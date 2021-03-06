<?php
/**
 * This file is part of the C33s\StaticPageContentBundle.
 *
 * (c) consistency <office@consistency.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace C33s\StaticPageContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
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
        return $this->container->getParameter('c33s_static_page_content.content_bundle');
    }

    /**
     * Returns the name of the folder where the content templates are stored.
     *
     * This folder has to be located in %YourBundleName%/Resources/views
     * The default path is C33s/StaticPageContentBundle/Resources/views/Content
     * so the default return value is "Content".
     *
     * @return string Name of the folder containing the Content
     */
    protected function getContentFolderName()
    {
        return $this->container->getParameter('c33s_static_page_content.content_dir');
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
        return $this->container->getParameter('c33s_static_page_content.use_template_sandbox');
    }

    /**
     * Returns the full template "path" expression for a given content name.
     * Currently only twig is implemented. The Expression includes the ":"
     * seperators.
     * It's not the Filesystem path it's a twig path.
     *
     * @param string    $contentName        The name of the content file which should be loaded
     * @param boolean   $useTranslations    Whether to add translation component to file path or not
     *
     * @return string Full path expression for the template
     */
    protected function getContentLocation($contentName, $useTranslations)
    {
        return sprintf
        (
            '%s:%s:%s%s%s',
            $this->getContentBundleName(),
            $this->getContentFolderName(),
            $contentName,
            $useTranslations ? $this->getTranslationFilePath() : '',
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
        return $this->container->getParameter('c33s_static_page_content.template_extension');
    }

    /**
     * Returns the full "path" expression for the Container Template
     *
     * @return string container template "path" expression
     */
    protected function getContainerLocation()
    {
        return $this->container->getParameter('c33s_static_page_content.wrapper_template');
    }

    /**
     *  Returns the Base Template Location which should be used for extending.
     *
     * @return string Base Template which should be used to extend from
     *
     */
    protected function getBaseTemplateLocation()
    {
        return $this->container->getParameter('c33s_static_page_content.base_template');
    }

    /**
     * The Core Show Controller of this Bundle, renders the container templates,
     * which have to include the static page content.
     *
     * @throws Symfony\Component\HttpKernel\Exception\NotFoundHttpException     Not found Exception is thrown if no template with the given name exists.
     *
     * @param string    $name   The Name of the Static Page which should be loaded
     *
     * @return Response         A Response instance
     */
    public function showAction($name)
    {
        $contentLocation = $this->getContentLocation($name, $this->isUsingTranslations());

        if (!$this->container->get('templating')->exists($contentLocation) && $this->isUsingTranslations()) {
            // fallback: if translations are enabled, try fetching the same template without translation path
            $contentLocation = $this->getContentLocation($name, false);
        }

        if (!$this->container->get('templating')->exists($contentLocation)) {
            throw $this->createNotFoundException();
        }

        return $this->render($this->getContainerLocation(), array(
                'baseTemplate' => $this->getBaseTemplateLocation(),
                'isSandboxed' => $this->isSandboxed(),
                'contentLocation'=> $contentLocation,
                'contentName' => $name,
            )
        );
    }

    /**
     * Define if translated files should be used or not. Translated files use an additional substring in the template path.
     * e.g.: views/Content/foo.de.html.twig instead of views/Content/foo.html.twig
     *
     * Override this and return true to enable translations support
     *
     * @return boolean
     */
    protected function isUsingTranslations()
    {
        return $this->container->getParameter('c33s_static_page_content.prefer_locale_templates');
    }

    /**
     * Get the intermediate file path used for translated templates.
     *
     * @return string
     */
    protected function getTranslationFilePath()
    {
        return '.' . $this->get('request')->getLocale();
    }
}
