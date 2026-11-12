# Bright Cloud Studio's Isotope List Products Variants

A Contao content element that lists the Isotope products assigned to the current
page, each with its child variants' dimensions shown in both inches and
millimeters.

**This package is client-specific.** It is built around a product setup that uses
the custom Isotope attributes `bristle_type`, `wp_size`, `length` and `width`. It
will not do anything useful on a shop without those attributes.

## Requirements

- PHP 8.3 or newer
- Contao 5.7.4 or newer
- Isotope 3.0.0-RC1 or newer

PHP 8.3 is a floor set by Isotope 3.0 itself, which is why this package does not
support 8.2.

## Installation

```
composer require bright-cloud-studio/isotope-list-products-variants
```

## Usage

Add the **Show Variants** content element (under the *Isotope* group) to a page
that has Isotope products assigned to it, then choose which **product types**
count as variant parents.

The element renders nothing at all when the page has no matching products, so it
is safe to place on a shared layout.

For each parent product it outputs the first image, the name, the `bristle_type`
option label, a comma-separated size list, and a Dimensions block holding an
inches table and a millimeters table built from the published child variants
(sorted by width, then length). The size list is derived from the child variants
themselves, so it cannot drift from the products that actually exist.

### Toggling the dimensions block

The dimensions block ships as `hidden` with a `<button>` carrying
`aria-expanded` and `aria-controls`, and the template ships the small script
that toggles it. Nothing needs wiring up on the site.

The script is delegated from the document and guarded, so placing several of
these elements on one page is safe. It slides the block open and shut over
300ms by animating its height, which is what the 4.13 version got from jQuery
UI's blind effect - but without jQuery or jQuery UI.

### Overriding the template

Put your own `content_element/show_variants.html.twig` in the project's
`templates/` directory, or select a custom template on the element itself.

## Upgrading from the Contao 4.13 version

The 4.13 package did the same job twice: through `{{variants::}}` insert tags and
through a `mod_show_variants` front end module. **Only the module survives**, now
as a content element. These were dropped:

- the `replaceInsertTags` hook and all five `{{variants*}}` tags
- the `item_variant*` templates
- the `iso_list_products_variants` front end module, whose class was empty
- `SizeConversion`, which was unreachable, and a fully commented-out
  `tl_iso_product.php`

Two things changed because Isotope 3.0 required it:

- Products are now found through `tl_iso_product_category`. Isotope's own
  migration drops `tl_iso_product.orderPages`, which the old module queried.
  A side effect is that the manual product ordering is now honoured, where the
  old query sorted by name.
- The product type is a setting on the element instead of a hardcoded `type = 2`,
  because type IDs are not guaranteed to survive the migration.

## License

MIT — see [LICENSE](LICENSE).
