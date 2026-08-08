<?php
// Never expose the installer once the gallery has been configured.
if (is_file(dirname(__FILE__) .'/data/mg2_settings.php')) {
	http_response_code(404);
	exit();
}

// SET HEADERS TO PREVENT BROWSER CACHING OF PAGES
@header('Content-Type: text/html; charset=utf-8');
@header('Expires: Mon, 20 Jul 2000 05:00:00 GMT');
@header('Last-Modified: '. gmdate('D, d M Y H:i:s') .' GMT');
@header('Cache-Control: no-store, no-cache, must-revalidate');
@header('Cache-Control: post-check=0, pre-check=0', false);
@header('Pragma: no-cache');

// DISPLAY ADMIN HEADER
define('DATA_FOLDER',  dirname(__FILE__) .'/data/');
define('ADMIN_FOLDER', 'admin/');

$mg2 = new stdClass();
$mg2->gallerytitle = 'Install to kh_mod 0.2.1';
$mg2->charset = 'utf-8';
$mg2->lang = array();
$mg2->extendedset = 0;
$mg2->activeskin = '';
$_REQUEST += array('step' => '');

include(ADMIN_FOLDER .'admin_header.php');

//
// STEP 1
//
if($_REQUEST['step'] == '') {
	$step = '1';

	$failure = '<span class="install_failure">Failure</span>';
	$success = '<span class="install_success">Success</span>';
	$todo = '';

	// TEST 1
	@rmdir(DATA_FOLDER .'x');
	if (@mkdir(DATA_FOLDER .'x')) {
		$test1 = $success .'<br />';
		@rmdir(DATA_FOLDER .'x');
	} else {
		$test1 = $failure;
		$todo.= '- Grant the script write access to the gallery folder \''. DATA_FOLDER .'\' (CHMOD 777) - <a href="http://www.google.com/search?hl=en&q=chmod+tutorial&meta=" target="_blank">help!</a><br />';
	}

	// TEST 2
	@rmdir('pictures/x');
	if (@mkdir('pictures/x')) {
		$test2 = $success;
		@rmdir('pictures/x');
	} else {
		$test2 = $failure;
		$todo.= '- Create folder called \'pictures\' in gallery root using FTP and chmod to 777<br />';
	}	

	// TEST 3
	$test3 = $success;
	$main_file1 = 'index.php';
	$main_file2 = 'admin.php';
	$main_file3 = 'lang/*.php';
	$main_file4 = 'includes/mg2_version.php';
	$main_file5 = 'includes/mg2_showimages.php';
	$main_file6 = 'includes/mg2_showthumbs.php';
	$main_file7 = 'includes/mg2_slideshow.php';
	$main_file8 = 'includes/mg2admin_tableview.php';
	if (!is_readable($main_file1)) $test3 = $failure;
	if (!is_readable($main_file2)) $test3 = $failure;
	if (!glob($main_file3))        $test3 = $failure;
	if (!is_readable($main_file4)) $test3 = $failure;
	if (!is_readable($main_file5)) $test3 = $failure;
	if (!is_readable($main_file6)) $test3 = $failure;
	if (!is_readable($main_file7)) $test3 = $failure;
	if (!is_readable($main_file8)) $test3 = $failure;

	// TEST 4
	$test4 = $success;
	$class_file1 = 'includes/mg2_functions.php';
	$class_file2 = 'includes/mg2admin_functions.php';
	if (!is_readable($class_file1)) $test4 = $failure;
	if (!is_readable($class_file2)) $test4 = $failure;

	if ($test3 != $success) {
		$todo.= '- Upload all gallery files<br />';
	}
	elseif ($test4 != $success) {
		$todo.= '- Upload files \''.$class_file1.'\' and  \''.$class_file2.'\'<br />';
	}

	// TEST 5
	$test5 = '<span class="install_failure">?</span>';
	if ($test4 == $success) {
		include_once($class_file1);
		$mg2 = new mg2db;
		// NEEDED GD VERSION 2.0.1
		if ($mg2->gd_version() < 2) {
			$test5 = $failure ." ($mg2->gd_version_number)";
			$todo.= '- Install GD image library version 2.0.1 or newer ';
			$todo.= '(<a href="http://www.boutell.com/gd/" target="_blank">';
			$todo.= 'http://www.boutell.com/gd/</a>)<br />';
		}
		else {
			$test5 = $success ." ($mg2->gd_version_number)";
		}
	}

	// TEST 6
	$phpvers	= phpversion();
	$order	= '- Install PHP version 8.0 or newer ';
	$order  .= '(<a href="http://www.php.net/downloads.php" target="_blank">';
	$order  .= 'http://www.php.net/</a>)<br />';
	if (!function_exists('version_compare')) {
		$test6 = $failure ." ($phpvers)";
		$todo	.= $order;
	}
	elseif (version_compare($phpvers,'8.0.0','<')) {
		$test6 = $failure ." ($phpvers)";
		$todo	.= $order;
	}
	else $test6 = $success ." ($phpvers)";

	include(ADMIN_FOLDER .'install.inc.php');
}

