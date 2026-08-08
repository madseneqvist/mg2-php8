<table class="table_actions" cellpadding="0" cellspacing="0">
<form method="post" name="commentform" action="admin.php">
<input type="hidden" name="action" value="deletecomments" />
<input type="hidden" name="editID" value="<?php echo $editID;?>" />
<input type="hidden" name="selectsize" value="<?php echo $num_comments;?>" />
<tr>
  <td class="td_headline" width="30">&nbsp;</td>
  <td class="td_headline" width="120" align="center"><?php echo $this->lang['date'];?></td>
  <td class="td_headline" width="146"><?php echo $this->lang['from'];?></td>
  <td class="td_headline"><?php echo $this->lang['comment'];?></td>
  <td class="td_headline" width="40" align="center"><?php echo $this->lang['edit'];?></td>
  <td class="td_headline" width="40" align="center"><?php echo $this->lang['delete'];?></td>
</tr>
<?php
$num = 0;
foreach ($this->comments as $comment) {
	// COMMENT UPDATED?
	echo ($updatedComment === (int)$comment[0])?
		'<tr bgcolor="#DBFFF0" title="'.$this->lang['commentupdated'].' '.$filename.'">':
		'<tr>';

	// REDUCE NAME TO 45 CHARS
	$fname = (strlen($comment[1]) > 45)?
				substr($comment[1],0,45) .'...'
				:
				$comment[1];

	// REDUCE COMMENT TO 75 CHARS
	$fcomment = preg_replace('/<br\s*\/?>/','&#182;&nbsp;',$comment[3]);
	if (strlen($fcomment) > 80) $fcomment = substr($fcomment,0,75) .'<a href="admin.php?editID='. $editID .'&editcomment=cID'. $comment[0] .'">...</a>';
?>
	<td class="td_files" align="center"><input type="checkbox" name="comment<?php echo $num++;?>" value="<?php echo $comment[0];?>" /></td>
	<td class="td_files" align="center"><?php echo $this->time2date($comment[4],true);?></td>
	<td class="td_files"><a href="mailto:<?php echo $comment[2];?>"><?php echo $fname;?></a></td>
	<td class="td_files"><?php echo $fcomment;?></td>
	<td class="td_files" align="center"><a href="admin.php?editID=<?php echo $editID;?>&editcomment=cID<?php echo $comment[0];?>" title="<?php echo $this->lang['edit'];?>">
		<img src="<?php echo ADMIN_FOLDER;?>images/edit.gif" width="24" height="24" alt="<?php echo $this->lang['edit'];?>" title="<?php echo $this->lang['edit'];?>" border="0" /></a>
	</td>
	<td class="td_files" align="center"><a href="admin.php?editID=<?php echo $editID;?>&deletecomment=cID<?php echo $comment[0];?>" title="<?php echo $this->lang['delete'];?>">
		<img src="<?php echo ADMIN_FOLDER;?>images/delete.gif" width="24" height="24" alt="<?php echo $this->lang['delete'];?>" border="0" /></a>
	</td>
</tr>
<?php } ?>
<tr>
	<td class="td_files" width="30" align="center">
		<img src="<?php echo ADMIN_FOLDER;?>images/checkbox_on.gif" width="13" height="13" alt="<?php echo $this->lang['checkall'];?>" title="<?php echo $this->lang['checkall'];?>" onclick="checkAll(<?php echo $num_comments;?>,'comm')" />
		<img src="<?php echo ADMIN_FOLDER;?>images/checkbox_off.gif" width="13" height="13" alt="<?php echo $this->lang['uncheckall'];?>" title="<?php echo $this->lang['uncheckall'];?>" onclick="uncheckAll(<?php echo $num_comments;?>,'comm')" />
	</td>
	<td class="td_files" colspan="5">
		<input type="submit" value="<?php echo $this->lang['buttondelete'];?>" class="adminbutton" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" onclick="return confirmSubmit(<?php echo $num_comments;?>,'comm')" />
	</td>
</tr>
</form>
</table>