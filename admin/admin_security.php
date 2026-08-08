<?php if ($select == 1) { ?>
  <tr>
    <td class="td_div">
	  <br />
      <form name="login" method="post" action="admin.php">
        <p><b><?php echo $pwdheadline;?></b></p>
        <p><?php echo $this->lang['thissection'];?></p>
        <p><input type="password" name="password" class="admintext" /></p>
        <p><input type="image" src="<?=ADMIN_FOLDER?>images/ok.gif" class="adminpicbutton" alt="<?php echo $this->lang['ok'];?>" title="<?php echo $this->lang['ok'];?>" /></p>
        <a href="<?php echo $this->indexfile;?>"><?php $this->lang['viewgallery'];?></a>
      </form>
	  <br /><br />
    </td>
  </tr>
<?php
}
if ($select == 2) {
?>
  <tr>
    <td class="td_div"><h1><?php echo $this->lang['securitylogoff'];?></h1>
      <p><?php echo $this->lang['autologoff'];?></p>
      <a href="admin.php"><?php echo $this->lang['loginagain'];?></a><br /><br />
    </td>
  </tr>
<?php
}
if ($select == 3) {
?>
  <tr>
    <td class="td_div"><h1><?php echo $this->lang['logoff'];?></h1>
      <p><?php echo $this->lang['forsecurity'];?></p>
      <a href="<?php echo $this->indexfile;?>"><?php echo $this->lang['viewgallery'];?></a> | <a href="admin.php"><?php echo $this->lang['loginagain'];?></a><br /><br />
	  <br /><?php $this->check_new_version();?><br /><br />
    </td>
  </tr>
<?php
}
?>