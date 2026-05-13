<?php

include 'db.php';

$product_query = "SELECT * FROM products";
$product_result = mysqli_query($conn, $product_query);

if(isset($_POST['submit'])){

    $office = $_POST['office'];
    $purpose = $_POST['purpose'];
    $request_date = date('Y-m-d');

    // GENERATE RIS NUMBER
    $ris_number = "RIS-" . date('YmdHis');

    // SAVE RIS HEADER
    $insert_ris = "INSERT INTO ris_requests
    (ris_number, office, purpose, request_date)

    VALUES

    ('$ris_number', '$office', '$purpose', '$request_date')";

    mysqli_query($conn, $insert_ris);

    $ris_id = mysqli_insert_id($conn);

    // LOOP ALL ITEMS
    foreach($_POST['product_id'] as $index => $product_id){

        $other_item = $_POST['other_item'][$index];
        $quantity_requested = $_POST['quantity_requested'][$index];

        // DEFAULT VALUES
        $stock_available = "NO";
        $quantity_issued = 0;

        // CHECK IF INVENTORY ITEM
        if($product_id != "others"){

            $product_sql = "SELECT * FROM products
            WHERE id='$product_id'";

            $product_result2 =
            mysqli_query($conn, $product_sql);

            $product =
            mysqli_fetch_assoc($product_result2);

            $current_balance =
            $product['current_balance'];

            // STOCK CHECKING
            if($current_balance >= $quantity_requested){

                $stock_available = "YES";
                $quantity_issued = $quantity_requested;

            }

        }

        // SAVE RIS ITEM
        $insert_item = "INSERT INTO ris_items
        (
        ris_id,
        product_id,
        other_item,
        quantity_requested,
        quantity_issued,
        stock_available
        )

        VALUES

        (
        '$ris_id',
        '$product_id',
        '$other_item',
        '$quantity_requested',
        '$quantity_issued',
        '$stock_available'
        )";

        mysqli_query($conn, $insert_item);

    }

    echo "RIS Created Successfully!";

}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Create RIS</title>

    <style>

        table{
            border-collapse: collapse;
            width: 100%;
        }

        td, th{
            border:1px solid black;
            padding:10px;
        }

    </style>

</head>
<body>

<h2>Requisition and Issue Slip</h2>

<form method="POST">

    <label>Office</label><br>
    <input type="text" name="office" required>

    <br><br>

    <label>Purpose</label><br>
    <textarea name="purpose"></textarea>

    <br><br>

    <table id="item_table">

        <tr>

            <th>Item</th>
            <th>Other Item</th>
            <th>Quantity</th>
            <th>Action</th>

        </tr>

        <tr>

            <td>

                <select
                name="product_id[]"
                class="product_select"
                required>

                    <option value="">
                        -- Select Item --
                    </option>

                    <?php
                    $product_result =
                    mysqli_query($conn, $product_query);

                    while($row =
                    mysqli_fetch_assoc($product_result)){ ?>

                        <option
                        value="<?php echo $row['id']; ?>">

                            <?php echo $row['item_name']; ?>

                            (Available:
                            <?php echo $row['current_balance']; ?>)

                        </option>

                    <?php } ?>

                    <option value="others">
                        Others
                    </option>

                </select>

            </td>

            <td>

                <input
                type="text"
                name="other_item[]"
                class="other_input"
                style="display:none;">

            </td>

            <td>

                <input
                type="number"
                name="quantity_requested[]"
                required>

            </td>

            <td>

                <button
                type="button"
                onclick="removeRow(this)">

                    Remove

                </button>

            </td>

        </tr>

    </table>

    <br>

    <button type="button" onclick="addRow()">
        + Add Item
    </button>

    <br><br>

    <button type="submit" name="submit">
        Submit RIS
    </button>

</form>

<script>

function addRow(){

    let table =
    document.getElementById("item_table");

    let row = table.insertRow();

    row.innerHTML = `

    <td>

        <select
        name="product_id[]"
        class="product_select"
        required>

            <option value="">
                -- Select Item --
            </option>

            <?php
            $product_result =
            mysqli_query($conn, $product_query);

            while($row =
            mysqli_fetch_assoc($product_result)){ ?>

                <option
                value="<?php echo $row['id']; ?>">

                    <?php echo $row['item_name']; ?>

                    (Available:
                    <?php echo $row['current_balance']; ?>)

                </option>

            <?php } ?>

            <option value="others">
                Others
            </option>

        </select>

    </td>

    <td>

        <input
        type="text"
        name="other_item[]"
        class="other_input"
        style="display:none;">

    </td>

    <td>

        <input
        type="number"
        name="quantity_requested[]"
        required>

    </td>

    <td>

        <button
        type="button"
        onclick="removeRow(this)">

            Remove

        </button>

    </td>

    `;

    attachEvents();

}

function removeRow(button){

    let row =
    button.parentNode.parentNode;

    row.remove();

}

function attachEvents(){

    let selects =
    document.querySelectorAll(".product_select");

    selects.forEach(function(select){

        select.addEventListener("change", function(){

            let row =
            this.parentNode.parentNode;

            let otherInput =
            row.querySelector(".other_input");

            if(this.value == "others"){

                otherInput.style.display = "block";

            } else {

                otherInput.style.display = "none";

            }

        });

    });

}

attachEvents();

</script>

</body>
</html>