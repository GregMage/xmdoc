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
use Xmf\Module\Admin; 

require __DIR__ . '/admin_header.php';

$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('index.php');
$moduleAdmin->addConfigModuleVersion('system', '2.1.2');
// xmsocial
if (xoops_isActiveModule('xmsocial')){
	if ($helper->getConfig('general_xmsocial', 0) == 1){
		$moduleAdmin->addConfigModuleVersion('xmsocial', '2.1.0');
	} else {
		$moduleAdmin->addConfigWarning(_MA_XMDOC_INDEXCONFIG_XMSOCIAL_WARNINGNOTACTIVATE);
	}	
} else {
	$moduleAdmin->addConfigWarning(_MA_XMDOC_INDEXCONFIG_XMSOCIAL_WARNINGNOTINSTALLED);
}

$folder[] = $path_logo_category;
$folder[] = $path_logo_document;
$folder[] = $path_document;
foreach (array_keys( $folder) as $i) {
    $moduleAdmin->addConfigBoxLine($folder[$i], 'folder');
    $moduleAdmin->addConfigBoxLine(array($folder[$i], '777'), 'chmod');
}
$moduleAdmin->displayIndex();

echo XmdocUtility::getServerStats();
require __DIR__ . '/admin_footer.php';