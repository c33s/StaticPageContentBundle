<?php
/*
* This file is part of the C33s\StaticPageContentBundle.
*
* (c) consistency <office@consistency.at>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace C33s\StaticPageContentBundle\Tests\DependencyInjection;

use C33s\StaticPageContentBundle\DependencyInjection\Configuration;
use Matthias\SymfonyConfigTest\PhpUnit\AbstractConfigurationTestCase;

class ConfigurationTest extends AbstractConfigurationTestCase
{
    protected function getConfiguration()
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function itSetsDefaultConfiguration()
    {
        $this->assertProcessedConfigurationEquals(array(
            array()
        ), array(
            'base_template' => '::base.html.twig',
            'content_bundle' => 'C33sStaticPageContentBundle',
            'content_dir' => 'Content',
            'wrapper_template' => 'C33sStaticPageContentBundle::layout.html.twig',
            'template_extension' => '.html.twig',
            'use_template_sandbox' => false,
            'prefer_locale_templates' => false
        ));
    }
}

