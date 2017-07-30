<{if $xmdoc_viewdocs == true}>
    <{foreach item=document from=$document}>
        <div class="col-sm-4 col-md-4 xm-minibox">
            <div class="xm-document-logo">
                <{$document.logo}>
            </div>
            <a class="xm-document-title" title="<{$document.name}>" href="">
                <{$document.name}>
            </a>

            <div class="xm-document-description">
                <{$document.description_short}>
            </div>

            <a class="btn btn-primary btn-xs col-md-9" title="<{$document.name}>" href="">
                <{$smarty.const._MA_XMDOC_DOWNLOAD}>
            </a>
        </div>
    <{/foreach}>
<{/if}>
<!-- .xmdoc -->