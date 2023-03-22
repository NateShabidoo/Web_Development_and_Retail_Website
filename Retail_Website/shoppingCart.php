<?php
session_start();
require 'config.php';


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
	
function php_printItemInfo(){
	global $data, $conn;
	if (sizeof($data)==0) {
		 $print = "
		 	<h2> Shopping cart is empty...</h2>
		 	<div id=\"emptyCartIcon\">
				<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"200\" height=\"200\" fill=\"currentColor\" class=\"bi bi-cart-x-fill\" viewBox=\"0 0 16 16\">
  					<path d=\"M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM7.354 5.646 8.5 6.793l1.146-1.147a.5.5 0 0 1 .708.708L9.207 7.5l1.147 1.146a.5.5 0 0 1-.708.708L8.5 8.207 7.354 9.354a.5.5 0 1 1-.708-.708L7.793 7.5 6.646 6.354a.5.5 0 1 1 .708-.708z\"/>
				</svg>
			</div>";
		 echo $print;
				 
	}
	else{ ?>
		<div class="mb-4 row">
				<div class="col-4"> 
				</div>
				<div class="col-1"> 
					<p> ID </p>
				</div>
				<div class="col-3"> 
					<p> Name </p>
				</div>
				<div class="col-2"> 
					<p> Price </p>
				</div>
				<div class="col-2"> 
					<p> Shipping </p>
				</div>
			</div>		
<?php
		foreach($data as $item){
		$query2 = mysqli_query($conn, "SELECT * FROM Product WHERE Product_ID = '$item'");
		while ($row = mysqli_fetch_assoc($query2)) { 
		?>
			<div class="mb-4 row">
				<div class="col-4"> 
					<img src="<?php echo $row['Photo']; ?>" style="height:300px; width:200px"> 
				</div>
				<div class="col-1"> 
					<p style="font-size:20px"> <?php echo $row['Product_ID']; ?> </p>
				</div>
				<div class="col-3"> 
					<p style="font-size:20px"> <?php echo $row['Product_name']; ?> </p>
				</div>
				<div class="col-2"> 
					<p style="font-size:20px"> <?php echo $row['Price']; ?> </p>
				</div>
				<div class="col-2"> 
					<p style="font-size:20px"> <?php echo $row['Shipping_Price']; ?> </p>
				</div>
			</div>
		<?php }
		}
	}
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
?>

<!DOCTYPE html>
<html>
<head>
<title>Shopping Cart Page</title>
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
					<form action="shoppingCart.php" method="post" class="col" id="searchBarForm">
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

	<!-- CART PAGE -->
	<div class="container">
		<h2 id="cartTitle">My Cart</h2>
		<!-- EMPTY SHOPPING CART -->
		<div class="shoppingCartPage">
			<div class="row" id="shoppingCartCard">
				<div class="col-8">
					<h4> <?php echo php_printItemInfo() ?> </h4>
				</div>
				<div class="mt-5 col-4" id="cartTotals">
					<p><b>Total:</b> <?php echo php_functionTotal() ?></p>
					<p><b>Total Items: <?php echo sizeof($list) ?></b> </p>
					<button id="checkoutBtn" onClick="window.location='shipping.php'" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						CHECKOUT
					</button> 
					<p class="mt-5"> <b>Double click to clear your cart</b> </p>
					<!--<form method="post"> 
						<button onClick="window.location.reload()" class="m-2" name="clearButton" id="clearBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							CLEAR
						</button> 
					</form>-->
					<form method="post"> 
						<button name="clearButton" class="m-2" id="goToMoviesBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							CLEAR
						</button> 
					</form>
					
				</div>
				
			</div>
		</div>

		<?php 
			if(array_key_exists('clearButton', $_POST)) {
			$query = "DELETE FROM Add_item WHERE Shoppingcart_ID ='$shoppingcartid'";
			$query_run = mysqli_query($conn,$query);
			}
		
		
		#if(array_key_exists('clearButton', $_POST)) {
		#	$query = "DELETE FROM Add_item WHERE Shoppingcart_ID ='$shoppingcartid'";
		#	$query_run = mysqli_query($conn,$query);
		#}
		
		?>
		
    
	<!-- END OF CART PAGE -->
</body>
</html>