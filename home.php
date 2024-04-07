<?php
require('top.php');

// Check if the user is logged in
if (!isset($_SESSION['USER_LOGIN'])) {
    ?>
    <script>
        window.location.href = 'index.php';
    </script>
    <?php
    exit; // Stop further execution
}

// Get the user ID of the logged-in user
$user_id = $_SESSION['USER_ID'];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    // Escape and retrieve form data
    $full_name = $con->real_escape_string($_POST['fullName']);
    $father_name = $con->real_escape_string($_POST['fatherName']);
    $cnic = $con->real_escape_string($_POST['cnic']);
    $phone_number = $con->real_escape_string($_POST['phoneNumber']);
    $email = $con->real_escape_string($_POST['email']);
    $select_option = $con->real_escape_string($_POST['select1']);

    // Handle file upload
    $target_dir = PRODUCT_IMAGE_SERVER_PATH;
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $image_name = basename($_FILES["fileToUpload"]["name"]);
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

    // Insert form data into the database
    $sql = "INSERT INTO admissions (user_id, full_name, father_name, cnic, phone_number, email, select_option, image_path)
            VALUES ('$user_id', '$full_name', '$father_name', '$cnic', '$phone_number', '$email', '$select_option', '$image_name')";

    if ($con->query($sql) === TRUE) {
        echo "<p class='msg-feild'>Your form was sent successfully. We will contact you on your phone number.</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Mark the form submission as completed for this session
    $_SESSION['form_submitted'] = true;
}

// Fetch and display forms submitted by the logged-in user
$sql = "SELECT * FROM admissions WHERE user_id = '$user_id'";
$result = $con->query($sql);
?>

<style>
    /* Your CSS styles */
</style>

<div class="container box">
    <h2>Admission Form</h2>
    <!-- Display the form -->
    <form action="#" method="post" enctype="multipart/form-data">
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

    <?php
    // Display previously submitted forms
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display each form entry
            // You can customize the display as per your requirement
            echo "<p>Full Name: " . $row['full_name'] . "</p>";
            echo "<p>Father Name: " . $row['father_name'] . "</p>";
            // Display other form fields similarly
        }
    } else {
        echo "<p>No forms submitted yet.</p>";
    }
    ?>
</div>

<?php require('footer.php'); ?>
