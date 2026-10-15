=== TargetWeb Summit ===
Author: TargetWeb
Author URI: https://www.idealcomputersystems.com/targetweb
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
License: GPLv2 or later

A dark, bold, condensed-type standalone WordPress theme for commercial
outdoor power equipment dealers — no parent theme, no page builder, no
plugin dependency.

== Installation ==
1. Go to Appearance > Themes > Add New > Upload Theme in wp-admin and upload
   targetweb3-theme.zip. Activate it. On activation the theme automatically
   sets the homepage, creates About Us / Support / Blog pages, adds 3 sample
   blog posts, and creates + assigns the Primary Menu and the footer
   Equipment menu. The site is fully browsable immediately.
2. Go to Appearance > Customize > "⚙ TargetWeb Summit Theme Options." Everything
   is editable there:
     - ↕ Homepage Section Order — reorder or hide any of the 7 homepage
       sections
     - Colors — 10 color pickers for the whole dark/light palette
     - Header, Hero, Section Titles
     - 🧩 Equipment Categories — add/remove/reorder cards. Each card opens
       a popup on click; edit that popup's photo, description, and button
       right here, per category, no code required.
     - 🧩 Brand Wall — add/remove/reorder brand names, optionally upload a
       logo per brand to replace the plain text name
     - 🧩 Why Choose Us Tiles — add/remove/reorder feature tiles
     - Quote Form — edit the "Equipment Needed" and "Budget Range" dropdown
       options directly (one per line), plus the form's destination email
     - Mini Trust Row, CTA Banner, Contact Info, Footer
3. Add real photos: click "Upload" on any photo field (hero, category
   cards, quote section, CTA banner) — it opens the normal WordPress media
   library. Until you do, each image slot shows original placeholder
   artwork (no stock photography, so no licensing risk).
4. If you ever want to start over, Appearance > TargetWeb Summit Setup has
   buttons to re-create demo pages/menus, reset all text/color/image
   settings, or reset just the content blocks (Categories/Brands/Why Us).

== Category popups ==
Clicking any Equipment Category card opens a modal with that category's
photo, description, and a call-to-action button — instead of navigating
away. All of that content is edited per-category inside the Customizer's
Equipment Categories repeater (fields: Card Photo, Corner Icon, Popup
Description, Popup Button Text, Popup Button Link). No code, no plugin.

== What's included ==
- Full Customizer panel covering colors, header, hero, section titles,
  quote form dropdowns, mini trust row, CTA banner, contact info, footer.
- ↕ Homepage Section Order — reorder/hide any section.
- 3 repeater blocks (Categories with popups, Brands, Why Choose Us) built
  on a reusable custom Customizer control — add/remove/reorder rows with
  image uploads and icon pickers (including a "None" option), no ACF, no
  page builder, no custom post types.
- Original placeholder artwork (assets/images/) for hero, categories,
  quote section, and CTA banner — all hand-built SVG, not stock photos.
- On activation: homepage, About Us / Support / Blog pages, 3 sample blog
  posts, Primary Menu, and footer Equipment menu are all created and
  assigned automatically.
- A working "Request Quote" form that emails the address set in the Quote
  Form Customizer section (or falls back to your WP admin email).
- A single centralized defaults file (inc/field-defaults.php) used by both
  the Customizer and every front-end template, so no field can ever show
  blank on a fresh install.
- Fully responsive layout, mobile nav, and a click-to-open category popup
  modal — all in vanilla JS, no jQuery.
