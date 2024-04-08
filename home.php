<?php
require('top.php');

if (!isset($_SESSION['USER_LOGIN'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['USER_ID'];

$sql = "SELECT * FROM admissions WHERE user_id = ?";
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
    <a href="logout.php">Logout</a>
    <?php echo $_SESSION['USER_NAME'] ?>
    <div style='text-align: center;'><a href='post.php' class='btn btn-warning own-btn'><i class='fas fa-plus'></i></a>
        <p>Add new ad</p>
    </div>
    <?php if ($result->num_rows > 0) { ?>
        <table class="table table-responsive own-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Actions</th> <!-- Added Actions column -->
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo $row['full_name']; ?></td>
                        <td><?php echo $row['father_name']; ?></td>
                        <td>
                            <!-- Edit button -->
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                            <!-- Delete button -->
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<?php require('footer.php'); ?>
