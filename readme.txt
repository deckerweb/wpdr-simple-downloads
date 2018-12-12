=== Simple Download Manager for WP Document Revisions ===
Contributors: daveshine, deckerweb, wpautobahn
Donate link: https://www.paypal.me/deckerweb
Tags: downloads, download manager, file manager, files, documents, revisions, widgets, add-on, wp document revisions, easy downloads, simple downloads, deckerweb
Requires at least: 4.7+
Tested up to: 5.0.0
Requires PHP: 5.6
Stable tag: 1.2.0
License: GPL-2.0-or-later
License URI: https://opensource.org/licenses/GPL-2.0

Use the WP Document Revisions plugin as very basic & simple download manager with this additional add-on plugin.

== Description ==

= ADD-ON PLUGIN for "WP Document Revisions" (WPDR) =
Want to offer public file downloads? Just use "WP Document Revisions" plus this little add-on plugin! This **small and lightweight** add-on plugin just adds a few specific additions to the **awesome WPDR base plugin which does all the heavy lifting for you!**

For my own projects I needed a new but robust and future-proof plugin with a custom post type solution to replace an old, unsupported download counter plugin. With its many benefits I wanted WPDR as a base foundation for that. Now, that I've finally found my solution, I hope it may help you as well :-).

= What this Add-On does - General Features =
* All the benefits of "WP Document Revisions" plugin! (see below)
* Simple, basic download counter included!
* Use "Downloads" wording instead of "Documents" (changeable via options); plus Downloads icon.
* 2 additional taxonomies for download files: "File Categories" and "File Tags".
* *3 additional Widgets:*
 * Display most popular/ accessed Downloads with "Popular Downloads".
 * Simple taxonomy listings with "Download File Categories / Tags".
 * To Downloads restricted search with "Search Downloads".
* Own plugin settings page.
* Help tabs included.
* Fully internationalized!
* Fully Multisite compatible!

= Special Features of this Add-On =
* Full German translations included, formal and informal versions - you can choose via options (default is 'formal').

= Benefits of using "WP Document Revisions" as the base plugin =
* *In general: fantastic plugin, awesome developer! :)*
* Really simple, yet very effective! Does just one thing, but does it right!
* Really secure & robust!
* Revision management by default.
* Workflow Status management by default.
* Uses known WordPress interface - just concentrate on file management :).
* Extendable via Hooks & Filters - very developer friendly.
* Support for "Edit Flow" plugin already included.

