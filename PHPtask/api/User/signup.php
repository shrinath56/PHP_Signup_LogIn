<?php
 
// database connection
include_once '../database/database.php';
 include_once '../object/user.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
$user->username = $_POST['username'];
$user->password = base64_encode($_POST['password']);
 
// create user
if($user->signup()){
    $user_arr=array(
        "status" => true,
        "message" => "Successfully Signup!",
        "id" => $user->id,
        "username" => $user->username
    );
}
else{
    $user_arr=array(
        "status" => false,
        "message" => "Username already exists!"
    );
}
print_r(json_encode($user_arr));
?>