//
// STEP 2
//
if($_REQUEST['step'] == '2') {
	include_once('includes/mg2_functions.php');
	$mg2 = new mg2db;

	// LANGUAGE
	$lang_arr = array();
	$def_lang = 'english.php';
	$workdir  = opendir('lang');
	$regexp   = '/^[a-z_-]{2,30}\.php$/i';
	while (false !== ($pointer = readdir($workdir))) {
		if (@preg_match($regexp,$pointer)) $lang_arr[] = $pointer;
	}
	if (!empty($lang_arr)) {
		sort($lang_arr);
		if (!in_array($def_lang,$lang_arr))	$def_lang = $lang_arr[0];
	}
	if (!is_file('lang/'.$def_lang)) {
		$mg2->lang['gallerytitle']	= 'Gallery title';
		$mg2->lang['adminemail']	= 'Admin email';
		$mg2->lang['language']		= 'Language';
		$mg2->lang['skin']			= 'Skin';
		$mg2->lang['password']		= 'Password';
	}
	else include('lang/'.$def_lang);

	// SKIN
	$skins	= array();
	$workdir	= opendir('skins');
	while (false !== ($pointer = readdir($workdir))) {
		if (substr($pointer,0,1) !== '.' && $pointer !== 'admin') {
			$skins[] = $pointer;
		}
	}
	sort($skins);

	include(ADMIN_FOLDER .'install.inc.php');
}

//
// STEP 3
//
if($_REQUEST['step'] == '3') {
	include_once('includes/mg2_functions.php');
	$mg2 = new mg2db;

	$_POST['gallerytitle'] = $mg2->charfix($_POST['gallerytitle']);
	$_POST['password']	  = trim($_POST['password']);
	$bufferpwd = md5(strrev(md5($_POST["password"])));

	$filebuffer = "<?php\n";
	$filebuffer.= '$mg2->gallerytitle = '.chr(34).$_POST["gallerytitle"].chr(34).";\n";
	$filebuffer.= '$mg2->adminemail = '.chr(34).$_POST["adminemail"].chr(34).";\n";
	$filebuffer.= '$mg2->defaultlang = '.chr(34).$_POST["defaultlang"].chr(34).";\n";
	$filebuffer.= '$mg2->activeskin = '.chr(34).$_POST["activeskin"].chr(34).";\n";		// kh_mod 0.1.0, changed
	$filebuffer.= '$mg2->dateformat = '.chr(34)."%d.%m.%Y".chr(34).";\n";					// kh_mod 0.3.0, changed
	$filebuffer.= '$mg2->navtype = '.chr(34)."1".chr(34).";\n";									// kh_mod 0.3.0, changed
	$filebuffer.= '$mg2->showexif = 510'.";\n";														// kh_mod 0.2.0, changed
	$filebuffer.= '$mg2->marknew = '.chr(34)."7".chr(34).";\n";
	$filebuffer.= '$mg2->copyright = '.chr(34)."Copyright &#169; 2006".chr(34).";\n";
	$filebuffer.= '$mg2->password = '.chr(34).$bufferpwd.chr(34).";\n";
	$filebuffer.= '$mg2->extensions = '.chr(34)."jpeg,jpg,gif,png".chr(34).";\n";
	$filebuffer.= '$mg2->mediumimage = '.chr(34)."924".chr(34).";\n";							// kh_mod 0.1.0, changed
	$filebuffer.= '$mg2->introwidth = '.chr(34)."0".chr(34).";\n";								// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->indexfile = '.chr(34)."index.php".chr(34).";\n";
	$filebuffer.= '$mg2->imagefolder = '.chr(34)."pictures".chr(34).";\n";					// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->folderseting = 0'.";\n";													// kh_mod 0.2.0, add
	$filebuffer.= '$mg2->thumbquality = '.chr(34)."85".chr(34).";\n";
	$filebuffer.= '$mg2->thumbwidth = '.chr(34)."150".chr(34).";\n";							// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->thumbheight = '.chr(34)."150".chr(34).";\n";							// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->commentsets = '.chr(34)."7".chr(34).";\n";							// kh_mod 0.1.0, changed
	$filebuffer.= '$mg2->metaseting = 17'.";\n";														// kh_mod 0.2.0, add
	$filebuffer.= '$mg2->imagecolumns = '.chr(34)."4".chr(34).";\n";
	$filebuffer.= '$mg2->imagerows = '.chr(34)."6".chr(34).";\n";
	$filebuffer.= '$mg2->slideshowdelay = '.chr(34). "10" .chr(34).";\n";
	$filebuffer.= '$mg2->websitelink = '.chr(34).chr(34).";\n";
	$filebuffer.= '$mg2->websitetext = '.chr(34)."Home".chr(34).";\n";						// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->accesstime = '.chr(34)."15".chr(34).";\n";							// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->extendedset = '.chr(34)."28".chr(34).";\n";							// kh_mod 0.1.0, add
	$filebuffer.= '$mg2->installdate = '.chr(34). time() .chr(34).";\n";
	$filebuffer.= '?>';
	$fd = fopen(DATA_FOLDER .'mg2_settings.php','w');
	fwrite($fd,$filebuffer);
	fclose($fd);

	include(ADMIN_FOLDER .'install.inc.php');
}
include(ADMIN_FOLDER .'admin_footer.php');
exit();
?>
