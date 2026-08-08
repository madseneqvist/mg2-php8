<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php $mg2->output('charset');?>" />
	<title><?php $mg2->output('pagetitle');?></title>
	<meta name="title" content="<?php $mg2->output('pagetitle');?>" />
	<meta name="robots" content="<?php $mg2->output('robots');?>" />
	<link href="skins/<?php $mg2->output('activeskin');?>/css/style.css" rel="stylesheet" type="text/css" />
	<?php	$mg2->jsformvalid(); // necessary for onsubmit="return validateCompleteForm(this,'error') in 'viewimage_comments.php'?>
	<?php $mg2->ga4tag();?>
</head>
<body class="mg2body">
<div align="center" style="font-weight:bold"><?php $mg2->output('status');?></div>
<table cellspacing="0" cellpadding="0" class="table-top" width="100%">
<tr>
	<td class="iconbar"><?php $mg2->gallerynavigation(' : ');?></td>
</tr>
</table>
<table cellspacing="0" cellpadding="0" class="table-headline" width="100%">
<tr>
	<td class="iconbar"><?php $mg2->slideshowicon();?></td>
	<td class="headline"><?php $mg2->output('title');?></td>
</tr>
</table>
<table class="minithumb" cellspacing="0" cellpadding="0" border="0" align="center">
<tr>
	<td>&nbsp;<?php $mg2->output('nav_first');?>&nbsp;</td>
	<td>&nbsp;<?php $mg2->output('nav_prev');?>&nbsp;</td>
	<td>&nbsp;<?php $mg2->output('nav_this');?>&nbsp;</td>
	<td>&nbsp;<?php $mg2->output('nav_next');?>&nbsp;</td>
	<td>&nbsp;<?php $mg2->output('nav_last');?>&nbsp;</td>
</tr>
</table>
<br />


<div align="center"><?php echo $mg2->fullsizelink;?></div>
<table cellpadding="0" cellspacing="0" align="center" width="<?php echo ($mg2->width+2);?>">
<tr>
	<td class="viewimage" align="center">
		<a href="index.php?iID=<?php echo $mg2->nav_next_id;?>&page=1" target="<?php $mg2->output('target');?>" title="<?php echo $title;?>"><img src="<?php $mg2->output('imagefile');?>" border="0" width="<?php $mg2->output('width');?>" height="<?php $mg2->output('height');?>" alt="" /></a></td>
</tr>
</table>
<div align="center">
	<div class="description" style="width:<?php echo ($mg2->width+2);?>px"><?php $mg2->output('description');?></div>
</div>
<br />
<div class="copyright"><?php $mg2->output('copyright');?></div>
