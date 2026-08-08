<form name="editfolder" action="admin.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="fID" value="<?php echo $folderID;?>" />
<input type="hidden" name="page" value="<?php echo $page;?>" />
<input type="hidden" name="action" value="updatefolder" />
<?php	$rowspan = ($folderID == 1)? 5:7;?>
<table class="table_actions" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td class="td_headline" colspan="4">
<?php
		echo $this->lang['editfolder'];
		if ($folderID == 1)	echo '&nbsp;('. $this->lang['root'] .')';
?>
	</td>
</tr>
<tr valign="top">
	<td rowspan="<?=$rowspan?>" class="td_files" width="170" align="center">
<?php
		// SETUP: FORCE FOLDER ICONS?
		if ($folderID > 1 && $this->folderseting & 16)	echo
			'<a href="admin.php?action=setup&amp;fID='. $folderID .'&amp;page='.	$page .
			'">'. $this->lang['menutxt_setup'] .'</a>: '. $this->lang['foldericons'] .
			'<br /><br />';
?>
		<a href="<?php echo $this->indexfile;?>?fID=<?php echo $folderID;?>" target="_blank">
		<img src="<?php echo $icon['path'];?>" <?php echo $icon['attrb'];?> alt="<?php echo $this->lang['viewfolder'];?>" title="<?php echo $this->lang['viewfolder'];?>" border="0" />
		</a><br /><br />
<?php
// FOLDER ICON
if ($folderID > 1) {
	echo '<table cellpadding="0" cellspacing="0" border="0">';
	$randomselected  = '';
	$defaultselected = '';
	// image icon from get_foldericon()
	if ($icon['id'] > 0) {
		$thumbfile = basename($icon['thumb']);
		if (strlen($thumbfile) > 22) $thumbfile = substr($thumbfile,0,20) .'...';
		if ($this->all_images[$icon['id']][5] < 0) {
			$thumbtitle = 'Locked: '. $icon['thumb'];
			$thumbcolor = ' background-color:red;';
		} else {
			$thumbtitle = $icon['thumb'];
			$thumbcolor = '';
		}
		echo'
		<tr><td style="height:20px;'.$thumbcolor.'">
			<input type="radio" name="icon" id="imageicon" value="'. $icon['id'] .'" style="vertical-align:middle;" checked="checked" />
			<label for="imageicon" style="vertical-align:middle;" title="'. $thumbtitle .'">'. $thumbfile .'</label>
		</td></tr>
		';
	}
	// random icon
	elseif ($icon['id'] == -1)
		$randomselected  = 'checked="checked"';
	// default icon
	else
		$defaultselected = 'checked="checked"';

	echo '
		<tr>
			<td style="height:20px;">
				<input type="radio" name="icon" id="randomicon" value="-1" style="vertical-align:middle;" '. $randomselected .' />
				<label for="randomicon" style="vertical-align:middle;">'. $this->lang['randomicon'] .'</label>
			</td>
		</tr><tr>
			<td style="height:20px;">
				<input type="radio" name="icon" id="defaulticon" value="" style="vertical-align:middle;" '. $defaultselected .' />
				<label for="defaulticon" style="vertical-align:middle;">'. $this->lang['defaulticon'] .'</label>
			</td>
		<tr>
	</table>
	';
	if ($this->folderseting & 16)	echo '<br />&nbsp;';
}
?>
	</td>
	<td class="td_actions_right" width="100"><?php echo $this->lang['foldername'];?></td>
	<td class="td_actions_right">
<?php
	echo '<input type="text" name="name" value="'.$foldername.'" size="40" class="admintext" />';
	if ($folderRC[8] != '')
		echo '&nbsp;<img src="'. ADMIN_FOLDER .'images/lock.gif" width="16" height="16" align="middle" alt="" />';
