<?php
//////////////////////////////////////////////////////////////////////////////////
//                                                                              //
//    MG2                                                                       //
//    A PHP/HTML based image gallery script.                                    //
//                                                                              //
//    Copyright 2005 by Thomas Rybak                                            //
//    http://www.minigal.dk                                                     //
//    support@minigal.dk                                                        //
//                                                                              //
//    The script utilises Exif reader v 1.2 (free to use)                       //
//    Exif reader v 1.2                                                         //
//    By Richard James Kendall (richard@richardjameskendall.com)                //
//                                                                              //
//    -----------------                                                         //
//                                                                              //
//    MG2 is free software; you can redistribute it and/or modify               //
//    it under the terms of the GNU General Public License as published by      //
//    the Free Software Foundation; either version 2 of the License, or         //
//    (at your option) any later version.                                       //
//                                                                              //
//    MG2 is distributed in the hope that it will be useful,                    //
//    but WITHOUT ANY WARRANTY; without even the implied warranty of            //
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the              //
//    GNU General Public License for more details.                              //
//                                                                              //
//    TO COMPLY WITH THIS LICENSE, DO NOT REMOVE THE LINK TO THE MINIGAL        //
//    WEBSITE FROM YOUR GALLERY FRONT PAGE. THIS IS THE LEAST YOU CAN DO TO     //
//    SUPPORT THE DEVELOPMENT OF MG2!                                           //
//                                                                              //
//    You should have received a copy of the GNU General Public License         //
//    along with this program; if not, you can find it here:                    //
//    http://www.gnu.org/copyleft/gpl.html                                      //
//                                                                              //
//    -----------------                                                         //
//                                                                              //
//    If you find this script useful, please make a donation via the main       //
//    website:                                                                  //
//                          http://www.minigal.dk                               //
//                                                                              //
//////////////////////////////////////////////////////////////////////////////////

// DISPLAY ERRORS BUT HIDE NOTICES
@error_reporting(E_ALL ^ E_NOTICE);

//SET PHP ARGUMENT SEPERATOR ON '&AMP'
@ini_set('arg_separator.output','&amp;');

// Harden the session cookie used by protected gallery folders.
$secure_cookie = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
@ini_set('session.use_strict_mode', '1');
session_set_cookie_params(array(
	'lifetime' => 0,
	'path' => '/',
	'secure' => $secure_cookie,
	'httponly' => true,
	'samesite' => 'Lax'
));
session_start();

//
// DEFINE SCRIPT CONSTANS
// kh_mod 0.2.0, add
define('PRE_SESSION',  'mg2'. (string)crc32(__FILE__));
define('DATA_FOLDER',  dirname(__FILE__) .'/data/');
define('ADMIN_FOLDER', 'admin/');

//
// LOGOUT ALL FOLDER (GALLERY)
// kh_mod 0.1.0, add
$logoutmsg = '';
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout') {
	unset($_SESSION[PRE_SESSION.'folderpwd']);
	$logoutmsg = '1';
}

// TRIGGER INSTALLATION
if (!is_file(DATA_FOLDER .'mg2_settings.php')) {
	@include('mg2_install.php');
	exit();
}

// MAKE NEW DATABASE OBJECT
@include('includes/mg2_functions.php');
$mg2 = new mg2db;

// BASIC SETTINGS
$mg2->imagefolder = 'pictures';
$mg2->extendedset = '28';	// 0, 0, 1, 1, 1
$mg2->commentsets =  '6';	// 0, 1, 1, 0
$mg2->showexif    =  '0';

// READ FILE SETTINGS
@include('includes/mg2_version.php');
@include(DATA_FOLDER .'mg2_settings.php');

//
// CHECK LANGUAGE
// kh_mod 0.1.0 rc1, changed
$selectlang = $_SESSION[PRE_SESSION.'selectlang'];
if (isset($_GET['ln']) && strlen($_GET['ln']) == 2) {
	switch ($_GET['ln']) {
		// ISO 639-1
		case 'en': $selectlang = 'english.php';	break;
		case 'de': $selectlang = 'german.php';		break;
		case 'fr': $selectlang = 'french.php';		break;
		case 'sv': $selectlang = 'swedish.php';	break;
		case 'el': $selectlang = 'greek.php';		break;
		case 'sr': $selectlang = 'srpski.php';		break;
		case 'lt': $selectlang = 'lithuan.php';	break;
		case 'ro': $selectlang = 'romanian.php';	break;
		case 'es': $selectlang = 'spanish.php';	break;
	}
}
do {
	if ($mg2->checkLanguage($selectlang))	break;
	$selectlang = $_SESSION[PRE_SESSION.'selectlang'];
	if ($mg2->checkLanguage($selectlang))	break;
	$selectlang = $mg2->defaultlang;
	if ($mg2->checkLanguage($selectlang))	break;
	$selectlang = 'english.php';
	if ($mg2->checkLanguage($selectlang))	break;
	$mg2->status = 'The language "'. ucfirst(substr($mg2->defaultlang,0,-4));
	$mg2->status.= '" is not available!';
}
while(0);

