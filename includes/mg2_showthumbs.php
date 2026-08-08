<?php
//////////////////////////////
// DISPLAY INDEX (THUMBS)	//
//////////////////////////////

	// kh_mod 0.1.0, add
	$tmp_sort = ($mg2->folderseting & 15)?
					$mg2->folderseting & 15	// global setting
					:
					$mg2->folder_sortby;		// folder setting

	switch ((int)$tmp_sort) {
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

	$folders  = $mg2->select($folderID,$mg2->all_folders,1,$trans_sortby,$mg2->folder_sortway);		// kh_mod 0.2.0, changed
	$images   = $mg2->select($folderID,$mg2->all_images,1,$mg2->folder_sortby,$mg2->folder_sortway);// kh_mod 0.2.0, changed
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
	$npages = ceil(($cfolders + $cimages)/$prpage);

	//CALCULATE FIRST AND LAST INDEX OF PAGE 
	if ((int)$currentPage > $npages) $currentPage = 1;
	if ($currentPage == 'all') {
		$first = 0;
		$last  = $cfolders + $cimages;
	}
	else {
		$first = $prpage * ($currentPage - 1);
		$last  = $first + $prpage;
	}

	// STARTIMAGE
	$mg2->startimage = (!empty($cimages))?
							 $images[0][0] .'&amp;fID='. $folderID .'&amp;page='. $currentPage
							 :
							 '';

	// DISPLAY THUMBNAIL HEADER
	thumbnails_begin($folderID, $npages, $currentPage);

	//DISPLAY EMPTY MESSAGE
	if ($cfolders == 0 && $cimages == 0) {
		echo '<td align="center"><nobr><b>'.$mg2->lang['folderempty'] .'</b></nobr></td>';
		include('skins/'.$mg2->activeskin.'/templates/thumbnails_end.php');
		exit();
	}

	//DISPLAY FOLDERS
	$upto = ($cfolders < $last)? $cfolders:$last;
	for ($i=$first; $i < $upto; $i++) {
		$mg2->link = $mg2->indexfile .'?fID='. $folders[$i][0];
		$mg2->thumbfile  = $mg2->getthumb($folders[$i][0]);
		$mg2->foldername = ($folders[$i][2])? $folders[$i][2]:'&nbsp;';

		// MARK NEW FOLDERS
		if ((time() - $folders[$i][4]) < ($mg2->marknew * 84600)) {
			$mg2->new = true;
		} else $mg2->new = false;

		include('skins/'.$mg2->activeskin.'/templates/subfolder.php');
		$col_idx = ($i % $imagecols) + 1;
		if ($col_idx >= $imagecols && ($i+1) < $last) echo '</tr><tr>';
	}

	// CALCULATE THUMBS
	$first = $i    - $cfolders;
	$last  = $last - $cfolders;
	$upto  = ($cimages < $last)? $cimages:$last;

	// SUPPORT CLICK COUNTER
	if ($mg2->setCounter && $cimages) {
		for ($i=$first; $i < $upto; $i++) { $data[$images[$i][0]] = 0; }
		$Counter = new MG2counter($data);
	}

	// DISPLAY THUMBS
	for ($i=$first; $i < $upto; $i++) {
		$mg2->link = $mg2->indexfile .'?iID='. $images[$i][0];
		$mg2->width  = $images[$i][8];
		$mg2->height = $images[$i][9];
		$mg2->thumb_width  = $images[$i][10];
		$mg2->thumb_height = $images[$i][11];

		// THUMBNAIL TITLE
		if ($mg2->folderseting & 32)			// kh_mod 0.1.0, add
			$mg2->title = $images[$i][6];		// display filename under thumbs
		elseif (strlen($images[$i][2]) > $skin_titlelimit)
			$mg2->title = substr($images[$i][2],0,$skin_titlelimit) .'...';
		else
			$mg2->title = $images[$i][2];
		if ($mg2->title == '') $caption = '&nbsp;';

		// CHECK THUMB PICTURE
		$mg2->thumbfile = $mg2->get_path($images[$i][6],$images[$i][7],'thumb');
		if(!is_readable($mg2->thumbfile)) {
			$mg2->thumbfile = $mg2->get_path($images[$i][6],$images[$i][7]);
			if (!is_readable($mg2->thumbfile)) {
				$mg2->thumbfile = 'skins/'.$mg2->activeskin.'/images/1x1.gif';
				$mg2->thumb_width  = '150';
				$mg2->thumb_height = '150';
			}
		}

		// MARK NEW FILES
		if ((time() - $images[$i][4]) < ($mg2->marknew * 84600))
			$mg2->new = true;
		else
			$mg2->new = false;

		include('skins/'.$mg2->activeskin.'/templates/thumb.php');
		$col_idx = (($i+$cfolders) % $imagecols) + 1;
		if ($col_idx >= $imagecols && $i+1 < $last) echo '</tr><tr>';
	}

	// FILL ROW WITH EMPTY TD TAGS
	while ($col_idx < $imagecols) {
		echo '<td>&nbsp;</td>';
		$col_idx = (($i+$cfolders) % $imagecols) + 1;
		$i++;
	}

	// CREDITS - DO NOT REMOVE OR YOU WILL VOID MG2 TERMS OF USE!
	if ($folderID == 1) {
		echo '
		</tr>
		<tr>
			<td colspan="'.$imagecols.'">
		';
		// kh_mod 0.1.0, add
		if ($_SESSION[PRE_SESSION.'folderpwd'] != "")
			echo '<div class="credits"><a href="'.$mg2->indexfile.'?action=logout">'.$mg2->lang['logout'].'</a></div>';
		elseif ($logoutmsg)
			echo '<div class="credits">'.$mg2->lang['logoutok'].'</div>';
		// end
		echo '
				<br />
				<div class="credits">
					Powered by <a href="http://www.minigal.dk" target="_blank">MG2</a> v'. $mg2->version .'
					(<a href="http://www.tangata.de/kh_mod/" target="_blank">kh_mod</a> v'.$mg2->modversion.')
				</div>
			</td>
		';
	} else {
		echo '</tr><tr><td colspan="'.$imagecols.'">&nbsp;</td>';
	}
	include('skins/'.$mg2->activeskin.'/templates/thumbnails_end.php');
?>
