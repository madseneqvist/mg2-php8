<?php
////////////////////////////////////////////////////////
//	DISPLAY FOLDER AND IMAGE TABLE (ADMIN)	//
////////////////////////////////////////////////////////

	$folderID = ($_REQUEST['fID'] == '')? 1:(int)$_REQUEST['fID'];
	if (!$mg2->getfoldersettings($folderID)) {
		$mg2->displaystatus($mg2->lang['nofolderid'] .' #'. $folderID);
		if ($folderID != 1) {
			$folderID = 1;
			$mg2->getfoldersettings($folderID);
		}
	}

	// kh_mod 0.1.0, add
	$tmp_sort = ($mg2->folderseting & 15)?
					$mg2->folderseting & 15	// global setting
					:
					$mg2->folder_sortby;		// folder setting

	switch ($tmp_sort) {
		case  6 : $trans_sortby = 2; break;	// filename	->	foldername
		case  2 : $trans_sortby = 2; break;	// title		->	foldername
		case  3 : $trans_sortby = 3; break;	// description	->	description
		case 12 : $trans_sortby = 2; break;	// filesize	->	foldername
		case  8 : $trans_sortby = 2; break;	// width		->	foldername
		case  9 : $trans_sortby = 2; break;	// height		->	foldername
		case  4 : $trans_sortby = 4; break;	// timestamp	->	timestamp
		case  5 : $trans_sortby = 5; break;	// position	->	position
		default : $trans_sortby = 2;
	}
	// end

	$folders  = $mg2->select($folderID,$mg2->all_folders,1,$trans_sortby,$mg2->folder_sortway);		// kh_mod 0.1.0, changed
	$images   = $mg2->select($folderID,$mg2->all_images,1,$mg2->folder_sortby,$mg2->folder_sortway);// kh_mod 0.1.0, changed
	$cfolders = count($folders);																							// kh_mod 0.1.0, add
	$cimages  = count($images);																							// kh_mod 0.1.0, add

	//
	// PAGE COUNTER
	// kh_mod 0.1.0, changed

	//CALCULATE NUMBER OF PAGES NEEDED
	$imagecols = ((int)$mg2->all_folders[$folderID][9] < 1)?
					 $mg2->imagecolumns								// global setting
					 :
					 (int)$mg2->all_folders[$folderID][9];		// folder setting
	$imagerows = ((int)$mg2->all_folders[$folderID][10] < 1)?
					 $mg2->imagerows									// global setting
					 :
					 (int)$mg2->all_folders[$folderID][10];	// folder setting
	$prpage = $imagecols * $imagerows;
	$npages = ceil($cimages / $prpage);

	// CALCULATE FIRST AND LAST INDEX OF PAGE 
	if ($_REQUEST['page']=='all') {
		$page  = 'all';
		$first = 0;
		$last  = $cfolders + $cimages;
	}
	else {
		$page  = (int)$_REQUEST['page'];
		if ($page < 1) $page = 1;
		$first = $prpage * ($page - 1);
		$last  = $first  + $prpage;
	}

	//
	// DISPLAY LIST HEADER
	//
	if ($mg2->folder_position < 0) {
		$tableHead = ' bgcolor="#FFCFCF" title="'. $mg2->lang['nodisplay'];
		$tableHead.= ' ('. $mg2->lang['position'] .' '. $mg2->folder_position .')"';
	}
	elseif ($mg2->folder_publish > time()) {
		$tableHead = ' bgcolor="#FFFF99" title="'. $mg2->lang['notpublished'];
		$tableHead.= ' '. $mg2->time2date($mg2->folder_publish) .'"';
	}
	else {
		$tableHead = '';
	}
	$navigation = $mg2->lang['navigation'] .': '. $mg2->adminnavigation($folderID);
	$navigation.= ' : '. count($images) .'&nbsp;'. $mg2->lang['images'];
	$navigation.= $mg2->adminpagenavigation($folderID, $npages, $page);
	$class		= 'table_files';
	include(ADMIN_FOLDER .'admin_table_start.php');

	//
	// LIST FOLDERS
	// kh_mod 0.1.0, changed
	for ($i=0; $i < $cfolders; $i++) {
		// IS SET FOLDER PASSWORT?
		if (trim($folders[$i][8]) != '') {
			$small_icon = ADMIN_FOLDER .'images/folder_small_locked.gif';
		}
		// IS SET FOLDER THUMBNAIL?
		elseif ((int)$folders[$i][6] > 0) {
			$small_icon = ADMIN_FOLDER .'images/folder_small_thumb.gif';
		}
		// STANDARD ICON
		else {
			$small_icon = ADMIN_FOLDER .'images/folder_small.gif';
		}

		// GET PUBLISH DATE OF FOLDER
		$publishdate = $mg2->time2date($folders[$i][4]);
		include(ADMIN_FOLDER .'admin3_folders.php');
	}

	//
	// LIST FILES
	// kh_mod 0.1.0, changed
	$upto = ($cimages < $last)? $cimages:$last;
	for ($i=$first; $i < $upto; $i++) {
		// COUNTER START BY 0
		$num = $i-$first;

		// CALCULATE IMAGE SIZE
		$dec = 1;
		$val = ' bytes';
		if (strlen($images[$i][12]) > 3) { $dec=1024;    $val=' KB'; }
		if (strlen($images[$i][12]) > 6) { $dec=1048576; $val=' MB'; }
		$filesize = @number_format(round(($images[$i][12]/$dec),2), 2, '.', ','). $val;

		// GET IMAGE VALUES
		$imageID		  = $images[$i][0];
		$imagename	  = $images[$i][6];
		$thumb_width  = $images[$i][10];
		$thumb_height = $images[$i][11];
		$subdir		  = $images[$i][7];
		$imagefile	  = $mg2->get_path($imagename, $subdir);

		// GET THUMB FILE
		$thumbfile = $mg2->get_path($imagename, $subdir, 'thumb');
		if (!$thumb_ok = is_readable($thumbfile))
			$thumbfile = ADMIN_FOLDER .'images/1x1.gif';
			$thumbfile.= $isuffix;	// image suffix

		// CALCULATE MINITHUMB SIZE
		$minithumb_width  = (string)(round(($thumb_width/5),0));
		$minithumb_heigth = (string)(round(($thumb_height/5),0));

		// GET PUBLISH DATE OF FILE
		$publishdate = $mg2->time2date($images[$i][4]);

		// GET THUMB INFO
		$thumb_info ='';
		if (($mg2->extendedset & 8) && $thumb_ok)
		if ($thumb_ok && include_once('includes/mg2_exif.php')) {
			exif($imagefile);
			$d = preg_split('/(:|\s)/', $exif_data['DTOpticalCapture'],6,PREG_SPLIT_NO_EMPTY);
			$exif_data['DTOpticalCapture'] = ''; // RESET FOR NEXT LOOPS RUN, kh_mod 0.1.0 b3, add
			$exif_date  = mktime($d[3], $d[4], $d[5], $d[1], $d[2], $d[0]);
			$thumb_info = 'this.T_WIDTH='.($thumb_width+10).';return escape(\'<img src=\\\''.$thumbfile;
			$thumb_info.= '\\\' width=\\\''.$thumb_width.'\\\' height=\\\''.$thumb_height.'\\\' alt=\\\'\\\' />';
			$thumb_info.= '<br />ID: #'. $images[$i][0] .',&nbsp;Exif-'. $mg2->lang['date'];
			$thumb_info.= ($exif_date > 0)?
							  ':<br />'. $mg2->time2date($exif_date, true) .'\')'
							  :
							  ': -\')';
		}

		// GET COMMENT FILE
		$commfile  = $mg2->get_path($imagename, $subdir, 'comment');
		$ncomments = $mg2->readcomments($commfile);
		include(ADMIN_FOLDER .'admin3_files.php');
	}

	// DISPLAY CONTROLS
	$selectsize = $upto - $first;
	if (empty($mg2->sortedfolders)) $mg2->makefolderlist();
	include(ADMIN_FOLDER .'admin4_controls.php');
?>
