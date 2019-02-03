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
// The name of this module
define('_MI_XMDOC_NAME', 'Document');
define('_MI_XMDOC_DESC', 'Document management');

// Menu
define('_MI_XMDOC_MENU_HOME', 'Index');
define('_MI_XMDOC_MENU_CATEGORY', 'Category');
define('_MI_XMDOC_MENU_DOCUMENT', 'Document');
define('_MI_XMDOC_MENU_PERMISSION', 'Permission');
define('_MI_XMDOC_MENU_ABOUT', 'About');

// Block
define('_MI_XMDOC_BLOCK_DATE', 'Recent Documents');
define('_MI_XMDOC_BLOCK_DATE_DESC', 'Display Recent Documents');
define('_MI_XMDOC_BLOCK_HITS', 'Top Documents');
define('_MI_XMDOC_BLOCK_HITS_DESC', 'Display Top Documents');
define('_MI_XMDOC_BLOCK_RATING', 'Top Rated Documents');
define('_MI_XMDOC_BLOCK_RATING_DESC', 'Display Top Rated Documents');
define('_MI_XMDOC_BLOCK_RANDOM', 'Random Documents');
define('_MI_XMDOC_BLOCK_RANDOM_DESC', 'Display documents randomly');

// Pref
define('_MI_XMDOC_PREF_HEAD_INDEX', '<span style="font-size: large;  font-weight: bold;">Index</span>');
define('_MI_XMDOC_PREF_COLUMN', 'Number of column for download View');
define('_MI_XMDOC_PREF_COLUMN_DESC', 'Number of download that can be viewed in index: 1, 2, 3 or 4 columns');
define('_MI_XMDOC_PREF_HEADER', 'Header index page');
define('_MI_XMDOC_PREF_HEADER_DESC', 'Set HTML codes to show in index page');
define('_MI_XMDOC_PREF_FOOTER', 'Footer index page');
define('_MI_XMDOC_PREF_FOOTER_DESC', 'Set HTML codes to show in index page');
define('_MI_XMDOC_PREF_HEAD_OPTIONS', '<span style="font-size: large;  font-weight: bold;">Options</span>');
define('_MI_XMDOC_PREF_GENERALITEMPERPAGE', 'Number of items per page in the general view');
define('_MI_XMDOC_PREF_XMSOCIAL', 'Use xmsocial module to rate document');
define('_MI_XMDOC_PREF_XMSOCIAL_DESC', '');
define('_MI_XMDOC_PREF_CAPTCHA', 'Use Captcha?');
define('_MI_XMDOC_PREF_CAPTCHA_DESC', 'Select Yes to use Captcha in the submit form');
define('_MI_XMDOC_PREF_HEAD_DOWNLOAD', '<span style="font-size: large;  font-weight: bold;">Download</span>');
define('_MI_XMDOC_PREF_CHECKHOST', 'Disallow direct download linking (leeching)?');
define('_MI_XMDOC_PREF_HOST', 'These sites can link directly to your files. Separate each one with "|"');
define('_MI_XMDOC_PREF_HEAD_ADMIN', '<span style="font-size: large;  font-weight: bold;">Administration</span>');
define('_MI_XMDOC_PREF_EDITOR', 'Text Editor');
define('_MI_XMDOC_PREF_ITEMPERPAGE', 'Number of items per page in the administration view');