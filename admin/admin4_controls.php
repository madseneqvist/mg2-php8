</table>
<input type="hidden" name="selectsize" value="<?php echo $selectsize;?>" />
<input type="hidden" name="fID" value="<?php echo $folderID;?>" />
<table class="table_files" cellpadding="0" cellspacing="0">
<tr>
	<td class="td_files" width="30" align="center">
		<img src="<?=ADMIN_FOLDER?>images/checkbox_on.gif" width="13" height="13" alt="<?php echo $mg2->lang["checkall"];?>" title="<?php echo $mg2->lang["checkall"];?>" onclick="checkAll(<?php echo $selectsize;?>,'ctrl')" />
		<img src="<?=ADMIN_FOLDER?>images/checkbox_off.gif" width="13" height="13" alt="<?php echo $mg2->lang["uncheckall"];?>" title="<?php echo $mg2->lang["uncheckall"];?>" onclick="uncheckAll(<?php echo $selectsize;?>,'ctrl')" />
	</td>
	<td class="td_files">
	<select size="1" name="moveto" class="admindropdown">
<?php
	foreach ($mg2->sortedfolders as $pathID=>$folderpath) {
		if ($pathID != $folderID) {
			echo '<option value="'. $pathID .'">'.$folderpath[0] .'</option>';
		}
	}
?>
	</select>
	<input type="submit" name="movefiles"	 value="<?php echo $mg2->lang['buttonmove'];?>" class="adminbutton" alt="<?php echo $mg2->lang['ok'];?>" title="<?php echo $mg2->lang['ok'];?>" onclick="return confirmSubmit(<?php echo $selectsize;?>,'move')" />
	<input type="submit" name="deletefiles" value="<?php echo $mg2->lang['buttondelete'];?>" class="adminbutton" alt="<?php echo $mg2->lang['ok'];?>" title="<?php echo $mg2->lang['ok'];?>" onclick="return confirmSubmit(<?php echo $selectsize;?>,'file')" />
	</td>
</tr>
</table>
</form>
<?php
// DISLPAY MINI THUMB AS TOOLTIPS?
if ($mg2->extendedset & 8) {
	echo '<script type="text/javascript" src="'. ADMIN_FOLDER .'tooltip/wz_tooltip.js">';
	echo '</script>', "\n";
}
?>
