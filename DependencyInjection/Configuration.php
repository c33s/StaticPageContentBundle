<?php
/**
 * This file is part of the C33s\StaticPageContentBundle.
 *
 * (c) consistency <office@consistency.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace C33s\StaticPageContentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        /* @var Symfony\Component\Config\Definition\Builder\NodeDefinition */
        $rootNode = $treeBuilder->root('c33s_static_page_content');

        $rootNode
            ->children()
                ->scalarNode('base_template')
                    ->defaultValue('::base.html.twig')
                    ->info('Template that the content wrapper template will extend from')
                ->end()
                ->scalarNode('template_extension')
                    ->defaultValue('.html.twig')
                    ->info('Template file name extension')
                ->end()
                ->scalarNode('content_dir')
                    ->defaultValue('Content')
                    ->info('Relative path from the views directory to a directory containing' . PHP_EOL .
                           'the page templates.')
                ->end()
                ->scalarNode('content_bundle')
                    ->defaultValue('C33sStaticPageContentBundle')
                    ->info('Bundle that holds the static pages')
                ->end()
                ->scalarNode('wrapper_template')
                    ->defaultValue('C33sStaticPageContentBundle:Content:_content_container.html.twig')
                    ->info('Template used to wrap your static pages')
                ->end()
                ->booleanNode('use_template_sandbox')
                    ->defaultFalse()
                    ->info('Should the pages use the twig sandbox extension?' . PHP_EOL .
                           '(http://twig.sensiolabs.org/doc/api.html#sandbox-extension)' . PHP_EOL .
                           'NOTE: it only works when using the default content template')
                ->end()
                ->booleanNode('prefer_locale_templates')
                    ->defaultFalse()
                    ->info('use templates for the requested locale if they exist. '. PHP_EOL .
                    'These templates should be placed in a folder named after the locale in the content directory.')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
