<?php
include_once("db.php");

if(isset($_POST['uname'])){
    $user_name = $_POST['uname'];
    $pass_word = $_POST['pass1'];

$sql_check_user = "SELECT *FROM `users` 
                 WHERE username = '$user_name'
                 AND password = '$pass_word'";
$user_result = mysqli_query($conn, $sql_check_user);
if(mysqli_num_rows($user_result)== 1){
$row=mysqli_fetch_assoc($user_result);

//echo $row['fullname'] . "<br>";
//echo $row['user_type'];

if ($row['user_type']=='U'){

    echo "User already exist.";
    die();
}
else if($row['user_type']=='A'){
    echo "Admin already exist.";
    die();

}
else{
    echo "Not found.";
    die();
}


}      
}
?>
