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
 * @copyright       XOOPS Project (http://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @author          Mage Gregory (AKA Mage)
 */

defined('XOOPS_ROOT_PATH') || exit('Restricted access');

/**
 * A simple text field
 */
class XmdocFormDoc extends XoopsFormElementTray
{
	/**
     * Constructor
     *
     * @param string $modulename   name of module
     */
    public function __construct($modulename = '', $itemid = 0)
    {
        
		include __DIR__ . '/../include/common.php';
		xoops_loadLanguage('main', 'xmdoc');
		unset($_SESSION['xmdoc_selectiondocs']);
		parent::__construct(_MA_XMDOC_FORMDOC_NAME, '<br>');
		// module id
		$helper = \Xmf\Module\Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		// remove doc
        $criteria = new CriteriaCompo();
		$criteria->add(new Criteria('docdata_modid', $moduleid));
		$criteria->add(new Criteria('docdata_itemid', $itemid));
		$criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');
		$docdataHandler->table_link = $docdataHandler->db->prefix("xmdoc_document");
        $docdataHandler->field_link = "document_id";
        $docdataHandler->field_object = "docdata_docid";
        $docdata_arr = $docdataHandler->getByLink($criteria);
		$docdata_count = $docdataHandler->getCount($criteria);	
		if ($docdata_count > 0) {
			$remove_doc = new XoopsFormCheckBox('<h4>' . _MA_XMDOC_FORMDOC_REMOVE . '</h4>', 'removeDocs');
			$remove_doc->columns = 3;
            foreach (array_keys($docdata_arr) as $i) {
				$document_img = $docdata_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
				$value_doc = '<img src="' . $url_logo_document .  $document_img . '" alt="' . $document_img . '" />' . $docdata_arr[$i]->getVar('document_name');
				$remove_doc->addOption($i, $value_doc);
            }
			$this->addElement($remove_doc);
		}
		// add doc
		$add_text = "<br>";
		$add_text .= "<button type='button' class='btn btn-default btn-sm' onclick='openWithSelfMain(\"" . XOOPS_URL . "/modules/xmdoc/docmanager.php\",\"docmanager\",400,430);' onmouseover='style.cursor=\"hand\"' title='" . _MA_XMDOC_FORMDOC_ADD . "'>";
		$add_text .= "<span class='fa fa-file' aria-hidden='true'></span>";
		$add_text .= "<small> " . _MA_XMDOC_FORMDOC_ADD . "</small>";
		$add_text .= "</button>";
		$this->addElement(new XoopsFormLabel('<h4>' . _MA_XMDOC_FORMDOC_ADD . '</h4>', $add_text));

    }
}
