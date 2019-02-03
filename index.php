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

include_once __DIR__ . '/header.php';
$GLOBALS['xoopsOption']['template_main'] = 'xmdoc_index.tpl';
include_once XOOPS_ROOT_PATH . '/header.php';

$xoTheme->addStylesheet(XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname', 'n') . '/assets/css/styles.css', null);

$xoopsTpl->assign('index_header', $helper->getConfig('index_header', ""));
$xoopsTpl->assign('index_footer', $helper->getConfig('index_footer', ""));
$xoopsTpl->assign('index_column', $helper->getConfig('index_column', 2));

// Get start pager
$start = Request::getInt('start', 0);

// Get Permission to view
$viewPermissionCat = XmdocUtility::getPermissionCat('xmdoc_view');

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
$document_arr         = $documentHandler->getall($criteria);
$document_count_total = $documentHandler->getCount($criteria);
$document_count       = count($document_arr);
$xoopsTpl->assign('document_count', $document_count);
$count     = 1;
$count_row = 1;
$keywords = '';
if ($document_count > 0 && !empty($viewPermissionCat)) {
	foreach (array_keys($document_arr) as $i) {
		$document_id                   = $document_arr[$i]->getVar('document_id');
		$document['id']                = $document_id;
		$document['name']              = $document_arr[$i]->getVar('document_name');
		$document['categoryid']        = $document_arr[$i]->getVar('document_category');
		$document['document']          = $document_arr[$i]->getVar('document_document');
		$document['description_short'] = $document_arr[$i]->getVar('document_description', 'n');
		$document['description']       = $document_arr[$i]->getVar('document_description', 'show');
		$document['size']              = XmdocUtility::SizeConvertString($document_arr[$i]->getVar('document_size'));
		$document['author']            = XoopsUser::getUnameFromId($document_arr[$i]->getVar('document_userid'));
		$document['date']              = formatTimestamp($document_arr[$i]->getVar('document_date'), 's');
		if ($document_arr[$i]->getVar('document_mdate') != 0) {
			$document['mdate']         = formatTimestamp($document_arr[$i]->getVar('document_mdate'), 's');
		}                
		$document['rating']            = number_format($document_arr[$i]->getVar('document_rating'), 1);
		$document['votes']             = sprintf(_MA_XMDOC_FORMDOC_VOTES, $document_arr[$i]->getVar('document_votes'));
		$document['counter']           = $document_arr[$i]->getVar('document_counter');
		$document['showinfo']          = $document_arr[$i]->getVar('document_showinfo');
		$document_img                  = $document_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
		$document['logo']              = $url_logo_document . $document_img;
		if ($keywords == '') {
            $keywords = $document_arr[$i]->getVar('document_name');
        } else {
            $keywords = $keywords . ',' . $document_arr[$i]->getVar('document_name');
        }
		$document['count'] = $count;
		if ($count_row == $count) {
			$document['row'] = true;
			$count_row      = $count_row + $helper->getConfig('index_column', 2);
		} else {
			$document['row'] = false;
		}
		if ($count == $document_count) {
			$document['end'] = true;
		} else {
			$document['end'] = false;
		}
		$count++;
		$xoopsTpl->append_by_ref('documents', $document);
		unset($document);
	}
    // Display Page Navigation
    if ($document_count_total > $nb_limit) {
        $nav = new XoopsPageNav($document_count_total, $nb_limit, $start, 'start');
        $xoopsTpl->assign('nav_menu', $nav->renderNav(4));
    }
}
//SEO
// pagetitle
$xoopsTpl->assign('xoops_pagetitle', $xoopsModule->name());
//keywords
$xoTheme->addMeta('meta', 'keywords', $keywords);
include XOOPS_ROOT_PATH . '/footer.php';
