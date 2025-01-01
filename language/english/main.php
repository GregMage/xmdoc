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

// Button
define('_MA_XMDOC_CATEGORY_ADD', 'Add category');
define('_MA_XMDOC_CATEGORY_LIST', 'Category list');
define('_MA_XMDOC_DOCUMENT_ADD', 'Add a new document');
define('_MA_XMDOC_DOCUMENT_LIST', 'Document list');

// Error message
define('_MA_XMDOC_ERROR_LIMITDOWNLOAD', 'You have downloaded %s files from this category and the limit is %s in 24h');
define('_MA_XMDOC_ERROR_LIMITDOWNLOADITEM', 'You have downloaded this file %s times and the limit is %s in 24h');
define('_MA_XMDOC_ERROR_MODAL', 'Information: The form is not available because the information is detailed in a "modal" window (on the same page)');
define('_MA_XMDOC_ERROR_NACTIVE', 'Error: Disable content!');
define('_MA_XMDOC_ERROR_NOACESSCATEGORY', 'You don\'t have access to any categories');
define('_MA_XMDOC_ERROR_NOCATEGORY', 'There are no categories in the database');
define('_MA_XMDOC_ERROR_NODOCUMENT', 'There are no documents in the database');
define('_MA_XMDOC_ERROR_NOPERMISETOLINK', 'This file does not belong to the website from where you are coming.<br /><br />thanks for writing an email to the webmaster of the website from where you are coming and tell him: <br /><strong>NO OWNERSHIP OF LINKS FROM OTHER SITES! (LEECH)</strong><br /><br /><strong>Leecher definition: </strong>Someone who is lazy to link to its own server or steals the hard work done by other people <br /><br />You are already <strong>registered</strong>.');
define('_MA_XMDOC_ERROR_PERMISSION', 'To use permissions, you must create categories.');
define('_MA_XMDOC_ERROR_WEIGHT', 'Weight must be a number');
define('_MA_XMDOC_ERROR_SIZE', "<span style='color: #FF0000; font-weight: bold;'>The system failed to determine the file size, it is necessary to do it manually.</span>");
define('_MA_XMDOC_ERROR_CATEGORYSIZE', "The size exceeds the maximum values defined in 'post_max_size' or 'upload_max_filesize' in your configuration in php.ini");

// Shared
define('_MA_XMDOC_ADD', 'Add');
define('_MA_XMDOC_ACTION', 'Action');
define('_MA_XMDOC_DEL', 'Delete');
define('_MA_XMDOC_EDIT', 'Edit');
define('_MA_XMDOC_REDIRECT_SAVE', 'Successfully saved');
define('_MA_XMDOC_SEARCH', 'Search an existing document');
define('_MA_XMDOC_STATUS', 'Status');
define('_MA_XMDOC_STATUS_A', 'Active');
define('_MA_XMDOC_STATUS_NA', 'Disabled');
define('_MA_XMDOC_VIEW', 'See the document');

