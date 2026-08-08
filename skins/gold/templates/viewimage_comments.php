<br />
<br />
<form name="commentform" action="<?php echo $mg2->indexfile;?>" method="post" onsubmit="return validateCompleteForm(this,'error')">
<input type="hidden" name="action" value="addcomment" />
<input type="hidden" name="iID" value="<?php echo $imageID;?>" />
<table cellspacing="0" class="table-comments" align="center">
<?php
// VIEW IMAGE COMMENTS
if ($num_comments > 0) {
	echo '
		<tr>
			<td class="comment-headline">'.
				$mg2->lang['comments'] .' ('. $num_comments .')
			</td>
		</tr>
	';
	foreach ($mg2->comments as $comment) {
		echo '
			<tr>
				<td class="comment-aboveline">'. $mg2->time2date($comment[4],true)
				 .' '. $mg2->lang['by']
				 .' <a href="mailto:'. $comment[2] .'">'. $comment[1] .'</a></td>
			</tr>
			<tr><td class="comment-belowline">'. $comment[3] .'</td></tr>
		';
	}
}
?>
<tr>
	<td class="comment-headline">
		<br />
		<?php echo $mg2->lang['addcomment'];?>
	</td>
</tr>
<tr>
	<td>
		<?php echo $mg2->lang['comment'];?><br />
		<textarea cols="68" rows="3" name="body" id="body" class="comment-textfield"><?php echo $workon[3];?></textarea>
	</td>
</tr>
<tr>
	<td>
		<?php echo $mg2->lang['name'];?><br />
		<input type="text" size="90" maxlength="90" name="name" id="name" value="<?php echo $workon[1];?>" class="comment-textfield" />
	</td>
</tr>
<tr>
	<td>
		<?php echo $mg2->lang['email'];?><br />
		<input type="text" size="90" maxlength="90" name="email" id="email" value="<?php echo $workon[2];?>" class="comment-textfield" />
	</td>		
</tr>
<?php
// VIEW IMAGE CAPTCHA
if ($mg2->commentsets & 32) {
	echo '
		<tr>
			<td>'.
				$mg2->lang['captcha'] .'<br />
				<input type="text" size="30" name="captcha" id="captcha" value="" class="comment-textfield" />
			</td>
		</tr>
		<tr>
			<td>'. $mg2->displaycaptcha() .'</td>
		</tr>
	';
}
?>
<tr>
	<td>
		&nbsp;<br />
		<input type="submit" value="<?php echo $mg2->lang['addcomment'];?>" class="comment-button" />
	</td>
</tr>
</table>
</form>
