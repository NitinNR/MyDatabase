<?php

session_start();
if(isset($_SESSION["forput"])){

    $forwhat = $_SESSION["forput"];
    $name = $_SESSION["name"];
    $wnum = $_SESSION["wnumber"];
    $addr = $_SESSION["address"];
    $pass = $_SESSION["password"];


}else{
    $forwhat = "";
    $name = "";
    $wnum = "";
    $addr = "";
    $pass = "";
}

if (isset($_POST["regstr"])) {


$imageName = time()."".$_FILES["myimage"]["name"];

$fullname = $_POST["first_name"]." ".$_POST["last_name"];

$targetLocation = "uploadedImages/".basename($imageName);
register($targetLocation,$_FILES["myimage"]["tmp_name"],$fullname,$_POST["wapp"],$_POST["password"],$_POST["myaddress"],
    $imageName);
    
}

function register($target,$file,$fullname,$whatsapp_number,$password,$address,$imagename){
    $conn = mysqli_connect("sql337.main-hosting.eu","u362881663_bible_bot","bible_bot","u362881663_bible_bot");
    if($conn){

            $s_query = "Select * from static_users where whatsapp_number='$whatsapp_number' ";
            $checknum = $conn->query($s_query);
            if($checknum->num_rows>0){
                //echo "<script>alert('Number already exists');</script>";
            }else{

                $i_query = "Insert into static_users(name,whatsapp_number,address,Password,profile_image) values('$fullname','$whatsapp_number','$address','$password','$imagename')";

                $result = $conn->query($i_query);

                if(!move_uploaded_file($_FILES["myimage"]["tmp_name"], $target)){

                    //echo "<script>alert('Image not uploaded');</script>";

            }

            }

    }
}



?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register - Bible Bot Panel</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/style.css">
      
    <script src="https://kit.fontawesome.com/b7b7d528ee.js" crossorigin="anonymous"></script>
    <script src="js/myjs.js"></script>
    <script type="text/javascript">

        function whenBodyLoad(){
            
            alert("<?php session_start(); 

                if(isset($_SESSION['forput'])){
                    echo("<script>alert('ok');</script>");
                }else{
                    echo("<script>alert('nope');</script>");
                }

                //echo "$_SESSION["forput"]"; ?>");


        }

        var is_num_verified = false;
        
        function clickfile(){
            $("#myfile").click();
        }
        function openimage(myfile){
            

            if (myfile.files && myfile.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //console.log(e.target.result);
                    $('#profile').attr('src', e.target.result);
                }

                reader.readAsDataURL(myfile.files[0]);
            }
        }

        function checkNumber(){
          $("#vbtn").val("sending otp...");
          $("#vbtn").prop("disabled",true);

          var factor = $("#exampleInputEmail").val().toString();


          if (factor==""){

            alert("Please enter your whatsapp number");
            $("#vbtn").val("Send OTP");
            $("#vbtn").prop("disabled",false);

          }else{

            console.log(factor);

            $.ajax({

                  type: "POST",
                  url: 'checkUser.php',
                  dataType:'text',

                  data: {job: 'checkNumber',"whatsappNum":factor},
                    success: function (obj, textstatus)
                        {
                            console.log(obj);

                            if (obj=="1") {

                              alert("This whatsapp number is already exists");
                              $("#vbtn").val("Send OTP");
                              $("#vbtn").prop("disabled",false);

                            }else{

                                //console.log("going to verify");

                           verification();

                            }
                        },
                        error:function(error){
                            console.log("error");
                        }

                  });
          }

        }
        var gcode="";
        var is_otp_sent = false;
    function verification(){
          var userNumber =$("#exampleInputEmail").val().toString();
          //$("#verify").val("verifying..");

          //code2
            var code = Math.floor(1000 + Math.random() * 9000);
            
            gcode = code;
            
            var url = "https://eu49.chat-api.com/instance96695/sendMessage?token=n3w2igu5q1sdhems";
            var mydata = {
            phone:userNumber, // Receivers phone
            body: gcode.toString() // Message
            };
            // Send a request
            $.ajax(url,{

            data : JSON.stringify(mydata),
            contentType : 'application/json',
            type : 'GET',
            success:function(obj,st){
                StartCounter();

                //console.log(JSON.stringify(obj));
              $("#vbtn").val("OTP sent");
              is_otp_sent = true;
              $("#vbtn").prop("disabled",true);

                //checkCode(code,"enter code");
            },
            error:function(hmm){
                console.log("error");
            }
            });
    
        }
    
    function checkValidation(){

        var first_name = $("#exampleFirstName").val();
        var last_name = $("#exampleLastName").val();
        var wnum = $("#exampleInputEmail").val();
        var otp = $("#exampleotp").val();
        var pass1 = $("#examplePasswordInput").val();
        var pass2 = $("#exampleRepeatPasswordInput").val();
        var myaddress = $("#addressId").val();
        console.log(first_name+" "+last_name+" "+wnum+" "+otp+" "+pass1+" "+pass2 +" "+myaddress);
        if(first_name!="" && last_name!="" && wnum!="" && otp!="" && pass1!="" && pass2!="" && myaddress){

            if(is_otp_sent){
                if(gcode==otp){
                console.log("otp matched");
                if (pass1==pass2) {

                    if ($("#myfile")[0].files.length===0) {
                        alert("Please choose your profile image");
                        return false;
                    }else{
                         alert("Registration Successfull");

                        return true;
                    }

                       
                }else{
                    alert("Password not Matching");
                    return false;
                }

                }else{
                alert("Wrong Otp");
                return false;
                }
            }else{
            alert("Please Send OTP to your whatsapp number");
            }

        }else{
            alert("Please fill all fields");
            return false;
        }

        return false;
    }

    function StartCounter(){
        $('.countdown').css("display","block");

     $('.countdown').html("1:01");
                        //counter...
                        var timer2 = "1:01";
                        var interval = setInterval(function() {


                        var timer = timer2.split(':');
                        //by parsing integer, I avoid all extra string processing
                        var minutes = parseInt(timer[0], 10);
                        var seconds = parseInt(timer[1], 10);
                        --seconds;
                        minutes = (seconds < 0) ? --minutes : minutes;
                        if (minutes < 0) clearInterval(interval);
                        seconds = (seconds < 0) ? 59 : seconds;
                        seconds = (seconds < 10) ? '0' + seconds : seconds;
                        //minutes = (minutes < 10) ?  minutes : minutes;
                        if(minutes=="0" && seconds=="00"){

                            $('.countdown').css("display","none");
                            $("#vbtn").val("Send OTP");
                            $("#vbtn").prop("disabled",false);
                            $('.countdown').html("1:01");
                            clearInterval(interval);

                        }
                        $('.countdown').html(minutes + ':' + seconds);
                        timer2 = minutes + ':' + seconds;
                        }, 1000);
    }



    </script>
