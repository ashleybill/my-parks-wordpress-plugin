=== My Parks ===
Contributors:      The WordPress Contributors
Tags:              parks, custom post type, blocks, taxonomy, filters
Tested up to:      6.8
Stable tag:        0.3.2
License:           GPL-2.0-or-later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html

A WordPress plugin for managing park listings with custom blocks, taxonomies, and filtering capabilities.

== Description ==

My Parks provides a complete solution for managing and displaying park information on your WordPress site. It includes:

* **Custom Post Type**: Park post type with featured images and excerpts
* **Taxonomies**: Activities, Facilities, and Locations for organizing parks
* **Custom Blocks**: 9 specialized Gutenberg blocks for displaying park information
* **Filtering**: Search and taxonomy-based filtering for park listings
* **ACF Integration**: Works with Secure Custom Fields for additional park metadata

**Included Blocks:**

* Park Flip Card - Display parks as interactive flip cards
* Park Search Filter - Search parks by keyword
* Park Taxonomy Filter - Filter parks by activities, facilities, and locations
* Gallery Slider - Image gallery with slider functionality
* Operational Dates - Display park operating hours and seasons
* Visitor Services - Show available visitor services
* Rates - Display park fees and pricing
* Advisories - Show important park alerts and notices
* Taxonomy Icons - Display taxonomy terms with icons

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/my-parks`, or install through the WordPress plugins screen
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Install and activate Secure Custom Fields (SCF) plugin (required dependency)
4. Navigate to Parks in the admin menu to start adding parks

== Frequently Asked Questions ==

= What are the requirements? =

WordPress 6.8 or higher, PHP 7.4 or higher, and the Secure Custom Fields (SCF) plugin.

= How do I add a new park? =

Go to Parks > Add New in your WordPress admin. Add a title, featured image, excerpt, and use the custom blocks to add detailed information.

= Can I customize the park fields? =

Yes, the plugin uses Secure Custom Fields (SCF) for additional metadata. You can customize field groups in the plugin's includes/field-groups.php file.

= How do I display parks on my site? =

Create a page and use the Park Flip Card block to display parks. Add the Park Search Filter and Park Taxonomy Filter blocks to enable filtering.

== Changelog ==

= 0.3.2 =
* Fixed search clear functionality to properly reset card display and prevent jumping
* Added automatic filter clearing when typing in search box for better UX
* Improved interaction between search and taxonomy filter systems

= 0.3.1 =
* Fixed park search filter form submission causing 404 errors on mobile
* Prevented search form from submitting when Enter key is pressed
* Search now only filters park cards without page navigation

= 0.3.0 =
* Added [park_embed_map] shortcode for embedded Google Maps with customizable width, height, and zoom
* Updated [park_map] shortcode to use Google Maps URLs for better compatibility
* Added field group menu_order to ensure Park Configuration appears first in admin
* Enhanced test coverage for both map shortcodes
* Fixed test syntax errors and improved test reliability

= 0.2.0 =
* Fixed taxonomy icons block to properly display images from media library
* Added park location coordinates field group (latitude/longitude)
* Added [park_map] shortcode for mobile-friendly map links
* Updated plugin-zip script to auto-build before packaging
* Added comprehensive test coverage for new features

= 0.1.0 =
* Initial release
* Custom park post type
* Activity, Facility, and Location taxonomies
* 9 custom Gutenberg blocks
* Search and taxonomy filtering
* SCF integration for custom fields
