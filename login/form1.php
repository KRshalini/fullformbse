<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "details";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn) {
 // echo "Connection Success";
}else{
    echo "Connection failed .mysqli_connect_error";
}

?>
<?php
include_once("db.php");
include_once("response.php");
?>

<html>
  <head>  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.f.js"></script>  
   

    <title>FORM</title>
</head>
  <body>
 
    <div class="class">
        <form action="" id="formvalidation"  method="POST" enctype="multipart/form-data">
          <p id="msg" style="color:red"></p>
        <div class="title">
         <h1>FORM</h1>
        </div>
      <div class="form">
        <div class="input">
          <label for="fname">FirstName:</label>
          <input type="text" id="firstname" name="firstname"><br>
        </div>

        <div class="input">
          <label for="lname">LastName:</label>
          <input type="text" name="lastname"><br>
        </div>

        <div class="input">
          <label for="email">Email:</label>
          <input type="email" name="email"><br>
        </div>

        <div class="input">
          <label for="password">Password:</label>
          <input type="password" name="password"><br>
        </div>

        <div class="input">
          <input type="file" name="uploadfile" required><br>
          </div> 

        
     
        <div class="input">

            <label for="country"> Country</label>
            <select class="" id="country" name="country">
                <option value=""> Select Country</option>
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
                <option value="">select State</option>

            </select>
        </div>
        <div class="input">
            <label for="city"> City</label>
            <select class="" id="city" name="city">
                <option value="">select City</option>
            </select>
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
    <!--register ajax-->
    <script>
     $(document).ready(function(){
      $("#formvalidation").submit(function(e){
        e.preventDefault();
        $.ajax({
          method:"POST",
          url:"register.php",
          data: new FormData(this),
          processData:false,
          contentType:false,
          success:function(data){
            $('#msg').html(data);
            $('#formvalidation').find('input'),val('');
          }
        });
      });
     });
</script>
   
   
        <div class="input">
          <label for="gender">Gender:</label><br>
          <input type="radio" name="gender" value="Female">Female
          <input type="radio" name="gender" value="Male">Male<br>
        </div>
 

        <div class="input">
          <label for="native">Native:</label>
          <select name="native">
            <option value="Select">Select</option>
            <option value="Chennai">Chennai</option>
            <option value="Madurai">Madurai</option>
           
          </select>
   
           
          <div class="input">
            <label for="skills">Skills:</label>          
            <input type="checkbox"  name="skills[]" value="Python">python        
            <input type="checkbox"  name="skills[]" value="NodeJs">nodejs                
            <input type="checkbox"  name="skills[]" value="Javascript">Javascript<br>
           
           
            <div class="input">
           
              <label for="location">Preferred location:</label><br>
              
              <select name="location[]" multiple required >
              <option value="Tirchy">Trichy</option>          
                 <option value="Madurai">Madurai</option>
                 <option value="Coimbatore">Coimbatore</option>
                 <option value="Bangalore">Bangalore</option>
                 <option value="Chennai">Chennai</option>                                                    
              </select>
            </div>

        <div class="input">
            <input type="submit" name="submit" value="Submit">  
        </div>
        <div>
            <p>Already have an account, <a href="login.php">login</a>.</p>
       </div>

      </div>
    </div>  
    </form>
    </div>
   
  </body>
</html>
