<?php
require_once 'Post.php';
require_once 'MessagePrinter.php';

require_once '../config.php';

class Updater {

	private $rebuild;
	private $fatalError = false;
	private $updateIssues = false;
	private $templates = null;
	private $lastUpdate = 0;
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
			emptyOutputDir();
			$lastUpdate = 0;
		} else {
			$lastUpdate = file_get_contents('../lastupdate.txt');
		}

		getSourceArray()
		generatePosts();
		generateIndex();
		generateArchive();
		if (RSS)
			generateRss();

		if ($updateIssues)
			MessagePrinter::updateIssues();
		else
			MessagePrinter::updateComplete();
	}

	private function checkOutputFiles () {
	}

	private function emptyOutputDir () {
	}

	private function getSourceArray () {
	}

	private function generatePosts () {
	}

	private function generateIndex () {
	}

	private function generateArchive () {
	}

	private function generateRss () {
	}
}
