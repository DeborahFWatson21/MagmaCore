<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EnityManager;

use Magma\LiquidOrm\EntityManager\CrudInterface;

class EnityManager implements EnityMangerInterface
{
    /**
     * @var CrudInterface
     */
    protected CrudInterface $crud;

    /**
     * Main constructor method
     * 
     * @param CrudInterface $crud 
     * @return void
     */
    public function __construct(CrudInterface $crud)
    {
        $this->crud = $crud;
    }

    /**
     * inheritDoc
     * 
     * @return Object
     */
    public function getCrud():object
    {
        return $this->crud;
    }
}