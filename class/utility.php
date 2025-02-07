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
                $mysize = sprintf ("%01.2f",$size/$kb) . " " . 'K';
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
            return intval($mysize);
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
        $helper = Helper::getHelper('xmdoc');
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
        $sessionHelper = new Helper\Session('xmdoc');
		// module id
		$helper = Helper::getHelper($modulename);
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

	public static function delDocdata($modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';
		$helper = Helper::getHelper($modulename);
		$moduleid = $helper->getModule()->getVar('mid');
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('docdata_modid', $moduleid));
		$criteria->add(new Criteria('docdata_itemid', $itemid));
		$docdataHandler->deleteAll($criteria);
        return '';
    }

	public static function renderDocuments($xoopsTpl, $xoTheme, $modulename = '', $itemid = 0)
    {
        include __DIR__ . '/../include/common.php';

        $xoTheme->addStylesheet( XOOPS_URL . '/modules/xmdoc/assets/css/styles.css', null );

        $xmdocHelper = Helper::getHelper('xmdoc');
		$permDocHelper = new Helper\Permission('xmdoc');
        // Load language files
        $xmdocHelper->loadLanguage('main');

		$helper = Helper::getHelper($modulename);
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
		// Get Permission to view
		$viewPermissionCat = XmdocUtility::getPermissionCat('xmdoc_view');
		//xmsocial
		if (xoops_isActiveModule('xmsocial') && $helper->getConfig('general_xmsocial', 0) == 1) {
			xoops_load('utility', 'xmsocial');
		}
        // Document
        $criteria = new CriteriaCompo();
		if (count($docdata_ids) > 0) {
			$criteria->add(new Criteria('document_id', '(' . implode(',', $docdata_ids) . ')','IN'));
		} else {
			$criteria->add(new Criteria('document_id', 0));
		}
        $criteria->add(new Criteria('document_status', 1));
		$criteria->setSort('document_weight ASC, document_name');
        $criteria->setOrder('ASC');
		if (!empty($viewPermissionCat)) {
			$criteria->add(new Criteria('document_category', '(' . implode(',', $viewPermissionCat) . ')', 'IN'));
		}
		$documentHandler->table_link = $documentHandler->db->prefix("xmdoc_category");
        $documentHandler->field_link = "category_id";
        $documentHandler->field_object = "document_category";
        $document_arr = $documentHandler->getByLink($criteria);
		$options['mod'] = $modulename;
		$options['id'] = $itemid;
		if (count($document_arr) > 0 && !empty($viewPermissionCat)) {
            foreach (array_keys($document_arr) as $i) {
                $document_id                   = $document_arr[$i]->getVar('document_id');
                $document['id']                = $document_id;
                $document['name']              = $document_arr[$i]->getVar('document_name');
                $document['category']          = $document_arr[$i]->getVar('category_name');
                $document['categoryid']        = $document_arr[$i]->getVar('document_category');
                $document['document']          = $document_arr[$i]->getVar('document_document');
				$document['description']       	   = str_replace('[break]', '', $document_arr[$i]->getVar('document_description', 'show'));
				if (false == strpos($document_arr[$i]->getVar('document_description', 'e'), '[break]')){
					$document['description_short'] = '';
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
					$document['xmsocial_arr'] = XmsocialUtility::renderRating('xmdoc', $document_id , 5, $document_arr[$i]->getVar('document_rating'), $document_arr[$i]->getVar('document_votes'), $options);
					$document['dorating'] = 1;
				} else {
					$document['dorating'] = 0;
				}
                $xoopsTpl->appendByRef('document', $document);
                unset($document);
            }
            $xoopsTpl->assign('xmdoc_viewdocs', true);
            $xoopsTpl->assign('xmdoc_viewlist', $xmdocHelper->getConfig('general_uselist', 0));
            $xoopsTpl->assign('xmdoc_logosize', $xmdocHelper->getConfig('general_logosize', 0));
			$xoopsTpl->assign('use_modal', $xmdocHelper->getConfig('general_usemodal', 1));
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
        //Copy index.php
        $indexFile = XOOPS_ROOT_PATH . '/modules/xmdoc/include/index.php';
        copy($indexFile, $dir . '/index.php');
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
			curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($curlHandle, CURLOPT_HEADER, TRUE);
			curl_setopt($curlHandle, CURLOPT_NOBODY, TRUE);
			curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 3); // Timeout de connexion
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, 6); // Timeout total
			$curlReturn = curl_exec($curlHandle);
			if (false === $curlReturn) {
				trigger_error(curl_error($curlHandle), E_USER_WARNING);
                curl_close($curlHandle);
				return 0;
			}
            $httpCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
            if ($httpCode >= 400) { // Si le fichier n'existe pas ou erreur serveur
                curl_close($curlHandle);
                return 0;
            }
            $size = curl_getinfo($curlHandle, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
			curl_close($curlHandle);
            return ($size > 0) ? XmdocUtility::FileSizeConvert($size) : 0;
			if ($size <= 0){
				return 0;
			} else {
				return XmdocUtility::FileSizeConvert($size);
			}
		}
		return 0;
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

    public static function generateDescriptionTagSafe($text, $wordCount = 100)
    {
		if (xoops_isActiveModule('xlanguage')){
			$text = XoopsModules\Xlanguage\Utility::cleanMultiLang($text);
		}
		$text = \Xmf\Metagen::generateDescription($text, $wordCount);
		return $text;
	}

	public static function TagSafe($text)
    {
		if (xoops_isActiveModule('xlanguage')){
			$text = XoopsModules\Xlanguage\Utility::cleanMultiLang($text);
		}
		return $text;
	}
}
