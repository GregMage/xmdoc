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

function xoops_module_install_xmdoc()
{
    $namemodule = 'xmdoc';
    
    //Creation ".$namemodule."/
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);

    //Creation ".$namemodule."/images/
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);

    //Creation ".$namemodule."/images/category
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/category';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);
    
    //Creation ".$namemodule."/images/document
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/document';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    
    chmod($dir, 0777);
    //Creation ".$namemodule."/documents
    $dir = XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/documents';
    if (!is_dir($dir)) {
        mkdir($dir, 0777);
    }
    chmod($dir, 0777);
    
    //Copy index.html
    $indexFile = XOOPS_ROOT_PATH . '/modules/' . $namemodule . '/include/index.html';
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/category/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/document/index.html');
    copy($indexFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/documents/index.html');

    //Copy blank.gif
    $blankFile = XOOPS_ROOT_PATH . '/modules/' . $namemodule . '/assets/images/blank.gif';
    copy($blankFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/category/blank.gif');
    $blankFile = XOOPS_ROOT_PATH . '/modules/' . $namemodule . '/assets/images/blank_doc.gif';
    copy($blankFile, XOOPS_ROOT_PATH . '/uploads/' . $namemodule . '/images/document/blank_doc.gif');
    return true;
}
