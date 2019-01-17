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
class XmdocUtility{
	
    public static function FileSizeConvert($size){
        if ($size > 0) {
            $kb = 1024;
            $mb = 1024*1024;
            $gb = 1024*1024*1024;
            if ($size >= $gb) {
                $mysize = sprintf ("%01.2f",$size/$gb) . " " . 'G';
            } elseif ($size >= $mb) {
                $mysize = sprintf ("%01.2f",$size/$mb) . " " . 'M';
            } elseif ($size >= $kb) {
                $mysize = sprintf ("%01.2f",$size/$kb) . " " . 'k';
            } else {
                $mysize = sprintf ("%01.2f",$size) . " " . 'B';
            }

            return $mysize;
        } else {
            return '';
        }
    }
	
	public static function StringSizeConvert($stringSize){
        if ($stringSize != '') {
            $kb = 1024;
            $mb = 1024*1024;
            $gb = 1024*1024*1024;
			$size_value_arr = explode(' ', $stringSize);
			
            if ($size_value_arr[1] == 'B') {
                $mysize = $size_value_arr[0];
            } elseif ($size_value_arr[1] == 'K') {
                $mysize = $size_value_arr[0] * $kb;
            } elseif ($size_value_arr[1] == 'M') {
                $mysize = $size_value_arr[0] * $mb;
            } else {
                $mysize = $size_value_arr[0] * $gb;
            }
            return $mysize;
        } else {
            return 0;
        }
    }
	
	public static function SizeConvertString($sizeString){
		$mysizeString = '';
		if ($sizeString != '') {
			$size_value_arr = explode(' ', $sizeString);
			if (array_key_exists (0, $size_value_arr) == true && array_key_exists (1, $size_value_arr) == true){
				if ($size_value_arr[0] != ''){
					$mysizeString = '';
					switch ($size_value_arr[1]) {
						case 'B':
							$mysizeString = $size_value_arr[0] . ' ' . _MA_XMDOC_UTILITY_BYTES;
							break;
							
						case 'K':
							$mysizeString = $size_value_arr[0] . ' ' . _MA_XMDOC_UTILITY_KBYTES;
							break;
							
						case 'M':
							$mysizeString = $size_value_arr[0] . ' ' . _MA_XMDOC_UTILITY_MBYTES;
							break;
							
						case 'G':
							$mysizeString = $size_value_arr[0] . ' ' . _MA_XMDOC_UTILITY_GBYTES;
							break;
					}					
					return $mysizeString;
				}
			}
		}		
		return $mysizeString;
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
        $criteria->add(new Criteria('document_status', 1));
		$criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');
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
    
    public static function creatFolder($path = '')
    {
        $folder = str_shuffle(substr(uniqid(), 6, 7)) . uniqid();
        $dir = $path . $folder;
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        //Copy index.html
        $indexFile = XOOPS_ROOT_PATH . '/modules/xmdoc/include/index.html';
        copy($indexFile, $dir . '/index.html');
        return $folder;
    }
    
    public static function delDirectory($dir)
    {
        if (is_dir($dir)) {
            if ($dirHandle = opendir($dir)) {
                while (($file = readdir($dirHandle)) !== false) {
                    if (filetype($dir . $file) === 'file') {
                        unlink($dir . $file);
                    }
                }
                closedir($dirHandle);
            }
            rmdir($dir);
        }
    }
    
    /**
     * formatURL()
     *
     * @param mixed $url
     * @return mixed|string
     */
    public static function formatURL($url)
    {
        $url = trim($url);
        if ($url != '') {
            if ((!preg_match('/^http[s]*:\/\//i', $url)) && (!preg_match('/^ftp*:\/\//i', $url)) && (!preg_match('/^ed2k*:\/\//i', $url))) {
                $url = 'http://' . $url;
            }
        }
        return $url;
    }
     /**
     * XmdocUtility::GetFileSize()
     *
     * @param mixed $url
     * @return mixed|string
     */
    public static function GetFileSize($url)
    {
		if (function_exists('curl_init') && false !== ($curlHandle  = curl_init($url))) {
			$ch = curl_init($url);
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curlHandle, CURLOPT_HEADER, TRUE);
			curl_setopt($curlHandle, CURLOPT_NOBODY, TRUE);	
			curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);			
			$curlReturn = curl_exec($curlHandle);
			if (false === $curlReturn) {
				trigger_error(curl_error($curlHandle));
				$size = 0;
			} else {
				$size = curl_getinfo($curlHandle, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
			}
			curl_close($curlHandle);
			if ($size <= 0){
				return 0;
			} else {			
				return XmdocUtility::FileSizeConvert($size);
			}
		} else {
			return 0;
		}
    }  
    public static function getServerStats()
    {
        $moduleDirName      = basename(dirname(dirname(__DIR__)));
        $moduleDirNameUpper = mb_strtoupper($moduleDirName);
        xoops_loadLanguage('common', $moduleDirName);
        $html = '';
        $html .= "<fieldset><legend style='font-weight: bold; color: #900;'>" . _MA_XMDOC_INDEX_IMAGEINFO . "</legend>\n";
        $html .= "<div style='padding: 8px;'>\n";
        $html .= '<div>' . _MA_XMDOC_INDEX_SPHPINI . "</div>\n";
        $html .= "<ul>\n";
        $downloads = ini_get('file_uploads') ? '<span style="color: #008000;">' . _MA_XMDOC_INDEX_ON . '</span>' : '<span style="color: #ff0000;">' . _MA_XMDOC_INDEX_OFF . '</span>';
        $html      .= '<li>' . _MA_XMDOC_INDEX_SERVERUPLOADSTATUS . $downloads;
        $html .= '<li>' . _MA_XMDOC_INDEX_MAXUPLOADSIZE . ' <b><span style="color: #0000ff;">' . ini_get('upload_max_filesize') . "</span></b>\n";
        $html .= '<li>' . _MA_XMDOC_INDEX_MAXPOSTSIZE . ' <b><span style="color: #0000ff;">' . ini_get('post_max_size') . "</span></b>\n";
        $html .= '<li>' . _MA_XMDOC_INDEX_MEMORYLIMIT . ' <b><span style="color: #0000ff;">' . ini_get('memory_limit') . "</span></b>\n";
        $html .= "</ul>\n";
        $html .= '</div>';
        $html .= '</fieldset><br>';

        return $html;
    }
	
	public static function returnBytes($val)
	{
		switch (mb_substr($val, -1)) {
			case 'K':
			case 'k':
				return (int)$val * 1024;
			case 'M':
			case 'm':
				return (int)$val * 1048576;
			case 'G':
			case 'g':
				return (int)$val * 1073741824;
			default:
				return $val;
		}
	}
}
