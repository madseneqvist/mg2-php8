<?php
if ($class == "table_files") echo '<form method="post" name="fileform" action="admin.php">';

echo '<table class="'. $class .'" cellpadding="0" cellspacing="0">';
if ($class == "table_files") {
	echo '
		<tr'. $tableHead .'>
		<td class="td_navigation" colspan="8">'.$navigation.'</td>
		<td class="td_div">
			<a href="admin.php?rebuildfolder='.$folderID.'&page='.$page.'"><img src="'.ADMIN_FOLDER.'images/rebuild.gif" width="24" height="24" alt="'.$mg2->lang['rebuildimages'].'" title="'.$mg2->lang['rebuildimages'].'" border="0" /></a>
		</td>
		<td class="td_div">
			<a href="admin.php?editfolder='.$folderID.'&page='.$page.'"><img src="'.ADMIN_FOLDER.'images/edit.gif" width="24" height="24" alt="'.$mg2->lang['editcurrentfolder'].'" title="'.$mg2->lang['editcurrentfolder'].'" border="0" /></a>
		</td>
		<td class="td_div">
	';
	if ($folderID > 1) {
		echo '
		<a href="admin.php?deletefolder='.$folderID.'&page='.$page.'"><img src="'.ADMIN_FOLDER.'images/delete.gif" width="24" height="24" alt="'.$mg2->lang['deletecurrentfolder'].'" title="'.$mg2->lang['deletecurrentfolder'].'" border="0" /></a>
		';
	} else
		echo '&nbsp;';
	echo '
		</td>
	</tr>
	<tr>
		<td class="td_headline" width="30">&nbsp;</td>
		<td class="td_headline" width="40" align="center">'.$mg2->lang['thumb'].'</td>
		<td class="td_headline" colspan="2">'.$mg2->lang['filename'].'</td>
		<td class="td_headline" width="30" align="center">'.$mg2->lang['position'].'</td>		<!-- kh_mod 0.1.0, add -->
		<td class="td_headline" width="30" align="center">'.$mg2->lang['comments'].'</td>		<!-- add for psn ;-) -->		
		<td class="td_headline" width="80" align="center">'.$mg2->lang['filesize'].'</td>
		<td class="td_headline" width="100" align="center">'.$mg2->lang['dateadded'].'</td>
		<td class="td_headline" width="40">'.$mg2->lang['rebuild'].'</td>
		<td class="td_headline" width="40">'.$mg2->lang['edit'].'</td>
		<td class="td_headline" width="40">'.$mg2->lang['delete'].'</td>
	</tr>
	';
}
?>
