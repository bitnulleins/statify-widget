=== Statify Widget ===
Contributors: 		bitnulleins
Tags: 			statify, widget, popular posts, custom post types, wordpress, analytics, privacy, statistics
Requires at least: 	4.6
Tested up to: 		5.8.1
Requires PHP: 		5.2.4
Stable tag: 		trunk
License: 		GPLv2 or later
License URI: 		http://www.gnu.org/licenses/gpl-2.0.html

Widget for list popular content (pages, posts, custom post types) – based on Statify plugin.

== Description ==

The *Statify Widget* shows the most popular content from [Statify](http://wordpress.org/plugins/statify/) plugin made by pluginkollektiv. Fast and clear!

= Statify =

Plugin for visitor statistics with emphasis on privacy, transparency and clarity.

**Note**: This widget only works in conjunction with the Statify plugin.

= Own content types =

Own content types (Custom Post Types) are supported and can also be displayed.

= Intelligent summary =

Once there are different paths to a content, the widget adds them together and adds the calls.

= New: period selectable =

You can now choose an individual daily period for the most popular content. Just set in the widget.

= Calls of individual contents =

The shortcode `[statify-count]` can be used to display calls to the current post or page. With the options "prefix" and "suffix" displayed texts can be checked before (prefix) and after (suffix) the calls:

`[statify-count prefix="Total " suffix=" calls." days="8"]`

Parameter:

* `prefix`: Sentence before views
* `suffix`: Sentence after views
* `days`: Inteval for view statistics

Result: A total of 243 views.

= Settings =

The following settings can be made in the widget:

* Title
* Content Type (Default: post )
* Category (when content type post is select)
* Amount (default: 5)
* Show calls (default: No)
* Custom text (Replace variable for views: %VIEWS%)
* Number of past days

= Support =

Friendly questions about the widget I like to answer under * Support *.

= Author =

* Finn Dohrn
* [Homepage](http://www.bit01.de)

== Installation ==

Install the plugin [Statify] (http://wordpress.org/plugins/statify/) by pluginkollektiv. And then from the plugin directory "Statify Widget" install and activate.

Manually:

1. Load the folder "statify-widget" into the plugin folder (./wp-content/plugins/)
1. Activate the plugin on your page
1. Add the "Satify Widget" under Design > Widgets

== Frequently Asked Questions ==

= Error: The widget does not find any entries =

Statify has not added statistics yet. Wait some days to collect some statistics.

= Show pages and posts together =

Yes! Since 1.1.4 that works. Just in the content type widget: select "Pages and posts". He then displays the default content types "post" and "page" together.

= Show views of individual posts / pages or from site =

This is possible with the shortcode and theme functions. Specifying a prefix and suffix is ​​not mandatory:

`[statify-count prefix ="Total" suffix ="calls." days="8"]`

The following functions return the number of calls for an article ID (`$ post_id`) in the theme. If no ID is given, the number of the current page will be returned.

`if(function_exists('get_statify_count')) echo get_statify_count($post_id, $days = 0);`

Example: `<?php echo get_statify_count (); ?>`

The total views of the page can be over:

`[statify-count-sum prefix="Total" suffix="calls."]`

Alternative it is possible, to call this in theme with:

`if(function_exists('get_statify_count_sum')) echo get_statify_count_sum($days = 0);`

Calling!

= Return all posts as WP Query =

You this in your theme, for example as "popular post blog page":

`if(function_exists('statify_popular_posts')):
    statify_popular_posts(  $amount = 5,
                            $days = 30,
                            $post_type = 'post',
                            $post_category = 0);`

Properties
* `$days` Range of days for statictics (0 = all days)
* `$amount` Amount of posts
* `$post_type` Post type ("post", "page", ...)
* `$post_category` Category of the post, if post type is choosen

= I do not have static page as homepage =

No problem. A pseudo "Home" entry appears.

= I changed the permalink structure =

This changes nothing. The plugin takes every Statify entry and adds it together sensibly.

= Change design =

Just the CSS classes:
* `.statify-widget-list {...}`
* `.statify-widget-element {...}`
* `.statify-widget-link {...}`

= Change list from numeric to points =

If you want to change the list of contents (1st, 2nd, 3rd, ...) to bullets, just add the following to the CSS:

`.statify-widget-element {
    list-style-type: circle;
} `

== Screenshots ==

1. Statify Widget Result
2. Statify Widget Settings


== Changelog ==

= 1.3.3 =

* New way to return list of popular posts as WP_Query
* Correct the way how pseudo frontpage is generate

= 1.3.2 =

* Fix for non existing views in "Frontpage" alias

= 1.3.1 =

* Fix bug in [statify-count-sum]. Remove unnecessary post_id.
* Add shortcode parameter "days" for limit interval days.

= 1.3.0 =

* Bugfix: Hide duplicate frontpage item in widget.

= 1.2.9. =

* Now comtaible with PHP8
* Fix two bugs occured in PHP8 version.
* Remove "frontpage" label, now the frontpage list with its original page name

= 1.2.8 =

* Fix bugs

= 1.2.7 =

* Add some description and tested up to WordPress v5.6

= 1.2.5 =

* Fixed bug in backend for category select

= 1.2.4 =

* Fixed ressourcen bug. Add required java script folder.

= 1.2.3 =

* Add feature to filter for post category in widget.

= 1.2.2 =

* Fixed another bug for unpublished posts

= 1.2.1 =

* Translate whole plugin into English.
* Fixed "show views" translation bug.

= 1.2 =

* English and German language
* Fixed a link bug in the widget
* Shortcode for total number of views

= 1.1.9 =

* Correction of a translation error.
* List type setting has been removed.

= 1.1.8 =

* The plugin is now ready for translation.
* You can now choose between the list type (`<ol>` or `<ul>`) per widget.
* Now the classes `statify-widget-list`,` statify-widget-element` and `statify-widget-link` have been added as class to make a more flexible design possible.

= 1.1.7 =

* List type ordered (`<ol>`) changed to unordered (`<ul>`) for higher theme compatibility.
* Outdated create_function () method swapped.
* Bug with shotcode usage removed (statify_count edited in Statify_Posts.class.php)

= 1.1.6 =

* The functionality of restricting a time period for the content has been added.
* Fixed a bug that caused the homepage to ignore when choosing "Posts + Pages".

= 1.1.5 =

* An error has been removed. He had always shown the number of views at the end of a page.

= 1.1.4 =

* Content Type: "Posts and Pages" added to show together
* Views for article shortcode and theme function

= 1.1.3 =

* Recording the evolution and tested for WordPress 4.7.6

= 1.1.2 =
* Corrections in the validation

= 1.1.1 =
* Custom text for the number of views
* Unused require_once () removes
* span element added by the number of views

= 1.1 =
* Limitation of records canceled
* added title attribute to the links

= 1.0 =
* Release of the first version

== Upgrade Notice ==

No Upgrades