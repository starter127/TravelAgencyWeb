<?php

class DBConnection {
    
    function __construct() {
        
    }
    function connect() {
        include_once dirname(__FILE__) . '/Config.php';
 
        // Connecting to mysql database
        $this->_Conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
        // Check for database connection error
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $this->_Conn->query("SET CHARACTER SET utf8 ");
        return $this->_Conn;
    }
    
    private $_Conn;
}