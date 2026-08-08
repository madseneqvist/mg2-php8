<?php
echo '<tr valign="top';
if ($folders[$i][5] < 0)
	echo '" bgcolor="#FFCFCF" title="'. $mg2->lang['nodisplay'] .' ('. $mg2->lang['position'] .' '. $folders[$i][5] .')';
elseif ($folders[$i][4] > time())
	echo '" bgcolor="#FFFF99" title="'. $mg2->lang['notpublished'] .' '. $publishdate;
echo '">';
?>
	<td class="td_div">&nbsp;</td>
	<td class="td_files" width="50" align="center">
		<a href="admin.php?editfolder=<?php echo $folders[$i][0];?>">
		<img src="<?php echo $small_icon;?>" width="30" height="20" alt="" border="0" /></a>
	</td>
	<td class="td_files" colspan="2">
		<a href="admin.php?fID=<?php echo $folders[$i][0];?>"><?php echo $folders[$i][2];?></a>
	</td>
	<td class="td_files" width="30" align="right"><?php echo $folders[$i][5] ?>&nbsp;&nbsp;</td>			<!-- kh_mod 0.1.0, add -->
	<td class="td_files" width="30" align="center">&nbsp;</td>														<!-- add for psn ;-)  -->	
	<td class="td_files" width="80" align="center"><?php echo ucfirst($mg2->lang['folder']);?></td>		<!-- kh_mod 0.1.0, changed -->
	<td class="td_files" width="100" align="center"><?php echo $publishdate;?></td>							<!-- kh_mod 0.1.0, changed -->
	<td class="td_div" width="40" align="center"><a href="admin.php?rebuildfolder=<?php echo $folders[$i][0];?>"><img src="<?=ADMIN_FOLDER?>images/rebuild.gif" width="24" height="24" alt="<?php echo $mg2->lang['rebuildimages'] ?>" title="<?php echo $mg2->lang['rebuildimages'];?>" border="0" /></a></td>
	<td class="td_div" width="40" align="center"><a href="admin.php?editfolder=<?php echo $folders[$i][0];?>"><img src="<?=ADMIN_FOLDER?>images/edit.gif" width="24" height="24" alt="<?php echo $mg2->lang['edit'] ?>" title="<?php echo $mg2->lang['edit'];?>" border="0" /></a></td>
	<td class="td_div" width="40" align="center"><a href="admin.php?deletefolder=<?php echo $folders[$i][0];?>&amp;fID=<?php echo $folders[$i][1].'&amp;page='.$page;?>"><img src="<?=ADMIN_FOLDER?>images/delete.gif" width="24" height="24" alt="<?php echo $mg2->lang['delete'];?>" title="<?php echo $mg2->lang['delete'];?>" border="0" /></a></td>
</tr>
