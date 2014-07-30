<?php
/**
 * This file is part of the c33s\StaticPageContentBundle.
 *
 * (c) consistency <office@consistency.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace c33s\StaticPageContentBundle\Tests\DependencyInjection;

use c33s\StaticPageContentBundle\DependencyInjection\Extension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class ExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions()
    {
        return array(new Extension());
    }

    /**
     * @test
     */
    public function itSetsDefaultParameters()
    {
        $this->load();

        $this->assertContainerBuilderHasParameter(
            'c33s_static_page_content.content_bundle',
            'c33sStaticPageContentBundle'
        );
    }

    /**
     * @test
     */
    public function itCanChangeParameters()
    {
        $config = array('content_dir' => 'pages');
        $this->load($config);

        $this->assertContainerBuilderHasParameter(
            'c33s_static_page_content.content_dir',
            'pages'
        );
    }
}
