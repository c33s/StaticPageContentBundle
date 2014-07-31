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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class Extension extends ConfigurableExtension
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $fileLocator = new FileLocator(__DIR__.'/../Resources/config');
        $loader = new XmlFileLoader($container, $fileLocator);
        $loader->load('services.xml');

        foreach($mergedConfig as $name => $value) {
            $container->setParameter($this->getAlias() . '.' . $name, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'c33s_static_page_content';
    }
}

