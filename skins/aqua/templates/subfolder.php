<?php $distance = 164 - $mg2->height;?>
<td valign="top">
	<table cellpadding="0" cellspacing="0" class="<?php $mg2->output('subfolder_class'); if ($mg2->new) echo ' marknew';?>" align="center">
		<tr>
			<td>
				<a href="<?php $mg2->output('link');?>">
				<img src="<?php $mg2->output('thumbfile');?>" border="0" height="<?php $mg2->output('height');?>" width="<?php $mg2->output('width');?>" alt="" class="thumb" />
				<br /><img src="skins/<?php echo $mg2->activeskin;?>/images/1x1.gif" width="1" height="<?php echo $distance;?>" alt="" /><br />
				<?php $mg2->output('foldername');?>
				</a>
			</td>
		</tr>
	</table>
</td>
