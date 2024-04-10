<?php
require('top.php');

if (!isset($_SESSION['USER_LOGIN'])) { 
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $post_id = $_GET['id'];
    
    $sql = "SELECT * FROM post WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('s', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        echo "Post not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $con->real_escape_string($_POST['fullName']);
    $product_name = $con->real_escape_string($_POST['productName']);
    $price = $con->real_escape_string($_POST['price']);
    $detail = $con->real_escape_string($_POST['detail']);
    $select_option = $con->real_escape_string($_POST['select1']);
    $phone_number = $con->real_escape_string($_POST['phoneNumber']);
    $address = $con->real_escape_string($_POST['address']);
    $post_id = $_POST['post_id'];

    $sql = "UPDATE post SET full_name=?, product_name=?, price=?, detail=?, select_option=?, phone_number=?, address=? WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('sssssssi', $full_name, $product_name, $price, $detail, $select_option, $phone_number, $address, $post_id);
    if ($stmt->execute()) { ?>
        <script>
            window.location.href = "home.php";
        </script>
    <?php } else {
        echo "Error updating post: " . $stmt->error;
    }
}

?>

<style>
    .post-box {
        margin-top: 200px;
    }
    @media screen and (min-width: 200px) and (max-width: 576px) {
        .post-box {
            margin-top: 120px;
        }
    }
</style>

<div class="container post-box ">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fullName">Your Name:</label>
            <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo $post['full_name']; ?>" placeholder="Enter Full Name" required>
        </div>
        <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $post['product_name']; ?>" placeholder="Enter Product Name" required>
        </div>
        <div class="form-group">
            <label for="price">Selling Price:</label>
            <input type="text" class="form-control" id="price" name="price" value="<?php echo $post['price']; ?>" placeholder="Enter Price" required>
        </div>
        <div class="form-group">
            <label for="detail">Product Detail:</label>
            <textarea class="form-control" id="detail" name="detail" rows="5" placeholder="Enter your detail"><?php echo $post['detail']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="select1">Select Categories:</label><br>
            <select class="form-control" id="select1" name="select1" required>
                <?php
                $res = mysqli_query($con, "SELECT id, categories FROM categories ORDER BY categories ASC");
                while ($row = mysqli_fetch_assoc($res)) {
                    if ($row['id'] == $post['categories_id']) {
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
            <input type="text" class="form-control" id="phoneNumber" maxlength="11" name="phoneNumber" value="<?php echo $post['phone_number']; ?>" placeholder="Enter Contact Number" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" maxlength="30" id="address" name="address" value="<?php echo $post['address']; ?>" placeholder="Enter Address" required>
        </div>
        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
        <button type="submit" class="primary-btn mt-3 mb-5">Update Post</button>
    </form>
</div>

<?php require('footer.php'); ?>
