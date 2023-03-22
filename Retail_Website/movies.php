<?php
session_start();
require 'config.php';

$username = $_SESSION['username'];

$query = mysqli_query($conn, "SELECT * FROM User WHERE username = '$username'");
while ($row = mysqli_fetch_array($query)) {  
		$userid= $row['userid']; 
		$shoppingcartid = $userid;
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

//SHOPPING CART DYNAMIC ICON
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
// End shopping cart dynamic icon
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
					<form action="movies.php" method="post" class="col" id="searchBarForm">
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
		<!-- NEWEST MOVIES -->
    	<div class="moviesList">
    	    <h2 id="newestMoviesTitle">Newest Movies</h2>

    	    <div class="card-group d-flex justify-content-center">

			<div class="row" id="newestMoviesRow">
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="theMatrixResurrections()"><img src="images/matrix.jpg" alt="The Matrix Resurrections" id="movieImg"></a>
			    	</div>
					<div class="col card" id="movieCard">
    	                <a id="movie" onclick="encanto()"> <img src="images/encanto.jpeg" alt="Encanto" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="ronsGoneWrong()"> <img src="images/ronsgonewrong.jpg" alt="Ron's Gone Wrong" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="venomLetThereBeCarnage()"> <img src="images/venom.jpg" alt="Venom: Let There Be Carnage" id="movieImg"> </a>
			    	</div>
					<div class="col card" id="movieCard">
    	                <a id="movie" onclick="shangchi()"> <img src="images/shangchi.jpeg" alt="Shang Chi" id="movieImg"> </a>
			    	</div>
    	        </div>

    	    </div>
		<!-- END OF NEWEST MOVIES -->

		<!-- MOVIES -->
    	    <h2 id="otherMoviesTitle">Movies</h2>

    	    <div class="card-group d-flex justify-content-center">

    	        <div class="row" id="newestMoviesRow">
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="avengersInfWar()"><img src="images/infinitywars.jpg" alt="Avengers Infinity Wars" id="movieImg"></a>
			    	</div>
					<div class="col card" id="movieCard">
    	                <a id="movie" onclick="avengersEndGame()"> <img src="images/endgame.jpg" alt="Avengers End Game" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="joker()"> <img src="images/joker.jpg" alt="Joker" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="darkKnight()"> <img src="images/darkknight.jpg" alt="Dark Knight" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="fantasticBeasts()"> <img src="images/fantasticbeasts.jpg" alt="Fantastic Beasts" id="movieImg"> </a>
			    	</div>
    	        </div>
				<div class="row" id="newestMoviesRow">
    	            <div class="col card" id="movieCard">
    	                <a id="movie" type="submit" onclick="interstellar()"><img src="images/interstellar.jpg" alt="Interstellar" id="movieImg"></a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="inception()"> <img src="images/inception.jpg" alt="Inception" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="trainToBusan()"> <img src="images/traintobusan.jpg" alt="Train To Busan" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="grownUps()"> <img src="images/grownups.jpg" alt="Grown Ups" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="forrestGump()"> <img src="images/forrestgump.jpg" alt="Forrest Gump" id="movieImg"> </a>
			    	</div>
    	        </div>
				<div class="row" id="newestMoviesRow">
    	            <div class="col card" id="movieCard">
    	                <a id="movie" type="submit" onclick="dearJohn()"><img src="images/dearjohn.jpg" alt="Dear John" id="movieImg"></a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="notebook()"> <img src="images/notebook.jpg" alt="The Notebook" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="shawshank()"> <img src="images/shawshank.jpg" alt="Shawshank" id="movieImg"> </a>
			    	</div>
    	            <div class="col card" id="movieCard">
    	                <a id="movie" onclick="godfather()"> <img src="images/godfather.jpg" alt="Godfather" id="movieImg"> </a>
			    	</div>
					<div class="col card" id="movieCard">
    	                <a id="movie" onclick="threeHundred()"> <img src="images/300.jpg" alt="300" id="movieImg"> </a>
			    	</div>
    	        </div>
    	    </div>

    	</div>
		<!-- END OF MOVIES -->

		<!-- AVENGERS:INF WAR PAGE -->
		<div class="avengersInfWar">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Avengers: Infinity War'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="avengersInfWarButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- SHANG-CHI PAGE -->
		<div class="shangchi">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Shang-Chi and The Legend of The Ten Rings'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="shangchiButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- ENCANTO PAGE -->
		<div class="encanto">
		<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Encanto'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="encantoButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- SHAWSHANK RED PAGE -->
		<div class="shawshank">
		<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Shawshank Redemption'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn"  name="shawshankButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- GODFATHER PAGE -->
		<div class="godfather">
		<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Godfather'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="godfatherButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- THE MATRIX RESURRECTIONS -->
		<div class="theMatrixResurrections">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Matrix Resurrections'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="matrixButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->
		
		<!-- RON'S GONE WRONG -->
		<div class="ronsGoneWrong">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Ron''s Gone Wrong'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="ronsGoneWrongButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- VENOM: LET THERE BE CARNAGE -->
		<div class="venomLetThereBeCarnage">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Venom: Let There Be Carnage'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <?php echo $row['Description']; ?> </p>
						<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
						<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
							<button type="submit" id="addCartBtn" name="venomButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
									<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
									<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
								</svg>
								ADD TO CART
							</button> 
						</form> 
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  								<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
							</svg>
							BACK
						</button>

					</div>
				</div>
				<?php
				} 
				?>
		</div>
		<!-- END -->

		<!-- JOKER -->
		<div class="joker">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Joker'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="jokerButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- AVENGERS: ENDGAME -->
		<div class="avengersEndGame">
			<?php
	
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Avengers: Endgame'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="avengersEndGameButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- TRAIN TO BUSAN -->
		<div class="trainToBusan">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Train to Busan'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="trainToBusanButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- MOANA -->
		<div class="moana">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Moana'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="moanaButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- FANTASTIC BEASTS AND WHERE TO FIND THEM -->
		<div class="fantasticBeasts">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Fantastic Beasts and Where to Find Them'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="fantasticBeastsButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
						ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- INTERSTELLAR -->
		<div class="interstellar">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Interstellar'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="interstellarButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- INCEPTION -->
		<div class="inception">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Inception'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="inceptionButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
						ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- GROWN UPS -->
		<div class="grownUps">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Grown Ups'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="grownUpsButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- DEAR JOHN -->
		<div class="dearJohn">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Dear John'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="dearJohnButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- THE DARK KNIGHT -->
		<div class="darkKnight">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Dark Knight'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="darkKnightButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- 300 -->
		<div class="threeHundred">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = '300'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="threeHundredButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- THE NOTEBOOK -->
		<div class="notebook">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Notebook'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="notebookButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<!-- FOREST GUMP -->
		<div class="forrestGump">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Forrest Gump'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <?php echo $row['Description']; ?> </p>
					<p> <span style="font-weight:bold;">Directors: </span> <?php echo $row['Director']; ?> </p>
					<p> <span style="font-weight:bold;">Runtime: </span> <?php echo $row['Run_time']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button type="submit" id="addCartBtn" name="forrestGumpButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
					</post>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='movies.php'">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  							<path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
						</svg>
						BACK
					</button>
				</div>
			</div>
			<?php
			} 
			?>
		</div>
		<!-- END -->

		<?php
			if(array_key_exists('avengersInfWarButton', $_POST)) {
        	    		$productid = 1;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
        		else if(array_key_exists('shangchiButton', $_POST)) {
				$productid = 8;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('encantoButton', $_POST)) {
				$productid = 18;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('shawshankButton', $_POST)) {
				$productid = 23;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('godfatherButton', $_POST)) {
				$productid = 2;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('matrixButton', $_POST)) {
				$productid = 16;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('ronsGoneWrongButton', $_POST)) {
				$productid = 15;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('venomButton', $_POST)) {
				$productid = 17;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('jokerButton', $_POST)) {
				$productid = 10;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('avengersEndGameButton', $_POST)) {
				$productid = 5;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
        	 else if(array_key_exists('trainToBusanButton', $_POST)) {
				$productid = 11;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('moanaButton', $_POST)) {
				$productid = 20;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			 else if(array_key_exists('fantasticBeastsButton', $_POST)) {
				$productid = 19;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			else if(array_key_exists('interstellarButton', $_POST)) {
				$productid = 4;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
			}
			else if(array_key_exists('inceptionButton', $_POST)) {
				$productid = 6;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
			}
			else if(array_key_exists('grownUpsButton', $_POST)) {
				$productid = 3;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			else if(array_key_exists('dearJohnButton', $_POST)) {
				$productid = 7;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			else if(array_key_exists('forrestGumpButton', $_POST)) {
				$productid = 12;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			else if(array_key_exists('darkKnightButton', $_POST)) {
				$productid = 9;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			else if(array_key_exists('threeHundredButton', $_POST)) {
				$productid = 14;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
			else if(array_key_exists('notebookButton', $_POST)) {
				$productid = 13;
				$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
				$query_run = mysqli_query($conn,$query);
        	}
    	?>

	</div>

</body>
<script>
	    function avengersInfWar() {
            window.scrollTo(0,0);
            document.getElementsByClassName('avengersInfWar')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function shangchi() {
            window.scrollTo(0,0);
            document.getElementsByClassName('shangchi')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function encanto() {
            window.scrollTo(0,0);
            document.getElementsByClassName('encanto')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function shawshank() {
            window.scrollTo(0,0);
            document.getElementsByClassName('shawshank')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function godfather() {
            window.scrollTo(0,0);
            document.getElementsByClassName('godfather')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function theMatrixResurrections() {
			window.scrollTo(0,0);
            document.getElementsByClassName('theMatrixResurrections')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function ronsGoneWrong() {
			window.scrollTo(0,0);
            document.getElementsByClassName('ronsGoneWrong')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function venomLetThereBeCarnage() {
			window.scrollTo(0,0);
            document.getElementsByClassName('venomLetThereBeCarnage')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function joker() {
			window.scrollTo(0,0);
            document.getElementsByClassName('joker')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function avengersEndGame() {
			window.scrollTo(0,0);
            document.getElementsByClassName('avengersEndGame')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function trainToBusan() {
			window.scrollTo(0,0);
            document.getElementsByClassName('trainToBusan')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function moana() {
			window.scrollTo(0,0);
            document.getElementsByClassName('moana')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }
            
        function darkKnight() {
			window.scrollTo(0,0);
            document.getElementsByClassName('darkKnight')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function fantasticBeasts() {
			window.scrollTo(0,0);
            document.getElementsByClassName('fantasticBeasts')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function interstellar() {
			window.scrollTo(0,0);
            document.getElementsByClassName('interstellar')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function inception() {
			window.scrollTo(0,0);
            document.getElementsByClassName('inception')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function grownUps() {
			window.scrollTo(0,0);
            document.getElementsByClassName('grownUps')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function dearJohn() {
			window.scrollTo(0,0);
            document.getElementsByClassName('dearJohn')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function threeHundred() {
			window.scrollTo(0,0);
            document.getElementsByClassName('threeHundred')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function notebook() {
			window.scrollTo(0,0);
            document.getElementsByClassName('notebook')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }

		function forrestGump() {
			window.scrollTo(0,0);
            document.getElementsByClassName('forrestGump')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }
			
</script>
</html>