</head>

<body onload="whenBodyLoad()" class="bg-gradient-primary">
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="  
                        background: url(images/regb.png);
                          background-repeat: no-repeat;
                          background-size: cover;"></div>
                                            </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Create an Account!</h4>
                            </div>
                    <!--Form-->
            <form class="user" method="POST" action="" enctype="multipart/form-data" onsubmit="return checkValidation()">
                            <div class="container">  
                                <div class="row " style="margin: 10px;">
                                    <input onchange="openimage(this)" type="file" name="myimage" style="display: none;" id="myfile">
                                <div class="col-sm-4 offset-sm-4" ><img id="profile" onclick="clickfile()" width="190px" height="190px" style="border-radius: 50%;cursor: pointer;" src="media/user4.png" alt="Avatar"></div>

                                </div>
                            </div>
                                
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" value="<?php  echo $name; ?>" id="exampleFirstName" placeholder="First Name" name="first_name"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="exampleLastName" value="<?php echo $name; ?>" placeholder="Last Name" name="last_name"></div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-8 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleInputEmail" value="<?php echo $wnum; ?>" aria-describedby="emailHelp" placeholder="WhatsApp Number" name="wapp">
                                    </div>
                                    <div class="col-sm-4 mb-3 mb-sm-0"  >
                                    <input type="button" id="vbtn" class="btn btn-secondary" onclick="checkNumber()" 
                                    value="Send OTP" /><p style="display: block;float: right;" class="countdown">1:00</p>
                                    </div>
                                    
                                </div>
                                <div class="form-group row">
                                <div class="col-sm-8 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="exampleotp" aria-describedby="emailHelp" placeholder="OTP" name="otp">
                                    </div>
                                </div>
                                <div class="form-group row">
                                        <div class="col-sm-8 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="addressId" aria-describedby="emailHelp" placeholder="Address(Country,state,city)" name="myaddress">
                                    </div>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" id="examplePasswordInput" value="<?php echo $pass; ?>" placeholder="Password" name="password"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" value="<?php echo $pass; ?>" placeholder="Repeat Password" name="password_repeat"></div>
                                </div><button class="btn btn-primary btn-block text-white btn-user" id="regstrid" name="regstr" type="submit">Register Account</button>
<!--
                                <hr><a class="btn btn-primary btn-block text-white btn-google btn-user" role="button"><i class="fab fa-google"></i>&nbsp; Register with Google</a><a class="btn btn-primary btn-block text-white btn-facebook btn-user" role="button"><i class="fab fa-facebook-f"></i>&nbsp; Register with Facebook</a>

                                <hr>
-->
                            </form>
                            <div class="text-center"><a class="small" href="forgot-password.html">Forgot Password?</a></div>
                            <div class="text-center"><a class="small" href="login.html">Already have an account? Login!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="js/theme.js"></script>
    <script src="js/myjs.js"></script>
</body>

</html>