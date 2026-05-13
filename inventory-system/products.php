<?php
include 'db.php';

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock List</title>

    <style>

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>

</head>
<body>

<h2>Item List</h2>

<a href="add-product.php">Add Item</a>

<br><br>

<table>

    <tr>
        
        <th>Item Name</th>
        <th>Description</th>
        <th>Unit</th>
        <th>Stock Number</th>
        <th>Re-order Point</th>
        <th>Current Balance</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)) { ?>

    <tr>


        <td><?php echo $row['item_name']; ?></td>

        <td><?php echo $row['description']; ?></td>

        <td><?php echo $row['unit']; ?></td>

        <td><?php echo $row['stock_number']; ?></td>

        <td><?php echo $row['reorder_point']; ?></td>

        <td><?php echo $row['current_balance']; ?></td>

        <td>
            <a href="stock-card.php?id=<?php echo $row['id']; ?>">
                 View Stock Card
            </a>
        </td>

    </tr>

    <?php } ?>

</table>

</body>
</html>