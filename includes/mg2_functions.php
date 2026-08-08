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

//
// DISPLAY THUMBNAIL HEADER
// kh_mod 0.1.0, add
function thumbnails_begin($folderID, $npages=1, $currentPage=1) {
	global $mg2;
	$currentfolder = ($folderID == 1)?
						  $mg2->gallerytitle
						  :
						  $mg2->all_folders[$folderID][2];
	include('skins/'.$mg2->activeskin.'/templates/thumbnails_begin.php');
}

//
// DISPLAY IMAGE OR FOLDER NOT EXISTS
// kh_mod 0.1.0, add
function notexists($id,$list='',$page='') {
	global $mg2;
	if ($id=='demaged')
		$noexists = $mg2->lang['requestfolder'] . $mg2->lang['damaged'];
	elseif ((int)$id>0)
		$noexists = $mg2->lang['noimage'];
	else
		$noexists = $mg2->lang['requestfolder'] . $mg2->lang['notexists'];
	$page = ($page)? $page:'1';
	$list = ($list)? $list:'1';
	$_REQUEST['fID'] = $list;
	$_REQUEST['iID']	= '';
	$mg2->introtext	= '';
	$currentfolder		= $mg2->gallerytitle;
	include('skins/'.$mg2->activeskin.'/templates/thumbnails_begin.php');
	echo '
		<td align="center"><nobr><b>'.$noexists.'</b></nobr><br />&nbsp;</td></tr>
		<tr><td align="center">
			<a href="'.$mg2->indexfile.'?fID='.$list.'&amp;page='.$page.'">'
			.$mg2->lang['viewgallery'].'</a>
		</td></tr></table></body></html>
	';
	exit();
}


class mg2db {

	//
	// READ ENTIRE DATABASE
	// kh_mod 0.2.0, changed
	function readDB($admin=false) {

		// IMAGE DATABASE
		$this->all_images	= array();
		$this->autoid		= 0;
		$iDB = DATA_FOLDER .'mg2db_idatabase.php';

		do {
			if (!is_file($iDB)) 		break;	// no data file

			$fd = fopen($iDB,'rb');
			if (!is_resource($fd))	break;	// cannot open data file

			$this->autoid = trim(fgets($fd,16));
			if ($admin===true) {
				while (!feof($fd)) {
					if (fgets($fd,2) !== '#')		continue;	// no data row?
					$record = fgetcsv($fd,4096,"\t");
					$this->all_images[$record[0]] = $record;
				}
			}
			else {
				$now = time();
				while (!feof($fd)) {
					if (fgets($fd,2) !== '#')		continue;	// no data row?
					$record = fgetcsv($fd,4096,"\t");
					if ((int)$record[4] > $now)	continue;	// date not in future?
					if ((int)$record[5] < 0)   	continue;	// position < 0?
					$this->all_images[$record[0]] = $record;
				}
			}
			fclose($fd);
		}
		while(0);

		// FOLDER DATABASE
		$this->all_folders = array();
		$fDB = DATA_FOLDER .'mg2db_fdatabase.php';

		do {
			if (!is_file($fDB)) {
				$this->folderautoid = 1;
				$this->all_folders[$this->folderautoid] = array(
																		'1',		// folder ID				[0]
																		'root',	// in folder (ID)			[1]
																		'',		// folder name			[2]
																		'',		// introtext				[3]
																		time(),	// timestamp (publish off)	[4]
																		'1',		// folder position			[5]
																		'-1',		// imageID for thumb		[6]
																		'6',		// folder sort mode		[7]
																		'',		// password				[8]
																		0,			// number of cols			[9]
																		0			// number of rows			[10]
																		);
				break;
			}

			$fd = fopen($fDB,'rb');
			if (!is_resource($fd))	break;	// cannot open data file

			$this->folderautoid = trim(fgets($fd,16));
			if ($admin===true) {
				while (!feof($fd)) {
					if (fgets($fd,2) !== '#')		continue;	// no data row?
					$record = fgetcsv($fd,4096,"\t");
					$this->all_folders[$record[0]] = $record;
				}
			}
			else {
				while (!feof($fd)) {
					if (fgets($fd,2) !== '#')		continue;	// no data row?
					$record = fgetcsv($fd,4096,"\t");
					if ((int)$record[4]  > $now)	continue;	// date not in future?
					if ((int)$record[5] < 0)   	continue;	// position < 0?
					$this->all_folders[$record[0]] = $record;
				}
			}
			fclose($fd);
		}
		while(0);
	}

