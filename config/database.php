<?php
/**
* @file database.php
* @brief Contains the class and methods for connecting to the database used in StarWars test for Prototype
* @author Johnroe Paulo Canamaque <jpcanamaque@gmail.com>
* @date February 2020
*/

/**
 * @brief Main class for the database connection for the StarWars test
 */
class Database {
    private $host = "recruitment-test-mysql.caqylurhpyhw.eu-west-1.rds.amazonaws.com";
    private $username = "candidate";
    private $password = 'PrototypeRocks123654';
    private $db_name = 'star-wars';

    private $conn;

    /**
     * @brief Creates a database connection instance to the StarWars database
     * @return object $conn
     */
    public function getConnection(){
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
        return $this->conn;
    }
}