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
error_reporting(E_ALL ^ E_NOTICE);

// SET PHP ARGUMENT SEPERATOR ON '&AMP'
@ini_set('arg_separator.output','&amp;');

// SESSION START, kh_mod 0.2.0, changed
$secure_cookie = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
@ini_set('session.use_strict_mode', '1');
session_set_cookie_params(array(
	'lifetime' => 0,
	'path' => '/',
	'secure' => $secure_cookie,
	'httponly' => true,
	'samesite' => 'Strict'
));
session_start();

// DEFINE SCRIPT CONSTANS
define('PRE_SESSION',  'mg2'. (string)crc32(__FILE__));
define('DATA_FOLDER',  dirname(__FILE__) .'/data/');
define('ADMIN_FOLDER', 'admin/');

// TRIGGER INSTALLATION
if (!is_file(DATA_FOLDER .'mg2_settings.php'))
	@include('mg2_install.php');

// MAKE NEW DATABASE OBJECT
include('includes/mg2_functions.php');
include('includes/mg2admin_functions.php');
$mg2 = new MG2admin;

// BASIC SETTINGS
$mg2->imagefolder = 'pictures';
$mg2->extendedset = '28';	// 0, 0, 1, 1, 1
$mg2->ga4measurementid = '';

// READ FILE SETTINGS
include('includes/mg2_version.php');
include(DATA_FOLDER .'mg2_settings.php');


//
// READ LANGUAGES
// kh_mod 0.1.0, changed
if ($_REQUEST['action'] == 'writesetup') {
	$selectedlang = $mg2->charfix($_REQUEST['defaultlang'], '/');
	if (!empty($selectedlang)) $mg2->defaultlang = $selectedlang;
}
if (!is_readable('lang/'.$mg2->defaultlang))	$mg2->defaultlang = 'english.php';
if (is_readable('lang/'.$mg2->defaultlang)) include('lang/'.$mg2->defaultlang);

//
// DISPLAY LOG FILE
// kh_mod 0.2.0, add
if ($_REQUEST['action'] == 'logfile')
if ($_SESSION[PRE_SESSION.'password'] === $mg2->password) {
if ((time() - $_SESSION[PRE_SESSION.'accesstime']) <= ((int)$mg2->accesstime * 60)) {
	@header('Content-Type: text/plain; charset='.$mg2->charset);
	include(DATA_FOLDER .'.mg2_log');
	exit();
}
} else die('You don\'t have permission to access logfile!');

