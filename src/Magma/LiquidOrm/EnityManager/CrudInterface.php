<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EntityManager;

interface CrudInterface
{

    /**
     * Returns the storage schema name as a string
     * 
     * @return string
     */
    public function getSchema():string;

    /**
     * Returns the primary key for the storage schema
     * 
     * @return string
     */
    public function getSchemaId():string;

    /**
     * Returns the last id inserted ID
     * 
     * @return int
     */
    public function lastID():int;

    /**
     * Create method which inserts data within a storage table
     * 
     * @param (optional) array $fields 
     * @return bool
     */
    public function create(array $fields=[]):bool;

    /**
     * Returns an array of database rows based on the individual supplied arguments
     * 
     * @param (optional) array $selectors
     * @param (optional) array $conditions
     * @param (optional) array $parameters
     * @param (optional) array $optional
     * 
     * @return array
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []):array;

    /**
     * Update method which update 1 or more rows of data with in the storage table
     * 
     * @param (optional) array $fields
     * @param string $primaryKey
     * 
     * @return bool
     */
    public function update(array $fields = [], string $primaryKey): bool;

    /**
     * Delete method which will permanently delete a row from the storage table
     * 
     * @param (optional) array $conditions
     * 
     * @return bool
     */
    public function delete(array $conditions = []): bool;

    /**
     * Returns a custom query string. The second argument can assign and associate array
     * of conditions for the query string
     * 
     * @param (optional) array $selectors
     * @param (optional) array $conditions
     * 
     * @return array
     */
    public function search(array $selectors = [], array $conditions = []):array;

    /**
     * 
     * 
     * @param string $rawQuery
     * @param (optional) array $conditions
     * 
     * @return void
     */
    public function rawQuery(string $rawQuery, array $conditions = []);

}