<?php
require_once '../config.php';
require_once 'functions.php';
include 'header.php';

preUpdateCheck();
$error = false;
set_default_timezone('UTC'); //suppress unrelated warnings

echo "<p>Generating a list of posts</p>\n";
$sourceArray = getSourceArray();

echo "<p>Updating post files</p>\n";
updatePosts($sourceArray);

echo "<p>Generating index page</p>\n";
generateSpecial(array_slice($sourceArray, 0, INDEX_ITEMS), 'index');

echo "<p>Generating archive page</p>\n";
generateSpecial($sourceArray, 'archive');

if (RSS == true) {
	echo "<p>Generating RSS file</p>\n";
	generateSpecial(array_slice($sourceArray, 0, RSS_ITEMS), 'rss');
}

punchOut($error);

include 'footer.php';
