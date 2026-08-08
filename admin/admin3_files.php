<?php
echo '<tr valign="top';
if ($images[$i][5] < 0)
	echo '" bgcolor="#FFCFCF" title="'. $mg2->lang['nodisplay'] .' ('. $mg2->lang['position'] .' '. $images[$i][5] .')';
elseif ($images[$i][4] > time())
	echo '" bgcolor="#FFFF99" title="'. $mg2->lang['notpublished'] .' '. $publishdate;
echo '">';
?>
	<td class="td_div" width="30" align="center"><input type="checkbox" name="selectfile<?php echo $num;?>" value="<?php echo $imageID;?>" /></td>
	<td class="td_files" width="50" align="center" title=""><a href="admin.php?editID=<?php echo $imageID;?>"><img src="<?php echo $thumbfile;?>" width="<?php echo $minithumb_width;?>" height="<?php echo $minithumb_heigth;?>" alt="" class="thumb" onMouseOver="<?=$thumb_info?>" /></a></td>
	<td class="td_files" colspan="2"><span title="<?php echo $imagefile;?>"><?php echo $imagename;?></span></td>
	<td class="td_files" width="30" align="right"><?php echo $images[$i][5];?>&nbsp;&nbsp;</td>			<!-- kh_mod 0.1.0, add -->
	<td class="td_files" width="30" align="center"><?php echo $ncomments;?></td>								<!-- add for psn ;-)  -->	
	<td class="td_files" width="80" align="right"><?php echo $filesize;?>&nbsp;&nbsp;</td>					<!-- kh_mod 0.1.0, changed -->
	<td class="td_files" width="100" align="center"><?php echo $publishdate;?></td>							<!-- kh_mod 0.1.0, changed -->
	<td class="td_div" width="40" align="center"><a href="admin.php?rebuildID=<?php echo $imageID.'&amp;page='.$page;?>"><img src="<?=ADMIN_FOLDER?>images/rebuild.gif" width="24" height="24" alt="<?php echo $mg2->lang['rebuildimages'];?>" title="<?php echo $mg2->lang['rebuildimages'];?>" border="0" /></a></td>
	<td class="td_div" width="40" align="center"><a href="admin.php?editID=<?php echo $imageID;?>">
	<?php if ($images[$i][2] != '' || $images[$i][3] != '') { ?>
	<img src="<?=ADMIN_FOLDER?>images/edit.gif" width="24" height="24" alt="<?php echo $mg2->lang['edit'];?>" title="<?php echo $mg2->lang['edit'];?>" border="0" />
	<?php } else { ?>
	<img src="<?=ADMIN_FOLDER?>images/edit_dimmed.gif" width="24" height="24" alt="<?php echo $mg2->lang['edit'];?>" title="<?php echo $mg2->lang['edit'];?>" border="0" />
	<?php } ?>
	</a></td>
	<td class="td_div" width="40" align="center"><a href="admin.php?deleteID=<?php echo $imageID.'&amp;page='.$page;?>"><img src="<?=ADMIN_FOLDER?>images/delete.gif" width="24" height="24" alt="<?php echo $mg2->lang['delete'];?>" title="<?php echo $mg2->lang['delete'];?>" border="0" /></a></td>
</tr>
