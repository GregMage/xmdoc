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
use Xmf\Module\Admin;
use Xmf\Request;
use Xmf\Metagen;


require __DIR__ . '/admin_header.php';
$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('document.php');

// Get Action type
$op = Request::getCmd('op', 'list');
switch ($op) {
    case 'list':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addStylesheet( XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/admin.css', null );
        $xoTheme->addScript('modules/system/js/admin.js');
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMDOC_DOCUMENT_ADD, 'document.php?op=add', 'add');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());
		$xoopsTpl->assign('usemodal', $helper->getConfig('general_usemodal', 1));
        // Get start pager
        $start = Request::getInt('start', 0);
        $xoopsTpl->assign('start', $start);

		if ($helper->getConfig('general_usemodal', 1) == 1){
			$xoopsTpl->assign('modal', false);
		} else {
			$xoopsTpl->assign('modal', true);
		}

        $xoopsTpl->assign('filter', true);
        // Category
		$category = Request::getInt('category', 0);
        $xoopsTpl->assign('category', $category);
		$criteria = new CriteriaCompo();
		$criteria->setSort('category_weight ASC, category_name');
		$criteria->setOrder('ASC');
		$category_arr = $categoryHandler->getall($criteria);
		if (count($category_arr) > 0) {
			$category_options = '<option value="0"' . ($category == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
			foreach (array_keys($category_arr) as $i) {
				$category_options .= '<option value="' . $i . '"' . ($category == $i ? ' selected="selected"' : '') . '>' . $category_arr[$i]->getVar('category_name') . '</option>';
			}
			$xoopsTpl->assign('category_options', $category_options);
		}
        // Status
        $status = Request::getInt('status', 10);
        $xoopsTpl->assign('status', $status);
        $status_options_arr = array(1 => _MA_XMDOC_STATUS_A, 0 =>_MA_XMDOC_STATUS_NA, 2 => _MA_XMDOC_DOCUMENT_WFV);
		$status_options = '<option value="10"' . ($status == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
        foreach (array_keys($status_options_arr) as $i) {
            $status_options .= '<option value="' . $i . '"' . ($status == $i ? ' selected="selected"' : '') . '>' . $status_options_arr[$i] . '</option>';
        }
        $xoopsTpl->assign('status_options', $status_options);

        // Waiting document
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('document_status', 2));
        $Waiting_document = $documentHandler->getCount($criteria);
        if ($Waiting_document > 0){
            $xoopsTpl->assign('warning_message', sprintf(_MA_XMDOC_DOCUMENT_WAITING, $Waiting_document));
        }

        // Criteria
        $criteria = new CriteriaCompo();
        $criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($nb_limit);
        if ($category != 0){
			$criteria->add(new Criteria('document_category', $category));
		}
        if ($status != 10){
			$criteria->add(new Criteria('document_status', $status));
		}
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
                $document['category']        = $document_arr[$i]->getVar('category_name');
                $document['categoryid']      = $document_arr[$i]->getVar('document_category');
                $document['document']        = $document_arr[$i]->getVar('document_document');
                $description                 = XmdocUtility::TagSafe($document_arr[$i]->getVar('document_description', 'e'));
				if (false == strpos($description, '[break]')){
					$document['description'] = XmdocUtility::generateDescriptionTagSafe($description, 50);
				}else{
					$document['description'] = substr($description, 0, strpos($description,'[break]'));
				}
                $document['counter']         = $document_arr[$i]->getVar('document_counter');
                $document['showinfo']        = $document_arr[$i]->getVar('document_showinfo');
                $document['weight']          = $document_arr[$i]->getVar('document_weight');
                $document['status']          = $document_arr[$i]->getVar('document_status');
                $document_img                = $document_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
                $document['logo']            = $url_logo_document .  $document_img;
                $xoopsTpl->appendByRef('document', $document);
                unset($document);
            }
            // Display Page Navigation
            if ($document_count > $nb_limit) {
                $nav = new XoopsPageNav($document_count, $nb_limit, $start, 'start', 'category=' . $category . '&status=' . $status);
                $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
            }
        } else {
            $xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NODOCUMENT);
        }
        break;

    // Add
    case 'add':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMDOC_DOCUMENT_LIST, 'document.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('category_status', 1));
        $category_count = $categoryHandler->getCount($criteria);
        if ($category_count > 0) {
            // Form
            $obj  = $documentHandler->create();
            $form = $obj->getFormCategory();
            $xoopsTpl->assign('form', $form->render());
        } else {
            redirect_header('category.php?op=add', 2, _MA_XMDOC_ERROR_NOCATEGORY);
        }
        break;

    // Loaddocument
    case 'loaddocument':
        // Define Stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
        $xoTheme->addScript('modules/system/js/admin.js');
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMDOC_DOCUMENT_LIST, 'document.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());
        $document_category = Request::getInt('document_category', 0);
        if ($document_category == 0) {
            $xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NOCATEGORY);
        } else {
            $category = $categoryHandler->get($document_category);
            $xoopsTpl->assign('tips', true);
            $xoopsTpl->assign('extensions', implode(', ', $category->getVar('category_extensions')));
            $xoopsTpl->assign('size', XmdocUtility::SizeConvertString($category->getVar('category_size')));
            $obj  = $documentHandler->create();
            $form = $obj->getForm($document_category);
            $xoopsTpl->assign('form', $form->render());
        }
        break;

    // Edit
    case 'edit':
        // Module admin
        $moduleAdmin->addItemButton(_MA_XMDOC_DOCUMENT_LIST, 'document.php', 'list');
        $xoopsTpl->assign('renderbutton', $moduleAdmin->renderButton());
        // Form
        $document_id = Request::getInt('document_id', 0);
        if ($document_id == 0) {
            $xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_NODOCUMENT);
        } else {
            $obj = $documentHandler->get($document_id);
            $form = $obj->getForm();
            $xoopsTpl->assign('form', $form->render());
        }

        break;
    // Save
    case 'save':
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header('document.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
        }
        $document_id = Request::getInt('document_id', 0);
        if ($document_id == 0) {
            $obj = $documentHandler->create();
        } else {
            $obj = $documentHandler->get($document_id);
        }
        $error_message = $obj->saveDocument($documentHandler, 'document.php');
        if ($error_message != ''){
            $xoopsTpl->assign('error_message', $error_message);
			$document_category = Request::getInt('document_category', 0);
            $form = $obj->getForm($document_category);
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
			if ($surdel === true) {
				if (!$GLOBALS['xoopsSecurity']->check()) {
					redirect_header('document.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
				}
				$error_message = $obj->delDocument($documentHandler, 'document.php');
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

    // Update status
    case 'document_update_status':
        $document_id = Request::getInt('document_id', 0);
        if ($document_id > 0) {
            $document_status = Request::getInt('document_status', 10);
            $obj = $documentHandler->get($document_id);
            if ($document_status == 0 || $document_status == 2){
                $obj->setVar('document_status', 1);
            } else {
                $obj->setVar('document_status', 0);
            }
            if ($documentHandler->insert($obj)) {
                exit;
            }
            $xoopsTpl->assign('error_message', $obj->getHtmlErrors());
        }
        break;
}

$xoopsTpl->display("db:xmdoc_admin_document.tpl");

require __DIR__ . '/admin_footer.php';
