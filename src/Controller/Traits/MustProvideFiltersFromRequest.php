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

    private function extractFilters(Request $request, bool $terminateOnInvalidData = false): Collection
    {
        Assert::thatAll($this->filterFactory)
            ->notEmpty('Filter factory must be defined and accessible')
            ->isInstanceOf(FilterFactory::class, 'Filter factory must be of type FilterFactory');

        $input = $this->extractRequestInput($request, $terminateOnInvalidData);
        return $this->filterFactory->createFromArray($input);
    }

    private function extractRequestInput(Request $request, bool $terminateOnInvalidData = false): array
    {
        $data = $request->get('filter');
        $valid = is_array($data) && !empty($data);

        if (!$valid && $terminateOnInvalidData) {
            throw new \InvalidArgumentException('Filter data provided is invalid');
        }

        return $valid ? $data : [];
    }
}