<?php
require_once 'UpdateUtils.php';
require_once 'Post.php';
require_once 'MessagePrinter.php';
require_once '../config.php';

class Updater {

	private $rebuild;
	private $fatalError = false;
	private $updateWarning = false;
	private $templates = null;
	private $sourceArray;

	public function __construct ($rebuild) {
		$this->rebuild = $rebuild;
	}

	public function update () {
		checkOutputFiles();
		$templates = getTemplates();

		if ($fatalError)
			MessagePrinter::updateFailed();
		else
			performUpdate();
	}

	private function performUpdate () {
		if ($rebuild) {
			if (!UpdaterUtils::emptyDir(OUTPUT_DIR))
				$updateWarning = true;
			$lastUpdate = 0;
		} else {
			$lastUpdate = file_get_contents('../lastupdate.txt');
		}

		getSourceArray();
		generatePosts($lastUpdate);
		generateIndex();
		generateArchive();
		if (RSS)
			generateRss();

		if ($updateWarning) {
			MessagePrinter::updateWarning();
		} else
			recordUpdate();
			MessagePrinter::updateComplete();
		}
	}

	private function checkOutputFiles () {
		$error = false;
		if (!UpdaterUtils::checkAndCreateDir(OUTPUT_DIR))
			$error = true;
		if (!UpdaterUtils::checkAndCreateFile('lastupdate.txt'))
			$error = true;
		if (!UpdaterUtils::checkAndCreateFile(INDEX_FILE))
			$error = true;
		if (!UpdaterUtils::checkAndCreateFile(ARCHIVE_FILE))
			$error = true;
		if (RSS && !UpdaterUtils::checkAndCreateFile(RSS_FILE))
			$error = true;

		if ($error) {
			MessagePrinter::fileError();
			$fatalError = true;
		}
	}

	private function getSourceArray () {
	}

	private function generatePosts ($lastUpdate) {
	}

	private function generateIndex () {
	}

	private function generateArchive () {
	}

	private function generateRss () {
	}

	private function recordUpdate () {
	}
}
