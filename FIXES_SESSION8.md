# Session 8: Center Footer on Mobile/Responsive View

## Issue
Footer content was left-aligned on mobile/responsive view (max-width: 767px), making it look unbalanced on smaller screens.

## Fix Applied
Added responsive CSS to WordPress custom CSS post (ID 9850, streamlab theme) via `@media (max-width: 767px)` media query.

### CSS Selectors Targeted
- `.elementor-8825 .elementor-column .elementor-widget-wrap` — Centers all column widget wraps
- `.elementor-8825 .elementor-widget-image .elementor-widget-container` — Centers logo image
- `.elementor-8825 .elementor-widget-text-editor .elementor-widget-container` — Centers description text
- `.elementor-8825 .elementor-widget-html .elementor-widget-container` — Centers Imporlan button with flex
- `.elementor-8825 .imporlan-footer-link` — Auto margins for button centering
- `.elementor-8825 .elementor-heading-title` — Centers "Menú" and "Contacto" headings
- `.elementor-8825 .elementor-nav-menu--main` — Centers nav menu with flex column layout
- `.elementor-8825 .elementor-nav-menu li` / `li a` — Centers individual menu items
- `.elementor-8825 .elementor-widget-icon-box .elementor-icon-box-wrapper` — Centers icon-box contact items (phone, email, address)
- `.elementor-8825 .elementor-position-inline-start .elementor-icon-box-wrapper` — Overrides inline-start position on mobile
- `.elementor-8825 .elementor-divider-separator` — Centers divider with auto margins
- Copyright footer text — Centers via multiple fallback selectors

### Key Details
- **Footer Elementor ID**: 8825
- **Custom CSS Post ID**: 9850 (streamlab theme)
- **Breakpoint**: max-width 767px
- **Method**: CSS injected into `wp_posts` table (post_type='custom_css')
- **Contact section**: Uses `elementor-widget-icon-box` with `elementor-icon-box-wrapper` (not icon-list)

## Verification
- Tested on mobile viewport (375px width)
- All footer sections centered: logo, description, button, menu, contact info
- Desktop view (>768px) unchanged
