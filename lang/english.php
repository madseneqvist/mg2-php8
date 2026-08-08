<?php
/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
//                                    MG2 LANGAUGE FILE:                               //
//                                  http://www.minigal.dk                              //
//                                                                                     //
//                                         English                                     //
//                                                                                     //
//                               TRANSLATED BY: Thomas Rybak                           //
//                               EMAIL: support@minigal.dk                             //
//                                                                                     //
//                               LAST UPDATED: 11. May 2007                            //
//                                                                                     //
//         You are welcome to translate this file into your own language, but          //
//         be sure to check the Addon directory if your langauge is already            //
//         supported (http://addons.minigal.dk)                                        //
//                                                                                     //
//         Submit translated/updated language files to support@minigal.dk              //
//                                                                                     //
//         HOW TO TRANSLATE THIS FILE:                                                 //
//         Only edit the text to the right of the equal signs. Translate               //
//         this text to the language of your choice.                                   //
//         It is recommended to keep the letter cases intact in the                    //
//         finished translation. This will look the best.                              //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////

// CHARSET INFORMATION AND LANGUAGE
$mg2->charset		= "utf-8";
$mg2->activelang	= "en";		// kh_mod 0.1.0 b3, add

//GALLERY LANGUAGE STRINGS
$mg2->lang['specialchars']								= "";										// kh_mod 0.1.0 b3, add
$mg2->lang['wronglogin']								= "Wrong password, try again!";	// kh_mod 0.1.0 b3, add
$mg2->lang['gallery']									= "Gallery";
$mg2->lang['of']											= "of";
$mg2->lang['first']										= "First";
$mg2->lang['prev']										= "Previous";
$mg2->lang['next']										= "Next";
$mg2->lang['last']										= "Last";
$mg2->lang['thumbs']										= "Thumbs";
$mg2->lang['exif_info']									= "Exif Information";				// kh_mod 0.2.0, changed
$mg2->lang['model']										= "Model";
$mg2->lang['shutter']									= "Exposure time";					// kh_mod 0.1.0 rc1, changed
$mg2->lang['viewslideshow']							= "View slideshow";
$mg2->lang['stopslideshow']							= "Stop slideshow";
$mg2->lang['aperture']									= "Aperture";
$mg2->lang['flash']										= "Flash";
$mg2->lang['focallength']								= "Focal length";
$mg2->lang['mm']											= "mm";
$mg2->lang['exposurecomp']								= "Exposure compensation";
$mg2->lang['original']									= "Original";
$mg2->lang['metering']									= "Metering";
$mg2->lang['iso']											= "ISO";
$mg2->lang['seconds']									= "s";
$mg2->lang['page']										= "Page";
$mg2->lang['all']											= "All";
$mg2->lang['fullsize']									= "View fullsize image";
$mg2->lang['addcomment']								= "Add comment";
$mg2->lang['name']										= "Name";
$mg2->lang['email']										= "Email";
$mg2->lang['commentadded']								= "Comment added";
$mg2->lang['commenterror']								= "ERROR: Comment could not add!";		// kh_mod 0.1.0, add
$mg2->lang['commentexists']							= "ADVICE: Comment already exists!";	// kh_mod 0.1.0, changed
$mg2->lang['commentmissing']							= "ERROR: All comment fields must be filled!";
$mg2->lang['emailerror']								= "ERROR: eMail-Adress is incorrect!";	// kh_mod 0.1.0, add
$mg2->lang['enterpassword']							= "Enter password";
$mg2->lang['thissection']								= "This section is password protected";
// added in kh_mod 0.2.0
$mg2->lang['filenotreadable']							= "ERROR: File not readable!";

