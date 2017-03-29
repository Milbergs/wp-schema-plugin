# Wordpress Schema Plugin

OTM Homemade Schema (JSON-LD) plugin for Wordpress.

Features:
- places JSON-LD information in website header for spiders to crawl;
- fully compliant with Google recommended schema markup;
- provides contact information about Local Business and can be later extended to other business types;
- provides control over service rating shown on Google by manual means or automatic Testimonial loop;
- provides Testimonial custom post type in menu and star rating system below the editor;
- adds settings page with generous recommendations for better crawling, some fields have sane defaults, others default to best available alternative;
- [wsp_stars] shortcode for individual testimonials;

### Installing

- drop this plugin in /wp-content/plugins/;
- activate from Wordpress Plugin manager;
- complete setup in "schema settings" menu;

## Shortcodes
- [wsp_rating] - returns stars for individual testimonial;
- [wsp_testimonials] - returns all testimonials in HTML with stars;
- [wsp_breadcrumbs] - returns all breadcrumbs of current page (suitable to put under header or above main element);

## Running the tests

- this plugin should not conflict with other common plugins;
- if used with Bustr theme, will use existing testimonials for automatic aggregation;
- tested with php 7.0;
- works with Wordpress 4 and up;

## ToDo
See CHANGELOG.md for details

## Built With

- [Schema rating markup](https://schema.org/Rating);
- [Schema structure testing tool](https://search.google.com/structured-data/testing-tool);
- [wp-plugin-template](https://github.com/hlashbrooke/WordPress-Plugin-Template);


## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).
