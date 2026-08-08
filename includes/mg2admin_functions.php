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

class MG2admin extends mg2db {

	// DISPLAY STATUS MESSAGE
	// kh_mod 0.2.0, changed
	function displaystatus($message='') {
		if ($message) $this->status = $message;
		if ($this->status) {
			include(ADMIN_FOLDER .'admin2_status.php');
			$this->status = '';
		}
	}

	function security()
	{
		$firstlogin = false;
		$class		= 'table_security';
		// check pwd match, then set login var
		if (isset($_POST['password']) && md5(strrev(md5($_POST['password']))) == $this->password && !isset($_SESSION[PRE_SESSION.'password'])) {
			session_regenerate_id(true);
			$ip   = getenv('REMOTE_ADDR');
			$host = gethostbyaddr($ip);
			$_SESSION[PRE_SESSION.'password']	= md5(strrev(md5($_POST['password'])));
			$_SESSION[PRE_SESSION.'accesstime']	= time();
			$this->log('Logon from IP: '. $ip .', HOST: '. $host);
			$firstlogin = true;
		}

		// accesstime in seconds
		if ((int)$this->accesstime < 1) $this->accesstime = 15;	// kh_mod 0.1.0, add
		$accesstime = (int)$this->accesstime * 60;					// kh_mod 0.1.0, add

		// check for login and show login screen
		if ($_SESSION[PRE_SESSION.'password'] !== $this->password) {
			// PASSWORD LOGOFF
			unset($_SESSION[PRE_SESSION.'password']);
			unset($_SESSION[PRE_SESSION.'accesstime']);
			$select = 1;
			$pwdheadline = ($_POST['password'])? $this->lang['wronglogin']:$this->lang['enterpassword'];
			include(ADMIN_FOLDER .'admin_table_start.php');
			include(ADMIN_FOLDER .'admin_security.php');
			include(ADMIN_FOLDER .'admin_donate_hint.php');
			include(ADMIN_FOLDER .'admin_footer.php');
			exit();
		}
		// Renew timestamp if time not exceded
		elseif ((time() - $_SESSION[PRE_SESSION.'accesstime']) > $accesstime) {
			// TIME LOGOFF
			// kh_mod 0.1.0, changed
			unset($_SESSION[PRE_SESSION.'password']);
			unset($_SESSION[PRE_SESSION.'accesstime']);
			$select = 2;
			include(ADMIN_FOLDER .'admin_table_start.php');
			include(ADMIN_FOLDER .'admin_security.php');
			include(ADMIN_FOLDER .'admin_footer.php');
			$this->log('Timeout logoff after '. $this->accesstime .' minutes');
			exit();
		} else
			$_SESSION[PRE_SESSION.'accesstime'] = time();
			// end

		//Logout
		if ($_REQUEST['action'] == 'logoff') {
			unset($_SESSION[PRE_SESSION.'password']);
			unset($_SESSION[PRE_SESSION.'accesstime']);
			$select = 3;
			include(ADMIN_FOLDER .'admin_table_start.php');
			include(ADMIN_FOLDER .'admin_security.php');
			include(ADMIN_FOLDER .'admin_footer.php');
			$this->log('Logoff');
			exit();
		}

		// ADDITIONAL LOGIN PERMISSION CHECKS
		if ($firstlogin == true) {
			@rmdir(DATA_FOLDER .'x');
			if (@mkdir(DATA_FOLDER .'x')) {
				@rmdir(DATA_FOLDER .'x');
			} else {
				$this->permcheck(1);
			}
			@rmdir($this->imagefolder .'/x');
			if (@mkdir($this->imagefolder .'/x')) {
				@rmdir($this->imagefolder .'/x');
			} else {
				$this->permcheck(2);
			}
			// ARE DATABASE FILES WRITEABLE?
			if (!is_writable(DATA_FOLDER .'mg2db_idatabase.php'))
			if (is_file(DATA_FOLDER .'mg2db_idatabase.php')) {
				$this->permcheck(3);
			}
			if (!is_writable(DATA_FOLDER .'mg2db_idatabase_temp.php'))
			if (is_file(DATA_FOLDER .'mg2db_idatabase_temp.php')) {
				$this->permcheck(4);
			}
			if (!is_writable(DATA_FOLDER .'mg2db_fdatabase.php'))
			if (is_file(DATA_FOLDER .'mg2db_fdatabase.php')) {
				$this->permcheck(5);
			}
			if (!is_writable(DATA_FOLDER .'mg2db_fdatabase_temp.php'))
			if (is_file(DATA_FOLDER .'mg2db_fdatabase_temp.php')) {
				$this->permcheck(6);
			}
		}
		return $firstlogin;
	}

	//
	// DISPLAY PERMISSION ERROR
	// kh_mod 0.2.0, changed
	function permcheck($level) {
		$permerror = $this->lang['permerror'.$level];
		$whattodo  = $this->lang['whattodo'.$level];
		include(ADMIN_FOLDER .'admin_permerror.php');
		unset($_SESSION[PRE_SESSION.'password']);
		unset($_SESSION[PRE_SESSION.'accesstime']);
		session_destroy();
		exit();
	}

	//
	// ADMIN NAVIGATION
	// kh_mod 0.2.0, changed
	function adminnavigation($list){
		$path = array();
		do {
			if (!isset($this->all_folders[$list])) break;

			$foldername = ($list == 1)?
							  $this->lang['root']
							  :
							  $this->all_folders[$list][2];
			$path[$list] = ' <a href="admin.php?fID='. $list .'">'. $foldername .'</a>';
			$list			 = $this->all_folders[$list][1];
			if (!empty($path[$list])) break;	 // circle link!
		}
		while ((int)$list > 0);

		// REVERSE NAVIGATION STRING
		return implode(' : ', array_reverse($path));
	}

	//
	// REBULID THUMB AND MEDIUM IMAGE
	// kh_mod 0.2.0, changed
	function rebuildID($imageID) {
		$rebuild = false;
		do {
			// EXCLUSION CRITERIONS
			if (!isset($this->all_images[$imageID])) {
				$message = $this->lang['nopictureid'] .' #'. $imageID .'\''; break;
			}
			$message		= $this->lang['rebuilderror'];
			$filename	= $this->all_images[$imageID][6];
			$subdir		= $this->all_images[$imageID][7];
			$image_path	= $this->get_path($filename,$subdir);
			if (!is_readable($image_path)) break;

			// DELETE OLD THUMB AND MEDIUM IMAGE
			$thumb_path  = $this->get_path($filename,$subdir,'thumb');
			$medium_path = $this->get_path($filename,$subdir,'medium');
			if (is_file($thumb_path)  && !unlink($thumb_path))	 break;
			if (is_file($medium_path) && !unlink($medium_path)) break;

			// CREATE NEW THUMB AND MEDIUM IMAGE
			$imgs_size = $this->createthumb($filename,$subdir);

			// UPDATE DATABASE
			if (is_array($imgs_size)) {
				$this->all_images[$imageID][12] = filesize($image_path);
				$this->all_images[$imageID][8]  = $imgs_size[0];
				$this->all_images[$imageID][9]  = $imgs_size[1];
				$this->all_images[$imageID][10] = $imgs_size[2];
				$this->all_images[$imageID][11] = $imgs_size[3];
				$this->log('Rebuild thumbnail for image #'. $imageID .' (\''. $filename .'\')');
				$message = $this->lang['rebuildsuccess'];
				$rebuild = true;
			}
		}
		while(0);

		// DISPLAY MESSAGE
		$this->displaystatus($message .' \''. $filename .'\''); flush();
		return $rebuild;
	}

	function editID($editID, $updatedComment, $Calendar) {
		if (!isset($this->all_images[$editID])) {
			$this->log('ERROR: editID(), picture ID '.$editID.' not found!');
			$this->displaystatus($this->lang['nopictureid'] .' #'. $editID);
			return false;
		}

		// kh_mod 0.2.0, add
		$imageRC	 = $this->all_images[$editID];
		$folderID = $imageRC[1];
		$this->makefolderlist($folderID);
		$this->getfoldersettings($folderID);
		$currentPage		= $this->imagenavigation($folderID, $editID, true);
		$this->navstring  = '<table class="minithumb" cellspacing="0" cellpadding="0"><tr><td>';
		$this->navstring .= $this->nav_first.'&nbsp;</td><td>&nbsp;';
		$this->navstring .= $this->nav_prev.'&nbsp;</td><td>&nbsp;';
		$this->navstring .= $this->nav_this.'&nbsp;</td><td>&nbsp;';
		$this->navstring .= $this->nav_next.'&nbsp;</td><td>&nbsp;';
		$this->navstring .= $this->nav_last.'&nbsp;</td></tr></table>';
		$_REQUEST['page'] = $currentPage;
		$_REQUEST['fID']	= $folderID;
		$title				= $imageRC[2];
		$description		= $imageRC[3];
		$position			= $imageRC[5];
		$filename			= $imageRC[6];
		$subdir				= $imageRC[7];
		$photographer		= $imageRC[14];
		$publish			  	= $this->time2date($imageRC[4], true);
		$thumbsize			= 'width="'.$imageRC[10].'" height="'.$imageRC[11].'"';
		$isuffix				= (string)('?'. rand(0,10000));	// image suffix
		$thumbfile			= $this->get_path($filename, $subdir, 'thumb');
		$thumbfile			= (!is_readable($thumbfile))?
								  ADMIN_FOLDER .'images/1x1.gif'
								  :
								  $thumbfile . $isuffix;
		// end

		include(ADMIN_FOLDER .'admin2_edit.php');
		$num_comments = (is_array($this->comments))?
							 count($this->comments)
							 :
							 $this->readcomments($this->get_path($filename, $subdir, 'comment'));
		$this->sort($this->comments, 4, $this->commentsets & 2);
		if ($num_comments) include(ADMIN_FOLDER .'admin2_comments.php');

		// IMAGE SUFFIX FOR FILE LIST
		return $isuffix;
	}

