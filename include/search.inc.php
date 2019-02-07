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

function xmdoc_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = "SELECT document_id, document_category, document_name, document_description, document_date, document_userid FROM " . $xoopsDB->prefix("xmdoc_document") . " WHERE document_status = 1";

    if ( is_array($queryarray) && $count = count($queryarray) )
    {
        $sql .= " AND ((document_name LIKE '%$queryarray[0]%' OR document_description LIKE '%$queryarray[0]%')";

        for($i=1;$i<$count;$i++)
        {
            $sql .= " $andor ";
            $sql .= "(document_name LIKE '%$queryarray[$i]%' OR document_description LIKE '%$queryarray[$i]%')";
        }
        $sql .= ")";
    }

    $sql .= " ORDER BY document_date DESC";
    $result = $xoopsDB->query($sql,$limit,$offset);
    $ret = array();
    $i = 0;
    while($myrow = $xoopsDB->fetchArray($result))
    {
        $ret[$i]["image"] = "assets/images/xmdoc_search.png";
        $ret[$i]["link"] = "download.php?doc_id=" . $myrow["document_id"] . '&cat_id=' . $myrow["document_category"];
        $ret[$i]["title"] = $myrow["document_name"];
        $ret[$i]["time"] = $myrow["document_date"];
        $ret[$i]["uid"] = $myrow["document_userid"];
        $i++;
    }

    return $ret;
}