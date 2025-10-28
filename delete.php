<?php
include("db.php");

// validate request method for security
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}
// check if input exists and is numeric
if (!isset($_POST['delete_id']) || !ctype_digit($_POST['delete_id'])) {
    header('Location: index.php?error=bad_id');
    exit;
}

$delete_id = (int)$_POST['delete_id'];
$sql = "DELETE FROM tasks WHERE id = (?)";
$sql2 = "DELETE FROM tasks WHERE id IN $_POST['delete_ids']";
try {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $delete_id);
    $stmt->execute();
    mysqli_query($conn, $sql2);
    // checks if index deleted, if not, ID doesnt exist
    if ($stmt->affected_rows === 0) {
        header('Location: index.php?error=not_found');
        exit;
    } else {
        header('Location: index.php?msg=deleted');
        exit;
    }
} catch (mysqli_sql_exception $e) {
    error_log('delete.php failed: ' . $e->getMessage());
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
