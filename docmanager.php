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
 * xmdoc module
 *
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */
use Xmf\Request;
use Xmf\Module\Helper;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';
require_once $GLOBALS['xoops']->path('class/template.php');
$xoopsTpl = new XoopsTpl();

include __DIR__ . '/include/common.php';
xoops_load('utility', basename(__DIR__));
include_once $GLOBALS['xoops']->path('class/xoopsformloader.php');

// Get Permission to submit
$viewPermissionCat = XmdocUtility::getPermissionCat('xmdoc_view');

// Get values
$search = Request::getString('search', '');
$reset = Request::getString('reset', '');
$select = Request::getString('select', '');
$op = Request::getString('op', '');
$mod = Request::getString('mod', '');
$docitemid = Request::getInt('docitemid', 0);

$sessionHelper = new Helper\Session();

$bootstrap = XOOPS_THEME_PATH . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.css';
$bootstrap_min = XOOPS_THEME_PATH . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.min.css';

if (file_exists($bootstrap) || file_exists($bootstrap_min)){
	if (file_exists($bootstrap_min)){
		$xoopsTpl->assign('bootstrap_css', XOOPS_THEME_URL . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.min.css');
	} else {
		$xoopsTpl->assign('bootstrap_css', XOOPS_THEME_URL . '/' . $GLOBALS['xoopsConfig']['theme_set'] . '/css/bootstrap.css');
	}
	include_once XOOPS_ROOT_PATH . '/class/xoopsform/renderer/XoopsFormRendererBootstrap4.php';
	XoopsFormRenderer::getInstance()->set(new XoopsFormRendererBootstrap4());
} else{
	$xoopsTpl->assign('bootstrap_css', '');
}

if ($op == 'directadd'){
	if (isset($_REQUEST['valid'])){
		$error_message = XmdocUtility::saveDocuments($mod, $docitemid);
		if ($error_message != ''){
			$xoopsTpl->assign('error_message', $error_message);
			$op = 'add';
		} else {
			echo '<script type="text/javascript">
				window.opener.location.reload();
				window.close();
			</script>';
			exit();
		}
	}
	if (isset($_REQUEST['subselect'])){
		$sessionHelper->del('selectiondocs');
		$op = 'add';
	}
}
$xoopsTpl->assign('op', $op);
$xoopsTpl->assign('docitemid', $docitemid);
$xoopsTpl->assign('mod', $mod);

if (isset($_REQUEST['selectreset'])){
    $sessionHelper->del('selectiondocs');
}

if (isset($_REQUEST['selDocs'])){
	if (isset($_REQUEST['selDocs']) && is_array($_REQUEST['selDocs'])) {
		if ($sessionHelper->get('selectiondocs') != false){
			$arr_selectiondocs = $sessionHelper->get('selectiondocs');
		} else {
			$arr_selectiondocs = array();
		}
		foreach ($_REQUEST['selDocs'] as $index) {
			if (!in_array($index, $arr_selectiondocs)){
				$arr_selectiondocs[] = $index;
			}
		}
		$sessionHelper->set('selectiondocs', $arr_selectiondocs);
	}
}

if ($sessionHelper->get('selectiondocs') != False){
	$xoopsTpl->assign('selected', true);

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('document_status', 1));
    if (is_array($sessionHelper->get('selectiondocs'))){
        $criteria->add(new Criteria('document_id', '(' . implode(',', $sessionHelper->get('selectiondocs')) . ')','IN'));
    }
	$criteria->setSort('document_weight ASC, document_name');
	$criteria->setOrder('ASC');
	$documentHandler->table_link = $documentHandler->db->prefix("xmdoc_category");
	$documentHandler->field_link = "category_id";
	$documentHandler->field_object = "document_category";
	$seldoc_arr = $documentHandler->getByLink($criteria);
	$seldoc_count = $documentHandler->getCount($criteria);
	$xoopsTpl->assign('seldoc_count', $seldoc_count);
	if ($seldoc_count > 0) {
		$count = 1;
		foreach (array_keys($seldoc_arr) as $i) {
			$seldoc['name']            = $seldoc_arr[$i]->getVar('document_name');
			$seldoc_img                = $seldoc_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
			$seldoc['logo']            = '<img src="' . $url_logo_document .  $seldoc_img . '" alt="' . $seldoc_img . '" style="max-width:100px" />';
			$seldoc['count']           = $count;
			$xoopsTpl->appendByRef('seldocs', $seldoc);
			unset($seldoc);
			$count++;

		}
	} else {
		$xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NODOCUMENT);
	}
	$reset = '';
}