//Index
define('_MA_XMDOC_INDEX_IMAGEINFO', 'Server status');
define('_MA_XMDOC_INDEX_SPHPINI', "<span style='font-weight: bold;'>Information taken from PHP ini file:</span>");
define('_MA_XMDOC_INDEX_ON', "<span style='font-weight: bold;'>ON</span>");
define('_MA_XMDOC_INDEX_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('_MA_XMDOC_INDEX_SERVERUPLOADSTATUS', 'Server uploads status: ');
define('_MA_XMDOC_INDEX_MAXPOSTSIZE', 'Max post size permitted (post_max_size directive in php.ini): ');
define('_MA_XMDOC_INDEX_MAXUPLOADSIZE', 'Max upload size permitted (upload_max_filesize directive in php.ini): ');
define('_MA_XMDOC_INDEX_MEMORYLIMIT', 'Memory limit (memory_limit directive in php.ini): ');
define('_MA_XMDOC_INDEXCONFIG_XMSOCIAL_WARNINGNOTINSTALLED', 'You have not installed the xmsocial module, this module is required if you want to rate documents');
define('_MA_XMDOC_INDEXCONFIG_XMSOCIAL_WARNINGNOTACTIVATE', 'You must enable in xmdoc preferences the use of xmsocial (if you want to rate documents)');

// Category
define('_MA_XMDOC_CATEGORY_COLOR', 'Color');
define('_MA_XMDOC_CATEGORY_DESC', 'Description');
define('_MA_XMDOC_CATEGORY_FORMPATH', 'Files are in: %s');
define('_MA_XMDOC_CATEGORY_LIMITDOWNLOAD', 'Number of downloads in 24 hours<br><small>Number of download for each user in 24 hours. Select 0 for unlimited.</small>');
define('_MA_XMDOC_CATEGORY_LIMITITEM', 'Number of downloads for each file in 24 hours<br><small>Number of downloads for each file in 24 hours by each user. Select 0 for unlimited.</small>');
define('_MA_XMDOC_CATEGORY_LOGO', 'Logo');
define('_MA_XMDOC_CATEGORY_LOGOFILE', 'Logo file');
define('_MA_XMDOC_CATEGORY_EXTENSION', 'Extensions allowed');
define('_MA_XMDOC_CATEGORY_NAME', 'Name');
define('_MA_XMDOC_CATEGORY_RENAME', "Rename documents uploaded?");
define('_MA_XMDOC_CATEGORY_SIZE', 'Maximum upload size');
define('_MA_XMDOC_CATEGORY_SIZEINFO', "The size should not exceed the values of 'post_max_size' and 'upload_max_filesize' in your configuration in php.ini");
define('_MA_XMDOC_CATEGORY_SUREDEL', 'Sure to delete this category? %s');
define('_MA_XMDOC_CATEGORY_UNIT', '[kB]');
define('_MA_XMDOC_CATEGORY_UPLOAD', 'Upload');
define('_MA_XMDOC_CATEGORY_UPLOADSIZE', 'Maximum size: %s kB');
define('_MA_XMDOC_CATEGORY_WARNINGDELARTICLE', '<strong>Warning, the following items will also be removed!</strong>');
define('_MA_XMDOC_CATEGORY_WEIGHT', 'Weight');

// document
define('_MA_XMDOC_DOCUMENT_CATEGORY', 'Category');
define('_MA_XMDOC_DOCUMENT_INCATEGORY', 'In category');
define('_MA_XMDOC_DOCUMENT_DATEUPDATE', 'Update the creation date');
define('_MA_XMDOC_DOCUMENT_DESC', 'Description');
define('_MA_XMDOC_DOCUMENT_DESC_DESC', "Use the <span style='color:orange'>[break]</span> delimiter to define the size of the short description.");
define('_MA_XMDOC_DOCUMENT_DOCUMENT', 'File to attach');
define('_MA_XMDOC_DOCUMENT_DOCUMENTURL', 'Document URL');
define('_MA_XMDOC_DOCUMENT_FORMPATH', 'Files are in: %s');
define('_MA_XMDOC_DOCUMENT_LOGO', 'Logo');
define('_MA_XMDOC_DOCUMENT_LOGOFILE', 'Logo file');
define('_MA_XMDOC_DOCUMENT_MDATEUPDATE', 'Update the modification date');
define('_MA_XMDOC_DOCUMENT_NAME', 'Name');
define('_MA_XMDOC_DOCUMENT_RESETCOUNTER', 'Reset download counter');
define('_MA_XMDOC_DOCUMENT_RESETMDATE', 'Reset (empty date)');
define('_MA_XMDOC_DOCUMENT_SHOWINFO', 'View file information');
define('_MA_XMDOC_DOCUMENT_SIZE', "File Size");
define('_MA_XMDOC_DOCUMENT_SIZE_DSC', "File SizeTo use the automatic system for calculating the file size, leave this field empty.<br>Please note that the automatic size calculation system may not work on files hosted on another server!");
define('_MA_XMDOC_DOCUMENT_SUREDEL', 'Sure to delete this document? %s');
define('_MA_XMDOC_DOCUMENT_UPLOAD', 'Upload');
define('_MA_XMDOC_DOCUMENT_UPLOADSIZE', 'Maximum size: %s kB');
define('_MA_XMDOC_DOCUMENT_USERID', 'Author');
define('_MA_XMDOC_DOCUMENT_WAITING', 'There are <strong>%s</strong> document(s) waiting for validation!');
define('_MA_XMDOC_DOCUMENT_WEIGHT', 'Weight');
define('_MA_XMDOC_DOCUMENT_WFV', 'Waiting for validation');

// permission
define('_MA_XMDOC_PERMISSION_VIEW', 'View Permissions');
define('_MA_XMDOC_PERMISSION_VIEW_DSC', 'Select groups that can view a document in categories');
define('_MA_XMDOC_PERMISSION_VIEW_THIS', 'Select groups that can view in this category');
define('_MA_XMDOC_PERMISSION_SUBMIT', 'Submit permission');
define('_MA_XMDOC_PERMISSION_SUBMIT_DSC', 'Select groups that can submit a document in categories');
define('_MA_XMDOC_PERMISSION_SUBMIT_THIS', 'Select groups that can submit in this category');
define('_MA_XMDOC_PERMISSION_EDITAPPROVE', 'Edit and approve permission');
define('_MA_XMDOC_PERMISSION_EDITAPPROVE_DSC', 'Select groups that can edit and approve a document in categories');
define('_MA_XMDOC_PERMISSION_EDITAPPROVE_THIS', 'Select groups that can edit and approve in this category');
define('_MA_XMDOC_PERMISSION_DELETE', 'Delete permission');
define('_MA_XMDOC_PERMISSION_DELETE_DSC', 'Select groups that can delete a document in categories');
define('_MA_XMDOC_PERMISSION_DELETE_THIS', 'Select groups that can delete in this category');

// about
define('_MA_XMDOC_ABOUT_FILEPROTECTION', "Files Protection");
define('_MA_XMDOC_ABOUT_FILEPROTECTION_INFO1', "To protect your files against unwanted downloads (compared to permissions), you have to create an '.htaccess' file in the folder:");
define('_MA_XMDOC_ABOUT_FILEPROTECTION_INFO2', "With the following content:");

// utility
define('_MA_XMDOC_UTILITY_BYTES', "Bytes");
define('_MA_XMDOC_UTILITY_KBYTES', "kB");
define('_MA_XMDOC_UTILITY_MBYTES', "MB");
define('_MA_XMDOC_UTILITY_GBYTES', "GB");

// formDoc
define('_MA_XMDOC_FORMDOC_ADD', 'Add documents');
define('_MA_XMDOC_FORMDOC_AUTHOR', 'Author');
define('_MA_XMDOC_FORMDOC_DATE', 'Creation date');
define('_MA_XMDOC_FORMDOC_DATE_BT', 'On line');
define('_MA_XMDOC_FORMDOC_DOWNLOAD', 'Downloads');
define('_MA_XMDOC_FORMDOC_MDATE', 'Modification date');
define('_MA_XMDOC_FORMDOC_MDATE_BT', 'Updated');
define('_MA_XMDOC_FORMDOC_NAME', 'Document management');
define('_MA_XMDOC_FORMDOC_REMOVE', 'Remove documents');
define('_MA_XMDOC_FORMDOC_LISTDOCUMENT', 'List of existing documents');
define('_MA_XMDOC_FORMDOC_RATING', 'Rating');
define('_MA_XMDOC_FORMDOC_RESETSELECTED', 'Reset selection');
define('_MA_XMDOC_FORMDOC_VALIDATE', 'validate');
define('_MA_XMDOC_FORMDOC_SELECT', 'Selection');
define('_MA_XMDOC_FORMDOC_SELECTED', 'Selected documents');
define('_MA_XMDOC_FORMDOC_1SELECTED', 'selected document');
define('_MA_XMDOC_FORMDOC_NODOCSELECTED', 'No document selected ...');
define('_MA_XMDOC_FORMDOC_SIZE', "File Size");
define('_MA_XMDOC_FORMDOC_VOTES', '(%s Votes)');
define('_MA_XMDOC_FORMDOC_CHECKLINK', 'Link');
define('_MA_XMDOC_FORMDOC_WARNING', 'Please note that the documents selected here will not be displayed in the original form once this window is closed. No worries, the documents will be saved when validating the original form.');
define('_MA_XMDOC_FORMDOC_1WARNING', 'Please note that the document selected here will not be displayed in the original form once this window is closed. No worries, the document will be saved when validating the original form.');

// user
define('_MA_XMDOC_DOWNLOAD', 'Download');
define('_MA_XMDOC_SELECTCATEGORY', 'Select a category to add an item to');
define('_MA_XMDOC_INDEX_SELECTCATEGORY', 'Select a category to filter documents');

//block
define('_MA_XMDOC_GENINFORMATION', 'General informations');

// Info message
define('_MA_XMDOC_INFO_NEWSDISABLE', 'The document is disabled, you see it because you are allowed to change its status');
define('_MA_XMDOC_INFO_NEWSWAITING', 'The document is pending validation, you see it because you are allowed to change its status');