<?php
require('top.php');

if (!isset($_SESSION['USER_LOGIN'])) {
?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php
    exit;
}

$user_id = $_SESSION['USER_ID'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $con->real_escape_string($_POST['fullName']);
    $father_name = $con->real_escape_string($_POST['fatherName']);
    $cnic = $con->real_escape_string($_POST['cnic']);
    $phone_number = $con->real_escape_string($_POST['phoneNumber']);
    $email = $con->real_escape_string($_POST['email']);
    $select_option = $con->real_escape_string($_POST['select1']);

    $target_dir = PRODUCT_IMAGE_SERVER_PATH;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $image_name = basename($_FILES["fileToUpload"]["name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    $sql = "INSERT INTO admissions (user_id, full_name, father_name, cnic, phone_number, email, select_option, image_path)
            VALUES ('$user_id', '$full_name', '$father_name', '$cnic', '$phone_number', '$email', '$select_option', '$image_name')";

    if ($con->query($sql) === TRUE) {
        echo "<p class='msg-feild'>Your form was sent successfully. We will contact you on your phone number.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $_SESSION['form_submitted'] = true;
}

$sql = "SELECT * FROM admissions WHERE user_id = '$user_id'";
$result = $con->query($sql);
?>

<style>
    .table {
        margin-top: 150px;
    }

    .btn {
        margin-top: 200px;
    }
</style>

<div class="container">
    <?php
    if ($result->num_rows > 0) {
    ?>
        <table class="table table-responsive">
            <i class="fas fa-plus"></i>
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $row["id"]; ?></th>
                        <td><?php echo $row['full_name'] ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php
    } else {
        echo "<div style='text-align: center;'>";
        echo "<a href='#' class='btn btn-warning'><i class='fas fa-plus'></i></a>";
        echo "<spam>fds</span></div>";
    }
    ?>
</div>



<?php require('footer.php'); ?>