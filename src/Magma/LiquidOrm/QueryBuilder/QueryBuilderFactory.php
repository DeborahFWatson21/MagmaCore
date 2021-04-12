<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\QueryBuilder;

use Magma\LiquidOrm\QueryBuilder\QueryBuilderInterface;
use Magma\LiquidOrm\QueryBuilder\Expections\QueryBuilderException;

class QueryBuilderFactory
{
    /**
     * Main constructor method
     * 
     * @return void
     */
    public function __construct(){}

    public function create(string $queryBuilderString): QueryBuilderInterface
    {
        $queryBuilderObject = new $queryBuilderString();
        if(!$queryBuilderObject instanceof QueryBuilderInterface)
        {
            throw new QueryBuilderException($queryBuilderString . ' is not a valid Query Builder Object');
        }
        return new QueryBuilder();
    }
}