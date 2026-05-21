/**
 * xmdoc - Document picker widget (AJAX)
 *
 * Replaces the legacy openWithSelfMain() popup based on PHP sessions.
 * Reads its configuration from data-* attributes on a container element.
 *
 * Required attributes on container:
 *   data-ajax-url   URL to xmdoc/ajax.php
 *   data-token-name name of the XOOPS token field
 *   data-token      XOOPS token value
 *   data-mod        target module dirname (e.g. "xmarticle")
 *   data-item-id    target item id (>0)
 *
 * Required child elements (selected within the container):
 *   .xmdoc-search-q       <input> search query
 *   .xmdoc-search-cat     <select> category filter (optional)
 *   .xmdoc-search-btn     <button> trigger search
 *   .xmdoc-results        <div>  search results destination
 *   .xmdoc-linked         <tbody|ul|div> list of currently linked docs
 *
 * @author Mage Gregory (AKA Mage)
 */
(function (global) {
    'use strict';

    var ICONS = {
        pdf:        'fa-file-pdf-o',
        image:      'fa-file-image-o',
        word:       'fa-file-word-o',
        excel:      'fa-file-excel-o',
        powerpoint: 'fa-file-powerpoint-o',
        archive:    'fa-file-archive-o',
        video:      'fa-file-video-o',
        audio:      'fa-file-audio-o',
        text:       'fa-file-text-o',
        other:      'fa-file-o'
    };

    function iconFor(filetype) {
        return ICONS[filetype] || ICONS.other;
    }

    function escapeHtml(s) {
        if (s === null || typeof s === 'undefined') return '';
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#39;');
    }

    function XmdocDocPicker(container) {
        this.el        = container;
        this.ajaxUrl   = container.getAttribute('data-ajax-url');
        this.tokenName = container.getAttribute('data-token-name');
        this.token     = container.getAttribute('data-token');
        this.mod       = container.getAttribute('data-mod');
        this.itemId    = parseInt(container.getAttribute('data-item-id'), 10) || 0;
        this.reloadOnChange = container.getAttribute('data-reload-on-change') === '1';
        this.lblLink   = container.getAttribute('data-lbl-link')   || 'Lier';
        this.lblUnlink = container.getAttribute('data-lbl-unlink') || 'Délier';
        this.lblEmpty  = container.getAttribute('data-lbl-empty')  || 'Aucun résultat';
        this.lblError  = container.getAttribute('data-lbl-error') || 'Erreur';
        this.lblConfirmRemove = container.getAttribute('data-lbl-confirm') || 'Délier ce document ?';

        this.qInput   = container.querySelector('.xmdoc-search-q');
        this.catSel   = container.querySelector('.xmdoc-search-cat');
        this.btn      = container.querySelector('.xmdoc-search-btn');
        this.results  = container.querySelector('.xmdoc-results');
        this.linked   = container.querySelector('.xmdoc-linked');

        this._debounce = null;
        this._bind();
    }

    XmdocDocPicker.prototype._bind = function () {
        var self = this;
        if (this.btn) {
            this.btn.addEventListener('click', function (e) {
                e.preventDefault();
                self.search();
            });
        }
        if (this.qInput) {
            this.qInput.addEventListener('input', function () {
                clearTimeout(self._debounce);
                self._debounce = setTimeout(function () { self.search(); }, 300);
            });
            this.qInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    clearTimeout(self._debounce);
                    self.search();
                }
            });
        }
        if (this.catSel) {
            this.catSel.addEventListener('change', function () { self.search(); });
        }
        // Delegate clicks on results (Link) and linked list (Unlink)
        if (this.results) {
            this.results.addEventListener('click', function (e) {
                var btn = e.target.closest('.xmdoc-link-btn');
                if (!btn) return;
                e.preventDefault();
                var docId = parseInt(btn.getAttribute('data-doc-id'), 10);
                if (docId > 0) self.linkDoc(docId, btn);
            });
        }
        if (this.linked) {
            this.linked.addEventListener('click', function (e) {
                var btn = e.target.closest('.xmdoc-unlink-btn');
                if (!btn) return;
                e.preventDefault();
                if (!window.confirm(self.lblConfirmRemove)) return;
                var ddId = parseInt(btn.getAttribute('data-docdata-id'), 10);
                if (ddId > 0) self.unlinkDoc(ddId, btn);
            });
        }
    };

    XmdocDocPicker.prototype._fetch = function (params, method) {
        var url = this.ajaxUrl;
        var opts = { method: method || 'GET', credentials: 'same-origin' };
        if (opts.method === 'GET') {
            var qs = new URLSearchParams(params).toString();
            url += (url.indexOf('?') === -1 ? '?' : '&') + qs;
        } else {
            var body = new URLSearchParams();
            Object.keys(params).forEach(function (k) { body.append(k, params[k]); });
            // XOOPS token
            if (this.tokenName && this.token) body.append(this.tokenName, this.token);
            opts.body = body;
            opts.headers = { 'X-Requested-With': 'XMLHttpRequest' };
        }
        return fetch(url, opts).then(function (r) { return r.json(); });
    };

    XmdocDocPicker.prototype.search = function () {
        var self = this;
        if (!this.results) return;
        var params = {
            op:    'search',
            q:     this.qInput ? this.qInput.value : '',
            cat:   this.catSel ? this.catSel.value : 0,
            mod:   this.mod,
            start: 0
        };
        this.results.innerHTML = '<div class="text-muted p-2"><span class="fa fa-spinner fa-spin"></span></div>';
        this._fetch(params, 'GET')
            .then(function (data) { self._renderResults(data); })
            .catch(function () { self.results.innerHTML = '<div class="alert alert-danger">' + escapeHtml(self.lblError) + '</div>'; });
    };

    XmdocDocPicker.prototype._renderResults = function (data) {
        if (!data || !data.ok) {
            this.results.innerHTML = '<div class="alert alert-warning">' + escapeHtml((data && data.error) || this.lblError) + '</div>';
            return;
        }
        if (!data.docs || data.docs.length === 0) {
            this.results.innerHTML = '<div class="text-muted p-2">' + escapeHtml(this.lblEmpty) + '</div>';
            return;
        }
        var linkedIds = this._linkedDocIds();
        var html = '<ul class="list-group list-group-flush">';
        for (var i = 0; i < data.docs.length; i++) {
            var d = data.docs[i];
            var already = linkedIds.indexOf(d.id) !== -1;
            html += '<li class="list-group-item d-flex justify-content-between align-items-center py-1">'
                +   '<span><span class="fa ' + iconFor(d.filetype) + ' fa-fw text-muted" aria-hidden="true"></span> '
                +     '<strong>' + escapeHtml(d.name) + '</strong> '
                +     '<small class="text-muted">' + escapeHtml(d.category) + (d.size ? ' &middot; ' + escapeHtml(d.size) : '') + '</small>'
                +   '</span>'
                +   (already
                        ? '<span class="badge badge-success"><span class="fa fa-check"></span></span>'
                        : '<button type="button" class="btn btn-sm btn-outline-primary xmdoc-link-btn" data-doc-id="' + d.id + '">'
                          + '<span class="fa fa-link"></span> ' + escapeHtml(this.lblLink) + '</button>')
                + '</li>';
        }
        html += '</ul>';
        this.results.innerHTML = html;
    };

    XmdocDocPicker.prototype._linkedDocIds = function () {
        var ids = [];
        if (!this.linked) return ids;
        var nodes = this.linked.querySelectorAll('[data-doc-id]');
        for (var i = 0; i < nodes.length; i++) {
            ids.push(parseInt(nodes[i].getAttribute('data-doc-id'), 10));
        }
        return ids;
    };

    XmdocDocPicker.prototype.linkDoc = function (docId, btnEl) {
        var self = this;
        if (btnEl) { btnEl.disabled = true; btnEl.innerHTML = '<span class="fa fa-spinner fa-spin"></span>'; }
        this._fetch({ op: 'link', doc_id: docId, mod: this.mod, item_id: this.itemId }, 'POST')
            .then(function (data) {
                if (!data || !data.ok) {
                    window.alert((data && data.error) || self.lblError);
                    if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<span class="fa fa-link"></span> ' + escapeHtml(self.lblLink); }
                    return;
                }
                if (self.reloadOnChange) { window.location.reload(); return; }
                self._appendLinked(data.docdata_id, data.doc);
                if (btnEl) {
                    btnEl.outerHTML = '<span class="badge badge-success"><span class="fa fa-check"></span></span>';
                }
            })
            .catch(function () {
                window.alert(self.lblError);
                if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<span class="fa fa-link"></span> ' + escapeHtml(self.lblLink); }
            });
    };

    XmdocDocPicker.prototype._appendLinked = function (docdataId, doc) {
        if (!this.linked || !doc) return;
        var row = document.createElement('div');
        row.className = 'xmdoc-linked-row d-flex justify-content-between align-items-center border-bottom py-1';
        row.setAttribute('data-doc-id', doc.id);
        row.setAttribute('data-docdata-id', docdataId);
        row.innerHTML =
            '<span><span class="fa ' + iconFor(doc.filetype) + ' fa-fw text-muted"></span> '
            + '<strong>' + escapeHtml(doc.name) + '</strong>'
            + (doc.size ? ' <small class="text-muted">' + escapeHtml(doc.size) + '</small>' : '')
            + '</span>'
            + '<button type="button" class="btn btn-sm btn-outline-danger xmdoc-unlink-btn" data-docdata-id="' + docdataId + '">'
            + '<span class="fa fa-times"></span> ' + escapeHtml(this.lblUnlink) + '</button>';
        this.linked.appendChild(row);
        var empty = this.linked.querySelector('.xmdoc-linked-empty');
        if (empty) empty.style.display = 'none';
    };

    XmdocDocPicker.prototype.unlinkDoc = function (docdataId, btnEl) {
        var self = this;
        if (btnEl) { btnEl.disabled = true; btnEl.innerHTML = '<span class="fa fa-spinner fa-spin"></span>'; }
        this._fetch({ op: 'unlink', docdata_id: docdataId, mod: this.mod, item_id: this.itemId }, 'POST')
            .then(function (data) {
                if (!data || !data.ok) {
                    window.alert((data && data.error) || self.lblError);
                    if (btnEl) { btnEl.disabled = false; btnEl.innerHTML = '<span class="fa fa-times"></span> ' + escapeHtml(self.lblUnlink); }
                    return;
                }
                if (self.reloadOnChange) { window.location.reload(); return; }
                var row = btnEl ? btnEl.closest('[data-docdata-id]') : null;
                if (row && row.parentNode) row.parentNode.removeChild(row);
                if (self.linked && self.linked.querySelectorAll('[data-docdata-id]').length === 0) {
                    var empty = self.linked.querySelector('.xmdoc-linked-empty');
                    if (empty) empty.style.display = '';
                }
                // Refresh results to re-enable the "Lier" button on this doc
                self.search();
            })
            .catch(function () { window.alert(self.lblError); });
    };

    // Auto-init any picker on the page
    function autoInit() {
        var nodes = document.querySelectorAll('.xmdoc-docpicker');
        for (var i = 0; i < nodes.length; i++) {
            if (!nodes[i].__xmdocPicker) {
                nodes[i].__xmdocPicker = new XmdocDocPicker(nodes[i]);
            }
        }
        bindEditButtons();
    }

    // -----------------------------------------------------------------------
    // Edit document in shared modal #xmdocEditModal — AJAX form load + submit
    // -----------------------------------------------------------------------
    function bindEditButtons() {
        if (document.body.__xmdocEditBound) return;
        document.body.__xmdocEditBound = true;
        document.body.addEventListener('click', function (e) {
            var btn = e.target.closest('.xmdoc-edit-doc-btn');
            if (!btn) return;
            // do not preventDefault — Bootstrap's data-toggle will open the modal
            var docId       = parseInt(btn.getAttribute('data-doc-id'), 10);
            var ajaxdocUrl  = btn.getAttribute('data-ajaxdoc-url');
            var tokenName   = btn.getAttribute('data-token-name');
            var token       = btn.getAttribute('data-token');
            if (!docId || !ajaxdocUrl) return;
            loadEditForm(docId, ajaxdocUrl, tokenName, token);
        });
    }

    function getEditModalParts() {
        var modal = document.getElementById('xmdocEditModal');
        if (!modal) return null;
        return {
            modal:    modal,
            loading:  modal.querySelector('.xmdoc-edit-loading'),
            container: modal.querySelector('.xmdoc-edit-form-container'),
            error:    modal.querySelector('.xmdoc-edit-error')
        };
    }

    function loadEditForm(docId, ajaxdocUrl, tokenName, token) {
        var parts = getEditModalParts();
        if (!parts) return;
        parts.loading.style.display = '';
        parts.container.innerHTML = '';
        parts.error.style.display = 'none';
        parts.error.textContent = '';
        var url = ajaxdocUrl + (ajaxdocUrl.indexOf('?') === -1 ? '?' : '&') + 'op=edit&document_id=' + docId;
        fetch(url, { credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) {
                if (!r.ok) throw new Error('HTTP ' + r.status);
                return r.text();
            })
            .then(function (html) {
                parts.loading.style.display = 'none';
                parts.container.innerHTML = html;
                wireEditForm(parts.container, ajaxdocUrl, tokenName, token, parts);
            })
            .catch(function (err) {
                parts.loading.style.display = 'none';
                parts.error.style.display = '';
                parts.error.textContent = String(err && err.message ? err.message : err);
            });
    }

    function wireEditForm(container, ajaxdocUrl, tokenName, token, parts) {
        var form = container.querySelector('form');
        if (!form) return;
        // Hijack submit
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            parts.error.style.display = 'none';
            var fd = new FormData(form);
            fd.append('op', 'save');
            if (tokenName && token) fd.append(tokenName, token);
            var submitUrl = ajaxdocUrl + (ajaxdocUrl.indexOf('?') === -1 ? '?' : '&') + 'op=save&document_id=' + encodeURIComponent(fd.get('document_id') || '');
            fetch(submitUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                body: fd
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data && data.ok) {
                    window.location.reload();
                    return;
                }
                if (data && data.form) {
                    parts.container.innerHTML = data.form;
                    wireEditForm(parts.container, ajaxdocUrl, tokenName, token, parts);
                }
                if (data && data.error) {
                    parts.error.style.display = '';
                    parts.error.innerHTML = data.error;
                }
            })
            .catch(function (err) {
                parts.error.style.display = '';
                parts.error.textContent = String(err && err.message ? err.message : err);
            });
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', autoInit);
    } else {
        autoInit();
    }

    global.XmdocDocPicker = XmdocDocPicker;
})(window);
