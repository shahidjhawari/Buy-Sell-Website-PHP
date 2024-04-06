<?php require('top.php'); ?>
<!--================Login Box Area =================-->
<section class="login_box_area section_gap">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="login_form_inner">
					<h3>Register</h3>
					<form class="row login_form" id="register-form" method="post">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'">
							<span class="field_error" id="name_error"></span>
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="email" id="email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							<span class="field_error" id="email_error"></span>
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="mobile" id="mobile" placeholder="Mobile" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Mobile'">
							<span class="field_error" id="mobile_error"></span>
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="password" id="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							<span class="field_error" id="password_error"></span>
						</div>
						<div class="col-md-12 form-group">
							<button type="button" onclick="user_register()" class="primary-btn">Register</button>
							<div class="form-output register_msg">
								<p class="form-messege field_error"></p>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="login_form_inner">
					<h3>Log in to enter</h3>
					<form class="row login_form" id="login-form" method="post">
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="login_email" id="login_email" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
							<span class="field_error" id="login_email_error"></span>
						</div>
						<div class="col-md-12 form-group">
							<input type="text" class="form-control" name="login_password" id="login_password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							<span class="field_error" id="login_password_error"></span>
						</div>
						<div class="col-md-12 form-group">
							<div class="creat_account">
								<input type="checkbox" id="f-option2" name="selector">
								<label for="f-option2">Keep me logged in</label>
							</div>
						</div>
						<div class="col-md-12 form-group">
							<button type="button" onclick="user_login()" class="primary-btn">Log In</button>
							<a href="#">Forgot Password?</a>
							<div class="form-output login_msg">
								<p class="form-messege field_error"></p>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<!--================End Login Box Area =================-->

<?php require('footer.php'); ?>