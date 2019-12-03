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

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmdoc_action.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);



$op = Request::getCmd('op', '');
// Get start pager
$start = Request::getInt('start', 0);

if ($op == 'add' || $op == 'save' || $op == 'loaddocument' || $op == 'edit' || $op == 'del') {
    switch ($op) {
        // Add
        case 'add':
			// Get Permission to submit
			$submitPermissionCat = XmdocUtility::getPermissionCat('xmdoc_submit');
			if (empty($submitPermissionCat)){
				redirect_header('index.php', 2, _NOPERM);
			}	
			$criteria = new CriteriaCompo();
			$criteria->add(new Criteria('category_status', 1));
			$criteria->setSort('category_weight ASC, category_name');
			$criteria->setStart($start);
			$criteria->setLimit($nb_limit);
			$criteria->setOrder('ASC');
			if (!empty($submitPermissionCat)){
				$criteria->add(new Criteria('category_id', '(' . implode(',', $submitPermissionCat) . ')','IN'));
			}
			$category_arr   = $categoryHandler->getall($criteria);
			$category_count = $categoryHandler->getCount($criteria);
			$xoopsTpl->assign('category_count', $category_count);
			if ($category_count > 0 && !empty($submitPermissionCat)) {
				foreach (array_keys($category_arr) as $i) {
					$category_id              = $category_arr[$i]->getVar('category_id');
					$category['id']           = $category_id;
					$category['name']         = $category_arr[$i]->getVar('category_name');
					$category['description']  = $category_arr[$i]->getVar('category_description', 'show');
					$category_img             = $category_arr[$i]->getVar('category_logo') ?: 'blank.gif';
					$category['logo']         = $url_logo_category . $category_img;
					$xoopsTpl->append_by_ref('categories', $category);
					unset($category);
				}
				// Display Page Navigation
				if ($category_count > $nb_limit) {
					$nav = new XoopsPageNav($category_count, $nb_limit, $start, 'start');
					$xoopsTpl->assign('nav_menu', $nav->renderNav(4));
				}
			} else {
				$xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NOCATEGORY);
			}
            break;
		// Loaddocument
        case 'loaddocument':
			$category_id = Request::getInt('category_id', 0);		
			if ($category_id == 0) {
				$xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NOCATEGORY);
			} else {
				// Get Permission to submit in category
				$permHelper->checkPermissionRedirect('xmdoc_submit', $category_id, 'action.php?op=add', 2, _NOPERM);
				$category = $categoryHandler->get($category_id);
				$xoopsTpl->assign('tips', true);
				$xoopsTpl->assign('extensions', implode(', ', $category->getVar('category_extensions')));
				$xoopsTpl->assign('size', XmdocUtility::SizeConvertString($category->getVar('category_size')));
				$obj  = $documentHandler->create();
				$form = $obj->getForm($category_id);
				$xoopsTpl->assign('form', $form->render());
			}
            break;

        // Save
        case 'save':
			$category_id = Request::getInt('category_id', 0);
			// Get Permission to submit in category
			$permHelper->checkPermissionRedirect('xmdoc_submit', $category_id, 'index.php', 2, _NOPERM);
			if (!$GLOBALS['xoopsSecurity']->check()) {
				redirect_header(XOOPS_URL, 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
			}
			$document_id = Request::getInt('document_id', 0);
			if ($document_id == 0) {
				$obj = $documentHandler->create();            
			} else {
				$obj = $documentHandler->get($document_id);
			}
			$error_message = $obj->saveDocument($documentHandler, 'action.php?op=add');
			if ($error_message != ''){
				$xoopsTpl->assign('error_message', $error_message);
				$document_category = Request::getInt('document_category', 0);
				$form = $obj->getForm($document_category);
				$xoopsTpl->assign('form', $form->render());
			}			
			break;
			
		// Edit
        case 'edit':
			// Form
			$document_id = Request::getInt('document_id', 0);
			if ($document_id == 0) {
				$xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NODOCUMENT);
			} else {
				$obj = $documentHandler->get($document_id);
				// Get Permission to edit in category
				$permHelper->checkPermissionRedirect('xmdoc_editapprove', $obj->getVar('document_category'), 'index.php', 2, _NOPERM);
				$form = $obj->getForm();
				$xoopsTpl->assign('form', $form->render()); 
			}
            break;

		// del
		case 'del':
			$document_id = Request::getInt('document_id', 0);
			if ($document_id == 0) {
				$xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NODOCUMENT);
			} else {
				$surdel = Request::getBool('surdel', false);
				$obj  = $documentHandler->get($document_id);
				// Get Permission to delete in category
				$permHelper->checkPermissionRedirect('xmdoc_delete', $obj->getVar('document_category'), 'index.php', 2, _NOPERM);	
				if ($surdel === true) {
					if (!$GLOBALS['xoopsSecurity']->check()) {
						redirect_header(XOOPS_URL, 3, implode('<br>', $GLOBALS['xoopsSecurity']->getErrors()));
					}
					$error_message = $obj->delDocument($documentHandler, 'index.php');
					if ($error_message != ''){
						$xoopsTpl->assign('error_message', $error_message);
					}
				} else {
					$document_img = $obj->getVar('document_logo') ?: 'blank.gif';
					xoops_confirm(array('surdel' => true, 'document_id' => $document_id, 'op' => 'del'), $_SERVER['REQUEST_URI'], 
										sprintf(_MA_XMDOC_DOCUMENT_SUREDEL, $obj->getVar('document_name')) . '<br>
										<img src="' . $url_logo_document . $document_img . '" title="' . 
										$obj->getVar('document_name') . '" /><br>');
				}
			}        
			break;
    }
} else {
    redirect_header(XOOPS_URL, 2, _NOPERM);
}
include XOOPS_ROOT_PATH . '/footer.php';
