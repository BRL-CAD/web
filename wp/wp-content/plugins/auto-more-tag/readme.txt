=== Auto More Tag ===
Contributors: anubisthejackle, toubsen
Tags: more, tag, content, development, travis, weston
Requires at least: 3.2.1
Tested up to: 3.5.2
Stable tag: 3.2.2

Allows you to add a More tag to your post automatically upon publication.

== Description ==

Auto More Tags is a WordPress plugin that allows you to forget placing a more
tag on every post. It lets you stop worrying about where you should place those
tags, and just set rules. Once those rules are set, the intelligent placing
system will use your settings as a guideline, and attempt to place the more tag
as closely to your settings as possible, without breaking formatting or cutting
paragraphs off without cause.

== Installation ==

1. Upload the auto-more-tags.zip to your /wp-content/plugins directory
2. Extract the files
3. Modify the settings, or rely on the default settings.

== Frequently Asked Questions ==

= Where to ask questions about usage? =
Head to the [Wordpress plugins forum](http://wordpress.org/support/plugin/auto-more-tag)

= Where to send code issues / bugfixes? =
Head to the [Github project's issue tracker](https://github.com/toubsen/wp-auto-more-tag/issues)

== Screenshots ==

1. This is the options page for Auto More Tag.

== Changelog ==

= 3.2.2 = 
* Integrated fix for repeated content on short posts

= 3.2.1 =
* Version bump in php files + readme for wordpress auto update

= 3.2 =
* Made the plugin multibyte aware / safe (UTF-8)
* Removed donate / credit stuff
* Set the default of "auto update posts on settings change" to false, to prevent
  accidents while not having tested on single posts in your installation

= 3.1 =
* Added functionality to allow you to forgo the auto more tag on Pages.

= 3.0 =
* Improved intelligent placement, fixing glitch with HTML. Placement is now
  based on plaintext, and not HTML content. Added capabilities to place by word
  count.

= 2.1.3 =
* Minor change to posting, so tag isn't placed as first character of post.

= 2.1.2 =
* A formatting error was causing the auto more tag to be placed in the midst of
  HTML tags. It now performs a better formatted check to verify that it is not
  in between the &lt; and &gt; tags. (<>)

= 2.1.1 =
* Updated Donate and Plugin URLs

= 2.1 =
* Added option to automatically update when new settings are saved. This cycles
  through all your posts, and updates each one based on the new Auto More Tag
  settings. Also added in a shortcode for manual placement, for those times when
  you just have to do it yourself.

= 2.0 =
* Added percentage based intelligent placing. 

= 1.1 = 
* Fixed a glitch that made it so it ignored the more tag entirely.

= 1.0 = 
* Initial public release of code.

== Upgrade Notice == 

= 1.1 =
* Glitch fix.
