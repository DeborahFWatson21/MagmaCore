<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper\DataMapper;

use Magma\LiquidOrm\DataMapper\Exception\DataMapperInvalidArgumentException;

class DataMapperEnvironmentConfiguration
{
    /**
     * @var array
     */
    private array $credentials = [];

    /**
     * Main construct class
     * 
     * @param array $credentials
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Get the user defined database connection array
     * 
     * @param string $driver
     * @return array
     */
    public function getDatabaseCredentials(string $driver):array
    {
        $connectionArray = [];
        foreach($this->credentials as $credentials)
        {
            if(array_key_exists($driver, $credentials))
            {
                $connectionArray = $connectionArray[$driver];
            }
        }
        return $connectionArray;
    }

    /**
     * Checks credentials for validity
     * 
     * @param string $driver
     * @return void
     */
    private function isCredentialValid(string $driver):void
    {
        if(empty($driver) && !is_string($driver))
        {
            throw new DataMapperInvalidArgumentException('Invalid argument. This either missing or off the invalid datatype.');
        }
        if(!is_array($driver))
        {
            throw new DataMapperInvalidArgumentException('Invalid creditials');
        }
        if(!in_array($driver, array_keys($this->credentials[$driver])))
        {
            throw new DataMapperInvalidArgumentException('Invalid or unsport database driver');
        }
    }
    

}