<?php
	$max_upload  = get_cfg_var('upload_max_filesize');
	$mg2->status = $mg2->lang['maxupload'] .': ';
	$mg2->status.= @preg_replace('/(\d+)M$/','${1} MByte',$max_upload);
	$mg2->displaystatus();
?>
<form name="uploadform" action="admin.php?fID=<?php echo $_REQUEST['fID'];?>&amp;loading=1" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="upload" />
<table class="table_actions" cellpadding="0" cellspacing="0">
<tr>
	<td width="25"  class="td_headline">&nbsp;</td>
	<td width="450" class="td_headline"><?php echo $mg2->lang['image'];?></td>
	<td class="td_headline"><?php echo $mg2->lang['import'];?></td>
	<td width="80" class="td_headline" align="center"><?php echo $mg2->lang['overwrite'];?></td>
</tr>
<?php for ($x = 0; $x < 10; $x++) { ?>
<tr class="admintdleft">
	<td class="td_actions" align="right"><?php echo $x+1;?>&nbsp;</td>
	<td class="td_actions"><input type="file" name="file[<?=$x?>]" size="60" class="adminbutton" /></td>
	<td class="td_actions">
		<select size="1" name="uploadto[<?=$x?>]" class="admindropdown">
<?php
	foreach ($mg2->sortedfolders as $pathID=>$folderpath) {
		$selected = ($pathID==$_REQUEST['fID'])? ' selected="selected"':'';
		echo '<option value="'. $pathID .'"'. $selected .'>'. $folderpath[0] .'</option>';
	}
?>
		</select>
	</td>
	<td class="td_headline" align="center"><input type="checkbox" name="overwrite<?=$x?>"></td>
</tr>
<?php } ?>
<tr>
	<td class="td_actions_bottom">&nbsp;</td>
	<td class="td_actions" align="center" colspan="2">
		<a href="admin.php?fID=<?php echo $_REQUEST['fID'].'&amp;page='.$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/cancel.gif" class="adminpicbutton" width="24" height="24" border="0" alt="<?php echo $mg2->lang['cancel'];?>" title="<?php echo $mg2->lang['cancel'];?>" /></a>
		<input type="image" src="<?=ADMIN_FOLDER?>images/ok.gif" class="adminpicbutton" alt="<?php echo $mg2->lang['upload'];?>" title="<?php echo $mg2->lang['upload'];?>" />
	</td>
	<td class="td_files" align="center">
		<img src="<?=ADMIN_FOLDER?>images/checkbox_on.gif" width="13" height="13" alt="<?php echo $mg2->lang["checkall"];?>" title="<?php echo $mg2->lang["checkall"];?>" onclick="checkAll(10,'upld')" />
		<img src="<?=ADMIN_FOLDER?>images/checkbox_off.gif" width="13" height="13" alt="<?php echo $mg2->lang["uncheckall"];?>" title="<?php echo $mg2->lang["uncheckall"];?>" onclick="uncheckAll(10,'upld')" />
	</td>
</tr>
</table>
</form>
