<?php
session_start();
require 'config.php';

$username = $_SESSION['username'];

$query = mysqli_query($conn, "SELECT * FROM User WHERE username = '$username'");
while ($row = mysqli_fetch_array($query)) {  
		$userid= $row['userid']; 
    
}

// SEARCH BAR
if (isset($_POST['searchBtn'])){

	$searchKey = $_POST['searchInput'];
	$query="SELECT * FROM Product WHERE Product_name = '$searchKey'";
	$result= mysqli_query($conn,$query);

	if($row = mysqli_fetch_array($result)){
		$_SESSION['result'] = $searchKey;
		header('Location:search-result.php');

	}
	else{
		echo ('<script type="text/javascript">alert("Sorry, the item you are looking for was not found. Please type in product name correctly. Thank you!")</script>');
	}
}

//SHOPPING CART ICON
$data = array();
$list = array();
$sum = 0;

$username = $_SESSION['username'];
$query = mysqli_query($conn, "SELECT * FROM User WHERE username = '$username'");
while ($row = mysqli_fetch_array($query)) {  
	$userid= $row['userid']; 
	$shoppingcartid = $userid;
}

$query1 = mysqli_query($conn, "SELECT * FROM Add_item WHERE Shoppingcart_ID = '$shoppingcartid'"); 
	
while ($row1 = mysqli_fetch_array($query1)) {  		
    $data[] = $row1['Product_ID'];
}

foreach($data as $item){
	$list[]=$item;
			
    $query2 = mysqli_query($conn, "SELECT * FROM Product WHERE Product_ID = '$item'");

    while ($row = mysqli_fetch_assoc($query2)) { 
    	$sum = $sum + $row['Price'] + $row['Shipping_Price']; #total
    }
			
}
		
function php_functionTotal(){
	 global $sum;
	 return $sum;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login Page</title>
<link href="style/main.css?v=3<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Merriweather" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>
	<!-- MAIN NAV BAR -->
	<div class="mainNavBar">
		<nav class="navbar navbar-expand-md navbar-dark bg-dark">
			<a class="navbar-brand text-primary" href="homepage.php" style="display: flex; align-items: center">
				<svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="#fd6e00" class="bi bi-play" viewBox="0 0 16 16">
  					<path d="M10.804 8 5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"/>
				</svg>
	
            	<span id="mainTitle">Entertainment Central</span>
            </a>
			<div class="collapse navbar-collapse" id="mainNavTabs">
				<ul class= "navbar-nav ml-auto" id="mainNav">
					<li class="nav-item" >
						<h5 class="nav-link active" id="mainNavLink" onClick="window.location='movies.php'">Movies</h5>
					</li>
					<li class="nav-item" >
						<h5 class="nav-link" id="mainNavLink" onClick="window.location='music.php'">Music</h5>
					</li>

					<li class="nav-item">
						<h5 class="nav-link" id="mainNavLink" onClick="window.location='games.php'">Games</h5>
					</li>
				</ul>
			</div>
			<div class="collapse navbar-collapse" id="rightMainNavBar">
				<ul class= "navbar-nav mr-auto">
					<li id="shoppingCartIcon">
						<button class="btn btn-outline-light" id="shoppingCartBtn" onClick="location.href='shoppingCart.php'">
							<p id="cartNumber"> <?php echo sizeof($list) ?> </p>
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
								<path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
							</svg> 
						</button>
					</li>
					<form action="billing.php" method="post" class="col" id="searchBarForm">
						<li>
							<input class="form-control" type="search" id="searchInput" name="searchInput" placeholder="Search" aria-label="Search"/>
						</li>
						<li>
							<button class="btn btn-outline-success" type="submit" id="searchBtn" name="searchBtn">Search</button>
						</li>
					</form>
					<li>
						<button class="btn btn-primary" type="button" id="logOutBtn" onClick="location.href='index.php'">Log Out</button>
					</li>
				</ul>
			</div>
		</nav>
	</div>

	<?php
		if(isset($_POST['billingContinueBtn']))
		{
			
			$name = $_POST['name'];
			$phone = $_POST['phone'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$address = $_POST['address'];
			$zip = $_POST['zip'];
			
			
					$query = "INSERT INTO Billing_address VALUES ('$userid', '$name', '$phone', '$address', '$city' , '$state', '$zip')";
					$query_run = mysqli_query($conn,$query);
					//everyting went smoothly...entering billing info into database!
					if($query_run)
					{
						header('location:payment.php');
					}
					//something wrong...most likely the query
					else
					{
						echo ('<script type="text/javascript">alert("Billing Info Did Not Send!")</script>');	
					}
		}
	?>
    <!-- BILLING PAGE -->  
    <div class="container">
		<h2 class="mb-5"> Billing Information </h2>
        <form id="billingForm" action="#" method="POST">
            <div class="row">
                <div class="col-6">
                    <input class="billingFormInput" type="text" placeholder="Full Name" name="name" required="required">
                </div>
                <div class="col-6">
                    <input class="billingFormInput" type="tel" placeholder="Phone Number" name="phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required="required">
                </div>
            </div>
            <div class="row">
			<div class="col-6">
                    <input class="billingFormInput" type="text" placeholder="Address" name="address" required="required">
                </div>
                <div class="col-6">
                    <input class="billingFormInput" type="text" placeholder="City" name="city" required="required">
                </div>
                
            </div>
            <div class="row">
			<div class="col-6">
					<select class="billingFormInput"  type="tel" id="state" name="state"  required="required">
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>
                </div>
                <div class="col-6">
                    <input class="billingFormInput" type="text" placeholder="Zip Code" name="zip" required="required">
                </div>
            </div>
			<div class="row d-flex justify-content-center">
				<input type="submit" id="continueBtn" name="billingContinueBtn" value="CONTINUE"/>
			</div>
			<div class="row d-flex justify-content-center">
				<input type="button" id="shippingBackBtn" onClick="window.location='shipping.php'" value="BACK"/>
			</div>
        </form>
    </div>
</body>
</html>