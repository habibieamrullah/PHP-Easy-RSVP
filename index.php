<?php
include("config.php");
session_start();
?>
<!DOCTYPE html>
<html>
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <?php
        if(isset($_GET["feedback"])){
            ?>
            <title>Feedback - <?php echo $websitetitle ?></title>
            <?php
        }else{
            ?>
            <title><?php echo $websitetitle ?></title>
            <?php
        }
        ?>
    	
    	<link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    	
    	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    	<script
    	  src="https://code.jquery.com/jquery-3.4.1.min.js"
    	  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    	  crossorigin="anonymous"></script>
    	<style>
    		body{
    			background-color: black;
    			color: white;
    			font-family: 'Lato', sans-serif;
    		}
    		#container{
    			background-image: url(bg.jpg);
    			position: fixed;
    			top: 0; left: 0; right: 0; bottom: 0;
    			background-color: white;
    			background-position: center;
    			background-repeat: no-repeat;
    			background-size: cover;
    			overflow: auto;
    			padding-bottom: 100px;
    		}
    		.logos{
    			display: inline-block;
    		}
    		.formblock{
    			margin-bottom: 10px;
    		}
    		input, select, textarea, button{
    			width: 100%;
    			box-sizing: border-box;
    			padding: 10px;
    			outline: none;
    			border: none;
    			border-radius: 15px;
    		}
    		textarea{
    		    height: 125px;
    		}
    		label{
    			display: block;
    		}
    		button{
    			text-align: center;
    			font-weight: bold;
    			font-size: 18px;
    			background: rgb(177,143,0);
    			background: linear-gradient(152deg, rgba(177,143,0,1) 0%, rgba(233,176,69,1) 35%, rgba(255,244,0,1) 100%);
    			cursor: pointer;
    		}
    		
    		.submitbutton{
    		    text-align: center;
    			font-weight: bold;
    			font-size: 18px;
    			background: rgb(177,143,0);
    			background: linear-gradient(152deg, rgba(177,143,0,1) 0%, rgba(233,176,69,1) 35%, rgba(255,244,0,1) 100%);
    			cursor: pointer;
    		}
    		a{
    		    color: lime;
    		}
    		
    		table, th, td {
    		    font-size: 10px;
                border: 1px solid black;
                border-collapse: collapse;
                padding: 5px;
            }
            tr{
                background-color: white;
                color: purple;
            }
            
            
    	</style>
    	
		<link rel="apple-touch-icon" sizes="57x57" href="apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
		<link rel="manifest" href="manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
        
        <?php
        if(isset($_GET["admin"])){
            ?>
            <script src="xlsxcore.js"></script>
            <script src="filesaver.js"></script>
            <script src="tableexport.js"></script>
            <?php
        }
        ?>
    </head>
	<body>
		<div id="container">
			<div style="padding: 50px;">
				<div class="logos"><img src="logo-1.png" width="96"></div>
				<div class="logos" style="float: right"><img src="logo-2.png" width="96"></div>
			</div>
			<div style="max-width: 720px; margin: 0 auto; padding: 20px;">
				<div style="text-align: center; margin-bottom: 50px;"><a href=<?php echo $baseurl ?>><img src="registrationtitle.png" width="100%" style="max-width: 512px"></a></div>
				<?php
				    if(isset($_GET["logout"])){
				        $_SESSION["username"] = "";
				        $_SESSION["password"] = "";
				        session_unset();
				        session_destroy();
				        ?>
				        <h1>Logged out</h1>
				        <p>Please wait...</p>
						<script>
						    setTimeout(function(){
						        location.href="<?php echo $baseurl ?>";
						    }, 2000);
						</script>
				        <?php
				    }
				    if(isset($_GET["admin"])){
				        if(isset($_SESSION["username"]) && isset($_SESSION["password"]) && $_SESSION["username"] == $adminusername && $_SESSION["password"] == $adminpassword){
				            if(isset($_GET["delete"])){
				                $id = mysqli_real_escape_string($connection, $_GET["delete"]);
				                mysqli_query($connection, "UPDATE $registrationtable SET deleted=1 WHERE id=$id");
				            }
				            ?>
    						<h1>Welcome!</h1>
    						<p>In this page you can see the list of registered guests. Click <a href="<?php echo $baseurl ?>?logout">here</a> to logout.</p>
    						<h3>Quick Stat</h3>
    						<p>
    						    - Total of all people submitted the form: <?php echo mysqli_query($connection, "SELECT * FROM $registrationtable WHERE deleted = 0")->num_rows; ?><br>
    						    - Attending people: <?php echo mysqli_query($connection, "SELECT * FROM $registrationtable WHERE deleted = 0 AND attending = 'yes' ")->num_rows; ?><br>
    						    - Not Attending people: <?php echo mysqli_query($connection, "SELECT * FROM $registrationtable WHERE deleted = 0 AND attending = 'no' ")->num_rows; ?><br>
    						    - Awarded Nominee: <?php echo mysqli_query($connection, "SELECT * FROM $registrationtable WHERE deleted = 0 AND awarded = 'Awarded' ")->num_rows; ?><br>
    						    - Regular Guest: <?php echo mysqli_query($connection, "SELECT * FROM $registrationtable WHERE deleted = 0 AND awarded = 'Guest' ")->num_rows; ?><br>
    						</p>
    						<p>To export "all of the data", click this button:</p>
    						<div id='texportbtns' style='margin-bottom: 20px;'></div>
    						<?php
    						$sql = "SELECT * FROM $registrationtable WHERE deleted = 0 ORDER BY id DESC";
    						$result = mysqli_query($connection, $sql);
    						$resulttable = "<table id='apptable' style='width: 100%;'><tr><th>ID</th><th>DateReg.</th><th>Atten.</th><th>Title</th><th>Full Name</th><th>Organisation</th><th>Designation</th><th>Email</th><th>Type</th><th>Delete</th></tr>";
    						while($row = mysqli_fetch_assoc($result)){
    						    $style = "";
    						    
    						    if($row["attending"] == "no")
    						        $style = " style='color: red;'";
    						    else{
    						        if($row["awarded"] == "Awarded"){
    						            $style = " style='color: blue; font-weight: bold;'";
    						        }
    						    }
    						        
    						    $resulttable .= "<tr class='datarow' ".$style."><td>".$row["id"]."</td><td>".$row["datereg"]."</td><td>".$row["attending"]."</td><td>".$row["title"]."</td><td>".$row["fullname"]."</td><td>".$row["org"]."</td><td>".$row["des"]."</td><td>".$row["email"]."</td><td>".$row["awarded"]."</td><td>[<a href='". $baseurl . "?admin&delete=".$row["id"]."' style='color: red;'>DELETE</a>]</td></tr>";
    						}
    						$resulttable .= "</table>";
    						?>
    						<div style="width: 100%; overflow: auto;">
    						    <?php echo $resulttable; ?>
    						</div>
    						
    						
    						
    						<script>
    						    function showmode(n){
    						        if(n == 0){
    						            showall()
    						        }else{
    						            hideall();
        						        for(var i = 0; i < $(".datarow").length; i++){
        						            if(n == 1){
        						                if($(".datarow:eq("+i+")").find("td:eq(1)").text() == "yes")
        						                    $(".datarow:eq("+i+")").show()
        						            }else if(n == 2){
        						                if($(".datarow:eq("+i+")").find("td:eq(1)").text() == "no")
        						                    $(".datarow:eq("+i+")").show()
        						            }else if(n == 3){
        						                if($(".datarow:eq("+i+")").find("td:eq(7)").text() == "Awarded")
        						                    $(".datarow:eq("+i+")").show()
        						            }else if(n == 4){
        						                if($(".datarow:eq("+i+")").find("td:eq(7)").text() == "Guest")
        						                    $(".datarow:eq("+i+")").show()
        						            }
        						        }
    						        }
    						        
    						        inittableexport()
    						    }
    						    
    						    inittableexport()
    						    
    						    function hideall(){
    						        $(".datarow").hide();
    						    }
    						    
    						    function showall(){
    						        $(".datarow").show();
    						    }
    						    
    						    function inittableexport(){
    						        $("#texportbtns").html("");
    						        $("#apptable").tableExport(
                						{formats : ["xlsx"] }
                					);
                					// Detach the `buttons` html
                					var $buttons = $("#apptable").find('caption').children().detach();
                					// Append the buttons to an element of your choosing
                					$buttons.appendTo('#texportbtns');
    						    }
    						    
    						</script>
    						
    						<h3>Feedback Result</h3>
    						<?php
    						
    						$sql = "SELECT * FROM $feedbacktable ORDER BY id DESC";
    						$result = mysqli_query($connection, $sql);
    						$resulttable = "<table style='width: 100%;'><tr><th>Num</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>Q5</th><th>Q6</th><th>Q7</th><th>Q8</th><th>Q9</th><th>Name</th><th>Organisation</th><th>Designation</th><th>Contact</th><th>Email</th></tr>";
    						$num = 0;
    						while($row = mysqli_fetch_assoc($result)){
    						    $num+= 1;
    						    $resulttable .= "<tr><td>".$num."</td><td>".$row["fb1"]."</td><td>".$row["fb2"]."</td><td>".$row["fb3"]."</td><td>".$row["fb4"]."</td><td>".$row["fb5"]."</td><td>".$row["fb6"]."</td><td>".$row["fb7"]."</td><td>".$row["fb8"]."</td><td>".$row["fb9"]."</td><td>".$row["fb10"]."</td><td>".$row["fb11"]."</td><td>".$row["fb12"]."</td><td>".$row["fb13"]."</td><td>".$row["fb14"]."</td></tr>";
    						}
    						$resulttable .= "</table>";
    						
    						echo $resulttable;
    						
				        }else{
				            if(isset($_POST["username"])){
    				            if($_POST["username"] == $adminusername && $_POST["password"] == $adminpassword){
    				                $_SESSION["username"] = $_POST["username"];
    				                $_SESSION["password"] = $_POST["password"];
    				                ?>
            						<h1>Login Success</h1>
            						<p>Please wait...</p>
            						<script>
            						    setTimeout(function(){
            						        location.href="<?php echo $baseurl ?>?admin";
            						    }, 2000);
            						</script>
            						<?php
    				            }else{
    				                ?>
            						<h1>Access Denied</h1>
            						<p>Wrong Username and/or Password.</p>
            						<?php
    				            }
    				        }else{
    				            ?>
        						<h1>Administrator Login</h1>
        						<form method="post" id="appform">
        						    <div class="formblock">
        						        <label>Username</label><br>
        						        <input placeholder="Username" name="username">
        						    </div>
        						    <div class="formblock">
        						        <label>Password</label><br>
        						        <input placeholder="Password" type="Password" name="password">
        						    </div>
        						    <div class="formblock" style="padding-top: 20px;">
            							<button onclick="submitform()">SUBMIT</button>
            						</div>
        						</form>
        						<?php
    				        }
				        }
				    }else if(isset($_GET["feedback"])){
				        
				        if(isset($_POST["fb1"])){
				            $fb1 = mysqli_real_escape_string($connection, $_POST["fb1"]);
				            $fb2 = mysqli_real_escape_string($connection, $_POST["fb2"]);
				            $fb3 = mysqli_real_escape_string($connection, $_POST["fb3"]);
				            $fb4 = mysqli_real_escape_string($connection, $_POST["fb4"]);
				            $fb5 = mysqli_real_escape_string($connection, $_POST["fb5"]);
				            $fb6 = mysqli_real_escape_string($connection, $_POST["fb6"]);
				            $fb7 = mysqli_real_escape_string($connection, $_POST["fb7"]);
				            $fb8 = mysqli_real_escape_string($connection, $_POST["fb8"]);
				            $fb9 = mysqli_real_escape_string($connection, $_POST["fb9"]);
				            $fb10 = mysqli_real_escape_string($connection, $_POST["fb10"]);
				            $fb11 = mysqli_real_escape_string($connection, $_POST["fb11"]);
				            $fb12 = mysqli_real_escape_string($connection, $_POST["fb12"]);
				            $fb13 = mysqli_real_escape_string($connection, $_POST["fb13"]);
				            $fb14 = mysqli_real_escape_string($connection, $_POST["fb14"]);
				            
				            
				            
				            if(mysqli_query($connection, "SELECT * FROM feedback WHERE fb14 = '$fb14'")->num_rows > 0){
    						    ?>
        						<h1>Sorry</h1>
        						<p>This email address (<?php echo $fb14 ?>) is already used for submitting this form.</p>
        						
        						<?php
    						}else{
    						    
    						    $sql = "INSERT INTO $feedbacktable (fb1, fb2, fb3, fb4, fb5, fb6, fb7, fb8, fb9, fb10, fb11, fb12, fb13, fb14) VALUES ('$fb1', '$fb2', '$fb3', '$fb4', '$fb5', '$fb6', '$fb7', '$fb8', '$fb9', '$fb10', '$fb11', '$fb12', '$fb13', '$fb14')";
            						mysqli_query($connection, $sql);
				                echo "<p>Thank you for your feedback. </p>";
				                sendmail($fb14, "Thank you for your feedback", "<p>Thank you for your valuable feedback.</p>");
    						}
				            
				            
				        }else{
				            
				        
				        ?>
				        <h3>Feedback Form</h3>
				        <form method="post" id="feedbackform">
				        <p>1. Are you a Guest or Award Winner?</p>
				            <select name="fb1" class="fbformfield">
				                <option>Guest</option>
				                <option>Award Winner</option>
				            </select>
				        <p>2. How is the XYZ ? (1 Very Poor - 5 Excellent)</p>
				            <select name="fb2" class="fbformfield">
    				            <option>1</option>
    				            <option>2</option>
    				            <option>3</option>
    				            <option>4</option>
    				            <option selected>5</option>
				            </select>
				        
				        <p>3. How is the XYZ ? (1 Very Poor - 5 Excellent)</p>
				            <select name="fb3" class="fbformfield">
    				            <option>1</option>
    				            <option>2</option>
    				            <option>3</option>
    				            <option>4</option>
    				            <option selected>5</option>
				            </select>
				            
				        <p>4. How is the XYZ ?  (1 Very Poor - 5 Excellent)</p>
				            <select name="fb4" class="fbformfield">
    				            <option>1</option>
    				            <option>2</option>
    				            <option>3</option>
    				            <option>4</option>
    				            <option selected>5</option>
				            </select>
				        <p>5. How is the XYZ ? (1 Very Poor - 5 Excellent)</p>
				            <select name="fb5" class="fbformfield">
    				            <option>1</option>
    				            <option>2</option>
    				            <option>3</option>
    				            <option>4</option>
    				            <option selected>5</option>
				            </select>
				        <p>6. What do you think about XYZ ?</p>
				            <textarea name="fb6" class="fbformfield"></textarea>
				        <p>7. What do you think about XYZ ?</p>
				            <textarea name="fb7" class="fbformfield"></textarea>
				        <p>8. What do you think about XYZ ?</p>
				            <textarea name="fb8" class="fbformfield"></textarea>
				       <p>9. What do you think about XYZ ?</p>
				            <textarea name="fb9" class="fbformfield"></textarea>
				        
				        <p>Name:</p>
				        <input name="fb10" class="fbformfield">
				        <p>Organisation:</p>
				        <input name="fb11" class="fbformfield">
				        <p>Designation:</p>
				        <input name="fb12" class="fbformfield">
				        <p>Contact Number:</p>
				        <input name="fb13" class="fbformfield" type="number">
				        <p>Email Address:</p>
				        <input name="fb14" class="fbformfield" type="email" id="emailfield">
				        
				        <br>
				        <br>
				        
				        
				        </form>
				        
				        <button onclick="submitfeedbackform()">SUBMIT</button>
				        
				        <script>
				            function submitfeedbackform(){
				                var formcomplete = true;
				                for(var i = 0; i < $(".fbformfield").length; i++){
				                    if($(".fbformfield:eq("+i+")").val() == ""){
				                        formcomplete = false;
				                        console.log("Not complete on : " + i);
				                    }
				                        
				                }
				                
				                
				                if(formcomplete){
				                    var emailfield = $("#emailfield").val();
				                    if(emailfield.indexOf("@") > 0 && emailfield.indexOf(".") > 0 && emailfield.indexOf(" ") < 0)
                				        $("#feedbackform").submit();
                				    else
                				        alert("You did not enter the correct email address.");
				                }
                				else
                				    alert("All fields are required.");
                			}
                			
                			function onlynumberpls(){
                			    
                			}
				        </script>
				        <?php
				        }
				    }else{
				        if(!isset($_GET["logout"])){
				            if(isset($_POST["email"])){
				                $attending = mysqli_real_escape_string($connection, $_POST["attending"]);
        						$title = mysqli_real_escape_string($connection, $_POST["title"]);
        						$fullname = mysqli_real_escape_string($connection, $_POST["fullname"]);
        						$org = mysqli_real_escape_string($connection, $_POST["org"]);
        						$des = mysqli_real_escape_string($connection, $_POST["des"]);
        						$email = mysqli_real_escape_string($connection, $_POST["email"]);
        						$awarded = mysqli_real_escape_string($connection, $_POST["awarded"]);
        						
        						if(mysqli_query($connection, "SELECT * FROM $registrationtable WHERE email = '$email' AND deleted = 0")->num_rows > 0){
        						    ?>
            						<h1>Registration error</h1>
            						<p>This email address (<?php echo $email ?>) is already registered.</p>
            						
            						<?php
        						}else{
        						    date_default_timezone_set('Asia/Singapore');
        						    $datereg = date("Y-m-d H:i:s");
        						    $sql = "INSERT INTO $registrationtable (attending, datereg, title, fullname, org, des, email, awarded, deleted) VALUES ('$attending', '$datereg', '$title', '$fullname', '$org', '$des', '$email', '$awarded', 0)";
            						mysqli_query($connection, $sql);
            						
            						$emailcontent = "New guest is registered with this details:<br>Title: ".$title."<br>Full Name: ".$fullname."<br>Organisation: ".$org."<br>Designation: ".$des."<br>Email: ".$email;
            						sendmail($emailusername, "New Registration Alert", $emailcontent);
            						?>
            						<h1>Thank you.</h1>
            						<p>Your registration has been submitted successfully.</p>
            						<p>If you have any queries, feel free to email <a href="mailto:<?php echo $emailusername ?>"><?php echo $emailusername ?></a>.</p>
            						
            						<?php
            						$emailcontent = "<h1>Thank you.</h1> <p>Your registration has been submitted successfully.</p> <p>If you have any queries, feel free to email <a href='" .$emailusername. "'>" .$emailusername. "</a>.</p>";
            						sendmail($email, "Thank you for your registration", $emailcontent);
        						}
        					}else{
								
								if($registrationisopen){
									?>
									<form method="post" id="appform">
										<div class="formblock">
											<label>Will you be attending the event?</label><br>
											<select id="form-registering" name="attending">
												<option value="yes" selected="selected">Yes</option>
												<option value="no">No</option>
											</select>
										</div>
										<div class="formblock">
											<label>Title</label><br>
											<select id="form-title" name="title">
												<option value="Mr" selected="selected">Mr</option>
												<option value="Miss">Miss</option>				
												<option value="Mrs">Mrs</option>
												<option value="Mdm">Mdm</option>
												<option value="Dr">Dr</option>
											</select>
										</div>
										<div class="formblock">
											<label>Full Name</label><br>
											<input placeholder="Full Name" id="form-fullname" name="fullname">
										</div>
										<div class="formblock">
											<label>Organisation</label><br>
											<input placeholder="Organisation" id="form-org" name="org">
										</div>
										<div class="formblock">
											<label>Designation</label><br>
											<input placeholder="Designation" id="form-des" name="des">
										</div>
										<div class="formblock">
											<label>Email</label><br>
											<input placeholder="Email" name="email" type="email" id="form-email" name="email">
										</div>
										<?php 
										if(isset($_GET["congrat"])){
											?>
											<input value="Awarded" name="awarded" style="display: none;">
											<?php
										}else{
											?>
											<input value="Guest" name="awarded" style="display: none;">
											<?php
										}
										?>
									</form>
									<div class="formblock" style="padding-top: 20px;">
										<button onclick="submitregform()">SUBMIT</button>
									</div>
									
									
									<?php
								}
								else{
									echo "<h1>Registration is closed</h1><p>Thank you for visiting this page. Currently registration is closed.</p>";
								}
								
        					}
        					
				        }
				        
				    }
					
				?>
			</div>
		</div>
		<script>
			function submitform(){
				$("#appform").submit();
			}
			function submitregform(){
			    var title, fullname, org, des, email;
			    title = $("#form-title").val();
			    fullname = $("#form-title").val();
			    org = $("#form-org").val();
			    des = $("#form-des").val();
			    email = $("#form-email").val();
			    
		        if(title != "" && fullname != "" && org != "" && des != "" && email != ""){

                    if(email.indexOf("@") > 0 && email.indexOf(".") > 0 && email.indexOf(" ") < 0)
                        submitform();
                    else
                        alert("You did not provide a correct email address.");
                
			    }else{
			        alert("All fields are required.");
			    }
			    
			}
			
			
		</script>
	</body>
</html>