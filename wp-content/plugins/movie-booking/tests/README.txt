Cart state regression tests
===========================

From the repository root, run:
node --test wp-content\plugins\movie-booking\tests\cart-state.test.cjs

The frontend bundle contains its editable source in an inline source map.
The tests extract the CART implementation from that source and exercise
duplicate selections, existing extra services and area quantities, recovery
of saved null entries, removal, and reload persistence without WordPress.

When changing the bundle, update the embedded source and regenerate both
the executable code and inline source map together. With the extracted
source named script.js, run from the frontend asset directory:
npm exec --yes --package=terser -- terser script.js --compress --mangle --source-map "filename='script.min.js',url='inline',includeSources" --output script.min.js

The frontend asset version uses its modification time to invalidate cached
JavaScript. After deployment, also purge page/CDN caches so cached HTML
references the new asset version. Saved valid selections are preserved;
null entries created by the old duplicate-selection bug are removed at
cart initialization, persisted immediately, and reported via console.warn.
If ImageMapPro does not deliver mapInit, the first object click initializes
the sidebar before processing the selection and logs a warning. This keeps
the seat list and totals functional without suppressing ImageMapPro errors.
