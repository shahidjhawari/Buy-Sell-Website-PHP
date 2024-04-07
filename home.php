<?php require('top.php');

if (!isset($_SESSION['USER_LOGIN'])) { ?>
    <script>
        window.location.href = 'index.php';
    </script>
<?php } ?> <?php
            if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
                echo "<p class='msg-feild'>You have already submitted the form. We will contact you soon!</p>";
                $disabled = "disabled";
            } else {
                $disabled = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $full_name = $con->real_escape_string($_POST['fullName']);
                    $father_name = $con->real_escape_string($_POST['fatherName']);
                    $cnic = $con->real_escape_string($_POST['cnic']);
                    $phone_number = $con->real_escape_string($_POST['phoneNumber']);
                    $email = $con->real_escape_string($_POST['email']);
                    $select_option = $con->real_escape_string($_POST['select1']);

                    $target_dir = PRODUCT_IMAGE_SERVER_PATH;
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $image_name = basename($_FILES["fileToUpload"]["name"]);
                    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

                    $sql = "INSERT INTO admissions (full_name, father_name, cnic, phone_number, email, select_option, image_path)
                VALUES ('$full_name', '$father_name', '$cnic', '$phone_number', '$email', '$select_option', '$image_name')";

                    if ($con->query($sql) === TRUE) {
                        echo "<p class='msg-feild'>Your form was sent successfully. We will contact you on your phone number.</p>";
                        $_SESSION['form_submitted'] = true;
                        $disabled = "disabled";
                    } else {
                        echo "Error: " . $sql . "<br>" . $con->error;
                    }
                }
            }
            ?>


<style>
    .box {
        margin-top: 200px;
        margin-bottom: 40px;
    }

    .msg-feild {
        text-align: center;
        color: red;
        transform: translateY(550px);
        font-weight: bold;
    }

    @media screen and (min-width: 200px) and (max-width: 996px) {
        .msg-feild {
            text-align: center;
            color: red;
            transform: translateY(720px);
            font-weight: bold;
            margin-bottom: 60px;
            margin-top: 30px;
        }
    }
</style>

<div class="container box">
    <h2>Admission Form</h2>
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
        <button type="submit" class="btn btn-warning mt-3 mb-5" <?php echo $disabled; ?>>Submit</button>
    </form>
</div>

<script>
    // Client-side validation script
    document.getElementById('fullName').addEventListener('input', function() {
        if (this.value.length > 30) {
            this.setCustomValidity('Name cannot exceed 30 characters');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('fatherName').addEventListener('input', function() {
        if (this.value.length > 30) {
            this.setCustomValidity('Father Name cannot exceed 30 characters');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('cnic').addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length !== 13) {
            this.setCustomValidity('CNIC must be 13 numeric characters long');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('phoneNumber').addEventListener('input', function() {
        // Remove non-numeric characters
        this.value = this.value.replace(/\D/g, '');
        if (this.value.length !== 11) {
            this.setCustomValidity('WhatsApp number must be 11 numeric characters long');
        } else {
            this.setCustomValidity('');
        }
    });
</script>

<?php require('footer.php'); ?>