// ADMIN LANGUAGE STRINGS
$mg2->lang['months']										= array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"); // kh_mod 0.1.0 b3, add
$mg2->lang['root']										= "Root";
$mg2->lang['thumb']										= "Thumb";
$mg2->lang['dateadded']									= "Publication date";				// kh_mod 0.1.0, changed
$mg2->lang['upload']										= "Upload files";
$mg2->lang['sourcefolder']								= "Source folder";					// kh_mod 0.1.0, add
$mg2->lang['import']										= "Import uploaded files to";
$mg2->lang['newfolder']									= "New folder";
$mg2->lang['viewgallery']								= "View gallery";
$mg2->lang['setup']										= "Setup";
$mg2->lang['logoff']										= "Log off";
$mg2->lang['menutxt_upload']							= "Upload";
$mg2->lang['menutxt_import']							= "Import";
$mg2->lang['menutxt_newfolder']						= "New folder";
$mg2->lang['menutxt_viewgallery']					= "View gallery";
$mg2->lang['menutxt_setup']							= "Setup";
$mg2->lang['menutxt_logoff']							= "Logoff";
$mg2->lang['delete']										= "Delete";
$mg2->lang['cancel']										= "Cancel";
$mg2->lang['ok']											= "Ok";
$mg2->lang['deletefolder']								= "Delete folder";
$mg2->lang['navigation']								= "Navigation";
$mg2->lang['images']										= "image(s)";
$mg2->lang['filename']									= "Filename";
$mg2->lang['title']										= "Title";
$mg2->lang['position']									= "Position";							// kh_mod 0.1.0, add
$mg2->lang['setpositions']								= "Set positions of images new";	// kh_mod 0.1.0, add
$mg2->lang['publish']									= "Publishing";						// kh_mod 0.1.0, add
$mg2->lang['notpublished']								= "Publishing on";					// kh_mod 0.1.0, add
$mg2->lang['nodisplay']								   = "No display";						// kh_mod 0.1.0, add
$mg2->lang['calendar']									= "Calendar";							// kh_mod 0.1.0, add
$mg2->lang['description']								= "Description";
$mg2->lang['setasthumb']								= "Set as folder thumb";
$mg2->lang['editfolder']								= "Edit folder";
$mg2->lang['editimage']									= "Edit image";
$mg2->lang['nofolderselected']						= "No folder selected";
$mg2->lang['foldername']								= "Folder name";
$mg2->lang['samefolders']								= "Allow same folder names";		// kh_mod 0.1.0, add
$mg2->lang['newpassword']								= "New password";
$mg2->lang['deletepassword']							= "Delete password";
$mg2->lang['introtext']									= "Intro text";
$mg2->lang['introwidth']								= "Width of intro text (0 = disable)";// kh_mod 0.1.0, add
$mg2->lang['moveto']										= "Move to";
$mg2->lang['iID']											= "Id";
$mg2->lang['filesize']									= "Filesize";
$mg2->lang['width']										= "Width";
$mg2->lang['height']										= "Height";
$mg2->lang['date']										= "Date";
$mg2->lang['ascending']									= "Ascending";
$mg2->lang['descending']								= "Descending";
$mg2->lang['newfolder']									= "New folder";
$mg2->lang['password']									= "Password";
$mg2->lang['sortby']										= "Sort by";
$mg2->lang['direction']									= "Direction";
$mg2->lang['sortfolder']								= "<sup>*</sup>Sort folder by foldername";		// kh_mod 0.1.0, add
$mg2->lang['gallerytitle']								= "Gallery title";
$mg2->lang['adminemail']								= "Admin email";
$mg2->lang['language']									= "Language";
$mg2->lang['skin']										= "Skin";
$mg2->lang['dateformat']								= "Date format";
$mg2->lang['foldericons']								= "Force folder icons";
$mg2->lang['displayfile']								= "Display file name under thumbnails";			// kh_mod 0.1.0, add
$mg2->lang['foldersort']								= "Force all folders sort by";						// kh_mod 0.1.0, add
$mg2->lang['foldersetup']								= "Folder setup";											// kh_mod 0.1.0, add
$mg2->lang['allowcomments']							= "Show comments";										// kh_mod 0.1.0, changed
$mg2->lang['jsvalidate']								= "Verify by JavaScript";								// kh_mod 0.1.0, add
$mg2->lang['navtype']									= "Navigation type";										// kh_mod 0.1.0, add
$mg2->lang['copyright']									= "Copyright notice";
$mg2->lang['passwordchange']							= "Change password (3 x blank = keep current)";
$mg2->lang['oldpasswordsetup']						= "Enter current password (admin)";					// kh_mod 0.1.0, changed
$mg2->lang['newpasswordsetup']						= "New Password (blank = use current)";
$mg2->lang['newpasswordsetupconfirm']				= "Enter new password again";
$mg2->lang['advanced']									= "Advanced";
$mg2->lang['indexfile']									= "Gallery index file";
$mg2->lang['imagefolder']								= "Image folder";											// kh_mod 0.1.0, add
$mg2->lang['allowedextensions']						= "Allowed extensions";
$mg2->lang['imgwidth']									= "Max. image size (0 = disable)";					// kh_mod 0.1.0, changed
$mg2->lang['thumbquality']								= "Thumbnail quality in %";							// kh_mod 0.1.0, changed
$mg2->lang['thumbwidth']								= "Thumbnail max. width in pixel";					// kh_mod 0.1.0, add
$mg2->lang['thumbheight']								= "Thumbnail max. height in pixel";					// kh_mod 0.1.0, add
$mg2->lang['image']										= "Image";
$mg2->lang['edit']										= "Edit";
$mg2->lang['editcurrentfolder']						= "Edit current folder";
$mg2->lang['deletecurrentfolder']					= "Delete current folder";
$mg2->lang['by']											= "by";
$mg2->lang['loginagain']								= "Login again";
$mg2->lang['securitylogoff']							= "Security logoff";
$mg2->lang['autologoff']								= "You have been automatically logged off after $mg2->accesstime minutes of inactivity.";	// kh_mod 0.1.0, changed
$mg2->lang['logoff']										= "Log off";
$mg2->lang['forsecurity']								= "For security reasons, it is recommended to close this browser window.";
$mg2->lang['updatesuccess']							= "Update successful";
$mg2->lang['iDB_error']									= "ERROR: Couldn't update image database!";						// kh_mod 0.1.0, add
$mg2->lang['fDB_error']									= "ERROR: Couldn't update folder database!";						// kh_mod 0.1.0, add
$mg2->lang['nopictureid']								= "ERROR: Picture-ID ".$_REQUEST['iID']." not found!";			// kh_mod 0.1.0, add
$mg2->lang['renamefailure']							= "ERROR: Filename contains illegal characters!";
$mg2->lang['filenotdeleted']							= "ERROR: Couldn't delete file!";									// kh_mod 0.1.0, add
$mg2->lang['filenotfound']								= "ERROR: File not found!";											// kh_mod 0.1.0, changed
$mg2->lang['filenotselected']							= "ERROR: No file selected!";											// kh_mod 0.1.0, add
$mg2->lang['nofilestoimport']							= "No files to import!";												// kh_mod 0.1.0, changed
$mg2->lang['alreadyexists']							= "already exists file(s) have not been uploaded!";			// kh_mod 0.1.0, add
$mg2->lang['nofolderid']								= "ERROR: Folder-ID not found!";										// kh_mod 0.1.0, add
$mg2->lang['foldernotempty']							= "ERROR: Folder not empty!";
$mg2->lang['folderdeleted']							= "Folder deleted";
$mg2->lang['foldernotdeleted']						= "ERROR: Couldn't delete folder!";									// kh_mod 0.1.0, add
$mg2->lang['folderupdated']							= "Folder updated";
$mg2->lang['foldererror']								= "ERROR: Couldn't save folder settings!";						// kh_mod 0.1.0, add
$mg2->lang['foldercreated']							= "Folder created";
$mg2->lang['settingssaved']							= "Settings saved";
$mg2->lang['nopwdmatch']								= "Settings saved<br /><br />ERROR: Password mismatch - new password not saved!";
$mg2->lang['nothumbsize']								= "ERROR: Size of Thumbnails too small! - Thumbnail size not saved!";	// kh_mod 0.1.0, add
$mg2->lang['file']										= "File";
$mg2->lang['files']										= "files";
$mg2->lang['forbidden']									= "forbidden";																// kh_mod 0.1.0, add
$mg2->lang['filedeleted']								= "File deleted";
$mg2->lang['filesdeleted']								= "files deleted";														// kh_mod 0.1.0, changed
$mg2->lang['filesimported']							= "file(s) imported";													// kh_mod 0.1.0, changed
$mg2->lang['filesuploaded']							= "file(s) uploaded";													// kh_mod 0.1.0, changed
$mg2->lang['filesrenamed']								= "file(s) renamed automatically!";									// kh_mod 0.1.0, add
$mg2->lang['filesmovedto']								= "file(s) moved to";													// kh_mod 0.1.0, changed
$mg2->lang['folder']										= "folder";
$mg2->lang['folders']									= "folders";
$mg2->lang['rebuild']									= "Rebuild";
$mg2->lang['rebuildimages']							= "Rebuild thumbnails";
$mg2->lang['rebuildsuccess']							= "Rebuild thumbnail for";								// kh_mod 0.1.0, changed
$mg2->lang['rebuilderror']								= "ERROR: Not able to rebuild Thumbnail!";		// kh_mod 0.1.0, add
$mg2->lang['rebuildempty']								= "No thumbnails rebuild, the folder is empty!";// kh_mod 0.1.0, add
$mg2->lang['donate']										= "MG2 is free software, licensed under the GPL. If you find this software useful, please make a donation to the author by pressing the button below.";
$mg2->lang['therefrom']									= "therefrom";												// kh_mod 0.1.0, add
$mg2->lang['from']										= "From";
$mg2->lang['by']											= "by";
$mg2->lang['buttonmove']								= "Move";
$mg2->lang['buttondelete']								= "Delete";
$mg2->lang['deleteconfirm']							= "Delete selected files?";
$mg2->lang['moveconfirm']								= "Move selected images?";								// kh_mod 0.1.0, add
$mg2->lang['commentnotread']							= "ERROR: Couln't read comment file!";				// kh_mod 0.1.0, add
$mg2->lang['nocommentid']								= "ERROR: Comment-ID not found!";					// kh_mod 0.1.0, add
$mg2->lang['commentnotselected']						= "ERROR: No comment selected!";						// kh_mod 0.1.0, add
$mg2->lang['commentconfirm']							= "Delete selected comments?";						// kh_mod 0.1.0, add
$mg2->lang['commentsdeleted']							= "Comment(s) deleted from";							// kh_mod 0.1.0, changed
$mg2->lang['commentupdated']							= "Comment updated from";								// kh_mod 0.1.0, add
$mg2->lang['comment']									= "Comment";
$mg2->lang['comments']									= "Comments";
$mg2->lang['layout']										= "Layout";													// kh_mod 0.1.0, add
$mg2->lang['imagecolumns']								= "Image columns";
$mg2->lang['imagerows']									= "Image rows";
$mg2->lang['viewfolder']								= "View folder";
$mg2->lang['viewimage']									= "View image";
$mg2->lang['viewgallery']								= "View gallery";
$mg2->lang['rotateright']								= "Rotate image 90 degrees right";					// kh_mod 0.1.0, changed
$mg2->lang['rotateleft']								= "Rotate image 90 degrees left";					// kh_mod 0.1.0, changed
$mg2->lang['imagerotated']								= "Image rotated to";									// kh_mod 0.1.0, changed
$mg2->lang['imagenotrotated']							= "ERROR: Couldn't image rotate!";					// kh_mod 0.1.0, add
$mg2->lang['gifnotrotated']							= "ERROR: GIF files can't be rotated due to limitations in GD lib!";
$mg2->lang['help']										= "Help";
$mg2->lang['slideshowdelay']							= "Slideshow delay (sec.)";							// kh_mod 0.1.0, changed
$mg2->lang['htmlarea']									= "HTMLArea (WYSIWYG Editor)";						// kh_mod 0.1.0, add
$mg2->lang['tooltips']									= "Tooltips (mini thumbs)";							// kh_mod 0.1.0, add
$mg2->lang['websitelink']								= "Link adress to mainpage (blank = disable)";	// kh_mod 0.1.0, changed
$mg2->lang['marknew']									= "Mark items newer than X days (0 = disable)";
$mg2->lang['folderempty']								= "This folder is empty!";
$mg2->lang['requestfolder']							= "The requested folder";								// kh_mod 0.1.0, add
$mg2->lang['notexists']									= " was not found!";										// kh_mod 0.1.0, add
$mg2->lang['damaged']									= " is damaged!";											// kh_mod 0.1.0, add
$mg2->lang['noimage']									= "The requested image does not exist!";
$mg2->lang['logout']										= "Logout (all folders)";								// kh_mod 0.1.0, add
$mg2->lang['logoutok']									= "Logout successfully!";								// kh_mod 0.1.0, add
$mg2->lang['recorddeleted']							= "Database entry deleted";							// kh_mod 0.1.0, add
$mg2->lang['recordsdeleted']							= "Database entries deleted";							// kh_mod 0.1.0, add