	//
	// SELECT ENTRIES FROM DATABASE
	// kh_mod 0.2.0, changed
	function select($item,&$array,$row,$sortrow=0,$sortmode=0) {
		$selectarray = array();
		if (!is_array($array)) return $selectarray;

		foreach ($array as $record) {
			if ($record[$row] == $item) $selectarray[] = $record;
		}
		if (count($selectarray) > 1) $this->sort($selectarray,$sortrow,$sortmode);
		return $selectarray;
	}

	//
	// SORT SELECT RESULTS
	// kh_mod 0.2.0, changed
	function sort(&$datatable,$field,$mode) {
		if (!isset($field)) return;
		usort($datatable, function ($a, $b) use ($field, $mode) {
			$result = strnatcasecmp((string)$a[$field], (string)$b[$field]);
			if ($result === 0) $result = strnatcasecmp((string)$a[0], (string)$b[0]);
			return $mode ? -$result : $result;
		});
	}

	//
	// DISPLAY SLIDIESHOW ICON
	// kh_mod 0.2.0, changed
	function slideshowicon($attrib='',$inactiv=false) {
		if (!empty($this->startimage)) {
			echo '<a href="'. $this->indexfile .'?slideshow='. $this->startimage .'">';
			echo '<img src="skins/'. $this->activeskin .'/images/slideshow.gif" ';
			echo 'width="15" height="17" '. $attrib .' alt="'. $this->lang['viewslideshow'];
			echo '" title="'. $this->lang['viewslideshow'] .'" border="0" /></a>';
		} elseif ($inactiv) {
			echo '<img src="skins/'. $this->activeskin .'/images/slideshow.gif" ';
			echo 'width="15" height="17" '. $attrib .' alt="" border="0" />';
		}
	}

	//
	// IMAGE NAVIGATION
	// kh_mod 0.2.0, changed
	function imagenavigation($list, $imageID, $admin=false) {
		$folders = $this->select($list,$this->all_folders,1,0,0);
		$images  = $this->select($list,$this->all_images,1,$this->folder_sortby,$this->folder_sortway);
		if ($admin===true) {
			$cfolders = 0;
			$href = './admin.php?editID=';
		} else {
			$cfolders = count($folders);
			$href = './'.$this->indexfile.'?iID=';
		}

		$totalImages = count($images);
		$currentPage = 1;
		for ($i=0; $i < $totalImages; $i++) {
			if ($imageID == $images[$i][0]) {
				$currentImage = $i + 1;
				$currentPage  = ceil(($currentImage + $cfolders) / ($this->imagerows * $this->imagecolumns));
				break;
			}
		}

		// NAVIGATION LINKS
		$links['first'] = '<a href="'. $href . $images[0][0] .'&amp;page='.$currentPage.'">';
		$links['prev']  = '<a href="'. $href . $images[$currentImage - 2][0] .'&amp;page='.$currentPage.'">';
		$links['next']  = '<a href="'. $href . $images[$currentImage][0] .'&amp;page='.$currentPage.'">';
		$links['last']  = '<a href="'. $href . $images[$totalImages - 1][0] .'&amp;page='.$currentPage.'">';

		// NAVIGATION ACTIV LINKS
		$activ['first'] = (bool)($images[0][0] != $imageID);
		$activ['prev']  = (bool)($images[$currentImage - 2][0] != '');
		$activ['next']  = (bool)($images[$currentImage][0] != '');
		$activ['last']  = (bool)($images[$totalImages - 1][0] != $imageID);

		//  IMAGE NUMBER
		$this->nav_this = $currentImage .' '. $this->lang['of'] .' '. $totalImages;

		// Nex Image (custom by moffe)
		//echo $images[$currentImage][0] .'&amp;page='.$currentPage.'">';
		$this->nav_next_id = $images[$currentImage][0];

		if ($this->navtype & 1)	$this->text_imagenavigation($links, $activ);
		if ($this->navtype & 2) $this->icon_imagenavigation($links, $activ, $admin);
		if ($this->navtype & 4) $this->thumb_imagenavigation($currentImage, $images, $admin);
		return $currentPage;
	}

	//
	// IMAGE NAVIGATION BY TEXTSTRING
	// kh_mod 0.1.0, add
	function text_imagenavigation($links, $activ) {
		// FIRST IMAGE
		if ($activ['first'])
			$this->nav_first = $links['first'] . $this->lang['first'] .'</a>';
		else
			$this->nav_first = $this->lang['first'];

		// PREV IMAGE
		if ($activ['prev'])
			$this->nav_prev = $links['prev'] . $this->lang['prev'] .'</a>';
		else
			$this->nav_prev = $this->lang['prev'];

		// NEXT IMAGE
		if ($activ['next'])
			$this->nav_next = $links['next'] . $this->lang['next'] .'</a>';
		else
			$this->nav_next = $this->lang['next'];

		// LAST IMAGE
		if ($activ['last'])
			$this->nav_last = $links['last'] . $this->lang['last'] .'</a>';
		else
			$this->nav_last = $this->lang['last'];
	}

