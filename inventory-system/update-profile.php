<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update'])){

    $last_name = strtoupper(trim($_POST['last_name']));
    $first_name = strtoupper(trim($_POST['first_name']));
    $middle_initial = strtoupper(trim($_POST['middle_initial']));
    $position_title = strtoupper(trim($_POST['position_title']));
    $division = strtoupper(trim($_POST['division']));

    // DEFAULT: keep old image
    $profile_pic_name = null;

    // CHECK IF NEW IMAGE UPLOADED
    if(!empty($_FILES['profile_pic']['name'])){

        $target_dir = "uploads/";

        $profile_pic_name = time() . "_" . basename($_FILES["profile_pic"]["name"]);
        $target_file = $target_dir . $profile_pic_name;

        move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file);
    }

    // IF IMAGE UPDATED
    if($profile_pic_name){

        $sql = "UPDATE users 
                SET last_name=?, first_name=?, middle_initial=?, position_title=?, division=?, profile_pic=? 
                WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssi",
            $last_name,
            $first_name,
            $middle_initial,
            $position_title,
            $division,
            $profile_pic_name,
            $user_id
        );

    } else {

        // NO IMAGE UPDATE
        $sql = "UPDATE users 
                SET last_name=?, first_name=?, middle_initial=?, position_title=?, division=? 
                WHERE id=?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssssi",
            $last_name,
            $first_name,
            $middle_initial,
            $position_title,
            $division,
            $user_id
        );
    }

    if($stmt->execute()){
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating profile.";
    }
}
?>