?>
	</td>
	<td class="td_actions" rowspan="<?=$rowspan?>" valign="top">
		<table class="td_actions_noborder" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="td_actions_right" width="100"><?php echo $this->lang['sortby'];?></td>
				<td class="td_actions_noborder">
				<?php /*
					Pulldownmenu für die Sortierung von Bildern und Ordnern. Die Werte von 'value' bzw. $folder entsprechen der Position der Einträge in
					den Bilddatensätzen (Array 'all_images') nach denen die Datensätze sortiert werden sollen. Die Datensätze werden mit Hilfe der Funktion
					'readdb()' in 'mg2_functions.php' in das Array 'all_images' eingelesen. Die Änderung der, in dieser Pulldownbox ausgewählten Optionen
					erfolgt mittels der Funktion editID() in 'mg2admin_functions.php'. 
				*/ ?>
					<select size="8" name="sortby" class="admindropdown">
						<option value="6"	 <?php if(($folderRC[7] & 15) ==  6)	echo 'selected="selected"';?>><?php echo $this->lang['name'];?></option>
						<option value="5"  <?php if(($folderRC[7] & 15) ==  5)	echo 'selected="selected"';?>><?php echo $this->lang['position'];?></option>					<!-- kh_mod 0.1.0, add-->
						<option value="4"  <?php if(($folderRC[7] & 15) ==  4)	echo 'selected="selected"';?>><?php echo $this->lang['date'];?></option>
						<option value="2"  <?php if(($folderRC[7] & 15) ==  2)	echo 'selected="selected"';?>><?php echo $this->lang['title'];?><sup>*</sup></option>		<!-- kh_mod 0.1.0, add-->
						<option value="3"  <?php if(($folderRC[7] & 15) ==  3)	echo 'selected="selected"';?>><?php echo $this->lang['description'];?></option>
						<option value="12" <?php if(($folderRC[7] & 15) == 12)	echo 'selected="selected"';?>><?php echo $this->lang['filesize'];?><sup>*</sup></option>
						<option value="8"  <?php if(($folderRC[7] & 15) ==  8)	echo 'selected="selected"';?>><?php echo $this->lang['width'];?><sup>*</sup></option>
						<option value="9"  <?php if(($folderRC[7] & 15) ==  9)	echo 'selected="selected"';?>><?php echo $this->lang['height'];?><sup>*</sup></option>
					</select>
				</td>
			<tr>
			<tr>
				<td class="td_actions_right" width="100"><?php echo $this->lang['direction'];?></td>
				<td class="td_actions_noborder">
					<select size="2" name="direction" class="admindropdown">
						<option value="0" <?php echo ($folderRC[7] & 16)? '':'selected="selected"';?>><?php echo $this->lang['ascending'];?></option>
						<option value="1" <?php echo ($folderRC[7] & 16)? 'selected="selected"':'';?>><?php echo $this->lang['descending'];?></option>
					</select>
				</td>
			<tr>
			<tr>
				<td class="td_actions_right" width="100" title="Generate position numbers automat.">
					<?php echo $this->lang['setpositions'];?>
				</td>
				<td class="td_actions_noborder">
					<input type="checkbox" name="generate" value="ok">
				</tr>
			</tr>
			<tr>
				<td colspan="2" class="td_actions_noborder">
					<br /><?php echo $this->lang['sortfolder'] ?>
				</td>
			<tr>
		</table>
	</td>
</tr>
<?php
if ($folderID > 1) {
	echo '
	<tr>
		<td class="td_actions_right" width="100">'. $this->lang['position'] .'</td>
		<td class="td_actions_right">
		<input type="text" name="position" value="'.$position.'" size="19" class="admintext" />
		</td>
	</tr>
	';
}
?>
<tr>
	<td class="td_actions_right" width="100"><?php echo $this->lang['publish'];?></td>
	<td class="td_actions_right">
		<input type="text" name="publish" id="publish" value="<?php echo $publish;?>" size="19" class="admintext" />
<?php
		if (isset($Calendar) && gettype($Calendar) == 'object') {
			echo '&nbsp;'.
			$Calendar->_make_calendar(
				// calendar options go here; see the documentation and/or calendar-setup.js
				array('date'			=> $publish,							// CALENDAR START DATE
						'ifFormat'		=> $this->dateformat .', %H:%M',	// CALENDAR FORMAT
						'inputField'	=> 'publish')							// INPUT FIELD ID
			);
		}
?>
	</td>
</tr>
<?php
	if ($folderID > 1) {
		echo '
			<tr>
			<td class="td_actions_right">'.$this->lang['moveto'].'</td>
			<td class="td_actions_right">
			<select size="1" name="moveto" class="admindropdown">
		';
		foreach ($this->sortedfolders as $key=>$fullpath) {
			if (!$fullpath[2]) {
				$selected = ($key == $parentID)? ' selected="selected"':'';
				echo '<option value="'.$key.'"'.$selected.'>'.$fullpath[0].'</option>';
			}
		}
		echo '
			</select>
			</td></tr>
		';
	}
?>
<tr>
  <td class="td_actions_right" width="100"><?php echo $this->lang['introtext'];?></td>
  <td class="td_actions_right"><table class="table_wysiwyg_folder"><tr><td>
    <textarea id="editor" cols="60" rows="10" name="introtext" class="admindropdown"><?php echo $introtext;?></textarea>
  </td></tr></table></td>
 </tr>
<tr>
  <td class="td_actions_right" width="100"><?php echo $this->lang['newpassword'];?></td>
  <td class="td_actions_right">
    <input type="password" name="password" value="" size="40" class="admintext" autocomplete="new-password" />
  </td>
</tr>
<tr>
  <td class="td_actions" width="100"><?php echo $this->lang['deletepassword'];?></td>
  <td class="td_actions">
    <input type="checkbox" name="deletepassword" value="1" />
  </td>
</tr>
<tr>
  <td colspan="4" align="center" class="td_actions">
    <a href="admin.php?fID=<?php echo $folderID.'&amp;page='.$page; ?>"><img src="<?=ADMIN_FOLDER?>images/cancel.gif" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['cancel'];?>" border="0" class="adminpicbutton"  /></a>
    <input type="image" src="<?=ADMIN_FOLDER?>images/ok.gif" class="adminpicbutton" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" />
  </td>
</tr>
</table>
</form>
