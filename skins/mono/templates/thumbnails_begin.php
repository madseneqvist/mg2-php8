<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=<?php $mg2->output('charset');?>" />
	<title><?php $mg2->output('pagetitle');?></title>
	<meta name="title" content="<?php $mg2->output('pagetitle');?>" />
	<meta name="robots" content="<?php $mg2->output('robots');?>" />
	<link href="skins/<?php $mg2->output('activeskin');?>/css/style.css" rel="stylesheet" type="text/css" />
</head>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-3510938-2";
urchinTracker();
</script>
<body class="mg2body">
<table cellspacing="0" cellpadding="0" class="table-top" width="100%">
<tr>
	<td class="iconbar"><?php $mg2->gallerynavigation(' : ');?></td>
</tr>
</table>
<table cellspacing="0" cellpadding="0" class="table-headline" width="100%">
<tr>
	<td class="iconbar"><?php $mg2->slideshowicon();?></td>
	<td class="headline"><?php echo $currentfolder;?></td>
</tr>
</table>
<?php
if ($mg2->introtext != '') {
	$attrb = ($mg2->introwidth)? ' style="width:'.$mg2->introwidth.'px"':'';
	echo '
		<div align="center">
			<div class="introtext"'. $attrb .'>'. $mg2->introtext .'</div>
		</div>
	';
}
$mg2->pagenavigation($folderID, $npages, $currentPage);
?>
<table cellspacing="0" cellpadding="0" align="center">
<tr>
