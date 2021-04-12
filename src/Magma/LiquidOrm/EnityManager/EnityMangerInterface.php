<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EnityManager;

interface EnityMangerInterface
{
    
    /**
     * Get the crud object which will expose all the method within our crud class
     * 
     * @return Object
     */
    public function getCrud() : Object;
}