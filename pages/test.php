<?php

if (!empty($_POST))
{
    echo $_POST['content'];
}
/*
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/Page.class.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/admin/include/Content.class.php");

$content = new Content("This is a content header!", "Lorem ipsum blah blah", false);
$content1 = new Content("This is a second content header!", "Lorem ipsum longer than the previous\nWith an extra paragraph to show off!", false);
$content2 = new Content("Below is custom content", "<div id=\"left-column\">
                        <h3>Future Goals</h3>
                        <ul>
                            <li><a target=\"_blank\" href=\"docs/pressrelease.pdf\">Press Release</a></li>
                            <li><a target=\"_blank\" href=\"docs/RCDC.png\">Future Building</a></li>
                        </ul> 
                    </div>", true);

$page = new Page("This is my test page!", array($content, $content1, $content2));

// $page->printPage();

$new_page = Page::buildPage('home', $db);
$new_page->printPage();*/

?>
<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: 'textarea',
        theme: 'modern',
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table contextmenu paste moxiemanager'],
        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
    });
</script> 
<form method="POST" action="/test">
    <textarea name="content"></textarea>
    <input type="submit" value="Submit" />
</form>
