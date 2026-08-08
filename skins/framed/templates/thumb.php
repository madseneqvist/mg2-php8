<td valign="top" width="210" height="190">
	<table cellpadding="0" cellspacing="0" class="thumb" align="center" width="<?php echo ($mg2->thumb_width+26);?>">
		<tr>
			<td class="img_topleft"></td>
			<td class="img_top" width="<?php $mg2->output('thumb_width');?>"></td>
			<td class="img_topright"></td>
		</tr>
		<tr>
			<td class="img_left" height="<?php $mg2->output('thumb_height');?>"></td>
			<td>
				<a href="<?php $mg2->output('link');?>"><img src="<?php $mg2->output('thumbfile');?>" border="0" width="<?php $mg2->output('thumb_width');?>" height="<?php $mg2->output('thumb_height');?>" alt="" /></a></td>
			<td class="img_right" height="<?php $mg2->output('thumb_height');?>"></td>
		</tr>
		<tr>
			<td class="img_bottomleft"></td>
			<td class="img_bottom" width="<?php $mg2->output('thumb_width');?>"></td>
			<td class="img_bottomright<?php if (is_file($result[$i][1] .'.comment')) echo '_comment';?>"></td>
		</tr>
		<tr>
			<td colspan="3" class="title"><?php $mg2->output('title');?></td>
		</tr>
	</table>
</td>
