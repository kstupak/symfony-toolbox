<?php
/*
 * This file is part of "symfony-toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Model\Behaviour;


use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait HasMetadata
{
    /** @var Collection */
    private $metadata;

    public function getMetadata(string $key)
    {
        Assertion::true($this->metadata->containsKey($key), sprintf('Key "%s" does not exist in bag', $key));
        return $this->metadata->get($key);
    }

    public function setMetadata(string $key, $value)
    {
        $this->metadata->set($key, $value);
    }

    public function getAllMetadata(): array
    {
        return $this->metadata->toArray();
    }

    public function createMetadataFromArray(array $data)
    {
        $this->metadata = new ArrayCollection($data);
    }
}