// ----8<--------------------------------
// INSTRUCTIONS 0.5.0
//
// 1. Remove the following lines from above:
// $mg2->lang['uploadimport']
// $mg2->lang['upgradenote']
//
// 2. Update the translations for the following strings:
// $mg2->lang['filesuploaded']
//
// 3. Add the lines below into your existing translation
// 4. Translate the lines you just inserted into your own language file
// 5. Remove this comment
// 6. Update the 'last updated' comment in beginning of file
// 7. Upload the new language file to the addon directory (www.minigal.dk/login.php)
//
// (If you don't have a login, send a mail to support@minigal.dk)
// ----8<--------------------------------

$mg2->lang['text']										= "Text";														// kh_mod 0.1.0, add
$mg2->lang['icons']										= "Icons";														// kh_mod 0.1.0, add
$mg2->lang['actions']									= "Actions";
$mg2->lang['uncheckall']								= "Uncheck all";												// kh_mod 0.1.0, add
$mg2->lang['checkall']									= "Check all";													// kh_mod 0.1.0, add
$mg2->lang['backupcomplete']							= "Database backup complete";
$mg2->lang['backuplink']								= "Database backup";
$mg2->lang['viewlogfile']								= "View logfile";
$mg2->lang['websitetext']								= "Link text for mainpage";								// kh_mod 0.1.0, changed
$mg2->lang['accesstime']								= "Auto logout for admin after X minutes";			// kh_mod 0.1.0, add
$mg2->lang['pwdrecursiv']								= "Folder password request recursiv (gallery)";		// kh_mod 0.2.0, changed
$mg2->lang['version1']									= "You have the latest MG2 version";
$mg2->lang['version2']									= "MG2 version X is available!";
$mg2->lang['version3']									= "Error: You seem to have a version newer than the one online!";
$mg2->lang['backtofolder']								= "Back to folder";

