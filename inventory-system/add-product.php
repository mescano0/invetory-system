<?php
include 'db.php';

if (isset($_POST['save'])) {

    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $unit = $_POST['unit'];
    $stock_number = $_POST['stock_number'];
    $reorder_point = $_POST['reorder_point'];

    $query = "INSERT INTO products 
    (item_name, description, unit, stock_number, reorder_point)
    
    VALUES 
    
    ('$item_name', '$description', '$unit', '$stock_number', '$reorder_point')";

    mysqli_query($conn, $query);

    echo "Product Added Successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>

<h2>Add Product</h2>

<form method="POST">

    <label>Item Name</label><br>
    <input type="text" name="item_name" required><br><br>

    <label>Description</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Unit</label><br>
    <input type="text" name="unit"><br><br>

    <label>Stock Number</label><br>
    <input type="text" name="stock_number"><br><br>

    <label>Re-order Point</label><br>
    <input type="number" name="reorder_point"><br><br>

    <button type="submit" name="save">Save Product</button>

</form>

</body>
</html>