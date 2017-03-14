# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

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
