<?php
include 'Database.php';

$deleteid = $_GET['deleteid'] ?? null;
if (null !== $deleteid) {
    $marathon_id = mysqli_real_escape_string($conn, $deleteid);
    $user_id = mysqli_real_escape_string($conn, $deleteid);

    $sql = "DELETE FROM marathon WHERE marathon_id = $marathon_id";
    $sql1 = "DELETE FROM user_participants WHERE user_id = $user_id";

    $result1 = mysqli_query($conn, $sql);
    $result2 = mysqli_query($conn, $sql1);
    
    if ($result1 && $result2) {
        header('location: Index.php');
        exit;
    } else {
        die("Something went wrong: " . mysqli_error($conn));
    }
}
?>