// deleted in kh_mod 0.2.0
$mg2->lang['deletethumb']								= "Delete thumb";
$mg2->lang['showexif']									= "Show Exif";

// changed in kh_mod 0.2.0
$mg2->lang['permerror1']								= "PERMISSION ERROR: Cannot write to gallery root folder!";
$mg2->lang['permerror2']								= "PERMISSION ERROR: Cannot write to '$mg2->imagefolder' folder!";
$mg2->lang['permerror3']								= "PERMISSION ERROR: Cannot write to 'mg2db_idatabase.php' file!";
$mg2->lang['permerror4']								= "PERMISSION ERROR: Cannot write to 'mg2db_idatabase_temp.php' file!";
$mg2->lang['permerror5']								= "PERMISSION ERROR: Cannot write to 'mg2db_fdatabase.php' file!";
$mg2->lang['permerror6']								= "PERMISSION ERROR: Cannot write to 'mg2db_fdatabase_temp.php' file!";
$mg2->lang['whattodo1']									= "Chmod your gallery folder 'data' to 777";
$mg2->lang['whattodo2']									= "Chmod your gallery folder '$mg2->imagefolder' to 777";
$mg2->lang['whattodo3']									= "Chmod 'mg2db_idatabase.php' file to 744";
$mg2->lang['whattodo4']									= "Chmod 'mg2db_idatabase_temp.php' file to 744";
$mg2->lang['whattodo5']									= "Chmod 'mg2db_fdatabase.php' file to 744";
$mg2->lang['whattodo6']									= "Chmod 'mg2db_fdatabase_temp.php' file to 744";
$mg2->lang['sendmail']									= "Send new comments to admin";

