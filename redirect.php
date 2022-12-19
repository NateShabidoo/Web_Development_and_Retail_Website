<?php
session_start();
if ($_SESSION['username']==NULL){
header('Location: resourcesGuest.php');
} else {
  header('Location: resources.php');
}
exit;
?>
