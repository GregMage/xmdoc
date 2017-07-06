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
use Xmf\Request;

require __DIR__ . '/admin_header.php';
include_once XOOPS_ROOT_PATH.'/class/xoopsform/grouppermform.php';
$moduleAdmin = Admin::getInstance();
$moduleAdmin->displayNavigation('permission.php');

// Get permission
$permission = Request::getInt('permission', 1);

// Category
$criteria = new CriteriaCompo();
$category_arr = $categoryHandler->getall($criteria);
if (count($category_arr) > 0) {
    $tab_perm = array(1 => _MA_XMDOC_PERMISSION_VIEW, 2 => _MA_XMDOC_PERMISSION_SUBMIT);
}
if (isset($tab_perm)){
    $permission_options = '';
    foreach (array_keys($tab_perm) as $i) {
        $permission_options .= '<option value="' . $i . '"' . ($permission == $i ? ' selected="selected"' : '') . '>' . $tab_perm[$i] . '</option>';
    }
    $xoopsTpl->assign('permission_options', $permission_options);

    switch ($permission) {
        case 1:    // View permission
            $formTitle = _MA_XMDOC_PERMISSION_VIEW;
            $permissionName = 'xmdoc_view';
            $permissionDescription = _MA_XMDOC_PERMISSION_VIEW_DSC;
            foreach (array_keys($category_arr) as $i) {
                $global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
            }
            break;

        case 2:    // Submit permission
            $formTitle = _MA_XMDOC_PERMISSION_SUBMIT;
            $permissionName = 'xmdoc_submit';
            $permissionDescription = _MA_XMDOC_PERMISSION_SUBMIT_DSC;
            foreach (array_keys($category_arr) as $i) {
                $global_perms_array[$i] = $category_arr[$i]->getVar('category_name');
            }
            break;
    }
    $permissionsForm = new XoopsGroupPermForm($formTitle, $helper->getModule()->getVar('mid'), $permissionName, $permissionDescription, 'admin/permission.php?permission=' . $permission);
    foreach ($global_perms_array as $perm_id => $permissionName) {
        $permissionsForm->addItem($perm_id , $permissionName) ;
    }
    $xoopsTpl->assign('form', $permissionsForm->render());
} else {
    $xoopsTpl->assign('error_message', _MA_XMDOC_ERROR_PERMISSION);
}
$xoopsTpl->display("db:xmdoc_admin_permission.tpl");

require __DIR__ . '/admin_footer.php';
