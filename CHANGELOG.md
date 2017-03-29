# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## ToDo
- core
  - create Schema Person for one and/or more attorneys for even better Google™ Rich Snippets;
  - optimize js code, search for security issues;
  - clean uninstall;
  - create multiple department support with dynamic settings subpage;
  - create shortcodes for every department;
  - new shortcode to call settings elements (addresses, phone numbers etc);
  - new shortcode to display either all or individual social network profiles;
- testimonial shortcode
  - allow display single testimonial by id;
- JSONLD for menu items (must sort out ID uniqueness problem);

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
