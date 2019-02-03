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
use Xmf\Request;
use Xmf\Module\Helper;

require_once dirname(dirname(__DIR__)) . '/mainfile.php';

include __DIR__ . '/include/common.php';
xoops_load('utility', basename(__DIR__));

$helper     = Helper::getHelper('xmdoc');
$permHelper = new \Xmf\Module\Helper\Permission();

$cat_id = Request::getInt('cat_id', 0);
$doc_id  = Request::getInt('doc_id', 0);

// Checking access
if ($cat_id == 0) {
    redirect_header(XOOPS_URL, 2, _MA_XMDOC_ERROR_NOCATEGORY);
}
// permission to view
$permHelper->checkPermissionRedirect('xmdoc_view', $cat_id, 'index.php', 2, _NOPERM);
if ($doc_id == 0) {
    redirect_header(XOOPS_URL, 2, _MA_XMDOC_ERROR_NODOCUMENT);
}
$category = $categoryHandler->get($cat_id);
$document = $documentHandler->get($doc_id);
if (empty($category)) {
    redirect_header(XOOPS_URL, 2, _MA_XMDOC_ERROR_NOCATEGORY);
}
if (empty($document)) {
    redirect_header(XOOPS_URL, 2, _MA_XMDOC_ERROR_NODOCUMENT);
}
if ($category->getVar('category_status') == 0 || $document->getVar('document_status') == 0) {
    redirect_header(XOOPS_URL, 2, _MA_XMDOC_ERROR_NACTIVE);
}

//check download limit download
if ($category->getVar('category_limitdownload') != 0){
    $limitdownload = $category->getVar('category_limitdownload');
    $yesterday = time() - 86400; //24hrs    
    $criteria = new CriteriaCompo();
    if ($xoopsUser) {
        $criteria->add(new Criteria('downlimit_uid', $xoopsUser->getVar('uid') , '='));
    } else {
        $criteria->add(new Criteria('downlimit_hostname', getenv("REMOTE_ADDR"), '='));
    }
    $criteria->add(new Criteria('downlimit_date', $yesterday , '>'));
    $criteria->add(new Criteria('downlimit_catid', $cat_id , '='));
    $downlimit_count = $downlimitHandler->getCount($criteria);
    if ($downlimit_count >= $limitdownload) {
        redirect_header(XOOPS_URL, 5, sprintf(_MA_XMDOC_ERROR_LIMITDOWNLOAD, $downlimit_count, $limitdownload));
    }    
}

//check download limit item
if ($category->getVar('category_limititem') != 0){
    $limititem = $category->getVar('category_limititem');
    $yesterday = time() - 86400; //24hrs    
    $criteria = new CriteriaCompo();
    if ($xoopsUser) {
        $criteria->add(new Criteria('downlimit_uid', $xoopsUser->getVar('uid') , '='));
    } else {
        $criteria->add(new Criteria('downlimit_hostname', getenv("REMOTE_ADDR"), '='));
    }
    $criteria->add(new Criteria('downlimit_date', $yesterday , '>'));
    $criteria->add(new Criteria('downlimit_docid', $doc_id , '='));
    $downlimit_count = $downlimitHandler->getCount($criteria);
    if ($downlimit_count >= $limititem) {
        redirect_header(XOOPS_URL, 5, sprintf(_MA_XMDOC_ERROR_LIMITDOWNLOADITEM, $downlimit_count, $limititem));
    }    
}

// save information to limit downloading 
if ($category->getVar('category_limitdownload') != 0 || $category->getVar('category_limititem') != 0){
    $obj = $downlimitHandler->create();
    $obj->setVar('downlimit_docid', $doc_id);
    $obj->setVar('downlimit_catid', $cat_id);
    $obj->setVar('downlimit_uid', !empty($xoopsUser) ? $xoopsUser->getVar('uid') : 0);
    $obj->setVar('downlimit_hostname', getenv("REMOTE_ADDR"));
    $obj->setVar('downlimit_date', time());
    $downlimitHandler->insert($obj) or $obj->getHtmlErrors();
}



// checkhost
if ($helper->getConfig('download_checkhost', 0) == 1) {
    $goodhost      = false;
    $referer       = parse_url(xoops_getenv('HTTP_REFERER'));
    $referer_host  = $referer['host'];
    $host          = $helper->getConfig('download_host');
    foreach ($host as $ref) {
        if ( !empty($ref) && preg_match("/".$ref."/i", $referer_host) ) {
            $goodhost = true;
            break;
        }
    }
    if ($goodhost == false) {
        redirect_header(XOOPS_URL, 30, _MA_XMDOC_ERROR_NOPERMISETOLINK);
    }
}

//counter
$sql = 'UPDATE ' . $xoopsDB->prefix('xmdoc_document') . ' SET document_counter=document_counter+1 WHERE document_id = ' . $doc_id;
$xoopsDB->queryF($sql);

$url = XmdocUtility::formatURL($document->getVar('document_document'));
$contentLength = XmdocUtility::StringSizeConvert($document->getVar('document_size'));
Header("Content-Length: $contentLength");
Header("Location: $url");
exit();