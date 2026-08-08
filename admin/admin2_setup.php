<script language="JavaScript" type="text/javascript">
<!--
function confirmAction(type) {
	if (type=='backup')
		return confirm("Backup of the current database?");
	else if (type=='import')
		return confirm("Import MG2 0.5.0/0.5.1 or kh_mod 0.1.0 database?");
	else if (type=='convert')
		return confirm("Convert MG2 0.5.0/0.5.1 or kh_mod 0.1.0 comment files?");
}
-->
</script>
<form action="admin.php" method="post">
<input type="hidden" name="action" value="writesetup" />
<input type="hidden" name="fID" value="<?php echo $list;?>" />
<input type="hidden" name="page" value="<?php echo $page;?>" />
<table class="table_actions" cellpadding="0" cellspacing="0">
<tr>
  <td colspan="2" align="center" class="td_actions">
    <div align="center">
    <a href="admin.php?fID=<?php echo $list.'&amp;page='.$page;?>"><img src="<?=(ADMIN_FOLDER .'images/cancel.gif')?>" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['cancel'];?>" border="0" class="adminpicbutton" /></a>
    <input type="image" src="<?=(ADMIN_FOLDER .'images/ok.gif')?>" class="adminpicbutton" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" />
    </div>
  </td>
</tr>
<tr valign="top">
  <td class="td_headline" colspan="2"><?php echo $this->lang['setup'];?></td>
</tr>
<tr valign="top">
  <td class="td_setup" width="300"><?php echo $this->lang['gallerytitle'];?></td>
  <td class="td_setup">
    <input type="text" name="gallerytitle" value="<?php echo $this->gallerytitle;?>" size="80" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['adminemail'];?></td>
  <td class="td_setup">
    <input type="text" name="adminemail" value="<?php echo $this->adminemail;?>" size="80" class="admintext" />
  </td>
</tr>
<tr>
	<td class="td_setup" width="300">HTML-Metatag 'title' (gallery)</td>
	<td class="td_setup">
		<input type="checkbox" style="vertical-align:middle;" name="_gallery"	 <?php if($this->metaseting & 1) echo 'checked="checked"';?> value="1" />
		<?php echo $this->lang['gallerytitle'];?> |
		<input type="checkbox" style="vertical-align:middle;" name="_foldername" <?php if($this->metaseting & 2) echo 'checked="checked"';?> value="1" />
		<?php echo $this->lang['foldername'];?> |
		<input type="checkbox" style="vertical-align:middle;" name="_imagename"	 <?php if($this->metaseting & 4) echo 'checked="checked"';?> value="1" />
		<?php echo $this->lang['filename'];?> |
		<input type="checkbox" style="vertical-align:middle;" name="_imagetitle" <?php if($this->metaseting & 8) echo 'checked="checked"';?> value="1" />
		<?php echo $this->lang['imagetitle'];?>
	</td>
</tr>
<tr>
	<td class="td_setup" width="300">HTML-Metatag 'robots' (gallery)</td>
	<td class="td_setup">
		<select size="1" name="_robots" class="admindropdown">
			<option value="0">no entry</option>
			<option value="1"<?php if($this->metaseting & 1<<4) echo ' selected="selected"';?>>noindex, nofollow</option>
			<option value="2"<?php if($this->metaseting & 2<<4) echo ' selected="selected"';?>>index, nofollow</option>
			<option value="4"<?php if($this->metaseting & 4<<4) echo ' selected="selected"';?>>noindex, follow</option>
			<option value="8"<?php if($this->metaseting & 8<<4) echo ' selected="selected"';?>>index, follow</option>
		</select>
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['language'];?></td>
	<td class="td_setup">
		<select size="1" name="defaultlang" class="admindropdown">
<?php
	// kh_mod 0.1.0 b3, changed
	for ($i=0; $i < count($lang); $i++){
		echo '<option '.$lang[$i][0].'>'.$lang[$i][1].'</option>';
	}
	// end
?>
    </select> <?php echo '&nbsp;('.$this->charset.')';?>
  </td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['skin'];?></td>
	<td class="td_setup">
		<select size="1" name="activeskin" class="admindropdown">