	//
	// IMAGE NAVIGATION BY ICONS
	// kh_mod 0.1.0, add
	function icon_imagenavigation($links, $activ, $admin) {

		$navigation = array ('first' => array('navstr' => &$this->nav_first),
									'prev'  => array('navstr' => &$this->nav_prev),
									'next'  => array('navstr' => &$this->nav_next),
									'last'  => array('navstr' => &$this->nav_last)
								  );

		// GENERATE NAVIGATION STRINGS
		$iconpath = ($admin)?
						ADMIN_FOLDER .'images/'
						:
						'skins/'. $this->activeskin .'/images/';
		foreach ($navigation as $key=>$record) {
			if ($activ[$key]) {
				$icon = $iconpath . $key .'_activ.gif';
				$size = (is_readable($icon))? getimagesize($icon):'';
				$record['navstr'] = $links[$key] .'<img src="'. $icon .'" '. $size[3] .' border="0" alt="';
				$record['navstr'].= $this->lang[$key].'" title="'.$this->lang[$key].'" align="middle" /></a>';
			}
			else {
				$icon = $iconpath . $key .'_inactiv.gif';
				$size = (is_readable($icon))? getimagesize($icon):'';
				$record['navstr'] = '<img src="'. $icon .'" '. $size[3] .' border="0" alt="" align="middle" />';
			}
		}
	}

	//
	// IMAGE NAVIGATION BY THUMBS
	// kh_mod 0.2.0, add
	function thumb_imagenavigation($currentImage, &$images, $admin) {

		// IMAGE LINK PATH AND DIVISOR FOR THUMB SIZE
		if ($admin) {
			$linkpath = 'admin.php?editID=';
			$divisor  = 4;
		} else {
			$linkpath = $this->indexfile .'?iID=';
			$divisor  = 2.5;
		}

		// GET START AND END INDEX
		$totalImages = count($images);
		$nthmb = 5;		// displayed nav thumbs total
		$nprev = 3;		// position of current thumb
		$idx = ($currentImage > $nprev)? $currentImage - $nprev : 0;
		if ($idx + $nthmb < $totalImages)
			$end = $idx + $nthmb;
		else {
			$end = $totalImages;
			$idx = ($end > $nthmb)? $end - $nthmb : 0;
		}

		// CREATE THUMB NAVIGATION LINE
		$this->nav_this = '';
		for (; $idx < $end; $idx++) {
			$title		 = ($idx+1) .' '. $this->lang['of'] .' '. $totalImages;
			$thumbwidth	 = round($images[$idx][10]/$divisor,0);
			$thumbheight = round($images[$idx][11]/$divisor,0);
			$thumbsize	 = 'width="'.$thumbwidth.'" height="'.$thumbheight.'"';
			$thumbfile	 = $this->get_path($images[$idx][6],$images[$idx][7],'thumb');
			if ($currentImage == $idx+1) {
				$class	= 'class="activ"';
				$isuffix = ($admin)? (string)('?'. rand(0,10000)):'';	// image suffix
				$this->nav_this.= '<img src="./'. $thumbfile . $isuffix .'" '. $thumbsize .' title="'. $title .'" alt="'. $title .'" '.$class.' />';
				$this->nav_this.= '&nbsp;';
			}
			elseif (is_readable($thumbfile)) {
				$class = 'class="inactiv"';
				$this->nav_this.= '<a href="'. $linkpath . $images[$idx][0] .'">';
				$this->nav_this.= '<img src="./'. $thumbfile .'" '. $thumbsize .' title="'. $title .'" alt="'. $title .'" '.$class.' />';
				$this->nav_this.= '</a>&nbsp;';
			}
			else {
				$this->nav_this = '';
			}
		}
	}

	//
	// CREATE METATAG TITLE
	// kh_mod 0.2.0, add
	function getpagetitle($imageID, $folderID, $delimiter, $withoutext=false) {
		$metatitle	  = array();
		$foldername	  = trim($this->all_folders[$folderID][2]);
		$imagetitle	  = trim($this->all_images[$imageID][2]);
		$filename	  = trim($this->all_images[$imageID][6]);
		$gallerytitle = trim($this->gallerytitle);
		if (!$gallerytitle) $gallerytitle = trim($this->lang['gallery']);

		// CUT EXTENSION?
		if ($withoutext) $filename = substr($filename,0,strrpos($filename,'.'));

		// COMPOSE TITEL ELEMENTS
		if ($this->metaseting & 1)										$metatitle[] = $gallerytitle;
		if ($this->metaseting & 2)
			if (($folderID == 1) && !($this->metaseting & 1))	$metatitle[] = $gallerytitle;
			elseif ($foldername)											$metatitle[] = $foldername;
		if ($this->metaseting & 4 && $filename)					$metatitle[] = $filename;
		if ($this->metaseting & 8 && $imagetitle)					$metatitle[] = $imagetitle;

		// RETURN METATEG TITEL
		return @strip_tags(implode($delimiter, $metatitle));
	}

