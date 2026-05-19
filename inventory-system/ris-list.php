<?php
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if($role == 'user'){
    $query = "SELECT * FROM ris_requests WHERE user_id = $user_id ORDER BY id DESC";
} else {
    $query = "SELECT * FROM ris_requests ORDER BY id DESC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<body>

<!-- TOP BAR -->
<div style="background:#1f2937;color:white;padding:15px;display:flex;justify-content:space-between;">
    <div><b>RIS SYSTEM</b></div>
    <div>
        <a href="profile.php" style="color:white;">Profile</a> |
        <a href="change-password.php" style="color:white;">Change Password</a> |
        <a href="logout.php" style="color:white;">Logout</a>
    </div>
</div>

<div style="display:flex;">

<!-- SIDEBAR -->
<div style="width:250px;background:white;height:100vh;padding:15px;">

<?php if($role == 'admin'){ ?>

    <a href="create-ris.php">Create RIS</a><br>
    <a href="products.php">List of Stocks</a><br>
    <a href="purchase-request.php">Purchase Request</a><br>
    <a href="purchase-order.php">Purchase Order</a><br>
    <a href="iar.php">Inspection & Acceptance</a><br>
    <a href="manage-users.php">Role Assignment</a><br>

<?php } elseif($role == 'user'){ ?>

    <a href="create-ris.php">Create RIS</a><br>
    <a href="products.php">List of Stocks</a><br>

<?php } elseif($role == 'supply_officer'){ ?>

    <a href="create-ris.php">Create RIS</a><br>
    <a href="products.php">List of Stocks</a><br>
    <a href="purchase-request.php">Purchase Request</a><br>
    <a href="purchase-order.php">Purchase Order</a><br>
    <a href="iar.php">Inspection & Acceptance</a><br>

<?php } ?>

</div>

<!-- CONTENT -->
<div style="flex:1;padding:20px;">

<h2>RIS Dashboard</h2>

<?php if($role == 'user'){ ?>
    <h3>My Created RIS</h3>
<?php } else { ?>
    <h3>All RIS Records</h3>
<?php } ?>

<table border="1" width="100%" cellpadding="10">

<tr>
    <th>RIS Number</th>
    <th>Office</th>
    <th>Purpose</th>
    <th>Date</th>
    <th>Status</th>
    <th>Action</th>
    
</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr>
    <td><?= $row['ris_number']; ?></td>
    <td><?= $row['office']; ?></td>
    <td><?= $row['purpose']; ?></td>
    <td><?= $row['request_date']; ?></td>
    <td><?= $row['status']; ?></td>
    <td>
        <a href="view-ris.php?id=<?= $row['id']; ?>">View</a> |
        <a href="edit-ris.php?id=<?= $row['id']; ?>">Edit</a> |
        <a href="delete-ris.php?id=<?= $row['id']; ?>">Delete</a> |

        <?php if(($role == 'admin' || $role == 'supply_officer') 
        && $row['status'] == 'Pending'){ ?>
                <a href="purchase-ris.php?id=<?= $row['id']; ?>">
                Purchase
                </a>
    </td>



    <?php } else { ?>

    <td>-</td>

    <?php } ?>
</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>
