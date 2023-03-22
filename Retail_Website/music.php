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
					<form action="music.php" method="post" class="col" id="searchBarForm">
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
		<!-- NEWEST MUSIC -->
    	<div class="musicList">
    	    <h2 id="newestMusicTitle">Newest Music</h2>

    	    <div class="card-group d-flex justify-content-center">

			<div class="row" id="newestMusicRow">
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="anEveningWithSilkSonic()"><img src="images/music/aneveningwithsilksonic.jpg" alt="An Evening With Silk Sonic" id="musicImg"></a>
    	                <label for="music"> An Evening With Silk Sonic </label>
			    	</div>
					<div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="oneNightInMalibu()"> <img src="images/onenight.jpg" alt="One Night in Malibu" id="musicImg"> </a>
    	                <label for="music"> One Night in Malibu </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="scenicDrive()"> <img src="images/music/scenicdrive.jpg" alt="Scenic Drive" id="musicImg"> </a>
    	                <label for="music"> Scenic Drive </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="a30()"> <img src="images/music/adele30.jpg" alt="a30" id="musicImg"> </a>
    	                <label for="music"> 30 </label>
			    	</div>
					<div class="col card" id="musicCard">
    	                <a id="music" type = "submit" onclick="red()"> <img src="images/music/red.jpg" alt="Red" id="musicImg"> </a>
    	                <label for="music"> Red (Taylor Swift's Version) </label>
			    	</div>
    	        </div>

    	    </div>
		<!-- END OF NEWEST MUSIC -->

		<!-- OTHER MUSIC -->
    	    <h2 id="otherMusicTitle">Music</h2>

    	    <div class="card-group d-flex justify-content-center">

    	        <div class="row" id="musicRow">
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="jubilee()"><img src="images/music/jubilee.jpeg" alt="Jubilee" id="musicImg"></a>
						<label for="music"> Jubilee </label>
			    	</div>
					<div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="callMeIfYouGetLost()"> <img src="images/music/callmeifyougetlost.jpg" alt="call Me if You Get Lost" id="musicImg"> </a>
						<label for="music"> Call me If You Get Lost </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="cultureiii()"> <img src="images/music/cultureiii.png" alt="Culture III" id="musicImg"> </a>
						<label for="music"> Culture III </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="happierThanEver()"> <img src="images/music/happierthanever.jpg" alt="Happier Than Ever" id="musicImg"> </a>
						<label for="music"> Happier Than Ever </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="heartAndSoul()"> <img src="images/music/heartandsoul.jpeg" alt="Heart & Soul" id="musicImg"> </a>
												<label for="music"> Heart and Soul </label>
			    	</div>
    	        </div>
				<div class="row" id="musicRow">
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="justice()"><img src="images/music/justice.jpg" alt="Justice" id="musicImg"></a>
						<label for="music"> Justice </label>
			    	</div>
					<div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="outsideChild()"> <img src="images/music/outsidechild.jpg" alt="Outside Child" id="musicImg"> </a>
						<label for="music"> Outside Child </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="reckless()"> <img src="images/music/reckless.jpg" alt="Reckless" id="musicImg"> </a>
						<label for="music"> Reckless </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="roadRunner()"> <img src="images/music/roadrunner.jpg" alt="ROADRUNNER" id="musicImg"> </a>
						<label for="music"> RoadRunner </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="scaledAndIcy()"> <img src="images/music/scaledandicy.jpg" alt="Scaled and Icy" id="musicImg"> </a>
						<label for="music"> Scaled And Icy </label>
			    	</div>
    	        </div>
				<div class="row" id="musicRow">
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" type="submit" onclick="sometimesIMightBeIntrovert()"><img src="images/music/sometimesimightbeintrovert.jpeg" alt="Sometimes I Might Be Introvert" id="musicImg"></a>
						<label for="music"> Sometimes I Might Be Introvert </label>
			    	</div>
					<div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="sour()"> <img src="images/music/sour.jpg" alt="SOUR" id="musicImg"> </a>
						<label for="music"> Sour </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="theOffSeason()"> <img src="images/music/theoffseason.jpg" alt="The Off Season" id="musicImg"> </a>
						<label for="music"> The off-season </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="v()"> <img src="images/music/v.png" alt="V" id="musicImg"> </a>
						<label for="music"> V - Maroon 5 </label>
			    	</div>
    	            <div class="col card" id="musicCard">
    	                <a id="music" type="submit" onclick="wonder()"> <img src="images/music/wonder.png" alt="Wonder" id="musicImg"> </a>
						<label for="music"> Wonder </label>
			    	</div>
    	        </div>
				
    	    </div>

    	</div>
		<!-- END OF OTHER MUSIC -->

		<!-- WONDER PAGE -->
		<div class="wonder">
		<?php

?>
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Wonder'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Intro </li>
								<li> Wonder </li>
								<li> Higher </li>
								<li> 24 Hours</li>
								<li> Teach Me How To Love </li>
								<li> Call My Friends </li>
								<li> Dream </li>
								<li> Song For No One</li>
								<li> Monster</li>
								<li> 305</li>
								<li> Always Been You</li>
								<li> Piece Of You</li>          
								<li> Look Up At The Stars</li>
								<li> Can't Imagine </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
                        <form method="post"> 
						<button type="submit" id="addCartBtn" name="wonderButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;"<\button>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		
		<!-- AN EVENING WITH SILK SONIC PAGE -->
		<div class="anEveningWithSilkSonic">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'An Evening With Silk Sonic'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Silk Sonic Intro </li>
								<li> Leave The Door Open </li>
								<li> Fly As me</li>
								<li> After Last Night</li>
								<li> Smokin Out The Window </li>
								<li> Put on a Smile </li>
								<li> 777</li>
								<li> Skate</li>
								<li> Love's Train</li>
								<li> Blast Off</li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
                        <form method="post">
						<button name="sonicButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- One Night in Malibu Page-->
		<div class="oneNightInMalibu">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'One Night in Malibu'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Horizon </li>
								<li> Distance </li>
								<li> Take Care Of You</li>
								<li> Good Life</li>
								<li> Rescue Me </li>
								<li> Secrets </li>
								<li> Wanted</li>
								<li> Lose Somebody</li>
								<li> Better Days</li>
								<li> Run</li>
								<li> I Lived</li>
								<li> Someday</li>
								<li> Ships + Tides</li>
								<li> Apologize</li>
								<li> Love Runs Out</li>
								<li> Counting Stars</li>
								<li> Wild Life</li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post">
						<button name="malibuButton"id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
							</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!--Scenic Drive Page-->
		<div class="scenicDrive">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Scenic Drive'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Intro </li>
								<li> Backseat </li>
								<li> Brand New</li>
								<li> Voicemail</li>
								<li>  Scenic Drive </li>
								<li> Present </li>
								<li> Retrograde</li>
								<li> All I feel Is Rain</li>
								<li> Open</li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="scenicButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- 30 -->
		<div class="a30">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = '30'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Strangers by Nature </li>
								<li> Easy on Me </li>
								<li> My Little Love </li>
								<li> Cry Your Heart Out</li>
								<li> Oh My God </li>
								<li> Can I Get It </li>
								<li> I Drink Wine </li>
								<li> Woman Like Me</li>
								<li> All Night Parking</li>
								<li> Women Like Me</li>
								<li> Hold On</li>
								<li> To Be Loved</li>
								<li> Hold On</li>
								<li> Love Is a Game </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="30Button" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- Red Page-->
		<div class="red">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Red'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> State of Grace </li>
								<li> Red </li>
								<li> Treacherous </li>
								<li> I knew You were Trouble</li>
								<li> All Too Well </li>
								<li> 22 </li>
								<li> I Almost Do </li>
								<li> We Are Never Ever Getting Back Together</li>
								<li> Stay Stay Stay</li>
								<li> The Last Time</li>
								<li> Holy Ground</li>
								<li> Sad Beautiful Tragic</li>
								<li> The Lucky One</li>
								<li> Everything Has Changed </li>
								<li> Starlight </li>
								<li> Begin Again </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="redButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
							</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- JUBILEE Page -->
		<div class="jubilee">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Jubilee'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Paprika </li>
								<li> Be Sweet </li>
								<li> Kokomo, IN </li>
								<li> Slide Tackle</li>
								<li> Posing in Bondage </li>
								<li> Sit </li>
								<li> Savage Good Boy </li>
								<li> In Hell</li>
								<li> Tactics</li>
								<li> Posing for Cars</li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="jubileeButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- JUSTICE PAGE -->
		<div class="justice">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Justice'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> 2 Much </li>
								<li> Deserve You </li>
								<li> As I Am </li>
								<li> Off My Face</li>
								<li> Holy </li>
								<li> Unstable </li>
								<li> MLK Interlude </li>
								<li> Die for You</li>
								<li> Hold On</li>
								<li> Somebody</li>
								<li> Ghost</li>
								<li> Peaches</li>
								<li> Love You Different</li>
								<li> Loved by You</li>
								<li> Anyone</li>
								<li> Lonely</li>
								<li> Red Eye</li>
								
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button id="addCartBtn" name="justiceButton" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- OUTSIDECHILD PAGE -->
		<div class="outsideChild">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Outside Child'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Montreal </li>
								<li> Nightflyer </li>
								<li> Persephone </li>
								<li> 4th Day Prayer</li>
								<li> The Runner </li>
								<li> Hy-Brasil </li>
								<li>  The Hunters </li>
								<li> All Of The Women </li>
								<li> Poison Arrow </li>
								<li> Little Rebirth </li>
								<li> Joyful Motherfuckers </li>

							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="outsideButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		<!-- RECKLESS PAGE -->
		<div class="reckless">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Reckless'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> One Night Love Affair </li>
								<li> She's Only Happy When... </li>
								<li> Run to You </li>
								<li> Heaven (Live)</li>
								<li> Somebody  </li>
								<li> Summer of '69 </li>
								<li>  Kids Wanna Rock</li>
								<li> It's Only Love</li>
								<li> Long Gone</li>
								<li> Ain't Gonna Cry</li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="recklessButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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

		<!-- CALLMEIFYOUGETLOST PAGE -->
		<div class="callMeIfYouGetLost">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Call Me If You Get Lost'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Sir Baudelaire </li>
								<li> Corso </li>
								<li> Lemonehead </li>
								<li> Wusyaname</li>
								<li> Lumberjack </li>
								<li> Hot Wind Blows </li>
								<li>  Massa </li>
								<li> Runitup </li>
								<li> Manifesto </li>
								<li> Sweet </li>
								<li> Mama talk </li>
								<li> Rise! </li>
								<li> Blessed </li>
								<li> Juggernaut </li>
								<li> Wilshire </li>
								<li> Safari </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="callmeButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- CULTUREIII PAGE -->
		<div class="cultureiii">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Culture III'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Avalanche </li>
								<li> Having Our Way </li>
								<li> Straightenin </li>
								<li> Type Shit</li>
								<li> Malibu </li>
								<li> Birthday </li>
								<li>  Modern Day </li>
								<li> Vaccine </li>
								<li> Picasso </li>
								<li> Roadrunner </li>
								<li>  What You See </li>
								<li> Jane </li>
								<li> Antisocial </li>
								<li> Why Not </li>
								<li> Mahomes </li>
								<li> Handle My Business </li>
								<li> Time For Me </li>
								<li> Light It Up </li>
								<li> Need It </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="cultureButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
        <!-- HAPPIERTHANEVER PAGE -->
		<div class="happierThanEver">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Happier Than Ever'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Getting Older </li>
								<li> I Didn't Change My Number </li>
								<li> Billie Bossa Nova </li>
								<li> My future </li>
								<li> Oxytocin </li>
								<li> GOLDWING </li>
								<li>  Lost Cause </li>
								<li> Halley's Comet </li>
								<li> Not My Responsibility </li>
								<li> Overheated </li>
								<li>  Everybody Dies </li>
								<li> Yout Power </li>
								<li> NDA </li>
								<li> Therefore </li>
								<li> Happier Than Ever </li>
								<li>  Male Fantasy </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="happierButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
		 <!-- HEARTANDSOUL PAGE -->
		<div class="heartAndSoul">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Heart And Soul'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Rock & Roll Found Me </li>
								<li> Through My Ray-Bans </li>
								<li> Heart On Fire </li>
								<li> Heart On Fire </li>
								<li> Heart of the Night </li>
								<li> Doing Life With Me </li>
								<li>  Look Good and You Know It </li>
								<li> Do Side </li>
								<li> Bright Side Girl </li>
								<li> Russian Roulette </li>
								<li> Break It Kind of Guy </li>
								<li> Kiss Her Goodbye </li>
								<li> People Break </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="heartButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- ROADRUNNER PAGE -->
		<div class="roadRunner">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'roadRunner'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> BUZZCUT </li>
								<li> CHAIN ON </li>
								<li> COUNT ON ME </li>
								<li> BANKROLL </li>
								<li> THE LIGHT </li>
								<li> WINDOWS </li>
								<li> I'LL TAKE YOU ON </li>
								<li> OLD NEWS </li>
								<li> WHAT'S THE OCCASION </li>
								<li> WHEN I BALL </li>
								<li> DON'T SHOOT UP THE PARTY </li>
								<li> DEAR LORD </li>
								<li> THE LIGHT PT.II </li>
								<li> Robero's interlude </li>
								<li> Jeremiah </li>
								<li> SEX </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="roadButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- SCALEDANDICY PAGE -->
		<div class="scaledAndIcy">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Scaled And Icy'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Good Day </li>
								<li> Choker </li>
								<li> Shy Away </li>
								<li> The Outside </li>
								<li> Saturday </li>
								<li> Never Take It </li>
								<li> Mulberry Street </li>
								<li> Formidable </li>
								<li> Bounce Man </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="scaleButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- SOMETIMESIMIGHTBEINTROVERT PAGE -->
		<div class="sometimesIMightBeIntrovert">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Sometimes I Might Be Introvert'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Introvert </li>
								<li> Woman </li>
								<li> Two Worlds Apart </li>
								<li> I Love You, I Hate You </li>
								<li> Little Q, Pt. 1 </li>
								<li> Little Q, Pt. 2 </li>
								<li> Gems </li>
								<li> Speed </li>
								<li> Standing Ovation </li>
								<li> I See You </li>
								<li> The Rapper That Came To Tea </li>
								<li> Rollin Stone </li>
								<li> Protect My Energy </li>
								<li> Never Make Promises </li>
								<li> Point and Kill </li>
								<li> Fear No Man </li>
								<li> The Garden </li>
								<li> How Did You Get Here </li>
								<li> Miss Understood </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="sometimeButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- SOUR PAGE -->
		<div class="sour">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'Sour'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> brutal </li>
								<li> traitor </li>
								<li> drivers license </li>
								<li> 1 step forward, 3 steps behind </li>
								<li> deja vu </li>
								<li> Good 4 U </li>
								<li> enough for you </li>
								<li> happier </li>
								<li> jealousy, jealousy </li>
								<li> favorite crime </li>
								<li> hope ur ok </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="sourButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- THEOFFSEASON PAGE -->
		<div class="theOffSeason">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'The Off-Season'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> 95.south </li>
								<li> amari </li>
								<li> my.life </li>
								<li> applying.pressure </li>
								<li> punchin',the.clock </li>
								<li> 100.mil' </li>
								<li> pride.is.the.devil </li>
								<li> let.go.my.hand </li>
								<li> interlude </li>
								<li> the.climb.back </li>
								<li> hunger.on.hillside </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="seasonButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button> 
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
<!-- V PAGE -->
		<div class="v">
			<?php
			
			// Fetch image from database
				$query_run = mysqli_query($conn, "SELECT * FROM Product WHERE Product_name = 'V'");
				while ($row = mysqli_fetch_array($query_run)) {     
				?>	
				<div class="row">
		 			<div class="mt-4 col-4"> 
						 <?php echo "<img src=".$row['Photo']." height='300' width='300' >"; ?>
					</div>
					<div class="mt-4 col-8">

						<p style="font-size:40px;"><?php echo $row['Product_name']; ?>
						<p> <span style="font-weight:bold;">Artist: </span> <?php echo $row['Artist']; ?> </p>
						<p> <span style="font-weight:bold;">Release Date: </span> <?php echo $row['Release_date']; ?> </p>
						<p> <span style="font-weight:bold;">Tracks: </span> </p>
						<div id="tracklist">
							<ul id="list">
								<li> Maps </li>
								<li> Animals </li>
								<li> It Was Always You </li>
								<li> Unkiss me </li>
								<li> Sugar </li>
								<li> Leaving California </li>
								<li> In Your Pocket </li>
								<li> New Love </li>
								<li> Coming Back for You </li>
								<li> Feelings </li>
								<li> My Heart Is Open </li>
								<li> This Summer's Gonna Hurt </li>
								<li> Shoot Love </li>
								<li> Sex And Candy </li>
								<li> Lost Stars </li>
							</ul>
						</div>
						<p> <span style="font-weight:bold;">Price: $</span> <?php echo $row['Price']; ?> </p>
						<form method="post"> 
						<button name="vButton" id="addCartBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #fd8930; color: #ffffff;">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus" viewBox="0 0 16 16">
								<path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z"/>
								<path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
							</svg>
							ADD TO CART
						</button>  
						</form>
						<button id="moviesBackBtn" style="height:40px; width: 200px; border-radius:10px; background-color: #000000; color: #ffffff;" onClick="window.location='music.php'">
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
        if(array_key_exists('wonderButton', $_POST)) {
            $productid = 24;
    			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
        else if(array_key_exists('sonicButton', $_POST)) {
			$productid = 25;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('malibuButton', $_POST)) {
			$productid = 21;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('scenicButton', $_POST)) {
			$productid = 27;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('30Button', $_POST)) {
			$productid = 29;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('redButton', $_POST)) {
			$productid = 48;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('jubileeButton', $_POST)) {
			$productid = 44;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('justiceButton', $_POST)) {
			$productid = 45;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('outsideButton', $_POST)) {
			$productid = 46;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('callmeButton', $_POST)) {
			$productid = 31;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
         else if(array_key_exists('recklessButton', $_POST)) {
			$productid = 47;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('cultureButton', $_POST)) {
			$productid = 33;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('heartButton', $_POST)) {
			$productid = 36;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('happierButton', $_POST)) {
			$productid = 34;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
		 }
			 else if(array_key_exists('roadButton', $_POST)) {
			$productid = 49;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
			 }
			 else if(array_key_exists('scaleButton', $_POST)) {
			$productid = 50;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('sometimeButton', $_POST)) {
			$productid = 54;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('sourButton', $_POST)) {
			$productid = 55;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('seasonButton', $_POST)) {
			$productid = 56;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        }
		 else if(array_key_exists('vButton', $_POST)) {
			$productid = 57;
			$query = "INSERT into Add_item values ('$userid', '$productid', '$shoppingcartid')";
			$query_run = mysqli_query($conn,$query);
        
        
        }
    ?>

	</div>

</body>
<script>
	    function wonder() {
            window.scrollTo(0,0);
            document.getElementsByClassName('wonder')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }

	function anEveningWithSilkSonic() {
            window.scrollTo(0,0);
            document.getElementsByClassName('anEveningWithSilkSonic')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
			
	function oneNightInMalibu() {
            window.scrollTo(0,0);
            document.getElementsByClassName('oneNightInMalibu')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function scenicDrive() {
            window.scrollTo(0,0);
            document.getElementsByClassName('scenicDrive')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
			
	function a30() {
            window.scrollTo(0,0);
            document.getElementsByClassName('a30')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function red() {
            window.scrollTo(0,0);
            document.getElementsByClassName('red')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function jubilee() {
            window.scrollTo(0,0);
            document.getElementsByClassName('jubilee')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function justice() {
            window.scrollTo(0,0);
            document.getElementsByClassName('justice')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function outsideChild() {
            window.scrollTo(0,0);
            document.getElementsByClassName('outsideChild')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function callMeIfYouGetLost() {
            window.scrollTo(0,0);
            document.getElementsByClassName('callMeIfYouGetLost')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function cultureiii() {
            window.scrollTo(0,0);
            document.getElementsByClassName('cultureiii')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function happierThanEver() {
            window.scrollTo(0,0);
            document.getElementsByClassName('happierThanEver')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function heartAndSoul() {
            window.scrollTo(0,0);
            document.getElementsByClassName('heartAndSoul')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function reckless() {
            window.scrollTo(0,0);
            document.getElementsByClassName('reckless')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function roadRunner() {
            window.scrollTo(0,0);
            document.getElementsByClassName('roadRunner')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function scaledAndIcy() {
            window.scrollTo(0,0);
            document.getElementsByClassName('scaledAndIcy')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function sometimesIMightBeIntrovert() {
            window.scrollTo(0,0);
            document.getElementsByClassName('sometimesIMightBeIntrovert')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function sour() {
            window.scrollTo(0,0);
            document.getElementsByClassName('sour')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function theOffSeason() {
            window.scrollTo(0,0);
            document.getElementsByClassName('theOffSeason')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	function v() {
            window.scrollTo(0,0);
            document.getElementsByClassName('v')[0].style.display = 'block';
            document.getElementsByClassName('musicList')[0].style.display = 'none';
            }
	
			
</script>
</html>
