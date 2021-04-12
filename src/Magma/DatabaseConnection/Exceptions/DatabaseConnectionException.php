<?php

declare(strict_types=1);

namespace Magma\DatabaseConnection\Exceptions;

use PDOException;

class DatabaseConnectionException extends PDOException
{
    /**
     * Main constructor class wihich override the parent constructer and set the message and the code properties which is optional
     * 
     * @param string $message
     * @param int $code
     * @param void
     */
    protected $message;

    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}