	//
	// UPDATE IMAGE DATA RECORD ACTION
	// kh_mod 0.2.0, changed
	function updateID($imageID) {
		// EXISTS REQUEST ID?
		if (!isset($this->all_images[$imageID])) {
			$this->log('ERROR: updateID(), picture ID '. $imageID .' not found!');
			$this->displaystatus($this->lang['nopictureid'] .' #'. $imageID);
			return false;
		}

		// CLEAN INPUT VALUES
		$filename_new = $this->charfix($_POST['filename']);
		$title		  = $this->charfix($_POST['title']);
		$description  = $this->charfix($_POST['description']);
		$description  = @preg_replace('/\r\n|\r|\n/', '', $description);
		$photographer = $this->charfix($_POST['photographer']);
		$publish		  = $this->date2time($_POST['publish']);
		$position	  = (int)$_POST['position'];
		$folderID	  = (int)$_POST['setthumb'];

		// INITIALIZE STATUS MESSAGE AND REFERENCE TO IMAGE DB
		$this->status = '';
		$imageRC		  = &$this->all_images[$imageID];

		// RENAME FILE NAME?
		$ren_ok = ($imageRC[6] != $filename_new)?
					 $this->renamefiles($imageID, $filename_new)
					 :
					 true;

		// SET THE NEW DATE
		if ($publish !== false) {
			$diffTime = $imageRC[4] - $publish;
			if ($diffTime < 0 || 59 < $diffTime) $imageRC[4] = $publish;
		}

		// SET THE FURTHER NEW VALUES
		$imageRC[2]  = $title;
		$imageRC[3]  = $description;
		$imageRC[5]  = $position;
		$imageRC[14] = $photographer;

		// WRITE IMAGE DATABASE AND UPDATE
		$iDB_ok = $this->write_iDB('update');
		$fDB_ok = true;

		// SET AS THUMBNAIL FOR FOLDER?
		if (isset($this->all_folders[$folderID])) {
			$thumbfile = $this->get_path($imageRC[6],$imageRC[7],'thumb');
			if (is_file($thumbfile)) {
				$this->all_folders[$folderID][6] = $imageID;	// for thumb icon
				$fDB_ok = $this->write_fDB('update');			// write database
			}
		}

		// OUTPUT STATUS MESSAGES
		$this->log('End of \'updateID\' for file \''. $imageRC[6] .'\'');
		if ($ren_ok && $iDB_ok && $fDB_ok) $this->status.= $this->lang['updatesuccess'];
		else {
			if (!$iDB_ok) $this->status.= $this->lang['iDB_error'] .'<br />';
			if (!$fDB_ok) $this->status.= $this->lang['fDB_error'];
		}
		$this->displaystatus();
		return ($ren_ok && $iDB_ok && $fDB_ok)? true:false;
	}

	// kh_mod 0.2.0, changed
	function renamefiles($imageID, $fname_new) {
		// CHECK FILENAME FOR ILLEGAL CHARACTERS
		if (@preg_match('/[:;<>\/\\\¤\|~§\?]/',$fname_new)) {
			$this->status = $this->lang['renamefailure'] .'<br />\'';
			$this->status.= @htmlspecialchars($fname_new, ENT_QUOTES) .'\'';
			return false;
		}

		// CHECK FILE EXTENSION
		$ext = strtolower(substr(strrchr($fname_new, '.'), 1));
		if (strpos($this->extensions,$ext) === false) {
			$this->status = $this->lang['forebiddenxtensions'] .'<br />\'';
			$this->status.= @htmlspecialchars($fname_new, ENT_QUOTES) .'\'';
			return false;
		}

		// RENAME IMAGE
		$filename  = $this->all_images[$imageID][6];
		$subdir	  = $this->all_images[$imageID][7];
		$image_old = $this->get_path($filename, $subdir);
		$image_new = $this->get_path($fname_new, $subdir);
		if (
			!$image_new												||		// new file formally incorrect
			!$image_old												||		// orig. file formally incorrect
			!is_file($image_old)									||		// orig. file not found
			!rename($image_old, $image_new)							// renaming missed
		) {
			$this->status = $this->lang['renamefailure_image'] .'<br />\'';
			$this->status.= @htmlspecialchars($fname_new, ENT_QUOTES) .'\'';
			return false;
		}

		// SET DATABASE ENTRY
		$ren_ok = true;
		$this->all_images[$imageID][6] = $fname_new;

		// RENAME THUMBNAIL
		$thumb_old = $this->get_path($filename, $subdir, 'thumb');
		$thumb_new = $this->get_path($fname_new, $subdir, 'thumb');
		if (!is_file($thumb_old))
			$ren_ok = $this->rebuildID($imageID);
		elseif (!rename($thumb_old, $thumb_new)) {
			$this->status = $this->lang['renamefailure_thumb'] .'<br />';
			$ren_ok = false;
		}

		// RENAME MEDIUM
		$medium_old = $this->get_path($filename, $subdir, 'medium');
		$medium_new = $this->get_path($fname_new, $subdir, 'medium');
		if (is_file($medium_old) && !rename($medium_old, $medium_new))
			$this->status.= $this->lang['renamefailure_medium'] .'<br />';

		// RENAME COMMENT
		$comment_old = $this->get_path($filename, $subdir, 'comment');
		$comment_new = $this->get_path($fname_new, $subdir, 'comment');
		if (is_file($comment_old) && !rename($comment_old, $comment_new))
			$this->status.= $this->lang['renamefailure_comment'] .'<br />';

		return $ren_ok;
	}

	//
	// ASK DELETE IMAGE DIALOG
	// kh_mod 0.1.0, add
	function askdeleteID() {
		$imageRC = $this->all_images[$_REQUEST['deleteID']]; // kh_mod 0.2.0, changed
		if ($imageRC) {
			$folderID	  = $imageRC[1];
			$filename	  = $imageRC[6];
			$subdir		  = $imageRC[7];
			$thumb_width  = $imageRC[10];
			$thumb_height = $imageRC[11];
			$thumbfile	  = $this->get_path($filename, $subdir, 'thumb');
			$message		  = $this->lang['delete'] .' \''. $filename .'\'?';
		}
		else {
			$this->status = $this->lang['nopictureid'];
			include(ADMIN_FOLDER .'admin2_status.php');
			return false;
		}

		if (!is_readable($thumbfile)) $thumbfile = ADMIN_FOLDER .'images/1x1.gif';
		$cancel		  = 'admin.php?fID='. $folderID .'&amp;page='. (int)$_REQUEST['page'];
		$href_ok		  = 'admin.php?action=deleteID&amp;iID='. (int)$_REQUEST['deleteID'];
		$display		  = 'image';
		include(ADMIN_FOLDER .'admin2_delete.php');
		return $folderID;
	}

	//
	// DELETE IMAGE AND DATABASE ENTRY ACTION
	// kh_mod 0.2.0, change
	function deleteID($imageID) {

		// GET FOLDER ID
		$folderID = $this->all_images[$imageID][1];

		// DELETE IMAGE
		$del_status = $this->deleteimage($imageID);

		// DELETE DATABASE ENTRY?
		if ($del_status & 4) {
			// WRITE IMAGE DATABASE AND UPDATE
			$iDB_ok = $this->write_iDB('update');

			// STATUS MESSAGE
			if ($iDB_ok) {
				$this->status.= '<br />'. $this->lang['recorddeleted'];
			} else {
				$this->status.= '<br />'. $this->lang['iDB_error'];
			}
		}
		include(ADMIN_FOLDER .'admin2_status.php');

		// RETURN FOLDER ID
		return ($del_status & 1)? $folderID:1;
	}

	// kh_mod 0.2.0, changed
	function deletefiles() {
		$todelete  = 0;
		$delfiles  = 0;
		$delrecord = 0;
		$numfiles = (int)$_REQUEST['selectsize'];

		// START DLETE FILES
		$this->log('Delete file(s) started');

		for ($i = 0; $i < $numfiles; $i++) {
			$imageID = (int)$_REQUEST['selectfile'. $i];
			if ($imageID < 1) continue;

			$todelete++;
			if ($del_status = $this->deleteimage($imageID)) {
				if ($del_status & 2) $delfiles++;	// DELETE IMAGE FILE?
				if ($del_status & 4) $delrecord++;	// DELETE DATABASE ENTRY?
			}
		}

		// DISPLAY STATUS MESSAGE
		$file_txt = ($todelete>1)? $this->lang['filesdeleted']:$this->lang['filedeleted'];
		if (empty($todelete)) {
			$this->log('ERROR: No file selected to delete!');
			$this->status = $this->lang['filenotselected'];
		} elseif ($delfiles < $todelete) {
			$this->status = $delfiles .' '. $this->lang['of'] .' '. $todelete .' '. $file_txt;
		} else {
			$this->status = $delfiles .' '. $file_txt;
		}
		// WRITE IMAGE DATABASE AND UPDATE
		if ($delrecord)
			if ($this->write_iDB('update')) {
				$this->log('Summery: Deleted '. $delrecord .' database entry(s) of '. $todelete .' selected');
				$record_txt = ($delrecord>1)? $this->lang['recordsdeleted']:$this->lang['recorddeleted'];
				$this->status.= '<br />'. $delrecord .' '. $record_txt;
			} else {
				$this->status.= '<br />'. $this->lang['iDB_error'];
			}
		include(ADMIN_FOLDER .'admin2_status.php');
	}

	// kh_mod 0.1.0, changed
	function deleteimage($imageID) {

		// EXISTS REQUEST ID?
		if (!isset($this->all_images[$imageID])) { 	// kh_mod 0.2.0, changed
			$this->status = $this->lang['nopictureid'] .' #'. $imageID;
			return false;
		}

		// SET IMAGE ID OK AND GET FILE NAME AND SUBDIR
		$del_status = 1;
		$filename	= $this->all_images[$imageID][6];
		$list			= $this->all_images[$imageID][1];
		$subdir		= $this->all_images[$imageID][7];

		// IS EXISTS IMAGE, DELETE IT!
		$filepath = $this->get_path($filename, $subdir);
		if (is_file($filepath)) {
			if (!unlink($filepath)) {
				$this->log('ERROR: Couldn\'t delete file \''.$filename.'\'');
				$this->status = $this->lang['filenotdeleted'].'\''.$filename.'\'';
				return false;
			}
			else {
				$this->log('Deleting file \''. $filename .'\'');
				$this->status = $this->lang['filedeleted'].' \''.$filename.'\'';
				$del_status |= 2;
			}
		}
		else {
			$this->log('ERROR: Couldn\'t found file \''. $filename .'\' to delete!');
			$this->status = $this->lang['filenotfound'].' \''.$filename.'\'';
		}

		// DELETE THUMBNAIL
		$thumbpath = $this->get_path($filename, $subdir, 'thumb');
		if (is_file($thumbpath)) unlink($thumbpath);

		// DELETE MEDIUM IMAGE
		$mediumpath = $this->get_path($filename, $subdir, 'medium');
		if (is_file($mediumpath)) unlink($mediumpath);

		// DELETE COMMENT FILE
		$commentpath = $this->get_path($filename, $subdir, 'comment');
		if (is_file($commentpath)) unlink($commentpath);

		// DELETE DATABASE ENTRY
		if ($del_ok = $this->array_delete($this->all_images, $imageID)) {
			$this->log('Image database entry deleted');
			$del_status |= 4;
		} else {
			$this->log('ERROR: Couldn\'t delete image database entry!');
		}
		return $del_status;
	}

