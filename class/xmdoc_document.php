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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmdoc_document
 */
class xmdoc_document extends XoopsObject
{
    // constructor
    /**
     * xmdoc_document constructor.
     */
    public function __construct()
    {
        $this->initVar('document_id', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('document_category', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('document_name', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('document_description', XOBJ_DTYPE_TXTAREA, null, false);
        // use html
        $this->initVar('dohtml', XOBJ_DTYPE_INT, 1, false);
        $this->initVar('document_logo', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('document_document', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('document_showinfo', XOBJ_DTYPE_INT, null, false, 1);
        $this->initVar('document_weight', XOBJ_DTYPE_INT, null, false, 11);
        $this->initVar('document_status', XOBJ_DTYPE_INT, null, false, 1);
        $this->initVar('category_name', XOBJ_DTYPE_TXTBOX, null, false);
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
    public function saveDocument($documentHandler, $action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include __DIR__ . '/../include/common.php';

        $error_message = '';
        $upload_size = 512000;
        // test error
        if ((int)$_REQUEST['document_weight'] == 0 && $_REQUEST['document_weight'] != '0') {
            $error_message .= _MA_XMDOC_ERROR_WEIGHT . '<br>';
            $this->setVar('document_weight', 0);
        }
        
        // document
        $category_id = Xmf\Request::getInt('document_category', 1);
        $category = $categoryHandler->get($category_id);
        $category->getVar('category_size');
        if ($_FILES['document_document']['error'] != UPLOAD_ERR_NO_FILE) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploader_document_img = new XoopsMediaUploader($path_document, XmdocUtility::ExtensionToMime($category->getVar('category_extensions')), $category->getVar('category_size') * 1024, null, null);
            if ($uploader_document_img->fetchMedia('document_document')) {
                $uploader_document_img->setPrefix('document_');
                if (!$uploader_document_img->upload()) {
                    $error_message .= $uploader_document_img->getErrors() . '<br />';
                } else {
                    $this->setVar('document_document', $url_document . $uploader_document_img->getSavedFileName());
                }
            } else {
                $error_message .= $uploader_document_img->getErrors();
            }
        } else {
            $this->setVar('document_document', Xmf\Request::getString('document_document', ''));
        }

        //logo
        if ($_FILES['document_logo']['error'] != UPLOAD_ERR_NO_FILE) {
            include_once XOOPS_ROOT_PATH . '/class/uploader.php';
            $uploader_document_img = new XoopsMediaUploader($path_logo_document, array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'), $upload_size, null, null);
            if ($uploader_document_img->fetchMedia('document_logo')) {
                $uploader_document_img->setPrefix('document_');
                if (!$uploader_document_img->upload()) {
                    $error_message .= $uploader_document_img->getErrors() . '<br />';
                } else {
                    $this->setVar('document_logo', $uploader_document_img->getSavedFileName());
                }
            } else {
                $error_message .= $uploader_document_img->getErrors();
            }
        } else {
            $this->setVar('document_logo', Xmf\Request::getString('document_logo', ''));
        }
        $this->setVar('document_name', Xmf\Request::getString('document_name', ''));
        $this->setVar('document_category', $category_id);
        $this->setVar('document_description',  Xmf\Request::getText('document_description', ''));
        $this->setVar('document_showinfo', Xmf\Request::getInt('document_showinfo', 1));
        $this->setVar('document_status', Xmf\Request::getInt('document_status', 1));

        if ($error_message == '') {
            $this->setVar('document_weight', Xmf\Request::getInt('document_weight', 0));
            if ($documentHandler->insert($this)) {
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
    public function getFormCategory($action = false)
    {
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';  

        // Get Permission to submit
        $submitPermissionCat = XmdocUtility::getPermissionCat('xmdoc_submit');        
        
        $form = new XoopsThemeForm(_MA_XMDOC_ADD, 'form', $action, 'post', true);
        // category       
        $category = new XoopsFormSelect(_MA_XMDOC_DOCUMENT_CATEGORY, 'document_category', $this->getVar('document_category'));
        $criteria = new CriteriaCompo();
		$criteria->add(new Criteria('category_status', 1));
        $criteria->setSort('category_weight ASC, category_name');
        $criteria->setOrder('ASC');
        if (!empty($submitPermissionCat)){
            $criteria->add(new Criteria('category_id', '(' . implode(',', $submitPermissionCat) . ')','IN'));
        }
        $category_arr = $categoryHandler->getall($criteria);        
        if (count($category_arr) == 0 || empty($submitPermissionCat)){
            redirect_header('index.php', 3, _MA_XMDOC_ERROR_NOACESSCATEGORY);
        }
        foreach (array_keys($category_arr) as $i) {
            $category->addOption($category_arr[$i]->getVar('category_id'), $category_arr[$i]->getVar('category_name'));
        }
        $form->addElement($category, true);
        
        $form->addElement(new XoopsFormHidden('op', 'loaddocument'));        
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    } 

    /**
     * @param bool $action
     * @return XoopsThemeForm
     */
    public function getForm($category_id = 0, $action = false)
    {
        $upload_size = 512000;
        $helper = \Xmf\Module\Helper::getHelper('xmdoc');
        if ($action === false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
        include __DIR__ . '/../include/common.php';
        
        // Get Permission to submit
        $submitPermissionCat = XmdocUtility::getPermissionCat('xmdoc_submit');  

        //form title
        $title = $this->isNew() ? sprintf(_MA_XMDOC_ADD) : sprintf(_MA_XMDOC_EDIT);

        $form = new XoopsThemeForm($title, 'form', $action, 'post', true);
        $form->setExtra('enctype="multipart/form-data"');

        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('document_id', $this->getVar('document_id')));
            $status = $this->getVar('document_status');
            $showinfo = $this->getVar('document_showinfo');
            $weight = $this->getVar('document_weight');
            $category_id = $this->getVar('document_category');
        } else {
            $status = 1;
            $showinfo = 1;
            $weight = 0;
        }

        // category
        $category = $categoryHandler->get($category_id);
        $category_img = $category->getVar('category_logo') ?: 'blank.gif';
        $form->addElement(new xoopsFormLabel (_MA_XMDOC_DOCUMENT_CATEGORY, '<img src="' . $url_logo_category .  $category_img . '" alt="' . $category_img . '" /> <strong>' . $category->getVar('category_name') . '</strong>'));
        $form->addElement(new XoopsFormHidden('document_category', $category_id));
        
        // title
        $form->addElement(new XoopsFormText(_MA_XMDOC_DOCUMENT_NAME, 'document_name', 50, 255, $this->getVar('document_name')), true);
        
        // document       
        $document = new XoopsFormElementTray(_MA_XMDOC_DOCUMENT_DOCUMENT,'<br /><br />');
        $document_url = new XoopsFormText(_MA_XMDOC_DOCUMENT_DOCUMENTURL, 'document_document', 75, 255, $this->getVar('document_document'));
        $document->addElement($document_url,false);
        $document->addElement(new XoopsFormFile(_MA_XMDOC_DOCUMENT_DOCUMENT, 'document_document', 104857600), false); // 100 MB (Verification with the category when saving)
        $form->addElement($document);

        // description
        $editor_configs           =array();
        $editor_configs['name']   = 'document_description';
        $editor_configs['value']  = $this->getVar('document_description', 'e');
        $editor_configs['rows']   = 20;
        $editor_configs['cols']   = 160;
        $editor_configs['width']  = '100%';
        $editor_configs['height'] = '400px';
        $editor_configs['editor'] = $helper->getConfig('general_editor', 'Plain Text');
        $form->addElement(new XoopsFormEditor(_MA_XMDOC_DOCUMENT_DESC, 'document_description', $editor_configs), false);
        
        // logo
        $blank_img = $this->getVar('document_logo') ?: 'blank_doc.gif';
        $uploadirectory = str_replace(XOOPS_URL, '', $url_logo_document);
        $imgtray_img     = new XoopsFormElementTray(_MA_XMDOC_DOCUMENT_LOGOFILE  . '<br /><br />' . sprintf(_MA_XMDOC_DOCUMENT_UPLOADSIZE, $upload_size/1024), '<br />');
        $imgpath_img     = sprintf(_MA_XMDOC_DOCUMENT_FORMPATH, $uploadirectory);
        $imageselect_img = new XoopsFormSelect($imgpath_img, 'document_logo', $blank_img);
        $image_array_img = XoopsLists::getImgListAsArray($path_logo_document);
        $imageselect_img->addOption("$blank_img", $blank_img);
        foreach ($image_array_img as $image_img) {
            $imageselect_img->addOption("$image_img", $image_img);
        }
        $imageselect_img->setExtra("onchange='showImgSelected(\"image_img2\", \"document_logo\", \"" . $uploadirectory . "\", \"\", \"" . XOOPS_URL . "\")'");
        $imgtray_img->addElement($imageselect_img, false);
        $imgtray_img->addElement(new XoopsFormLabel('', "<br /><img src='" . $url_logo_document . '/' . $blank_img . "' name='image_img2' id='image_img2' alt='' />"));
        $fileseltray_img = new XoopsFormElementTray('<br />', '<br /><br />');
        $fileseltray_img->addElement(new XoopsFormFile(_MA_XMDOC_DOCUMENT_UPLOAD, 'document_logo', $upload_size), false);
        $fileseltray_img->addElement(new XoopsFormLabel(''), false);
        $imgtray_img->addElement($fileseltray_img);
        $form->addElement($imgtray_img);
        
        // showinfo
        $form->addElement(new XoopsFormRadioYN(_MA_XMDOC_DOCUMENT_SHOWINFO, 'document_showinfo', $showinfo));
        
        // weight
        $form->addElement(new XoopsFormText(_MA_XMDOC_DOCUMENT_WEIGHT, 'document_weight', 5, 5, $weight), true);

		// status
        $form_status = new XoopsFormRadio(_MA_XMDOC_STATUS, 'document_status', $status);
        $options = array(1 => _MA_XMDOC_STATUS_A, 0 =>_MA_XMDOC_STATUS_NA,);
        $form_status->addOptionArray($options);
        $form->addElement($form_status);

        $form->addElement(new XoopsFormHidden('op', 'save'));
        // submit
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        return $form;
    }
}

/**
 * Class xmdocxmdoc_documentHandler
 */
class xmdocxmdoc_documentHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmdocxmdoc_documentHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmdoc_document', 'xmdoc_document', 'document_id', 'document_name');
    }
}
