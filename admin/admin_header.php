<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo $mg2->charset;?>" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="cache-control" content="no-cache" />
<title>ADMIN: <?php echo $mg2->gallerytitle;?></title>
<meta name="title" content="<?php echo $mg2->gallerytitle;?>" />
<meta name="robots" content="noindex,nofollow" />
<meta name="googlebot" content="noarchive,nofollow" />
<link href="<?=ADMIN_FOLDER?>admin.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript">
<!--
function checkAll(num,type) {
	var item = 'document.';
	switch (type) {
		case 'ctrl': item += 'fileform.selectfile';  break;
		case 'comm': item += 'commentform.comment';	break;
		case 'upld': item += 'uploadform.overwrite'; break;
		default: return;
	}
	for (var i = 0; i < num; i++) {
		var box = eval(item + i);
		if (box.checked == false) box.checked = true;
	}
}
function uncheckAll(num,type) {
	var item = 'document.';
	switch (type) {
		case 'ctrl': item += 'fileform.selectfile';  break;
		case 'comm': item += 'commentform.comment';	break;
		case 'upld': item += 'uploadform.overwrite'; break;
		default: return;
	}
	for (var i = 0; i < num; i++) {
		var box = eval(item + i);
		if (box.checked == true) box.checked = false;
	}
}
function confirmSubmit(num,type) {
	var item = (type == 'comm')? "commentform['comment":"fileform['selectfile";
	for (i=0;i<num;i++) {
		if (eval("document." + item + i +"'].checked")) {
			if (type=='file')
				return confirm("<?php echo $mg2->lang['deleteconfirm']; ?>");
			else if (type=='move')
				return confirm("<?php echo $mg2->lang['moveconfirm']; ?>");
			else if (type=='comm')
				return confirm("<?php echo $mg2->lang['commentconfirm']; ?>");
		}
	}
	var message = (type == 'comm')?
		"<?php echo $mg2->lang['commentnotselected']; ?>":
		"<?php echo $mg2->lang['filenotselected']; ?>";

	alert(message);
	return false;
}
-->
</script>
<?php
// if order dialog: 'edit image', 'editfolder', 'newfolder', 'rotate', updateID or updatefolder, include HTMLArea (WYSIWYG)
if ($_REQUEST['editID'] || $_REQUEST['editfolder'] || $_REQUEST['newfolder'] || $_REQUEST['rotate'] || $_REQUEST['action']=='updateID' || $_REQUEST['action']=='updatefolder') {

	// INITIALIZE HTMLArea 
	$htmlarea_path = ADMIN_FOLDER .'wysiwyg/htmlarea.inc.php';
	if (($mg2->extendedset & 4) && is_readable($htmlarea_path)) {
		include($htmlarea_path);
	}

	// INITIALIZE DYNARCH CALENDAR
	$calendar_path = ADMIN_FOLDER .'calendar/calendar.inc.php';
	if (($mg2->extendedset & 16) && is_readable($calendar_path)) {
		include($calendar_path);
		$Calendar = new MG2calendar(ADMIN_FOLDER .'calendar/',	// CALENDAR PATH
											 $mg2->activelang,					// CALENDAR LANGUAGE
											 'calendar_mg2',						// CALENDAR THEME
											 $mg2->lang['calendar']);			// CALENDER TITLE

		// LOAD JAVASCRIPT AND THEME FILES
		$Calendar->load_files();
	}
}
?>
</head>

<body>
<div class="logo">
<a href="admin.php"><img src="<?=ADMIN_FOLDER?>images/logo.gif" width="210" height="70" class="logo" border="0" alt="" /></a>
</div>
