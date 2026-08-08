<form name="editfolder" action="admin.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="fID" value="<?php echo (int)$_REQUEST['fID'];?>" />
<input type="hidden" name="page" value="<?php echo (int)$_REQUEST['page'];?>" />
<input type="hidden" name="action" value="newfolder" />
<table class="table_actions" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td class="td_headline" colspan="4"><?php echo $mg2->lang['newfolder'];?></td>
</tr>
<tr valign="top">
  <td class="td_files" width="170" align="center" rowspan="5">
<?php
		// SETUP: FORCE FOLDER ICONS?
		if ($mg2->folderseting & 16)	echo
			'<a href="admin.php?action=setup&amp;fID='. (int)$_REQUEST['fID'] .'&amp;page='. (int)$_REQUEST['page'] .
			'">'. $mg2->lang['menutxt_setup'] .'</a>: '. $mg2->lang['foldericons'] .
			'<br /><br />';
?>
	<img src="<?php echo ADMIN_FOLDER;?>images/folder.gif" width="150" height="100" alt="">
	<br /><br />
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td style="height:20px;">
				<input type="radio" name="icon" id="randomicon" value="-1" style="vertical-align:middle;" checked />
				<label for="randomicon" style="vertical-align:middle;"><?php echo $mg2->lang['randomicon'];?></label>
			</td>
		</tr><tr>
			<td style="height:20px;">
				<input type="radio" name="icon" id="defaulticon" value="" style="vertical-align:middle;" />
				<label for="defaulticon" style="vertical-align:middle;"><?php echo $mg2->lang['defaulticon'];?></label>
			</td>
		<tr>
	</table>
	<?php if ($mg2->folderseting & 16)	echo '<br />&nbsp;';?>
	</td>
	<td class="td_actions_right" width="100">&nbsp;<?php echo $mg2->lang['foldername'];?></td>
	<td class="td_actions_right">
		<input type="text" name="name" value="<?php echo $folder ?>" size="30" class="admintext" />
	</td>
	<td class="td_actions" rowspan="5">
		<table class="td_actions_noborder" cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="td_actions_right" width="100"><?php echo $mg2->lang['sortby'];?></td>
				<td class="td_actions_noborder">
					<select size="8" name="sortby" class="admindropdown">
						<option value="6" selected="selected"><?php echo $mg2->lang['name'];?></option>
						<option value="5"><?php echo $mg2->lang['position'];?></option>				<!-- kh_mod 0.1.0, add-->
						<option value="4"><?php echo $mg2->lang['date'];?></option>
						<option value="2"><?php echo $mg2->lang['title'];?><sup>*</sup></option>	<!-- kh_mod 0.1.0, add-->
						<option value="3"><?php echo $mg2->lang['description'];?></option>
						<option value="12"><?php echo $mg2->lang['filesize'];?><sup>*</sup></option>
						<option value="8"><?php echo $mg2->lang['width'];?><sup>*</sup></option>
						<option value="9"><?php echo $mg2->lang['height'];?><sup>*</sup></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td_actions_right" width="100"><?php echo $mg2->lang['direction'];?></td>
				<td class="td_actions_noborder">
					<select size="2" name="direction" class="admindropdown">
						<option value="0" selected="selected"><?php echo $mg2->lang['ascending'];?></option>
						<option value="1"><?php echo $mg2->lang['descending'] ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="td_actions_noborder">
					<br /><?php echo $mg2->lang['sortfolder'];?>
				</td>
			</tr>
		</table>
  </td>
</tr>
<tr valign="top">
	<td class="td_actions_right">&nbsp;<?php echo $mg2->lang['position'];?></td>
	<td class="td_actions_right">
		<input type="text" name="position" value="1" size="19" class="admintext" />
	</td>
</tr>
<tr valign="top">
	<td class="td_actions_right">&nbsp;<?php echo $mg2->lang['publish'];?></td>
	<td class="td_actions_right">
	<input type="text" name="publish" id="publish" value="<?php echo $mg2->time2date('', true);?>" size="19" class="admintext" autocomplete="new-password" />
<?php
		if (isset($Calendar) && gettype($Calendar) == 'object') {
			echo '&nbsp;'.
			$Calendar->_make_calendar(
				// calendar options go here; see the documentation and/or calendar-setup.js
				array('date'			=> $mg2->time2date('', true),		// CALENDAR START DATE
						'ifFormat'		=> $mg2->dateformat .', %H:%M',	// CALENDAR FORMAT
						'inputField'	=> 'publish')							// INPUT FIELD ID
			);
		}
?>
	</td>
</tr>
<tr valign="top">
	<td class="td_actions_right">&nbsp;<?php echo $mg2->lang['introtext'];?></td>
	<td class="td_actions_right"><table class="table_wysiwyg_folder"><tr><td>
    <textarea id="editor" cols="60" rows="10" name="introtext" class="admindropdown"></textarea>
   </td></tr></table></td>
</tr>
<tr valign="top">
	<td class="td_actions">&nbsp;<?php echo $mg2->lang['password'];?></td>
	<td class="td_actions">
		<input type="password" name="password" value="" size="30" class="admintext" autocomplete="new-password" />
	</td>
</tr>
<tr>
	<td colspan="4" align="center" class="td_actions">
		<a href="admin.php?fID=<?php echo $_REQUEST['fID'].'&amp;page='.$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/cancel.gif" width="24" height="24" alt="<?php echo $mg2->lang['cancel'];?>" title="<?php echo $mg2->lang['cancel'];?>" border="0" class="adminpicbutton" /></a>
		<input type="image" src="<?=ADMIN_FOLDER?>images/ok.gif" class="adminpicbutton" alt="<?php echo $mg2->lang['ok'];?>" title="<?php echo $mg2->lang['ok'];?>" />
	</td>
</tr>
</table>
</form>
