<table class="table_actions" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td class="td_actions_bottom" width="160" align="center"><img src="<?php echo $icon['path'];?>" <?php echo $icon['attrb'];?> alt="<?php echo $icon['path'];?>" title="<?php echo $icon['path'];?>" /><br /></td>
	<td class="td_actions_bottom" align="center">
		<?php echo $this->lang['deletefolder'];?> '<?php echo $this->getfoldername($delfolder);?>'?
		<br /><br />
		<a href="admin.php?fID=<?php echo (int)$_REQUEST['fID'].'&amp;page='.(int)$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/cancel.gif" width="24" height="24" alt="<?php echo $mg2->lang['cancel'];?>" title="<?php echo $mg2->lang['cancel'];?>" border="0" /></a>
		<a href="admin.php?erasefolder=<?php echo $delfolder;?>&amp;page=<?php echo (int)$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/ok.gif" width="24" height="24" alt="<?php echo $mg2->lang['ok'];?>" title="<?php echo $mg2->lang['ok'];?>" border="0" /></a>
	</td>
	<td class="td_actions" width="160">&nbsp;</td>
</tr>
</table>
