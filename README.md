# Magento 2 Module - Force Complete Orders

![https://www.augustash.com](http://augustash.s3.amazonaws.com/logos/ash-inline-color-500.png)

**This is a private module and is not currently aimed at public consumption.**

## Overview

This is a simple module to expose a mass action to the admin sales order grid. It allows sales orders to forcibly be set to a "Complete" status. This is generally important when a one-way integration is in place where order updates are not directly communicated back to Magento.

## Installation

### Via Composer

Install the extension using Composer using our development package repository:

```bash
composer config repositories.augustash composer https://augustash.repo.repman.io
composer require augustash/module-force-complete:~2.0.0
bin/magento module:enable --clear-static-content Augustash_ForceComplete
bin/magento setup:upgrade
bin/magento cache:flush
```

## Uninstall

After all dependent modules have also been disabled or uninstalled, you can finally remove this module:

```bash
bin/magento module:disable --clear-static-content Augustash_ForceComplete
rm -rf app/code/Augustash/ForceComplete/
composer remove augustash/module-force-complete
bin/magento setup:upgrade
bin/magento cache:flush
```

## Structure

[Typical file structure for a Magento 2 module](http://devdocs.magento.com/guides/v2.4/extension-dev-guide/build/module-file-structure.html).
