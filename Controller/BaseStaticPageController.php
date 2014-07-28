<?php
/**
 * This file is part of the c33s\StaticPageContentBundle.
 *
 * (c) consistency <office@consistency.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace c33s\StaticPageContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/*
 * BaseStaticPageController which should be extended from.
 *
 * Usage: MyPageController extends BaseStaticPageController
 *
 *
 * @author consistency <office@consistency.at>
 */
class BaseStaticPageController extends Controller
{
    /**
     * Returns the name of the Bundle, where the templates, which are
     * containing the static content, are stored
     *
     * @return string Name of the Content Bundle
     */
    protected function getContentBundleName()
    {
        return $this->container->getParameter('c33s_static_pages.content_bundle');
    }

    /**
     * Returns the name of the folder where the content templates are stored.
     *
     * This folder has to be located in %YourBundleName%/Resources/views
     * The default path is c33s/StaticPageContentBundle/Resources/views/Content
     * so the default return value is "Content".
     *
     * @return string Name of the folder containing the Content
     */
    protected function getContentFolderName()
    {
        return $this->container->getParameter('c33s_static_pages.content_dir');
    }

    /**
     * Should the Static content be sandboxed?
     *
     * Only works for the default Content Container
     *
     * http://twig.sensiolabs.org/doc/api.html#sandbox-extension
     *
     * @return bool
     */
    protected function isSandboxed()
    {
        return $this->container->getParameter('c33s_static_pages.use_template_sandbox');
    }

    /**
     * Returns the full template "path" expression for a given content name.
     * Currently only twig is implemented. The Expression includes the ":"
     * seperators.
     * It's not the Filesystem path it's a twig path.
     *
     * @param  string $contentName The name of the content file which should be loaded
     * @return string Full path expression for the template
     */
    protected function getContentLocation($contentName, $subfolder = "")
    {
        if (!empty($subfolder)) {
            $subfolder .= "/";
        }

        return sprintf
        (
            '%s:%s:%s%s%s%s',
            $this->getContentBundleName(),
            $this->getContentFolderName(),
            $subfolder,
            $contentName,
            $this->getTranslationFilePath(),
            $this->getTemplateExtension()
        );
    }

    /**
     * Returns template extension. Default is ".html.twig".
     *
     * @return string Template Extension (dual extension) like ".html.twig"
     */
    protected function getTemplateExtension()
    {
        return $this->container->getParameter('c33s_static_pages.template_extension');
    }

    /**
     * Returns the full "path" expression for the Container Template
     *
     * @return string container template "path" expression
     */
    protected function getContainerLocation()
    {
        return $this->container->getParameter('c33s_static_pages.wrapper_template');
    }

    /**
     *  Returns the Base Template Location which should be used for extending.
     *
     * @return string Base Template which should be used to extend from
     *
     */
    protected function getBaseTemplateLocation()
    {
        return $this->container->getParameter('c33s_static_pages.base_template');
    }

    /**
     * The Core Show Controller of this Bundle, renders the container templates,
     * which have to include the static page content.
     *
     * @param string The Name of the Static Page which should be loaded
     *
     * @return Response                                                     A Response instance
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException Not found Exception is thrown if no template with the given name exists.
     */
    public function showAction($name, $subfolder="")
    {
        $contentLocation = $this->getContentLocation($name, $subfolder);

        if (!$this->container->get('templating')->exists($contentLocation)) {
            throw $this->createNotFoundException();
        }

        return $this->render($this->getContainerLocation() ,
            array
            (
                'baseTemplate' => $this->getBaseTemplateLocation(),
                //--'isSandboxed' => $this->isSandboxed(),
                'contentLocation'=> $contentLocation,
                'contentName' => $name,
            )
        );
    }

    /**
     * Define if translated files should be used or not. Translated files use an additional folder in the template path.
     * e.g.: views/Content/de/foo.html.twig instead of views/Content/foo.html.twig
     *
     * @TODO: make this a service setting
     *
     * Override this and return true to enable translations support
     *
     * @return boolean
     */
    public function isUsingTranslations()
    {
        return $this->container->getParameter('c33s_static_pages.prefer_locale_templates');
    }

    /**
     * Get the intermediate folder used for translated templates if translations are enabled.
     *
     * @return string
     */
    protected function getTranslationFolder()
    {
        if ($this->isUsingTranslations()) {
            return $this->get('request')->getLocale().'/';
        }

        return '';
    }

    /**
     * Get the intermediate file path used for translated templates if translations are enabled.
     *
     * @return string
     */
    protected function getTranslationFilePath()
    {
        if ($this->isUsingTranslations()) {
            return '.' . $this->get('request')->getLocale();
        }

        return '';
    }
}
