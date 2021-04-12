<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use  Magma\LiquidOrm\DataMapper\Exceptions\DataMapperException;
use Magma\LiquidOrm\DataMapper\DataMapperInterface;
use Magma\DatabaseConnection\DatabaseConnectionInterface;
use PDOStatement;
use PDO;
use Throwable;

class DataMapper implements DataMapperInterface
{
    /**
     * @var DatabaseConnectionInterface $dbh;
     */
    private DatabaseConnectionInterface $dbh;

    /**
     * @var PDOStatment
     */
    private PDOStatement $stmt;

    /**
     * Main constructor class
     */
    public function __construct(DataMapperInterface $dbh)
    {
        $this->dbh=$dbh;
    }


    /**
     * Check the incoming $valis isn't empty else throw an exception
     * 
     * @param mixed $value
     * @param string|null $errorMessage
     * @return void
     * @throws DataMapperException
     */
    private function isEmpty($value, string $errorMessage = null)
    {
        if(empty($value))
        {
            throw new DataMapperException($errorMessage);
        }
    }


    /**
     * Check the incoming argument $value is an array else throw an exception
     * 
     * @param array $value
     * @return void
     * @throws BaseInvalidArgumentException
     */
    private function isArray(array $value, string $errorMessage = null)
    {
        if(is_array($value))
        {
            throw new DataMapperException('Your argument needs to be an array');
        }
    }

    /**
     * @inheritDoc
     * 
     * @return self
     */
    public function prepare(string $query):self
    {
        $this->stmt = $this->dbh->open()->prepare($query);
        return $this;
    }

    /**
     * @inheritDoc
     *
     * @param [type] $value
     * @return void
     */
    public function bind($value)
    {
        try{
            switch($value)
            {
                case is_bool($value):
                case intVal($value):
                    $dataType=PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $dataType=PDO::PARAM_NULL;
                    break;
                default:
                    $dataType=PDO::PARAM_STR;
                    break;
            }
            return $dataType;
        }catch(DataMapperException $exception){
            throw $exception;
        }
    }    
    
    /**
     * @inheritDoc
     *
     * @param array $fields
     * @param boolean $isSearch
     * @return self
     */
    public function bindParameters(array $fields, bool $isSearch = false):self
    {
        if(is_array($fields))
        {
            $type = ($isSearch === false) ? $this->bindValue($fields) : $this->bindSearchValue($fields);
            if($type)
            {
                return $this;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     * 
     * @return integer
     */
    public function numRows():int
    {
        if($this->stmt)
        {
            return $this->stmt->rowCount();
        }
    }

    /**
     * @inheritDoc
     * 
     * @return void
     */
    public function execute()
    {
        if($this->stmt)
        {
            return $this->stmt->execute();
        }
    }

    /**
     * @inheritDoc
     * 
     * @return Object
     */
    public function result():Object
    {
        if($this->stmt)
        {
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }
    }

    /**
     * @inheritDoc
     */
    public function results():array
    {
        if($this->stmt)
        {
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function getLastId():int
    {
        try{
            if($this->dbh->open())
            {
                $lastId=$this->dbh->open()->lastInsertId();
                if(!empty($lastID))
                {
                    return intval($lastID);
                }
            }
        }catch(Throwable $throwable){
            throw $throwable;
        }
    }

    /**
     * Binds a value to a corresponding name or question mark placeholder in the SQL statement that was used to praprae the statement
     * 
     * @param array $fields
     * @return PDOStatement
     * @throws DataMapperException
     */
    protected function bindValue(array $fields):PDOStatement
    {
        $this->isArray($fields);
        foreach($fields as $key => $value)
        {
            $this->stmt->bindValue(':'.$key, $value, $this->bind($value));
        }
        return $this->stmt;
    }


    /**
     * Binds a value to a corresponding name or question mark placeholder
     * in the SQL statement that was used to prepare the statement. Similar to
     * above but optimised for search queries
     * 
     * @param array $fields
     * @return mixed
     */
    protected function bindSearchValue(array $fields)
    {
        $this->isArray($fields);
        foreach($fields as $key => $value)
        {
            $this->stmt->bindValue(':'.$key, '%'. $value . '%', $this->bind($value));
        }
        return $this->stmt;
    }

        /**
     * Returns the query condition merged with the query parameters
     * 
     * @param array $conditions
     * @param array $parameters
     * @return array
     */
    public function buildQueryParameters(array $conditions = [], array $parameters = []) : array
    {
        return (!empty($parameters) || (!empty($conditions)) ? array_merge($conditions, $parameters) : $parameters);
    }

    /**
     * Persist queries to database
     * 
     * @param string $query
     * @param array $parameters
     * @return mixed
     * @throws Throwable
     */
    public function persist(string $sqlQuery = [], array $parameters = [])
    {
        try {
            return $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
        } catch(Throwable $throwable){
            throw $throwable;
        }
    }



}
