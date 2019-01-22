<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Controller\Traits;


use Assert\Assert;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;
use Toolbox\Service\Filter\FilterFactory;

trait MustProvideFiltersFromRequest
{
    /** @var FilterFactory */
    private $filterFactory;

    private function extractFilters(Request $request): Collection
    {
        Assert::thatAll($this->filterFactory)
            ->notEmpty('Filter factory must be defined and accessible')
            ->isInstanceOf(FilterFactory::class, 'Filter factory must be of type FilterFactory');

        return $this->filterFactory->createFromRequestData($request->query->all());
    }
}