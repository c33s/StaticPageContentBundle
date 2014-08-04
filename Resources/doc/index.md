# StaticPageContentBundle
* [Installation](#installation)
* [How It Works](#how-it-works)
* [Usage](#usage)
    * [Using static files with folders](#using-static-files-with-folders)
    * [Localized templates](#localized-templates)
* [Customization](#customization)

## Installation

Require [`c33s/static-page-content-bundle`][link_packagist] to your `composer.json` file:

manually: 
```json
{
    "require": {
        "c33s/static-page-content-bundle": "@stable"
    }
}
```
by using composer:

	php composer.phar require c33s/static-page-content-bundle @stable

you can get the same result

**Protip:** you should browse the [`c33s/static-page-content-bundle`][link_packagist] page to choose a stable version to use, avoid the `@stable` meta constraint.

Register the bundle in `app/AppKernel.php`:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new c33s\StaticPageContentBundle\c33sStaticPageContentBundle(),
    );
}
```

## How It Works

This Bundle is just a small twig template wrapper. The "core" is the template
`layout.html.twig` which extends a predefined base template. the 
default one is `::base.html.twig`. If the base template name is empty (or false),
the  template wrapper will extend `@C33sStaticPageContent::empty.html.twig` which
simply outputs the content block.

Afterwards the content is loaded from the provided content file, in a block 
named "content". The content files don't need any includes or extends only the 
real content has to be inside.

The Bundle uses a very catchy route `/{name}`, so it should be placed at the end of your
routing file.

if `{name}` is caught the controller tries to load the content file with the
given name.

## Usage
After the installation, you have to create your own bundle, where you change the
controller that it extends C33s\BaseStaticPageController.

YourVendorName/YourBundle/Controller/YourControllerName.php
```php
<?php
namespace YourVendorName\YourBundle\Controller;
use C33s\StaticPageContentBundle\Controller\BaseStaticPageController;

class PageController extends BaseStaticPageController
{
    protected function getContentBundleName()
    {
        return 'YourVendorNameYourBundleName';
    }
}
?>
```

add a routing like this to the end of your routing file (in config/routing you can
find the routing code you can use).
```yml
static_pages:
    path:  /{name}
    defaults: { _controller: "YourVendorNameYourBundle:Page:show" }
```

put your content files here:
```
YourVendorName/YourBundle/Resources/views/Content/
```

### Using static files with folders:

```yml
static_pages:
    path:  /{name}
    defaults: { _controller: "YourVendorNameYourBundle:Page:show" }
    requirements:
        # this makes the name parameter accept anything, even slashes
        name:  .*
```

```
http://example.com/about-us/team
```
will look for a template in

```
YourVendorName/YourBundle/Resources/views/Content/about-us/team.html.twig
```

### Localized templates

You can enable support for localized templates by either overriding the `isUsingTranslations()` method in your controller
(returning true) or setting the configuration value:

```yml
#config.yml

c33s_static_page_content:
    prefer_locale_templates:    true
```
Either way the controller will try to add the current locale to the template path:

```
about-us/team.en.html.twig
vs.
about-us/team.html.twig
```

If no localized version is found, the non-localized template will be used as fallback (if available)

## Customization
If you want customize the bundles behavior, you have to overwrite the following 
functions:

Most of the time you only change the first of the following four functions to your 
own bundle name.

```
getContentBundleName() The Name which contains all the content
getContentFolderName() The Subfolder of the view folder which holds the content
getContainerLocation() Full Twig Path expression to the Container Location
getBaseTemplateLocation() Full Twig Path expression to the Base Template
```

[link_packagist]:          https://packagist.org/packages/c33s/static-page-content-bundle
