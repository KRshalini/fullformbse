<?php
ob_start();
include("reg.php");
include_once("db.php");
include_once("response.php");

$country = ''; 
if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = "select * from person_details where id='$id'";
    $data = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($data);

    $skills1 = explode(",", $result['skills']);
    $location = explode(",", $result['location']);
    $role = $result['role'];


$query_country = "SELECT * FROM country";
$data_country = mysqli_query($con, $query_country);
$total_country = mysqli_num_rows($data_country);
while ($result_1 = mysqli_fetch_assoc($data_country))
{
    if($result['country']==$result_1['id'])
        {
            $country=$result_1['name'];
        }
}

$query_state= "SELECT * FROM state";
$data_state = mysqli_query($con, $query_state);
$total_state = mysqli_num_rows($data_state);
while ($result_2 = mysqli_fetch_assoc($data_state))
            {
                if($result['state']==$result_2['id'])
                {
                    $state=$result_2['state'];
                }
            }

$query_city= "SELECT * FROM city";
$data_city = mysqli_query($con, $query_city);
$total_city = mysqli_num_rows($data_city);
while ($result_3 = mysqli_fetch_assoc($data_city))
{
    if($result['city']==$result_3['id'])
    {
        $city=$result_3['city'];
    }
}
}
?>

<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <title>FORM</title>
</head>
  <body>
    <div class="class">
        <form action="" id="formvalidation" method="POST" enctype="multipart/form-data">
            <div class="title">
                <h1>UPDATE FORM</h1>
            </div>
            <div class="form">
                <div class="input">
                    <label for="fname">FirstName:</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $result['firstname'] ?>"><br>
                </div>

                <div class="input">
                    <label for="lname">LastName:</label>
                    <input type="text" name="lastname"  value="<?php echo $result['lastname'] ?>"><br>
                </div>

                <div class="input">
                    <label for="email">Email:</label>
                    <input type="email" name="email" value="<?php echo $result['email'] ?>"><br>
                </div>

                <div class="input">
                    <label for="password">Password:</label>
                    <input type="password" name="password" value=""><br>
                </div>
                
                <div class="input">
                    <input type="file" name="uploadfile">
                    <?php echo "<img src='data:image/*;base64," . base64_encode($result['image']) . "' alt='Image' style='max-width: 100px; max-height: 100px;'>";?>
                <br><br>
                </div>

                <div class="input">
                    <label for="gender">Gender:</label><br>
                    <input type="radio" name="gender" value="Female" <?php if($result['gender']=="Female") echo "checked"; ?>>Female
                    <input type="radio" name="gender" value="Male" <?php if($result['gender']=="Male") echo "checked"; ?>>Male<br>
                </div>

                <div class="input">
                    <label for="native">Native:</label>
                    <select name="native">
                        <option value="Select">Select</option>
                        <option value="Chennai" <?php if($result['native'] == 'Chennai') echo "selected"; ?>>Chennai</option>
                        <option value="Madurai" <?php if($result['native'] == 'Madurai') echo "selected"; ?>>Madurai</option>
                    </select>
                </div>
                
               
                <div class="input">
                    <label for="skills">Skills:</label>
                    <input type="checkbox" name="skills[]" value="Python" <?php if(in_array("Python", $skills1)) echo "checked"; ?>>python
                    <input type="checkbox" name="skills[]" value="NodeJs" <?php if(in_array("NodeJs", $skills1)) echo "checked"; ?>>nodejs
                    <input type="checkbox" name="skills[]" value="Javascript" <?php if(in_array("Javascript", $skills1)) echo "checked"; ?>>Javascript<br>
                </div>

                <div class="input">
                    <label for="location">Preferred location:</label><br>
                    <select name="location[]" multiple required="select-form-control">
                    <option value="Tirchy" <?php echo (isset($location) && in_array('Tirchy', $location)) ? "selected" : ""; ?>>Trichy</option>          
                        <option value="Madurai" <?php echo (isset($location) && in_array('Madurai', $location)) ? "selected" : ""; ?>>Madurai</option>
                        <option value="Coimbatore" <?php echo (isset($location) && in_array('Coimbatore', $location)) ? "selected" : ""; ?>>Coimbatore</option>   
                        <option value="Bangalore" <?php echo (isset($location) && in_array('Bangalore', $location)) ? "selected" : ""; ?>>Bangalore</option>
                        <option value="Chennai" <?php echo (isset($location) && in_array('Chennai', $location)) ? "selected" : ""; ?>>Chennai</option>              
                    </select>
                </div>
 
                <div class="input">
                   <label for="country"> Country</label>
                   <select class="" id="country" name="country">
                       <option value=""><?php echo $country ?></option>
                <?php
                $query = "select * from country";
                $result = $con->query($query);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
            </div>
            <div class="input">
            <label for="state"> State</label>
            <select class="" id="state" name="state">
               <option value=""><?php echo $state ?></option>
            </select>
            </div>
            <div class="input">
            <label for="city"> City</label>
            <select class="" id="city" name="city">
                <option value=""><?php echo $city ?></option>
            </select>  
            </div>
            

            <div class="input">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="update" value="Update">
            </div>        
        </div>
    
    <script>
        $(document).ready(function() {
            $("#country").on('change', function() {
                var countryid = $(this).val();

                $.ajax({
                    method: "POST",
                    url: "response.php",
                    data: {
                        id: countryid
                    },
                    datatype: "html",
                    success: function(data) {
                        $("#state").html(data);
                        $("#city").html('<option value="">Select city</option');

                    }
                });
            });
            $("#state").on('change', function() {
                var stateid = $(this).val();
                $.ajax({
                    method: "POST",
                    url: "response.php",
                    data: {
                        sid: stateid
                    },
                    datatype: "html",
                    success: function(data) {
                        $("#city").html(data);

                    }

                });
            });
        });
    </script>
            </div>
        </form>
    </div>   
  </body>
</html>

<?php
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];   
   // $newpassword = $_POST['password'];   
        
     if(!empty($password)){
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);
       
     }else{       
        $hashedPassword = '';
     }
    

    
    $gender = $_POST['gender'];
    $native = $_POST['native'];
    $skills = implode(",", $_POST['skills']);
    $country=$_POST['country'];
    $state=$_POST['state'];
    $city=$_POST['city'];
    $location = implode(',', $_POST['location']);

   // $passwordUpdate = empty($password) ? ", password='$hashedPassword'" : "";
    
    $sql = "update person_details set firstname='$firstname', lastname='$lastname', email='$email', password='$hashedPassword', gender='$gender', native='$native', skills='$skills',country='$country',state='$state',city='$city', location='$location' where id='$id'";
    $query = mysqli_query($conn, $sql);
    
     if ($query) {
       
        $updatedQuery = "SELECT role FROM person_details WHERE id='$id'";
        $updatedResult = mysqli_query($conn, $updatedQuery);
        $updatedRow = mysqli_fetch_assoc($updatedResult);
        $updatedRole = $updatedRow['role'];

        if ($updatedRole == 0) {
            //echo "Updated successfully ";
            ob_end_clean();
            header("Location:index.php");
            exit();
        } elseif ($updatedRole == 2) {
            ob_end_clean();
            header("Location: table.php");
            exit();
        } else {
            echo "Update successful ";
        }
    } else {
        echo "Failed to submit. Error: " . mysqli_error($conn);
        echo "SQL Query: " . $sql;
    }

}
?>
