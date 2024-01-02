<?php
session_start();

if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    echo "Logout successful!";
}
?>

<?php
include("reg.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = trim($_POST["password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    $query = "SELECT *,role,password FROM person_details WHERE email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];

        if (password_verify($password, $row['password'])) {
            $_SESSION["role"] = $row['role'];
            $_SESSION["id"] = $row['id'];

            if ($row['role'] == 2) {
                header("Location: table.php");
            } else {
                header("Location: index.php");
            }

            exit();
        } 
    } 
}
?>

<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <script>
        $(document).ready(function(){
            $("#email").keyup(function(e){
                var email = $("#email").val();

                $.ajax({
                    type: "POST",
                    url: "checkemail.php",
                    data: { email: email },
                    success: function(response){
                        if(response === 'exists'){
                            $('#email-error').html('');
                        } else {
                            $('#email-error').html('Email does not exist');
                        }
                    }
                });
            });

            $('#formvalidation').submit(function(e){
                e.preventDefault();
                
                var email = $('#email').val();

                $.ajax({
                    type: 'POST',
                    url: 'checkemail.php',
                    data: { email: email },
                    success: function(response){
                        if(response === 'exists'){
                            $('#email-error').html('');
                            $('#formvalidation').unbind('submit').submit();
                        } else {
                            $('#email-error').html('Email does not exist');
                        }
                    }
                });
            });
        });
    </script>
    
        <script>
        $(document).ready(function(){
            $("#password").keyup(function(e){
                var password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "checkpass.php",
                    data: { password: password },
                    success: function(response){
                        if(response === 'exists'){
                            $('#password-error').html('');
                        } else {
                            $('#password-error').html('password does not exist');
                        }
                    }
                });
            });

            $('#formvalidation').submit(function(e){
                e.preventDefault();
                
                var password = $('#password').val();

                $.ajax({
                    type: 'POST',
                    url: 'checkpass.php',
                    data: { password: password },
                    success: function(response){
                        if(response === 'exists'){
                            $('#password-error').html('');
                            $('#formvalidation').unbind('submit').submit();
                        } else {
                            $('#password-error').html('password does not exist');
                          //  $('#password-error').show('password does not exist');
                        }
                    }
                });
            });
        });
    </script>
     
</head>
<body>
    <div class="class">
        <form action="" id="formvalidation" method="POST" enctype="multipart/form-data">
            <div class="title">
                <h1>LOGIN</h1>
            </div>

            <div class="input">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required><br>
                <span id="email-error" style="color: red;"></span><br>
            </div>

            <div class="input">
                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
                <span id="password-error" style="color: red;"></span><br>
                <span id="password-message" style="color:red"></span>                
            </div>
        
            <div class="input">
                <input type="submit" name="login" value="Login">   
            </div>
            <div>
                <p>Not have an account, <a href="form1.php">Register</a>.</p>
            </div>
        </form>
    </div>
</body>
</html>
