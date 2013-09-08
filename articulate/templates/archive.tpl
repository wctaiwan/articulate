<!doctype html>
<html>
<head>
<meta charset="utf-8" />
<title>Archive | [site_name]</title>
<link rel="stylesheet" type="text/css" href="[templates]/style.css" />
<?php if (RSS == true): ?>
<link rel="alternate" type="application/rss+xml" title="RSS" href="[rss]" />
<?php endif; ?>
</head>

<body>
<div id="container">
<div id="header">
<h1><a href="[index]">[site_name]</a></h1>
<ul>
<li><a href="[archive]">Archive</a></li>
<?php if (RSS == true): ?>
<li><a href="[rss]">RSS</a></li>
<?php endif; ?>
</ul>
</div>

<div class="post">
<h2>Archive</h2>
[post]
<p><span class="archivedate">[date]</span><a href="[link]">[title]</a></p>
[/post]
</div>

<div id="footer">Created with <a href="http://wctaiwan.com/articulate/">Articulate</a></div>
</div>
</body>
</html>