	//
	// UPLOAD IMAGES ACTION
	// kh_mod 0.2.0, changed
	function upload($list=1) {
		$allfiles  = 0;
		$imported  = 0;
		$duplicate = 0;
		$renamed   = 0;
		$this->log('Upload and import started');
		for ($x = 0; $x < 10; $x++) {
			// GET FORM VALUES
			$tmp_name  = @trim($_FILES['file']['tmp_name'][$x]);
			$filename  = @trim($_FILES['file']['name'][$x]);
			$tmp_size  = (int)$_FILES['file']['size'][$x];
			$uploadto  = ($_POST['uploadto'][$x])?
							 (int)$_POST['uploadto'][$x]
							 :
							 (int)$_GET['fID'];
			$overwrite = ($_POST['overwrite'.$x])? true:false;

			// EXCLUSION CRITERIONS
			if (!$tmp_name || $tmp_size < 1)							continue; // temp file don't exists
			if (@preg_match('/[:;<>\/\\\¤\|~§\?]/',$filename))	continue; // forbidden chars
			if (!isset($this->all_folders[$uploadto]))			continue; // folder don't exists

			// START IMAGE FILE IMPORT
			$allfiles++;
			$subdir	 = '';
			$filepath = $this->imagefolder . $subdir .'/'. $filename;
			// NEW FILE OR OVERWRITE?
			if (!is_file($filepath) or $overwrite) {
				if ($this->importimage($uploadto,$filename,$subdir,$tmp_name)) $imported++;
			}
			// DIFFERENT FILE SIZE?
			elseif (filesize($filepath) != $tmp_size) {
				$extension = strrchr($filename,'.');
				$extenlen  = strlen($extension);
				$filename  = substr($filename,0,-$extenlen); 
				$filename .= '_autorenamed'. rand(1000,9999);
				$filename .= $extension;
				if ($this->importimage($uploadto,$filename,$subdir,$tmp_name)) $renamed++;
			}

			// FILE NOT ENTERED YET IN DATABASE?
			elseif ($this->importimage($list, $filename, $subdir)) {
				$imported++;
			// FILE ALREADY EXISTS!
			} else
				$duplicate++;
		}
		$imported += $renamed;

		// WRITE IMAGE DATABASE AND UPDATE
		$import_ok = ($imported > 0 && $this->write_iDB('update'))? true:false;

		// DISPLAY STATUS MESSAGE
		if ($import_ok) {
			$cimages = (string)count($this->all_images);
			$this->log('Summary: Uploaded and imported '.$imported.' file(s). Gallery now contains '. $cimages .' images');
			$this->status = $imported .' '. $this->lang['filesimported'];
		} elseif ($imported > 0) {
			$this->status = $imported .' '. $this->lang['filesuploaded'];
		} elseif ($duplicate < 1) {
			$this->log('No files to import!');
			$this->status = $this->lang['nofilestoimport'];
			if ($allfiles > 0) {
				$this->status.= '<br />('.$allfiles .' '. $this->lang['forbidden'] .' ';
				$this->status.= ($allfiles==1)? $this->lang['file']:$this->lang['files'];
				$this->status.= ')';
			}
		}
		if ($renamed > 0) {
			$this->log('Therefrom '. $renamed .' file(s) renamed automatically!');
			$this->status.= ', '. $this->lang['therefrom'] .'<br />'. $renamed .' '.$this->lang['filesrenamed'];
		}
		if ($duplicate > 0) {
			$this->log($duplicate .' already exists file(s) have not been uploaded!');
			if ($imported > 0) $this->status.= '<br />';
			$this->status.= $duplicate .' '. $this->lang['alreadyexists'];
		}
		if ($imported > 0) {
			if (!$import_ok)  $this->status.= '<br />'. $this->lang['iDB_error'];
			$foldername   = $this->getfoldername($list);
			$this->status.= '<br /><br /><a href="admin.php?fID='. $list .'">';
			$this->status.= $this->lang['backtofolder'] .' \''. $foldername .'\'</a>';
		}
		include(ADMIN_FOLDER .'admin2_status.php');
		return $imported;
	}

	//
	// IMPORT START ACTION
	// kh_mod 0.1.0, changed
	function importstart($list, $subdir) {
		if (!isset($this->all_folders[$list])) {  // kh_mod 0.2.0, changed
			$this->displaystatus($this->lang['nofolderid'] .' #'. $list);
			$_REQUEST['fID'] = '1';
			return false;
		}

		$this->log('Import started');
		$imported = 0;
		if ($handle = opendir($this->imagefolder . $subdir)) {
			while (false !== ($filename = readdir($handle))) {
				if ($this->importimage($list, $filename, $subdir)) $imported++;
			}
			closedir($handle);

			// WRITE IMAGE DATABASE AND UPDATE
			if ($imported && !$this->write_iDB('update')) $imported = 0;
		}

		// DISPLAY STATUS MESSAGE
		$cimages = (string)count($this->all_images);
		$foldername = $this->getfoldername($list);
		$this->log('Summary: Imported '. $imported .' file(s) to \''.$foldername.'\'. Gallery now contains '. $cimages .' images');
		if ($imported < 1) {
			$this->status = $this->lang['nofilestoimport'];
		} else {
			$this->status = $imported .' '. $this->lang['filesimported'];
			$this->status.= '<br /><br /><a href="admin.php?fID='. $list .'">';
			$this->status.= $this->lang['backtofolder'] .' \''. $foldername .'\'</a>';
		}
		include(ADMIN_FOLDER .'admin2_status.php');
		return $imported;
	}

	//
	// IMPORT NEW IMAGE ACTION
	// kh_mod 0.2.0, changed
	function importimage($folder,$filename,$subdir,$tmp_name='') {
		$extension = substr(strrchr($filename, '.'), 1);
		$extension = strtolower($extension);
		$filepath  = $this->imagefolder . $subdir .'/'. $filename;

		// EXCLUSION CRITERIONS
		$allowed_extensions = array_filter(array_map('trim', explode(',', strtolower($this->extensions))));
		if (empty($extension))													return false;	// extension empty
		if (!in_array($extension, $allowed_extensions, true))			return false;	// extension forbidden
		if ($tmp_name) {
			$image_info = @getimagesize($tmp_name);
			$allowed_types = array(IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG);
			if ($image_info === false || !in_array($image_info[2], $allowed_types, true)) return false;
		}
		if ($tmp_name && !move_uploaded_file($tmp_name,$filepath))	return false;	// can't import new file
		if (strpos($filename, '_medium')  !== false)						return false;	// medium image
		if (strpos($filename, '_thumb')   !== false)						return false;	// thumb image		
		if ($imageID = $this->search_iDB($filename,6,$subdir,7))							// image alredy imported
			return ($tmp_name)? $this->rebuildID($imageID):false;

		// IMPORT LOG ENTRY
		$filesize = filesize($filepath);
		$this->log('Importing '.$filename.' ('.$filesize.' Bytes)');

		// GENERATE NEW THUMBNAIL AND MEDIUM IMAGE
		@chmod($filepath, 0755);
		$imgs_size = $this->createthumb($filename, $subdir);

		// NEW DATABASE ENTRY
		if ($imgs_size) {
			$log_msg = date("Ymd, H.i.s : ") .' * finished creating thumbnail'. "\n";
			$imageID = ++$this->autoid;
			list($width, $height, $thumb_width, $thumb_height) = $imgs_size;
			$this->all_images[$imageID] = array(
													$imageID,			// image autoid		[0]
													$folder,				//  move in folder (#id)	[1]
													'',					// image headline		[2]
													'',					// image description	[3]
													time(),				// publishing date		[4]
													1,						// sorting position		[5]
													$filename,			// file name			[6]
													$subdir,				// subdir path			[7]
													$width,				// image width		[8]
													$height,				// image height		[9]
													$thumb_width,		// thumb width		[10]
													$thumb_height,		// thumb height		[11]
													$filesize,			// image file size		[12]
													'',					// exif date			[13]
													''						// Photographer		[14]
												 );
			$log_msg.= date("Ymd, H.i.s : ") .' = finished importing \''. $filename ."'\n";
			$log_msg.= date("Ymd, H.i.s : ") .' * finished adding file to database'. "\n";
			$this->log($log_msg, true);
			return true;
		}
		else {
			$this->log(' = ERROR: Can\'t importing \''. $filename .'\'');
			return false;
		}
	}

	// SEARCH ITEMS IN IMAGE DATABASE
	// kh_mod 0.2.0, add
	function search_iDB($string1, $field1, $string2, $field2) {
		if (is_array($this->all_images))
		foreach ($this->all_images as $record) {
			if ($record[$field1] == $string1 && $record[$field2] == $string2)
				return $record[0];
		}
		return false;
	}

	//
	// GET FOLDER NAME
	// kh_mod 0.2.0, changed
	function getfoldername($folderID) {
		if ($folderRC = $this->all_folders[$folderID])
			return ($folderRC[0] == '1')? $this->lang['root']:$folderRC[2];
		else
			return '';
	}

