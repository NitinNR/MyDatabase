<?php
if($_POST["job"]=="check_status"){
	$number  = $_POST["wnum"];
	checkStatus($number);
}

if($_POST["job"]=="checkNumber"){
  $number  = $_POST["whatsappNum"];
  checkNumber($number);
}
function checkStatus($num){

  $conn = mysqli_connect("sql337.main-hosting.eu","u362881663_bible_bot","bible_bot","u362881663_bible_bot");
  if($conn)
  {
  	
    $squery = "SELECT * FROM static_users WHERE whatsapp_number='$num'";
    $result = $conn->query($squery);
    if($result->num_rows > 0){

    session_start();
    while($row = $result->fetch_assoc()){

      	if($row["name"]==null|| $row["name"]==""){

      		echo "update";
      		
      		

      	}
      	$_SESSION["forput"]="yes";
      	$_SESSION["name"]=$row["name"];
      	$_SESSION["wnumber"]=$row["whatsapp_number"];
      	$_SESSION["address"]=$row["address"];
      	$_SESSION["password"]=$row["Password"];


      }
    }else{
        echo "0";
    }

  }else{
  	echo "not connected";
  }

}

function checkNumber($num){

  $conn = mysqli_connect("sql337.main-hosting.eu","u362881663_bible_bot","bible_bot","u362881663_bible_bot");
  if($conn)
  {
    
    $squery = "SELECT * FROM static_users WHERE whatsapp_number='$num'";
    $result = $conn->query($squery);
    if($result->num_rows > 0)
      echo "1";
    else
      echo "0";

  }else
    echo "not connected";
  

}

?>