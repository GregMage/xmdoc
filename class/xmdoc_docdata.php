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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

/**
 * Class xmdoc_docdata
 */
class xmdoc_docdata extends XoopsObject
{
    // constructor
    /**
     * xmdoc_docdata constructor.
     */
    public function __construct()
    {
        $this->initVar('docdata_id', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('docdata_docid', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('docdata_modid', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('docdata_itemid', XOBJ_DTYPE_INT, null, false, 11);
		$this->initVar('document_name', XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar('document_logo', XOBJ_DTYPE_TXTBOX, null, false);
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
}

/**
 * Class xmdocxmdoc_docdataHandler
 */
class xmdocxmdoc_docdataHandler extends XoopsPersistableObjectHandler
{
    /**
     * xmdocxmdoc_docdataHandler constructor.
     * @param null|XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, 'xmdoc_docdata', 'xmdoc_docdata', 'docdata_id', 'docdata_docid');
    }
}
