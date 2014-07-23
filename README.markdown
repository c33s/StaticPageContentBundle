[![Latest Stable Version](https://poser.pugx.org/c33s/static-page-content-bundle/v/stable.png)](https://packagist.org/packages/c33s/static-page-content-bundle) [![License](https://poser.pugx.org/c33s/static-page-content-bundle/license.png)](https://packagist.org/packages/c33s/static-page-content-bundle) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/7187788e-a842-4ee6-a2e0-58f4c2809f14/mini.png)](https://insight.sensiolabs.com/projects/7187788e-a842-4ee6-a2e0-58f4c2809f14)
[![project status](http://stillmaintained.com/c33s/StaticPageContentBundle.png)](http://stillmaintained.com/c33s/StaticPageContentBundle)


Provide an easy way to serve static page content in your Symfony2 Projects with
Twig.

## INSTALLATION

`php composer.phar require c33s/static-page-content-bundle`

## HOW IT WORKS

This Bundle is just a small twig template wrapper. The "core" is the template
``_content_container.html.twig`` which extends a predefined base template. the 
default one is ``::base.html.twig``. If no base template is defined, nothing will
be extended.
Afterwards the content is loaded from the provided content file, in a block 
named "content". The content files don't need any includes or extends only the 
real content has to be inside.

The Bundle uses a very catchy route ``/{name}``, so it should be placed at the end of your
routing file.

if ``{name}`` is catched the controller tries to load the content file with the
given name.

## USAGE
After the installation, you have to create your own bundle, where you change the
controller that it extends c33s\BaseStaticPageController.

YourVendorName/YourBundleNameBundle/Controller/YourControllerName.php
```
<?php
namespace YourVendorName\YourBundleNameBundle\Controller;
use c33s\StaticPageContentBundle\Controller\BaseStaticPageController;

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
```
static_pages:
    pattern:  /{name}
    defaults: { _controller: "YourVendorNameYourBundleNameBundle:Page:show" }
```

put your content files here:
```
YourVendorName/YourBundleNameBundle/Resources/views/Content/
```

using static files with folders:
```
static_pages_subfolder:
    pattern:  /{subfolder}/{name}
    defaults: { _controller: "YourVendorNameYourBundleNameBundle:Page:show" }
```

your files can be located in the first level subfolder of the Content directory:
```
YourVendorName/YourBundleNameBundle/Resources/views/Content/YourSubFolder
```

```
http://example.com/aboutus/team
``` 
will look for a template in 

```
YourVendorName/YourBundleNameBundle/Resources/views/Content/aboutus/team.html.twig
```


## CUSTOMIZATION
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





