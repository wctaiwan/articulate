<?php echo '<?xml version="1.0"?>'; ?>
<rss version="2.0">
<channel>
<title>[site_name]</title>
<link>[rss_link]</link>
<description>[rss_description]</description>

[post]
<item>
<title>[title]</title>
<guid>[rss_link][link]</guid>
<pubDate>[date]</pubDate>
<description><![CDATA[
[body]
]]></description>
</item>
[/post]

</channel>
</rss>
