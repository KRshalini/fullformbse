<?php
ob_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "details";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $query = "SELECT * FROM `person_details` ORDER BY Id DESC LIMIT 1";
    $data = mysqli_query($conn, $query);
    $total = mysqli_num_rows($data);

    if ($total == 0) {
        $id = 1;
    } else {
        $result = mysqli_fetch_assoc($data);
        $id = $result['id'] + 1;
    }

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = trim($_POST["password"]);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $gender = $_POST['gender'];
    $native = $_POST['native'];
    $skills = $_POST['skills'];
    $country = $_POST['country'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $location = implode(',', $_POST['location']);
    $skills1 = implode(",", $skills);
    
    $image = file_get_contents($_FILES['uploadfile']['tmp_name']);

    $escapedImage = $conn->real_escape_string($image);
   
     
    $sql = "INSERT INTO person_details (id, firstname, lastname, email, password,img, gender, native, skills, country, state, city, location) VALUES ('$id','$firstname','$lastname','$email','$hashedPassword','$escapedImage','$gender','$native','$skills1','$country','$state','$city','$location')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo "Registered";
    } else {
        echo "Failed";
    }
}

ob_end_flush();
?>