= Requirements =
* WordPress 4.7+ -- latest version 5.0.0 (or 4.9.8) always recommended!
* Already installed plugin ["WP Document Revisions"](https://wordpress.org/plugins/wp-document-revisions/)

= Recommended Settings & Usage Instructions =
* See ["Installation" section here](https://wordpress.org/plugins/wpdr-simple-downloads/#installation)
* Plus, see ["FAQ" section here](https://wordpress.org/plugins/wpdr-simple-downloads/#faq)

= Third-party compatibility included =
* *Genesis Framework:* For Child Themes - Display post meta on the frontend for the post type.

= Translations =
- English (United States) - `en_US` = default, always included
- [German (informal, default)](https://translate.wordpress.org/locale/de/default/wp-plugins/wpdr-simple-downloads) - `de_DE` - always included
- [German (formal)](https://translate.wordpress.org/locale/de/formal/wp-plugins/wpdr-simple-downloads) - `de_DE_formal` - always included
- `.pot` file (`wpdr-simple-downloads.pot`) for translators is always included in the plugin's 'languages' folder :)

= Be a Contributor =
If you want to translate, [go to the Translation Portal at translate.wordpress.org](https://translate.wordpress.org/projects/wp-plugins/wpdr-simple-downloads).

You can also contribute code-wise via our [WP Document Revisions Simple Downloads GitHub Repository](https://github.com/deckerweb/wpdr-simple-downloads) - and see where you can help.

= Documentation and Support =
- If you have any more questions, visit our support on the [Plugin's Forum](https://wordpress.org/support/plugin/wpdr-simple-downloads).

= Liked WP Document Revisions Simple Downloads? =
- Then please **rate us 5 stars** on [WordPress.org](https://wordpress.org/support/plugin/wpdr-simple-downloads/reviews/?filter=5/#new-post) :)
- Join our [**Facebook User Community Support Group**](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
- Like our [**Facebook Info Page for Deckerweb Plugins**](https://www.facebook.com/deckerweb.wordpress.plugins/)

= This Plugin ... =
- ... scratches my own itch!
- ... is *Quality Made in Germany*
- ... was created with love (plus some coffee) :-) - [if you like it consider donating](https://www.paypal.me/deckerweb)


== Installation ==

= Minimum Requirements =

* WordPress version 4.7 or higher
* *Base plugin:* [**WP Document Revisions**](https://wordpress.org/plugins/wp-document-revisions/), latest version
* PHP version 5.6 or higher
* MySQL version 5.0 or higher
* Administrator user with capability `manage_options` and/or `edit_theme_options`

= We Recommend Your Host Supports at least: =

* PHP version 7.0 or higher
* MySQL version 5.6 or higher / or MariaDB 10 or higher

= Installation =

1. Install using the WordPress built-in Plugin installer (via **Plugins > Add New** - search for `wpdr simple downloads`), or extract the ZIP file and drop the contents in the `wp-content/plugins/` directory of your WordPress installation.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to "Documents"/ "Downloads" > Download Settings to set a few options - or just be happy with the default settings :)
4. Go and manage your downloas files :)

= Recommended Settings: =
*Go the add-on plugin's settings page (located under "Documents"/ "Downloads" > Download Settings):*

* Set downloads slug -- via WPDR
* Set upload directory for download files/ documents -- via WPDR
* Use "Downloads" wording instead of "Documents"
* Use additional taxonomies and widgets
* Set the preferred translations variant to load

= Basic Usage: =
* To insert a download file link into a Post, Page or Custom Post Type, use the regular "Insert Link" feature, search for your Download/ Document file (searches for title!) and insert the actual link. Really simple, yeah!
* To display Download files on the frontend you can also use the included widgets or the shortcodes of WPDR (see [the WPDR Wiki](https://ben.balter.com/wp-document-revisions/frequently-asked-questions/) for the shortcode documentation - scroll down a bit there...).
* To update an existing file/ document just open the existing item and upload a new version (revision). The file/ document peramlink will always point to the latest revision! Yeah, it's so easy :)
* You can also use third-party plugins or widgets that support custom post types to query, display or do anything you want with the "Document" post type, that we use for the download files. Pretty simple again, yet very effective and standards compliant.
* *List of reccommended third-party plugins:*
  * [Count Shortcode](https://wordpress.org/plugins/count-shortcode/) - simple count posts or post types
  * [Faceted Search Widget](https://wordpress.org/plugins/faceted-search-widget/) - sidebar widget to allow filtering indexes by builtin and custom taxonomies
  * [Display Posts Shortcode](https://wordpress.org/plugins/display-posts-shortcode/) - display a listing of posts or post types using the `[display-posts]` shortcode 
  * [Edit Flow](https://wordpress.org/plugins/edit-flow/) - for even more workflow & team/staff management -- Alternative: [PublishPress](https://wordpress.org/plugins/publishpress/)
  * [Members](https://wordpress.org/plugins/members/) - for user roles & capability management

= Other Stuff: =

**Own translation/wording:** For custom and update-safe language files please upload them to `/wp-content/languages/wpdr-simple-downloads/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that, just use a language file like `wpdr-simple-downloads-en_US.mo/.po` to achieve that.

= Deinstallation =
If you ever want to uninstall the add-on (i.e. "WP Document Revisions Simple Downloads") you can use your stuff like before. All will work like normal as **this plugin does NOT make any permanent modifications!** Good to know, right?! :)


== Frequently Asked Questions ==

= Why on earth do I need this plugin along with WPDR? =
Good question, hehe :). -- "WP Document Revision" (WPDR) already does all the heavy lifting for you, and **in reality** is your actual *download manager*! This add-on plugin here (a.k.a. "WP Document Revisions Simple Downloads") does minor adjustments and additions for more comfort, even easier (admin) usage and provides specific "Downloads" specific wording/ translations. The add-on fully leverages the existing hooks & filters of its base plugin as well as from WordPress itself. So, in reality it does not make any (permanent) modifications. With this approach we avoid performance issues and load things only where and when needed. -- Also, the add-on adds 3 nice little widgets which may help to improve your site/ download manager on the front end.


= Alternatives for inserting downloads/ documents? =
To insert download files (URLs) into posts, pages, other post types, sidebars or templates just use any of the following alternatives:

1) The easiest one: WordPress' built-in "Insert Link" feature which is there in both editors, "Visual" and "Text". -- [see screenshot 1](https://www.dropbox.com/s/duwf83239bl813c/screenshot-5.png), plus [screenshot 2](https://www.dropbox.com/s/34skmbvvdzmz0ra/screenshot-6.png)...

2) 2 base shortcodes of WPDR: `[documents]` and `[document_revisions]` -- [see Wiki for more info (scroll down a bit...)](https://ben.balter.com/wp-document-revisions/frequently-asked-questions/)

3) 4 available widgets: 1 from WPDR, plus 3 from this add-on plugin.

4) Any third-party plugin or widget that does support custom post types by WordPress. I highly recommend one of these: [Display Posts Shortcode](https://wordpress.org/plugins/display-posts-shortcode/) - display a listing of posts or post types using the `[display-posts]` shortcode // [Count Shortcode](https://wordpress.org/plugins/count-shortcode/) - simple count posts or post types

5) For developers: shortcodes can also be used with their template tag equivalent: `<?php do_shortcode( '[your_shortcode ...]' ); ?>`


= What's going on, "Downloads" or "Documents"? =
You decide, which wording or which translations will be loaded! In my opinion it's better to use purpose-specific and consistent wording throughout both plugins which will avoid confusions in day to day usage with your team.

The add-on DOESN'T modifiy the actual post type that's used as the base. This post type is by WPDR and has the ID "document", therefore some admin urls and such still reflect this ID. But in the end *this* just doesn't matter :).


= Is this plugin Multisite compatible? =
Of course it is! :) Works really fine in Multisite environment.


= In Multisite, can I "network activate" this plugin? =
Yes, you can! Activating on a per-site basis is also possible. -- I recommend activating on a per-site basis in combination with "WP Document Revisions" plugin.


= Where are the Hooks & Filters documented? =
Currently as [Gist on GitHub](https://gist.github.com/4395899).


**Final note:** I DON'T recommend to add customization code snippets to your main theme's/ child theme's `functions.php` file! **Please use a functionality plugin or an MU-plugin instead!** This way you can also use this better for Multisite environments. In general you are then more independent from theme/child theme changes etc. If you don't know how to create such a plugin yourself just use one of my recommended 'Code Snippets' plugins. Read & bookmark these Sites:

* [**"Code Snippets"** plugin by Shea Bunge](https://wordpress.org/plugins/code-snippets/) - also network wide!
* [**PHP Code Snippets (Insert PHP)** plugin by webcraftic](https://wordpress.org/plugins/insert-php/)
* [**"What is a functionality plugin and how to create one?"**](http://wpcandy.com/teaches/how-to-create-a-functionality-plugin) - *blog post by WPCandy*
* [**"Creating a custom functions plugin for end users"**](http://justintadlock.com/archives/2011/02/02/creating-a-custom-functions-plugin-for-end-users) - *blog post by Justin Tadlock*

All the custom & branding stuff code above can also be found as a Gist on Github: https://gist.github.com/4395899 (you can also add your questions/ feedback there :)


= More info on Translations? =

* English - default, always included
* German (de_DE): Deutsch - immer dabei! :-)
* For custom and update-safe language files please upload them to `/wp-content/languages/wpdr-simple-downloads/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that as well, just use a language file like `wpdr-simple-downloads-en_US.mo/.po` to achieve that (for creating one see the following tools).

**Easy WordPress.org plugin translation platform with GlotPress platform:** [**Translate "WP Document Revisions Simple Downloads"...**](https://translate.wordpress.org/projects/wp-plugins/wpdr-simple-downloads)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating and validating I recommend the awesome ["Poedit Editor"](https://www.poedit.net/), which works fine on Windows, macOS and Linux.


== Screenshots ==

01. Add-On plugin's settings page

02. Settings page - "Usage" tab

03. Admin "Downloads" table with additional stuff added by add-on

04. Edit "Download" view with additional stuff added by add-on

05. Insert Download link via Visual Editor

06. Insert Download link via Text Editor (HTML)

07. Popular Downloads widget

08. Search Downloads widget

09. Taxonomy Widget - used for "File Categories"

10. Taxonomy Widget - used for "File Tags"

11. Original "Recently Revised Downloads" (Documents) widget - by base plugin WPDR :)

12. Help tab user guidance included


== Changelog ==

= 1.2.0 - 2018-12-12 =
* *New: Brought the plugin back to life after more than six years, yeah! :)*
* New: Release on GitHub.com as well (for issues, development etc.), see here: [https://github.com/deckerweb/wpdr-simple-downloads](https://github.com/deckerweb/wpdr-simple-downloads)
* New: Added plugin update message also to Plugins page (overview table)
* New: Added plugins recommendations library by deckerweb to add plugin installer tips
* New: Added uninstaller to remove plugin's options when deleting (uninstalling) the plugin
* New: Added `composer.json` file to the plugin's root folder - this is great for developers using Composer
* New: Added `README.md` file for plugin's GitHub.com repository to make it more readable there
* New: Added new plugin icon and banner on WordPress.org
* New: Created special [Facebook Group for user community support](https://www.facebook.com/groups/deckerweb.wordpress.plugins/) for all plugins from me (David Decker - DECKERWEB), this one here included! ;-) - [please join at facebook!](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
* Update: Completely reworked translation loading for the plugin itself, plus the optional feature translations for WP Document Revisions - all more standards compliant
* Update: Changed admin icon to newest WP standard, using Dashicon
* Update: Enhanced security
* Update: Lots of code tweaks and improvements throughout the plugin; all code now properly hooked
* Update: `.pot` file for translators, plus German translations
* Update: Readme.txt file
* *Trivia fact: this plugin is already over 6 (six!) years old. Whoa, that's a lot. ;-)*


= 1.1.0 - 2013-11-11 =
* **Unreleased - private beta version!**
* UPDATE: Fixed doubled notice when saving settings (was impacting other plugins...).
* UPDATE: Changed and improved plugin's own translation loading.
* UPDATE: Minor code/ documentation improvements and tweaks.
* UPDATE: Updated German translations and also the .pot file for all translators.
* NEW: Added partly Spanish translations, user-submitted.


= 1.0.0 (2012-12-28) =
* Initial release

== Upgrade Notice ==

= 1.2.0 =
**Major release: Back in life :-)** - Fully working again. All code fixed, refactored and improved. - Have fun managing your download files ;-) -- **Update highly recommended!**

= 1.1.0 =
Private beta (unreleased).

= 1.0.0 =
Just released into the wild.


== Plugin Links ==
* [Translations (GlotPress)](https://translate.wordpress.org/projects/wp-plugins/wpdr-simple-downloads)
* [User support forums](https://wordpress.org/support/plugin/wpdr-simple-downloads)
* [Code snippets archive for customizing, GitHub Gist](https://gist.github.com/4395899)


== Donate ==
Enjoy using *WP Document Revisions Simple Downloads*? Please consider [making a small donation](https://www.paypal.me/deckerweb) to support the project's continued development.


== Additional Info ==
**Idea Behind / Philosophy:** I just needed a simple downloads/ file manager plugin that used a custom post type for management. Since there are no such good download managers out there yet, but with the "WP Document Revisions" plugin there was an awesome solution. It only had few things missing in my opinion if used for public downloads/ file management. So finally, this add-on plugin was born. I hope you also find it useful somehow... :)


== Credits ==
* [**Ben Balter**](http://ben.balter.com/) for an amazing plugin with [**WP Document Revisions** - see WP.org plugin page](http://wordpress.org/extend/plugins/wp-document-revisions/) -- [see GitHub plugin development page](https://github.com/benbalter/WP-Document-Revisions/)!
* [**iconmonstr**®](http://iconmonstr.com/) for their amazing free icons. (This was used for version 1.0 - since then we switched to Dashicons.)


== My Other Plugins ==
* [**Toolbar Extras for Elementor - WordPress Admin Bar Enhanced**](https://wordpress.org/plugins/toolbar-extras/)
* [**Builder Template Categories - for WordPress Page Builders**](https://wordpress.org/plugins/builder-template-categories/)
* [**Polylang Connect for Elementor – Language Switcher & Template Tweaks**](https://wordpress.org/plugins/connect-polylang-elementor/)
* [Genesis What's New Info](https://wordpress.org/plugins/genesis-whats-new-info/)
* [Genesis Layout Extras](https://wordpress.org/plugins/genesis-layout-extras/)
* [Genesis Widgetized Not Found & 404](https://wordpress.org/plugins/genesis-widgetized-notfound/)
* [Genesis Widgetized Footer](https://wordpress.org/plugins/genesis-widgetized-footer/)
* [Genesis Widgetized Archive](https://wordpress.org/plugins/genesis-widgetized-archive/)
* [Multisite Toolbar Additions](https://wordpress.org/plugins/multisite-toolbar-additions/)
* [Cleaner Plugin Installer](https://wordpress.org/plugins/cleaner-plugin-installer/)