	//
	// MAKE A NEW FOLDER ACTION
	// kh_mod 0.2.0, changed
	function newfolder($infolder) {

		// IS NOT EXISTS FOLDER ID?
		if (!isset($this->all_folders[$infolder])) {
			$this->log('ERROR: Folder ID #'. $infolder .' not found! (function \'newfolder\')');
			$this->displaystatus($this->lang['nofolderid'] .' #'. $infolder);
			return false;
		}

		// CLEAN REQUEST VALUES
		$password = $this->chleaninput();

		// SAVE NEW FOLDER VALUES
		$fid		= ++$this->folderautoid;
		$sortby	= $_REQUEST['sortby'];
		$sortby |= $_REQUEST['direction'] << 4;
		$this->all_folders[$fid] = array(
											$fid,								// folder autoid			[0]
											$infolder,						// move in folder (#id)		[1]
											$_REQUEST['name'],			// folder name			[2]
											$_REQUEST['introtext'],		// introtext				[3]
											$_REQUEST['publish'],		// timestamp	(publish off)	[4]
											$_REQUEST['position'],		// folder position			[5]
											$_REQUEST['icon'],			// folder icon				[6]
											$sortby,							// folder sort mode		[7]
											$password,						// password				[8]
											0,									// number of cols			[9]
											0									// number of rows			[10]
										);
		$parentfolder = $this->getfoldername($infolder);
		if ($this->write_fDB('update')) {
			$this->log('Created folder \''. $_REQUEST['name'] .'\' in \''. $parentfolder .'\'');
			$this->status = $this->lang['foldercreated'] .' \''. $_REQUEST['name'] .'\'';
		} else {
			$this->log('Couldn\'t create folder \''. $_REQUEST['name'] .'\' in \''. $parentfolder .'\'');
			$this->status = $this->lang['iDB_error'];
		}
		include(ADMIN_FOLDER .'admin2_status.php');
	}

	// kh_mod 0.2.0, changed
	function editfolder($Calendar='') {
		$folderRC = $this->all_folders[$_REQUEST['editfolder']];
		if (!$folderRC) {
			$this->displaystatus($this->lang['nofolderid']);
			return false;
		}

		// FOLDER VALUES
		$folderID	= (int)$folderRC[0];
		$parentID	= (int)$folderRC[1];
		$foldername = $folderRC[2];
		$publish	   = $this->time2date($folderRC[4], true);
		$introtext  = $folderRC[3];
		$position   = $folderRC[5];

		// DISPLAY FOLDER DIALOG
		$icon = $this->get_foldericon($folderID);
		$page = (!empty($_REQUEST['page']))? $_REQUEST['page']:'1';
		$this->makefolderlist($folderID);
		include(ADMIN_FOLDER .'admin2_editfolder.php');

		return $folderID;
	}

	function updatefolder($list, $move) {

		// ROOT FOLDER?
		if ($list == '1') {
			$root	= true;		// kh_mod 0.1.0 b3, add
			$mid	= 'root';
		} else {
			$root	= false;		// kh_mod 0.1.0 b3, add
			$mid  = (isset($this->all_folders[$move]))? $move:false;
		}
		$fid = (isset($this->all_folders[$list]))? $list:false;

		// IS NOT EXISTS 'MOVETO' OR 'EDIT' FOLDER ID?
		if ($mid===false || $fid===false) {
			if ($mid===false) $this->log('ERROR: Moveto folder ID #'. $move .' not found! (function \'updatefolder\')');
			if ($fid===false) $this->log('ERROR: Edit folder ID #'. $list .' not found! (function \'updatefolder\')');
			$this->displaystatus($this->lang['nofolderid']);
			return false;
		}

		// CLEAN REQUEST VALUES
		$old_foldername = $this->all_folders[$fid][2];
		$password = $this->chleaninput($old_foldername, $root);			// kh_mod 0.1.0 b3, changed

		// SET NO SECONDS OF NEW DATE, kh_mod 0.2.0, changed
		$publish = $_REQUEST['publish'];
		if ($publish !== false) {
			$diffTime = $this->all_folders[$fid][4] - $publish;
			if (0 < $diffTime && $diffTime < 60) $publish = false;
		}

		// SAVE NEW VALUES
		if ($publish!==false)  $this->all_folders[$fid][4] = $publish;	// kh_mod 0.1.0 rc1, add
		if (!empty($password)) $this->all_folders[$fid][8] = $password;
		$this->all_folders[$fid][0]  = $fid;
		$this->all_folders[$fid][1]  = $mid;
		$this->all_folders[$fid][2]  = $_REQUEST['name'];
		$this->all_folders[$fid][3]  = $_REQUEST['introtext'];
		$this->all_folders[$fid][5]  = $_REQUEST['position'];
		$this->all_folders[$fid][6]  = $_REQUEST['icon'];
		$this->all_folders[$fid][7]  = $_REQUEST['sortby'];
		$this->all_folders[$fid][7] |= $_REQUEST['direction'] << 4;
		if ($_REQUEST['deletepassword'] == 1) {
			$this->all_folders[$fid][8] = '';
		}

		// kh_mod 0.1.0, add
		// SET THE POSITIONS OF IMAGES NEW
		if ($_REQUEST['generate'] == 'ok') $this->setposition($fid);

		// kh_mod 0.1.0, changed
		// WRITE FOLDER DATABASE AND UPDATE
		$fDB_ok = $this->write_fDB('update');
		if ($fDB_ok) {
			$this->log('Update of folder \''. $old_foldername .'\' complete.');
			$this->status = $this->lang['folderupdated'];
		} else {
			$this->log('Couldn\'t update folder \''. $old_foldername .'\'!');
			$this->status = $this->lang['foldererror'];
		}
		include(ADMIN_FOLDER .'admin2_status.php');
		return $fDB_ok;
		// end
	}

	//
	// CLEAN REQUEST VALUES FOR FOLDER
	// kh_mod 0.1.0, changed
	function chleaninput($old_fname='', $root=false) {

		// CHECK NEW FOLDER NAME
		$fname = $this->charfix($_REQUEST['name']);
		$fname = substr($fname,0,255);		// kh_mod 0.1.0 b3, add
		if (empty($fname) && !$root) {		// kh_mod 0.1.0 b3, changed
			$fname = (!empty($old_fname))? $old_fname
						:
						'autonamed#'. $_REQUEST['moveto'] .'_'. rand(1000,9999);
		}
		if ($old_fname != $fname && !($this->extendedset & 2)) {
			$folders	= $this->select($fname,$this->all_folders,2,0,0);
			$folders = $this->select($_REQUEST['moveto'],$folders,1,0,0);
		}
		$_REQUEST['name'] = (empty($folders))? $fname:$fname .'_autorenamed'. rand(1000,9999);

		// CLEAN INPUT VALUES
		$_REQUEST['sortby']    = (int)$_REQUEST['sortby'] & 15;
		$_REQUEST['direction'] = ($_REQUEST['direction']) ? 1:0;
		$_REQUEST['introtext'] = $this->charfix($_REQUEST['introtext']);
		$_REQUEST['introtext'] = @preg_replace('/\r\n|\r|\n/', '', $_REQUEST['introtext']);
		$_REQUEST['introtext'] = substr($_REQUEST['introtext'],0,4096);
		$_REQUEST['position']  = (int)$_REQUEST['position'];
		$_REQUEST['icon']		  = (int)$_REQUEST['icon'];

		// CONVERT DATE TO TIMESTAMP, kh_mod 0.1.0 b3, changed
		$_REQUEST['publish'] = $this->date2time($_REQUEST['publish']);

		// ENCRYPT PASSWORD
		return (!empty($_REQUEST['password'])) ? $this->hashPassword($_REQUEST['password']) : '';
	}

	//
	// GENERATE POSITION NUMBERS ACTION
	// kh_mod 0.1.0, add
	function setposition($folderID) {
		$sortrow = (int)$this->all_folders[$folderID][7] & 15;	// kh_mod 0.2.0, changed
		$sortdir = (int)$this->all_folders[$folderID][7] & 16;	// kh_mod 0.2.0, changed
		$images = $this->select($folderID,$this->all_images,1,$sortrow,$sortdir);
		if (count($images) > 1) {
			$pos = 10;
			foreach ($images as $record) {
				if ($record[5] < 0) continue;
				$this->all_images[$record[0]][5] = $pos;				// kh_mod 0.2.0, changed
				$pos+=10;
			}
			// WRITE IMAGE DATABASE AND UPDATE
			$this->write_iDB('update');
		}
	}

	//
	// REBUILD THUMBS AND MEDIUMS IMAGES ACTION
	// kh_mod 0.1.0, add
	function rebuildfolder($folderID) {
		$n_updated = 0;
		$images = $this->select($folderID,$this->all_images,1,0,0);
		if (count($images) > 0) {
			foreach ($images as $record) {
				if ($this->rebuildID($record[0])) $n_updated++;
			}
			// WRITE IMAGE DATABASE AND UPDATE
			if ($n_updated>0 && !$this->write_iDB('update')) {
				$this->status = $this->lang['iDB_error'];
				include(ADMIN_FOLDER .'admin2_status.php');
			}
		}
		else {
			$this->status = $this->lang['rebuildempty'];
			include(ADMIN_FOLDER .'admin2_status.php');
		}
		return $n_updated;
	}

	//
	// ASK DELETE FOLDER DIALOG
	// kh_mod 0.2.0, changed
	function askdelfolder($delfolder) {
		if (!isset($this->all_folders[$delfolder])) {
			$this->displaystatus($this->lang['nofolderid'] .' #'. $delfolder);
			return false;
		}

		// IS FOLDER EMPTY?
		$images  = $this->select($delfolder,$this->all_images,1,0,0);
		$folders = $this->select($delfolder,$this->all_folders,1,0,0);
		if (count($folders) > 0 || count($images) > 0) {
			$this->displaystatus($this->lang['foldernotempty']);
			return false;
		}

		// GET FOLDER ICON ITEMS (ARRAY)
		$icon = $this->get_foldericon($delfolder);
		include(ADMIN_FOLDER .'admin2_deletefolder.php');
	}

	//
	// DELETE FOLDER ACTION
	// kh_mod 0.1.0, changed
	function erasefolder($folderID) {
		if (!isset($this->all_folders[$folderID])) {
			$this->displaystatus($this->lang['nofolderid'] .' #'. $folderID);
			return '1';
		}

		$parentID   = $this->all_folders[$folderID][1];
		$foldername = $this->all_folders[$folderID][2];
		$parentname = $this->getfoldername($parentID);
		$del_ok = $this->array_delete($this->all_folders,$folderID);

		// WRITE FOLDER DATABASE AND UPDATE
		if ($del_ok && $this->write_fDB('update')) {
			$this->log('Folder \''.$foldername.'\' deleted from \''. $parentname .'\'');
			$this->status = $this->lang['folderdeleted'] .' \''. $foldername .'\'';
		} else {
			$this->log('Couldn\'t delete folder \''.$foldername.'\' from \''. $parentname .'\'');
			$this->status = $this->lang['foldernotdeleted'];
		}
		include(ADMIN_FOLDER .'admin2_status.php');
		return ($del_ok)? $parentID:$folderID;
	}

