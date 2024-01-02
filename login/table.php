<?php
//  session_start();
//     if (!isset($_SESSION["role"]) || $_SESSION["role"] === 2) {
//         header("location:login.php");
//      exit();
//      }
include("reg.php");
include("db.php");

$perPage = 10;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

$start = ($currentPage - 1) * $perPage;
$query = "SELECT * FROM person_details LIMIT $start, $perPage";
$data = mysqli_query($conn, $query);


$totalQuery = "SELECT COUNT(*) AS total FROM person_details";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$total = $totalRow['total'];


$query_country = "SELECT * FROM country";
$data_country = mysqli_query($con, $query_country);
$country_data = array();
while ($row_country = mysqli_fetch_assoc($data_country)) {
    $country_data[$row_country['id']] = $row_country['name'];
}
$query_state= "SELECT * FROM state";
$data_state = mysqli_query($con, $query_state);
$state_data = array();
while ($row_state = mysqli_fetch_assoc($data_state)) {
    $state_data[$row_state['id']] = $row_state['state'];
}

$query_city= "SELECT * FROM city";
$data_city = mysqli_query($con, $query_city);
$city_data = array();
while ($row_city = mysqli_fetch_assoc($data_city)) {
    $city_data[$row_city['id']] = $row_city['city'];
}
//echo $total;

if ($total != 0) {
    ?>
    <table>
        <th>ID</th>
        <th>FirstName</th>
        <th>LastName</th>
        <th>Email</th>
        <th>Password</th>
        <th>Image</th>
        <th>Gender</th>
        <th>Native</th>
        <th>Skills</th>
        <th>Country</th>
        <th>state</th>
        <th>city</th>
        <th>role</th>     
        <th>Location</th>
        <th>Edit/Delete</th>

        <?php
        while ($result = mysqli_fetch_assoc($data)) {
        $country = isset($country_data[$result['country']]) ? $country_data[$result['country']] : '';
        $state = isset($state_data[$result['state']]) ? $state_data[$result['state']] : '';
        $city = isset($city_data[$result['city']]) ? $city_data[$result['city']] : '';
              
            echo "<tr>
            <td>" . $result['id'] . "</td>
            <td>" . $result['firstname'] . "</td>
            <td>" . $result['lastname'] . "</td>
            <td>" . $result['email'] . "</td>
            <td>" . $result['password'] . "</td>
            <td><img src='data:image/*;base64," . base64_encode($result['image']) . "' alt='Image' style='max-width: 400px; max-height: 500px;'></td>
            <td>" . $result['gender'] . "</td>
            <td>" . $result['native'] . "</td>
            <td>" . $result['skills'] . "</td>
            <td>".$country."</td> 
            <td>".$state."</td>
            <td>".$city."</td>
            <td>" . $result['role'] . "</td>
            <td>" . $result['location'] . "</td>
            <td>
                <a href='edit.php?id=$result[id]'>Edit</a>
                <a href='delete.php?id=$result[id]'>Delete</a>
            </td>
            </tr>";
        }
        ?>
    </table>  
    <a href="login.php">LOGIN</a>
    <a href="logout.php">LOGOUT</a>
    <?php
    $total_pages = ceil($total / $perPage);

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='table.php?page=$i'>$i</a> ";
    }
    echo "</div>";
    ?>
<?php
} else {
    echo "No records";
}
?>
