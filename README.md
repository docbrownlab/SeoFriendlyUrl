# DocBrownLab Seo Friendly URL

Magento 2 module that normalizes product `url_key` generation before Magento creates the final slug.

The module adds a configurable conversion table in the Admin so the merchant can control how special characters are replaced, for example:

- `cancao-facil` from `Cancao Facil`
- `acao-social` from `Acao Social`
- `oleo-de-coco` from `Oleo de Coco`

Current admin path:

- `Stores > Configuration > Firjan > URL Amigavel`

Planned future path:

- `Stores > Configuration > DocBrownLab > Seo Friendly URL`

## Features

- Enables or disables the behavior per Magento configuration scope.
- Applies custom character replacement before the native Magento slug formatter runs.
- Keeps the native Magento URL sanitization flow intact.
- Allows the merchant to edit the conversion table in the Admin.
- Works with automatic `url_key` generation and manual `url_key` formatting for products.
- Does not require any Firjan module to be installed.

## Admin configuration

After installation, open:

- `Stores > Configuration > Firjan > URL Amigavel`

Available settings:

- `Habilitar modulo`: turns the behavior on or off.
- `Tabela de conversao`: lets the merchant define the source character and the replacement value.

Important behavior notes:

- The module affects product slugs when Magento formats the product `url_key`.
- Existing products are not rewritten retroactively just by installing the module.
- To apply a new mapping to existing products, the product needs to be saved again or updated by an import/process that regenerates the `url_key`.

## Installation options

### 1. Manual installation in `app/code`

Copy the module to:

```bash
app/code/DocBrownLab/SeoFriendlyUrl
```

Then run:

```bash
php bin/magento module:enable DocBrownLab_SeoFriendlyUrl
php bin/magento setup:upgrade
php bin/magento cache:flush
```

Recommended in production mode:

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

### 2. Composer installation from a private Composer repository

Add the repository:

```bash
composer config repositories.docbrownlab composer https://your-private-repository.example
```

Require the package:

```bash
composer require docbrownlab/module-seo-friendly-url
```

Then run:

```bash
php bin/magento module:enable DocBrownLab_SeoFriendlyUrl
php bin/magento setup:upgrade
php bin/magento cache:flush
```

### 3. Composer installation from a local path or extracted package

If the commercial package is delivered as a local folder or extracted ZIP, add a `path` repository:

```bash
composer config repositories.docbrownlab-seo-friendly-url path packages/DocBrownLab/SeoFriendlyUrl
composer require docbrownlab/module-seo-friendly-url:*
```

Then run:

```bash
php bin/magento module:enable DocBrownLab_SeoFriendlyUrl
php bin/magento setup:upgrade
php bin/magento cache:flush
```

## Package structure

```text
DocBrownLab/SeoFriendlyUrl
|-- Block/
|-- Model/
|-- Plugin/
|-- etc/
|-- composer.json
|-- registration.php
`-- README.md
```

## Technical design

- The module uses a plugin on `Magento\Catalog\Model\Product::formatUrlKey()`.
- Custom replacements are applied first.
- Magento native transliteration and slug cleanup still run afterwards.
- The implementation avoids a class preference and stays aligned with Magento extension best practices.

## Compatibility

- Adobe Commerce / Magento Open Source 2.4.7 line
- PHP 8.1, 8.2 or 8.3

## Support

For package customization, store-specific mapping definitions or distribution adjustments, keep the module namespace and package name unchanged to preserve upgrade compatibility.
