<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * xmdoc module - inline AJAX document linking widget
 *
 * Renders an inline search-and-link widget that writes directly to xmdoc_docdata
 * through modules/xmdoc/ajax.php — no popup, no PHP session.
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
use Xmf\Module\Helper;

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * Inline AJAX document picker form element.
 */
class XmdocFormDoc extends XoopsFormElementTray
{
    /**
     * Constructor
     *
     * @param string $modulename name of the parent module (dirname)
     * @param int    $itemid     parent item id (0 = not yet saved)
     */
    public function __construct($modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
        xoops_loadLanguage('main', 'xmdoc');

        parent::__construct(_MA_XMDOC_FORMDOC_NAME, '<br>');

        // Inject CSS + JS only once
        global $xoTheme;
        if (is_object($xoTheme)) {
            $xoTheme->addScript(XOOPS_URL . '/modules/xmdoc/assets/js/xmdoc-docpicker.js', array('type' => 'text/javascript'));
            $xoTheme->addStylesheet(XOOPS_URL . '/modules/xmdoc/assets/css/styles.css');
        }

        $itemid     = (int)$itemid;
        $modulename = (string)$modulename;

        // Creation: itemid not known yet -> show a hint, no widget
        if ($itemid <= 0) {
            $msg = '<div class="alert alert-info mb-0">'
                 . '<span class="fa fa-info-circle"></span> '
                 . (defined('_MA_XMDOC_FORMDOC_SAVEFIRST')
                    ? _MA_XMDOC_FORMDOC_SAVEFIRST
                    : 'Les documents pourront être liés après la première sauvegarde.')
                 . '</div>';
            $this->addElement(new XoopsFormLabel('', $msg));
            return;
        }

        // Resolve target module id
        $modHelper = Helper::getHelper($modulename);
        if (false === $modHelper) {
            $this->addElement(new XoopsFormLabel('', '<div class="alert alert-danger">' . _MA_XMDOC_ERROR_NOMODULE . '</div>'));
            return;
        }
        $moduleid = (int)$modHelper->getModule()->getVar('mid');

        // Already-linked documents
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('docdata_modid', $moduleid));
        $criteria->add(new Criteria('docdata_itemid', $itemid));
        $criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');
        $docdataHandler->table_link  = $docdataHandler->db->prefix('xmdoc_document');
        $docdataHandler->field_link  = 'document_id';
        $docdataHandler->field_object = 'docdata_docid';
        $linked_arr = $docdataHandler->getByLink($criteria);

        // View-permission categories (for the category filter)
        $viewCats = XmdocUtility::getPermissionCat('xmdoc_view');
        $catOptions = '<option value="0">' . _MA_XMDOC_FORMDOC_SELECT . '</option>';
        if (!empty($viewCats)) {
            $catCrit = new CriteriaCompo();
            $catCrit->add(new Criteria('category_status', 1));
            $catCrit->add(new Criteria('category_id', '(' . implode(',', array_map('intval', $viewCats)) . ')', 'IN'));
            $catCrit->setSort('category_weight ASC, category_name');
            $catCrit->setOrder('ASC');
            $cats = $categoryHandler->getAll($catCrit);
            foreach ($cats as $cat) {
                $catOptions .= '<option value="' . (int)$cat->getVar('category_id') . '">'
                            . htmlspecialchars($cat->getVar('category_name'), ENT_QUOTES) . '</option>';
            }
        }

        // XOOPS security token
        $tokenName  = 'XOOPS_TOKEN_REQUEST';
        $tokenValue = $GLOBALS['xoopsSecurity']->createToken();

        $ajaxUrl     = XOOPS_URL . '/modules/xmdoc/ajax.php';
        $containerId = 'xmdoc-docpicker-' . htmlspecialchars($modulename, ENT_QUOTES) . '-' . $itemid;

        // Linked-list HTML
        $linkedHtml = '';
        if (count($linked_arr) > 0) {
            foreach ($linked_arr as $obj) {
                $docId     = (int)$obj->getVar('docdata_docid');
                $docdataId = (int)$obj->getVar('docdata_id');
                $name      = $obj->getVar('document_name');
                $ext       = strtolower(pathinfo($obj->getVar('document_document'), PATHINFO_EXTENSION));
                $iconClass = $this->_iconForExt($ext);
                $linkedHtml .= '<div class="xmdoc-linked-row d-flex justify-content-between align-items-center border-bottom py-1" data-doc-id="' . $docId . '" data-docdata-id="' . $docdataId . '">'
                            .  '<span><span class="fa ' . $iconClass . ' fa-fw text-muted"></span> '
                            .  '<strong>' . htmlspecialchars($name, ENT_QUOTES) . '</strong></span>'
                            .  '<button type="button" class="btn btn-sm btn-outline-danger xmdoc-unlink-btn" data-docdata-id="' . $docdataId . '">'
                            .  '<span class="fa fa-times"></span> ' . _MA_XMDOC_FORMDOC_UNLINK . '</button>'
                            .  '</div>';
            }
        }
        $emptyDisplay = $linkedHtml === '' ? '' : ' style="display:none;"';
        $linkedHtml = '<div class="xmdoc-linked-empty text-muted py-1"' . $emptyDisplay . '>'
                    . _MA_XMDOC_FORMDOC_NODOCSELECTED
                    . '</div>' . $linkedHtml;

