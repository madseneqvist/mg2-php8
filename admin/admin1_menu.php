<table class="table_menu" cellpadding="0" cellspacing="0">
<tr valign="middle" align="right">
  <td><img src="<?=ADMIN_FOLDER?>images/1x1.gif" width="170" height="1" alt="" border="0" /></td>
  <td class="td_menutext">
    <a href="admin.php?startupload=<?php echo $list.'&amp;page='.$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/menu_upload.gif" width="65" height="55" alt="<?php echo $mg2->lang['upload'] ?>" title="<?php echo $mg2->lang['upload'] ?>" border="0" /></a>
    <br /><?php echo $mg2->lang['menutxt_upload'] ?>
  </td>
  <td class="td_menutext">
    <a href="admin.php?action=startimport&amp;fID=<?php echo $list.'&amp;page='.$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/menu_importnew.gif" width="65" height="55" alt="<?php echo $mg2->lang['import'] ?> '<?php echo $mg2->getfoldername($list) ?>'" title="<?php echo $mg2->lang['import'] ?> '<?php echo $mg2->getfoldername($list) ?>'" border="0" /></a>
    <br /><?php echo $mg2->lang['menutxt_import'] ?>
  </td>
  <td class="td_menutext">
    <a href="admin.php?newfolder=<?php echo $list.'&amp;page='.$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/menu_newfolder.gif" width="65" height="55" alt="<?php echo $mg2->lang['newfolder'] ?>" title="<?php echo $mg2->lang['newfolder'] ?>" border="0" /></a>
    <br /><?php echo $mg2->lang['menutxt_newfolder'] ?>
  </td>
  <td class="td_menutext">
    <a href="<?php echo $mg2->indexfile ?>" target="_blank"><img src="<?=ADMIN_FOLDER?>images/menu_viewgallery.gif" width="65" height="55" alt="<?php echo $mg2->lang['viewgallery'] ?>" title="<?php echo $mg2->lang['viewgallery'] ?>" border="0" /></a>
    <br /><?php echo $mg2->lang['menutxt_viewgallery'] ?>
  </td>
  <td class="td_menutext">
    <a href="admin.php?action=setup<?php echo '&amp;fID='.$list.'&amp;page='.$_REQUEST['page'];?>"><img src="<?=ADMIN_FOLDER?>images/menu_setup.gif" width="65" height="55" alt="<?php echo $mg2->lang['setup'] ?>" title="<?php echo $mg2->lang['setup'] ?>" border="0" /></a>
    <br /><?php echo $mg2->lang['menutxt_setup'] ?>
  </td>
  <td class="td_menutext">
    <a href="admin.php?action=logoff"><img src="<?=ADMIN_FOLDER?>images/menu_logoff.gif" width="65" height="55" alt="<?php echo $mg2->lang['logoff'] ?>" title="<?php echo $mg2->lang['logoff'] ?>" border="0" /></a>
    <br /><?php echo $mg2->lang['menutxt_logoff'] ?>
  </td>
</tr>
<tr valign="middle">
  <td colspan="7" align="right" valign="bottom" height="25"><?php echo $mg2->gallerytitle . ": " . $total_images;?>, <?php echo $total_size ?>, <?php echo $total_folders ?> |
 <a href="http://faq.minigal.dk" target="_blank"><?php echo $mg2->lang['help'];?></a></td>
</tr>
</table>
