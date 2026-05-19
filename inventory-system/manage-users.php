<?php

include 'db.php';

session_start();

// ADMIN ONLY ACCESS
if(!isset($_SESSION['user_id'])){

    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != 'admin'){

    die("Access denied.");
}

// UPDATE ROLE
if(isset($_POST['update_role'])){

    $user_id = $_POST['user_id'];
    $role = $_POST['role'];

    $update =
    "UPDATE users
    SET role='$role'
    WHERE id='$user_id'";

    mysqli_query($conn, $update);

    echo "
    <script>
    alert('Role updated successfully.');
    window.location.href='manage-users.php';
    </script>
    ";
}

// FETCH USERS
$query =
"SELECT * FROM users
ORDER BY last_name ASC";

$result =
mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Manage Users</title>

    <style>

        body{
            font-family: Arial;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td{
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        select{
            padding: 5px;
        }

        button{
            padding: 5px 10px;
            cursor: pointer;
        }

    </style>

</head>

<body>

<h2>Manage Users</h2>

<table>

<tr>

    <th>Name</th>
    <th>Email</th>
    <th>Position Title</th>
    <th>Division</th>
    <th>Current Role</th>
    <th>Change Role</th>
    <th>Action</th>

</tr>

<?php while($user = mysqli_fetch_assoc($result)){ ?>

<tr>

    <td>

        <?php

        echo
        $user['first_name'];

        if(!empty($user['middle_initial'])){

            echo
            " " .
            $user['middle_initial'] .
            ".";
        }

        echo
        " " .
        $user['last_name'];

        ?>

    </td>

    <td>
        <?php echo $user['email']; ?>
    </td>

    <td>
        <?php echo $user['position_title']; ?>
    </td>

    <td>
        <?php echo $user['division']; ?>
    </td>

    <td>
        <?php echo strtoupper($user['role']); ?>
    </td>

    <td>

        <form method="POST">

            <input
            type="hidden"
            name="user_id"
            value="<?php echo $user['id']; ?>">

            <select name="role" required>

                <option value="user"
                <?php
                if($user['role'] == 'user'){
                    echo 'selected';
                }
                ?>>
                    USER
                </option>

                <option value="supply_officer"
                <?php
                if($user['role'] == 'supply_officer'){
                    echo 'selected';
                }
                ?>>
                    SUPPLY OFFICER
                </option>

                <option value="admin"
                <?php
                if($user['role'] == 'admin'){
                    echo 'selected';
                }
                ?>>
                    ADMIN
                </option>

            </select>

    </td>

    <td>

            <button
            type="submit"
            name="update_role">

                Update

            </button>

        </form>

    </td>

</tr>

<?php } ?>

</table>

</body>
</html>