	//
	// GALLERY NAVIGATION
	// kh_mod 0.1.0, changed
	function gallerynavigation($delimiter) {
		if ($_REQUEST['iID'] != '') {
			$folderID = $GLOBALS['folderID'];		// kh_mod 0.2.0, changed
		}
		elseif ($_REQUEST['fID'] != '') {
			$folderID = $this->parentfolder;
		}
		else {
			$folderID = 'root';
		}

		$path = array();
		do {
			if (!$folderRC = $this->all_folders[$folderID]) break;

			$foldername = ($folderRC[2] != '')?		// kh_mod 0.2.0, changed
								$folderRC[2]
								:
								$this->lang['gallery'];
			$path[$folderID] = '<a href="'. $this->indexfile .'?fID='. $folderID .'">'. $foldername .'</a>';
			$folderID		  = $folderRC[1];
			if (!empty($path[$folderID])) break;	// circle link!
		}
		while ((int)$folderID > 0);

		if ($this->websitelink != '')
			$path[] = '<a href="'. $this->websitelink .'">'. $this->websitetext .'</a>';
		echo implode($delimiter, array_reverse($path));
	}

	//
	// PAGE NAVIGATION
	// kh_mod 0.1.0 rc1, changed
	function pagenavigation($list,$npages,$page) {
		if ($npages > 1) {
			$arrnav[] = '<div align="center">'. $this->lang['page'];
			for ($i=1; $i <= $npages; $i++) {
				$arrnav[] = ($page == $i)?
								$i
								:
								'<a href="'. $this->indexfile .'?fID='.$list.'&amp;page='.$i.'">'. $i .'</a>';
			}
			$arrnav[] = ($page == 'all')?
							$this->lang['all']
							:
							'<a href="'. $this->indexfile .'?fID='.$list.'&amp;page=all">'. $this->lang['all'] .'</a>';
			echo implode(' | ', $arrnav), '</div>';
		}
	}

	//
	// DETERMINE THUMBNAIL FOR FOLDER
	// kh_mod 0.2.0, changed
	function getthumb($folderID) {

		// IS SET FOLDER THUMB?
		$thumbID = (int)$this->all_folders[$folderID][6];
		if ($thumbID > 0 && !($this->folderseting & 16)) {
			$filename  = $this->all_images[$thumbID][6];
			$subdir	  = $this->all_images[$thumbID][7];
			$thumbfile = $this->get_path($filename, $subdir, 'thumb');
			if (is_file($thumbfile)) {
				$this->width  = $this->all_images[$thumbID][10];
				$this->height = $this->all_images[$thumbID][11];
				$this->subfolder_class = 'subfolder border';
				return $thumbfile;
			}
		}

		// IS SET FOLDER PASSWORD?
		$passwrd = trim($this->all_folders[$folderID][8]);
		if ($passwrd != '') {
			$thumbfile = "skins/$this->activeskin/images/locked.gif";
			$this->width  = '150';
			$this->height = '100';
			$this->subfolder_class = 'subfolder';
			return $thumbfile;
		}

		// DOES FOLDER CONTAIN IMAGES?
		$images = $this->select($folderID,$this->all_images,1,0,0);
		if (count($images) > 0 && !($this->folderseting & 16) && $thumbID == -1) {
			$random = array_rand($images);
			$thumbfile = $this->get_path($images[$random][6],$images[$random][7],'thumb');
			if (is_file($thumbfile)) {
				$this->width  = $images[$random][10];
				$this->height = $images[$random][11];
				$this->subfolder_class = 'subfolder border';
				return $thumbfile;
			}
		}

		// FOLDER NOT EMPTY?
		$folders = $this->select($folderID,$this->all_folders,1,0,0);
		if (count($folders) > 0 || count($images) > 0) {
			$thumbfile = "skins/$this->activeskin/images/folder.gif";
			$this->width  = '150';
			$this->height = '100';
			$this->subfolder_class = 'subfolder';
			return $thumbfile;
		}

		// FOLDER IS EMPTY
		$thumbfile = "skins/$this->activeskin/images/emptyfolder.gif";
		$this->width  = '150';
		$this->height = '100';
		$this->subfolder_class = 'subfolder';
		return $thumbfile;
	}

