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
use Xmf\Module\Helper;
function block_xmdoc_show($options) {
	include __DIR__ . '/../include/common.php';
	include_once __DIR__ . '/../class/utility.php';
	
	$helper = Helper::getHelper('xmdoc');
	$helper->loadLanguage('main');
	
	$block = array();
	
	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('document_status', 1));
	switch ($options[2]) {
        case "date":
			$criteria->setSort('document_date DESC, document_name');
			$criteria->setOrder('ASC');
        break;

        case "hits":
			$criteria->setSort('document_counter DESC, document_name');
			$criteria->setOrder('ASC');
        break;

        case "rating":
			$criteria->setSort('document_rating DESC, document_name');
			$criteria->setOrder('ASC');
        break;

        case "random":
            $criteria->setSort('RAND()');
        break;
    }
	$category_ids = explode(',', $options[0]);
	if (!in_array(0, $category_ids)) {
        $criteria->add(new Criteria('category_id', '(' . $options[0] . ')', 'IN'));
    }
	$criteria->setLimit($options[1]);
	$documentHandler->table_link = $documentHandler->db->prefix("xmdoc_category");
	$documentHandler->field_link = "category_id";
	$documentHandler->field_object = "document_category";
	$document_arr = $documentHandler->getByLink($criteria);
	if (count($document_arr) > 0) {
		foreach (array_keys($document_arr) as $i) {
			$document_id                   = $document_arr[$i]->getVar('document_id');
			$document['id']                = $document_id;
			$document['name']              = $document_arr[$i]->getVar('document_name');
			$document['category']          = $document_arr[$i]->getVar('category_name');
			$document['categoryid']        = $document_arr[$i]->getVar('document_category');
			$document['document']          = $document_arr[$i]->getVar('document_document');
			$document['description']       = $document_arr[$i]->getVar('document_description', 'show');
			$document['description_short'] = \Xmf\Metagen::generateDescription($document_arr[$i]->getVar('document_description', 'show'), 10);
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
			$block['document'][] = $document;
			unset($document);
		}
	}
	$GLOBALS['xoTheme']->addStylesheet(XOOPS_URL . '/modules/xmdoc/assets/css/styles.css');
	return $block;
}

function block_xmdoc_edit($options) {
	include __DIR__ . '/../include/common.php';

	// Criteria
	$criteria = new CriteriaCompo();
	$criteria->setSort('category_weight ASC, category_name');
	$criteria->setOrder('ASC');
	$criteria->add(new Criteria('category_status', 1));
	$category_arr = $categoryHandler->getall($criteria);
	
	include_once XOOPS_ROOT_PATH . '/modules/xmdoc/class/blockform.php';
    xoops_load('XoopsFormLoader');

    $form = new XmdocBlockForm();
	$category = new XoopsFormSelect(_MB_XMDOC_CATEGORY, 'options[0]', $options[0], 5, true);
	$category->addOption(0, _MB_XMDOC_ALLCATEGORY);
	foreach (array_keys($category_arr) as $i) {
		$category->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
	}
	
	$form->addElement($category);
	$form->addElement(new XoopsFormText(_MB_XMDOC_NBDOC, 'options[1]', 5, 5, $options[1]), true);
	$form->addElement(new XoopsFormHidden('options[2]', $options[2]));

	return $form->render();
}