	//
	// GET FOLDER ICON
	// kh_mod 0.2.0, add
	function get_foldericon($folderID) {
		$iconfile = '';
		$selected = '';
		$imageID	  = (int)$this->all_folders[$folderID][6];
		if ($imageID > 0 && $folderID > 1) {
			$filename	  = $this->all_images[$imageID][6];
			$subdir		  = $this->all_images[$imageID][7];
			if ($iconfile = $this->get_path($filename, $subdir, 'thumb')) {
				$selected	  = $iconfile;
				$thumb_width  = (int)$this->all_images[$imageID][10];
				$thumb_height = (int)$this->all_images[$imageID][11];
				$class		  = 'class="thumb"';
			}
			else $imageID	  = 0;
		}

		// DISPLAY STANDARD FOLDER ICON?
		if (!$iconfile || !is_readable($iconfile) || ($this->folderseting & 16)) {
			$iconfile	  = ADMIN_FOLDER .'images/folder.gif';
			$thumb_width  = '150';
			$thumb_height = '100';
			$class		  = '';
		}

		// BUILD HTML ATTRIBUTES
		$attrb = 'class="'.$class.'" width="'.$thumb_width.'" height="'.$thumb_height.'"';

		return array('id'		=> $imageID,		// image ID for folder icon
						 'path'	=> $iconfile,		// thumb path for icon dislaying
						 'attrb'	=> $thumb_size,	// width, height and class for thumb
						 'thumb'	=> $selected		// selceted thumb for folder icon
						 );
	}

	//
	// CREATE THUMBNAIL AND MEDIUM IMAGE
	// kh_mod 0.2.0, changed
	function createthumb($filename, $subdir) {
		$message  = 'ERROR: Can\'t create thumb from '. $filename;
		$filepath = $this->get_path($filename, $subdir);
		if (!$filepath) {	$this->log($message .', invalid file path!'); return false;	}

		// TIME SETTING
		@set_time_limit(60);

		// SOURCEIMAGE
		$fileInfo	= getimagesize($filepath);
		$img_width	= $fileInfo[0];
		$img_height	= $fileInfo[1];
		$imagetype	= array(1=>'gif',2=>'jpg',3=>'png');
		$extension	= $imagetype[$fileInfo[2]];
		$src_img		= false;
		switch ($extension) {
			case 'jpg':	$src_img = @imagecreatefromjpeg($filepath); break;
			case 'png': $src_img = @imagecreatefrompng($filepath);  break;
			case 'gif': $src_img = @imagecreatefromgif($filepath);  break;
			default: $message.= ', extension isn\'t supported';
		}
		if (!$src_img) { $this->log($message .'!'); return false; }

		// IS MEDIUMSIZED IMAGE NEEDED
		$steps = 1;
		if ($this->mediumimage > 0)
		if (($img_width > $this->mediumimage) || ($img_height > $this->mediumimage)) {
			$mediumfile = $this->get_path($filename, $subdir, 'medium');
			// MEDIUMDSIZE PICTURE SETTINGS
			if (!is_file($mediumfile)) {
				$dst_filename = $mediumfile;
				$max_width	  = $this->mediumimage;
				$max_height	  = $this->mediumimage;
				$steps = 2;
			}
		}

		do {
			// THUMBSIZED PICTURE SETTINGS
			if ($steps==1) {
				$dst_filename = $this->get_path($filename, $subdir, 'thumb');
				$max_width	  = $this->thumbwidth;
				$max_height	  = $this->thumbheight;
			}
			if ($dst_filename == '') continue;

			// IF ORIGINAL SIZE SMALLER THEN MAX THUMBSIZE?
			if ($img_width <= $max_width && $img_height <= $max_height) {
				$max_width  = $img_width;
				$max_height = $img_height;
			}
			// CALCULATE THE SMALLER IMAGE SIDE
			elseif ($img_height < $img_width) {
				$max_height = (int)($max_width/$img_width * $img_height);
			} else {
				$max_width  = (int)($max_height/$img_height * $img_width);
			}
			// CREATE NEW PICTURE
			$dst_img = imagecreatetruecolor($max_width, $max_height);
			imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $max_width, $max_height, $img_width, $img_height);
			@touch($dst_filename); // workaround for 'safe mode' bug
			$create_ok = imagejpeg($dst_img, $dst_filename, $this->thumbquality);
			imagedestroy($dst_img);
			chmod($dst_filename,0775);
		}
		while (--$steps>0);
		imagedestroy($src_img);

