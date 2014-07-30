<?php
/**
 * This file is part of the c33s\StaticPageContentBundle.
 *
 * (c) consistency <office@consistency.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace c33s\StaticPageContentBundle;

use c33s\StaticPageContentBundle\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class c33sStaticPageContentBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new Extension();
    }
}
