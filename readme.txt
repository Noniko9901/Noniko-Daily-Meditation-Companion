=== Noniko Daily Meditation Companion ===
Contributors: noniko9901
Tags: meditation, daily meditation, recovery, addiction recovery, shortcode
Requires at least: 6.9
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Daily meditation plugin designed to support people recovering from addiction. Includes daily meditations in Polish and English, with the possibility of adding additional languages in the future.

== Description ==

Noniko Daily Meditation Companion is a WordPress plugin that provides daily meditation content designed to support people affected by addiction and those in recovery.

The plugin displays a meditation for the current day or allows a specific meditation date to be selected.

Meditation content is stored locally in a dedicated WordPress database table. The plugin does not require external APIs or remote services to display meditation content.

The plugin currently supports:

* Polish.
* English.

The plugin architecture is designed to allow additional languages to be added in future releases.

Features include:

* Daily meditation display.
* Support for displaying meditation for a specific date.
* Polish and English language support.
* Architecture prepared for additional languages.
* Automatic database table creation.
* Import of meditation data from bundled SQL files.
* Database update system.
* Ability to update meditation data without reinstalling the plugin.
* Database information and management tools.
* Dedicated administration page.
* Plugin settings available from the WordPress administration sidebar.
* Manual database update functionality.
* Translation-ready strings.
* Local storage of meditation data.
* No external API required.

== Installation ==

1. Upload the `noniko-daily-meditation-companion` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the WordPress Plugins screen.
3. The plugin will automatically create the required database tables and import the bundled meditation data.
4. Open the plugin administration page from the WordPress administration sidebar.
5. Add the `[noniko_daily_meditation]` shortcode to a page or post.

== Usage ==

Display today's meditation:

`[noniko_daily_meditation]`

Display a specific meditation:

`[noniko_daily_meditation date="01-03"]`

The `date` attribute uses the `MM-DD` format.

== Languages ==

The plugin currently supports:

* Polish.
* English.

The database and plugin architecture are designed to support additional languages in future releases.

== Database ==

The plugin uses dedicated WordPress database tables for storing meditation data.

Meditation data is bundled with the plugin and imported into the WordPress database during installation.

The database update system allows meditation data to be updated when a new database version is released.

Database updates can be performed from the plugin administration page in the WordPress dashboard.

The plugin is designed so that database updates can be performed without reinstalling the plugin.

== Administration ==

The plugin adds a dedicated administration page to the WordPress administration sidebar.

The administration page provides access to database information and database management functionality, including database update tools.

== Privacy ==

Noniko Daily Meditation Companion does not send meditation data to external services.

The meditation database is stored locally in the WordPress installation.

The plugin does not require an external API or remote service to display meditation content.

== Changelog ==

= 1.0.0.1 =

* Changed the main shortcode to `[noniko_daily_meditation]`.
* Added a database update system.
* Added database update functionality to the administration page.
* Added a dedicated plugin entry to the WordPress administration sidebar.
* Added English language support.
* Added support for Polish and English meditation content.
* Improved the database structure to support additional languages in the future.

= 1.0.0.0 =

* Initial release.
* Added meditation database.
* Added automatic database table creation.
* Added SQL import functionality.
* Added daily meditation shortcode.
* Added support for displaying meditation by date.
* Added administration page.
* Added database information and import tools.
* Added manual database re-import functionality.
* Added translation-ready strings.