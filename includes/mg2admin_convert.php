<?php
// *************************************************************************** //
// CONVERT MG2 0.5.0/0.5.1 AND KH_MOD 0.1.0 DATABASES TO KH_MOD 0.2.0 //
// *************************************************************************** //

// IMAGE DATABASE
function convert_iDB() {
	global $mg2;

	$db_ok = false;
	$maxID = 0;
	$start = microtime_float();
	do {
		$mg2->all_images = array();
		$iDB = 'mg2db_idatabase.php';
		if (!is_file($iDB)) {
			$message = 'Found no image database to import from the gallery root!';
			break;
		}
		if (!$fd = @fopen($iDB,'rb'))	break;		// cannot open data file
		if (!is_resource($fd))			break;		// $fd is no resource

		$mg2->autoid = trim(fgets($fd,16));
		while (!feof($fd)) {
			if (fgets($fd,2) !== '*')	continue;	// no data row?
			$record = fgetcsv($fd,4096,'*');
			$mg2->all_images[$record[0]] = $record;
		}
		fclose($fd);

		@include('includes/mg2_exif.php');
		foreach ($mg2->all_images as $key=>$record) {
			if ($maxID < (int)$key) $maxID = (int)$key;
			$mg2->all_images[$key][6]  = trim($record[1]);
			$mg2->all_images[$key][1]  = (int)$record[2];
			$mg2->all_images[$key][2]  = str_replace("\t",'   ',trim($record[3]));
			$mg2->all_images[$key][3]  = str_replace("\t",'   ',trim($record[4]));
			$mg2->all_images[$key][12] = (int)$record[5];
			$mg2->all_images[$key][8]	= (int)$record[6];
			$mg2->all_images[$key][9]  = (int)$record[7];
			$mg2->all_images[$key][10] = (int)$record[8];
			$mg2->all_images[$key][11] = (int)$record[9];
			$mg2->all_images[$key][4]  = (int)$record[10];
			$mg2->all_images[$key][5]  = (int)$record[11];
			$mg2->all_images[$key][7]  = ($record[12])? trim($record[12]):'';
			$mg2->all_images[$key][13] = '';
			$mg2->all_images[$key][14] = '';

/*
			// GET EXIF VALUES
			$imagefile = $mg2->get_path($mg2->all_images[$key][6], $mg2->all_images[$key][7]);
			exif($imagefile);
			$d = preg_split('/(:|\s)/', $exif_data['DTOpticalCapture'],6,PREG_SPLIT_NO_EMPTY);
			$exif_data['DTOpticalCapture'] = '';
			$mg2->all_images[$key][13] = mktime($d[3], $d[4], $d[5], $d[1], $d[2], $d[0]);
*/
		}
		if ($maxID > $mg2->autoid) $mg2->autoid = $maxID;
		$db_ok = $mg2->write_iDB('update');

		// BUILD STATUS MESSAGE
		$takes   = round(microtime_float() - $start,3);
		$records = count($mg2->all_images);
		$message = 'Image database import '. $records .' records';
		$message.= ($db_ok)? ', it took '. $takes .' sek.':', Error!';
	}
	while(0);

	// DISPLAY STATUS MESSAGE
	$mg2->displaystatus($message);
}

// FOLDER DATABASE
function convert_fDB() {
	global $mg2;

	$db_ok = false;
	$maxID = 0;
	$start = microtime_float();
	do {
		$mg2->all_folders = array();
		$fDB = 'mg2db_fdatabase.php';		
		if (!is_file($fDB)) {
			$message = 'Found no folder database to import from the gallery root!';
			break;
		}
		if (!$fd = @fopen($fDB,'rb'))	break;		// cannot open data file
		if (!is_resource($fd))			break;		// $fd is no resource

		$mg2->folderautoid = trim(fgets($fd,16));
		while (!feof($fd)) {
			if (fgets($fd,2) !== '*')	continue;	// no data row?
			$record = fgetcsv($fd,4096,'*');
			$mg2->all_folders[$record[0]] = $record;
		}
		fclose($fd);

		foreach ($mg2->all_folders as $key=>$record) {
			if ($maxID < (int)$key) $maxID = (int)$key;
			$mg2->all_folders[$key][7]	 = _getsortby($record[3]);	// sort by
			$mg2->all_folders[$key][7]	|= (int)$record[4] << 4;	// sort mode
			$mg2->all_folders[$key][8]  = $record[5];
			$mg2->all_folders[$key][4]  = $record[6];
			$mg2->all_folders[$key][6]  = ($record[7])? _getimage($record[7]):-1;
			$mg2->all_folders[$key][2]	 = str_replace("\t",'   ',trim($record[2]));
			$mg2->all_folders[$key][3]	 = str_replace("\t",'   ',trim($record[10]));
			$mg2->all_folders[$key][5]  = ((int)$record[11])? (int)$record[11]:1;
			$mg2->all_folders[$key][9]  = '';
			$mg2->all_folders[$key][10] = '';
			unset($mg2->all_folders[$key][11]);
		}
		if ($maxID > $mg2->folderautoid) $mg2->folderautoid = $maxID;
		$db_ok = $mg2->write_fDB('update');

		// BUILD STATUS MESSAGE
		$takes   = round(microtime_float() - $start,3);
		$records = count($mg2->all_folders);
		$message = 'Folder database import '. $records .' records';
		$message.= ($db_ok)? ', it took '. $takes .' sek.':', Error!';
	}
	while(0);

	// DISPLAY STATUS MESSAGE
	$mg2->displaystatus($message);
}

