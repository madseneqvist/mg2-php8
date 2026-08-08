<table class="table_actions" cellpadding="0" cellspacing="0">
<form action="admin.php" method="post">
<input type="hidden" name="action" value="import" />
<tr valign="top">
	<td rowspan="4" class="td_actions" width="160" align="center">
		<br /><h3><?php echo $mg2->lang['menutxt_import'];?></h3><br />
	</td>
	<td rowspan="4" class="td_actions_bottom" width="10">&nbsp;</td>
	<td colspan="2">&nbsp;</td>
	<td rowspan="4" class="td_actions_bottom" width="150">&nbsp;</td>
</tr>
<tr>
	<td width="160"><?php echo $mg2->lang['sourcefolder'];?>:</td>
	<td class="td_actions_noborder">
		<select size="1" name="importfrom" class="admindropdown">
			<option value=""><?php echo $mg2->imagefolder;?></option>
<?php
			foreach ($subdirs as $dir) {
				$bg = ($dir[3])? '':' style="background-color:red" title="Write protected!"';
				echo '<option value="'. $dir[0] .'"'. $bg .'>'. $dir[1] .'-'. $dir[2] .'</option>'."\n";
			}
?>
		</select>
	</td>
</tr>
<tr>
	<td><?php echo $mg2->lang['import'];?>:</td>
	<td class="td_actions_noborder">
		<select size="1" name="fID" class="admindropdown">
<?php
	foreach ($mg2->sortedfolders as $folderID=>$fullpath) {
		$selected = ($folderID==$_REQUEST['fID'])? ' selected="selected"':'';
		echo '<option value="'. $folderID .'"'. $selected .'>'. $fullpath[0] .'</option>';
	}
?>
		</select>
	</td>
</tr>
<tr valign="top">
	<td class="td_actions_bottom">&nbsp;</td>
	<td class="td_actions_bottom">
		<br />
		<a href="admin.php?fID=<?php echo $_REQUEST['fID'].'&amp;page='.$_REQUEST['page']; ?>"><img src="<?=ADMIN_FOLDER?>images/cancel.gif" width="24" height="24" alt="<?php echo $mg2->lang['cancel'] ?>" title="<?php echo $mg2->lang['cancel'] ?>" border="0" /></a>
		<input type="image" src="<?=ADMIN_FOLDER?>images/ok.gif" alt="<?php echo $mg2->lang['ok'];?>" title="<?php echo $mg2->lang['ok'];?>" />
	</td>
</tr>
</form>
</table>
