<?php


    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "todo_db";

    try{
    $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
        // echo"connected!!!! <br>";

    }
    catch(mysqli_sql_exception){
        // echo"couldnt connect... <br>";
    }


?>
