ImageMapPro zoom UI regression
=============================

Run from the repository root:
node --test wp-content\plugins\image-map-pro-wordpress\tests\zoom-ui.test.cjs

The test extracts the zoom controller's insertUI method from the production
bundle. It covers zooming and button visibility independently, as well as
both button placements. Hidden buttons must not be accessed or inserted.
This corrects a 6.0.5 bug that aborts initialization before mapInit when
zooming is enabled and zoom buttons are disabled.

The shortcode script version uses the bundle's modification time. Purge
cached pages/CDN content after deployment to refresh the script URL.
Reapply or verify this fix when updating the upstream plugin.
