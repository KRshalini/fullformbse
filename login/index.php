<?php
session_start();
include("reg.php");
include("db.php");

if (isset($_SESSION["role"]) && $_SESSION["role"] == 0) {
    $id = $_SESSION["id"]; 
    $query = "SELECT * FROM person_details WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $details = mysqli_fetch_assoc($result);
        //country
        $countryQuery = "SELECT name FROM country WHERE id = " . $details['country'];
        $countryResult = mysqli_query($con, $countryQuery);
        $country = ($countryResult && mysqli_num_rows($countryResult) > 0) ? mysqli_fetch_assoc($countryResult)['name'] : '';

        //state
        $stateQuery = "SELECT state FROM state WHERE id = " . $details['state'];
        $stateResult = mysqli_query($con, $stateQuery);
        $state = ($stateResult && mysqli_num_rows($stateResult) > 0) ? mysqli_fetch_assoc($stateResult)['state'] : '';

        //city
        $cityQuery = "SELECT city FROM city WHERE id = " . $details['city'];
        $cityResult = mysqli_query($con, $cityQuery);
        $city = ($cityResult && mysqli_num_rows($cityResult) > 0) ? mysqli_fetch_assoc($cityResult)['city'] : '';
    
    } else {
        echo "Not found.";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
</head>
<body>
    <h1>User Details</h1>

    <?php if (isset($details)):  ?>
        <p><b>ID:</b> <?php echo $details['id']; ?></p>
        <p><b>First Name:</b> <?php echo $details['firstname']; ?></p>
        <p><b>Last Name:</b> <?php echo $details['lastname']; ?></p>
        <p><b>Email:</b> <?php echo $details['email']; ?></p>
        <p><b>Password:</b> <?php echo $details['password']; ?></p>
        <p><b>Gender:</b> <?php echo $details['gender']; ?></p>
        <p><b>Native:</b> <?php echo $details['native']; ?></p>
        <p><b>Skills:</b> <?php echo $details['skills']; ?></p>
        <p><b>Country:</b> <?php echo $country; ?></p>
        <p><b>State:</b> <?php echo $state; ?></p>
        <p><b>City:</b> <?php echo $city; ?></p>
        <p><b>Location:</b> <?php echo $details['location']; ?></p>
        <a href='edit.php?id=<?php echo $details["id"]; ?>'>Edit</a>

        <a href='delete.php?id=<?php echo $details["id"]; ?>'>Delete</a>
        
    <?php endif; ?>
    
    <a href="logout.php">Logout</a>
</body>
</html>
