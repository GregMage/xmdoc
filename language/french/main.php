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
define('_MA_XMDOC_CATEGORY_ADD', 'Ajout d\'une catégorie');
define('_MA_XMDOC_CATEGORY_LIST', 'Liste des catégories');
define('_MA_XMDOC_DOCUMENT_ADD', 'Ajout d\'un document');
define('_MA_XMDOC_DOCUMENT_LIST', 'Liste des documents');

// Error message
define('_MA_XMDOC_ERROR_LIMITDOWNLOAD', 'Vous avez téléchargé %s fichiers dans cette catégorie et la limite est de %s en 24h');
define('_MA_XMDOC_ERROR_LIMITDOWNLOADITEM', 'Vous avez téléchargé ce fichier %s fois et la limite est de %s en 24h');
define('_MA_XMDOC_ERROR_NACTIVE', 'Erreur : Contenu désactivé!');
define('_MA_XMDOC_ERROR_NOACESSCATEGORY', 'Vous n\'avez accès à aucune catégorie');
define('_MA_XMDOC_ERROR_NOCATEGORY', 'Il n\'y a pas de catégories dans la base de données');
define('_MA_XMDOC_ERROR_NODOCUMENT', 'Il n\'y a aucun document dans la base de données');
define('_MA_XMDOC_ERROR_NOPERMISETOLINK', 'Ce fichier n\'appartient pas au site d\'où vous venez.<br><br>Merci d\'écrire un courrier électronique au webmestre du site d\'où vous venez et dites-lui : <br><strong>VOUS N\'ÊTES PAS PROPRIÉTAIRE DE LIENS PROVENANT D\'AUTRES SITES ! (LEECH)</strong><br><strong>Définition de leecher : </strong> Quelqu\'un qui est trop paresseux pour afficher et héberger des liens sur son propre serveur ou vole le dur travail fait par d\'autres personnes.<br><br><strong>Vous êtes déjà enregistré</strong>');
define('_MA_XMDOC_ERROR_PERMISSION', 'Pour utiliser des autorisations, vous devez créer des catégories.');
define('_MA_XMDOC_ERROR_WEIGHT', 'Le poids doit être un nombre');
define('_MA_XMDOC_ERROR_SIZE', "<span style='color: #FF0000; font-weight: bold;'>Le système n'a pas pu déterminer la taille du fichier, il est nécessaire de le faire manuellement.</span>");
define('_MA_XMDOC_ERROR_CATEGORYSIZE', "La taille dépasse les valeurs maximales définies dans 'post_max_size' ou 'upload_max_filesize' dans votre configuration php.ini");

// Shared
define('_MA_XMDOC_ADD', 'Ajout');
define('_MA_XMDOC_ACTION', 'Action');
define('_MA_XMDOC_DEL', 'Effacer');
define('_MA_XMDOC_EDIT', 'Modifier');
define('_MA_XMDOC_REDIRECT_SAVE', 'Enregistré avec succès');
define('_MA_XMDOC_SEARCH', 'Rechercher un document');
define('_MA_XMDOC_STATUS', 'Statut');
define('_MA_XMDOC_STATUS_A', 'Activé');
define('_MA_XMDOC_STATUS_NA', 'Désactivé');
define('_MA_XMDOC_VIEW', 'Afficher');

//Index
define('_MA_XMDOC_INDEX_IMAGEINFO', 'Statut du serveur');
define('_MA_XMDOC_INDEX_SPHPINI', "<span style='font-weight: bold;'>Informations extraites du fichier PHP ini :</span>");
define('_MA_XMDOC_INDEX_ON', "<span style='font-weight: bold;'>ON</span>");
define('_MA_XMDOC_INDEX_OFF', "<span style='font-weight: bold;'>OFF</span>");
define('_MA_XMDOC_INDEX_SERVERUPLOADSTATUS', 'État des téléchargements du serveur : ');
define('_MA_XMDOC_INDEX_MAXPOSTSIZE', 'Taille de publication maximale autorisée (directive post_max_size dans php.ini) : ');
define('_MA_XMDOC_INDEX_MAXUPLOADSIZE', 'Taille de téléchargement maximale autorisée (directive upload_max_filesize dans php.ini) : ');
define('_MA_XMDOC_INDEX_MEMORYLIMIT', 'Limite de mémoire (directive memory_limit dans php.ini) : ');
define('_MA_XMDOC_INDEXCONFIG_XMSOCIAL_WARNINGNOTINSTALLED', 'Vous n\'avez pas installé le module xmsocial, ce module est obligatoire si vous souhaitez évaluer des documents');
define('_MA_XMDOC_INDEXCONFIG_XMSOCIAL_WARNINGNOTACTIVATE', 'Vous devez activer dans les préférences de xmdoc l\'utilisation de xmsocial (si vous souhaitez évaluer des documents)');

