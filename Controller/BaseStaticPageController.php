<?php

namespace c33s\StaticPageContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


/*
 * uses twig as template engine
 */
class BaseStaticPageController extends Controller
{
    /*
     * returns the name of the bundle, where the twig templates with the static 
     * content are stored
     */
    protected function getContentBundleName()
    {
        return 'c33sStaticPageContentBundle';
    }
    /*
     * has to be located in %BundleName%/Resources/views
     * Folder must be located in $bundle/Resources/views
     */
    protected function getContentFolder()
    {
        return 'Content';
    }
    protected function getContentLocation($contentName)
    {
        return sprintf
        (
            '%s:%s:%s%s', 
            $this->getContentBundleName(), 
            $this->getContentFolder(), 
            $contentName, 
            $this->getTemplateExtension()
        );
    }
    protected function getTemplateExtension()
    {
        return '.html.twig';
    }
    
    protected function getContainerLocation()
    {
        return 'c33sStaticPageContentBundle:Content:_content_container.html.twig';
    }
    
    protected function getBaseTemplateLocation()
    {
        return '::base.html.twig';
    }
    
    /**
     * @Route("/{name}", name="_page")
     * @Template()
     */
    public function showAction($name)
    {
        $contentLocation = $this->getContentLocation($name);
        
        if (!$this->container->get('templating')->exists($contentLocation))
        {
            throw $this->createNotFoundException();
        }
        return $this->render($this->getContainerLocation() ,
            array
            (
                'baseTemplate' => $this->getBaseTemplateLocation(), 
                'contentLocation'=> $contentLocation
            )
        );
    }
}
