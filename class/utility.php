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

/**
 * Class XmdocUtility
 */
class XmdocUtility
{    
    
    public static function FileSizeConvert($size){
        if ($size > 0) {
            $kb = 1024;
            $mb = 1024*1024;
            $gb = 1024*1024*1024;
            if ($size >= $gb) {
                $mysize = sprintf ("%01.2f",$size/$gb) . " " . _MA_XMDOC_UTILITY_GBYTES;
            } elseif ($size >= $mb) {
                $mysize = sprintf ("%01.2f",$size/$mb) . " " . _MA_XMDOC_UTILITY_MBYTES;
            } elseif ($size >= $kb) {
                $mysize = sprintf ("%01.2f",$size/$kb) . " " . _MA_XMDOC_UTILITY_KBYTES;
            } else {
                $mysize = sprintf ("%01.2f",$size) . " " . _MA_XMDOC_UTILITY_BYTES;
            }

            return $mysize;
        } else {
            return '';
        }
    }
        
    public static function ExtensionToMime($extensions){
        $extensionToMime = include $GLOBALS['xoops']->path('include/mimetypes.inc.php');
        foreach (array_keys($extensions) as $i) {
            $mimetypes[] = $extensionToMime[$extensions[$i]];
        }
        return $mimetypes;
    }
    
    public static function getPermissionCat($permtype = 'xmdoc_view')
    {
        global $xoopsUser;
        $categories = array();
        $helper = Xmf\Module\Helper::getHelper('xmdoc');
        $moduleHandler = $helper->getModule();
        $groups = is_object($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $gpermHandler = xoops_getHandler('groupperm');
        $categories = $gpermHandler->getItemIds($permtype, $groups, $moduleHandler->getVar('mid'));

        return $categories;
    }
    
    public static function documentNamePerCat($category_id)
    {
        include __DIR__ . '/../include/common.php';
        $document_name = '';
        $criteria = new CriteriaCompo();
        $criteria->setSort('document_name');
        $criteria->setOrder('ASC');
        $criteria->add(new Criteria('document_category', $category_id));
        $document_arr = $documentHandler->getall($criteria);
        if (count($document_arr) > 0){
            $document_name .= _MA_XMDOC_CATEGORY_WARNINGDELARTICLE . '<br>';
            foreach (array_keys($document_arr) as $i) {
                $document_name .= $document_arr[$i]->getVar('document_name') . '<br>';
            }
        }
        return $document_name;
    }
	
	public static function saveDocuments($modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
		$error_message = '';		

		if (isset($_REQUEST['removeDocs'])) {
            if (is_array($_REQUEST['removeDocs'])){
                foreach ($_REQUEST['removeDocs'] as $index) {
                    $obj  = $docdataHandler->get($index);
                    echo 'index: ' . $index. '<br>';
                    if ($docdataHandler->delete($obj)){
                        $error_message .= '';
                    } else {
                        $error_message .= 'docdata id: ' . $index . '<br>' . $obj->getHtmlErrors();
                    }
                }
            } else {
                $obj  = $docdataHandler->get($_REQUEST['removeDocs']);
                if ($docdataHandler->delete($obj)){
                    $error_message .= '';
                } else {
                    $error_message .= 'docdata id: ' . $index . '<br>' . $obj->getHtmlErrors();
                }
            }
		}
		// add doc
        $sessionHelper = new \Xmf\Module\Helper\Session('xmdoc');
		// module id
		$helper = \Xmf\Module\Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		if ($sessionHelper->get('selectiondocs') != false){
			foreach ($sessionHelper->get('selectiondocs') as $index) {				
				// vérification pour savoir si le document est déjà existant
				$criteria = new CriteriaCompo();
				$criteria->add(new Criteria('docdata_docid', $index));
				$criteria->add(new Criteria('docdata_modid', $moduleid));
				$criteria->add(new Criteria('docdata_itemid', $itemid));
				$docdata_count = $docdataHandler->getCount($criteria);
				if ($docdata_count == 0) {
					$obj  = $docdataHandler->create();
					$obj->setVar('docdata_docid', $index);
					$obj->setVar('docdata_modid', $moduleid);
					$obj->setVar('docdata_itemid', $itemid);					
					if ($docdataHandler->insert($obj)){
						$error_message .= '';
					} else {
						$error_message .= 'docdata id: ' . $index . '<br>' . $obj->getHtmlErrors();
					}
				}
			}
            $sessionHelper->del('selectiondocs');
		}
        return $error_message;
    }
	
	public static function renderDocuments($xoopsTpl, $xoTheme, $modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
        
        $xoTheme->addStylesheet( XOOPS_URL . '/modules/xmdoc/assets/css/styles.css', null );
        
        $xmdocHelper = Xmf\Module\Helper::getHelper('xmdoc');
        // Load language files
        $xmdocHelper->loadLanguage('main');
        
		$helper = \Xmf\Module\Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		//docdata
        $criteria = new CriteriaCompo();
		$criteria->add(new Criteria('docdata_modid', $moduleid));
		$criteria->add(new Criteria('docdata_itemid', $itemid));
        $docdata_arr = $docdataHandler->getAll($criteria);
        $docdata_ids = array();
        if (count($docdata_arr) > 0) {
            foreach (array_keys($docdata_arr) as $i) {
                $docdata_ids[] = $docdata_arr[$i]->getVar('docdata_docid');
            }
        }
        // Document  
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('document_id', '(' . implode(',', $docdata_ids) . ')','IN'));
		$criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');
		$documentHandler->table_link = $documentHandler->db->prefix("xmdoc_category");
        $documentHandler->field_link = "category_id";
        $documentHandler->field_object = "document_category";
        $document_arr = $documentHandler->getByLink($criteria);
		if (count($document_arr) > 0) {
            foreach (array_keys($document_arr) as $i) {
                $document_id                 = $document_arr[$i]->getVar('document_id');
                $document['id']              = $document_id;
                $document['name']            = $document_arr[$i]->getVar('document_name');
                $document['category']        = $document_arr[$i]->getVar('category_name');
                $document['document']        = $document_arr[$i]->getVar('document_document');
                $document['description']     = $document_arr[$i]->getVar('document_description', 'show');
                $document['showinfo']        = $document_arr[$i]->getVar('document_showinfo');
                $document_img                = $document_arr[$i]->getVar('document_logo') ?: 'blank_doc.gif';
                $document['logo']            = '<img src="' . $url_logo_document .  $document_img . '" alt="' . $document['name'] . '" />';
                $xoopsTpl->append_by_ref('document', $document);
                unset($document);
            }
            $xoopsTpl->assign('xmdoc_viewdocs', true);
        }
    }

    public static function renderDocForm($form, $modulename = '', $itemid = 0)
    {
        xoops_load('formdoc', 'xmdoc');
        $form->addElement(new XmdocFormDoc($modulename, $itemid), false);
        return $form;
    }
}
