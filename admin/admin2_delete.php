<?php if ($display=='comment') { ?>
<table class="table_files" cellpadding="0" cellspacing="0">
<tr>
	<td class="td_files" colspan="7">&nbsp;
	<?php echo $this->lang['navigation'].': '.$this->adminnavigation($folderID).' : '.$filename;?></td>
</tr>
</table>
<?php } ?>
<table class="table_actions" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td class="td_actions_bottom" width="160" align="center"><img src="<?php echo $thumbfile .'?'. rand(0,10000);?>" width="<?php echo $thumb_width;?>" height="<?php echo $thumb_height;?>" alt="" class="thumb" /></td>
	<td class="td_actions_bottom" align="center">
		<?php echo $message;?>
		<br /><br />
		<a href="<?php echo $cancel;?>"><img src="<?php echo ADMIN_FOLDER;?>images/cancel.gif" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['cancel'];?>" border="0" /></a>
		<a href="<?php echo $href_ok;?>"><img src="<?php echo ADMIN_FOLDER;?>images/ok.gif" width="24" height="24" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" border="0" /></a>
		<br />&nbsp;
	</td>
	<td class="td_actions" width="160">&nbsp;</td>
</tr>
</table>
<?php if ($display=='comment') { ?>
<table class="table_actions" cellpadding="0" cellspacing="0">
<tr>
	<td class="td_headline" width="30">&nbsp;</td>
	<td class="td_headline" width="115"><?php echo $this->lang['date'];?></td>
	<td class="td_headline" width="146"><?php echo $this->lang['from'];?></td>
	<td class="td_headline"><?php echo $this->lang['comment'];?></td>
</tr>
<tr>
	<td class="td_files" align="center"><img src="<?php echo ADMIN_FOLDER;?>images/checkbox_on.gif" width="13" height="13" alt=""></td>
	<td class="td_files"><?php echo $comment['date'];?></td>
	<td class="td_files"><a href="mailto:<?php echo $comment['email'];?>"><?php echo $comment['name'];?></a></td>
	<td class="td_files"><?php echo $comment['body'];?></td>
</tr>
</table>
<?php } ?>