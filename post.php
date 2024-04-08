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
    $product_name = $con->real_escape_string($_POST['productName']);
    $price = $con->real_escape_string($_POST['price']);
    $detail = $con->real_escape_string($_POST['detail']);
    $select_option = $con->real_escape_string($_POST['select1']);
    $phone_number = $con->real_escape_string($_POST['phoneNumber']);
    $address = $con->real_escape_string($_POST['address']);

    $image_names = array();

    foreach ($_FILES['fileToUpload']['tmp_name'] as $key => $tmp_name) {
        if (count($_FILES['fileToUpload']['tmp_name']) < 3 || count($_FILES['fileToUpload']['tmp_name']) > 10) {
            echo "You must upload minimum 3 and maximum 10 images.";
            exit;
        }

        if ($_FILES['fileToUpload']['size'][$key] > 1024 * 1024) { 
            echo "File size must be less than 1 MB.";
            exit;
        }

        $target_dir = PRODUCT_IMAGE_SERVER_PATH;
        $image_name = basename($_FILES["fileToUpload"]["name"][$key]);
        $target_file = $target_dir . $image_name;

        compressImage($_FILES["fileToUpload"]["tmp_name"][$key], $target_file, 1024);

        $image_names[] = $image_name; 
    }

    $image_path = implode(',', $image_names);

    $sql = "INSERT INTO post (user_id, full_name, product_name, price, detail, select_option, phone_number, address, image_path)
            VALUES ('$user_id', '$full_name', '$product_name', $price, '$detail', '$select_option', '$phone_number', '$address', '$image_path')";

    if ($con->query($sql) === TRUE) { ?>
        <script>
            window.location.href = "home.php"
        </script>
    <?php } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    $_SESSION['form_submitted'] = true;
}

$sql = "SELECT * FROM post WHERE user_id = '$user_id'";
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
            <label for="fullName">Your Name:</label>
            <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter Full Name" required>
        </div>
        <div class="form-group">
            <label for="fatherName">Product Name:</label>
            <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name" required>
        </div>
        <div class="form-group">
            <label for="price">Selling Price:</label>
            <input type="text" class="form-control" id="price" name="price" placeholder="Enter Price" required>
        </div>
        <div class="form-group">
            <label for="message">Product Detail:</label>
            <textarea class="form-control" name="detail" id="detail" rows="5" placeholder="Enter your detail"></textarea>
        </div>
        <div class="form-group">
            <label for="select1">Select Categories:</label><br>
            <select class="form-control" id="select1" name="select1" required>
                <?php
                $res = mysqli_query($con, "select id,categories from categories order by categories asc");
                while ($row = mysqli_fetch_assoc($res)) {
                    if ($row['id'] == $categories_id) {
                        echo "<option selected value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                    } else {
                        echo "<option value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="phoneNumber">Contact Number:</label>
            <input type="text" class="form-control" id="phoneNumber" maxlength="11" name="phoneNumber" placeholder="Enter Contact Number" required>
        </div>
        <div class="form-group">
            <label for="email">Address:</label>
            <input type="text" class="form-control" maxlength="30" id="address" name="address" placeholder="Enter Address" required>
        </div>
        <div class="form-group">
            <label for="fileToUpload">Upload Images:</label>
            <input type="file" class="form-control-file" id="fileToUpload" name="fileToUpload[]" accept="image/*" multiple required>
        </div>
        <button type="submit" class="btn btn-warning mt-3 mb-5">Submit</button>
    </form>
</div>

<?php require('footer.php'); ?>

<?php
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    }
    imagejpeg($image, $destination, $quality);
}
?>