	//
	// READ FOLDER SETTINGS
	// kh_mod 0.2.0, changed
	function getfoldersettings($folderID) {
		$folderRC = $this->all_folders[$folderID];
		if (!$folderRC) return false;

		if ($folderID == '1') $this->parentfolder = 'root';
		else $this->parentfolder = $folderRC[1];
		if ((int)$folderRC[7] < 1) {
			$this->folder_sortby  = 1;
			$this->folder_sortway = 0;
		}
		else {
			$this->folder_sortby  = (int)$folderRC[7] & 15;
			$this->folder_sortway = (int)$folderRC[7] & 16;
		}
		if (!isset($folderRC[4])) $this->folder_publish = 0;
		else $this->folder_publish = (int)$folderRC[4];
		if (!isset($folderRC[3])) $this->introtext = '';
		else $this->introtext = $folderRC[3];
		if (!isset($folderRC[5])) $this->folder_position = '1';
		else $this->folder_position = $folderRC[5];
		return true;
	}

	//
	// JAVASCRIPT VERIFY FOR COMMENTS
	// kh_mod 0.1.0, add
	function jsformvalid() {
		$validpath = 'includes/mg2_jsformvalid.php';
		if ((($this->commentsets&5)===5) && is_readable($validpath)) {
			include($validpath);
		} else {
			echo '<script language="JavaScript" type="text/javascript">
					<!--
						function validateCompleteForm(a,b) { return true; }
					-->
					</script>';
		}
	}

	//
	// GET GD LIB VERSION
	//
	function gd_version() {
		$gdInfo = gd_info();
		$this->gd_version_number = trim(preg_replace("/[a-z()]/i", "", $gdInfo["GD Version"]));	// kh_mod 0.1.0, changed
		return $this->gd_version_number;
	}

	//
	// GALLERY SECURITY
	// kh_mod 0.2.0, changed
	function gallerysecurity($list, $imageID) {

		$folderID = $list;	// for template 'thumbnails_password.php'

		// FOLDER DISPLAY NOT YET OR FORBIDDEN
		$fIDs = array();
		do {
			if (!is_array($this->all_folders[$list]))	notexists($imageID);
			$fIDs[$list] = $list;
			if ((int)$list == 1) break;

			$list = (int)$this->all_folders[$list][1];		// get parent folder ID
			if (isset($fIDs[$list])) notexists('demaged');	// circle link
		}
		while (1);

		// CHECK FOLDER PASSWORD
		foreach ($fIDs as $list) {
			$folderpwd = trim($this->all_folders[$list][8]);
			if ($folderpwd !== '' && $folderpwd !== $_SESSION[PRE_SESSION.'folderpwd'][$list]) {
				// PASSWORD ENTRY CORRECT?
				if (md5(strrev(md5($_POST['password']))) === $folderpwd) {
					$_SESSION[PRE_SESSION.'folderpwd'][$list] = $folderpwd;
					unset($_POST['password']);
				}
				// PASSWORD DIALOG
				else {
					$this->introtext   = '';
					$this->startimage	 = '';
					$pwdheadline		 = ($_POST['password'])?
												$this->lang['wronglogin']
												:
												$this->lang['enterpassword'];				  
					$_REQUEST['fID']   = $list; 									// for gallerynavigation()
					$this->parentfolder = $this->all_folders[$list][1];	// for gallerynavigation()
					unset($_REQUEST['iID']);							 			// for gallerynavigation()
					thumbnails_begin($list);
					include("skins/$this->activeskin/templates/thumbnails_password.php");
					exit();
				}
			}
			if ($this->extendedset & 1) break;	// password management not recursiv
		}
	}

	// kh_mod 0.2.0, changed
	function charfix($string, $trim=false, $html=false) {
		$string = trim($string);
		if ($trim) $string = trim($string,$trim);
		$string = str_replace("\t","   ",$string);	// item delimiter in database
		$string = str_replace('\"','"',$string);		// to avoid magic quots 
		$string = str_replace("\'","'",$string);		// to avoid magic quots
		if ($html) $string = @htmlspecialchars($string, ENT_QUOTES);
		return $string;
	}

