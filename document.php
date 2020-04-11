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
 * xmnews module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

use \Xmf\Request;
use \Xmf\Metagen;

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmdoc_document.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

$doc_id  = Request::getInt('doc_id', 0);

if ($doc_id == 0) {
    redirect_header('index.php', 2, _MA_XMDOC_ERROR_NODOCUMENT);
}
$document  = $documentHandler->get($doc_id);
if (empty($document)) {
    redirect_header('index.php', 2, _MA_XMDOC_ERROR_NODOCUMENT);
}
$category_id = $document->getVar('document_category');

if ($category_id == 0) {
    redirect_header('index.php', 2, _MA_XMDOC_ERROR_NOCATEGORY);
}
$category = $categoryHandler->get($category_id);

if (empty($category)) {
    redirect_header('index.php', 2, _MA_XMDOC_ERROR_NOCATEGORY);
}

if ($permHelper->checkPermission('xmdoc_view', $category_id) === false){
	redirect_header('index.php', 2, _NOPERM);
}

// permission edit and approve submitted document
$permission_editapprove = $permHelper->checkPermission('xmdoc_editapprove', $category_id);

if ($permission_editapprove != true || $helper->isUserAdmin() != true){
	if ($category->getVar('category_status') == 0 || $document->getVar('document_status') != 1) {
		redirect_header('index.php', 2, _MA_XMDOC_ERROR_NACTIVE);
	}
}

//permission
$xoopsTpl->assign('perm_edit', $permHelper->checkPermission('xmdoc_editapprove', $category_id));
$xoopsTpl->assign('perm_del', $permHelper->checkPermission('xmdoc_delete', $category_id));

// Category
$xoopsTpl->assign('category_name', $category->getVar('category_name'));
$xoopsTpl->assign('category_id', $category_id);

// Document
$xoopsTpl->assign('index_module', $helper->getModule()->getVar('name'));
$xoopsTpl->assign('doc_id', $doc_id);
$xoopsTpl->assign('name', $document->getVar('document_name'));
$xoopsTpl->assign('document', $document->getVar('document_document'));
$xoopsTpl->assign('description', str_replace('[break]', '', $document->getVar('document_description', 'show')));
if (false == strpos($document->getVar('document_description', 'e'), '[break]')){
	$xoopsTpl->assign('description_short', '');
	$xoopsTpl->assign('description_end', '');
}else{
	$xoopsTpl->assign('description_short', substr($document->getVar('document_description', 'show'), 0, strpos($document->getVar('document_description', 'show'),'[break]')));
	$xoopsTpl->assign('description_end', str_replace('[break]', '', substr($document->getVar('document_description', 'show'), strpos($document->getVar('document_description', 'show'),'[break]'))));
}
$xoopsTpl->assign('size', XmdocUtility::SizeConvertString($document->getVar('document_size')));
$xoopsTpl->assign('author', XoopsUser::getUnameFromId($document->getVar('document_userid')));
$xoopsTpl->assign('date', formatTimestamp($document->getVar('document_date'), 's'));
if ($document->getVar('document_mdate') != 0) {
	$xoopsTpl->assign('mdate', formatTimestamp($document->getVar('document_mdate'), 's'));
}
$xoopsTpl->assign('counter', $document->getVar('document_counter'));
$xoopsTpl->assign('showinfo', $document->getVar('document_showinfo'));
$xoopsTpl->assign('counter', $document->getVar('document_counter'));
$document_img = $document->getVar('document_logo') ?: 'blank_doc.gif';
$xoopsTpl->assign('logo', $url_logo_document . $document_img);
$xoopsTpl->assign('status', $document->getVar('document_status'));

//xmsocial
if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
    xoops_load('utility', 'xmsocial');
	$options['mod'] = 'xmdoc_document';
	$options['id'] = $doc_id;
	$xmsocial_arr = XmsocialUtility::renderRating($xoTheme, 'xmdoc', $doc_id , 5, $document->getVar('document_rating'), $document->getVar('document_votes'), $options);
	$xoopsTpl->assign('xmsocial_arr', $xmsocial_arr);
	$xoopsTpl->assign('dorating', 1);
} else {
    $xoopsTpl->assign('dorating', 0);
}


//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', Metagen::generateSeoTitle($document->getVar('document_name') . '-' . $xoopsModule->name()));
//description
$xoTheme->addMeta('meta', 'description', Metagen::generateDescription($document->getVar('document_description'), 30));
//keywords

$keywords = Metagen::generateKeywords($document->getVar('document_description'), 10);    
$xoTheme->addMeta('meta', 'keywords', implode(', ', $keywords));

include XOOPS_ROOT_PATH . '/footer.php';
