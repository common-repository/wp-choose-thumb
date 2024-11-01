=== WP-Choose-Thumb ===
Contributors:
Donate link: http://www.daveligthart.com
Tags: thumbnail, thumb, thumbnails, attachments, thumbs, featured
Requires at least: 2.7
Tested up to: 3.5
Stable tag: trunk

A simple way to add a default thumbnail to your post.

== Description ==

A simple way to choose a default thumbnail for your post. 

Works alongside the featured image core functionality.

For theme usage:

= Add this function where you want the thumbnail to appear =

`<?php if(function_exists('wct_thumb')){ wct_thumb(); } ?>`

== Installation ==

1. Extract zip in the `/wp-content/plugins/` directory
2. Activate the plugin through the 'plugins' menu in WordPress

== Screenshots ==

1. Choose from thumbnails in the edit post view.
2. Display thumbnail in post.
3. Overview demo

== Changelog ==

= Version 1.3.6 = 

Added settings page.

== Frequently Asked Questions ==

= I see the choose thumb window right of my 'write post' screen, but It says 'Choose thumbnail for post' . And there is no thumb below this. =

You have to attach images to your post: first icon after Upload/Insert in the "Edit Post" view.

WordPress generates a thumbnail based on those images automatically.

If you have uploaded the images it is best practice to publish your post first.

Click the "refresh" link in de WP-Choose-Thumb sidebar window.

Afterwards the thumbnails will automatically appear in de sidebar window.

= How can i change the thumbnail size =

You can define the size of the generated thumbnails here:
http://yoursite/wp-admin/options-media.php