// SET HEADERS TO PREVENT BROWSER CACHING OF PAGES
@header('Expires: Mon, 20 Jul 2000 05:00:00 GMT');
@header('Content-Type: text/html; charset='.$mg2->charset);
@header('Last-Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
@header('Cache-Control: no-store, no-cache, must-revalidate');
@header('Cache-Control: post-check=0, pre-check=0', false);
@header('Pragma: no-cache');

// HTML-HEADER
include(ADMIN_FOLDER .'admin_header.php');

// LOGIN SECURITY CHECK, kh_mod 0.1.0pl1, changed
$firstlogin = $mg2->security();

// READ DATABASE FOR ADMIN, kh_mod 0.2.0, changed
$mg2->readDB(true);

////////////////////////////
// MENU
////////////////////////////
if (!$_REQUEST['fID']) $list = "1"; else $list = $_REQUEST['fID'];
if ($_REQUEST['editfolder']) $list = $_REQUEST['editfolder'];

for ($i = 0; $i < count($mg2->all_images); $i++) {
	$total_size += (int)$mg2->all_images[$i][12];
}
$dec = "1"; $val = " bytes";
if (strlen($total_size) > 3) { $dec="1024"; $val=" Kb"; }
if (strlen($total_size) > 6) { $dec="1048576"; $val=" Mb"; }
$total_size = round($total_size/$dec,2) . $val;
$total_images = count($mg2->all_images);
if ($total_images == 1)	$total_images = $total_images ." ". $mg2->lang['file']; else $total_images = $total_images . " " . $mg2->lang['files'];
$total_folders = count($mg2->all_folders) - 1;
if ($total_folders < 0) $total_folders = 0;
if ($total_folders == 1) $total_folders = $total_folders ." ". $mg2->lang['folder']; else $total_folders = $total_folders . " " . $mg2->lang['folders'];
include(ADMIN_FOLDER .'admin1_menu.php');

// LANGUAGE INSTALLED?
if (empty($mg2->lang)) {
	$mg2->status = '<span style="color:red">There is no language intsalled!</span>';
	$mg2->displaystatus();
}

// USED SKIN NOTAVAILABLE OR UP TO DATE?
if ($firstlogin) {
	$skinpath = 'skins/'. $mg2->activeskin .'/';
	if (!is_readable($skinpath .'templates')) {
		$_REQUEST['action'] = 'setup';
		$mg2->status = '<span style="color:red">The skin "'. ucfirst($mg2->activeskin);
		$mg2->status.= '" is not available! Please select another one.</span>';
		$mg2->displaystatus();
	}
	elseif (is_readable($skinpath .'settings.php')) {
		include ($skinpath .'settings.php');
		$found = preg_match_all('/([0-9].[0-9].[0-9])/',$skin_version,$treffer);
		if ($found !== 2 || version_compare($treffer[0][1], '0.2.0', '<')) {
			$display = ($skin_version)? '('. $skin_version .') ':'';
			$mg2->status = '<span style="color:red">Your skin version '. $display .'of "';
			$mg2->status.= ucfirst($mg2->activeskin) .'" is not up to date!</span>';
			$mg2->displaystatus();
		}
	}
}

// UPLOAD ERROR?
if ($_REQUEST['loading'] && $_REQUEST['action'] != 'upload') {
	$max_upload  = get_cfg_var('upload_max_filesize');
	$mg2->status = 'ERROR: Upload missed! Selected file(s) are &gt; ';
	$mg2->status.= @preg_replace('/(\d+)M$/','${1} MByte',$max_upload);
	$mg2->displaystatus();
}

// kh_mod 0.1.0, changed
if (!empty($_REQUEST['action']))
switch ($_REQUEST['action']) {
	case "updateID":
		if ($mg2->updateID($_REQUEST['iID'])) {
			$mg2->getfoldersettings($_REQUEST['fID']);
			$images = $mg2->select($_REQUEST['fID'],$mg2->all_images,1,$mg2->folder_sortby,$mg2->folder_sortway);
			for ($i=0; $i < count($images); $i++) {
				if ($images[$i][0] == $_REQUEST['iID']) break;
			}
			$_REQUEST['editID'] = $images[$i+1][0];
		} else
			$_REQUEST['editID'] = $_REQUEST['iID'];
		break;
	case "dbbackup":
		$mg2->db_backup();
		break;
	case "startimport":
		$mg2->makefolderlist();
		$subdirs = $mg2->get_subdirs();
		include(ADMIN_FOLDER .'admin2_import.php');
		break;
	case "import":
		$list   = (int)$_POST['fID'];
		$subdir = str_replace('../', '', trim($_POST['importfrom']));
		if (!$mg2->importstart($list, $subdir))
			unset($_POST['action']);
		break;
	case "newfolder":
		$mg2->newfolder((int)$_REQUEST['fID']);
		break;
	case "deleteID":
		$_REQUEST['fID'] = $mg2->deleteID($_REQUEST['iID']);
		break;
	case "upload":
		if ($mg2->upload((int)$_REQUEST['fID'])) {
			include(ADMIN_FOLDER ."admin4_credits.php");
			exit();
		}
		break;
	case "updatefolder":
		$folderID = (int)$_REQUEST['fID'];
		$movetoID = (int)$_REQUEST['moveto'];
		$mg2->updatefolder($folderID, $movetoID);
		$_REQUEST['editfolder'] = $folderID;
		break;
	case "writesetup":
		$mg2->writesetup();
		break;
	case "deletecomments":
		$imageID = (int)$_REQUEST['editID'];
		$mg2->deletecomments($imageID);
		break;
	case "setup": // MG2 SETUP
		$mg2->setup();
		include(ADMIN_FOLDER .'admin4_credits.php');
		exit();
	case "convert": // DATABASE CONVERT
		include('includes/mg2admin_convert.php');
		if ($_REQUEST['items'] == 'db') {
			convert_iDB();
			convert_fDB();
			$back = $mg2->lang['backtofolder'];
			$back.= ' <a href="admin.php?fID=1">Root</a>';
			$mg2->displaystatus($back);
			include(ADMIN_FOLDER ."admin4_credits.php");
			exit();
		}
		elseif ($_REQUEST['items'] == 'cf') convert_cmf();
		else	 $mg2->displaystatus('No items to convert!');
}
// end

if ($_REQUEST['erasefolder']) {
	$_REQUEST['fID'] = $mg2->erasefolder($_REQUEST['erasefolder']);
}

// UPDATE COMMENT, ACTION, kh_mod 0.1.0, add
if (substr($_REQUEST['updatecomment'],0,3)==='cID') {
	$updatedComment = $mg2->updatecomment($_REQUEST['editID']);
	if ($updatedComment===false) {
		// BACK TO 'EDIT COMMENT' DIALOG
		$_REQUEST['editcomment'] = $_REQUEST['updatecomment'];
	}
}

//
// DISPLAY DIALOGS
//

// EDIT COMMENT, DIALOG, kh_mod 0.1.0, add
if (substr($_REQUEST['editcomment'],0,3)==='cID') {
	if ($mg2->editcomment($_REQUEST['editID'])) {
		include(ADMIN_FOLDER .'admin4_credits.php');
		exit();
	}
	// DISPLAY ERROR MESSAGE
	$mg2->displaystatus();
}

// DELETE COMMENT, DIALOG, kh_mod 0.1.0, add
if (substr($_REQUEST['deletecomment'],0,3)==='cID') {
	if ($mg2->askdelcomment($_REQUEST['editID'])) {
		include(ADMIN_FOLDER .'admin4_credits.php');
		exit();
	}
	// DISPLAY ERROR MESSAGE
	$mg2->displaystatus();
}

// DELETE FILES, kh_mod 0.1.0 b3, changed
if ($_REQUEST['deletefiles']) {
	$del_request = html_entity_decode($_REQUEST['deletefiles']);
	$del_value	 = html_entity_decode($mg2->lang['buttondelete']);
	if ($del_request == $del_value) $mg2->deletefiles();
}

// MOVE FILES, ACTION, kh_mod 0.1.0 b3, changed
if ($_REQUEST['movefiles']) {
	$move_request = html_entity_decode($_REQUEST['movefiles']);
	$move_value	  = html_entity_decode($mg2->lang['buttonmove']);
	if ($move_request == $move_value) $mg2->movefiles();
}

// UPLOAD IMAGES, DIALOG
if($_REQUEST['startupload']) {
	$mg2->makefolderlist();
	$_REQUEST['fID'] = (int)$_REQUEST['startupload'];
	include(ADMIN_FOLDER .'admin2_upload.php');
}

// MAKE A NEW FOLDER, DIALOG, kh_mod 0.1.0, add
if($_REQUEST['newfolder']) {
	$_REQUEST['fID'] = $_REQUEST['newfolder'];
	include(ADMIN_FOLDER .'admin2_newfolder.php');
}

// EDIT FOLDER, DIALOG
if ($_REQUEST['editfolder']) {
	$_REQUEST['fID'] = $mg2->editfolder($Calendar);
}

// REBUILD FOLDER, ACTION, kh_mod 0.2.0, changed
if($_REQUEST['rebuildfolder']) {
	$reblist = (int)$_REQUEST['rebuildfolder'];
	if ($mg2->rebuildfolder($reblist) > 0)
		$_REQUEST['fID'] = $reblist;
}

// DELETE IMAGE, DIALOG, kh_mod 0.1.0, changed
if ($_REQUEST['deleteID']) {
	$_REQUEST['fID'] = $mg2->askdeleteID();
}

if ($_REQUEST['deletefolder']) {
	$delfolder = (int)$_REQUEST['deletefolder'];
	if (!isset($_REQUEST['fID'])) $_REQUEST['fID'] = $delfolder;
	$mg2->askdelfolder($delfolder);
}

// REBUILD THUMB AND MEDIUM IMAGE, kh_mod 0.2.0, changed
if ($_GET['rebuildID']) {
	$imageID = (int)$_REQUEST['rebuildID'];
	if ($update = $mg2->rebuildID($imageID)) {
		$_REQUEST['fID'] = $mg2->all_images[$imageID][1];

		// UPDATE IMAGE DATABASE
		if (!$mg2->write_iDB('update'))
			$mg2->log('ERROR: Couldn\'t update image database!');
	}
}

$isuffix = '';	// image suffix
if ($_GET['rotate']) {
	$imageID	= (int)$_REQUEST['rotate'];
	$mg2->rotateimage($imageID);
	$isuffix = $mg2->editID($imageID, $updatedComment, $Calendar);
}
elseif ($_REQUEST['editID']) {
	$imageID	= (int)$_REQUEST['editID'];
	$isuffix = $mg2->editID($imageID, $updatedComment, $Calendar);
}

// NO IMPORT ACTION?
if ($_POST['action'] != 'import') {
	include('includes/mg2admin_tableview.php');
}
include(ADMIN_FOLDER .'admin4_credits.php');

?>