	// kh_mod 0.2.0, changed
	function readcomments($comment_file) {
		$this->comments	= array();
		$this->commautoid	= 0;
		if (is_readable($comment_file)) {
			$fd = @fopen($comment_file,'r');
			$this->commautoid = trim(fgets($fd,32));
			while ($fd && !feof($fd)) {
				if (fgets($fd,2) !== '#')	continue;	// no data row?
				$record = fgetcsv($fd,4600,"\t");
				$this->comments[$record[0]] = $record;
			}
			fclose($fd);
			$this->log("Read comments from '$comment_file'");
		}
		elseif (is_file($comment_file)) {
			$this->log("ERROR: Couldn't read comments from '$comment_file'!");
			return false;
		}
		return count($this->comments);
	}

	// kh_mod 0.2.0, changed
	function writecomments($commfile,$add=true) {
		$fok  = false;
		$ip   = ($this->commentsets & 64)? getenv('REMOTE_ADDR'):'-';
		$host = ($this->commentsets & 64)? gethostbyaddr($ip):'-';
		$todo = ($add)? 'added to':'changed in';
		do {
			if (is_file($commfile) && !is_writeable($commfile)) {
				$message = 'Comment couldn\'t be '.$todo.' \''.$commfile.'\', since the comment file is write protected';
				break;
			}
			if (!is_writeable($this->imagefolder))	{
				$message = 'Comment couldn\'t be '.$todo.' \''.$commfile.'\', since the image folder is write protected';
				break;
			}
			if (!@is_array($this->comments)) {
				$message = 'Comment couldn\'t be '.$todo.' \''.$commfile.'\', since no entries were found.';
				break;
			}
			if (!$fd = fopen($commfile,'w')) {
				$message = 'Commentfile \''.$commfile.'\' couldn\'t be opened for writing';
				break;
			}

			// CREATE DATA CONTENT FOR COMMENT FILE
			$buffer = $this->commautoid ."\n";
			foreach ($this->comments as $record) {
				$buffer.= '#';
				$buffer.= @implode("\t",$record);
				$buffer.= "\n";
			}

			if (!flock($fd, LOCK_EX)) {
				$message = 'Commentfile \''.$commfile.'\' couldn\'t be locked for writing';
			}
			elseif ($fok = fwrite($fd, $buffer)) {
				$message = 'Write comment file \''.$commfile.'\'';
			}
			else {
				$message = 'Couln\'t write comment file \''.$commfile.'\'';
			}

			flock($fd, LOCK_UN);	// UNLOCK FILE
			fclose($fd);			// CLOSE FILE
		}
		while(0);

		// WRITE LOG FILE
		$message.= "\n                     ";
		$message.= (($fok)? '(Filesize: '. $fok .' Bytes,':'(From') . ' IP: '. $ip .', HOST: '. $host .')';
		$this->log($message);

		return $fok;
	}

	// kh_mod 0.2.0, changed
	function addcomment($filename, $subdir) {
		$add_ok = false;
		do {
			// READ COMMENT FILE
			$commfile = $this->get_path($filename, $subdir, 'comment');
			$comments = $this->readcomments($commfile);
			if ($comments===false) { $this->status = $this->lang['commenterror']; break; }

			// GET AND CLEAN NEW COMMENT INPUT
			$commentID = ++$this->commautoid;
			if (!$this->cleancomment($commentID)) break;

			// SAVE NEW COMMENT RECORD FOR EMAIL
			$newcomment = &$this->comments[$commentID];

			// WRITE NEW COMMENT
			$add_ok = $this->writecomments($commfile);
			$this->status = ($add_ok===false)?
								 $this->lang['commenterror']		// for gallery output
								 :
								 $this->lang['commentadded'];		// for gallery output

			// SEND COMMENT EMAIL
			if (!($this->commentsets & 8) || !$this->adminemail) break;
			$HOST		= $_SERVER['HTTP_HOST'];
			$URI		= $_SERVER['REQUEST_URI'];
			$ID		= (int)$_POST['iID'];
			$to		= $this->adminemail;
			$subject	= $this->gallerytitle .": ". $this->lang['commentadded'];
			$body		= strtoupper($this->lang['from']) .":\n";
			$body	  .= $newcomment[1] ."(". $newcomment[2] .")\n\n";
			$body	  .= strtoupper($this->lang['comment']) .":\n";
			$body	  .= str_replace("<br />", "\n",$newcomment[3]) ."\n\n";
			$body	  .= "http://". $HOST . $URI ."?iID=". $ID;
			$body	  .= (!$add_ok)? "\n\nERROR: Couldn't write comment file!":"";
			$from		= "From: ". $newcomment[2] ."\nReply-to: ". $newcomment[2];
			$mail_ok	= @mail($to, $subject, $body, $from);
			$this->log(($mail_ok)? "Send comment by email":"ERROR: Couldn't send new comment by email!");
		}
		while(0);

		return $add_ok;
	}

