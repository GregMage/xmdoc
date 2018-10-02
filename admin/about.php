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

use Xmf\Module\Admin;

require __DIR__ . '/admin_header.php';

$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('about.php');
Admin::setPaypal('9MYQB7GUK5MCS');
// file protection
$xoops_url = parse_url(XOOPS_URL);
$xoops_url = str_replace ('www.','', $xoops_url['host']);
$file_protection = _MA_XMDOC_ABOUT_FILEPROTECTION_INFO1 . "<br /><br />" . XOOPS_ROOT_PATH . "/uploads/xmdoc/documents/" . "<br /><br />" . _MA_XMDOC_ABOUT_FILEPROTECTION_INFO2 . "<br /><br />";
$file_protection .= "RewriteEngine on" . "<br />" . "RewriteCond %{HTTP_REFERER} !" . $xoops_url . "/.*$ [NC]<br />ReWriteRule \.*$ - [F]";
$moduleAdmin->addInfoBox(_MA_XMDOC_ABOUT_FILEPROTECTION);
$moduleAdmin->addInfoBoxLine($file_protection);
$moduleAdmin->displayAbout(false);

require __DIR__ . '/admin_footer.php';