		// RETURN THUMB AND IMAGE SETTINGS
		return ($create_ok)? array($img_width, $img_height, $max_width, $max_height):false;
	}

	function setup() {
		// GET LANGUAGES, kh_mod 0.1.0 b3, changed
		$workdir = opendir('lang');
		$exists  = false;
		while (false !== ($pointer = readdir($workdir))) {
			if (substr($pointer,0,1) !== '.') {
				$value = 'value="'.$pointer.'"';
				if ($this->defaultlang == $pointer) {
					$value .= ' selected="selected"';
					$exists = true;
				}
				$pointer = ucfirst(substr($pointer,0,(strlen($pointer)-4)));
				$lang[]  = array($value, $pointer);
			}
		}
		if (!$exists) $lang[] = array('value="" selected="selected"','--');
		sort($lang);

		// GET SKINS, kh_mod 0.1.0 b3, changed
		$workdir = opendir('skins');
		$exists  = false;
		while (false !== ($pointer = readdir($workdir))) {
			if (substr($pointer,0,1) !== '.' && $pointer !== 'admin') {
				$value = 'value="'.$pointer.'"';
				if ($this->activeskin == $pointer) {
					$value .= ' selected="selected"';
					$exists = true;
				}
				$skins[] = array($value, ucfirst($pointer));
			}
		}
		if (!$exists) $skins[] = array('value="" selected="selected"','--');
		sort($skins);

		$list = (int)$_REQUEST['fID'];
		$page = (int)$_REQUEST['page'];
		include(ADMIN_FOLDER .'admin2_setup.php');
	}

	function writesetup() {
		$_REQUEST['gallerytitle']	= $this->charfix($_REQUEST['gallerytitle']);
		$_REQUEST['copyright']		= $this->charfix($_REQUEST['copyright']);
		$_REQUEST['password']		= $this->charfix($_REQUEST['password']);
		$_REQUEST['websitelink']	= $this->charfix($_REQUEST['websitelink']);
		$_REQUEST["indexfile"]		= $this->charfix($_REQUEST["indexfile"], '/');		// kh_mod 0.1.0, add
		$_REQUEST['imagefolder']	= $this->charfix($_REQUEST['imagefolder'], '/');	// kh_mod 0.1.0, add
		$_REQUEST["defaultlang"]	= $this->charfix($_REQUEST["defaultlang"], '/');	// kh_mod 0.1.0, add
		$_REQUEST['extensions']		= str_replace(' ','',$_REQUEST['extensions']);		// kh_mod 0.1.0, add
		$ga4measurementid = strtoupper(trim(isset($_REQUEST['ga4measurementid']) ? $_REQUEST['ga4measurementid'] : ''));
		$ga4error = '';
		if ($ga4measurementid !== '' && !preg_match('/^G-[A-Z0-9]{4,20}$/D', $ga4measurementid)) {
			$ga4measurementid = $this->ga4measurementid;
			$ga4error = '<br /><br /><div style="color:red">Invalid GA4 Measurement ID. Use a value such as G-XXXXXXXXXX.</div>';
		}
		$this->ga4measurementid = $ga4measurementid;
		$_REQUEST["commentmode"]	= ($_REQUEST["commentmode"])?	 	1:0;					// kh_mod 0.1.0, add
		$_REQUEST["jsvalidate"]		= ($_REQUEST["jsvalidate"])?	 	1:0;					// kh_mod 0.1.0, add
		$_REQUEST["sendmail"]		= ($_REQUEST["sendmail"])?		 	1:0;					// kh_mod 0.1.0, add
		$this->commentsets			= ($_REQUEST["allowcomments"])?	1:0;					// kh_mod 0.1.0, add
		$this->commentsets		  |= ($_REQUEST["commentmode"])?	1<<1:0;					// kh_mod 0.1.0, add
		$this->commentsets		  |= ($_REQUEST["jsvalidate"])?	1<<2:0;					// kh_mod 0.1.0, add
		$this->commentsets		  |= ($_REQUEST["sendmail"])?		1<<3:0;					// kh_mod 0.1.0, add
		$this->commentsets		  |= ($_REQUEST["logip"])?			1<<6:0;					// kh_mod 0.2.0, add
		$this->metaseting				= ($_REQUEST["_gallery"])?			1:0;					// kh_mod 0.2.0, add
		$this->metaseting			  |= ($_REQUEST["_foldername"])?	1<<1:0;					// kh_mod 0.2.0, add
		$this->metaseting			  |= ($_REQUEST["_imagename"])?	1<<2:0;					// kh_mod 0.2.0, add
		$this->metaseting			  |= ($_REQUEST["_imagetitle"])?	1<<3:0;					// kh_mod 0.2.0, add
		$this->metaseting			  |= (int)$_REQUEST["_robots"]    <<4;						// kh_mod 0.2.1, changed
		$this->showexif				= ($_REQUEST["_make"])?				1:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_model"])?		1<<1:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_expotime"])?	1<<2:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_expocomp"])?	1<<3:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_aperture"])?	1<<4:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_focallen"])?	1<<5:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_iso"])?			1<<6:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_flash"])?		1<<7:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_original"])?	1<<8:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_software"])?	1<<9:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_datetime"])?	1<<10:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_colorspace"])?	1<<11:0;					// kh_mod 0.2.0, add
		$this->showexif			  |= ($_REQUEST["_artist"])?		1<<12:0;					// kh_mod 0.2.0, add
		$_REQUEST["samefolders"]	= ($_REQUEST["samefolders"])?	 	1:0;					// kh_mod 0.1.0, add
		$_REQUEST["htmlarea"]		= ($_REQUEST["htmlarea"])?		 	1:0;					// kh_mod 0.1.0, add
		$_REQUEST["tooltips"]		= ($_REQUEST["tooltips"])?		 	1:0;					// kh_mod 0.1.0, add
		$this->extendedset			= ($_REQUEST["pwdrecursiv"])?	 	0:1;					// kh_mod 0.2.0, changed
		$this->extendedset		  |= ($_REQUEST["samefolders"])?	1<<1:0;					// kh_mod 0.1.0, add
		$this->extendedset		  |= ($_REQUEST["htmlarea"])?		1<<2:0;					// kh_mod 0.1.0, add
		$this->extendedset		  |= ($_REQUEST["tooltips"])?		1<<3:0;					// kh_mod 0.1.0, add
		$this->extendedset		  |= ($_REQUEST["calendar"])?		1<<4:0;					// kh_mod 0.1.0, add
		$this->imagecolumns			= (int)$_REQUEST["imagecolumns"];						// kh_mod 0.1.0, add
		$this->imagerows				= (int)$_REQUEST["imagerows"];							// kh_mod 0.1.0, add
		$this->mediumimage			= (int)$_REQUEST["mediumimage"];							// kh_mod 0.1.0, add
		$this->introwidth				= (int)$_REQUEST["introwidth"];							// kh_mod 0.1.0, add
		$this->slideshowdelay		= (int)$_REQUEST["slideshowdelay"];						// kh_mod 0.2.0, add
		$this->navtype					= (int)$_REQUEST["navtype"];								// kh_mod 0.2.1, add
		$this->folderseting			= (int)$_REQUEST["foldersort"];							// kh_mod 0.2.0, changed
		$this->folderseting		  |= ($_REQUEST["foldericons"])?	1<<4:0;					// kh_mod 0.2.0, add
		$this->folderseting		  |= ($_REQUEST["displayfile"])?	1<<5:0;					// kh_mod 0.2.0, add

		// DATE FORMAT, kh_mod 0.1.0 b3, add
		switch ($_REQUEST["dateformat"]) {
			case  '1': $this->dateformat = '%d.%m.%Y'; 	 break;
			case  '2': $this->dateformat = '%d. %b., %Y'; break;
			case  '3': $this->dateformat = '%d. %b. %Y';	 break;
			case  '4': $this->dateformat = '%b. %d, %Y';	 break;
			case  '5': $this->dateformat = '%b. %e, %Y';	 break;
			case  '6': $this->dateformat = '%e.%m.%y';	 break;
			case  '7': $this->dateformat = '%m.%e.%y';	 break;
			case  '8': $this->dateformat = '%Y%m%d';		 break;
			case  '9': $this->dateformat = '%Y-%m-%d';	 break;
			case '10': $this->dateformat = '%d-%m-%Y';	 break;
			case '11': $this->dateformat = '%m-%d-%Y';	 break;
			case '12': $this->dateformat = '%d-%b-%Y';	 break;
			case '13': $this->dateformat = '%b-%d-%Y';	 break;
			case '14': $this->dateformat = '%d/%m/%Y';	 break;
			case '15': $this->dateformat = '%m/%d/%Y';	 break;
			case '16': $this->dateformat = '%e/%m %Y';	 break;
			default:	  $this->dateformat = '%d.%m.%Y';
		}

		// PASSWORD, kh_mod 0.1.0, changed
		if ($_POST['oldpassword'] != "" || $_POST['password'] != "" || $_POST['passwordconfirm'] != "") {
			if ($_POST['password'] != $_POST['passwordconfirm'] || md5(strrev(md5($_POST["oldpassword"]))) != $this->password) {
				$this->status = $this->lang['nopwdmatch'];
			} else {
				$_POST['password'] = trim($_POST['password']);
				$this->password = md5(strrev(md5($_POST["password"])));
				$_SESSION[PRE_SESSION."password"] = $this->password;
				$this->status = $this->lang['settingssaved'];
			}
		} else {
			$this->status = $this->lang['settingssaved'];
		}

		$this->status.= $ga4error;

		// ALLOWED FILE EXTENTIONS, kh_mod 0.2.0, add
		$this->extensions = strtolower($_REQUEST["extensions"]);
		$this->extensions = str_replace(' ','',$this->extensions);

		// THUMBNAIL SIZE, kh_mod 0.1.0, add
		if ((int)$_REQUEST["thumbwidth"]<5 || (int)$_REQUEST["thumbheight"]<5) {
			$_REQUEST["thumbwidth"]	 = $this->thumbwidth;
			$_REQUEST["thumbheight"] = $this->thumbheight;
			$this->status.= '<br /><br /><div style="color:red">'.$this->lang['nothumbsize'].'</div>';
		}

		// WEBMASTER EMAIL
		$email  = trim($_REQUEST["adminemail"]);
		$cClass = '[_a-z'.$this->lang['specialchars'].'0-9-]';
		$regexp = '/^'.$cClass.'+(\.'.$cClass.'+)*@'.$cClass.'+(\.'.$cClass.'+)*\.([a-z]{2,5})$/i';
		if ($email != '' && !@preg_match($regexp, $email)) {
			$email  = $this->adminemail;
			$this->status.= '<br /><br /><div style="color:red">'.$this->lang['emailerror'].'</div>';
		}

		// SET ACTIV SKIN, kh_mod 0.1.0 b3, add
		$activeskin = $this->charfix($_REQUEST["activeskin"], '/');
		if (!empty($activeskin) && is_readable('skins/'.$activeskin.'/templates')) {
			$this->activeskin = $activeskin;
		}

		// WRITE BUFFER
		$filebuffer = "<?php\n";
		$filebuffer.= '$mg2->gallerytitle = '.	chr(34).$_REQUEST["gallerytitle"].chr(34).";\n";
		$filebuffer.= '$mg2->adminemail = '.	chr(34).$email.chr(34).";\n";
		$filebuffer.= '$mg2->defaultlang = '.	chr(34).$this->defaultlang.chr(34).";\n";
		$filebuffer.= '$mg2->activeskin = '.	chr(34).$this->activeskin.chr(34).";\n";
		$filebuffer.= '$mg2->dateformat = '.	chr(34).$this->dateformat.chr(34).";\n";
		$filebuffer.= '$mg2->navtype = '.				  $this->navtype.";\n";								// kh_mod 0.2.1, changed
		$filebuffer.= '$mg2->showexif = '.				  $this->showexif.";\n";							// kh_mod 0.2.0, changed
		$filebuffer.= '$mg2->folderseting = '.			  $this->folderseting.";\n";						// kh_mod 0.2.0, changed
		$filebuffer.= '$mg2->marknew = '.		chr(34).$_REQUEST["marknew"].chr(34).";\n";
		$filebuffer.= '$mg2->copyright = '.		chr(34).$_REQUEST["copyright"].chr(34).";\n";
		$filebuffer.= '$mg2->password = '.		chr(34).$this->password.chr(34).";\n";
		$filebuffer.= '$mg2->extensions = '.	chr(34).$this->extensions.chr(34).";\n";				// kh_mod 0.1.0, changed
		$filebuffer.= '$mg2->mediumimage = '.	chr(34).$this->mediumimage.chr(34).";\n";
		$filebuffer.= '$mg2->introwidth = '.	chr(34).$this->introwidth.chr(34).";\n";				// kh_mod 0.1.0, add
		$filebuffer.= '$mg2->indexfile = '.		chr(34).$_REQUEST["indexfile"].chr(34).";\n";
		$filebuffer.= '$mg2->imagefolder = '.	chr(34).$_REQUEST["imagefolder"].chr(34).";\n";
		$filebuffer.= '$mg2->thumbquality = '.	chr(34).$_REQUEST["thumbquality"].chr(34).";\n";
		$filebuffer.= '$mg2->thumbwidth = '.	chr(34).$_REQUEST["thumbwidth"].chr(34).";\n";		// kh_mod 0.1.0, add
		$filebuffer.= '$mg2->thumbheight = '.	chr(34).$_REQUEST["thumbheight"].chr(34).";\n";		// kh_mod 0.1.0, add
		$filebuffer.= '$mg2->commentsets = '.			  $this->commentsets.";\n";						// kh_mod 0.2.0, changed
		$filebuffer.= '$mg2->metaseting = '.			  $this->metaseting.";\n";							// kh_mod 0.2.0, add
		$filebuffer.= '$mg2->imagecolumns = '.			  $this->imagecolumns.";\n";
		$filebuffer.= '$mg2->imagerows = '.				  $this->imagerows.";\n";
		$filebuffer.= '$mg2->slideshowdelay = '.		  $this->slideshowdelay.";\n";
		$filebuffer.= '$mg2->websitelink = '.	chr(34).$_REQUEST["websitelink"].chr(34).";\n";
		$filebuffer.= '$mg2->websitetext = '.	chr(34).$_REQUEST["websitetext"].chr(34).";\n";		// kh_mod 0.1.0, add
		$filebuffer.= '$mg2->ga4measurementid = '.chr(34).$this->ga4measurementid.chr(34).";\n";
		$filebuffer.= '$mg2->accesstime = '.	chr(34).$_REQUEST["accesstime"].chr(34).";\n";		// kh_mod 0.1.0, add
		$filebuffer.= '$mg2->extendedset = '.			  $this->extendedset.";\n";						// kh_mod 0.2.0, changed
		$filebuffer.= '$mg2->installdate = '.	chr(34).$this->installdate .chr(34).";\n";
		$filebuffer.= '?>';
		$fd = fopen(DATA_FOLDER .'mg2_settings.php','w');
		fwrite($fd,$filebuffer);
		fclose($fd);
		$this->log('Setup saved');
		include(ADMIN_FOLDER .'admin2_status.php');
	}

	// kh_mod 0.2.0, changed
	function movefiles() {
		$moveto = (int)$_REQUEST['moveto'];
		if (!isset($this->all_folders[$moveto])) {
			$this->displaystatus($this->lang['nofolderid'] .' #'. $moveto);
			return false;
		}

		$selected_num = 0;
		$selected_max = (int)$_REQUEST['selectsize'];
		for ($i=0; $i < $selected_max; $i++) {
			$imageID = (int)$_REQUEST['selectfile'. $i];
			if (empty($imageID))								continue;
			if (!isset($this->all_images[$imageID]))	continue;

			$this->all_images[$imageID][1] = $moveto;
			$selected_num++;
		}
		// DISPLAY STATUS MESSAGE
		$movefolder = $this->getfoldername($moveto);
		if ($selected_num < 1) {
			$this->log('ERROR: No file selected to move!');
			$this->status = $this->lang['filenotselected'];
		}
		elseif ($this->write_iDB('update')) {
			$this->log('Moved '.$selected_num.' file(s) to \''. $movefolder .'\'');
			$this->status = $selected_num .' '. $this->lang['filesmovedto'] .': <a href=';
			$this->status.= '"admin.php?fID='.$moveto.'">'. $movefolder .'</a>'; 
		} else {
			$this->log('ERROR: Couldn\'t move '. $selected_num .' files to \''. $movefolder. '\'!');
			$this->status = $this->lang['iDB_error'];
		}
		include(ADMIN_FOLDER .'admin2_status.php');
	}

	//
	// EDIT COMMENT DIALOG
	// kh_mod 0.2.0, changed
	function editcomment($imageID) {
		if (!isset($this->all_images[$imageID])) {
			$this->status = $this->lang['nopictureid'] .' #'. $imageID;
			return false;
		}

		$imageRC   = $this->all_images[$imageID];
		$imageID	  = $imageRC[0];
		$filename  = $imageRC[6];
		$folderID  = $imageRC[1];
		$subdir	  = $imageRC[7];
		$commfile  = $this->get_path($filename, $subdir, 'comment');
		$commentID = (int)substr($_REQUEST['editcomment'],3);
		$num_comments = (is_array($this->comments[$commentID]))?
							 count($this->comments)
							 :
							 $this->readcomments($commfile);
		if (isset($this->comments[$commentID])) {
			$comment = array();
			$comment['date']	= $this->time2date($this->comments[$commentID][4], true);
			$comment['name']	= $this->comments[$commentID][1];
			$comment['email']	= $this->comments[$commentID][2];
			$comment['body']	= $this->comments[$commentID][3];
			$comment['body']	= @preg_replace('/<br\s*\/?>/', "\n", $comment['body']);
			include(ADMIN_FOLDER .'admin2_editcomment.php');
			$comment_display = true;
		}
		else {
			$this->status = $this->lang['nocommentid'] .' ID #'.$commentID;
			$this->status.= '<br />\''. $commfile. '\'';
			$comment_display = false;
		}
		return $comment_display;
	}

	//
	// UPDATE COMMENT ACTION
	// kh_mod 0.2.0, changed
	function updatecomment($imageID) {
		$update_ok = false;
		do {
			// EXISTS IMAGE ID?
			if (!isset($this->all_images[$imageID])) {
				$this->status = $this->lang['nopictureid'] . ' #'. $imageID; break;
			}

			// BELONG IMAGE ID TO RECORD?
			if ($this->all_images[$imageID][0] != $imageID) {
				$this->status = $this->lang['nopictureid'] . ' #'. $imageID; break;
			}

			// READ COMMENT FILE
			$filename = $this->all_images[$imageID][6];
			$subdir	 = $this->all_images[$imageID][7];
			$commfile = $this->get_path($filename, $subdir, 'comment');
			if (!$this->readcomments($commfile)) {
				$this->status = $this->lang['commentnotread'];	break;
			}

			// CHECK COMMENT ID
			$commentID = (int)substr($_REQUEST['updatecomment'],3);
			if (!isset($this->comments[$commentID])) {
				$this->status = $this->lang['nocommentid'] .' #'. $commentID; break;
			}

			// GET AND CLEAN COMMENT CHANGES
			if (!$this->cleancomment($commentID, false)) break;

			// WRITE COMMENT FILE
			if ($update_ok = $this->writecomments($commfile)) {
				$this->status = $this->lang['commentupdated'] .' \''.$filename.'\'';
			} else {
				$this->status = $this->lang['commenterror'];
			}
		} while(0);

		// DISPLAY STATUS MESSAGE
		include(ADMIN_FOLDER .'admin2_status.php');
		return ($update_ok)? $commentID:false;
	}

	//
	// DELETE COMMENT DIALOG
	// kh_mod 0.2.0, changed
	function askdelcomment($imageID) {
		if (!isset($this->all_images[$imageID])) {
			$this->status = $this->lang['nopictureid'] . ' #'. $imageID;
			return false;
		}

		$imageRC   	  = $this->all_images[$imageID];
		$imageID		  = $imageRC[0];
		$folderID	  = $imageRC[1];
		$filename	  = $imageRC[6];
		$subdir		  = $imageRC[7];
		$thumb_width  = $imageRC[10];
		$thumb_height = $imageRC[11];
		$commfile	  = $this->get_path($filename, $subdir, 'comment');
		$commentID	  = (int)substr($_REQUEST['deletecomment'],3);
		$num_comments = $this->readcomments($commfile);
		if (isset($this->comments[$commentID])) {
			$comment = array();
			$comment['date']	= $this->time2date($this->comments[$commentID][4], true);
			$comment['name']	= $this->comments[$commentID][1];
			$comment['email']	= $this->comments[$commentID][2];
			$comment['body']	= $this->comments[$commentID][3];
			$thumbfile = $this->get_path($filename, $subdir, 'thumb');
			if (!is_readable($thumbfile)) $thumbfile = ADMIN_FOLDER .'images/1x1.gif';
			$message	= $this->lang['commentconfirm'];
			$cancel	= 'admin.php?editID='.$imageID;
			$href_ok = 'admin.php?editID='.$imageID.'&amp;action=deletecomments&amp;comment0='. $commentID .'&amp;selectsize='.$num_comments;
			$display	= 'comment';
			include(ADMIN_FOLDER .'admin2_delete.php');
			$comment_display = true;
		}
		else {
			$this->status = $this->lang['nocommentid'] .' ID #'.$commentID;
			$this->status.= '<br />\''. $commfile. '\'';
			$comment_display = false;
		}
		return $comment_display;
	}

	//
	// DELETE COMMENT ACTION
	//  kh_mod 0.2.0, changed
	function deletecomments($imageID) {
		if (!isset($this->all_images[$imageID])) {
			$this->status = $this->lang['nopictureid'] . ' #'. $imageID;
			return false;
		}

		$filename = $this->all_images[$imageID][6];
		$subdir   = $this->all_images[$imageID][7];
		$comment_file	= $this->get_path($filename, $subdir, 'comment');
		$count_comments	= $this->readcomments($comment_file);
		$displ_comments	= (int)$_REQUEST['selectsize'];
		if ($count_comments < $displ_comments) $displ_comments = $count_comments;

		$count_todelete = 0;
		if ($count_comments) {
			for ($i = 0; $i < $displ_comments; $i++) {
				$commentID = (int)$_REQUEST['comment'. $i];
				if (isset($this->comments[$commentID])) {
					$count_todelete++;
					$this->array_delete($this->comments, $commentID);
				}
			}
			if ($count_todelete > 0) {
				$message = 'Deleted temporarily '. $count_todelete .' of '. $count_comments;
				$message.= ' comment(s) for image ID #'. $imageID;
				$this->log($message);
				if (count($this->comments) > 0)
					$wrt_ok = $this->writecomments($comment_file);
				elseif ($del_ok = @unlink($comment_file))
					$this->log('Deleted comment file \''. $comment_file .'\'');
				else
					$this->log('ERROR: Couldn\'t delete comment file \''. $comment_file .'\'');
			}
		}
		// DISPLAY STATUS MESSAGE
		if ($count_todelete < 1 && $filename) {
			$this->log('ERROR: No comment selected to delete!');
			$this->status = $this->lang['commentnotselected'];
		} elseif ($wrt_ok) {
			$this->status = $count_todelete .' ';
			$this->status.= $this->lang['commentsdeleted'] .' \'';
			$this->status.= $filename .'\'';
		} elseif ($del_ok) {
			$this->status = $this->lang['filedeleted'] .' \'';
			$this->status.= $filename .'.comment\'';
		} else {
			$this->status = 'ERROR: Couldn\'t delete comment(s) for ID #'. $imageID;
		}
		include(ADMIN_FOLDER .'admin2_status.php');
	}

	//
	// DELETE DATABASE ENTRY
	// kh_mod 0.2.0, changed
	function array_delete(&$array, $index) {
		if (!is_array($array)) return false;

		unset($array[$index]);
		return (isset($array[$index]))? false:true;
	}

	//
	// MAKE FOLDER TREE
	// kh_mod 0.2.0, changed
	function makefolderlist($list='-1') {
		$this->sortedfolders = array();
		foreach ($this->all_folders as $record) {
			$folderID   = $record[0];
			$circlelink = false;
			$folderpath = array();
			while ((int)$folderID > 1) {
				if ($folderID == $list) $circlelink = true;
				$folderRC = $this->all_folders[$folderID];
				$folderpath[$folderID] = $folderRC[2];
				$folderID				  = $folderRC[1];
				if (!empty($folderpath[$folderID])) break;
			}
			$fullpath = implode(' : ', array_reverse($folderpath));
			$this->sortedfolders[$record[0]] = array($fullpath, $record[1], $circlelink);
		}
		@asort($this->sortedfolders);

		//SET ROOT NAME
		if ($this->sortedfolders[1]) $this->sortedfolders[1][0] = $this->lang['root'];
	}

	//
	// GET SUBDIRECTORIES OF PICTURE DIR
	// kh_mod 0.2.0, add
	function get_subdirs($dir='', $level='') {
		$input = array();
		$fp	 = opendir($this->imagefolder . $dir);
		while ($node = readdir($fp)) {
			$sub = $dir .'/'. $node;
			if (@is_dir($this->imagefolder . $sub) && $node[0] != '.') {
				$tab = $level . '&nbsp;&nbsp;&nbsp;|';
				$wra = (is_writeable($this->imagefolder . $sub))? true:false;
				$input[]	= array($sub, $tab, $node, $wra);
				$input	= array_merge($input, $this->get_subdirs($sub, $tab));
			}
		}
		closedir($fp);
		return $input;
	}

	//
	// ADMIN PAGE NAVIGATION
	// kh_mod 0.2.0, changed
	function adminpagenavigation($list,$npages,$page) {
		$dislpay = '';
		if ($npages > 1) {
			$arrnav[] = ' - '. $this->lang['page'];
			for ($i=1; $i <= $npages; $i++) {
				$arrnav[] = ($page == $i)?
								$i
								:
								'<a href="admin.php?fID='. $list .'&amp;page='.$i.'">'. $i .'</a>';
			}
			$arrnav[] = ($page == 'all')?
							$this->lang['all']
							:
							'<a href="admin.php?fID='. $list .'&amp;page=all">'. $this->lang['all'] .'</a>';
			$dislpay = implode(' | ', $arrnav);							
		}
		return $dislpay;
	}

	// kh_mod 0.1.0, changed
	function rotateimage($imageID) {

		// EXISTS IMAGEROTATE FUNCTION
		if (!function_exists(imagerotate)) {
			$this->log('ERROR: GD function imagerotate missing!');
			$this->displaystatus('ERROR: GD function imagerotate missing!');
			return false;
		}

		if (!isset($this->all_images[$imageID])) {
			$this->displaystatus($this->lang['nopictureid'] . ' #'. $imageID);
			return false;
		}

		// GET IMAGE PATH
		$filename = $this->all_images[$imageID][6];
		$subdir	 = $this->all_images[$imageID][7];
		$filepath = $this->get_path($filename, $subdir);

		$rot_ok = false;
		if (is_readable($filepath)) {

			// GET IMAGE FORMAT
			$fileInfo  = getimagesize($filepath);
			$imagetype = array(1=>'gif',2=>'jpg',3=>'png');
			$extension = $imagetype[$fileInfo[2]];

			// ROTATE IMAGE
			$degrees = ($_REQUEST['direction'] == 'left')? 90:-90;
			if ($extension == 'jpg') {
				$source = imagecreatefromjpeg($filepath);
				if ($rotate = imagerotate($source, $degrees, 0)) {
					chmod($filepath, 0644); // workaround for 'safe mode' bug
					$rot_ok = imagejpeg($rotate, $filepath, 100);
				}
			} elseif ($extension == 'png') {
				$source = imagecreatefrompng($filepath);
				if ($rotate = imagerotate($source, $degrees, 0)) {
					unlink($filepath);
					$rot_ok = imagepng($rotate, $filepath);
				}
			} elseif ($extension == 'gif' && (imagetypes() & IMG_GIF)) {
				$source = imagecreatefromgif($filepath);
				if ($rotate = imagerotate($source, $degrees, 0)) {
					unlink($filepath);
					if (function_exists('imagegif'))
						$rot_ok = imagegif($rotate, $filepath);
					else
						$rot_ok = imagepng($rotate, $filepath);
				}
			}
		}

		// ROTATE OK, UPDATE THUMB AND MEDIUM IMAGE
		if ($rot_ok) {
			$this->log('Rotated image #'. $imageID .' to '. $direction .' (\''. $filename .'\')');
			$this->status = $this->lang['imagerotated'] .' '. $degrees .'&#176;';
			include(ADMIN_FOLDER .'admin2_status.php');

			// WRITE IMAGE DATABASE AND UPDATE
			if (!$this->rebuildID($imageID) || !$this->write_iDB('update')) {
				$this->log('ERROR: Couldn\'t update image database!');
				$this->status = $this->lang['iDB_error'] .' <a href="admin.php?rebuildID='. $imageID;
				$this->status.= '&amp;editID='.$imageID.'">'. $this->lang['tryitagain']. '</a>?';
				include(ADMIN_FOLDER .'admin2_status.php');
			}
		}
		elseif ($extension == 'gif' && !(imagetypes() & IMG_GIF)) {
			$this->log('ERROR: GIF files can\'t be rotated due to limitations in GD lib!');
			$this->status = $this->lang['gifnotrotated'];
			include(ADMIN_FOLDER .'admin2_status.php');
		}
		else {
			$this->log('Couldn\'t rotate image #'. $imageID .' to '. $direction);
			$this->status = $this->lang['imagenotrotated'];
			include(ADMIN_FOLDER .'admin2_status.php');
		}
	}

	//
	// WRITE IMAGE DATABASE
	// kh_mod 0.2.0, changed
	function write_iDB($update=false) {
		$error = '';
		if (!is_array($this->all_images))
			$error = $this->log('\'$this->all_images\' isn\'t an array!');
		elseif (count($this->all_images) < 1)
			$error = $this->log('Array \'$this->all_images\ is empty!');
		if ($error) {
			$this->log('ERROR: Couldn\'t write image database - '. $error);
			return false;
		}

		$iDB_temp = DATA_FOLDER .'mg2db_idatabase_temp.php';
		$fok		 = false;
		$buffer	 = $this->autoid ."\n";
		foreach ($this->all_images as $record) {
			$buffer.= '#';
			$buffer.= @implode("\t",$record);
			$buffer.= "\n";
		}
		$fd = fopen($iDB_temp, 'w');
		if (flock($fd, LOCK_EX)) {		// do an exclusive lock
			ftruncate($fd, 0);
			$fok = fwrite($fd, $buffer);
			flock($fd, LOCK_UN);			// release the lock
			fclose($fd);
			if ($fok!==false) $this->log('Writing temp image database file');
		} else {
			$this->log('ERROR: Could not lock image database file for writing');
			echo 'MG2 ERROR: Could not lock temp file (function \'write_iDB\')';
		}
		if ($fok!==false && $update) $this->updateDB('i');
		return $fok;
	}

	//
	// WRITE FOLDER DATABASE
	// kh_mod 0.2.0, changed
	function write_fDB($update=false) {
		$error = '';
		if (!is_array($this->all_folders))
			$error = $this->log('\'$this->all_folders\' isn\'t an array!');
		elseif (count($this->all_folders) < 1)
			$error = $this->log('Array \'$this->all_folders\ is empty!');
		if ($error) {
			$this->log('ERROR: Couldn\'t write folder database - '. $error);
			return false;
		}

		$fDB_temp = DATA_FOLDER .'mg2db_fdatabase_temp.php';
		$fok		 = false;
		$buffer	 = $this->folderautoid ."\n";
		foreach ($this->all_folders as $record) {
			$buffer.= '#';
			$buffer.= @implode("\t",$record);
			$buffer.= "\n";
		}
		$fd = fopen($fDB_temp, 'w');
		if (flock($fd, LOCK_EX)) {		// do an exclusive lock
			ftruncate($fd, 0);
			$fok = fwrite($fd, $buffer);
			flock($fd, LOCK_UN);			// release the lock
			fclose($fd);
			if ($fok!==false) $this->log('Writing temp folder database file');
		} else {
			$this->log('ERROR: Couldn\'t lock folder database file for writing');
			echo 'MG2 ERROR: Couldn\'t lock temp file (function \'write_fDB\')';
		}
		if ($fok!==false && $update) $this->updateDB('f');
		return $fok;
	}

	//
	// UPDATE DATABASE FROM TEMP FILES
	// kh_mod 0.2.0, changed
	function updateDB($db='all') {

		// IMAGE DATABASE
		$iDB = DATA_FOLDER .'mg2db_idatabase.php';
		$iDB_temp = DATA_FOLDER .'mg2db_idatabase_temp.php';
		if (($db == 'all' || $db == 'i') && is_file($iDB_temp)) {
			if (!copy($iDB_temp, $iDB)) {
				$this->log('ERROR: Failed to copy temporary image database file');
				echo 'MG2 ERROR: Failed to copy temp file (function \'readDB\')';
				exit();
			}
			else $this->log('Updated image database from temporary file');
		}

		// FOLDER DATABASE
		$fDB = DATA_FOLDER .'mg2db_fdatabase.php';
		$fDB_temp = DATA_FOLDER .'mg2db_fdatabase_temp.php';
		if (($db == 'all' || $db == 'f') && is_file($fDB_temp)) {
			if (!copy($fDB_temp, $fDB)) {
				$this->log('ERROR: Failed to copy temporary folder database file');
				echo 'MG2 ERROR: Failed to copy temp file (function \'readDB\')';
				exit();
			}
			else $this->log('Updated folder database from temporary file');
		}
	}

	function db_backup() {
		$timestamp = strftime('%Y%m%d%H%M'); // kh_mod 0.2.0, add
		copy(DATA_FOLDER .'mg2db_idatabase.php', DATA_FOLDER . $timestamp .'_mg2db_idatabase.php');
		copy(DATA_FOLDER .'mg2db_fdatabase.php', DATA_FOLDER . $timestamp .'_mg2db_fdatabase.php');
		$this->status = $this->lang['backupcomplete'];
		$this->log('Database backup complete');
		include(ADMIN_FOLDER .'admin2_status.php');
	}

	function check_new_version() {
		$url_parsed = parse_url('http://www.minigal.dk/mg2_scriptversion.php');
		$path = $url_parsed['path'];
		if ($url_parsed["query"] != '')
			$path .= '?'. $url_parsed['query'];

		$out = "GET $path HTTP/1.0\r\nHost:". $url_parsed['host'] ."\r\n\r\n";
		$fp = @fsockopen($url_parsed['host'], 80, $errno, $errstr, 1);

		if (!$fp) {
			return "$errstr ($errno)<br />\n";
		} else {
			fwrite($fp, $out);
			$body = false;
			while (!feof($fp)) {
				$mainversion = fgets($fp, 1024);

				// If the server is down/file is gone.
				if ($mainversion == "HTTP/1.1 404 Not Found\r\n") return;

				//Clever little thing to remove the header.
				if ($body) $in[] = explode("*",$mainversion);
				if ( $mainversion == "\r\n" ) $body = true;
			}
		}
		fclose($fp);
		switch (version_compare(trim($mainversion),$this->version)) {
		case 0:
			echo '<h2>'. $this->lang['version1'] .'</h2>';
			break;
		case 1:
			echo '<h3>'. str_replace('X', $mainversion, $this->lang['version2']) .'</h3>';
			echo '<a href="http://www.minigal.dk/download.php" target="_blank">'. $this->lang['goto'] .' www.minigal.dk</a><br />';
			break;
		case -1:
			echo '<h4>'. $this->lang['version3'] .'</h4>';
			echo '<a href="http://www.minigal.dk/download.php" target="_blank">'. $this->lang['goto'] .' www.minigal.dk</a><br />';
			break;
		}
	}
}	// END CLASS' MG2admin'
?>
