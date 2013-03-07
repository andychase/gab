<?php
class PDOLazyConnector
{
    private $dsn;
    private $username;
    private $password;
    private $driver_options;
    private $dbh;

    public function __construct ($dsn, $username, $password, $driver_options = array ())
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->driver_options = $driver_options;
    }

    public function __call ($function, $args)
    {
        // connect to db (first time only)
        $this->__init_dbh ();

        // invoke the original method
        return call_user_func_array (array($this->dbh, $function), $args);
    }

    public function __get ($property)
    {
        return $this->dbh->$property;
    }

    private function __init_dbh ()
    {
        // If db handler is not open yet, do it now
        if (empty ($this->dbh)) {
            $this->dbh = new PDO ($this->dsn, $this->username, $this->password, $this->driver_options);
        }
    }
}