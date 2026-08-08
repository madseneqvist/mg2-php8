<?php $distance = 175 - $mg2->thumb_height;?>
<td valign="top" align="center">
	<table cellpadding="0" cellspacing="0" class="thumb<?php if ($mg2->new) echo ' marknew';?>">
		<tr>
			<td>
				<a href="<?php $mg2->output('link');?>">
				<img src="<?php $mg2->output('thumbfile');?>" border="0" width="<?php $mg2->output('thumb_width');?>" height="<?php $mg2->output('thumb_height');?>" alt="" class="thumb"/>
				<br /><img src="skins/<?php echo $mg2->activeskin;?>/images/1x1.gif" width="1" height="<?php echo $distance;?>" alt="" /><br />
				<?php $mg2->output('title');?></a>
			</td>
		</tr>
	</table>
</td>
