# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## ToDo
- automatic updating;
- optimize js code, search for security issues;
- create multiple department support with dynamic settings subpage;
- create shortcodes for every department;

## [1.4.5] - 2017-04-12
### Changed
- Added wrapper to social shortcodes, fixed shortcodes;

## [1.4.4] - 2017-04-07
### Added
- added `WP_GitHub_Updater` as a test;

## [1.4.3] - 2017-04-07
### Added
- on uninstall deletes all `option`s set by the plugin;
- on uninstall downloads [`wsp-testimonials`](//github.com/kasparsp/wsp-testimonials) plugin to keep testimonial support after `wp-schema-plugin` is gone;
- now the plugin enqueues `font-awesome` by default;

### Changed
- changed Avvo icon to inline svg, but the `height`, `width` and `fill` color will have to be changed in the file itself for now. Bets bet is to have font-awesome implement Avvo icon, but it will not happen soon.

### Fixed
- some more shortcode issues with wsp_testimonials returning error when no stars provided;
- styling issues caused by lack of 'dashicons' in enqueue;
- removed some fallout files;

## [1.4.2] - 2017-04-05
### Fixed
- some shortcode issues;

## [1.4.1] - 2017-04-04
### Changed
- added support for wsp-testimonials after wsp-schema-plugin uninstall;
- added experimental update from github support;

### Fixed
- removed php warning due to small bug;

## [1.4.0] - 2017-04-03
### Added
- `[wsp_social]` / `wsp_social( $args )` - displays HTML formatted font-awesome icons with social network urls. **Note, that due to Avvo logo absence form Font-Awesome, the SVG file has to be given size and fillcolor.** Can be called with:
  - `raw="true"` - returns just raw `'network'=>'//example.com/url'` for custom styling;
- `[wsp_info address]` / `wsp_info( $str )` - will return array of all address elements or can call: *address, facebook, twitter, google-plus, instagram, youtube, linkedin, myspace, pinterest, soundcloud, tumblr, yelp, avvo, phone*;

### Changed
- freshened up readme.md;
- upgraded `wsp_testimonials` shortcode;
  - `hr="true"` - will add `<hr>` after every testimonial *(default: `False`)*. Good for Testimonial display;
  - `mode="raw"` - will return raw `array` of testimonial data without HTML formatting *(default: `html`)*. Good for custom modifications;
  - `id="$id"` - will return only `$id` testimonial *(default: `False`)*. Good for highlighting specific testimonial;
  - `limit="$n"` - limit to `$n` amount of newest testimonials. *(default: `-1`)*. Good for sliders;
- schema for `Person` is now default;

### Removed
- `[wsp_stars]` became obsolete and had no usage;

## [1.3.2] - 2017-03-29
### Added
- Settings "articles" option that displays dropdown box of articles;
- php 5.3 support

### Changed
- optimized php, some conflicts solved;

### Fixed
 - solved "id" conflict;
 - fixed documentation with shortcode attributes;

## [1.3.1] - 2017-03-27
### Added
- priceRange ($ - cheap, $$ - inexpensive, $$$ - expensive, $$$$ - bourgeois) or simply $50 - $500
- added all subtypes for LocalBusiness type;
- added breadcrumb support to JSON+LD;
- [wsp_breadcrumbs] shortcode and appropriate styling classes to display breadcrumb trail;
 - added option to chose between different separators, custom separators may be implemented with css wsp-crumb:after pseudo-element;

### Fixed
- reviews showing in JSON when they are disable;

## [1.3.0] - 2017-03-10
### Added
- shortcode [wsp_rating] star rating for individual testimonials;
  - provided sufficient amount of CSS classes for (.wsp, .wsp-stars, .wsp-stars-ID);
- shortcode [wsp_testimonials] for testimonial loop on any page
  - provided sufficient amount of SASS classes for (.wsp, wsp-review, .wsp-review-ID, .wsp-review-name, .wsp-review-rating, .wsp-review-content)

### Changed
- Testimonial now uses 'wsp_testimonials' instead of 'bustr_tetsimonials' used by some custom themes before;
- moved Testimonial metabox to better visible 'side' and assigned 'high' priority;

### Fixed
- automatically generated testimonials no longer return error on 0 queried testimonials

## [1.2.0] - 2017-03-03
### Added
- 'SameAs' social network support;

### Changed
- rewritten code in a more usable fashion;
- rewritten json generation and organized code;

### Fixed
- Tetsimonial loop got a new reset;
- voided empty variables;


## [1] - 2017-02-01
### Added
### Changed
### Deprecated
### Removed
### Fixed
### Security
