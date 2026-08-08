</tr>
</table>
<?php
	$mg2->pagenavigation($folderID, $npages, $currentPage);
	if ($folderID == 1)
		echo '
			<div align="center">
				<br />
				<a href="admin.php"><img src="'. ADMIN_FOLDER .'images/key.gif" width="13" height="7" alt="" border="0" /></a>
			</div>
		';
?>
<br />
</body>
</html>