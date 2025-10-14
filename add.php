<?php
    include("db.php");

    $sql = "INSERT INTO tasks (title) VALUES (?)";
    $inserted_title = trim($_POST['task_title'] ?? '');

    try{
        $stmt = $conn->prepare($sql);
        $stmt -> bind_param("s", $inserted_title);
        $stmt -> execute();
        $stmt -> close();        

        // to redirect back. exit for safety 
        header("Location: index.php");
        exit(); 
    }

    catch(mysqli_sql_exception){
        echo"couldnt save task to database... <br>";
    }

    finally {
    $conn -> close();
    }
?>