<?php

class dbObj
{

   
    var $servername = 'localhost';
    var $username = 'root';
    var $password = '';
    var $dbname = 'Cerveza_Artesanal';
    var $conn;

    function getConnstring() 
    {

        $con = mysqli_connect(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname
        ) or die("[1] Falló la conexión: " . mysqli_connect_error());
    
        if (mysqli_connect_errno()) 
        {
            printf("[2] Falló la conexión: %s\n", mysqli_connect_error());
            exit();
        } 
        else 
        {
            $this->conn = $con;
        }
    
        return $this->conn;
    }

}
?>