if ($reset == ''){
	$s_name = Request::getString('s_name', '');
	$s_cat = Request::getInt('s_cat', 0);
} else {
	$s_name = '';
	$s_cat = 0;
}
$helper = Helper::getHelper('xmdoc');
$nb_limit = $helper->getConfig('general_perpage', 15);

// Get start pager
$start = Request::getInt('start', 0);

$form = new XoopsThemeForm(_MA_XMDOC_SEARCH, 'form', 'docmanager.php', 'post', true);
// name
$form->addElement(new XoopsFormText(_MA_XMDOC_DOCUMENT_NAME, 's_name', 50, 255, $s_name));

// category
$category = new XoopsFormSelect(_MA_XMDOC_DOCUMENT_INCATEGORY, 's_cat', $s_cat);
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('category_status', 1));
$criteria->setSort('category_weight ASC, category_name');
$criteria->setOrder('ASC');
if (!empty($viewPermissionCat)){
	$criteria->add(new Criteria('category_id', '(' . implode(',', $viewPermissionCat) . ')','IN'));
}
$category_arr = $categoryHandler->getall($criteria);
if (count($category_arr) == 0 || empty($viewPermissionCat)){
	redirect_header(XOOPS_URL, 3, _MA_XMDOC_ERROR_NOACESSCATEGORY);
}
$category->addOption(0, _ALL);
foreach (array_keys($category_arr) as $i) {
	$category->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
}
$form->addElement($category, true);

// search
$button = new XoopsFormElementTray('');
$button->addElement(new XoopsFormButton('', 'search', _SEARCH, 'submit'));
$button->addElement(new XoopsFormButton('', 'reset', _RESET, 'submit'));
$form->addElement($button);

$form->addElement(new XoopsFormHidden('op', $op));
$form->addElement(new XoopsFormHidden('docitemid', $docitemid));
$form->addElement(new XoopsFormHidden('mod', $mod));

$xoopsTpl->assign('form', $form->render());

if ($search != ''){
	$arguments = 's_cat=' . $s_cat . '&amp;';
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('document_status', 1));
	if ($s_name != '') {
		$criteria->add(new Criteria('document_name', '%' . $s_name . '%', 'LIKE'));
		$arguments .= 's_name=' . $s_name . '&amp;';
	}
	if ($s_cat != 0){
		$criteria->add(new Criteria('document_category', $s_cat));
	}
	if (!empty($viewPermissionCat)){
		$criteria->add(new Criteria('document_category', '(' . implode(',', $viewPermissionCat) . ')','IN'));
	}
	$criteria->setSort('document_weight ASC, document_name');
	$criteria->setOrder('ASC');
	$criteria->setStart($start);
	$criteria->setLimit($nb_limit);

	$documentHandler->table_link = $documentHandler->db->prefix("xmdoc_category");
	$documentHandler->field_link = "category_id";
	$documentHandler->field_object = "document_category";
	$document_arr = $documentHandler->getByLink($criteria);
	$document_count = $documentHandler->getCount($criteria);
	$xoopsTpl->assign('document_count', $document_count);
	if ($document_count > 0) {
		foreach (array_keys($document_arr) as $i) {
			$document_id                 = $document_arr[$i]->getVar('document_id');
			$document['id']              = $document_id;
			$document['name']            = $document_arr[$i]->getVar('document_name');
			if (false == strpos($document_arr[$i]->getVar('document_description', 'e'), '[break]')){
				$document['description'] = $document_arr[$i]->getVar('document_description', 'show');
			}else{
				$document['description'] = substr($document_arr[$i]->getVar('document_description', 'show'), 0, strpos($document_arr[$i]->getVar('document_description', 'show'),'[break]'));
			}
			$document['category']        = $document_arr[$i]->getVar('category_name');
			$document['categoryid']      = $document_arr[$i]->getVar('document_category');
			$document_img                = $document_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
			$document['logo']            = '<img src="' . $url_logo_document .  $document_img . '" alt="' . $document_img . '" style="max-width:100px" />';
			$xoopsTpl->appendByRef('documents', $document);
			unset($document);
		}
		// Display Page Navigation
		if ($document_count > $nb_limit) {
			include_once $GLOBALS['xoops']->path('class/pagenav.php');
			$nav = new XoopsPageNav($document_count, $nb_limit, $start, 'start', 'search=Y&amp;' . $arguments);
			$xoopsTpl->assign('nav_menu', $nav->renderNav(4));
		}
	} else {
		$xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NODOCUMENT);
	}
}

$xoopsTpl->display('db:xmdoc_docmanager.tpl');