// COMMENT FILES
function convert_cmf() {
	global $mg2;

	$read		  = 0;
	$converted = 0;
	$saved	  = 0;
	$start	  = microtime_float();
	if ($handle = opendir($mg2->imagefolder)) {
		while (false !== ($file = readdir($handle))) {
			if (substr($file, -8) != '.comment')			 continue;
			$read++;
			$commfile = $mg2->imagefolder .'/'. $file;
			if (!$comments = read_oldcomments($commfile)) continue;

			// CONVERT RECORDS
			$commentID		= 0;
			$mg2->comments	= array();
			foreach ($comments as $record) {
				$commentID++;
				$mg2->comments[$commentID][0] = $commentID;
				$mg2->comments[$commentID][1] = str_replace("\t",'   ',trim($record[1]));
				$mg2->comments[$commentID][2] = trim($record[2]);
				$mg2->comments[$commentID][3] = str_replace("\t",'   ',trim($record[3]));
				$mg2->comments[$commentID][4] = $record[0];
				$mg2->comments[$commentID][5] = -1;
				$mg2->comments[$commentID][6] = 0;
				$mg2->comments[$commentID][7] = 1;
			}
			$converted++;

			// WRITE COMMENT DATABASE
			if ($commentID) {
				$mg2->commautoid = $commentID;
				if ($mg2->writecomments($commfile,false)) $saved++;
			}
		}
		closedir($handle);
	}
	$takes   = round(microtime_float() - $start,3);

	if ($read == 0)
		$message = 'Found no comment files to convert in \''.$mg2->imagefolder.'\' directory!';
	elseif ($converted == 0)
		$message = 'Read '. $read .' files, but no old comments to convert!';
	else {
		$message = 'Comment database converted '. $converted .' of '. $read;
		$message.= ' files, ';
		$message.= ($converted > $saved)?
					  ($converted - $saved) .' write error(s)!'
					  :
					  'it took '. $takes .' sek.';
	}
	$mg2->displaystatus($message);
}


//
// GET SORT BY (FOLDER DB)
function _getsortby($idx) {
	switch ((int)$idx) {
		case  1:	$idx =  6; break;
		case  3:	$idx =  2; break;
		case  4:	$idx =  3; break;
		case  5:	$idx = 12; break;
		case  6:	$idx =  8; break;
		case  7:	$idx =  9; break;
		case 10:	$idx =  4; break;
		case 11:	$idx =  5; break;
		default: $idx =  6;
	}
	return $idx;
}

//
// CONVERT THUMB NAME TO IMAGE ID
function _getimage($thumb) {
	global $mg2;

	$ext	= strrchr(trim($thumb), '.');
	$name = basename($thumb, $ext);
	if (substr($name, -6) == '_thumb') {
		$filename = substr($name, 0, -6) . $ext;
		$imageRC  = $mg2->select($filename,$mg2->all_images,6,0,0);
	}
	return ((int)$imageRC[0][0])? (int)$imageRC[0][0]:-1;
}

//
// GET COMMENT ENTRIES
function read_oldcomments($commfile) {
	$comments = array();
	if (is_readable($commfile)) {
		$fd = @fopen($commfile,'r');
		while ($fd && !feof($fd)) {
			if (fgets($fd,2) !== '*')	continue;	// no data row?
			$comments[] = fgetcsv($fd,4096,'*');
		}
		fclose($fd);
	}
	elseif (is_file($commfile)) {
		return false;
	}
	return $comments;
}

//
// GET MILLISEK AS FLOAT
function microtime_float()
{
    list($usec, $sec) = explode(' ', microtime());
    return ((float)$usec + (float)$sec);
}
?>