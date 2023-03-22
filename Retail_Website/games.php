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
<title>Games Page</title>
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
					<form action="games.php" method="post" class="col" id="searchBarForm">
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
		<!-- NEWEST GAMES -->

    	<div class="gamesList">
    	    <h2 id="newestGamesTitle">Newest Games</h2>
				<!--<p> Welcome 
					<?php echo $_SESSION['username'] ?>! -->
				</p>
    	    <div class="card-group d-flex justify-content-center">

			<div class="row" id="newestGamesRow">
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="eldenRing()"><img src="images/games/eldenring.jpg" alt="Elden Ring" id="gameImg"></a>
			    	</div>
					<div class="col card" id="gameCard">
    	                <a id="game" onclick="pokemonLegendsArceus()"> <img src="images/games/pokemonlegendsarceus.jpg" alt="Pokemon Legends: Arceus" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="tinytinaswonderland()"> <img src="images/games/tinytinaswonderland.jpg" alt="Tiny Tinas Wonderland" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="strangerOfParadise()"> <img src="images/games/stangerofparadise.jpg" alt="Stranger of Paradise" id="gameImg"> </a>
			    	</div>
					<div class="col card" id="gameCard">
    	                <a id="game" onclick="wwe2k22()"> <img src="images/games/wwe2k22.jpg" alt="WWE 2K22" id="gameImg"> </a>
			    	</div>
    	        </div>

    	    </div>
		<!-- END OF NEWEST GAMES -->

		<!-- GAMES -->
    	    <h2 id="otherGamesTitle">Games</h2>

    	    <div class="card-group d-flex justify-content-center">

    	        <div class="row" id="newestGamesRow">
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="superSmashBrosUltimate()"><img src="images/games/supersmash.jpg" alt="Super Smash Bros." id="gameImg"> </a>
			    	</div>
					<div class="col card" id="gameCard">
    	                <a id="game" onclick="gta5()"> <img src="images/games/gta5.png" alt="GTA 5" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="starWarsFallenOrder()"> <img src="images/games/starwarsfallenorder.jpg" alt="Star Wars Fallen Order" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="assassinsCreed()"> <img src="images/games/creed.jpg" alt="Assassins Creed the Ezio Collection" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="tomClancysRainbowSixSeige()"> <img src="images/games/tomclancyrainbowsixsiege.jpg" alt="Tom Clancy's Rainbow Six Seige" id="gameImg"> </a>
			    	</div>
    	        </div>
				<div class="row" id="newestGamesRow">
				    <div class="col card" id="gameCard">
    	                <a id="game" onclick="monsterHunterRise()"> <img src="images/games/monsterhunter.jpg" alt="Monster Hunter Rise" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="pokemonShiningPearl()"> <img src="images/games/pokemonshiningpearl.jpg" alt="Pokemon Shining Pearl" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="finalFantasy7Remake()"> <img src="images/games/finalfantasy7remake.jpg" alt="Final Fantasy 7 Remake" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="marvelsGuardiansOfTheGalaxy()"> <img src="images/games/marvelsguardiansofthegalaxy.jpg" alt="Marvel's Guardians of the Galaxy" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="shadowOfTheTombRaider()"> <img src="images/games/shadowofthetombraider.jpg" alt="Shadow of the Tomb Raider" id="gameImg"> </a>
			    	</div>
    	        </div>
				<div class="row" id="newestGamesRow">
    	            <div class="col card" id="gameCard">
    	                <a id="game" type="submit" onclick="theElderScrollsV()"><img src="images/games/theelderscrolls.jpg" alt="The Elder Scrolls V Skyrim Special Edition" id="gameImg"></a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="deadPool()"> <img src="images/games/deadpool.png" alt="Deadpool" id="gameImg"> </a>
			    	</div>
                    <div class="col card" id="gameCard">
    	                <a id="game" onclick="spyro()"> <img src="images/games/spyro.jpg" alt="Spyro" id="gameImg"> </a>
			    	</div>
    	            <div class="col card" id="gameCard">
    	                <a id="game" onclick="legoJurassicWorld()"> <img src="images/games/legojurassicworld.jpg" alt="Lego Jurassic World" id="gameImg"> </a>
			    	</div>
					<div class="col card" id="gameCard">
    	                <a id="game" onclick="mafiaDefinitiveEdition()"> <img src="images/games/mafia.jpg" alt="Mafia Definitive Edition" id="gameImg"> </a>
			    	</div>
    	        </div>
    	    </div>

    	</div>
		<!-- END OF GAMES -->

		<!-- ELDEN RING PAGE -->
		<div class="eldenRing">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Elden Ring'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="eldenRingButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- POKEMON LEGENDS: ARCEUS -->
		<div class="pokemonLegendsArceus">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Pokemon Legends: Arceus'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
						<button  type= "submit" id="addCartBtn" name="pokemonLegendsButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- TINY TINAS WONDERLAND -->
        <div class="tinytinaswonderland">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Tiny Tinas Wonderland'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="tinyTinasButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>						
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- STRANGER OF PARADISE: FINAL FANTASY ORIGIN -->
		<div class="strangerOfParadise">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Stranger of Paradise: Final Fantasy Origin'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
						<form method="post">
						<button  type= "submit" id="addCartBtn" name="strangerOfParadiseButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- WWE 2K22 -->
		<div class="wwe2k22">
		<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'WWE 2K22'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="wwe2k22Button"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- SUPER SMASH BROS -->
        <div class="superSmashBrosUltimate">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Super Smash Bros. Ultimate'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="superSmashButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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
		
		<!-- GTA 5 -->
		<div class="gta5">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'GTA 5'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="gta5Button"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- STAR WARS FALLEN ORDER -->
		<div class="starWarsFallenOrder">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Star Wars: Fallen Order'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="starWarsFallenButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>						
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- ASSASSINS CREED THE EZIO COLLECTION -->
        <div class="assassinsCreed">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Assassins Creed The Ezio Collection'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="assassinsCreedButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>						
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- TOM CLANCY'S RAINBOW SIX SIEGE -->
		<div class="tomClancysRainbowSixSeige">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Tom Clancys Rainbow Six Siege'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>

						<form method="post">
						<button  type= "submit" id="addCartBtn" name="rainbowSixButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- POKEMON SHINING PEARL -->
		<div class="pokemonShiningPearl">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Pokemon Shining Pearl'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="pokemonShiningPearlButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- MONSTER HUNTER RISE -->
		<div class="monsterHunterRise">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Monster Hunter Rise'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="monsterHunterButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- FINAL FANTASY 7 REMAKE -->
		<div class="finalFantasy7Remake">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Final Fantasy 7 Remake'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="finalFantasy7Button"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>
					</form>					
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- MARVEL'S GUARDIANS OF THE GALAXY -->
		<div class="marvelsGuardiansOfTheGalaxy">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Marvels Guardians of the Galaxy'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="guardiansOfGalaxyButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- SHADOW OF THE TOMB RAIDER -->
		<div class="shadowOfTheTombRaider">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Shadow of the Tomb Raider'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="shadowOfTheTombRaiderButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- ELDER SCROLLS V: SKYRIM -->
		<div class="theElderScrollsV">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Elder Scrolls V Skyrim Special Edition'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="elderScrollsVButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- DEADPOOL -->
		<div class="deadPool">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Deadpool'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="deadPoolButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- SPYRO -->
		<div class="spyro">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Spyro'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="spyroButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- LEGO JURASSIC WORLD -->
		<div class="legoJurassicWorld">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Lego Jurassic World'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="legoJurassicButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
					</form>
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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

		<!-- MAFIA -->
		<div class="mafiaDefinitiveEdition">
			<?php
		
			// Fetch image from database
			$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Mafia: Definitive Edition'");
			while ($row = mysqli_fetch_array($query_run)) {     
			?>	
			<div class="row">
		 		<div class="col-4"> 
					 <?php echo "<img src=".$row['Photo']." height='500' width='350' >"; ?>
				</div>
				<div class="mt-4 col-8">
					<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
					<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
					<p> <span style="font-weight:bold;">Genre: </span><?php echo $row['Genre']; ?> </p>
						<p> <span style="font-weight:bold;">Publisher: </span> <?php echo $row['Publisher']; ?> </p>
						<p> <span style="font-weight:bold;">Developer: </span> <?php echo $row['Developer']; ?> </p>
					<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
					<p> <span style="font-weight:bold;">In Stock: </span> <?php echo $row['Quantity_in_stock']; ?> </p>
					<form method="post">
						<button  type= "submit" id="addCartBtn" name="mafiaButton"  style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button> 
					</form>					
					<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='games.php'">
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
					<button id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
							<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
							<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
						</svg>
						ADD TO CART
					</button>  
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
	if(array_key_exists('eldenRingButton', $_POST)) {
		$productid = 22;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
	}
	else if(array_key_exists('pokemonLegendsButton', $_POST)) {
		$productid = 28;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('tinyTinasButton', $_POST)) {
		$productid = 30;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('strangerOfParadiseButton', $_POST)) {
		$productid = 32;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('wwe2k22Button', $_POST)) {
		$productid = 35;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('superSmashButton', $_POST)) {
		$productid = 26;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	 else if(array_key_exists('gta5Button', $_POST)) {
		$productid = 37;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	 else if(array_key_exists('starWarsFallenButton', $_POST)) {
		$productid = 38;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	 else if(array_key_exists('assassinsCreedButton', $_POST)) {
		$productid = 39;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	 else if(array_key_exists('rainbowSixButton', $_POST)) {
		$productid = 40;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	 else if(array_key_exists('pokemonShiningPearlButton', $_POST)) {
		$productid = 41;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	 else if(array_key_exists('monsterHunterButton', $_POST)) {
		$productid = 42;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('finalFantasy7Button', $_POST)) {
		$productid = 43;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('guardiansOfGalaxyButton', $_POST)) {
		$productid = 51;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('shadowOfTheTombRaiderButton', $_POST)) {
		$productid = 52;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('elderScrollsVButton', $_POST)) {
		$productid = 53;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('deadPoolButton', $_POST)) {
		$productid = 58;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('spyroButton', $_POST)) {
		$productid = 59;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	else if(array_key_exists('legoJurassicButton', $_POST)) {
		$productid = 60;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }	   
	else if(array_key_exists('mafiaButton', $_POST)) {
		$productid = 61;
		$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
       }
	?>

	</div>

</body>
<script>
	    function superSmashBrosUltimate() { 
            window.scrollTo(0,0);
            document.getElementsByClassName('superSmashBrosUltimate')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function wwe2k22() {
            window.scrollTo(0,0);
            document.getElementsByClassName('wwe2k22')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function pokemonLegendsArceus() {
            window.scrollTo(0,0);
            document.getElementsByClassName('pokemonLegendsArceus')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function spyro() {
            window.scrollTo(0,0);
            document.getElementsByClassName('spyro')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function legoJurassicWorld() {
            window.scrollTo(0,0);
            document.getElementsByClassName('legoJurassicWorld')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function eldenRing() {
			window.scrollTo(0,0);
            document.getElementsByClassName('eldenRing')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function tinytinaswonderland() {
			window.scrollTo(0,0);
            document.getElementsByClassName('tinytinaswonderland')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function strangerOfParadise() {
			window.scrollTo(0,0);
            document.getElementsByClassName('strangerOfParadise')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function starWarsFallenOrder() {
			window.scrollTo(0,0);
            document.getElementsByClassName('starWarsFallenOrder')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function gta5() {
			window.scrollTo(0,0);
            document.getElementsByClassName('gta5')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function finalFantasy7Remake() {
			window.scrollTo(0,0);
            document.getElementsByClassName('finalFantasy7Remake')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function moana() {
			window.scrollTo(0,0);
            document.getElementsByClassName('moana')[0].style.display = 'block';
            document.getElementsByClassName('moviesList')[0].style.display = 'none';
            }
            
        function assassinsCreed() {
			window.scrollTo(0,0);
            document.getElementsByClassName('assassinsCreed')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function tomClancysRainbowSixSeige() {
			window.scrollTo(0,0);
            document.getElementsByClassName('tomClancysRainbowSixSeige')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function pokemonShiningPearl() {
			window.scrollTo(0,0);
            document.getElementsByClassName('pokemonShiningPearl')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function monsterHunterRise() {
			window.scrollTo(0,0);
            document.getElementsByClassName('monsterHunterRise')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function marvelsGuardiansOfTheGalaxy() {
			window.scrollTo(0,0);
            document.getElementsByClassName('marvelsGuardiansOfTheGalaxy')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function theElderScrollsV() {
			window.scrollTo(0,0);
            document.getElementsByClassName('theElderScrollsV')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function mafiaDefinitiveEdition() {
			window.scrollTo(0,0);
            document.getElementsByClassName('mafiaDefinitiveEdition')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function deadPool() {
			window.scrollTo(0,0);
            document.getElementsByClassName('deadPool')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }

		function shadowOfTheTombRaider() {
			window.scrollTo(0,0);
            document.getElementsByClassName('shadowOfTheTombRaider')[0].style.display = 'block';
            document.getElementsByClassName('gamesList')[0].style.display = 'none';
            }
			
</script>
</html>
