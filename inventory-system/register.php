<?php
include 'db.php';

if(isset($_POST['register'])){

    // CONVERT TO UPPERCASE
    $last_name =
    strtoupper(trim($_POST['last_name']));

    $first_name =
    strtoupper(trim($_POST['first_name']));

    $middle_initial =
    strtoupper(trim($_POST['middle_initial']));

    $email = trim($_POST['email']);

    $position_title =
    strtoupper($_POST['position_title']);

    $division =
    strtoupper($_POST['division']);

    $password = $_POST['password'];

    // PASSWORD VALIDATION
    $password_pattern =
    "/^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$/";

    // STOP IMMEDIATELY IF INVALID
    if(!preg_match($password_pattern, $password)){

        echo "
        <script>
        alert('Password must be at least 8 characters and contain letters, numbers, and special characters.');
        window.history.back();
        </script>
        ";

        exit();
    }

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

    if(mysqli_num_rows($check_result) > 0){

        echo "
        <script>
        alert('Email already exists.');
        window.history.back();
        </script>
        ";

        exit();
    }

    mysqli_stmt_close($check_stmt);

    // HASH PASSWORD
    $hashed_password =
    password_hash($password, PASSWORD_DEFAULT);

    $role = 'user';

    // SECURED INSERT
    $sql = "INSERT INTO users
    (
        last_name,
        first_name,
        middle_initial,
        email,
        password,
        position_title,
        division,
        role
    )

    VALUES

    (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt =
    mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $last_name,
        $first_name,
        $middle_initial,
        $email,
        $hashed_password,
        $position_title,
        $division,
        $role
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    echo "
    <script>
    alert('Account created successfully!');
    window.location.href='login.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html>
<head>

    <title>Sign Up</title>

    <style>

        body{
            font-family: Arial;
        }

        .container{
            width: 400px;
            margin: auto;
            margin-top: 50px;
        }

        input, select{
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

        /* AUTO UPPERCASE */
        .uppercase{
            text-transform: uppercase;
        }

    </style>

</head>

<body>

<div class="container">

<h2>Sign Up</h2>

<form method="POST">

    <label>Last Name</label><br>

    <input
    type="text"
    name="last_name"
    class="uppercase"
    required>

    <br><br>

    <label>First Name</label><br>

    <input
    type="text"
    name="first_name"
    class="uppercase"
    required>

    <br><br>

    <label>Middle Initial (Optional)</label><br>

    <input
    type="text"
    name="middle_initial"
    class="uppercase"
    maxlength="5">

    <br><br>

    <label>Email</label><br>

    <input
    type="email"
    name="email"
    required>

    <br><br>

    <label>Position Title</label><br>

    <select
    name="position_title"
    class="uppercase"
    required>

        <option value="">-- Select Position --</option>
        <option value="Accountant">Accountant</option>
        <option value="Administrative Aide IV">Administrative Aide IV</option>
        <option value="Administrative Assistant I">Administrative Assistant I</option>
        <option value="Administrative Assistant III">Administrative Assistant III</option>
        <option value="Administrative Officer II">Administrative Officer II</option>
        <option value="Administrative Officer III">Administrative Officer III</option>
        <option value="Administrative Officer V">Administrative Officer V</option>
        <option value="Budget and Management Specialist I">Budget and Management Specialist I</option>
        <option value="Budget and Management Specialist II">Budget and Management Specialist II</option>
        <option value="Chief Budget and Management Specialist">Chief Budget and Management Specialist</option>
        <option value="Chief Administrative Officer">Chief Administrative Officer</option>
        <option value="Computer Maitenance Technologist I">Computer Maitenance Technologist I</option>
        <option value="Director III">Director III</option>
        <option value="Director IV">Director IV</option>
        <option value="Senior Budget and Management Specialist">Senior Budget and Management Specialist</option>
        <option value="Supervising Administrative Officer">Supervising Administrative Officer</option>
        <option value="Supervising Budget and Management Specialist">Supervising Budget and Management Specialist</option>
    </select>

    <br><br>

    <label>Division</label><br>

    <select
    name="division"
    class="uppercase"
    required>

        <option value=""> -- Select Division --</option>
        <option value="Fianance and Administrative Division">
            Finance and Administrative Division
        </option>

        <option value="Technical Division A">
            Technical Division A
        </option>

        <option value="Technical Division B">
            Technical Division B
        </option>

        <option value="Technical Division C">
            Technical Division C
        </option>

    </select>

    <br><br>

    <label>Password</label><br>

    <input
    type="password"
    name="password"
    pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[\W_]).{8,}$"
    title="Password must be at least 8 characters and contain letters, numbers, and special characters."
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
    name="register">

        Sign Up

    </button>

</form>

</div>

</body>
</html>