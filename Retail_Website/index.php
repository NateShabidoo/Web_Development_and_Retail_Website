<?php
	session_start();
	require 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<link href="style/main.css?v=3<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<!-- boostrap addins -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.boostrapcdn.com/boostrap/4.0.0/css/boostrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJISAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40TKnXrLnZ9+fkDaog==" crossorigin="anonymous"/>
</head>

<body>
	<div class="container">
		<div class="loginCard">
			<div class="row">
				<div class="col-md-6">
					<div class="myLeftCtn">
					<?php
							if(isset($_POST['submit_btn']))
							{
								
								$username = $_POST['username'];
								$password = $_POST['password'];
								
								$query = "select * from User WHERE username='$username' AND password='$password'";

								$query_run = mysqli_query($conn, $query);
								if(mysqli_num_rows($query_run)>0)
								{
									//valid
									$_SESSION['username']= $username; //session variables from database
									header('location:homepage.php');
									end_session();
								}
								else
								{
									//invalid
									echo ('<script type="text/javascript">alert("Invalid credentials")</script>');
								}
							}

						?>

						<form class="loginForm text-center" action="#" method="POST">
							<header>Sign In</header>
							
							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" id="inputIcon" viewBox="0 0 16 16">
									<path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
								  </svg>
								<input name="username" class="loginInput" type="text" placeholder="Username" id="username" >
								<div class="invalid-feedback">
									Please fill out this field.
								</div>
							</div>

							<div class="form-group">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" id="inputIcon" viewBox="0 0 16 16">
									<path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
								  </svg>
								<input name="password" class="loginInput" type="password" placeholder="Password" id="password" >
								<div class="invalid-feedback">
								</div>
							</div>

							<input name="submit_btn" type="submit" class="loginBtn" value="Submit"/>
						</form>
						<center>
						   <p id="demo">Login with Username: user and Password: Pa55word!</p>
						<a href="resetpassword.php">Reset Password</a>
</center>

					</div>
				</div>
				<div class="col-md-6">
					<div class="myRightCtn">
						<div class="box">
							<header> Welcome </header>
							<p>
								First time user? Create an account to start shopping for the latest movie titles and games! You can also like and rate the recent movies you rented or 
								games you played. Press register to get started!
							</p>
							<input name="goToRegisterBtn" type="button" class="goToRegisterBtn" value="Register" onclick="window.location = 'register.php'"/>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
</script>
</body>
</html>