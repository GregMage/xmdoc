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
class_exists('\Xmf\Module\Admin') or die('XMF is required.');
use Xmf\Module\Helper;
$helper = Helper::getHelper(basename(dirname(__DIR__)));

// Get handler
$categoryHandler = $helper->getHandler('xmdoc_category');
$documentHandler = $helper->getHandler('xmdoc_document');
$docdataHandler = $helper->getHandler('xmdoc_docdata');
$downlimitHandler = $helper->getHandler('xmdoc_downlimit');

// Path & url Config
$url_logo_category = XOOPS_UPLOAD_URL . '/xmdoc/images/category/';
$path_logo_category = XOOPS_UPLOAD_PATH . '/xmdoc/images/category/';
$url_logo_document = XOOPS_UPLOAD_URL . '/xmdoc/images/document/';
$path_logo_document = XOOPS_UPLOAD_PATH . '/xmdoc/images/document/';
$url_document = XOOPS_UPLOAD_URL . '/xmdoc/documents/';
$path_document = XOOPS_UPLOAD_PATH . '/xmdoc/documents/';