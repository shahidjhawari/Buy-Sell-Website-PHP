<?php require('top.php'); 

if (!isset($_SESSION['USER_LOGIN'])) {
    ?>
    <script>
        window.location.href = 'login.php';
    </script>
    <?php
    exit;
}

?>

<style>
    .login-container {
        max-width: 400px;
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-top: 150px;
    }

    @media screen and (min-width: 200px) and (max-width: 574px) {
        .login-container {
            margin-top: 100px;
        }
    }
</style>

<div class="container profile-container">
    <div class="login-container">
        <h2 class="text-center mb-4">Welcome <?php echo $_SESSION['USER_NAME']; ?></h2>
        <form id="login-form" method="post">
            <div class="form-group">
                <label for="username">Change Your Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Your Name">
                <button type="button" id="btn_submit" class="btn btn-info btn-block mt-2" onclick="update_profile()">Change Name</button>
                <span class="field_error" id="name_error"></span>
            </div>
        </form>
        <form method="post" id="frmPassword">
            <div class="form-group">
                <label for="username">Change Your Password</label>
                <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Old Password">
                <input type="password" class="form-control mt-2" name="new_password" id="new_password" placeholder="New Password">
                <span class="field_error" id="new_password_error"></span>
                <input type="password" class="form-control mt-2" name="confirm_new_password" id="confirm_new_password" placeholder="Confirm Password">
                <button type="button" class="btn btn-info btn-block mt-2" onclick="update_password()" id="btn_update_password"">Change Password</button>
        <span class=" field_error" id="confirm_new_password_error"></span>
                    <span class="field_error" id="current_password_error"></span>
            </div>
        </form>
        <a href="logout.php" type="button" class="btn btn-danger btn-block mt-2">Logout</a>
    </div>
</div>

<?php require('footer.php'); ?>

<script>
    function update_profile() {
        $('.field_error').html('');
        var name = jQuery('#name').val();
        if (name == '') {
            jQuery('#name_error').html('Please enter your name');
        } else {
            jQuery('#btn_submit').html('Please wait...');
            jQuery('#btn_submit').attr('disabled', true);
            jQuery.ajax({
                url: 'update_profile.php',
                type: 'post',
                data: 'name=' + name,
                success: function(result) {
                    jQuery('#name_error').html(result);
                    jQuery('#btn_submit').html('Update');
                    jQuery('#btn_submit').attr('disabled', false);
                }
            })
        }
    }

    function update_password() {
        jQuery('.field_error').html('');
        var current_password = jQuery('#current_password').val();
        var new_password = jQuery('#new_password').val();
        var confirm_new_password = jQuery('#confirm_new_password').val();
        var is_error = '';
        if (current_password == '') {
            jQuery('#current_password_error').html('Please enter password');
            is_error = 'yes';
        }
        if (new_password == '') {
            jQuery('#new_password_error').html('Please enter password');
            is_error = 'yes';
        }
        if (confirm_new_password == '') {
            jQuery('#confirm_new_password_error').html('Please enter password');
            is_error = 'yes';
        }

        if (new_password != '' && confirm_new_password != '' && new_password != confirm_new_password) {
            jQuery('#confirm_new_password_error').html('Please enter same password');
            is_error = 'yes';
        }

        if (is_error == '') {
            jQuery('#btn_update_password').html('Please wait...');
            jQuery('#btn_update_password').attr('disabled', true);
            jQuery.ajax({
                url: 'update_password.php',
                type: 'post',
                data: 'current_password=' + current_password + '&new_password=' + new_password,
                success: function(result) {
                    jQuery('#current_password_error').html(result);
                    jQuery('#btn_update_password').html('Update');
                    jQuery('#btn_update_password').attr('disabled', false);
                    jQuery('#frmPassword')[0].reset();
                }
            })
        }

    }
</script>