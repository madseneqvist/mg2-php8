<?php
/////////////////////////////
// DISPLAY SLIDESHOW
/////////////////////////////

	$slideimages = $mg2->select($folderID,$mg2->all_images,1,$mg2->folder_sortby,$mg2->folder_sortway);
	for ($i=0; $i < count($slideimages); $i++) {
		if ($slideimages[$i][0] == $imageRC[0]) {
			$nextid = (isset($slideimages[$i+1]))? $slideimages[$i+1][0]:'';
			break;
		}
	}
	if (empty($nextid)) {
		$nexturl = $mg2->indexfile.'?fID='.$folderID.'&amp;page='. $currentPage;
		$mg2->nextimage = 'skins/'. $mg2->activeskin .'/images/1x1.gif';
	}
	// NEXT IMAGE
	else {
		$filename = $slideimages[$i+1][6];
		$subdir	 = $slideimages[$i+1][7];
		$nexturl	 = $mg2->indexfile.'?slideshow='.$nextid.'&amp;page='. $currentPage;
		$mg2->nextimage = $mg2->get_path($filename,$subdir);
	}

	// CHECK CURRENT IMAGE
	$filename	 = $imageRC[6];
	$subdir		 = $imageRC[7];
	$image_file	 = $mg2->get_path($filename,$subdir);
	$medium_file = $mg2->get_path($filename,$subdir,'medium');
	$mg2->fullsizelink = '';
	if (is_readable($medium_file)) {
		list($mg2->width, $mg2->height, $mg2->type, $mg2->attr) = getimagesize($medium_file);
		$mg2->imagefile = $medium_file;
		$mg2->fullsizelink = '<a href="'. $image_file .'" target="_blank">'. $mg2->lang['fullsize'] .'</a>';
	} elseif (is_readable($image_file)) {
		$mg2->imagefile = $image_file;
		$mg2->width  = $imageRC[8];
		$mg2->height = $imageRC[9];
	} else {
		$mg2->imagefile = 'skins/'. $mg2->activeskin .'/images/1x1.gif';
		$mg2->width  = '0';
		$mg2->height = '0';
		$mg2->copyright = 'Load image...';
		$mg2->title = '';
		$mg2->description = '';
		$mg2->slideshowdelay = '0';
	}

	// DISPLAY IMAGE
	$mg2->link = $mg2->indexfile.'?fID='.$folderID.'&amp;page='. $currentPage;
	$mg2->target = '_self';
	$mg2->copyright = $mg2->copyright;
	$mg2->title = $imageRC[2];
	$mg2->description = $imageRC[3];
	$mg2->tooltip = $mg2->lang['next'];
	include('skins/'.$mg2->activeskin.'/templates/viewimage_slideshow.php');
?>
