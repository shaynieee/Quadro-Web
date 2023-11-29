<?php
include_once("db.php");

if(isset($_POST['uname'])){
    $user_name = $_POST['uname'];
    $pass_word = $_POST['pass1'];

$sql_check_user = "SELECT *FROM users 
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

<?php
include_once("db.php");

if (isset($_POST['fullname'])) {
    $full_name = $_POST['fullname'];
    $user_name = $_POST['uname'];
    $email_address = $_POST['email_address'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $pass_word = $_POST['pass1'];
    $conf_pass_word = $_POST['pass2'];

    if ($pass_word != $conf_pass_word) {
        echo "Password Mismatch";
        die();
    }
        $sql_check_user = "SELECT * FROM users
        WHERE user_fullname ='$full_name' 
        OR username ='$user_name'";

        $user_result = mysqli_query($conn, $sql_check_user);
        if (mysqli_num_rows($user_result) > 0) {
            header("location: registration.php?error=alreadyexist");
        }
       else { 
        $sql_insert_user = "INSERT INTO users 
        (user_fullname, username, password, contact_number, email_address, user_address) 
        VALUES 
        ('$full_name', '$user_name', '$pass_word', '$contact_number','$email_address', '$address')";

    
        mysqli_query($conn, $sql_insert_user);
                header("location: index.php?msg=userregistered");

                
        
            }
    }
    else{
        header("location: registration.php?error=notallowed"); 
    }


?>