<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Data
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * PDO
 *
 * This class holds an connection with a MySQL Database via PDO
 *
 * @abstract
 * @package Bwork
 * @subpackage Bwork_Data
 * @version v 0.1
 */
abstract class Bwork_Data_PDO implements Bwork_Data_Interface
{
    
    /**
     * This will hold the PDO object
     *
     * @var PDO $db
     * @access protected
     */
    protected $db;

    /**
     * The construction method will attempt to establish a connection with the
     * MySQL database and stores itself in $db.
     *
     * @access public
     * @throws Bwork_Data_Exception
     * @return Bwork_Data_PDO
     */
    public function  __construct()
    {

        $dbParams   = Bwork_Core_Registry::GetInstance()
                        ->getResource('Bwork_Config_Confighandler')
                        ->get('database');
        $dsn        = sprintf('mysql:dbname=%s;host=%s;port=%s', $dbParams['dbname'], $dbParams['host'], $dbParams['port']);
        
        $username = $dbParams['username'];
        $password = $dbParams['password'];

        try {
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        }
        catch(PDOException $e) {
            throw new Bwork_Data_Exception('PDO Error: Failed connecting to database.');
        }
    }

    /**
     * Magic method automatically called just before destroying the object and
     * will unset PDO
     *
     * @access public
     * @return void
     */
    public function  __destruct()
    {
        unset($this->db);
    }

    /**
     * The main function that will return the PDO class
     *
     * @access public
     * @return PDO
     */
    public function db()
    {
        return $this->db;
    }
    
}