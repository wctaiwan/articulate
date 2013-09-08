<?php

class Post {
	public $source;
	public $link;
	public $time;

	private $date;
	private $title;
	private $body;

	function __construct ($filename) {
		$this->source = SOURCE_DIR . $filename;
		$this->link = OUTPUT_DIR . substr($filename, 0, -4) . '.html';
		$this->time = filemtime('../' . $this->source);
		$this->date = strtotime(substr($filename, 0, 8));
		$this->setTitle();
	}

	private function setTitle () {
		$file = fopen('../' . $this->source, 'r');
		$rawTitle = fgets($file);
		fclose($file);
		$this->title = trim($rawTitle, " \t\n\r\0#");
	}

	public function setBody () {
		if (isset($this->body))
			return;
		$rawContents = file_get_contents('../' . $this->source);
		$start = strpos($rawContents, "\n");
		$rawContents = trim(substr($rawContents, $start), " \t\n\r\0-=");
		$this->body = markdown($rawContents);
	}

	public function process ($template, $type) {
		if ($type == 'output')
			$date = date(OUTPUT_DATE_FORMAT, $this->date);
		else if ($type == 'index')
			$date = date(INDEX_DATE_FORMAT, $this->date);
		else if ($type == 'archive')
			$date = date(ARCHIVE_DATE_FORMAT, $this->date);
		else if ($type == 'rss')
			$date = date(RSS_DATE_FORMAT, $this->date);
		else {
			echo "<p class=\"error\">A fatal error occurred</p>\n";
			include 'footer.php';
			exit;
		}

		$search = array('[title]', '[date]', '[body]', '[link]');
		$replace = array($this->title, $date, $this->body, $this->link);
		return str_replace($search, $replace, $template);
	}
}