        // Compose widget HTML
        $html  = '<div id="' . $containerId . '" class="xmdoc-docpicker card"';
        $html .=  ' data-ajax-url="' . htmlspecialchars($ajaxUrl, ENT_QUOTES) . '"';
        $html .=  ' data-token-name="' . htmlspecialchars($tokenName, ENT_QUOTES) . '"';
        $html .=  ' data-token="' . htmlspecialchars($tokenValue, ENT_QUOTES) . '"';
        $html .=  ' data-mod="' . htmlspecialchars($modulename, ENT_QUOTES) . '"';
        $html .=  ' data-item-id="' . $itemid . '"';
        $html .=  ' data-lbl-link="' . htmlspecialchars(_MA_XMDOC_FORMDOC_LINK, ENT_QUOTES) . '"';
        $html .=  ' data-lbl-unlink="' . htmlspecialchars(_MA_XMDOC_FORMDOC_UNLINK, ENT_QUOTES) . '"';
        $html .=  ' data-lbl-empty="' . htmlspecialchars(_MA_XMDOC_FORMDOC_NORESULT, ENT_QUOTES) . '"';
        $html .=  ' data-lbl-error="' . htmlspecialchars(_MA_XMDOC_FORMDOC_AJAXERROR, ENT_QUOTES) . '"';
        $html .=  ' data-lbl-confirm="' . htmlspecialchars(_MA_XMDOC_FORMDOC_CONFIRMUNLINK, ENT_QUOTES) . '"';
        $html .= '>';
        $html .= '  <div class="card-body p-2">';
        $html .= '    <div class="mb-2"><strong>' . _MA_XMDOC_FORMDOC_LINKED . '</strong></div>';
        $html .= '    <div class="xmdoc-linked mb-3">' . $linkedHtml . '</div>';
        $html .= '    <div class="mb-2"><strong>' . _MA_XMDOC_FORMDOC_SEARCH . '</strong></div>';
        $html .= '    <div class="row g-2 align-items-center mb-2">';
        $html .= '      <div class="col-md-6 mb-1"><input type="text" class="form-control form-control-sm xmdoc-search-q" placeholder="' . htmlspecialchars(_MA_XMDOC_FORMDOC_SEARCH_PLACEHOLDER, ENT_QUOTES) . '"></div>';
        $html .= '      <div class="col-md-4 mb-1"><select class="form-control form-control-sm xmdoc-search-cat">' . $catOptions . '</select></div>';
        $html .= '      <div class="col-md-2 mb-1"><button type="button" class="btn btn-sm btn-primary xmdoc-search-btn w-100"><span class="fa fa-search"></span></button></div>';
        $html .= '    </div>';
        $html .= '    <div class="xmdoc-results"></div>';
        $html .= '  </div>';
        $html .= '</div>';

        $this->addElement(new XoopsFormLabel('', $html));
    }

    /**
     * Map a file extension to a Font Awesome icon class.
     *
     * @param string $ext lowercased extension (without dot)
     * @return string
     */
    private function _iconForExt($ext)
    {
        $ext = strtolower($ext);
        if ($ext === 'pdf') return 'fa-file-pdf-o';
        if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'), true)) return 'fa-file-image-o';
        if (in_array($ext, array('doc', 'docx', 'odt', 'rtf'), true)) return 'fa-file-word-o';
        if (in_array($ext, array('xls', 'xlsx', 'ods', 'csv'), true)) return 'fa-file-excel-o';
        if (in_array($ext, array('ppt', 'pptx', 'odp'), true)) return 'fa-file-powerpoint-o';
        if (in_array($ext, array('zip', 'rar', '7z', 'tar', 'gz'), true)) return 'fa-file-archive-o';
        if (in_array($ext, array('mp4', 'avi', 'mkv', 'mov', 'webm'), true)) return 'fa-file-video-o';
        if (in_array($ext, array('mp3', 'wav', 'ogg', 'flac'), true)) return 'fa-file-audio-o';
        if (in_array($ext, array('txt', 'log', 'md'), true)) return 'fa-file-text-o';
        return 'fa-file-o';
    }
}
