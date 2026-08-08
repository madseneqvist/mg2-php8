<td valign="top">
  <table cellpadding="0" cellspacing="0" class="<?php $mg2->output('subfolder_class');?>" align="center" width="<?php echo ($mg2->width+26+26);?>">
    <tr>
	  <td class="dir_topleft"></td>
	  <td class="dir_top" width="<?php $mg2->output('width');?>"></td>
	  <td class="dir_topright"></td>
	</tr>
	<tr>
      <td class="dir_left"></td>
      <td><a href="<?php $mg2->output('link');?>"><img src="<?php $mg2->output('thumbfile');?>" border="0" height="<?php $mg2->output('height');?>" width="<?php $mg2->output('width');?>" alt="" /></a></td>
	  <td class="dir_right"></td>
	</tr>
    <tr>
	  <td class="dir_bottomleft"></td>
	  <td class="dir_bottom" width="<?php $mg2->output('width');?>"></td>
	  <td class="dir_bottomright"></td>
	</tr>
    <tr>
	  <td colspan="3" class="subfolder-title"><?php $mg2->output('foldername');?></td>
    </tr>
  </table>
</td>
