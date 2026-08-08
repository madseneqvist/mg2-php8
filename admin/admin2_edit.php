<form name="editfolder" action="admin.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="fID" value="<?php echo $folderID;?>" />
<input type="hidden" name="page" value="<?php echo $currentPage;?>" />
<input type="hidden" name="iID" value="<?php echo $editID;?>" />
<input type="hidden" name="action" value="updateID" />
<table class="table_actions" cellpadding="0" cellspacing="0" border="0">
<tr valign="top">
	<td class="td_headline" colspan="2" width="300" style="border-right:0px">
		<?php echo $this->lang['editimage'];?>
	</td>
	<td class="td_headline"><?php $this->output('navstring');?></td>
</tr>
<tr valign="top">
	<td rowspan="7" class="td_files" width="170" align="center">		<!-- kh_mod 0.1.0, changed-->
		<a href="<?php $this->output('indexfile');?>?iID=<?php echo $editID;?>" target="_blank">
		<img src="<?php echo $thumbfile;?>" <?php echo $thumbsize;?>" alt="<?php echo $this->lang['viewimage'];?>" title="<?php echo $this->lang['viewimage'];?>" class="thumb" />
		</a><br /><br />
		<a href="admin.php?rotate=<?php echo $editID;?>&amp;direction=left"><img src="<?php echo ADMIN_FOLDER;?>images/rotateleft.gif" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['rotateleft'];?>" border="0" class="adminpicbutton" /></a>
		<a href="admin.php?rotate=<?php echo $editID;?>&amp;direction=right"><img src="<?php echo ADMIN_FOLDER;?>images/rotateright.gif" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['rotateright'];?>" border="0" class="adminpicbutton" /></a>
	</td>
	<td class="td_actions_right" width="130"><?php echo $this->lang['filename'];?></td>
	<td class="td_actions_right">
		<input type="text" name="filename" value="<?php echo $filename;?>" size="80" class="admintext" />
	</td>
</tr>
<!-- kh_mod 0.1.0, add-->
<tr>
  <td class="td_actions_right"><?php echo $this->lang['position'];?></td>
  <td class="td_actions_right">
    <input type="text" name="position" value="<?php echo $position;?>" size="19" class="admintext" />
  </td>
</tr>
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
<!-- kh_mod 0.1.0, end-->
<tr>
  <td class="td_actions_right"><?php echo $this->lang['title'];?></td>
  <td class="td_actions_right">
    <input type="text" name="title" value="<?php echo $title;?>" size="80" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_actions_right"><?php echo $this->lang['description'];?></td>
  <td class="td_actions_right"><table class="table_wysiwyg"><tr><td>
    <textarea id="editor" cols="78" rows="10" name="description" class="admindropdown"><?php echo $description;?></textarea>
</td></tr></table></td>
</tr>
<tr>
  <td class="td_actions_right"><?php echo $this->lang['photographer'];?></td>
  <td class="td_actions_right">
    <input type="text" name="photographer" value="<?php echo $photographer;?>" size="80" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_actions"><?php echo $this->lang['setasthumb'];?></td>
  <td class="td_actions">
    <select size="1" name="setthumb" class="admindropdown">
<?php
	foreach ($this->sortedfolders as $folderID=>$fullpath) {
		if ($folderID > 1)
			echo '<option value="'. $folderID .'">'.$fullpath[0] .'</option>';
		else
			echo '<option value="">'. $this->lang['nofolderselected'] .'</option>';
	}
?>
	</select>
  </td>
</tr>
<tr>
  <td colspan="4" align="center" class="td_actions">
    <a href="admin.php?fID=<?php echo $folderID.'&amp;page='.$currentPage;?>"><img src="<?php echo ADMIN_FOLDER?>images/cancel.gif" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['cancel'];?>" border="0" class="adminpicbutton" /></a>
    <input type="image" src="<?php echo ADMIN_FOLDER;?>images/ok.gif" class="adminpicbutton" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" />
  </td>
</tr>
</table>
</form>
