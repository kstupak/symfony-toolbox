<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Toolbox\Service\Filter\FilterFactory;

final class RegisterFilters implements CompilerPassInterface
{
    const CONTAINER_TAG = 'filter.definition';

    public function process(ContainerBuilder $container)
    {
        $service = $container->getDefinition(FilterFactory::class);
        $filters = $container->findTaggedServiceIds(self::CONTAINER_TAG);

        foreach ($filters as $id => $definition) {
            $service->addMethodCall('registerFilterType', [new Reference($id)]);
        }
    }
}