<?php
include("reg.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    
    
    $query = "SELECT * FROM person_details WHERE email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

   
    if ($result && mysqli_num_rows($result) > 0) {
        echo 'exists';
    } else {
        echo 'not_exists';
    }
}
?>
