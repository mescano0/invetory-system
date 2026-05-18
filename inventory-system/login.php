<?php

include 'db.php';

session_start();

if(isset($_POST['login'])){

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // PREPARED STATEMENT
    $sql = "SELECT * FROM users WHERE email = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result =
    mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){

        $user = mysqli_fetch_assoc($result);

        // VERIFY PASSWORD
        if(password_verify($password, $user['password'])){

            // REGENERATE SESSION ID
            session_regenerate_id(true);

            // CREATE SESSION
            $_SESSION['user_id'] =
            $user['id'];

            $_SESSION['last_name'] =
            $user['last_name'];

            $_SESSION['first_name'] =
            $user['first_name'];

            $_SESSION['middle_initial'] =
            $user['middle_initial'];

            $_SESSION['email'] =
            $user['email'];

            $_SESSION['position_title'] =
            $user['position_title'];

            $_SESSION['division'] =
            $user['division'];

            $_SESSION['role'] =
            $user['role'];

            // ROLE-BASED REDIRECT
            if($user['role'] == 'admin'){

                header("Location: products.php");

            } elseif($user['role'] == 'supply_officer'){

                header("Location: products.php");

            } else {

                header("Location: products.php");
            }

            exit();

        } else {

            echo "
            <script>
            alert('Invalid email or password.');
            </script>
            ";
        }

    } else {

        echo "
        <script>
        alert('Invalid email or password.');
        </script>
        ";
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

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

<h2>Login</h2>

<form method="POST">

    <label>Email</label><br>

    <input
    type="email"
    name="email"
    required>

    <br><br>

    <label>Password</label><br>

    <input
    type="password"
    name="password"
    required>

    <br>

    <a href="forgot-password.php">
        Forgot Password?
    </a>

    <br><br>

    <button
    type="submit"
    name="login">

        Login

    </button>

</form>

</div>

</body>
</html>