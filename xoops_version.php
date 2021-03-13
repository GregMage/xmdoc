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
$modversion['dirname']     = basename(__DIR__);
$modversion['name']        = ucfirst(basename(__DIR__));
$modversion['version']     = '1.2';
$modversion['description'] = _MI_XMDOC_DESC;
$modversion['author']      = 'Grégory Mage (Mage)';
$modversion['url']         = 'https://github.com/GregMage';
$modversion['credits']     = 'Mage';

$modversion['help']        = 'page=help';
$modversion['license']     = 'GNU GPL 2 or later';
$modversion['license_url'] = 'http://www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']    = 0;
$modversion['image']       = 'assets/images/xmdoc_logo.png';

// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][] = array(
    'name' => _MI_XMDOC_SUB_ADD,
    'url'  => 'action.php?op=add'
);

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'xmdoc_search';

// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Install and update
$modversion['onInstall']        = 'include/install.php';
//$modversion['onUpdate']         = 'include/update.php';

// Tables
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';

$modversion['tables'][1] = 'xmdoc_category';
$modversion['tables'][2] = 'xmdoc_document';
$modversion['tables'][3] = 'xmdoc_docdata';
$modversion['tables'][4] = 'xmdoc_downlimit';

// Admin Templates
$modversion['templates'][] = array('file' => 'xmdoc_admin_category.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmdoc_admin_document.tpl', 'description' => '', 'type' => 'admin');
$modversion['templates'][] = array('file' => 'xmdoc_admin_permission.tpl', 'description' => '', 'type' => 'admin');

// User Templates
$modversion['templates'][] = array('file' => 'xmdoc_docmanager.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmdoc_viewdoc.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmdoc_action.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmdoc_index.tpl', 'description' => '');
$modversion['templates'][] = array('file' => 'xmdoc_document.tpl', 'description' => '');

// Blocks
$modversion['blocks'][] = array(
    'file'        => 'xmdoc_blocks.php',
    'name'        => _MI_XMDOC_BLOCK_DATE,
    'description' => _MI_XMDOC_BLOCK_DATE_DESC,
    'show_func'   => 'block_xmdoc_show',
    'edit_func'   => 'block_xmdoc_edit',
	'options'     => '0|5|date',
    'template'    => 'xmdoc_block.tpl'
);
$modversion['blocks'][] = array(
    'file'        => 'xmdoc_blocks.php',
    'name'        => _MI_XMDOC_BLOCK_HITS,
    'description' => _MI_XMDOC_BLOCK_HITS_DESC,
    'show_func'   => 'block_xmdoc_show',
    'edit_func'   => 'block_xmdoc_edit',
	'options'     => '0|5|hits',
    'template'    => 'xmdoc_block.tpl'
);
$modversion['blocks'][] = array(
    'file'        => 'xmdoc_blocks.php',
    'name'        => _MI_XMDOC_BLOCK_RATING,
    'description' => _MI_XMDOC_BLOCK_RATING_DESC,
    'show_func'   => 'block_xmdoc_show',
    'edit_func'   => 'block_xmdoc_edit',
	'options'     => '0|5|rating',
    'template'    => 'xmdoc_block.tpl'
);
$modversion['blocks'][] = array(
    'file'        => 'xmdoc_blocks.php',
    'name'        => _MI_XMDOC_BLOCK_RANDOM,
    'description' => _MI_XMDOC_BLOCK_RANDOM_DESC,
    'show_func'   => 'block_xmdoc_show',
    'edit_func'   => 'block_xmdoc_edit',
	'options'     => '0|5|random',
    'template'    => 'xmdoc_block.tpl'
);

// Configs
$modversion['config'] = array();

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMDOC_PREF_HEAD_INDEX',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'index_header',
    'title'       => '_MI_XMDOC_PREF_HEADER',
    'description' => '_MI_XMDOC_PREF_HEADER_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => ''
);

$modversion['config'][] = array(
    'name'        => 'index_footer',
    'title'       => '_MI_XMDOC_PREF_FOOTER',
    'description' => '_MI_XMDOC_PREF_FOOTER_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => ''
);

