<?php if ($_REQUEST['step'] == "") { ?>
<table class="table_menu" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td align="center" colspan="4">
		<p><strong>Welcome to MG2 0.5.1 (kh_mod 0.2.1) installation!</strong></p>
		<p><strong>Step 1 / 3</strong></p>
		<p>This script will help you to configure MG2 in 3 easy steps.</p>
		<br />
	</td>
</tr>
<tr valign="middle">
  <td width="140">&nbsp;</td>
  <td class="install_td" width="300">
    'data' subfolder writable:
  </td>
  <td width="200">
    <?php echo $test1 ?>
  </td>
  <td>&nbsp;</td>
</tr>
<tr valign="middle">
  <td width="140">&nbsp;</td>
  <td class="install_td" width="300">
    'pictures' subfolder writable:
  </td>
  <td width="200">
    <?php echo $test2 ?>
  </td>
  <td>&nbsp;</td>
</tr>
<tr valign="middle">
  <td width="140">&nbsp;</td>
  <td class="install_td" width="300">
    Main gallery files exists:
  </td>
  <td width="200">
    <?php echo $test3 ?>
  </td>
  <td>&nbsp;</td>
</tr>
<tr valign="middle">
  <td width="140">&nbsp;</td>
  <td class="install_td" width="300">
    Gallery class files exists:
  </td>
  <td width="200">
    <?php echo $test4 ?>
  </td>
  <td>&nbsp;</td>
</tr>
<tr valign="middle">
  <td width="140">&nbsp;</td>
  <td class="install_td" width="300">
    GD image library version 2.x or newer:
  </td>
  <td width="200">
    <?php echo $test5 ?>
  </td>
  <td>&nbsp;</td>
</tr>
<tr valign="middle">
  <td width="140">&nbsp;</td>
  <td class="install_td" width="300">
    PHP version 8.0 or newer:
  </td>
  <td width="200">
    <?php echo $test6 ?>
  </td>
  <td>&nbsp;</td>
</tr>
<?php if ($todo != "") { ?>
<tr valign="bottom">
	<td>&nbsp;</td>
	<td class="install_td" colspan="3">
		<br />You must complete these steps before continuing:
		<br /><br /><b><?php echo $todo; ?></b>
	</td>
</tr>
<tr valign="top">
	<td align="center" colspan="4">
		<br />
		<form action="<?php echo $PHP_SELF;?>" method="post">
		<input type="hidden" name="step" value="" />
		<input type="image" src="<?php echo ADMIN_FOLDER;?>images/rebuild.gif" class="adminpicbutton" alt="Try it again" title="Try it again" />
		</form>
	</td>
</tr>
<?php } else { ?>
<tr valign="top">
	<td align="center" colspan="4">
		<br />
		<form action="<?php echo $PHP_SELF;?>" method="post">
		<input type="hidden" name="step" value="2" />
		<input type="image" src="<?php echo ADMIN_FOLDER;?>images/ok.gif" class="adminpicbutton" alt="Next" title="Next" />
		</form>
	</td>
</tr>
<?php } ?>
</table>
<?php }

if ($_REQUEST['step'] == "2") {?>
<form action="<?php echo $PHP_SELF;?>" method="post">
<table class="table_menu" cellpadding="0" cellspacing="0">
<tr>
	<td align="center" colspan="3">
		<p><strong>Welcome to MG2 0.5.1 (kh_mod 0.2.1) installation!</strong></p>
		<p><strong>Step 2 / 3</p>
		<br />
	</td>
</tr>
<tr>
  <td width="200">&nbsp;</td>
	<td class="install_td" width="190"><?php echo $mg2->lang['gallerytitle'];?></td>
	<td>
		<input type="text" name="gallerytitle" value="My gallery" size="80" class="admintext" />
	</td>
</tr>
<tr>
	<td width="200">&nbsp;</td>
	<td class="install_td" width="190"><?php echo $mg2->lang['adminemail'];?></td>
	<td>
		<input type="text" name="adminemail" value="" size="80" class="admintext" />
	</td>
</tr>
<tr>
	<td width="200">&nbsp;</td>
	<td class="install_td" width="190"><?php echo $mg2->lang['language'];?></td>
	<td>
		<select size="1" name="defaultlang" class="admindropdown">
<?php
	for ($i=0; $i < count($lang_arr); $i++) {
		$selected = ($lang_arr[$i] == $def_lang)? ' selected="selected"':'';
		echo '<option value="'. $lang_arr[$i] .'"'. $selected .'>'. ucfirst(substr($lang_arr[$i],0,strlen($lang_arr[$i])-4)) .'</option>';
	}
?>
		</select>
	</td>
</tr>
<tr>
	<td width="200">&nbsp;</td>
	<td class="install_td" width="190"><?php echo $mg2->lang['skin'];?></td>
	<td>
		<select size="1" name="activeskin" class="admindropdown">
<?php
	for ($i=0; $i < count($skins); $i++){
		$selected = ($skins[$i] == $mg2->activeskin)? ' selected="selected"':'';
		echo '<option value="'. $skins[$i] .'"'. $selected .'>'. ucfirst($skins[$i]) .'</option>';
	}
?>
		</select>
	</td>
</tr>
<tr>
   <td width="200">&nbsp;</td>
	<td class="install_td" width="190"><?php echo $mg2->lang['password'],' (default = 1234)';?></td>
	<td>
		<input type="password" name="password" value="1234" size="20" class="admintext" />
	</td>
</tr>
<tr>
	<td align="center" colspan="3">
		<br />
		<input type="hidden" name="step" value="3" />
		<input type="image" src="<?php echo ADMIN_FOLDER;?>images/ok.gif" class="adminpicbutton" alt="Next" title="Next" />
	</td>
</tr>
</table>
</form>
<?php }

if ($_REQUEST['step'] == "3") {?>
<table class="table_menu" cellpadding="0" cellspacing="0">
<tr valign="top">
	<td align="center" colspan="2">
		<p><strong>Welcome to MG2 0.5.1 (kh_mod 0.2.1) installation!</strong></p>
		<p><strong>Step 3 / 3</strong></p>
		<p>Congratulations, you have successfully installed MG2!</p>
		<p>MG2 has been installed using default settings. You can configure these through the admin panel.</p>
		<br />
		<p><a href="admin.php">Go to admin panel</a></p>
	</td>
</tr>
</table>
<?php } ?>
