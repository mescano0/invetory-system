<?php

include 'db.php';

if(!isset($_GET['id'])){
    die("RIS ID Missing");
}

$id = $_GET['id'];


// GET RIS DETAILS
$stmt = mysqli_prepare($conn,
"SELECT * FROM ris_requests WHERE id=?");

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$ris = mysqli_fetch_assoc($result);

$item_query = "

SELECT
ris_items.*,
products.item_name

FROM ris_items

LEFT JOIN products
ON ris_items.product_id = products.id

WHERE ris_items.ris_id=?

";

$item_stmt = mysqli_prepare($conn, $item_query);

mysqli_stmt_bind_param($item_stmt, "i", $id);

mysqli_stmt_execute($item_stmt);

$item_result = mysqli_stmt_get_result($item_stmt);


if(!$ris){
    die("RIS Not Found");
}


// UPDATE RIS
if(isset($_POST['update'])){

    mysqli_begin_transaction($conn);

    try{

        $office = trim($_POST['office']);
        $purpose = trim($_POST['purpose']);

        // UPDATE HEADER
        $update_query = "

        UPDATE ris_requests

        SET
        office=?,
        purpose=?

        WHERE id=?

        ";

        $update_stmt = mysqli_prepare($conn, $update_query);

        mysqli_stmt_bind_param(
            $update_stmt,
            "ssi",
            $office,
            $purpose,
            $id
        );

        mysqli_stmt_execute($update_stmt);

        // DELETE OLD ITEMS
        $delete_items = "
        DELETE FROM ris_items
        WHERE ris_id=?
        ";

        $delete_stmt = mysqli_prepare($conn, $delete_items);

        mysqli_stmt_bind_param(
            $delete_stmt,
            "i",
            $id
        );

        mysqli_stmt_execute($delete_stmt);

        // INSERT NEW ITEMS
        foreach($_POST['product_id'] as $index => $product_id){

            $other_item =
            trim($_POST['other_item'][$index]);

            $quantity_requested =
            $_POST['quantity_requested'][$index];

            $stock_available = "NO";
            $quantity_issued = 0;

            // OTHERS
            if($product_id == "others"){
                $product_id = NULL;
            }

            // CHECK INVENTORY
            if(!empty($product_id)){

                $product_query = "
                SELECT current_balance
                FROM products
                WHERE id=?
                ";

                $product_stmt =
                mysqli_prepare($conn, $product_query);

                mysqli_stmt_bind_param(
                    $product_stmt,
                    "i",
                    $product_id
                );

                mysqli_stmt_execute($product_stmt);

                $product_result =
                mysqli_stmt_get_result($product_stmt);

                $product =
                mysqli_fetch_assoc($product_result);

                if($product){

                    if(
                    $product['current_balance']
                    >=
                    $quantity_requested
                    ){

                        $stock_available = "YES";
                        $quantity_issued =
                        $quantity_requested;

                    }

                }

            }

            // INSERT ITEM
            $insert_item = "

            INSERT INTO ris_items
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
            ?,
            ?,
            ?,
            ?,
            ?,
            ?
            )

            ";

            $insert_stmt =
            mysqli_prepare($conn, $insert_item);

            mysqli_stmt_bind_param(
                $insert_stmt,
                "iisiss",
                $id,
                $product_id,
                $other_item,
                $quantity_requested,
                $quantity_issued,
                $stock_available
            );

            mysqli_stmt_execute($insert_stmt);

        }

        mysqli_commit($conn);

        header("Location: ris-list.php");

        exit;

    }catch(Exception $e){

        mysqli_rollback($conn);

        echo $e->getMessage();

    }

}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Edit RIS</title>

    <style>

        body{
            font-family: Arial;
        }

        input,
        textarea,
        select{
            width:100%;
            padding:8px;
            box-sizing:border-box;
        }

        button{
            padding:10px 20px;
        }

    </style>

</head>
<body>

<h2>Edit RIS</h2>

<form method="POST">

    <label>Office</label>
    <br>

    <input
    type="text"
    name="office"
    value="<?php echo htmlspecialchars($ris['office']); ?>"
    required>

    <br><br>

    <label>Purpose</label>
    <br>

    <textarea
    name="purpose"
    rows="5"
    required><?php
    echo htmlspecialchars($ris['purpose']);
    ?></textarea>

    <br><br>

    <table
    border="1"
    cellpadding="10"
    id="item_table">

    <tr>

        <th>Item</th>
        <th>Other Item</th>
        <th>Quantity</th>
        <th>Action</th>

    </tr>

    <?php while($item = mysqli_fetch_assoc($item_result)){ ?>

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

    $product_query =
    "SELECT * FROM products";

    $product_result =
    mysqli_query($conn, $product_query);

    while($product =
    mysqli_fetch_assoc($product_result)){ ?>

    <option
    value="<?php echo $product['id']; ?>"

    <?php
    if($item['product_id']
    ==
    $product['id']){
        echo "selected";
    }
    ?>

    >

    <?php echo $product['item_name']; ?>

    </option>

    <?php } ?>

    <option
    value="others"

    <?php
    if(empty($item['product_id'])){
        echo "selected";
    }
    ?>

    >

    Others

    </option>

    </select>

    </td>

    <td>

    <input
    type="text"
    name="other_item[]"
    class="other_input"

    value="<?php
    echo htmlspecialchars(
    $item['other_item']
    );
    ?>"

    <?php

    if(!empty($item['product_id'])){
        echo "style='display:none;'";
    }

    ?>

    >

    </td>

    <td>

    <input
    type="number"
    name="quantity_requested[]"

    value="<?php
    echo $item['quantity_requested'];
    ?>"

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

    <?php } ?>

    </table>

    <br>

    <button
    type="button"
    onclick="addRow()">

    + Add Item

    </button>    

    <br><br>

    <button type="submit" name="update">
        Update RIS
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

                $products =
                mysqli_query($conn,
                "SELECT * FROM products");

                while($prod =
                mysqli_fetch_assoc($products)){ ?>

                    <option
                    value="<?php echo $prod['id']; ?>">

                        <?php
                        echo $prod['item_name'];
                        ?>

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

            select.onchange = function(){

                let row =
                this.parentNode.parentNode;

                let otherInput =
                row.querySelector(".other_input");

                if(this.value == "others"){

                    otherInput.style.display =
                    "block";

                    otherInput.required =
                    true;

                } else {

                    otherInput.style.display =
                    "none";

                    otherInput.required =
                    false;

                    otherInput.value = "";

                }

            };

        });

    }



    attachEvents();

</script>

</body>
</html>