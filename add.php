<?php

    include("db.php");
    // to validate POST method, because hackers/bots could type in the URL
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php");
        exit;
    }

    // ?? is the null coalescing operator: if the first is null use the following
    $inserted_title = trim($_POST['task_title'] ?? ''); 
    // input validation: if empty or more than 255 character
    // we used mb_strlen for Any UTF-8 text (e.g., Arabic, Turkish, emojis, accented letters) where strlen cannot
    if (mb_strlen($inserted_title) > 255 || $inserted_title === ''){
        header("Location: index.php");
        exit;
    }

    try{

        $sql = "INSERT INTO tasks (title) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt -> bind_param("s", $inserted_title);
        $stmt -> execute();
        // good practice, but only matters in large scripts
        $stmt -> close(); 
        $conn -> close(); 

        // to redirect back. exit for safety 
        header("Location: index.php");
        exit; 
    }

    catch(mysqli_sql_exception){
        echo"couldnt save task to database... <br>";
    }

?>