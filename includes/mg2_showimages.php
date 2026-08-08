<?php
/////////////////////////////
// DISPLAY IMAGE
/////////////////////////////

	// Check IMAGE
	$filename	 = $imageRC[6];
	$subdir		 = $imageRC[7];
	$image_file  = $mg2->get_path($filename, $subdir);
	$medium_file = $mg2->get_path($filename, $subdir, 'medium');
	$mg2->fullsizelink = '';
	if (is_readable($medium_file)) {
		list($mg2->width, $mg2->height, $mg2->type, $mg2->attr) = getimagesize($medium_file);
		$mg2->imagefile = $medium_file;
		$mg2->fullsizelink = '<a href="'. $image_file .'" target="_blank">'. $mg2->lang['fullsize'] .'</a>';
	} elseif (is_readable($image_file)) {
		$mg2->imagefile = $image_file;
		$mg2->width  = $imageRC[8];
		$mg2->height = $imageRC[9];
	} elseif (is_file($image_file)) {
		$mg2->imagefile = 'skins/'. $mg2->activeskin .'/images/1x1.gif';
		$mg2->width  = $imageRC[8];
		$mg2->height = $imageRC[9];
		$mg2->status = $mg2->lang['filenotreadable'];
	} else {
		notexists($imageID, $folderID, $currentPage);
	}

	// ADD COMMENT
	if ($_POST['action'] == 'addcomment' && ($mg2->commentsets & 1)) {
		$workon = ($mg2->addcomment($filename, $subdir))?
					 array('','','','')
					 :
					 array_pop($mg2->comments);
	}

	// DISPLAY IMAGE
	$currentPage	  = $mg2->imagenavigation($folderID,$imageID);
	$mg2->startimage = $imageID;
	$mg2->startimage.= '&amp;fID='.$folderID.'&amp;page='.$currentPage;
	$mg2->target = '_self';
	$mg2->title	 = $imageRC[2];
	$mg2->description = $imageRC[3];
	$mg2->link	= $mg2->indexfile .'?fID='. $folderID .'&amp;page='. $currentPage;
	include('skins/'.$mg2->activeskin.'/templates/viewimage_begin.php');

	// DISPLAY EXIF
	if ((int)$mg2->showexif > 0 && is_readable('includes/mg2_exif.php')) {
		if (@include('includes/mg2_exif.php')) exif($image_file);
		if ($exif_data['Model'] != '') {
			if (!$exif_data['ISOSpeedRating']) $exif_data['ISOSpeedRating'] = '-';
			$exif_data['ExposureTime'] = $exif_data['ExposureTime'] . $mg2->lang['seconds'];
			$exif_data['FNumber']		= 'f'. $exif_data['FNumber'];
			$exif_data['FocalLength']	= $exif_data['FocalLength'] . $mg2->lang['mm'];
			if ($mg2->showexif & 1<<2) {	// ExposureBias
				$exif_data['ExposureBias'] = round($exif_data['ExposureBias'],2);
			}

			if ($mg2->showexif & 1<<7) {	// DTOpticalCapture
				$d = preg_split('/(:|\s)/', $exif_data['DTOpticalCapture'],6,PREG_SPLIT_NO_EMPTY);
				

				if($d[1] == "Jan")
                                $d[1] = 1;
				if($d[1] == "Feb")
                                $d[1] = 2;
				if($d[1] == "Mar")
				$d[1] = 3;
				if($d[1] == "Apr")
				$d[1] = 4;
				if($d[1] == "May")
                                $d[1] = 5;
				if($d[1] == "Jun")
				$d[1] = 6;
				if($d[1] == "Jul")
				$d[1] = 7;
				if($d[1] == "Aug")
				$d[1] = 8;
				if($d[1] == "Sep")
				$d[1] = 9;
				if($d[1] == "Oct")
				$d[1] = 10;
				if($d[1] == "Nov")
				$d[1] = 11;
				if($d[1] == "Dec")
				$d[1] = 12;


				if($d[0] == "Mon")
				$d[0] = 1;
				if($d[0] == "Tue")
				$d[0] = 2;
				if($d[0] == "Wed")
				$d[0] = 3;
				if($d[0] == "Thu")
				$d[0] = 4;
				if($d[0] == "Fri")
				$d[0] = 5;
				if($d[0] == "Sat")
				$d[0] = 6;
				if($d[0] == "Sun")
				$d[0] = 7;
				
				
				
				$exif_date = mktime($d[3], $d[4], $d[5], $d[1], $d[2], $d[0]);
				$exif_data['DTOpticalCapture'] = $mg2->time2date($exif_date, true);
			
			}
			if ($mg2->showexif & 1<<9) {	// DateTime
				$d = preg_split('/(:|\s)/', $exif_data['DateTime'],6,PREG_SPLIT_NO_EMPTY);
				$exif_date = mktime($d[3], $d[4], $d[5], $d[1], $d[2], $d[0]);
				$exif_data['DateTime'] = $mg2->time2date($exif_date, true);
			}
			if ($mg2->showexif & 1<<12) {	// Photographer
				if ($imageRC[14])
					$exif_data['Photographer'] = $imageRC[14];
				elseif ($exif_data['Artist'])
					$exif_data['Photographer'] = $exif_data['Artist'];
				else
					$exif_data['Photographer'] = $exif_data['Copyright'];
			}
			include('skins/'.$mg2->activeskin.'/templates/viewimage_exif.php');
		}
	}

	// DISPLAY COMMENTS?
	if ($mg2->commentsets & 1) {
		$num_comments = (is_array($mg2->comments))?
							 count($mg2->comments)
							 :
							 $mg2->readcomments($mg2->get_path($filename, $subdir, 'comment'));
		$mg2->sort($mg2->comments, 4, $mg2->commentsets & 2);
		include('skins/'.$mg2->activeskin.'/templates/viewimage_comments.php');
	}
	include('skins/'.$mg2->activeskin.'/templates/viewimage_end.php');
?>
