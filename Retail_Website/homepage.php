<?php
session_start();
require 'config.php';

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
<title>Home Page</title>
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
					<form action="homepage.php" method="post" class="col" id="searchBarForm">
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
	<div class="container">
		<!-- HOMEPAGE -->
		<div id="homepage">
			<div class="d-flex justify-content-center d-flex flex-wrap align-content-center" id="welcome" style="background-image: linear-gradient(to bottom right, #ff6e00, #ff7e24, #ff8d3c, #ff9c52, #ffa967); height: 200px">
				<p> Welcome 
					<?php echo $_SESSION['username'] ?>! 
				</p>
				
			</div>

			<div class="d-flex justify-content-center" id="new">
				<p style="font-size: 30px">Newest Items</p>
			</div>
			<div>
				 <!-- NEWEST MOVIE -->
				<div class="p-3 row" style="">
					<div class="mt-1 col-4">
  						<?php
  							$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Matrix Resurrections'");
							while ($row = mysqli_fetch_array($query_run)) {    
						?>
							<?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?> 
						<?php
							}
						?>
					</div>
					<div class="mt-1 col-8">
					<iframe width="100%" height="500" src="https://www.youtube.com/embed/9ix7TUGVYIo" title="YouTube video player" 
						frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					</div>
				</div>

				<!-- NEWEST MUSIC -->
				<div class="p-3 mt-2 row" style="">
					<div class="mt-1 col-4">
  						<?php
  							$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'An Evening With Silk Sonic'");
							while ($row = mysqli_fetch_array($query_run)) {    
						?>
							<?php echo "<img src=".$row['Photo']." height='350' width='350'>"; ?> 
						<?php
							}
						?>
					</div>
					<div class="mt-1 col-8">
						<iframe width="100%" height="500" src="https://www.youtube.com/embed/adLGHcj_fmA" title="YouTube video player" 
						    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
						</iframe>
					</div>
				</div>

				<!-- NEWEST GAME -->
				<div class="p-3 mt-2 row">
					<div class="mt-1 col-4">
  						<?php
  							$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Elden Ring'");
							while ($row = mysqli_fetch_array($query_run)) {    
						?>
							<?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?> 
						<?php
							}
						?>
					</div>
					<div class="mt-1 col-8">
					<iframe width="100%" height="500" src="https://www.youtube.com/embed/AKXiKBnzpBQ" title="YouTube video player" 
						frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
					</iframe>
					</div>
				</div>
				
			</div>
		</div>

		<!-- MOVIES -->
		<div class="tab-pane" id="moviesPage" role="tabpanel">
			<h3> Newest Movies </h3>
		</div>
	</div>

	<script>
		 // Tab Change
		 $('#mainNav a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
        });

		$('.carousel').carousel({
  			interval: 2000
		})

	</script>
</body>

</html>