// Category
define('_MA_XMDOC_CATEGORY_DESC', 'Description');
define('_MA_XMDOC_CATEGORY_FORMPATH', 'Les fichiers sont dans : %s');
define('_MA_XMDOC_CATEGORY_LIMITDOWNLOAD', 'Nombre de téléchargements en 24 heures <br> <small> Nombre de téléchargements pour chaque utilisateur en 24 heures. Sélectionnez 0 pour illimité. </small>');
define('_MA_XMDOC_CATEGORY_LIMITITEM', 'Nombre de téléchargements pour chaque fichier en 24 heures <br> <small> Nombre de téléchargements pour chaque fichier en 24 heures par utilisateur. Sélectionnez 0 pour illimité. </small>');
define('_MA_XMDOC_CATEGORY_LOGO', 'Logo de la catégorie');
define('_MA_XMDOC_CATEGORY_LOGOFILE', 'Fichier de logo');
define('_MA_XMDOC_CATEGORY_EXTENSION', 'Extensions autorisées');
define('_MA_XMDOC_CATEGORY_NAME', 'Nom');
define('_MA_XMDOC_CATEGORY_RENAME', "Renommez les documents téléchargés ? <br> <span style = 'font-size: small;'> Si l'option est non et que vous avez téléchargé un fichier avec un nom qui existe déjà sur le serveur, il sera écrasé </span>");
define('_MA_XMDOC_CATEGORY_SIZE', 'Taille de téléchargement maximale');
define('_MA_XMDOC_CATEGORY_SIZEINFO', "La taille ne doit pas dépasser les valeurs de 'post_max_size' et 'upload_max_filesize' dans votre configuration dans php.ini");
define('_MA_XMDOC_CATEGORY_SUREDEL', 'Voulez-vous vraiment supprimer cette catégorie? %s');
define('_MA_XMDOC_CATEGORY_UNIT', '[kB]');
define('_MA_XMDOC_CATEGORY_UPLOAD', 'Upload');
define('_MA_XMDOC_CATEGORY_UPLOADSIZE', 'Taille maximum : %s Kb');
define('_MA_XMDOC_CATEGORY_WARNINGDELARTICLE', '<strong> Attention, les éléments suivants seront également supprimés! </strong>');
define('_MA_XMDOC_CATEGORY_WEIGHT', 'Poids');

// document
define('_MA_XMDOC_DOCUMENT_CATEGORY', 'Dans la catégorie');
define('_MA_XMDOC_DOCUMENT_DATEUPDATE', 'Mettre à jour la date de création');
define('_MA_XMDOC_DOCUMENT_DESC', 'Description');
define('_MA_XMDOC_DOCUMENT_DOCUMENT', 'Fichier à joindre');
define('_MA_XMDOC_DOCUMENT_DOCUMENTURL', 'URL du document');
define('_MA_XMDOC_DOCUMENT_FORMPATH', 'Les fichiers sont dans :  %s');
define('_MA_XMDOC_DOCUMENT_LOGO', 'Logo du document');
define('_MA_XMDOC_DOCUMENT_LOGOFILE', 'Fichier de logo');
define('_MA_XMDOC_DOCUMENT_MDATEUPDATE', 'Mettre à jour la date de modification');
define('_MA_XMDOC_DOCUMENT_NAME', 'Nom');
define('_MA_XMDOC_DOCUMENT_RESETCOUNTER', 'Réinitialiser le compteur de téléchargement');
define('_MA_XMDOC_DOCUMENT_RESETMDATE', 'Réinitialiser (date vide)');
define('_MA_XMDOC_DOCUMENT_SHOWINFO', 'Afficher les informations sur le fichier');
define('_MA_XMDOC_DOCUMENT_SIZE', "Taille du fichier<br><span style='font-size: small;'>Pour utiliser le système automatique de calcul de la taille du fichier, laissez ce champ vide.</span>");
define('_MA_XMDOC_DOCUMENT_SUREDEL', 'Voulez-vous vraiment supprimer ce document? %s');
define('_MA_XMDOC_DOCUMENT_UPLOAD', 'Upload');
define('_MA_XMDOC_DOCUMENT_UPLOADSIZE', 'Taille maximum : %s Ko');
define('_MA_XMDOC_DOCUMENT_USERID', 'Auteur');
define('_MA_XMDOC_DOCUMENT_WEIGHT', 'Poids');