<?php
	// kh_mod 0.1.0 b3, changed
	for ($i=0; $i < count($skins); $i++) {
		echo '<option '.$skins[$i][0].'>'.$skins[$i][1].'</option>';
	}
	// end
?>
    </select>
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['navtype'];?></td>
  <td class="td_setup">
    <select size="1" name="navtype" class="admindropdown">
		<option value="1"<?php if($this->navtype==1) echo ' selected="selected"';?>><?php echo $this->lang['text'];?></option>
		<option value="2"<?php if($this->navtype==2) echo ' selected="selected"';?>><?php echo $this->lang['icons'];?></option>
		<option value="4"<?php if($this->navtype==4) echo ' selected="selected"';?>><?php echo $this->lang['thumbs'];?></option>
		<option value="5"<?php if($this->navtype==5) echo ' selected="selected"';?>><?php echo $this->lang['thumbs'] .', '. $this->lang['text'];?></option>
		<option value="6"<?php if($this->navtype==6) echo ' selected="selected"';?>><?php echo $this->lang['thumbs'] .', '. $this->lang['icons'];?></option>
    </select>
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['slideshowdelay'];?></td>
  <td class="td_setup">
    <input type="text" name="slideshowdelay" value="<?php echo $this->slideshowdelay;?>" size="5" class="admintext" />
  </td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['copyright'];?><br /></td>
	<td class="td_setup">
		<input type="text" name="copyright" value="<?php echo $this->copyright;?>" size="80" class="admintext" /><br />
	</td>
