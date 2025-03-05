<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
  <title>ISSUE PASSPORT</title>
  <meta name="description" content="free website template" />
  <meta name="keywords" content="enter your keywords here" />
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <script type="text/javascript" src="js/jquery.easing.min.js"></script>
  <script type="text/javascript" src="js/jquery.nivo.slider.pack.js"></script>
  <script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
  </script> 
</head>

<body>
  <div id="main">
	
	<div id="menubar">
	  <div id="welcome">
	    <h1><a href="#">FastPort Passport</a></h1>
	  </div><!--close welcome-->
      <div id="menu_items">
	    <ul id="menu">
          <li><a href="PAHome.html">Home</a></li>
		  <li><a href="ApplicationPValidate.php">Validate Application</a></li>
          <li class="current"><a href="IssuePassport.php">Issue Passport</a></li>
          <li><a href="Logout.html">Logout</a></li>
		</ul>
      </div><!--close menu-->
    </div><!--close menubar-->	
	
	<div id="site_content">	

	  <div id="banner_image">
	    <div id="slider-wrapper">        
          <div id="slider" class="nivoSlider">
            <img src="images/home_1.jpg" alt="" />
            <img src="images/home_2.jpg" alt="" />
		  </div><!--close slider-->
		</div><!--close slider_wrapper-->
	  </div><!--close banner_image-->	

	  <div class="sidebar_container">       
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>New Website</h2>
            <p>Welcome to our new website. Please have a look around, any feedback is much appreciated.</p>
          </div><!--close sidebar_item--> 
        </div><!--close sidebar-->     		
		<div class="sidebar">
          <div class="sidebar_item">
            <h2>Latest Update</h2>
            <h3>August 2016</h3>
            <p>Four ID proofs ( Aadhaar, PAN, EPIC, Affidavit in format of Annexure-I) can get you a passport in 7 days.</p>         
		  </div><!--close sidebar_item--> 
        </div><!--close sidebar-->
		  		
      </div><!--close sidebar_container-->		   
	   
      <div id="content">
        <div class="content_item">
		  <div class="form_settings">
		  <h1>Passport Issue Process</h1>
          <?php
			$con=mysqli_connect($_SERVER['DB_HOSTNAME'],$_SERVER['DB_USERNAME'],$_SERVER['DB_PASSWORD'],$_SERVER['DB_SCHEMA'],$_SERVER['PORT']);
			if(!$con)
			{
				die('Could not connect:' . mysql_error());
			}
			$Appno=$_POST['ApplicationNo'];
			$query="SELECT ApplicationNumber,Status FROM payment WHERE Status='Success' LIMIT 5;";
			$res=mysqli_query($con,$query);
			$count=0;
			
			while($row=mysqli_fetch_array($res,MYSQL_ASSOC))
			{
				$Dat=$row['ApplicationNumber'];
				if($Dat==$Appno)
				{
					$count=1;
					
				}
			}
			if($count==0||mysqli_num_rows($res)==0)
			{
				echo "<p>Invalid Application Number</p>";
				echo "<p>&nbsp;</p>";
				echo "<br>";
				echo '<a href="IssuePassportFirst.html"><b>Click here</b></a>';
				echo " to re-enter Application number.";
			}
			else
			{
				$query="UPDATE applicant SET Status='S' WHERE ApplicationNumber='$Appno';";
				if(mysqli_query($con,$query))
				{
					echo "<b>Updation done successfully.</b>";
					$query="SELECT * FROM applicant WHERE ApplicationNumber='".$Appno."';";
					$res=mysqli_query($con,$query);
					while($row=mysqli_fetch_array($res,MYSQL_ASSOC))
					{
						$Name=$row['Name'];
						$FatherName=$row['FatherName'];
						$DateofBirth=$row['DateOfBirth'];
						$PermanentAddress=$row['PermanentAddress'];
						$TemporaryAddress=$row['TemporaryAddress'];
						$EMailID=$row['EmailAddress'];
						$PhoneNo=$row['PhoneNumber'];
						$PANNO=$row['PanNumber'];
						$ApplicationNo=$row['ApplicationNumber'];
						$UserID=$row['UserId'];
						$Status=$row['Status'];
						$query = "INSERT INTO completed_applicants (Name,FatherName,DateOfBirth,PermanentAddress,TemporaryAddress,EmailAddress,PhoneNumber,PanNumber,ApplicationNumber,UserId,Status)VALUES ('$Name','$FatherName','$DateofBirth','$PermanentAddress','$TemporaryAddress','$EMailID','$PhoneNo','$PANNO','$ApplicationNo','$UserID','$Status')";
						if(mysqli_query($con,$query))
						{
							$query="DELETE FROM applicant WHERE ApplicationNumber='$Appno';";
							mysqli_query($con,$query);
							$query="DELETE FROM payment WHERE ApplicationNumber='$Appno';";
							mysqli_query($con,$query);
							$query="DELETE FROM login_details WHERE UserId='$UserID';";
							mysqli_query($con,$query);
						}
							
					}
				}
				else
				{
					echo "<p><b>Some problem occurred during the updation process. Please try again.</b></p> ";
				}
			}
			exit();
			mysqli_close($con);
			?>

          </div><!--close form_settings-->
		</div><!--close content_item-->
      </div><!--close content-->   

	  
  
    	
  
</body>
</html>
