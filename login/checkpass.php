<?php
include("reg.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['password'])) {
    $password = $_POST['password'];
    $email = $_POST['email'];
   
    $query = "SELECT password FROM person_details WHERE email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            echo 'exists';
        } else {
            echo 'not_exists';
        }
    } else {
        echo 'not_exists';
    }
}
?>
