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
	
	public static function removeDocuments()
    {
        include __DIR__ . '/../include/common.php';
		// remove field
		$error_message = '';
		if (isset($_REQUEST['removeDocs']) && is_array($_REQUEST['removeDocs'])) {
			foreach ($_REQUEST['removeDocs'] as $index) {
				$obj  = $docdataHandler->get($index);
				$docdataHandler->delete($obj);
				$error_message .= 'docdata id: ' . $index . '<br>' . $obj->getHtmlErrors();
			}
		}
        return $error_message;
    }
}