</tr>
<tr>
	<td class="td_setup_bottom" width="300"><?php echo $this->lang['exif_info'];?></td>
	<td class="td_setup_bottom">
		<input type="checkbox" style="vertical-align:middle;" name="_make" id="_make" <?php if($this->showexif & 1) echo 'checked="checked"';?> value="1" />
		<label for="_make" title="Make"><?php echo $this->lang['make'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_model" id="_model" <?php if($this->showexif & 1<<1) echo 'checked="checked"';?> value="1" />
		<label for="_make" title="Model"><?php echo $this->lang['model'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_expotime" id="_expotime" <?php if($this->showexif & 1<<2) echo 'checked="checked"';?> value="1" />
		<label for="_expotime" title="ExposureTime"><?php echo $this->lang['shutter'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_expocomp" id="_expocomp" <?php if($this->showexif & 1<<3) echo 'checked="checked"';?> value="1" />
		<label for="_expocomp" title="ExposureBias"><?php echo $this->lang['exposurecomp'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_aperture" id="_aperture" <?php if($this->showexif & 1<<4) echo 'checked="checked"';?> value="1" />
		<label for="_aperture" title="FNumber"><?php echo $this->lang['aperture'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_focallen" id="_focallen" <?php if($this->showexif & 1<<5) echo 'checked="checked"';?> value="1" />
		<label for="_focallen" title="FocalLength"><?php echo $this->lang['focallength'];?></label>
		<br />
		<input type="checkbox" style="vertical-align:middle;" name="_iso" id="_iso" <?php if($this->showexif & 1<<6) echo 'checked="checked"';?> value="1" />
		<label for="_iso" title="ISOSpeedRating"><?php echo $this->lang['iso'];?></label>
		<input type="checkbox" style="vertical-align:middle;" name="_flash" id="_flash" <?php if($this->showexif & 1<<7) echo 'checked="checked"';?> value="1" />
		<label for="_flash" title="Flash"><?php echo $this->lang['flash'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_original" id="_original" <?php if($this->showexif & 1<<8) echo 'checked="checked"';?> value="1" />
		<label for="_original" title="DTOpticalCapture"><?php echo $this->lang['original'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_software" id="_software" <?php if($this->showexif & 1<<9) echo 'checked="checked"';?> value="1" />
		<label for="_software" title="Software"><?php echo $this->lang['software'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_datetime" id="_datetime" <?php if($this->showexif & 1<<10) echo 'checked="checked"';?> value="1" />
		<label for="_datetime" title="DateTime"><?php echo $this->lang['datetime'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_colorspace" id="_colorspace" <?php if($this->showexif & 1<<11) echo 'checked="checked"';?> value="1" />
		<label for="_colorspace" title="ColorSpace"><?php echo $this->lang['colorspace'];?></label> |
		<input type="checkbox" style="vertical-align:middle;" name="_artist" id="_artist" <?php if($this->showexif & 1<<12) echo 'checked="checked"';?> value="1" />
		<label for="_artist" title="Artist or Copyright"><?php echo $this->lang['photographer'];?></label>
	</td>
</tr>
<tr valign="top">
	<td class="td_headline" colspan="2"><?php echo $this->lang['comments'];?></td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['allowcomments'];?></td>
	<td class="td_setup">
		<input type="checkbox" style="vertical-align:middle;" name="allowcomments" <?php if($this->commentsets & 1) echo 'checked="checked"';?> value="1" />
		<select size="1" name="commentmode" class="admindropdown">
			<option value="0"><?php echo $this->lang['ascending'];?></option>
			<option value="1"<?php if($this->commentsets & 2) echo ' selected="selected"';?>><?php echo $this->lang['descending'];?></option>
		</select>
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['sendmail'];?></td>
	<td class="td_setup">
		<input type="checkbox" name="sendmail" <?php if($this->commentsets & 8) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['jsvalidate'];?></td>
	<td class="td_setup">
		<input type="checkbox" name="jsvalidate" <?php if($this->commentsets & 4) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup_bottom" width="300"><?php echo $this->lang['logip'];?></td>
	<td class="td_setup_bottom">
		<input type="checkbox" name="logip" <?php if($this->commentsets & 64) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr valign="top">
	<td class="td_headline" colspan="2"><?php echo 'Thumbnails';?></td>
</tr>
<!-- kh_mod 0.2.0, changed -->
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['foldersort'];?></td>
  <td class="td_setup">
	<select size="1" name="foldersort" class="admindropdown">
		<option value=""	<?php if(($this->folderseting & 15) == 0)	echo "selected";?>><?php echo $this->lang['foldersetup'];?></option>
		<option value="6"	<?php if(($this->folderseting & 15) == 6)	echo "selected";?>><?php echo $this->lang['name'];?></option>
		<option value="5" <?php if(($this->folderseting & 15) == 5)	echo "selected";?>><?php echo $this->lang['position'];?></option>
		<option value="4" <?php if(($this->folderseting & 15) == 4)	echo "selected";?>><?php echo $this->lang['date'];?></option>
		<option value="3"	<?php if(($this->folderseting & 15) == 3)	echo "selected";?>><?php echo $this->lang['description'];?></option>
	</select>
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['foldericons'];?></td>
  <td class="td_setup">
    <input type="checkbox" name="foldericons" <?php if($this->folderseting & 16) echo 'checked="checked"';?> value="1" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['displayfile'];?></td>
  <td class="td_setup">
    <input type="checkbox" name="displayfile" <?php if($this->folderseting & 32) echo 'checked="checked"';?> value="1" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['thumbquality'];?><br /></td>
  <td class="td_setup">
    <input type="text" name="thumbquality" value="<?php echo $this->thumbquality;?>" size="5" class="admintext" /><br />
  </td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['thumbwidth'];?><br /></td>
	<td class="td_setup">
		<input type="text" name="thumbwidth" value="<?php echo $this->thumbwidth;?>" size="5" class="admintext" /><br />
	</td>
</tr>
<tr>
	<td class="td_setup_bottom" width="300"><?php echo $this->lang['thumbheight'];?><br /></td>
	<td class="td_setup_bottom">
		<input type="text" name="thumbheight" value="<?php echo $this->thumbheight;?>" size="5" class="admintext" /><br />
	</td>
</tr>
<tr valign="top">
	<td class="td_headline" colspan="2"><?php echo $this->lang['layout'];?></td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['imagecolumns'];?></td>
  <td class="td_setup">
    <input type="text" name="imagecolumns" value="<?php echo $this->imagecolumns;?>" size="5" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['imagerows'];?></td>
  <td class="td_setup">
    <input type="text" name="imagerows" value="<?php echo $this->imagerows;?>" size="5" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['marknew'];?></td>
  <td class="td_setup">
    <input type="text" name="marknew" value="<?php echo $this->marknew;?>" size="5" class="admintext" />
  </td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['imgwidth'];?></td>
	<td class="td_setup">
		<input type="text" name="mediumimage" value="<?php echo $this->mediumimage;?>" size="20" class="admintext" />
	</td>
</tr>
<tr>
	<td class="td_setup_bottom" width="300"><?php echo $this->lang['introwidth'];?></td>
	<td class="td_setup_bottom">
		<input type="text" name="introwidth" value="<?php echo $this->introwidth;?>" size="20" class="admintext" />
	</td>
</tr>
<tr valign="top">
	<td class="td_headline" colspan="2"><?php echo $this->lang['passwordchange'];?></td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['oldpasswordsetup'];?></td>
  <td class="td_setup">
    <input type="password" name="oldpassword" value="" size="20" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['newpasswordsetup'];?></td>
  <td class="td_setup">
    <input type="password" name="password" value="" size="20" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['newpasswordsetupconfirm'];?></td>
  <td class="td_setup">
    <input type="password" name="passwordconfirm" value="" size="20" class="admintext" />
  </td>
</tr>
<tr>
  <td class="td_setup_bottom" width="300"><?php echo $this->lang['accesstime'];?></td>
  <td class="td_setup_bottom">
    <input type="text" name="accesstime" value="<?php echo $this->accesstime;?>" size="5" class="admintext" />
  </td>
</tr>
<tr valign="top">
  <td class="td_headline" colspan="2"><?php echo $this->lang['advanced'];?></td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['indexfile'];?></td>
	<td class="td_setup">
		<input type="text" name="indexfile" value="<?php echo $this->indexfile;?>" size="20" class="admintext" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['imagefolder'];?></td>
	<td class="td_setup">
		<input type="text" name="imagefolder" value="<?php echo $this->imagefolder;?>" size="20" class="admintext" />
	</td>
</tr>
<tr valign="top">
	<td class="td_setup" width="300"><?php echo $this->lang['allowedextensions'];?></td>
	<td class="td_setup">
		<input type="text" name="extensions" value="<?php echo $this->extensions;?>" size="20" class="admintext" />
	</td>
</tr>
<tr>
  <td class="td_setup" width="300"><?php echo $this->lang['dateformat'];?></td>
  <td class="td_setup">
    <select size="1" name="dateformat" class="admindropdown">
		<option value="1"<?php	if($this->dateformat == "%d.%m.%Y")		echo ' selected="selected"';?>>DD.MM.YYYY (27.11.2008)</option>
		<option value="2"<?php	if($this->dateformat == "%d. %b., %Y")	echo ' selected="selected"';?>>DD. MMM., YYYY (03. Nov., 2008)</option>
		<option value="3"<?php	if($this->dateformat == "%d. %b. %Y")	echo ' selected="selected"';?>>DD. MMM. YYYY (03. Nov. 2008)</option>
		<option value="4"<?php	if($this->dateformat == "%b. %d, %Y")	echo ' selected="selected"';?>>MMM. DD, YYYY (Nov. 03, 2008)</option>
		<option value="5"<?php	if($this->dateformat == "%b. %e, %Y")	echo ' selected="selected"';?>>MMM. D, YYYY (Nov. 3, 2008)</option>
		<option value="6"<?php	if($this->dateformat == "%e.%m.%y")		echo ' selected="selected"';?>>D.MM.YY (3.11.08)</option>
		<option value="7"<?php	if($this->dateformat == "%m.%e.%y")		echo ' selected="selected"';?>>MM.D.YY (11.3.08)</option>
		<option value="8"<?php	if($this->dateformat == "%Y%m%d")		echo ' selected="selected"';?>>YYYYMMDD (20081127)</option>
		<option value="9"<?php	if($this->dateformat == "%Y-%m-%d")		echo ' selected="selected"';?>>YYYY-MM-DD (2008-11-27)</option>
		<option value="10"<?php	if($this->dateformat == "%d-%m-%Y")		echo ' selected="selected"';?>>DD-MM-YYYY (27-11-2008)</option>
		<option value="11"<?php	if($this->dateformat == "%m-%d-%Y")		echo ' selected="selected"';?>>DD-MM-YYYY (11-27-2008)</option>
		<option value="12"<?php	if($this->dateformat == "%d-%b-%Y")		echo ' selected="selected"';?>>DD-MMM-YYYY (27-Nov-2008)</option>
		<option value="13"<?php	if($this->dateformat == "%b-%d-%Y")		echo ' selected="selected"';?>>MMM-DD-YYYY (Nov-27-2008)</option>
		<option value="14"<?php	if($this->dateformat == "%d/%m/%Y")		echo ' selected="selected"';?>>DD/MM/YYYY (27/11/2008)</option>
		<option value="15"<?php	if($this->dateformat == "%m/%d/%Y")		echo ' selected="selected"';?>>MM/DD/YYYY (11/27/2008)</option>
		<option value="16"<?php	if($this->dateformat == "%e/%m %Y")		echo ' selected="selected"';?>>D/MM YYYY (3/11 2008)</option>
    </select>
  </td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['pwdrecursiv'];?></td>
  <td class="td_setup">
	<input type="checkbox" name="pwdrecursiv" <?php if(!($this->extendedset & 1)) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['samefolders'];?></td>
	<td class="td_setup">
		<input type="checkbox" name="samefolders" <?php if($this->extendedset & 2) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['htmlarea'];?></td>
	<td class="td_setup">
		<input type="checkbox" name="htmlarea" <?php if($this->extendedset & 4) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['tooltips'];?></td>
	<td class="td_setup">
		<input type="checkbox" name="tooltips" <?php if($this->extendedset & 8) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['calendar'];?></td>
	<td class="td_setup">
		<input type="checkbox" name="calendar" <?php if($this->extendedset & 16) echo 'checked="checked"';?> value="1" />
	</td>
</tr>
<tr>
	<td class="td_setup" width="300"><?php echo $this->lang['websitelink'];?></td>
	<td class="td_setup">
		<input type="text" name="websitelink" value="<?php echo $this->websitelink;?>" size="30" class="admintext" />
	</td>
</tr>
<tr>
	<td class="td_setup_bottom" width="300"><?php echo $this->lang['websitetext'];?></td>
	<td class="td_setup_bottom">
		<input type="text" name="websitetext" value="<?php echo $this->websitetext;?>" size="30" class="admintext" />
	</td>
</tr>
<tr>
	<td colspan="2" align="center" class="td_actions">
		<div align="center">
		<a href="admin.php?fID=<?php echo $list.'&amp;page='.$page;?>"><img src="<?=(ADMIN_FOLDER .'images/cancel.gif')?>" width="24" height="24" alt="<?php echo $this->lang['cancel'];?>" title="<?php echo $this->lang['cancel'];?>" border="0" class="adminpicbutton"  /></a>
		<input type="image" src="<?php echo ADMIN_FOLDER .'images/ok.gif';?>" class="adminpicbutton" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" />
		</div>
	</td>
</tr>
<tr valign="top">
	<td class="td_headline" colspan="2"><?php echo $this->lang['actions'];?></td>
</tr>
<tr>
	<td class="td_setup_bottom" colspan="2">
		- <a href="admin.php?action=dbbackup&amp;fID=<?php echo $list.'&amp;page='.$page;?>" title="Backup of the current database" onclick="return confirmAction('backup')"><?php echo $this->lang['backuplink'];?></a><br />
		- <a href="admin.php?action=convert&amp;items=db" title="Import MG2 0.5.0/0.5.1 or kh_mod 0.1.0 database" onclick="return confirmAction('import')"><?php echo $this->lang['dbimport'];?></a><br />
		- <a href="admin.php?action=convert&amp;items=cf" title="Convert MG2 0.5.0/0.5.1 or kh_mod 0.1.0 comment files" onclick="return confirmAction('convert')"><?php echo $this->lang['comments_convert'];?></a><br />
		- <a href="admin.php?action=logfile" target="_blank"><?php echo $this->lang['viewlogfile'];?></a>&nbsp;&nbsp;&nbsp;(<?php if (is_file(DATA_FOLDER .'.mg2_log')) echo round(filesize(DATA_FOLDER .'.mg2_log') / 1000,1);?> KB)
	</td>
</tr>
</table>
</form>
