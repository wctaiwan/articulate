<?php
require_once 'Post.php';
require_once 'MessagePrinter.php';
require_once '../config.php';

function update ($rebuild) {
	$templates = null;
	$sourceArray = null;
	$lastUpdate = 0;
	$fatalError = false;
	$updateWarning = false;

	//check update conditions, abort update if not met
	if (!checkOutputFiles())
		$fatalError = true;
	if (!getTemplates($templates))
		$fatalError = true;
	if ($fatalError) {
		MessagePrinter::updateFailed();
		return;
	}

	//purge output directory if rebuilding, otherwise set last update time
	if ($rebuild) {
		if (!purgeOutputDir())
			$updateWarning = true;
	} else {
		$lastUpdate = file_get_contents('../lastupdate.txt');
	}

	//get array of posts
	if  (!getSourceArray($sourceArray))
		$updateWarning = true;

	//generate output
	if (!generatePosts($sourceArray, $templates, $lastUpdate))
		$updateWarning = true;
	if (!generateIndex($sourceArray, $templates))
		$updateWarning = true;
	if (!generateArchive($sourceArray, $templates))
		$updateWarning = true;
	if (RSS && !generateRss($sourceArray, $templates))
		$updateWarning = true;

	if ($updateWarning) {
		MessagePrinter::updateWarning();
	} else
		recordUpdate();
		MessagePrinter::updateComplete();
	}
}

function checkOutputFiles () {
	$error = false;

	if (!checkDir(OUTPUT_DIR))
		$error = true;
	if (!checkFile('lastupdate.txt'))
		$error = true;
	if (!checkFile(INDEX_FILE))
		$error = true;
	if (!checkFile(ARCHIVE_FILE))
		$error = true;
	if (RSS && !checkFile(RSS_FILE))
		$error = true;

	if ($error)
		MessagePrinter::fileError();

	return !$error;
}

function checkDir ($dir) {
	if (file_exists('../'.$dir)) {
		if (!is_writable('../'.$dir)) {
			MessagePrinter::dirNotWritable($dir);
			return false;
		} else {
			return true;
		}
	} else {
		if (@!mkdir('../'.$dir, 0755)) {
			MessagePrinter::dirCreateError($dir);
			return false;
		} else {
			file_put_contents('../'.$dir.'/index.html', '');
			chmod('../'.$dir.'/index.html', 0644);
			return true;
		}
	}
}

function checkFile ($filename) {
	if (file_exists('../'.$filename)) {
		if (!is_writable('../'.$filename)) {
			MessagePrinter::fileNotWritable($filename);
			return false;
		} else {
			return true;
		}
	} else {
		if (@file_put_contents('../'.$filename, '') === false || @!chmod('../'.$filename, 0644)) {
			MessagePrinter::fileCreateError($filename);
			return false;
		} else {
			return true;
		}
	}
}

function getTemplates ($templates) {
	$error = false;

	$tplNames = array('index', 'archive', 'post');
	if (RSS)
		$tplNames[] = 'rss';

	for ($tplNames as $tplName) {
	}
}

function purgeOutputDir () {
}

function getSourceArray ($sourceArray) {
}

function generatePosts ($sourceArray, $templates, $lastUpdate) {
}

function generateIndex ($sourceArray, $templates) {
}

function generateArchive ($sourceArray, $templates) {
}

function generateRss ($sourceArray, $templates) {
}

function recordUpdate () {
}
