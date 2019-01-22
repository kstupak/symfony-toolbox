<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Service\Filter;


use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Toolbox\Model\Filter\FilterInterface;

final class FilterFactory
{
    private $classMap = [];

    public function registerFilterType(FilterInterface $filter)
    {
        $this->classMap[$filter::getName()] = get_class($filter);
    }

    public function getFilterClassForType(string $type): string
    {
        Assertion::keyExists($this->classMap, $type, sprintf('Unknown filter type requested: "%s"', $type));
        return $this->classMap[$type];
    }

    public function createFromRequestData(array $requestData): Collection
    {
        $collection = new ArrayCollection();
        foreach ($requestData as $type => $value) {
            $filterClass = $this->getFilterClassForType($type);

            $filter = call_user_func([$filterClass, 'createForValue'], $value);
            $collection->set($type, $filter);
        }

        return $collection;
    }
}