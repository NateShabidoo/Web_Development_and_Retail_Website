<?php
	require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Registration Page</title>
<link href="style/main.css?v=3<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.boostrapcdn.com/boostrap/4.0.0/css/boostrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJISAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40TKnXrLnZ9+fkDaog==" crossorigin="anonymous"/>

</head>
<body>
<div class="container" id="register-page">
		<div class="registerCard">
			<div class="row">
				<div class="col">
					<div class="register">
					<?php
							if(isset($_POST['register_btn']))
							{
								
								$fname = $_POST['fname'];
								$lname = $_POST['lname'];
								$username = $_POST['username'];
								$email = $_POST['email'];
								$password = $_POST['password'];
								$cpassword = $_POST['cpassword'];
								
								if($password == $cpassword){

									$query = "select * from User WHERE username='$username'";
									$query_run = mysqli_query($conn, $query);

									//finding rows that are true for query
									if(mysqli_num_rows($query_run)>0)
									{	
										//exisiting user with same username found
										echo ('<script type="text/javascript">alert("User already exists, try another username")</script>');
									} 
									else
									{
										//everyting went smoothly...entering user in database!
										$query = "INSERT INTO User VALUES ('', '$fname', '$lname' , '$username', '$password', '$email')";
										$query_run = mysqli_query($conn,$query);

										if($query_run)
										{
											echo ('<script type="text/javascript">alert("User registered! Try to log in.")</script>');}
										else 
										{
											echo ('<script type="text/javascript">alert("Something went wrong!")</script>');	
										}
									}
								}
								else
									{
										//goofed up...passwords didn't match
										echo ('<script type="text/javascript">alert("Passwords do not match! Try again!")</script>');
									}
							
							}
					?>

						<form class="registerForm text-center" action="#" method="POST">
							<header>Sign Up</header>
							<!--FIRST NAME-->
							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" id="inputIcon" viewBox="0 0 16 16">
									<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
								  </svg>
								<input name="fname" class="registerInput" type="text" placeholder="First Name" id="fname" >
								<div class="invalid-feedback">
									Please fill out this field.
								</div>
							</div>
							<!--LAST NAME-->
							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" id="inputIcon" viewBox="0 0 16 16">
									<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
								  </svg>
								<input name="lname" class="registerInput" type="text" placeholder="Last Name" id="lname" >
								<div class="invalid-feedback">
									Please fill out this field.
								</div>
							</div>
							<!--USERNAME-->
							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" id="inputIcon" viewBox="0 0 16 16">
									<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
								  </svg>
								<input name="username" class="registerInput" type="text" placeholder="Username" id="username" >
								<div class="invalid-feedback">
									Please fill out this field.
								</div>
							</div>

							<!--EMAIL-->
							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" id="inputIcon"viewBox="0 0 16 16">
									<path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
								</svg>
								<input name="email" class="registerInput" type="text" placeholder="Email" id="email" >
								<div class="invalid-feedback">
									Please fill out this field.
								</div>
							</div>

							<!--PASSWORD-->
							<div class="form-group">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" id="togglePassword" viewBox="0 0 16 16">
									<path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
									<path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
								</svg>
								<input name="password" class="registerInput" type="password" placeholder="Password" id="password" >
								<div class="invalid-feedback">
								</div>
							</div>

							<!--CONFIRM PASSWORD-->
							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" id="togglePassword" viewBox="0 0 16 16">
  									<path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
								</svg>
								<input name="cpassword" class="registerInput" type="password" placeholder="Confirm Password" id="cPassword" >
								<div class="invalid-feedback">
								</div>
							</div>

							<!--BUTTONS-->
							<input name="register_btn" type="submit" class="registerBtn" value="Register"/>
							<input type="button" class="backToLogInBtn" value="Back" onclick="window.location = 'index.php'"/>
						</form>


					</div>
				</div>
			</div>
		</div>
	</div>

    <script>
        const togglePassword1 = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword1.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });
    </script>

</body>

</html>
</body>
</html>