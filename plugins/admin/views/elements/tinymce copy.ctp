<script type="text/javascript">
<?php 
$options2 = '
	mode  :"textareas", 
	plugins : "directionality,paste,ibrowser,fullscreen,media",
	theme : "advanced",
	editor_selector : "tinymceText",
	theme_advanced_buttons1 : "ltr,rtl,bold,italic,underline,separator,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink,pastetext,pasteword,selectall",
	theme_advanced_buttons1_add : "ibrowser",
	theme_advanced_buttons3 : "",
	theme_advanced_buttons2_add : "media,fontselect,fontsizeselect,forecolor,fullscreen",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	directionality : "rtl",
	paste_use_dialog : true,
	paste_insert_word_content_callback : "convertWord",
	paste_convert_headers_to_strong : true,
	paste_create_paragraphs : true,
	paste_create_linebreaks : true,
	paste_convert_middot_lists : true';
//theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,insertdate,inserttime,preview,|,forecolor,backcolor",
?>
tinyMCE.init({<?php echo($options2); ?>});

function convertWord(type, content) {
	switch (type) {
		// Gets executed before the built in logic performes it's cleanups
		case "before":
			//content = content.toLowerCase(); // Some dummy logic
			break;

		// Gets executed after the built in logic performes it's cleanups
		case "after":
			//content = content.toLowerCase(); // Some dummy logic
			break;
	}

	return content;
}
</script> 