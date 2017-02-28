<script type="text/javascript">
<?php if(isset($addItems)){?>
tinymce.create('tinymce.plugins.ExamplePlugin', {
    createControl: function(n, cm) {
        switch (n) {
            case 'mylistbox':
            	if(tinyMCE.activeEditor.id=="ArticleContent"){
	                var mlb = cm.createListBox('mylistbox', {
	                     title : 'בחירת אייטמים',
	                     onselect : function(v) {
	                     	tinyMCE.activeEditor.execCommand('mceInsertContent', false, v);
	                     }
	                });
	                // Add some values to the list box
	                <?php foreach($addItems as $key=>$value):?>
	                	mlb.add('<?php echo $value;?>', '%itemElement<?php echo $key;?>%');
	                <?php endforeach;?>
	                mlb.add('מאמר מקושר', '%relatedArticle%');
	                // Return the new listbox instance
	                return mlb;
				}
        }

        return null;
    }
});

// Register plugin with a short name
tinymce.PluginManager.add('itemsList', tinymce.plugins.ExamplePlugin);
<?php }?>

tinyMCE.init({
    mode : "textareas",
    theme : "advanced",
    editor_selector : "tinymceText",
    theme_advanced_buttons1 : "code,<?php if(isset($addItems))echo "mylistbox,";?>styleselect,ltr,rtl,bold,italic,underline,separator,bullist,numlist,undo,redo,link,unlink,pastetext,pasteword,ibrowser,fullscreen,image,media,youtube,table",
    theme_advanced_buttons2 : "",
    theme_advanced_buttons3 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "right",
    theme_advanced_statusbar_location : "bottom",
	plugins : "directionality,paste,ibrowser,fullscreen,media,table,-itemsList,youtube",
	paste_use_dialog : true,
	extended_valid_elements : "style,div[*]",
	directionality : "rtl",
	paste_insert_word_content_callback : "convertWord",
	paste_convert_headers_to_strong : true,
	paste_create_paragraphs : true,
	paste_create_linebreaks : true,
	paste_convert_middot_lists : true,
	style_formats : [
		{title : 'כותרת מאמר', block : 'div',classes:"articleTitle"}
	],
    setup : function(ed) {
        // Add a custom button
        ed.addButton('mybutton', {
            title : 'My button',
            image : 'img/example.gif',
            onclick : function() {
				// Add you own code to execute something on click
				ed.focus();
                ed.selection.setContent('<strong>Hello world!</strong>');
            }
        });
    }
});
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

<?php if(1==2){?>
<script type="text/javascript">
<?php 
$options2 = '
	mode  :"textareas", 
	plugins : "directionality,paste,ibrowser,fullscreen,media,table",
	theme : "advanced",
	editor_selector : "tinymceText",
	theme_advanced_buttons1 : "mybutton,ltr,rtl,bold,italic,underline,separator,bullist,numlist,undo,redo,link,unlink,pastetext,pasteword,ibrowser,fullscreen,image,table",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	directionality : "rtl",
	paste_use_dialog : true,
	paste_insert_word_content_callback : "convertWord",
	paste_convert_headers_to_strong : true,
	paste_create_paragraphs : true,
	paste_create_linebreaks : true,
	paste_convert_middot_lists : true,
	setup : function(ed) {
        // Add a custom button
        ed.addButton("mybutton", {
            title : "My button",
            onclick : function() {
				// Add you own code to execute something on click
				ed.focus();
                ed.selection.setContent("<strong>Hello world!</strong>");
		}
	';
//theme_advanced_buttons1 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,insertdate,inserttime,preview,|,forecolor,backcolor",
?>
tinyMCE.init({<?php echo($options2); ?>});
</script> 
<?php }?>