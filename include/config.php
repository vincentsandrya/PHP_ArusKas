<?php
    /** ini koneksi ke database **/
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "aruskas";

    $connection = mysqli_connect($servername,$username, $password,$dbname);
    if(!$connection)
    {
        die("connection failed : " .mysqli_connect_error());
    }

?>