// added in kh_mod 0.2.0
$mg2->lang['forebiddenxtensions']					= "ERROR: Forbidden file extension(s)";
$mg2->lang['renamefailure_image']					= "ERROR: Couldn't rename image file!";
$mg2->lang['renamefailure_thumb']					= "ERROR: Couldn't rename thumb file!";
$mg2->lang['renamefailure_medium']					= "WARNUNG: Couldn't rename medium file!";
$mg2->lang['renamefailure_comment']					= "WARNUNG: Couldn't rename comment file!";
$mg2->lang['tryitagain']								= "Try it again";
$mg2->lang['maxupload']									= "Maximally possible upload per form";
$mg2->lang['overwrite']									= "Overwrite exists files";
$mg2->lang['logip']										= "Log IP and HOST";
$mg2->lang['dbimport']									= "Database import";
$mg2->lang['comments_convert']						= "Comments convert";
$mg2->lang['randomicon']								= "Random folder icon";
$mg2->lang['defaulticon']								= "Default folder icon";
$mg2->lang['make']										= "Camera";
$mg2->lang['software']									= "Software";
$mg2->lang['datetime']									= "Changed";
$mg2->lang['colorspace']								= "Color space";
$mg2->lang['photographer']								= "Photographer";
$mg2->lang['imagetitle']								= "Image title";
$mg2->lang['captcha']									= "Charcode (Image)";	// Code for image captcha
$mg2->lang['lock']										= "Lock";
$mg2->lang['unlock']										= "Unlock";
$mg2->lang['lockcomments']								= "Lock selected comments?";
$mg2->lang['unlockcomments']							= "Unlock selected comments?";
$mg2->lang['allowentries']								= "Allow comment entries";

?>
