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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmdoc_category
 */
class xmdoc_category extends XoopsObject
{
    // constructor
    /**
     * xmdoc_category constructor.
     */
    public function __construct()
    {
        $this->initVar('category_id', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('category_name', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('category_description', XOBJ_DTYPE_TXTAREA, null, false);
        // use html
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('category_logo', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('category_size', XOBJ_DTYPE_TXTBOX, '500 K', false);
        $this->initVar('category_extensions', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('category_folder', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('category_rename', XOBJ_DTYPE_INT, null, false, 1);
        $this->initVar('category_limitdownload', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('category_limititem', XOBJ_DTYPE_INT, null, false, 5);
        $this->initVar('category_weight', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('category_status', XOBJ_DTYPE_INT, null, false, 1);
    }

    /**
     * @return mixed
     */
    public function get_new_enreg()
    {
        global $xoopsDB;
        $new_enreg = $xoopsDB->getInsertId();
        return $new_enreg;
    }

    /**
     * @return mixed
     */
    public function saveCategory($categoryHandler, $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include __DIR__ . '/../include/common.php';
        
        $error_message = '';
        // test error
        if ((int)$_REQUEST['category_weight'] == 0 && $_REQUEST['category_weight'] != '0') {
            $error_message .= _MA_XMDOC_ERROR_WEIGHT . '<br>';
            $this->setVar('category_weight', 0);
        }
		
		$iniPostMaxSize = XmdocUtility::returnBytes(ini_get('post_max_size'));
		$iniUploadMaxFileSize = XmdocUtility::returnBytes(ini_get('upload_max_filesize'));
		if (min($iniPostMaxSize, $iniUploadMaxFileSize) < XmdocUtility::StringSizeConvert(Request::getString('sizeValue', '') . ' ' . Request::getString('sizeType', ''))) {
			$error_message .= _MA_XMDOC_ERROR_CATEGORYSIZE . '<br>';
			$this->setVar('category_size', '500 K');
		}
		
        //logo
        if ($_FILES['category_logo']['error'] != UPLOAD_ERR_NO_FILE) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploader_category_img = new XoopsMediaUploader($path_logo_category, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), $upload_size, null, null);
            if ($uploader_category_img->fetchMedia('category_logo')) {
                $uploader_category_img->setPrefix('category_');
                if (!$uploader_category_img->upload()) {
                    $error_message .= $uploader_category_img->getErrors() . '<br />';
                } else {
                    $this->setVar('category_logo', $uploader_category_img->getSavedFileName());
                }
            } else {
                $error_message .= $uploader_category_img->getErrors();
            }
        } else {
            $this->setVar('category_logo', Request::getString('category_logo', ''));
        }
        $this->setVar('category_name', Request::getString('category_name', ''));
        $this->setVar('category_description',  Request::getText('category_description', ''));
        $this->setVar('category_extensions', Request::getArray('category_extensions', array()));
        $this->setVar('category_rename', Request::getInt('category_rename', 0));
        $this->setVar('category_status', Request::getInt('category_status', 1));
        if ($this->getVar('category_folder') == '') {
            $folder = XmdocUtility::creatFolder($path_document);
            $this->setVar('category_folder', $folder);
        }
        $this->setVar('category_limitdownload', Request::getInt('category_limitdownload', 1));
        $this->setVar('category_limititem', Request::getInt('category_limititem', 1));

        if ($error_message == '') {
            $this->setVar('category_weight', Request::getInt('category_weight', 0));
			$this->setVar('category_size',Request::getFloat('sizeValue', 0) . ' ' . Request::getString('sizeType', ''));
            if ($categoryHandler->insert($this)) {
                // permissions
                if ($this->get_new_enreg() == 0){
					$perm_id = $this->getVar('category_id');
				} else {
					$perm_id = $this->get_new_enreg();
				}
                $permHelper = new Helper\Permission();
                // permission view
                $groups_view = Request::getArray('xmdoc_view_perms', array(), 'POST');
                $permHelper->savePermissionForItem('xmdoc_view', $perm_id, $groups_view);
                // permission submit
                $groups_submit = Request::getArray('xmdoc_submit_perms', array(), 'POST');
                $permHelper->savePermissionForItem('xmdoc_submit', $perm_id, $groups_submit);
                redirect_header($action, 2, _MA_XMDOC_REDIRECT_SAVE);
            } else {
                $error_message =  $this->getHtmlErrors();
            }
        }
        return $error_message;
    }

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getForm($action = false)
    {
        $upload_size = 512000;
        $helper = Helper::getHelper('xmdoc');
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';

        //form title
        $title = $this->isNew() ? sprintf(_MA_XMDOC_ADD) : sprintf(_MA_XMDOC_EDIT);

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('category_id', $this->getVar('category_id')));
            $status = $this->getVar('category_status');
            $weight = $this->getVar('category_weight');
			$rename = $this->getVar('category_rename');
        } else {
            $status = 1;
            $weight = 0;
            $rename = 1;
        }

        // title
        $form->addElement(new XoopsFormText(_MA_XMDOC_CATEGORY_NAME, 'category_name', 50, 255, $this->getVar('category_name')), true);

        // description
        $editor_configs           =array();
        $editor_configs['name']   = 'category_description';
        $editor_configs['value']  = $this->getVar('category_description', 'e');
        $editor_configs['rows']   = 20;
        $editor_configs['cols']   = 160;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $helper->getConfig('general_editor', 'Plain Text');
        $form->addElement(new XoopsFormEditor(_MA_XMDOC_CATEGORY_DESC, 'category_description', $editor_configs), false);
        // logo
        $blank_img = $this->getVar('category_logo') ?: 'blank.gif';
        $uploadirectory = str_replace(XOOPS_URL, '', $url_logo_category);
        $imgtray_img     = new XoopsFormElementTray(_MA_XMDOC_CATEGORY_LOGOFILE  . '<br /><br />' . sprintf(_MA_XMDOC_CATEGORY_UPLOADSIZE, $upload_size/1024), '<br />');
        $imgpath_img     = sprintf(_MA_XMDOC_CATEGORY_FORMPATH, $uploadirectory);
        $imageselect_img = new XoopsFormSelect($imgpath_img, 'category_logo', $blank_img);
        $image_array_img = XoopsLists::getImgListAsArray($path_logo_category);
        $imageselect_img->addOption("$blank_img", $blank_img);
        foreach ($image_array_img as $image_img) {
            $imageselect_img->addOption("$image_img", $image_img);
        }
        $imageselect_img->setExtra("onchange='showImgSelected(\"image_img2\", \"category_logo\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'");
        $imgtray_img->addElement($imageselect_img, false);
        $imgtray_img->addElement(new XoopsFormLabel('', "<br /><img src='" . $url_logo_category . '/' . $blank_img . "' name='image_img2' id='image_img2' alt='' />"));
        $fileseltray_img = new XoopsFormElementTray('<br />', '<br /><br />');
        $fileseltray_img->addElement(new XoopsFormFile(_MA_XMDOC_CATEGORY_UPLOAD, 'category_logo', $upload_size), false);
        $fileseltray_img->addElement(new XoopsFormLabel(''), false);
        $imgtray_img->addElement($fileseltray_img);
        $form->addElement($imgtray_img);
        
        // upload size max		
		$size_value_arr = explode(' ', $this->getVar('category_size'));
		$aff_size = new \XoopsFormElementTray(_MA_XMDOC_CATEGORY_SIZE, '');
		$aff_size->addElement(new \XoopsFormText('', 'sizeValue', 13, 13, $size_value_arr[0]));
		if (array_key_exists (1, $size_value_arr) == false){
			$size_value_arr[1] = 'K';
		}
		$type     = new \XoopsFormSelect('', 'sizeType', $size_value_arr[1]);
		$typeArray = [
			'B' => _MA_XMDOC_UTILITY_BYTES,
			'K' => _MA_XMDOC_UTILITY_KBYTES,
			'M' => _MA_XMDOC_UTILITY_MBYTES,
			'G' => _MA_XMDOC_UTILITY_GBYTES
		];
		$type->addOptionArray($typeArray);
		$aff_size->addElement($type);
		$aff_size->addElement(new \XoopsFormElementTray(_MA_XMDOC_CATEGORY_SIZEINFO, 'dfsdfdf'));
		$form->addElement($aff_size);
        
        // extensions
        $extension_list = include $GLOBALS['xoops']->path('include/mimetypes.inc.php');
        ksort($extension_list);     
        $extension = new XoopsFormSelect(_MA_XMDOC_CATEGORY_EXTENSION, 'category_extensions', $this->getVar('category_extensions'), 10, true);
        foreach ($extension_list as $key => $val) {
            $extension ->addOption($key, $key);
        }
        $form->addElement($extension, true);
        
        // limitdownload
        $form->addElement(new XoopsFormText(_MA_XMDOC_CATEGORY_LIMITDOWNLOAD, 'category_limitdownload', 5, 5, $this->getVar('category_limitdownload')), true);
        
        // limititem
        $form->addElement(new XoopsFormText(_MA_XMDOC_CATEGORY_LIMITITEM, 'category_limititem', 5, 5, $this->getVar('category_limititem')), true);

		// rename
        $form->addElement(new XoopsFormRadioYN(_MA_XMDOC_CATEGORY_RENAME, 'category_rename', $rename), true);

        // weight
        $form->addElement(new XoopsFormText(_MA_XMDOC_CATEGORY_WEIGHT, 'category_weight', 5, 5, $weight));

		// status
        $form_status = new XoopsFormRadio(_MA_XMDOC_STATUS, 'category_status', $status);
        $options = array(1 => _MA_XMDOC_STATUS_A, 0 =>_MA_XMDOC_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        // permission
        $permHelper = new Helper\Permission();
        $form->addElement($permHelper->getGroupSelectFormForItem('xmdoc_view', $this->getVar('category_id'),  _MA_XMDOC_PERMISSION_VIEW_THIS, 'xmdoc_view_perms', true));
        $form->addElement($permHelper->getGroupSelectFormForItem('xmdoc_submit', $this->getVar('category_id'),  _MA_XMDOC_PERMISSION_SUBMIT_THIS, 'xmdoc_submit_perms', true));

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

/**
 * Classxmdocxmdoc_categoryHandler
 */
class xmdocxmdoc_categoryHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmdocxmdoc_categoryHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmdoc_category', 'xmdoc_category', 'category_id', 'category_name');
    }
}
