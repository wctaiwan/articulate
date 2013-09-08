Articulate
==========

## Introduction
Articulate is a simple semi-dynamic blogging script in PHP. Compared to traditional blogging scripts that compile content as they're requested by visitors, Articulate acts more like a batch converter that generates HTML pages from plain text files based on templates. While it has few features, it is lightweight and easy to customise.

## Licence Information
Articulate is released under a 2-clause BSD licence, as outlined in `licence.txt`.

Articulate includes a copy of [PHP Markdown](http://michelf.com/projects/php-markdown/) Extra 1.2.4 by John Gruber and Michel Fortin, which is released under a BSD-style open source licence. More information can be found in `update/markdown.php`.

## Acknowledgements
Thanks to members of `#neowin` and `##php` for their help.

## Installation
1. Upload the contents of `articulate/` to a folder on your web server.
2. Navigate to `update/` in your web browser.

* If there are no errors, installation is complete.
* Otherwise, please make sure Articulate has the required permissions on the indicated files.

## Updating your website

### Creating new posts
Upload text files with file names in the format of `YY-MM-DD-short_name.txt` to `_posts/` and then go to `update/`.

The first line of the file would be read as the title of the post, with the rest being the contents. You can use [Markdown](http://daringfireball.net/projects/markdown/basics) to format your posts.

### Updating existing posts
Modify the corresponding text file in `_posts/` and then go to `update/`.

### Deleting existing posts
To remove a post from the index and archive pages and the RSS file, remove the corresponding text file and then go to `update/`. Note that this does *not* remove the HTML version of the deleted post.

### Rebuilding your website
By default, Articulate does not update HTML versions of posts that have not been changed since the last update, or remove those of posts that have been deleted. If you change the configuration or appearance of your site, it may be necessary to manually trigger a rebuild of your entire website.

To do so, click on "Rebuild your website", located at the bottom of the update script.

## Customising your website
* You can configure your site by editing `config.php`.
* You can change the appearance of your site by creating template files and placing them in `templates/`. You can use PHP in your template files&mdash;it will be interpreted the moment the files are loaded.

## Getting help
If you have any questions or comments, please send them to wctaiwan at Google's email service.