$optionindexcat[_MI_XMDOC_PREF_INDEXCAT_A] = 1;
$optionindexcat[_MI_XMDOC_PREF_INDEXCAT_B] = 2;
$optionindexcat[_MI_XMDOC_PREF_INDEXCAT_C] = 3;
$modversion['config'][] = [
    'name'        => 'index_cat',
    'title'       => '_MI_XMDOC_PREF_INDEXCAT',
    'description' => '_MI_XMDOC_PREF_INDEXCAT_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 1,
	'options' => $optionindexcat,
];

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMDOC_PREF_HEAD_OPTIONS',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'general_usemodal',
    'title'       => '_MI_XMDOC_PREF_GENERALUSEMODAL',
    'description' => '_MI_XMDOC_PREF_GENERALUSEMODAL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1
);

$modversion['config'][] = array(
    'name'        => 'general_perpage',
    'title'       => '_MI_XMDOC_PREF_GENERALITEMPERPAGE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15
);

xoops_load('xoopseditorhandler');
$editorHandler = XoopsEditorHandler::getInstance();
$modversion['config'][] = array(
    'name'        => 'general_editor',
    'title'       => '_MI_XMDOC_PREF_EDITOR',
    'description' => '',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'default'     => 'dhtmltextarea',
    'options'     => array_flip($editorHandler->getList())
);

$modversion['config'][] = array(
    'name'        => 'general_xmsocial',
    'title'       => '_MI_XMDOC_PREF_XMSOCIAL',
    'description' => '_MI_XMDOC_PREF_XMSOCIAL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0
);

$modversion['config'][] = array(
    'name'        => 'general_captcha',
    'title'       => '_MI_XMDOC_PREF_CAPTCHA',
    'description' => '_MI_XMDOC_PREF_CAPTCHA_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0
);

$optionMaxsize['0.1 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 104858;
$optionMaxsize['0.5 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 1024*1024*0.5;
$optionMaxsize['1 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 1024*1024*1;
$optionMaxsize['1.5 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 1024*1024*1.5;
$optionMaxsize['2 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 1024*1024*2;
$optionMaxsize['5 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 1024*1024*5;
$optionMaxsize['10 ' . _MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES] = 1024*1024*10;
$modversion['config'][] = [
    'name'        => 'general_maxuploadsize',
    'title'       => '_MI_XMDOC_PREF_MAXUPLOADSIZE',
    'description' => '_MI_XMDOC_PREF_MAXUPLOADSIZE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 104858,
	'options' => $optionMaxsize,
];

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMDOC_PREF_HEAD_DOWNLOAD',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'download_checkhost',
    'title'       => '_MI_XMDOC_PREF_CHECKHOST',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
);

$xoops_url = parse_url(XOOPS_URL);
$modversion['config'][] = array(
    'name'        => 'download_host',
    'title'       => '_MI_XMDOC_PREF_HOST',
    'description' => '',
    'formtype'    => 'textarea',
    'valuetype'   => 'array',
    'default'     => array($xoops_url['host']),
);

$modversion['config'][] = array(
    'name'        => 'break',
    'title'       => '_MI_XMDOC_PREF_HEAD_ADMIN',
    'description' => '',
    'formtype'    => 'line_break',
    'valuetype'   => 'text',
    'default'     => 'head',
);

$modversion['config'][] = array(
    'name'        => 'admin_perpage',
    'title'       => '_MI_XMDOC_PREF_ITEMPERPAGE',
    'description' => '',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 15
);

// About stuff
$modversion['module_status'] = 'Alpha';
$modversion['release_date']  = '2021/03/21';

$modversion['developer_lead']      = 'Mage';
$modversion['module_website_url']  = 'www.monxoops.fr/';
$modversion['module_website_name'] = 'MonXoops';

$modversion['min_xoops'] = '2.5.10';
$modversion['min_php']   = '7.0';
$modversion['min_db']    = ['mysql' => '5.5'];
