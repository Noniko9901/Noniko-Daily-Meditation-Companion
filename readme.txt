=== Noniko Daily Meditation Companion ===
Contributors: noniko9901
Tags: meditation, daily meditation, recovery, shortcode
Requires at least: 6.9
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Short Description ==

Displays a daily meditation from a bundled database using a simple WordPress shortcode.

== Description ==

Noniko Daily Meditation Companion displays a daily meditation from a local database bundled with the plugin.

The plugin imports meditation data from an SQL file included with the plugin and provides a simple shortcode for displaying the meditation for the current day or a selected date.

Features include:

* Automatic database table creation.
* Import of meditation data from a bundled SQL file.
* Daily meditation display.
* Display of a specific meditation by date.
* Simple administration page.
* Database information and import tools.
* Translation-ready strings.

== Installation ==

1. Upload the `noniko-daily-meditation-companion` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the WordPress Plugins screen.
3. The plugin will create its database table and import the bundled meditation data.
4. Add the `[noniko_daily_meditation_pl]` shortcode to a page or post.

== Usage ==

Display today's meditation:

`[noniko_daily_meditation_pl]`

Display a specific meditation:

`[noniko_daily_meditation_pl date="01-03"]`

== Database ==

The plugin uses a dedicated WordPress database table for storing meditation data.

The default meditation data is included in:

`data/meditations_pl.sql`

The database can also be re-imported manually from the plugin administration page.

== Privacy ==

This plugin does not send meditation data to external services.

The meditation database is stored locally in the WordPress installation.

== Changelog ==

= 1.0.0.0 =
* Initial release.
* Added meditation database.
* Added SQL import functionality.
* Added daily meditation shortcode.
* Added administration page.