<?php
require('top.php');

if (!isset($_SESSION['USER_LOGIN'])) { ?>
    <script>
        window.location.href = "login.php";
    </script>
<?php }

$user_id = $_SESSION['USER_ID'];

$sql = "SELECT * FROM post WHERE user_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param('s', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    .own-btn {
        margin-top: 200px;
    }

    @media screen and (min-width: 200px) and (max-width: 576px) {
        .btn {
            margin-top: 120px;
        }
    }
</style>

<div class="container">
    <a href="logout.php">logout</a>
    <h6><?php echo $_SESSION['USER_NAME'] ?></h6>
    <div style='text-align: center;'><a href='post.php' class='btn btn-warning own-btn'><i class='fas fa-plus'></i></a>
        <p>Add new ad</p>
    </div>
    <?php if ($result->num_rows > 0) { ?>
        <div class="table-responsive">
            <table class="table own-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Last</th>
                        <th scope="col">Edit</th> 
                        <th scope="col">Delete</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row['full_name']; ?></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td><?php echo $row['detail']; ?></td>
                            <td><a href="edit.php?id=<?php echo $row['id']; ?>"><i class='fas fa-edit fa-2x' style="color: #191919;"></i></a></td>
                            <td><a href="delete.php?id=<?php echo $row['id']; ?>"><i class='fas fa-trash fa-2x' style="color: #9A031E;"></i></a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>


<?php require('footer.php'); ?>