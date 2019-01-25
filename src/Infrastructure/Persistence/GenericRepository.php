<?php
/*
 * This file is part of "toolbox".
 *
 * (c) Kostiantyn Stupak <konstantin.stupak@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toolbox\Infrastructure\Persistence;

use Assert\Assertion;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class GenericRepository extends EntityRepository
{
    public function list(): Collection
    {
        return new ArrayCollection($this->findAll());
    }

    public function save($subject)
    {
        $this->_em->persist($subject);
        $this->_em->flush();
    }

    public function get(string $id)
    {
        $entity = $this->find($id);
        Assertion::notEmpty($entity, 'Entity not found');

        return $entity;
    }
}