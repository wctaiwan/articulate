<?php

/* Back up this file before editing it.

   If you modify the name of a directory or a file, you should manually change
   the file name in FTP to match before you run the update script again.
   See http://php.net/manual/en/function.date.php for help on date formats.
   All changes take effect when you next run the update script. */

//Name of your site
define('SITE_NAME', 'My Blog');

//Directory in which you place your text files
define('SOURCE_DIR', '_posts/');

//Directory in which generated HTML files are stored
define('OUTPUT_DIR', 'posts/');

//File name of the index page
define('INDEX_FILE', 'index.html');

//File name of the archive page
define('ARCHIVE_FILE', 'archive.html');

//Date format for individual post pages
define('OUTPUT_DATE_FORMAT', 'j F Y');

//Date format for the index page
define('INDEX_DATE_FORMAT', 'j F Y');

//Date format for the archive page
define('ARCHIVE_DATE_FORMAT', 'j F Y');

//Number of posts to show on the index page
define('INDEX_ITEMS', 10);


/* RSS-specific configuration */

//Whether to generate an RSS file
define('RSS', true);

//File name of the RSS file
define('RSS_FILE', 'rss.xml');

//Number of posts to list in the RSS file
define('RSS_ITEMS', 10);

//The URL of your site (including http(s):// and trailing slash)
define('RSS_LINK', '');

//A brief description of your site
define('RSS_DESCRIPTION', '');
