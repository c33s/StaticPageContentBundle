<?php
/**
 * This file is part of the C33s\StaticPageContentBundle.
 *
 * (c) consistency <office@consistency.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace C33s\StaticPageContentBundle;

use C33s\StaticPageContentBundle\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class C33sStaticPageContentBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new Extension();
    }
}
