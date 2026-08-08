<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="refresh" content="<?php $mg2->output('slideshowdelay');?>; url=<?php echo $nexturl;?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php $mg2->output('charset');?>" />
	<title><?php $mg2->output('pagetitle');?></title>
	<meta name="title" content="<?php $mg2->output('pagetitle');?>" />
	<meta name="robots" content="<?php $mg2->output('robots');?>" />
	<meta http-equiv="expires" content="0" />
	<link href="skins/<?php $mg2->output('activeskin');?>/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body class="mg2body">
<table cellspacing="0" cellpadding="0" class="table-top" width="100%">
<tr>
  <td class="navigation"><a href="<?php $mg2->output('link');?>"><?php echo $mg2->lang['stopslideshow'];?></a></td>
  <td class="table-headline"><?php $mg2->output('title');?></td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td class="dir_topleft"></td>
    <td class="dir_top" width="<?php $mg2->output('width');?>"></td>
    <td class="dir_topright">
      <?php if($mg2->fullsizelink != '') { ?>
      <a href="<?php echo $image_file;?>" target="_blank"><img src="skins/<?php echo $mg2->activeskin;?>/images/dir_topright_resized.gif" border="0" width="26" height="26" alt="<?php echo $mg2->lang['fullsize'];?>" title="<?php echo $mg2->lang['fullsize'];?>" /></a><?php } ?></td>
  </tr>
  <tr>
    <td class="dir_left"></td>
    <td><a href="<?php echo $nexturl;?>" target="<?php $mg2->output('target');?>" title="<?php $mg2->output('tooltip');?>"><img src="<?php $mg2->output('imagefile');?>" border="0" width="<?php $mg2->output('width');?>" height="<?php $mg2->output('height');?>" alt="" /></a></td>
    <td class="dir_right"></td>
  </tr>
  <tr>
    <td class="dir_bottomleft"></td>
    <td class="dir_bottom" width="<?php $mg2->output('width');?>"></td>
    <td class="dir_bottomright"></td>
  </tr>
</table>
<div class="description"><?php $mg2->output('description');?></div><br />
<div class="copyright"><?php $mg2->output('copyright');?></div>
<img style="display:none" src="<?php $mg2->output('nextimage');?>" alt="" />
<br />
<br />
</body>
</html>