// permission
define('_MA_XMDOC_PERMISSION_VIEW', 'Autorisation de voir');
define('_MA_XMDOC_PERMISSION_VIEW_DSC', 'Choisissez les groupes qui peuvent voir un document dans ces catégories');
define('_MA_XMDOC_PERMISSION_VIEW_THIS', 'Sélectionnez les groupes pouvant voir un document dans ces catégories');
define('_MA_XMDOC_PERMISSION_SUBMIT', 'Autorisation de soumettre');
define('_MA_XMDOC_PERMISSION_SUBMIT_DSC', 'Sélectionnez les groupes pouvant soumettre des articles dans ces catégories');
define('_MA_XMDOC_PERMISSION_SUBMIT_THIS', 'Sélectionnez les groupes pouvant soumettre dans ces catégorie');
define('_MA_XMDOC_PERMISSION_EDITAPPROVE', 'Autorisation de modifier et d\'aprouver');
define('_MA_XMDOC_PERMISSION_EDITAPPROVE_DSC', 'Sélectionnez les groupes pouvant éditer et aprouver des articles dans ces catégories');
define('_MA_XMDOC_PERMISSION_EDITAPPROVE_THIS', 'Sélectionnez les groupes pouvant éditer et aprouver dans ces catégorie');
define('_MA_XMDOC_PERMISSION_DELETE', 'Autorisation de supprimer');
define('_MA_XMDOC_PERMISSION_DELETE_DSC', 'Sélectionnez les groupes pouvant supprimer des articles dans ces catégories');
define('_MA_XMDOC_PERMISSION_DELETE_THIS', 'Sélectionnez les groupes pouvant supprimer dans ces catégories');

// about
define('_MA_XMDOC_ABOUT_FILEPROTECTION', "Protection des fichiers");
define('_MA_XMDOC_ABOUT_FILEPROTECTION_INFO1', "Pour protéger vos fichiers contre les téléchargements indésirables (par rapport aux autorisations), vous devez créer un fichier '.htaccess' dans le dossier : ");
define('_MA_XMDOC_ABOUT_FILEPROTECTION_INFO2', "Avec le contenu suivant : ");

// utility
define('_MA_XMDOC_UTILITY_BYTES', "Octets");
define('_MA_XMDOC_UTILITY_KBYTES', "Ko");
define('_MA_XMDOC_UTILITY_MBYTES', "Mo");
define('_MA_XMDOC_UTILITY_GBYTES', "Go");

// formDoc
define('_MA_XMDOC_FORMDOC_ADD', 'Ajouter des documents');
define('_MA_XMDOC_FORMDOC_AUTHOR', 'Auteur ');
define('_MA_XMDOC_FORMDOC_DATE', 'Date de création ');
define('_MA_XMDOC_FORMDOC_DOWNLOAD', 'Téléchargements ');
define('_MA_XMDOC_FORMDOC_MDATE', 'Date de modification ');
define('_MA_XMDOC_FORMDOC_NAME', 'Gestion de documents');
define('_MA_XMDOC_FORMDOC_REMOVE', 'Supprimer des documents');
define('_MA_XMDOC_FORMDOC_LISTDOCUMENT', 'Liste des documents');
define('_MA_XMDOC_FORMDOC_RATING', 'Évaluation');
define('_MA_XMDOC_FORMDOC_RESETSELECTED', 'Réinitialiser les documents sélectionnés');
define('_MA_XMDOC_FORMDOC_SELECT', 'Sélectionner');
define('_MA_XMDOC_FORMDOC_SELECTED', 'Documents sélectionnés');
define('_MA_XMDOC_FORMDOC_SIZE', "Taille du fichier ");
define('_MA_XMDOC_FORMDOC_VOTES', '(%s Votes)');

// user
define('_MA_XMDOC_DOWNLOAD', 'Télécharger');
define('_MA_XMDOC_SELECTCATEGORY', 'Sélectionnez une catégorie à laquelle ajouter un document');
define('_MA_XMDOC_INDEX_SELECTCATEGORY', 'Sélectionnez une catégorie pour filtrer les documents');

//block
define('_MA_XMDOC_GENINFORMATION', 'Informations générales');