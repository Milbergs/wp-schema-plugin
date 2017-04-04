# Wordpress Schema Plugin

OTM Homemade Schema (JSON-LD) plugin for Wordpress 4.

## Features
- places JSON-LD information in website header for spiders to crawl;
- fully compliant with Google recommended schema markup for `LocalBusiness`, `BreadCrumbList` & `Person`;
- provides control over service rating shown on Google by manual means or automatic Testimonial loop;
- provides Testimonial custom post type in menu and star rating system in the editor;
- `[wsp_testimonials]` for multiple or individual testimonials, testimonial ranges;
- adds settings page with generous recommendations for better crawling, some fields have sane defaults, others default to best available alternative;
- has built-in link to Google's Schema verification tool;
- this plugin should not conflict with other common plugins;
- tested with php 5.3.2 - 7.0;
- works with Wordpress 4 and up;
- WPML ready;
- supports Emoji :poop:;

## Installing
- drop this plugin in `/wp-content/plugins/`;
- activate from Wordpress Plugin manager;
- complete setup in "Schema Settings" menu;

## Shortcodes
It is advised to use php functions from within the theme rather than `do_shortcode('[wsp_***]');`, since `do_shortcode` is very expensive operation.

- `[wsp_testimonials]` / `wsp_testimonials( $args )` - returns all public custom post type `Testimonials` testimonials formatted in HTML. Can be used with the following attributes:
  - `hr="true"` - will add `<hr>` after every testimonial *(default: `False`)*. Good for Testimonial display;
  - `mode="raw"` - will return raw `array` of testimonial data without HTML formatting *(default: `html`)*. Good for custom modifications;
  - `id="$id"` - will return only `$id` testimonial *(default: `False`)*. Good for highlighting specific testimonial;
  - `limit="$n"` - limit to `$n` amount of newest testimonials. *(default: `-1`)*. Good for sliders;
- `[wsp_breadcrumbs]` / `wsp_breadcrumbs( $args )` - returns all breadcrumbs of current page. Suitable to put under header or above main element;
- `[wsp_social]` / `wsp_social( $args )` - displays HTML formatted font-awesome icons with social network urls. **Note, that due to Avvo logo absence form Font-Awesome, the SVG file has to be given size and fillcolor.** Can be called with:
  - `raw="true"` - returns just raw `'network'=>'//example.com/url'` for custom styling;
- `[wsp_info address]` - will return array of all address elements or can call: *address, phone, name, facebook, twitter, google-plus, instagram, youtube, linkedin, myspace, pinterest, soundcloud, tumblr, yelp, avvo*;

## ToDo
See CHANGELOG.md for details

## Built With
- [Schema rating markup](https://schema.org/Rating);
- [Schema structure testing tool](https://search.google.com/structured-data/testing-tool);
- [wp-plugin-template](https://github.com/hlashbrooke/WordPress-Plugin-Template). *we should consider building next plugins with [Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate)*;

## Versioning
We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).
