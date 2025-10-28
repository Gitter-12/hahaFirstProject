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
if (mb_strlen($inserted_title) > 255 || $inserted_title === '') {
    header("Location: index.php?error=bad_title");
    exit;
}

try {

    $sql = "INSERT INTO tasks (title) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $inserted_title);
    $stmt->execute();

    // to redirect back. exit for safety 
    header("Location: index.php?msg=added");
    exit;
} catch (mysqli_sql_exception $e) {
    error_log('add.php failed: ' . $e->getMessage());
    header('Location: index.php?error=db');
    exit;


    // finally block will always execute to close, good practice
} finally {
    // if statements are to check if $stmt and $conn exists before closing
    // because $conn could throw before $stmt exists, and so on
    if (isset($stmt) && $stmt instanceof mysqli_stmt) {
        $stmt->close();
    }
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
}
