<?php
include_once("db.php");
session_start();

if (isset($_POST['uname']) && isset($_POST['pass1'])) {
    $user_name = $_POST['uname'];
    $pass_word = $_POST['pass1'];

    $sql_get_user_data = "SELECT * FROM users
                          WHERE username = '$user_name'
                          AND password = '$pass_word'";
    
    $user_result = mysqli_query($conn, $sql_get_user_data);

    if (mysqli_num_rows($user_result) > 0) {
        $row = mysqli_fetch_assoc($user_result);

        $_SESSION['user_info'] = [
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            // Add other user-related information as needed
        ];

        $_SESSION['user_global_info'] = [
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            'user_fullname' => $row['user_fullname'],
            'user_status' => $row['user_status'],
            'user_type' => $row['user_type'],
            'email_address' => $row['email_address'],
            'contact_number' => $row['contact_number'],
            'user_address' => $row['user_address']
        ];

        // Redirect based on user type
        if ($row['user_type'] == 'A') {
            header("location: admin/");
        } else if ($row['user_type'] == 'U') {
            header("location: user/");
        } else {
            header("location: log_in.php");
        }
    } else {
        header("location: log_in.php?error=777");
    }
} else {
    header("location: log_in.php?msg=notallowed");
}
?>