	// kh_mod 0.2.0, changed
	function cleancomment($commentID, $add=true) {
		// CLEAN UP INPUT
		$name	  = $this->charfix(substr($_POST['name'],0,90), false, true);
		$email  = $this->charfix(substr($_POST['email'],0,90), false, true);
		$body   = $this->charfix(substr($_POST['body'],0,4096));
		$body	  = @strip_tags($body, '<b></b><i></i><u></u><strong></strong><em></em>');
		$bodybr = @preg_replace('/\r\n|\r|\n/', '<br />', $body);

		$clean_ok = false;
		do {
			// ARE ALL FIELDS NOT EMPTY?
			if ($email == '' || $name == '' || $body == '') {
				$this->status = $this->lang['commentmissing']; break;
			}

			// EMAIL CORRECT?
			$cClass = '[_a-z'.$this->lang['specialchars'].'0-9-]';
			$regexp = '/^'.$cClass.'+(\.'.$cClass.'+)*@'.$cClass.'+(\.'.$cClass.'+)*\.([a-z]{2,5})$/i';
			if (!@preg_match($regexp, $email)) {
				$this->status = $this->lang['emailerror']; break;
			}

			// COMMENT ALLREADY EXISTS?
			$comment_exists = $this->select($bodybr,$this->comments,3,0,0);
			$comment_exists = $this->select($name,$comment_exists,1,0,0);
			$comment_exists = $this->select($email,$comment_exists,2,0,0);
			if (count($comment_exists) < 0) {
				$this->status = $this->lang['commenterror'];  break;;
			}
			if (count($comment_exists) > 0) {
				$this->status = $this->lang['commentexists']; break;;
			}

			// INPUT VALUES ARE CLEAN
			$clean_ok = true;

			// USE COMMENT ENTRY WITH <br />
			$body = $bodybr;
		}
		while(0);

		// SAVE NEW COMMENT (GALLERY)
		if ($add) {
			$this->comments[$commentID] = array(
													$commentID,	// comment ID
													$name,		// name of poster
													$email,		// email of poster
													$body,		// comment
													time(),		// entry time
													-1,			// last changed
													0,				// changes
													1				// display true
													);
		}
		// CHANGE COMMENT (ADMIN)
		else {
			$this->comments[$commentID][1] = $name;	// name of poster
			$this->comments[$commentID][2] = $email;	// email of poster
			$this->comments[$commentID][3] = $body;	// comment
		}

		return $clean_ok;
	}

	// kh_mod 0.2.0, add
	function displaycaptcha() {
		$captcha = '<img src="'.ADMIN_FOLDER.'/images/captcha.png" width="210" height="70" alt="" />';
		return $captcha;
	}

	// kh_mod 0.1.0 rc1, add
	function checkLanguage($lang) {
		return (!empty($lang) && is_readable('lang/'. $lang))? true:false;
	}

	// kh_mod 0.1.0, changed
	function output($var) {
		echo (isset($this->$var))? $this->$var:'';
	}

	// kh_mod 0.2.0, changed
	function log($entry='', $block=false) {
		$logfile  = DATA_FOLDER .'.mg2_log';
		$filesize = (is_file($logfile))? filesize($logfile):-1;

		// DELETE LARGE LOG FILE
		if ($filesize > 450000) unlink($logfile);
		if (!$block) $entry = date("Ymd, H.i.s : ") . $entry . "\n";

		// ADD LOG ENTRY
		if ($filesize > 0) {
			$fd = fopen($logfile,'a+');
			fwrite($fd, $entry);
		} 
		// CREATE NEW LOGFILE
		else {
			$fd = fopen($logfile,'a');
			fwrite($fd,"MG2/kh_mod LFS (Log File System)\n\n");
			fwrite($fd,"Version: $this->version/$this->modversion\n");
			fwrite($fd,"Install date: " . date("Y-m-d",$this->installdate) . "\n\n---LOG BEGIN------------------\n\n");
			fwrite($fd, $entry);
		}
	}

	//
	// GENERATE PATH FOR IMAGE, MEDIUM, THUMB AND COMMENT
	// kh_mod 0.2.0, add
	function get_path($fname, $subdir, $type='image') {
		$ext = strrchr($fname, '.');
		$len = strlen($ext);
		if ($len > 1) {
			$path	  = $this->imagefolder . $subdir .'/';
			switch ($type) {
				case 'image':	return $path . $fname;
				case 'medium':	return $path . substr($fname, 0, -$len) .'_medium'. $ext;
				case 'thumb':	return $path . substr($fname, 0, -$len) .'_thumb'. $ext;
				case 'comment':return $path . $fname .'.comment';
			}
		}
		return false;
	}

