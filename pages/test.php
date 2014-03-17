<?php
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
$new_page->printPage();
?>