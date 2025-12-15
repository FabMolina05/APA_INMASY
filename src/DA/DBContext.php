<?php
namespace DA;

class DBContext {
    private $conn;

    public function __construct() {
        $host = '172.16.0.187';
        $db   = 'PADDE';
        $UID = 'sa';
        $PWD = 'Cnfl_10_2025';
        

        $this->conn = sqlsrv_connect($host, ['Database' => $db, 'UID' => $UID, 'PWD' => $PWD, 'TrustServerCertificate' => 1]);
        if ($this->conn === false) {
            http_response_code(500);
        }else {
            
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

        
?>
 
