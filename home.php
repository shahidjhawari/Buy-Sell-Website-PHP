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
    .own-table {
        margin-top: 150px;
    }

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
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <th scope="row"><?php echo $row["id"]; ?></th>
                        <td><?php echo $row['full_name']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>

<?php require('footer.php'); // Include footer.php 
?>