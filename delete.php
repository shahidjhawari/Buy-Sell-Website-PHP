<?php
if(isset($_GET['id']) && !empty($_GET['id'])) {
    require('connection.inc.php');

    $id = $_GET['id'];
    $sql = "DELETE FROM post WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id); 
    if($stmt->execute()) {
        header('Location: home.php'); 
        exit;
    } else {
        echo "Error deleting post: " . $con->error;
    }

} else {
    header('Location: error_page.php'); 
    exit;
}
?>
