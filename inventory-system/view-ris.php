<?php

include 'db.php';

$ris_id = $_GET['id'];

$ris_query = "SELECT * FROM ris_requests
WHERE id='$ris_id'";

$ris_result = mysqli_query($conn, $ris_query);

$ris = mysqli_fetch_assoc($ris_result);

$item_query = "SELECT ris_items.*, products.item_name, products.unit

FROM ris_items

LEFT JOIN products
ON ris_items.product_id = products.id

WHERE ris_items.ris_id='$ris_id'";

$item_result = mysqli_query($conn, $item_query);

?>

<!DOCTYPE html>
<html>
<head>

<title>RIS Form</title>

<style>

body{
    font-family: Arial;
}

table{
    border-collapse: collapse;
    width: 100%;
}

td, th{
    border:1px solid black;
    padding:5px;
    font-size:12px;
}

.center{
    text-align:center;
}

</style>

</head>

<body>

<h2 class="center">
REQUISITION AND ISSUE SLIP
</h2>

<table>

<tr>

<td><b>Entity Name:</b></td>

<td colspan="4">
Department of Budget and Management ROIV-A
</td>

<td><b>Fund Cluster:</b></td>

<td>01101101</td>

</tr>

<tr>

<td colspan="4">
<b><?php echo $ris['office']; ?></b>
</td>

<td colspan="3">

<b>RIS Number:</b>

<?php echo $ris['ris_number']; ?>

</td>

</tr>

</table>

<br>

<table>

<tr>

<th>Unit</th>
<th>Description</th>
<th>Requested Qty</th>
<th>Available?</th>
<th>Issue Qty</th>
<th>Remarks</th>

</tr>

<?php while($item = mysqli_fetch_assoc($item_result)){ ?>

<tr>

<td>
<?php echo $item['unit']; ?>
</td>

<td>
<?php echo $item['item_name']; ?>
</td>

<td class="center">
<?php echo $item['quantity_requested']; ?>
</td>

<td class="center">
<?php echo $item['stock_available']; ?>
</td>

<td class="center">
<?php echo $item['quantity_issued']; ?>
</td>

<td></td>

</tr>

<?php } ?>

</table>

<br>

<table>

<tr>

<td>
Purpose:
<?php echo $ris['purpose']; ?>
</td>

</tr>

</table>

<br><br>

<table>

<tr>

<td class="center">
Requested by:
</td>

<td class="center">
Approved by:
</td>

<td class="center">
Issued by:
</td>

<td class="center">
Received by:
</td>

</tr>

<tr>

<td height="50"></td>
<td></td>
<td></td>
<td></td>

</tr>

</table>

</body>
</html>