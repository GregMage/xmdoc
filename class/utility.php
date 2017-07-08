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

/**
 * Class XmdocUtility
 */
class XmdocUtility
{    
    
    public static function FileSizeConvert($size){
        if ($size > 0) {
            $kb = 1024;
            $mb = 1024*1024;
            $gb = 1024*1024*1024;
            if ($size >= $gb) {
                $mysize = sprintf ("%01.2f",$size/$gb) . " " . _MA_XMDOC_UTILITY_GBYTES;
            } elseif ($size >= $mb) {
                $mysize = sprintf ("%01.2f",$size/$mb) . " " . _MA_XMDOC_UTILITY_MBYTES;
            } elseif ($size >= $kb) {
                $mysize = sprintf ("%01.2f",$size/$kb) . " " . _MA_XMDOC_UTILITY_KBYTES;
            } else {
                $mysize = sprintf ("%01.2f",$size) . " " . _MA_XMDOC_UTILITY_BYTES;
            }

            return $mysize;
        } else {
            return '';
        }
    }
        
    public static function MimeToExtension($mimetypes){
        $extensionToMime = include $GLOBALS['xoops']->path('include/mimetypes.inc.php');
        $extensionToMime = array_flip($extensionToMime);
        foreach (array_keys($mimetypes) as $i) {
            $extensions[] = $extensionToMime[$mimetypes[$i]];
        }
        return implode(', ', $extensions);
    }
}
