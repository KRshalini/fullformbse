<?php
include("reg.php");
$id = $_GET['id'];
$query = "delete from person_details where id='$id'";
$data = mysqli_query($conn,$query);

if($data){
    echo "Deleted";
}else{
    echo "Fail to delete";
}
?>
