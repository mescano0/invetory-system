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