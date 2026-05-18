<?php
include 'db.php';

if(isset($_POST['reset_password'])){

    $email = trim($_POST['email']);

    $new_password =
    $_POST['new_password'];

    $confirm_password =
    $_POST['confirm_password'];

    // CHECK IF EMAIL EXISTS (SECURED)
    $check_sql =
    "SELECT id FROM users WHERE email = ?";

    $check_stmt =
    mysqli_prepare($conn, $check_sql);

    mysqli_stmt_bind_param(
        $check_stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($check_stmt);

    $check_result =
    mysqli_stmt_get_result($check_stmt);

    if(mysqli_num_rows($check_result) == 0){

        echo "
        <script>
        alert('Email not found.');
        </script>
        ";

        exit();
    }

    mysqli_stmt_close($check_stmt);

    // CHECK PASSWORD MATCH
    if($new_password != $confirm_password){

        echo "
        <script>
        alert('Passwords do not match.');
        </script>
        ";

        exit();
    }

    // PASSWORD VALIDATION
    $password_pattern =
    "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/";

    if(!preg_match($password_pattern, $new_password)){

        echo "
        <script>
        alert('Password must be at least 8 characters and contain letters, numbers, and special characters.');
        </script>
        ";

        exit();
    }

    // HASH PASSWORD
    $hashed_password =
    password_hash($new_password, PASSWORD_DEFAULT);

    // SECURED UPDATE PASSWORD
    $update_sql =
    "UPDATE users
    SET password = ?
    WHERE email = ?";

    $update_stmt =
    mysqli_prepare($conn, $update_sql);

    mysqli_stmt_bind_param(
        $update_stmt,
        "ss",
        $hashed_password,
        $email
    );

    mysqli_stmt_execute($update_stmt);

    mysqli_stmt_close($update_stmt);

    echo "
    <script>
    alert('Password reset successfully.');
    window.location.href='login.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Forgot Password</title>

    <style>

        body{
            font-family: Arial;
        }

        .container{
            width: 400px;
            margin: auto;
            margin-top: 100px;
        }

        input{
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button{
            padding: 10px 20px;
            margin-top: 15px;
            cursor: pointer;
        }

    </style>

</head>

<body>

<div class="container">

<h2>Forgot Password</h2>

<form method="POST">

    <label>Email</label><br>

    <input
    type="email"
    name="email"
    required>

    <br><br>

    <label>New Password</label><br>

    <input
    type="password"
    name="new_password"
    pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$"
    title="Password must be at least 8 characters and contain letters, numbers, and special characters."
    required>

    <br><br>

    <label>Confirm Password</label><br>

    <input
    type="password"
    name="confirm_password"
    required>

    <br><br>

    <small>
        Password must be at least 8 characters
        and contain letters, numbers,
        and special characters.
    </small>

    <br><br>

    <button
    type="submit"
    name="reset_password">

        Reset Password

    </button>

</form>

</div>

</body>
</html>