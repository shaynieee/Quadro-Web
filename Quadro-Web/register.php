<?php
include_once("db.php");
session_start();

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

    $sql_check_user = "SELECT * FROM `users`
        WHERE `user_fullname` ='$full_name' 
        OR `username` ='$user_name'";

    $user_result = mysqli_query($conn, $sql_check_user);
    
    if (mysqli_num_rows($user_result) > 0) {
        header("location: registration.php?error=alreadyexist");
    } else { 
        $sql_insert_user = "INSERT INTO users 
        (`user_fullname`, `username`, `password`, `contact_number`, `email_address`, `user_address`) 
        VALUES 
        ('$full_name', '$user_name', '$pass_word', '$contact_number','$email_address', '$address')";

        mysqli_query($conn, $sql_insert_user);

        // Set session for the newly registered user
        $new_user_id = mysqli_insert_id($conn); // Get the ID of the newly inserted user
        $_SESSION['user_info'] = array(
            'user_id' => $new_user_id,
            'username' => $user_name,
            'fullname' => $full_name,
            'usertype' => 'U', // Assuming a default user type for newly registered users
            'user_status' => 'active' // Assuming a default status for newly registered users
        );

        header("location: log_in.php?msg=userregistered");
    }
} else {
    header("location: registration.php?error=notallowed");
}
?>