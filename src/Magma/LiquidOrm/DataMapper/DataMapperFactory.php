<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\LiquidOrm\DataMapper\Exceptions\DataMapperException;
use Magma\LiquidOrm\DataMapper\DataMapper;
use Magma\LiquidOrm\DataMapper\DataMapperInterface;

class DataMapperFactory
{
    /**
     * Main constructor class
     * 
     * @return void
     */
    public function __construct(){}

    /**
     * 
     */
    public function create(string $databaseConnectionString, string $dataMapperEnviromentConfiguration): DataMapperInterface
    {
        $credentials = (new $dataMapperEnviromentConfiguration([]))->getDatabaseCredntials('mysql');
        $databaseConnectionObject = new $databaseConnectionString($credentials);
        if(!$databaseConnectionObject instanceof DataMapperInterface)
        {
            throw new DataMapperException($databaseConnectionString . ' is not a valid database connection object');
        }
        return new DataMapper($databaseConnectionString);
    }
}