// SET AND LOAD LANGUAGE
$_SESSION[PRE_SESSION.'selectlang'] = $selectlang;	@include('lang/'. $selectlang);

// SET HEADERS TO PREVENT BROWSER CACHING OF PAGES
@header('Content-Type: text/html; charset='.$mg2->charset);
@header('Expires: Mon, 20 Jul 2000 05:00:00 GMT');

//
// SKIN SETTINGS
//  kh_mod 0.2.0, changed
$skinpath = 'skins/'. $mg2->activeskin .'/';
if (!is_readable($skinpath .'templates')) {
	$message = (empty($mg2->activeskin))?
				  'There isn\'t any installed skin!'
				  :
				  'The skin "'. ucfirst($mg2->activeskin) .'" is not available!';
	include(ADMIN_FOLDER .'fatal_error.php');
	exit();
}
if (is_readable($skinpath .'settings.php')) {
	include($skinpath .'settings.php');
}

//
// READ DATABASE FOR GALLERY
//  kh_mod 0.2.0, changed
$mg2->readDB();

//
// FOR THE LINK COMPATIBILITY WITH MG2 AND kh_mod 0.1.0
// kh_mod 0.2.1, add
if (!isset($_REQUEST['iID']) && !isset($_REQUEST['fID'])) {
	$_REQUEST['iID'] = $_REQUEST['id'];
	$_REQUEST['fID'] = $_REQUEST['list'];
}

//
// FOLDER AND IMAGE SETTINGS
// kh_mod 0.1.0, add
$imageRC	 = false;
$imageID	 = false;
$folderID = 1;
if ($_REQUEST['slideshow'] != '') {
	$imageID = (int)$_REQUEST['slideshow'];
	$imageRC = $mg2->all_images[$imageID];
	if (isset($mg2->all_images[$imageID]))
		$folderID = $imageRC[1];
	else
		unset($_REQUEST['slideshow']);
}

if ($_REQUEST['iID'] != '' && empty($imageRC)) {
	$imageID = (int)$_REQUEST['iID'];
	$imageRC = $mg2->all_images[$imageID];
	if (isset($mg2->all_images[$imageID]))
		$folderID = $imageRC[1];
	else
		unset($_REQUEST['iID']);
}

//
// CURRENT PAGE OF THUMBNAILS
// kh_mod 0.2.0, changed
if ($_GET['page'] == 'all') $currentPage = 'all';
else {
	$currentPage = (int)$_GET['page'];
	if ($currentPage < 1) $currentPage = 1;
}

//
// NOT EXISTS IMAGE IN DATABASE?
// kh_mod 0.1.0, add
if ($imageID && empty($imageRC)) notexists($imageID);

//
// GET FOLDER REQUESTET FOLDER
// kh_mod 0.1.0, add
if (!$imageID && $_REQUEST['fID'] != '') {
	$folderID = (int)$_REQUEST['fID'];
}

//
// SET METATAGS TITLE AND ROBOTS
// kh_mod 0.2.0, add
$mg2->pagetitle = $mg2->getpagetitle($imageID, $folderID, ' - ');
$mg2->robots	 = '';
if		 ($mg2->metaseting & 1<<4) $mg2->robots = 'noindex,nofollow';
elseif ($mg2->metaseting & 2<<4) $mg2->robots = 'index,nofollow';
elseif ($mg2->metaseting & 4<<4) $mg2->robots = 'noindex,follow';
elseif ($mg2->metaseting & 8<<4) $mg2->robots = 'index,follow';

//
// GALLERY SECURITY
// kh_mod 0.2.0, changed
$mg2->gallerysecurity($folderID, $imageID);

//
// GET FOLDER SETTINGS AND CHECK IF IT EXISTS
//
$mg2->getfoldersettings($folderID);


/////////////////////////////
//	DISPLAY IMAGES	//
////////////////////////////
if ($_REQUEST['slideshow']) {
	// SLIDESHOW
	include ('includes/mg2_slideshow.php');
}
elseif ($_REQUEST['iID']) {
	// DISPLAY IMAGE
	include ('includes/mg2_showimages.php');
}
else {
	// INDEX (THUMBS)
	include ('includes/mg2_showthumbs.php');
}
?>
