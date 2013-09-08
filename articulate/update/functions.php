<?php

require_once 'markdown.php';
require_once 'postclass.php';

function preUpdateCheck () {
	echo "<p>Checking whether Articulate has access to essential files</p>\n";

	if (!file_exists('../templates/post.tpl')) {
		echo "<p class=\"error\"><code>templates/post.tpl</code> can not be found</p>\n";
		$error = true;
	}
	if (!file_exists('../templates/index.tpl')) {
		echo "<p class=\"error\"><code>templates/index.tpl</code> can not be found</p>\n";
		$error = true;
	}
	if (!file_exists('../templates/archive.tpl')) {
		echo "<p class=\"error\"><code>templates/archive.tpl</code> can not be found</p>\n";
		$error = true;
	}
	if (RSS == true && !file_exists('../templates/rss.tpl')) {
		echo "<p class=\"error\"><code>templates/rss.tpl</code> can not be found</p>\n";
		$error = true;
	}

	if (!is_writable('../' . OUTPUT_DIR)) {
		echo "<p class=\"error\">No write permission on <code>" . OUTPUT_DIR . "</code></p>\n";
		$error = true;
	}
	if (!is_writable('../' . INDEX_FILE)) {
		echo "<p class=\"error\">No write permission on <code>" . INDEX_FILE . "</code></p>\n";
		$error = true;
	}
	if (!is_writable('../' . ARCHIVE_FILE)) {
		echo "<p class=\"error\">No write permission on <code>" . ARCHIVE_FILE . "</code></p>\n";
		$error = true;
	}
	if (!is_writable('lastupdate.txt')) {
		echo "<p class=\"error\">No write permission on <code>update/lastupdate.txt</code></p>\n";
		$error = true;
	}
	if (RSS == true && !is_writable('../' . RSS_FILE)) {
		echo "<p class=\"error\">No write permission on <code>" . RSS_FILE . "</code></p>\n";
		$error = true;
	}

	if (isset($error)) {
		echo "<p>Some problems were detected. Please resolve them and run the update script again.</p>";
		include 'footer.php';
		exit;
	}
}

function getSourceArray () {
	global $error;

	$dir = opendir('../' . SOURCE_DIR);
	while (($filename = readdir($dir)) !== false) {
		if (preg_match('/^[0-9][0-9]-[01][0-9]-[0-3][0-9]-.+\.txt$/', $filename) == 1)
			if (is_readable('../' . SOURCE_DIR . $filename)) {
				$fileArray[] = $filename;
			} else {
				$error = true;
				echo "<p class=\"error\">Could not open <code>" . SOURCE_DIR . $filename . "</code></p>\n";
			}
	}
	closedir($dir);
	rsort($fileArray);

	foreach ($fileArray as $filename)
		$sourceArray[] = new Post($filename);

	if (RSS == true)
		$max = min(max(INDEX_ITEMS, RSS_ITEMS), count($sourceArray));
	else
		$max = min(INDEX_ITEMS, count($sourceArray));
	for ($i = 0; $i < $max; $i++)
		$sourceArray[$i]->setBody();

	return $sourceArray;
}

function emptyOutput () {
	global $error;
	echo "<p>Removing previously generated files</p>\n";
	$dir = opendir('../' . OUTPUT_DIR);
	while (($filename = readdir($dir)) !== false) {
		if (preg_match('/^[0-9][0-9]-[01][0-9]-[0-3][0-9]-.+\.html$/', $filename) == 1) {
			if (@unlink('../' . OUTPUT_DIR . $filename) == true) {
				echo "<p><code>" . OUTPUT_DIR . $filename . "</code> removed</p>\n";
			} else {
				$error = true;
				echo "<p class=\"error\">Could not remove <code>" . OUTPUT_DIR . $filename . "</code></p>\n";
			}
		}
	}
	closedir($dir);
}

function updatePosts ($sourceArray) {
	global $error;

	if (isset($_GET['r'])) {
		emptyOutput();
		$lastupdate = 0;
	} else {
		$lastupdate = file_get_contents('lastupdate.txt');
	}

	ob_start();
	include '../templates/post.tpl';
	$template = ob_get_contents();
	ob_end_clean();

	$search = array('[site_name]', '[index]', '[archive]', '[templates]', '[rss]');
	$replace = array(SITE_NAME, '../' . INDEX_FILE, '../' . ARCHIVE_FILE, '../templates', '../' . RSS_FILE);
	$template = str_replace($search, $replace, $template);

	foreach ($sourceArray as $post) {
		if ($lastupdate == 0 || $post->time > $lastupdate) {
			echo "<p>Processing <code>" . $post->source . "</code></p>\n";
			$post->setBody();
			$html = $post->process($template, 'output');

			$file = @fopen('../' . $post->link, 'w');
			if ($file == false) {
				$error = true;
				echo "<p class=\"error\">Could not write to <code>" . $post->link . "</code></p>\n";
			} else {
				fwrite($file, $html);
				chmod('../' . $post->link, 0644);
				fclose($file);
			}
		}
	}
}

function generateSpecial ($sourceArray, $kind) {
	if ($kind == 'archive')
		$output = '../' . ARCHIVE_FILE;
	else if ($kind == 'index')
		$output = '../' . INDEX_FILE;
	else if ($kind == 'rss')
		$output = '../' . RSS_FILE;
	else {
		echo "<p class=\"error\">A fatal error occurred</p>\n";
		include 'footer.php';
		exit;
	}

	ob_start();
	include "../templates/$kind.tpl";
	$template = ob_get_contents();
	ob_end_clean();

	if (preg_match('/(.*)(\[post\])(.*)(\[\/post\])(.*)/s', $template) == 0) {
		echo "<p class=\"error\"><code>templates/$kind.tpl</code> is malformed. Please correct it and run this script again.</p>\n";
		include 'footer.php';
		exit;
	}

	$search = array('[site_name]', '[index]', '[archive]', '[templates]', '[rss]', '[rss_link]', '[rss_description]', '[/post]');
	$replace = array(SITE_NAME, INDEX_FILE, ARCHIVE_FILE, 'templates', RSS_FILE, RSS_LINK, RSS_DESCRIPTION, '[post]');
	$template = str_replace($search, $replace, $template);
	$parts = explode('[post]', $template);

	foreach ($sourceArray as $post)
		$posts[] = $post->process($parts[1], $kind);
	$content = implode('', $posts);

	$file = fopen($output, 'w');
	fwrite($file, $parts[0] . $content . $parts[2]);
	fclose($file);
}

function punchOut ($error) {
	if ($error == false) {
		$file = fopen('lastupdate.txt', 'w');
		fwrite($file, time());
		fclose($file);
		echo "<p>Update successfully completed</p>\n";
		echo "<p><a href=\"../" . INDEX_FILE . "\">Go to your website &raquo;</a></p>\n";
	} else {
		echo "<p>Update completed. However, some files could not be updated. Please manually remove them and run this script again.</p>\n";
	}
}
