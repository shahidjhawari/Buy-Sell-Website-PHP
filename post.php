<?php
require('top.php');

// Check if user is logged in
if (!isset($_SESSION['USER_LOGIN'])) {
    header("Location: index.php");
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

    // Ensure at least 3 images are uploaded
    $uploaded_images_count = 0;
    $image_names = array();

    for ($i = 1; $i <= 5; $i++) {
        if ($_FILES["fileToUpload$i"]["size"] > 0) {
            $target_dir = PRODUCT_IMAGE_SERVER_PATH;
            $target_file = $target_dir . basename($_FILES["fileToUpload$i"]["name"]);
            $image_name = basename($_FILES["fileToUpload$i"]["name"]);

            if (move_uploaded_file($_FILES["fileToUpload$i"]["tmp_name"], $target_file)) {
                $image_names[] = $image_name;
                $uploaded_images_count++;
            }
        }
    }

    if ($uploaded_images_count < 3) {
        echo "<script>alert('Please upload minimum 3 images.'); window.location.href = 'post.php';</script>";
        exit;
    }

    // Insert post into database
    $image_columns = implode(", ", array_map(function ($index) {
        return "image$index";
    }, range(1, count($image_names))));

    $image_values = "'" . implode("', '", $image_names) . "'";

    $sql = "INSERT INTO post (user_id, full_name, product_name, price, detail, select_option, phone_number, address, $image_columns)
        VALUES ('$user_id', '$full_name', '$product_name', $price, '$detail', '$select_option', '$phone_number', '$address', $image_values)";

    if ($con->query($sql) === TRUE) {
        // Redirect to home page after successful insertion
        header("Location: home.php");
        exit;
    } else {
        // Handle database error
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Set session variable to indicate form submission
    $_SESSION['form_submitted'] = true;
}

// Retrieve posts by the user
$sql = "SELECT * FROM post WHERE user_id = '$user_id'";
$result = $con->query($sql);
?>

<style>
    .post-box {
        margin-top: 200px;
    }

    .custom-file-input {
        cursor: pointer;
        position: relative;
        width: auto;
        margin-top: .5rem;
    }

    .custom-file-input:focus~.custom-file-label {
        border-color: #007bff;
        box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
    }

    .custom-file-input:lang(en)~.custom-file-label::after {
        content: "Browse";
    }

    .custom-file-label {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .custom-file-label::after {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        padding: .375rem .75rem;
        line-height: 1.5;
        color: #495057;
        background-color: #e9ecef;
        border-left: 1px solid #ced4da;
        border-radius: 0 .375rem .375rem 0;
    }

    .custom-file-label::after {
        content: "Browse";
    }
</style>

<script>
    // Function to update label text when a file is selected
    function updateLabel(input) {
        var label = input.nextElementSibling;
        var fileName = input.files[0].name;
        label.textContent = fileName ? 'Image Added' : 'Choose file';
    }
</script>

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
        <?php for ($i = 1; $i <= 5; $i++) { ?>
            <div class="form-group">
                <label for="fileToUpload<?= $i ?>">Upload Image <?= $i ?>:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="fileToUpload<?= $i ?>" name="fileToUpload<?= $i ?>" accept=".png, .jpg, .jpeg" onchange="updateLabel(this)">
                    <label class="custom-file-label" for="fileToUpload<?= $i ?>">Choose file</label>
                </div>
            </div>
        <?php } ?>
        <button type="submit" class="btn btn-warning mt-3 mb-5">Submit</button>
    </form>
</div>

<?php require('footer.php'); ?>

<script>
    document.getElementById('fileToUpload<?= $i ?>').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('fileLabel<?= $i ?>').innerHTML = fileName;
        document.getElementById('fileHelp<?= $i ?>').innerHTML = "File chosen: " + fileName;
    });
</script>