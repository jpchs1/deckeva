# Session 9 Fixes: Footer Contact Centering + Menu Consistency

## Date: 2026-02-28

## Issue 1: Footer Contact Section Not Centered on Mobile
**Problem:** The contact items (phone, email, address) in the footer were not properly centered on mobile/responsive view (max-width 767px).

**Root Causes (multiple):**
1. Previous CSS had a syntax error (57 open braces vs 58 close braces) preventing all rules from applying
2. The `.elementor-widget-wrap` in the contact column had asymmetric padding (`padding-left: 80px; padding-right: 0px`) shifting content off-center
3. Elementor kept regenerating a cached CSS file (`post-8825.css`) that overrode custom CSS

**Fix Applied (Database - post 9850):**
- Completely rewrote footer CSS from scratch with clean brace matching (14 open, 14 close)
- Fixed asymmetric padding: set `padding-left: 10px; padding-right: 10px` on all `.elementor-widget-wrap` elements
- Centered footer columns: `flex-direction: column; align-items: center` on `.elementor-container`
- Centered icon-box widgets: container uses `display: flex; justify-content: center; align-items: center`
- Icon-box wrapper uses `display: inline-flex; width: auto` to shrink-wrap around icon+text
- Icon spacing: `margin-right: 10px; flex-shrink: 0` on icon element
- Centered headings, nav menu, text editor, image, and button widgets
- Set Elementor CSS print method to 'internal' to prevent file-based caching
- Deleted ALL Elementor cached CSS files from uploads directory
- Cleared Elementor CSS meta for post 8825 and all transients

## Issue 2: Menu Inconsistency Across Pages
**Problem:** The header and footer menus were showing only 2 items (Proyectos, Blog) on some pages instead of the full 6-item menu (Caracteristicas, Como trabajamos, Testimonios, Precio, Proyectos, Blog).

**Root Cause:** The WordPress 'principal' menu (term_id=203) only contained 4 anchor-link items plus 2 empty items. "Proyectos" and "Blog" were missing from the menu. Header template 8832 had no menu setting, defaulting to page list.

**Fix Applied (Database):**
1. Added "Proyectos" (https://deckeva.cl/proyectos/) as menu item ID 9901 to 'principal' menu
2. Added "Blog" (https://deckeva.cl/blog/) as menu item ID 9902 to 'principal' menu
3. Removed 2 empty/orphan menu items (IDs 9726, 8955) from principal menu
4. Updated header template 8832's nav-menu widget to explicitly use 'principal' menu
5. Cleared Elementor caches for headers 8830 and 8832
6. Deleted cached CSS files for both headers
7. Cleared all Elementor transients

## Issue 3: Black Background on Right Side of Page
**Problem:** After CSS cache operations, the site showed a black area on the right side of the viewport, especially visible on mobile devices.

**Root Cause:** Elements (particularly the Elementor nav menu dropdown) extended beyond the viewport width, causing horizontal overflow. The browser rendered the overflow area as black.

**Fix Applied (WordPress Customizer - CSS adicional):**
- Added `overflow-x: hidden !important` on `html, body` to prevent horizontal scrollbar
- Added `max-width: 100vw !important` on `html, body` to constrain content to viewport
- Used Elementor Tools > "Vaciar archivos y datos" to regenerate all CSS files properly
- Applied footer centering CSS via WordPress Customizer API (`wp.customize('custom_css[streamlab]').set()`)

## Issue 4: Menu Items Not Rendering After Cache Regeneration
**Problem:** After Elementor CSS regeneration, the header/footer menus only showed 2 items (Proyectos, Blog) instead of all 6.

**Fix Applied:**
- Re-saved the "principal" menu (term_id=203) in WP Admin > Appearance > Menus
- Verified all 6 items present and correctly ordered
- Elementor CSS regeneration via official Tools button resolved rendering

## Verification
- Home page (https://deckeva.cl/): Header shows 6 menu items, footer shows 6 menu items, contact section centered
- Desktop view: No black background, full-width content, 3-column footer layout
- Mobile view (410px): No horizontal overflow (scrollWidth = viewport width), footer stacked and centered
- Footer contact items (phone, email, address) centered with icons on mobile
- CSS applied via WordPress Customizer persists across cache regenerations
- All changes applied directly to the live database and WordPress Customizer
