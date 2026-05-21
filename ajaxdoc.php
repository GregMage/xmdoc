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
 * xmdoc module - AJAX endpoint for editing/saving a document inline.
 *
 * Returns either an HTML fragment (op=edit) or a JSON envelope (op=save).
 *
 * @copyright XOOPS Project (https://xoops.org)
 * @license   GNU GPL 2
 * @author    Mage Gregory (AKA Mage)
 */
use Xmf\Request;
use Xmf\Module\Helper;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
include __DIR__ . '/include/common.php';
xoops_load('utility', basename(__DIR__));
xoops_loadLanguage('main', 'xmdoc');
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

global $xoopsUser;
if (!is_object($xoopsUser)) {
    http_response_code(403);
    echo 'Not authenticated';
    exit;
}

$op          = Request::getCmd('op', '');
$document_id = Request::getInt('document_id', 0);
$permHelper  = new Helper\Permission('xmdoc');

if ($document_id <= 0) {
    http_response_code(400);
    echo 'Invalid document id';
    exit;
}

$doc = $documentHandler->get($document_id);
if (!is_object($doc) || $doc->isNew()) {
    http_response_code(404);
    echo 'Document not found';
    exit;
}

// Permission: must be able to edit/approve in the document's category
if (!$permHelper->checkPermission('xmdoc_editapprove', $doc->getVar('document_category'))) {
    http_response_code(403);
    echo 'Permission denied';
    exit;
}

switch ($op) {

    case 'edit':
        // Return form HTML fragment only (no XOOPS header/footer)
        header('Content-Type: text/html; charset=utf-8');
        $form = $doc->getForm(0, XOOPS_URL . '/modules/xmdoc/ajaxdoc.php');
        // Replace op=save behaviour: ajaxdoc.php infers it from URL
        echo $form->render();
        exit;

    case 'save':
        header('Content-Type: application/json; charset=utf-8');
        if (!$GLOBALS['xoopsSecurity']->check()) {
            echo json_encode(array('ok' => false, 'error' => implode(' ', $GLOBALS['xoopsSecurity']->getErrors())));
            exit;
        }
        // saveDocument expects document_id in the request; ensure it matches the loaded doc
        $_POST['document_id'] = $document_id;
        $result = $doc->saveDocument($documentHandler, false, true);
        if (!is_array($result)) {
            // Should not happen since we passed skipRedirect=true, but guard anyway
            echo json_encode(array('ok' => false, 'error' => (string)$result));
            exit;
        }
        if (!empty($result['inserted']) && $result['error_message'] === '') {
            echo json_encode(array('ok' => true), JSON_HEX_TAG | JSON_HEX_AMP);
            exit;
        }
        // Re-render the form with errors
        $doc2 = $documentHandler->get($document_id);
        if (!is_object($doc2) || $doc2->isNew()) { $doc2 = $doc; }
        $form = $doc2->getForm(0, XOOPS_URL . '/modules/xmdoc/ajaxdoc.php');
        echo json_encode(array(
            'ok'    => !empty($result['inserted']),
            'error' => $result['error_message'],
            'form'  => $form->render(),
        ), JSON_HEX_TAG | JSON_HEX_AMP);
        exit;

    default:
        http_response_code(400);
        echo 'Unknown operation';
        exit;
}