	//
	// CONVERT DATE TO TIMESTAMP
	// kh_mod 0.1.0 b3, add
	function date2time($date='') {
		if (empty($date))	return time();

		// DATE FORMAT
		$dateForm  = $this->dateformat;

		// ALLOW DATE FORMATS
		$regexp1 = '/(%d|%e)(.*)(%b|%m)(.*)(%y|%Y)/';
		$regexp2 = '/(%b|%m)(.*)(%d|%e)(.*)(%y|%Y)/';
		$regexp3 = '/(%y|%Y)(.*)(%b|%m)(.*)(%d|%e)/';

		// CHECK DATE FORMAT AND DETERMINE ORDER
		if (@preg_match($regexp1,$dateForm, $item)) {
			$res = array(2,1,3);  // DAY, MONTH, YEAR
		}
		elseif (@preg_match($regexp2,$dateForm, $item)) {
			$res = array(1,2,3);  // MONTH, DAY, YEAR
		}
		elseif (@preg_match($regexp3,$dateForm, $item)) {
			$res = array(2,3,1);  // YEAR, MONTH, DAY
		}
		else return false;

		// DETERMINE DATE REGEXP
		$regexp = '';
		foreach ($item as $a) {
			switch ($a) {
				case '%d': $regexp.= '(\d{2}|\d{1})';	break;
				case '%e': $regexp.= '(\d{2}|\d{1})';	break;
				case '%b': $regexp.= '(\w{3}\.?)';		break;
				case '%m': $regexp.= '(\d{2}|\d{1})';	break;
				case '%y': $regexp.= '(\d{2})';			break;
				case '%Y': $regexp.= '(\d{4})';			break;
				case ''  : $regexp.= '';					break;
				default:   $regexp.= '\W*';
			}
		}
		$regexp = '/'. $regexp .'\W*(\d{1,2})?\W*(\d{2})?/';

		// GET EACH DATE VALUE
		$timestamp = false;
		if (@preg_match($regexp, $date, $split)) {
			$D = (int)$split[$res[1]];					// DAY
			$Y = (int)$split[$res[2]];					// YEAR
			if (!isset($split[4])) $split[4] = 0;	// HOUR
			if (!isset($split[5])) $split[5] = 0;	// MINUTE

			// MONTH TO NUMBER
			if (strlen($M) > 2) {
				$M = ucfirst(strtolower($split[$res[0]]));
				$M = 1 + array_search(substr($M,0,3),$this->lang['months']);
			} else {
				$M = (int)$split[$res[0]];
			}

			// CHECK DATE
			if (checkdate($M, $D, $Y)) {
				$mk = @mktime((int)$split[4], (int)$split[5], 0, $M, $D, $Y);
				if ($mk > 0) $timestamp = $mk;
			}
		}
		return $timestamp;
	}

	//
	// CONVERT TIMESTAMP TO DATE
	// kh_mod 0.2.0, changed
	function time2date($timestamp=0, $showTime=false) {
		if ((int)$timestamp < 0) return ' - ';

		// TIMESTAMP EMPTY?
		if (empty($timestamp)) $timestamp = time();
		$dateForm = ($showTime===true)?
						$this->dateformat .', %H:%M'
						:
						$this->dateformat;

		// SIMULATION '%e'
		$replace  = sprintf("%'2d", date("j", $timestamp));
		$dateForm = str_replace('%e',$replace,$dateForm);

		// SIMULATION '%b' (lokalisiert)
		$replace  = $this->lang['months'][(date("m", $timestamp)-1)];
		$dateForm = str_replace('%b',$replace,$dateForm);

		// Datum und Uhrzeit formatiert
		return strftime($dateForm, $timestamp);
	}
}	// END CLASS' mg2db'

//
// CLICK COUNTER CLASS
// kh_mod 0.1.0 rc1, add
class MG2counter {
	var $database = 'database.txt';

	// INITIALIZE COUNTER
	function __construct($array=array()) {
		if (!is_array($array)) return;
		$this->data = $array;
		$this->loadDatabase();
	}

	function loadDatabase() {
		if ($fp = @fopen($this->database, 'r')) {
			while (!feof($fp)) {
				$line = fgets($fp);
				if ($line != '') {
					$item = explode('|', $line, 2);
					$this->data[trim($item[0])] = trim($item[1]);
				}
			}
		}
	}

	function plusDatabase($id) {
		$this->data[$id]++;
		if ($fp = @fopen($this->database, 'w')) {
			foreach($this->data as $key=>$item) {
				fwrite($fp, $key ."|". $item ."\n");
			}
			fclose($fp);
		}
	}
}	// END CLASS' MG2Counter'
?>
