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
            die(print_r(sqlsrv_errors(), true));
        }else {
            print_r("Conexión exitosa a la base de datos.");
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

    // <table class="table">
    //     <thead>
    //         <tr>
    //             <th>ID</th>
    //             <th>Nombre</th>
               
    //         </tr>
    //     </thead>
    //     <tbody>
    //         <?php $DBContext = new DA\DBContext(); 
    //             $query = "SELECT TOP 10 * FROM dbo.CNFL_Empleados"; // Reemplaza 'SomeTable' con el nombre de tu tabla
    //             $stmt = sqlsrv_query($DBContext->getConnection(), $query);
    //             if ($stmt === false) {
    //                 die(print_r(sqlsrv_errors(), true));
    //             }
    //             while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)):
    //                 <tr>
    //                     <td><?php echo $row['num_empleado']; </td>
    //                     <td><?php echo $row['nombre_completo']; </td>
                        
    //                 </tr>
    //             <?php endwhile; 
    //     </tbody>
    // </table><?php sqlsrv_free_stmt($stmt);
        
?>
 
