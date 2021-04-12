<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\EnityManager;

use Magma\LiquidOrm\DataMapper\DataMapper;
use Magma\LiquidOrm\EntityManager\CrudInterface;
use Magma\LiquidOrm\QueryBuilder\QueryBuilder;
use Throwable;

class Crud implements CrudInterface
{
    /**
     * @var DataMapper
     */
    protected DataMapper $dataMapper;

    /**
     * @var QueryBuilder
     */
    protected QueryBuilder $queryBuilder;

    /**
     * @var string
     */
    protected string $tableSchema;

    /**
     * @var string
     */
    protected string $tableSchemaID;


    /**
     * Main construct method
     * 
     * @param DataMapper $dataMapper
     * @param QueryBuilder $queryBuilder
     * @param string $tableSchema
     * @param string $tableSchemaID
     * 
     * @return void
     */
    public function __construct(DataMapper $dataMapper, QueryBuilder $queryBuilder, string $tableSchema, string $tableSchemaID)
    {
        $this->dataMapper = $dataMapper;
        $this->queryBuilder = $queryBuilder;
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;   
    }

    /**
     * @inheritDoc
     * 
     * @return string
     */
    public function getSchema():string
    {
        return $this->tableSchema;
    }

    /**
     * @inheritDoc
     * 
     * @return string
     */
    public function getSchemaId():string
    {
        return $this->tableSchemaID;
    }

    /**
     * @inheritDoc
     * 
     * @return integer
     */
    public function lastID():int
    {
        return $this->dataMapper->getLastId();
    }

    /**
     * @inheritDoc
     * 
     * @return bool
     * @throws Throwable
     */
    public function create(array $fields=[]):bool
    {
        try{
            $args = [
                'table' => $this->getSchema(), 
                'type' => 'insert', 
                'fields' => $fields];
            $query = $this->queryBuilder->buildQuery($args)->insertQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if($this->dataMapper->numRows()==1)
            {
                return true;
            }
        }catch(Throwable $throwable){
            throw $throwable;

        }
        return false;
    }

    /**
     * @inheritDoc
     * 
     * @return array
     */
    public function read(array $selectors = [], array $conditions = [], array $parameters = [], array $optional = []): array
    {
        try{
            $args = [
                'table' => $this->getSchema(),
                'type'=> 'select',
                'selectors' => $selectors,
                'conditions' => $conditions,
                'parameters' => $parameters,
                'extras' => $optional
            ];
            $query = $this->queryBuilder->buildQuery($args)->selectQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions, $parameters));
            if($this->dataMapper->numRows() > 0)
            {
                return $this->dataMapper->results();
            }
        }catch(Throwable $throwable){
            throw $throwable;
        }
        return false;
    }

    /**
     * @inheritDoc
     * 
     * @return bool
     */
    public function update(array $fields = [], string $primaryKey): bool
    {
        try{
            $args = [
                'table' => $this->getSchema(),
                'type'=> 'update',
                'fields' => $fields,
                'primary_key' => $primaryKey
            ];
            $query = $this->queryBuilder->buildQuery($args)->updateQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($fields));
            if($this->dataMapper->numRows() == 1)
            {
                return true;
            }
        }catch(Throwable $throwable){
            throw $throwable;
        }
        return false;
    }

    /**
     * @inheritDoc
     * 
     * @return bool
     */
    public function delete(array $conditions = []): bool
    {
        try{
            $args = [
                'table' => $this->getSchema(),
                'type'=> 'delete',
                'conditions' => $conditions
            ];
            $query = $this->queryBuilder->buildQuery($args)->deleteQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if($this->dataMapper->numRows() == 1)
            {
                return true;
            }
        }catch(Throwable $throwable){
            throw $throwable;
        }
        return false;
    }

    /**
     * @inheritDoc
     * 
     * @return array
     */
    public function search(array $selectors = [], array $conditions = []):array
    {
        try{
            $args = [
                'table' => $this->getSchema(),
                'type'=> 'search',
                'selectors' => $selectors,
                'conditions' => $conditions
            ];
            $query = $this->queryBuilder->buildQuery($args)->searchQuery();
            $this->dataMapper->persist($query, $this->dataMapper->buildQueryParameters($conditions));
            if($this->dataMapper->numRows() >= 0)
            {
                return $this->dataMapper->results();
            }
        }catch(Throwable $throwable){
            throw $throwable;
        }
    }

    /**
     * @inheritDoc
     * 
     * @return void
     */
    public function rawQuery(string $rawQuery, array $conditions = [])
    {

    }
}