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
 * xmdoc module - AJAX endpoint
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
use Xmf\Request;
use Xmf\Module\Helper;

ob_start();
require_once dirname(dirname(__DIR__)) . '/mainfile.php';
include __DIR__ . '/include/common.php';
xoops_load('utility', basename(__DIR__));
xoops_loadLanguage('main', 'xmdoc');

/**
 * Output JSON and exit — always HTTP 200 to prevent server error-page substitution.
 * Cleans any buffered output (PHP notices, XOOPS logger snippets, etc.) first.
 */
function xmdoc_ajax_json($data)
{
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    header('Content-Type: application/json; charset=utf-8');
    header('X-Content-Type-Options: nosniff');
    echo json_encode($data, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    exit;
}

/**
 * Compute filetype from filename/url
 */
function xmdoc_filetype($filename)
{
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    if ($ext === 'pdf') return 'pdf';
    if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'), true)) return 'image';
    if (in_array($ext, array('doc', 'docx', 'odt', 'rtf'), true)) return 'word';
    if (in_array($ext, array('xls', 'xlsx', 'ods', 'csv'), true)) return 'excel';
    if (in_array($ext, array('ppt', 'pptx', 'odp'), true)) return 'powerpoint';
    if (in_array($ext, array('zip', 'rar', '7z', 'tar', 'gz'), true)) return 'archive';
    if (in_array($ext, array('mp4', 'avi', 'mkv', 'mov', 'webm'), true)) return 'video';
    if (in_array($ext, array('mp3', 'wav', 'ogg', 'flac'), true)) return 'audio';
    if (in_array($ext, array('txt', 'log', 'md'), true)) return 'text';
    return 'other';
}

// User must be logged in for any operation
global $xoopsUser;
if (!is_object($xoopsUser)) {
    xmdoc_ajax_json(array('ok' => false, 'error' => 'Not authenticated'));
}

$op = Request::getCmd('op', '');

switch ($op) {

    // ---------------------------------------------------------------------
    // SEARCH: GET op=search&q=...&cat=...&start=...&limit=...
    // ---------------------------------------------------------------------
    case 'search':
        $viewPermissionCat = XmdocUtility::getPermissionCat('xmdoc_view');
        if (empty($viewPermissionCat)) {
            xmdoc_ajax_json(array('ok' => true, 'docs' => array(), 'total' => 0));
        }

        $q     = trim(Request::getString('q', ''));
        $cat   = Request::getInt('cat', 0);
        $start = Request::getInt('start', 0);
        $limit = Request::getInt('limit', 20);
        if ($limit < 1 || $limit > 100) { $limit = 20; }

        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('document_status', 1));
        $criteria->add(new Criteria('document_category', '(' . implode(',', array_map('intval', $viewPermissionCat)) . ')', 'IN'));
        if ($cat > 0 && in_array($cat, $viewPermissionCat)) {
            $criteria->add(new Criteria('document_category', $cat));
        }
        if ($q !== '') {
            $qLike = '%' . $q . '%';
            $sub = new CriteriaCompo();
            $sub->add(new Criteria('document_name', $qLike, 'LIKE'));
            $sub->add(new Criteria('document_description', $qLike, 'LIKE'), 'OR');
            $criteria->add($sub);
        }
        $criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');

        $total = $documentHandler->getCount($criteria);
        $criteria->setStart($start);
        $criteria->setLimit($limit);

        $documentHandler->table_link  = $documentHandler->db->prefix('xmdoc_category');
        $documentHandler->field_link  = 'category_id';
        $documentHandler->field_object = 'document_category';
        $document_arr = $documentHandler->getByLink($criteria);

        $docs = array();
        foreach ($document_arr as $doc) {
            $docFile = $doc->getVar('document_document');
            $logo    = $doc->getVar('document_logo');
            $docs[] = array(
                'id'         => (int)$doc->getVar('document_id'),
                'name'       => $doc->getVar('document_name'),
                'category'   => $doc->getVar('category_name'),
                'categoryid' => (int)$doc->getVar('document_category'),
                'size'       => XmdocUtility::SizeConvertString($doc->getVar('document_size')),
                'date'       => formatTimestamp($doc->getVar('document_date'), 's'),
                'filetype'   => xmdoc_filetype($docFile),
                'extension'  => strtolower(pathinfo($docFile, PATHINFO_EXTENSION)),
                'logo'       => $logo ? $url_logo_document . $logo : '',
            );
        }
        xmdoc_ajax_json(array('ok' => true, 'docs' => $docs, 'total' => (int)$total, 'start' => $start, 'limit' => $limit));
        break;

    // ---------------------------------------------------------------------
    // LINK: POST op=link doc_id, mod, item_id, XOOPS_TOKEN_REQUEST
    // ---------------------------------------------------------------------
    case 'link':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Invalid token'));
        }
        $doc_id  = Request::getInt('doc_id', 0, 'POST');
        $modname = Request::getString('mod', '', 'POST');
        $item_id = Request::getInt('item_id', 0, 'POST');
        if ($doc_id <= 0 || $modname === '' || $item_id <= 0) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Invalid parameters (doc_id=' . $doc_id . ' mod=' . $modname . ' item_id=' . $item_id . ')'));
        }

        $doc = $documentHandler->get($doc_id);
        if (!is_object($doc)) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Document not found'));
        }
        // Check user has VIEW permission on the document's category (linking only requires viewing)
        $viewPermForLink = XmdocUtility::getPermissionCat('xmdoc_view');
        if (!in_array((int)$doc->getVar('document_category'), array_map('intval', $viewPermForLink))) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Permission denied'));
        }

        $modHelper = Helper::getHelper($modname);
        $modObj    = $modHelper->getModule();
        if (!is_object($modObj)) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Unknown module: ' . $modname));
        }
        $moduleid = (int)$modObj->getVar('mid');

        // Check if relation already exists
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('docdata_docid', $doc_id));
        $criteria->add(new Criteria('docdata_modid', $moduleid));
        $criteria->add(new Criteria('docdata_itemid', $item_id));
        if ($docdataHandler->getCount($criteria) > 0) {
            xmdoc_ajax_json(array('ok' => false, 'error' => defined('_MA_XMDOC_ERROR_EXIST') ? _MA_XMDOC_ERROR_EXIST : 'Already linked'));
        }

        $obj = $docdataHandler->create();
        $obj->setVar('docdata_docid', $doc_id);
        $obj->setVar('docdata_modid', $moduleid);
        $obj->setVar('docdata_itemid', $item_id);
        if (!$docdataHandler->insert($obj)) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Insert failed'));
        }
        xmdoc_ajax_json(array(
            'ok'         => true,
            'docdata_id' => (int)$obj->getVar('docdata_id'),
            'doc'        => array(
                'id'         => $doc_id,
                'name'       => $doc->getVar('document_name'),
                'categoryid' => (int)$doc->getVar('document_category'),
                'filetype'   => xmdoc_filetype($doc->getVar('document_document')),
                'extension'  => strtolower(pathinfo($doc->getVar('document_document'), PATHINFO_EXTENSION)),
                'size'       => XmdocUtility::SizeConvertString($doc->getVar('document_size')),
            ),
        ));
        break;

    // ---------------------------------------------------------------------
    // UNLINK: POST op=unlink docdata_id, mod, item_id, XOOPS_TOKEN_REQUEST
    // ---------------------------------------------------------------------
    case 'unlink':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Invalid token'));
        }
        $docdata_id = Request::getInt('docdata_id', 0, 'POST');
        $modname    = Request::getString('mod', '', 'POST');
        $item_id    = Request::getInt('item_id', 0, 'POST');
        if ($docdata_id <= 0 || $modname === '' || $item_id <= 0) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Invalid parameters'));
        }
        $obj = $docdataHandler->get($docdata_id);
        if (!is_object($obj)) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Not found'));
        }
        $modHelper = Helper::getHelper($modname);
        $modObj    = $modHelper->getModule();
        if (!is_object($modObj)) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Unknown module: ' . $modname));
        }
        $moduleid = (int)$modObj->getVar('mid');
        // Ownership check: docdata must belong to the (mod, item) the client claims
        if ((int)$obj->getVar('docdata_modid') !== $moduleid || (int)$obj->getVar('docdata_itemid') !== $item_id) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Ownership mismatch'));
        }
        // View permission on the linked document's category
        $doc = $documentHandler->get($obj->getVar('docdata_docid'));
        if (is_object($doc)) {
            $viewPermForUnlink = XmdocUtility::getPermissionCat('xmdoc_view');
            if (!in_array((int)$doc->getVar('document_category'), array_map('intval', $viewPermForUnlink))) {
                xmdoc_ajax_json(array('ok' => false, 'error' => 'Permission denied'));
            }
        }
        if (!$docdataHandler->delete($obj)) {
            xmdoc_ajax_json(array('ok' => false, 'error' => 'Delete failed'));
        }
        xmdoc_ajax_json(array('ok' => true));
        break;

    default:
        xmdoc_ajax_json(array('ok' => false, 'error' => 'Unknown operation'));
}
