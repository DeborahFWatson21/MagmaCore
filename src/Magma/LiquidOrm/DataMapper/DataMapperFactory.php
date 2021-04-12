<?php

declare(strict_types=1);

use Magma\DatabaseConnection\Exception\DataMapperException;
use Magma\DataMapper\DataMapper;
use Magma\DataMapper\DataMapperInterface;

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