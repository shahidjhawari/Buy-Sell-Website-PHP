<?php
require('top.php');

if (!isset($_SESSION['USER_LOGIN'])) { ?>
    <script>
        window.location.href = "login.php";
    </script>
<?php }

$user_id = $_SESSION['USER_ID'];

$sql = "SELECT * FROM post WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $con->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .card {
      width: 300px;
      height: 400px;
      margin-bottom: 20px;
    }
    .card-img-top {
      width: 100%;
      height: 50%;
      object-fit: contain;
    }
    .card-body {
      height: 50%;
    }
    .own-btn {
      margin-top: 20px;
    }
    .card-box {
        margin-top: 200px;
    }
    @media screen and (min-width: 200px) and (max-width: 576px) {
        .card-box{
            margin-top: 120px;
        }
    }
</style>

<div class="container card-box">
    <div style='text-align: center;'><a href='post.php' class='btn btn-warning own-btn'><i class='fas fa-plus'></i></a>
        <p>Add new ad</p>        
        <p>Please delete the post when it is sold out</p>        
    </div>
    <?php if ($result->num_rows > 0) { ?>
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) : ?>
                <div class="col-md-6 col-lg-3">
                    <div class="card">
                        <?php for ($i = 1; $i <= 1; $i++) {
                            $image_column = "image$i";
                            if (!empty($row[$image_column])) {
                                $image_path = PRODUCT_IMAGE_SITE_PATH . $row[$image_column];
                        ?>
                                <img class="card-img-top" src="<?php echo $image_path; ?>" alt="Image">
                        <?php
                            }
                        }
                        ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            <p class="card-text"><?php echo $row['phone_number']; ?></p>
                            <p class="card-text"><?php echo "Rs. " . $row['price']; ?></p>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-info mr-2">Edit</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php } ?>
</div>

<?php require('footer.php'); ?>