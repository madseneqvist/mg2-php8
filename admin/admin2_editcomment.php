<table class="table_files" cellpadding="0" cellspacing="0">
<tr>
	<td class="td_files" colspan="7">&nbsp;
	<?php echo $this->lang['navigation'].': '.$this->adminnavigation($folderID).' : '.$filename;?></td>
</tr>
</table>
<table class="table_actions" cellpadding="0" cellspacing="0">
<form action="admin.php" method="post">
<tr valign="top">
	<td rowspan="6" class="td_actions" width="160" align="center">
		<br /><h3><?php echo $this->lang['edit']; ?></h3>
	</td>
	<td rowspan="6" class="td_actions_bottom" width="10">&nbsp;</td>
	<td colspan="2">&nbsp;</td>
	<td rowspan="6" class="td_actions_bottom" width="150">&nbsp;</td>
</tr>
<tr>
	<td class="td_actions_noborder" width="120"><?php echo $this->lang['date'];?>:</td>
	<td class="td_actions_noborder">
		<?php echo $comment['date'];?><br />&nbsp;
	</td>
</tr>
<tr>
	<td class="td_actions_noborder" width="120"><?php echo $this->lang['name'];?>:</td>
	<td>
		<input type="text" name="name" size="45" value="<?php echo $comment['name'];?>">
	</td>
</tr>
<tr>
	<td class="td_actions_noborder"><?php echo $this->lang['email'];?>:</td>
	<td>
		<input type="text" name="email" size="45" value="<?php echo $comment['email'];?>">
	</td>
</tr>
<tr>
	<td class="td_actions_noborder"><?php echo $this->lang['comment'];?>:</td>
	<td>
		<textarea cols="65" rows="8" name="body"><?php echo $comment['body'];?></textarea>
	</td>
</tr>
<tr>
	<td class="td_actions_bottom">&nbsp;</td>
	<td class="td_actions_bottom">
		<br />
		<input type="hidden" name="editID" value="<?php echo $imageID;?>" />
		<input type="hidden" name="updatecomment" value="<?php echo 'cID'.$commentID;?>" />
		<a href="admin.php?editID=<?php echo $imageID;?>"><img src="<?php echo ADMIN_FOLDER;?>images/cancel.gif" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['cancel'];?>" border="0" /></a>
		<input type="image" src="<?php echo ADMIN_FOLDER;?>images/ok.gif" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" />
	</td>
</tr>
</form>
</table>