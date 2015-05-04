<?php
namespace services;

class DatabaseConnection {
    /**
     * Holds the instance object after it's been created
     *
     * Uses Singleton Design Pattern
     * @var null
     */
    protected static $_instance = NULL;

    /**
     * @var null|\PDO connection to the database
     */
    protected $_pdo = null;

    /**
     * Constructs the new PDO object for connecting to the database
     *
     * Construct is private so it cannot be started from the outside
     */
    private function __construct() {
        try {
            $this->_pdo = new \PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            // set error modes and exception handlers
            $this->_pdo->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
        }
        catch (\PDOException $e) {
            // output error to the errorlog.html file
            \core\Logger::newMessage($e->getMessage());
            \core\Logger::customErrorMsg();
        }
    }

    /**
     * Static function used to obtain a single connection to the database
     * @return null|DatabaseConnection returns the database connection
     */
    public static function getConnection() {
        // this will make sure it's only ONE instance, if there is no existing connection it will create a new one.
        if (is_null(self::$_instance)) {
            //new connection object.
            self::$_instance = new self();
        }
        //return connection.
        return self::$_instance;
    }

    /**
     * Adds quotes around the passed string to prep it for query use
     * @param string $string
     * @return string string
     */
    public function quote($string) {
       return $this->_pdo->quote($string);
    }

    /**
     * Selects data from the database using a passed SQL statement
     * @param string $sql the passed SQL statement
     * @return array the returned object data
     */
    public function select($sql) {
        $result = $this->_pdo->query($sql);
        $resultData = array();
        while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
            $resultData[] = $row;
        }
        return $resultData;
    }

    /**
     * Very simple Insert SQL function
     * @param string $sql the passed SQL statement
     */
    public function insert($sql) {
        $this->_pdo->exec($sql);
    }

    /**
     * Very simple Update SQL function
     * @param string $sql the passed SQL statement
     */
    public function update($sql) {
        $this->_pdo->exec($sql);
    }

    /**
     * Very simple Delete SQL function
     * @param string $sql the passed SQL statement
     */
    public function delete($sql) {
        $this->_pdo->exec($sql);
    }

    /**
     * Returns the id of the most recently ran SQL statement
     * @param string $field
     * @return string
     */
    public function getLastId($field = 'id') {
        return $this->_pdo->lastInsertId($field);
    }

}
