<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

interface DataMapperInterface
{
    /**
     * Prepare the query string
     * 
     * @param string $query
     * return self
     */
    public function prepare(string $query):self;

    /**
     * Explicit datatype for the parameter using the PDO::PARAM_* constants
     * 
     * @param mixed $values
     * 
     * @return mixed;
     */
    public function bind($values);

    /**
     * Combination method with combins both methods above. One of which is optimized for binding search queries. Once the second argument $types is set to search
     * 
     * @param array $fields
     * @param bool $isSearch
     * @return self
     */
    public function bindParameters(array $fields, bool $isSearch = false):self;

    /**
     * returns the number of rows affected by a DELETE, INSERT, or UPDATE statment
     * 
     * @return int|null
     */
    public function numRole():int;

    /**
     * Execute function which will execute the prepared statement
     * 
     * @return void
     */
    public function execute():void;

    /**
     * Returns a single database row as an object
     * 
     * @return Object
     */
    public function result():Object;

    /**
     * Returns all the rows within the database as an array
     * 
     * @Return array
     */
    public function results():array;

    /**
     * Returns the last inserted row ID from databaset able
     * 
     * @return int
     * @throws Throwable
     */
    public function getLastId():int;
}