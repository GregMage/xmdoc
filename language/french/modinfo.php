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
define('_MI_XMDOC_DESC', 'Gestion des documentss');

// submenu
define('_MI_XMDOC_SUB_ADD', 'Soumettre un document');

// Menu
define('_MI_XMDOC_MENU_HOME', 'Index');
define('_MI_XMDOC_MENU_CATEGORY', 'Catégories');
define('_MI_XMDOC_MENU_DOCUMENT', 'Documents');
define('_MI_XMDOC_MENU_PERMISSION', 'Autorisations');
define('_MI_XMDOC_MENU_ABOUT', 'À propos');

// Block
define('_MI_XMDOC_BLOCK_DATE', 'Documents récents');
define('_MI_XMDOC_BLOCK_DATE_DESC', 'Afficher les documents récents');
define('_MI_XMDOC_BLOCK_HITS', 'Top Documents (lectures)');
define('_MI_XMDOC_BLOCK_HITS_DESC', 'Afficher les top documents (lectures)');
define('_MI_XMDOC_BLOCK_RATING', 'Documents les mieux notés');
define('_MI_XMDOC_BLOCK_RATING_DESC', 'Afficher les documents les mieux notés');
define('_MI_XMDOC_BLOCK_RANDOM', 'Documents aléatoires');
define('_MI_XMDOC_BLOCK_RANDOM_DESC', 'Afficher les documents aléatoirement');

// Pref
define('_MI_XMDOC_PREF_HEAD_INDEX', '<span style="font-size: large;  font-weight: bold;">Index</span>');
define('_MI_XMDOC_PREF_HEADER', 'En-tête de la page d\'index');
define('_MI_XMDOC_PREF_HEADER_DESC', 'Utiliser du code HTML pour la mise en page');
define('_MI_XMDOC_PREF_FOOTER', 'Pied de page de la page d\'index');
define('_MI_XMDOC_PREF_FOOTER_DESC', 'Utiliser du code HTML pour la mise en page');
define('_MI_XMDOC_PREF_HEAD_OPTIONS', '<span style="font-size: large;  font-weight: bold;">Options</span>');
define('_MI_XMDOC_PREF_GENERALITEMPERPAGE', 'Nombre d\'éléments par page dans la vue générale');
define('_MI_XMDOC_PREF_XMSOCIAL', 'Utilisez le module xmsocial pour évaluer les documents');
define('_MI_XMDOC_PREF_XMSOCIAL_DESC', '');
define('_MI_XMDOC_PREF_CAPTCHA', 'Utiliser Captcha?');
define('_MI_XMDOC_PREF_CAPTCHA_DESC', 'Sélectionnez Oui pour utiliser Captcha dans le formulaire de soumission.');
define('_MI_XMDOC_PREF_MAXUPLOADSIZE', 'Taille maximale des fichiers uploadé');
define('_MI_XMDOC_PREF_MAXUPLOADSIZE_DESC', 'Cela concerne les logos uploadés pour les catégories et les documents');
define('_MI_XMDOC_PREF_MAXUPLOADSIZE_MBYTES', 'Mb');
define('_MI_XMDOC_PREF_HEAD_DOWNLOAD', '<span style="font-size: large;  font-weight: bold;">Téléchargement</span>');
define('_MI_XMDOC_PREF_CHECKHOST', 'Interdire le téléchargement direct par des liens externes (leeching)?');
define('_MI_XMDOC_PREF_HOST', 'Ces sites peuvent vous lier directement vers vos fichiers. Séparer par un "|"');
define('_MI_XMDOC_PREF_HEAD_ADMIN', '<span style="font-size: large;  font-weight: bold;">Administration</span>');
define('_MI_XMDOC_PREF_EDITOR', 'Éditeur de texte');
define('_MI_XMDOC_PREF_ITEMPERPAGE', 'Nombre d\'éléments par page dans la vue d\'administration');