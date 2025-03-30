=== AppSheet Functions ===
Contributors: Bachacode
Donate link: https://bachacode.com
Tags: appsheet
Requires at least: 3.0.1
Tested up to: 6.6.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Custom made plugin for TailorSheet website used to manage AppSheet related content through CPTs and Custom Taxonomies

== Description ==

Custom made plugin for TailorSheet website used to manage AppSheet related content through CPTs and Custom Taxonomies

### AppSheet Functions Post Type
CPT for AppSheet Functions management in a single place.

### Elementor Widgets
Custom Elementor Widgets handmade to display AppSheet Functions and their examples with ease.

== Changelog ==

= 2.7.1 =
* Streamline Post List widget initialization by moving style and script enqueuing to the constructor, and remove redundant CSS rules for improved clarity

= 2.7.0 =
* Added twig as template engine
* Added new helpers static functions for twig template rendering
* Renamed AppSheet Functions List widget to Post List
* Fixed route of enqueue styles and scripts of select2 library
* Fixed relative path to textdomain locales
* Updated template directory path and disabled caching in Twig initialization
* Added AlpineJS script registration to Frontend_Handler
* Introduced TSM_Control_Builder class for streamlined Elementor control registration
* Enhanced TSM_Widget_Base with generic section and control registration methods
* Implement Post List widget with customizable controls and new template rendering
* Enhance Post List widget with responsive controls, shadow options, and improved template rendering using Jquery
* Update post list template to use server-side rendering for improved performance and readability
* Add search functionality to Post List widget with customizable placeholder and responsive styling
* Rename CSS classes from .af-main__wrapper to .tsm-main__wrapper for consistency and update related styles in templates
* Add 'Make Whole Post Linkable' control to Post List widget and refactor related CSS classes for improved structure
* Enhance Post List widget with new taxonomy filtering options and improved sidebar layout for better user experience
* Add styling controls for post count and categories list in Post List widget, enhancing customization options
* Improve Post List widget layout with additional styling for content wrappers and overflow handling
* Introduce dedicated CSS file for Post List widget, enhancing layout and styling consistency across components
* Implement JavaScript functionality for Post List widget, enabling search and category filtering capabilities
* Updated version to 2.7.0 and refresh language files for improved translations and new features

= 2.6.0 =
* Changed naming from Public to Frontend

= 2.6.0 =
* Changed file, class, and widget name
* Created a parent class for elementor widgets
* Added new autoloader for classes inside "includes" folder
* Moved widgets inside includes folder
* Refactor how widgets are registered
* Added new namespace for core classes in includes folder
* Created a namespace and moved admin related classes inside includes folder
* Changed constant in assets route helper from BASE_DIR to BASE_URL
* Created a namespace and moved public related classes inside includes folder
* Changed class name of Admin and Public Bootstrap to Handler
* Converted helper functions to static functions of a new Helpers class
* Replaced previous helper template loader function with new static function from Helpers class
* Updated translations

= 2.5.4 =
* Added font color options to heading and content of "Appsheet Functions FAQ"

= 2.5.3 =
* Now FAQ widget passes down value with html attributes instead of localizing script

= 2.5.2 =
* Updated translations
* Created and registered "Appsheet Functions Faq" Js and Css
* Created and registered a new widget "Appsheet Functions Faq"

= 2.5.1 =
* Reduced "app_faq" subfields id length

= 2.5.0 =
* Added a new section of SEO fields to examples appsheet metabox
* Examples appsheet metabox is now untabbed
* Untabbed meta fields now have a custom background color
* Changed icons for extra fields tabs
* Check if relatedSelect existe before using method "select2"

= 2.4.5 =
* Removed taxonomy "relacion-de-expresion" from "expresiones-appsheet".

= 2.4.4 =
* Added a new metafield to "expresiones-appsheet" called "related_functions".
* Updated translations

= 2.4.3 =
* Added a new taxonomy to "expresiones-appsheet" called "relacion-de-expresion".
* Updated translations

= 2.4.2 =
* Fixed bad code that called undefined variable in post type file
* Added app_gallery meta field to "ejemplos-appsheet"
* Changed metabox "descriptive tabs" title to "app tabs"
* Fixed exopite bug where gallery type field checked an always undefined variable
* Made "add_button" translatable in metabox fields
* Fixed issue where "create_menu" callback would always run even in public side

= 2.4.1 =
* Removed "categoria-de-ejemplo" taxonomy
* Removed "etiqueta-de-ejemplo" taxonomy

= 2.4.0 =
* Ejemplos Appsheet archive is now changeable
* Expresiones Appsheet archive is now changeable

= 2.3.5 =
* Changed esc_url_raw for htmlspecialchars function for field fe_expected

= 2.3.4 =
* Changed sanitize text field for esc_url_raw function for field fe_expected

= 2.3.3 =
* Changed absint function to fe_expected to sanitize string

= 2.3.2 =
* Changed taxonomy "Sector de App" Show in REST value to true
* Changed taxonomy "Funcionalidad de App" Show in REST value to true
* Changed taxonomy "Integración de App" Show in REST value to true

= 2.3.1 =
* Removed "Whatsapp Message" metadata field from "AppSheet Examples" CPT

= 2.3.0 =
* Added new taxonomy "Sector de App"
* Added new taxonomy "Funcionalidad de App"
* Added new taxonomy "Integración de App"
* Updated translations to replace "Ejemplo/s" with "App/s"

= 2.2.1 =
* Changed metadata "automatizations" to "functionality"

= 2.2.0 =
* Added excerpt and app information field to "Ejemplos AppSheet"

= 2.1.0 =
* Added metadata to "Ejemplos AppSheet"


= 2.0.1 =
* Cleaning up unused files

= 2.0.0 =
* Added CPT "Ejemplos AppSheet"
* Added Custom taxonomies "Categoría de Ejemplo" and "Etiqueta de Ejemplo" to CPT "Ejemplos AppSheet"
* Added Plugin Menu Option and Settings Page for plugin
* Added all CPT and custom taxonomies to Plugin Menu Option as submenus
* Fixed Highlight bug with custom taxonomies under the Plugin Menu

= 1.2.7 =
* Changed plugin name from "Appsheet Functions" to "TailorSheet Manager"

= 1.2.6 =
* Disabled public visibility of "ejemplos de appsheet"

= 1.2.5 =
* Fixed category filter labels only selecting the first category

= 1.2.4 =
* Increased width of AppSheet Functions Main Cards to fix better the titles again

= 1.2.3 =
* Increased width of AppSheet Functions Main Cards to fix better the titles

= 1.2.2 =
* Removed appsheet functions thumbnail
* Added CSS to improve responsiveness of AppSheet Function Main Widget

= 1.2.1 =
* Normalized default styles in AppSheet Functions Main CSS

= 1.2.0 =
* Removed alpinejs from dependencies
* Created AppSheet Functions Main
* Added filter functionality to AppSheet Functions Main widget
* Added query by name functionality to AppSheet Functions Main widget
* Added default image to AppSheet Functions Main widget

= 1.1.2 =
* Spanish localization

= 1.1.1 =
* Fixed changelog format

= 1.1.0 =
* Added auto updater
* First release with auto updater

= 1.0.0 =
* Initial version.
* First release of the AppSheet Functions Plugin
