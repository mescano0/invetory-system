<?php
include 'db.php';

$query = "SELECT * FROM ris_requests ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>RIS List</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        .Pending { background: orange; color: white; }
        .Approved { background: blue; color: white; }
        .Issued { background: green; color: white; }
    </style>
</head>
<body>

<h2>All RIS Requests</h2>

<table>
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

            <td class="<?= $row['status']; ?>">
                <?= $row['status']; ?>
            </td>

            <td>
                <a href="view-ris.php?id=<?= $row['id']; ?>">View</a>
            </td>
        </tr>

    <?php } ?>

</table>

</body>
</html>