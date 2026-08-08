<!-- Include HTMLArea (Editor) in MG2, file 'admin_header.php' -->

<script type="text/javascript">
	window.onload = function () {HTMLArea.replace('editor',config);}
   _editor_url   = "<?php echo ADMIN_FOLDER;?>wysiwyg/";
   _editor_lang  = "en";
</script>

<script type="text/javascript" src="<?php echo ADMIN_FOLDER;?>wysiwyg/htmlarea.js?v=20260808"></script>
<script type="text/javascript" defer="defer">
<!--
var config = new HTMLArea.Config();

//config.width = '400';
config.height = '200px';

// the following sets a style for the page body (black text on yellow page)
// and makes all paragraphs be bold by default
// config.pageStyle =
// 'body { background-color: yellow; color: black; font-family: verdana,sans-serif } ' +
// 'p { font-width: bold; } ';


config.toolbar = [
[ //"fontname", "space",
  "fontsize", "space", "formatblock", "space", "textindicator"],

[ "bold", "italic", "underline", "strikethrough", "separator",
  "subscript", "superscript", "separator",
  "forecolor", "hilitecolor"],
  
[ "justifyleft", "justifycenter", "justifyright", "justifyfull", "separator",
  "insertorderedlist", "insertunorderedlist", "outdent", "indent"],
  
[ "inserthorizontalrule", "createlink", "inserttable", "separator", "htmlmode", "separator",
  //"popupeditor", "separator",  
  "space", "space", "showhelp", "about" ]
];
-->
</script>
