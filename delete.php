<?php
// Check if the ID parameter is provided in the URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    // Include database connection
    require('connection.inc.php');

    // Prepare and execute SQL statement to delete the post
    $id = $_GET['id'];
    $sql = "DELETE FROM post WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('i', $id); // Assuming id is an integer
    if($stmt->execute()) {
        // Redirect back to the page where the post was deleted
        header('Location: home.php'); // Replace previous_page.php with the actual page URL
        exit;
    } else {
        echo "Error deleting post: " . $con->error;
    }

} else {
    // If ID parameter is not provided or empty, redirect to an error page or homepage
    header('Location: error_page.php'); // Replace error_page.php with the actual error page URL
    exit;
}
?>
