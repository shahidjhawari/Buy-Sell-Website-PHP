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

    if ($con->query($sql) === TRUE) { ?>
        <script> window.location.href = "home.php"</script>
    <?php } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $_SESSION['form_submitted'] = true;
}

$sql = "SELECT * FROM admissions WHERE user_id = '$user_id'";
$result = $con->query($sql);
?>

<style>
    .post-box {
        margin-top: 200px;
    }
</style>

<div class="container post-box">
    <form method="post" enctype="multipart/form-data">
    <div class="form-group">
            <label for="fullName">Full Name:</label>
            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter Full Name" required>
        </div>
        <div class="form-group">
            <label for="fatherName">Father Name:</label>
            <input type="text" class="form-control" id="fatherName" name="fatherName" placeholder="Enter Father Name" required>
        </div>
        <div class="form-group">
            <label for="cnic">CNIC:</label>
            <input type="text" class="form-control" maxlength="13" id="cnic" name="cnic" placeholder="Enter CNIC" required>
        </div>
        <div class="form-group">
            <label for="phoneNumber">WhatsApp Number:</label>
            <input type="text" class="form-control" id="phoneNumber" maxlength="11" name="phoneNumber" placeholder="Enter Whatsapp Number" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" maxlength="30" id="email" name="email" placeholder="Enter Email" required>
        </div>
        <div class="form-group">
            <label for="select1">Select Courses:</label>
            <select class="form-control" id="select1" name="select1" required>
                <option value="Web Development">Web Development</option>
                <option value="Web Designing">Web Designing</option>
                <option value="Ethical Hacking">Ethical Hacking</option>
            </select>
        </div>
        <div class="form-group">
            <label for="fileToUpload">Upload Image:</label>
            <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-warning mt-3 mb-5">Submit</button>
    </form>
</div>

<?php require('footer.php'); ?>
