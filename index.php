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
use \Xmf\Request;
use \Xmf\Metagen;
use Xmf\Module\Helper;

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmdoc_index.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

$xoopsTpl->assign('index_header', $helper->getConfig('index_header', ""));
$xoopsTpl->assign('index_footer', $helper->getConfig('index_footer', ""));
$xoopsTpl->assign('index_cat', $helper->getConfig('index_cat', 1));
$xoopsTpl->assign('use_modal', $helper->getConfig('general_usemodal', 1));

// Get Permission to view
$viewPermissionCat = XmdocUtility::getPermissionCat('xmdoc_view');
$permDocHelper = new Helper\Permission('xmdoc');
//xmsocial
if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
	xoops_load('utility', 'xmsocial');
}

// Get start pager
$start = Request::getInt('start', 0);
$xoopsTpl->assign('start', $start);
$xoopsTpl->assign('index_module', $helper->getModule()->getVar('name'));
// Category
$doc_cid = Request::getInt('doc_cid', 0);
$xoopsTpl->assign('doc_cid', $doc_cid);
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('category_status', 1));
if (!empty($viewPermissionCat)) {
	if (!in_array($doc_cid , $viewPermissionCat) && $doc_cid != 0){
		redirect_header('index.php?$doc_cid=0',2, _NOPERM);
	}
    $criteria->add(new Criteria('category_id', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
}
$criteria->setSort('category_weight ASC, category_name');
$criteria->setOrder('ASC');
$category_arr = $categoryHandler->getall($criteria);		
if (count($category_arr) > 0) {
	$doc_cid_options = '<option value="0"' . ($doc_cid == 0 ? ' selected="selected"' : '') . '>' . _ALL .'</option>';
	if (!empty($viewPermissionCat)) {
		foreach (array_keys($category_arr) as $i) {
			$doc_cid_options .= '<option value="' . $i . '"' . ($doc_cid == $i ? ' selected="selected"' : '') . '>' . $category_arr[$i]->getVar('category_name') . '</option>';
			$cat_array['id']          = $category_arr[$i]->getVar('category_id');
			$cat_array['name'] 		  = $category_arr[$i]->getVar('category_name');
			$cat_array['description'] = $category_arr[$i]->getVar('category_description');
			$category_img  			  = $category_arr[$i]->getVar('category_logo');
			if ($category_img == ''){
				$cat_array['logo']    = '';
			} else {
				$cat_array['logo']    = $url_logo_category . $category_img;
			}
			$color					  = $category_arr[$i]->getVar('category_color');
			if ($color == '#ffffff'){
				$cat_array['color']	  = false;
			} else {
				$cat_array['color']	  = $category_arr[$i]->getVar('category_color');
			}
			$xoopsTpl->append_by_ref('cat_array', $cat_array);
			unset($cat_array);
		}
	}
	$xoopsTpl->assign('doc_cid_options', $doc_cid_options);
}

// Criteria
$criteria = new CriteriaCompo();
$criteria->setSort('document_weight ASC, document_name');
$criteria->setOrder('ASC');
$criteria->setStart($start);
$criteria->setLimit($nb_limit);
$criteria->add(new Criteria('document_status', 1));
if (!empty($viewPermissionCat)) {
    $criteria->add(new Criteria('document_category', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
}
if ($doc_cid != 0){
	// vérification si la categorie est activée
	$check_category = $categoryHandler->get($doc_cid);
	if (empty($check_category)) {
		redirect_header('index.php', 2, _MA_XMDOC_ERROR_NOCATEGORY);
	}
	if ($check_category->getVar('category_status') != 1){
		redirect_header('index.php', 2, _MA_XMDOC_ERROR_NACTIVE);
	}	
	$criteria->add(new Criteria('document_category', $doc_cid));
	$xoopsTpl->assign('category_name', $category_arr[$doc_cid]->getVar('category_name'));
	$category_img  = $category_arr[$doc_cid]->getVar('category_logo');
	if ($category_img == ''){
		$xoopsTpl->assign('category_logo', '');
	} else {
		$xoopsTpl->assign('category_logo', $url_logo_category . $category_img);
	}
	$color = $category_arr[$doc_cid]->getVar('category_color');
	if ($color == '#ffffff'){
		$xoopsTpl->assign('category_color', false);
		
	} else {
		$xoopsTpl->assign('category_color', $color);
	}
	$xoopsTpl->assign('category_description', $category_arr[$doc_cid]->getVar('category_description'));
	$xoopsTpl->assign('cat', true);
} else {
	$xoopsTpl->assign('cat', false);
}

$documentHandler->table_link = $documentHandler->db->prefix("xmdoc_category");
$documentHandler->field_link = "category_id";
$documentHandler->field_object = "document_category";
$document_arr = $documentHandler->getByLink($criteria);
$document_count_total = $documentHandler->getCount($criteria);
$document_count       = count($document_arr);
$xoopsTpl->assign('document_count', $document_count);
$keywords = '';
if ($document_count > 0 && !empty($viewPermissionCat)) {
	foreach (array_keys($document_arr) as $i) {
		$document_id                   = $document_arr[$i]->getVar('document_id');
		$document['id']                = $document_id;
		$document['name']              = $document_arr[$i]->getVar('document_name');
		$document['categoryid']        = $document_arr[$i]->getVar('document_category');
		$document['document']          = $document_arr[$i]->getVar('document_document');
		$document['description']       = str_replace('[break]', '', $document_arr[$i]->getVar('document_description', 'show'));
		if (false == strpos($document_arr[$i]->getVar('document_description', 'e'), '[break]')){
			$document['description_short'] = $document_arr[$i]->getVar('document_description', 'show');
			$document['description_end']   = '';
		}else{
			$document['description_short'] = substr($document_arr[$i]->getVar('document_description', 'show'), 0, strpos($document_arr[$i]->getVar('document_description', 'show'),'[break]'));
			$document['description_end']   = str_replace('[break]', '', substr($document_arr[$i]->getVar('document_description', 'show'), strpos($document_arr[$i]->getVar('document_description', 'show'),'[break]')));
		}
		$document['size']              = XmdocUtility::SizeConvertString($document_arr[$i]->getVar('document_size'));
		$document['author']            = XoopsUser::getUnameFromId($document_arr[$i]->getVar('document_userid'));
		$document['date']              = formatTimestamp($document_arr[$i]->getVar('document_date'), 's');
		if ($document_arr[$i]->getVar('document_mdate') != 0) {
			$document['mdate']         = formatTimestamp($document_arr[$i]->getVar('document_mdate'), 's');
		}
		$document['counter']           = $document_arr[$i]->getVar('document_counter');
		$document['showinfo']          = $document_arr[$i]->getVar('document_showinfo');
		$document_img                  = $document_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
		$document['logo']              = $url_logo_document . $document_img;
		$color						   = $document_arr[$i]->getVar('category_color');
		if ($color == '#ffffff'){
			$document['color']	 	   = false;
		} else {
			$document['color']		   = $color;
		}
		$document['perm_edit']         = $permDocHelper->checkPermission('xmdoc_editapprove', $document['categoryid']);
		$document['perm_del']          = $permDocHelper->checkPermission('xmdoc_delete', $document['categoryid']);
		//xmsocial
		if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
			$document['xmsocial_arr'] = XmsocialUtility::renderRating($xoTheme, 'xmdoc', $document_id , 5, $document_arr[$i]->getVar('document_rating'), $document_arr[$i]->getVar('document_votes'));
			$document['dorating'] = 1;
		} else {
			$document['dorating'] = 0;
		}
		$keywords .= Metagen::generateSeoTitle($document_arr[$i]->getVar('document_name')) . ',';
		$xoopsTpl->append_by_ref('documents', $document);
		unset($document);
	}
    // Display Page Navigation
    if ($document_count_total > $nb_limit) {
        $nav = new XoopsPageNav($document_count_total, $nb_limit, $start, 'start', 'doc_cid=' . $doc_cid);
        $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
    }
}
//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name());
//keywords
$keywords = substr($keywords, 0, -1);
$xoTheme->addMeta('meta', 'keywords', $keywords);
include XOOPS_ROOT_PATH . '/footer.php';
