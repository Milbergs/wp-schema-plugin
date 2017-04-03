# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## ToDo
- core
  - optimize js code, search for security issues;
  - clean uninstall;
  - update notify;
  - create multiple department support with dynamic settings subpage;
  - create shortcodes for every department;
- would be awesome:
  - detect existing Testimonial post types, assign star rating system in the editor and use existing Testimonial data;

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
