<?php

include 'db.php';

$id = $_GET['id'];

$product_query = "SELECT * FROM products WHERE id='$id'";
$product_result = mysqli_query($conn, $product_query);
$product = mysqli_fetch_assoc($product_result);

$movement_query = "SELECT * FROM stock_movements 
WHERE product_id='$id'
ORDER BY transaction_date ASC";

$movement_result = mysqli_query($conn, $movement_query);

?>

<!DOCTYPE html>
<html>
<head>

    <title>Stock Card</title>

    <style>

        body{
            font-family: Arial;
        }

        table{
            border-collapse: collapse;
            width: 100%;
        }

        td, th{
            border: 1px solid black;
            padding: 5px;
            font-size: 12px;
        }

        .center{
            text-align: center;
        }

    </style>

</head>
<body>

<h2 class="center">STOCK CARD</h2>

<table>

<tr>
    <td><b>Entity Name:</b></td>
    <td colspan="3">Department of Budget and Management ROIV-A</td>

    <td><b>Fund Cluster:</b></td>
    <td>01101101</td>
</tr>

<tr>
    <td><b>Item:</b></td>
    <td colspan="3"><?php echo $product['item_name']; ?></td>

    <td><b>Stock Number:</b></td>
    <td><?php echo $product['stock_number']; ?></td>
</tr>

<tr>
    <td><b>Description:</b></td>
    <td colspan="3"><?php echo $product['description']; ?></td>

    <td><b>Re-order Point:</b></td>
    <td><?php echo $product['reorder_point']; ?></td>
</tr>

<tr>
    <td><b>Unit of Measurement:</b></td>
    <td colspan="5"><?php echo $product['unit']; ?></td>
</tr>

</table>

<br>

<table>

<tr>

    <th rowspan="2">Date</th>
    <th rowspan="2">Reference</th>

    <th colspan="1">RECEIPT</th>
    <th colspan="2">ISSUE</th>
    <th colspan="1">BALANCE</th>

    <th rowspan="2">No. of Days to Consume</th>

</tr>

<tr>

    <th>Quantity</th>

    <th>Quantity</th>
    <th>Office</th>

    <th>Quantity</th>

</tr>

<?php while($row = mysqli_fetch_assoc($movement_result)) { ?>

<tr>

    <td>
        <?php echo date('d-M-y', strtotime($row['transaction_date'])); ?>
    </td>

    <td>
        <?php echo $row['reference_no']; ?>
    </td>

    <td class="center">

        <?php
        if($row['transaction_type'] == 'RECEIPT'){
            echo $row['quantity'];
        }
        ?>

    </td>

    <td class="center">

        <?php
        if($row['transaction_type'] == 'ISSUE'){
            echo $row['quantity'];
        }
        ?>

    </td>

    <td>
        <?php echo $row['office']; ?>
    </td>

    <td class="center">
        <?php echo $row['balance_after']; ?>
    </td>

    <td></td>

</tr>

<?php } ?>

</table>

</body>
</html>