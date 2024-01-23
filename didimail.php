<?php 
if(isset($_POST['submit'])){
    $to = $_POST['fake']; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $subject = $_POST['subject'];
    $message =  $_POST['message'];
    
    $tmp_name = $_FILES['file']['tmp_name']; // get the temporary file name of the file on the server
    $name     = $_FILES['file']['name']; // get the name of the file
    $size     = $_FILES['file']['size']; // get size of the file for size validation
    $type     = $_FILES['file']['type']; // get type of the file
    $error     = $_FILES['file']['error']; // get the error (if any)
 
    //validate form field for attaching the file
    if($error > 0)
    {
        die('Upload error or No files uploaded');
    }
 
    //read from the uploaded file & base64_encode content
    $handle = fopen($tmp_name, "r"); // set the file handle only for reading the file
    $content = fread($handle, $size); // reading the file
    fclose($handle);                 // close upon completion
 
    $encoded_content = chunk_split(base64_encode($content));
    $boundary = md5("random"); // define boundary with a md5 hashed value
 
    //header
    $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
    $headers .= "From:".$from."\r\n"; // Sender Email
    $headers .= "Reply-To: ".$to."\r\n"; // Email address to reach back
    $headers .= "Content-Type: multipart/mixed;"; // Defining Content-Type
    $headers .= "boundary = $boundary\r\n"; //Defining the Boundary
         
    //plain text
    $body = "--$boundary\r\n";
    
    $body .= "Content-Type: text/plain; charset=ISO-8859-1\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($message));
         
    //attachment
    $body .= "--$boundary\r\n";
    $body .="Content-Type: $type; name=".$name."\r\n";
    $body .="Content-Disposition: attachment; filename=".$name."\r\n";
    $body .="Content-Transfer-Encoding: base64\r\n";
    $body .="X-Attachment-Id: ".rand(1000, 99999)."\r\n\r\n";
    $body .= $encoded_content; // Attaching the encoded file with email
     
    $sentMailResult = mail($to, $subject,$body, $headers);
 
    if($sentMailResult ){
        echo "<center><h4>EMAIL Sent Successfully<h4></center>";
        // unlink($name); // delete the file after attachment sent.
    }
    else{
        echo "<center><h4>ERROR SENDING EMAIL TO VICTIM<h4></center>";
    }
    //mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    
    //header('Location: index.php'); 
    
    
    }
?>

<!DOCTYPE html>
 <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Didi Fake Mail</title>
     <link rel="SHORTCUT ICON" href="https://i.ibb.co/hs36Vqq/logo.png" type="image/x-icon"/>
    
<meta property="og:type" content="website">
<meta property="og:title" content="Didi Fake Mail">
<meta property="og:description" content="Anarchist Allies Malaysia">
<meta property="og:image" content="">
<meta property="og:site_name" content="Anarchist Allies Malaysia" />
<link rel=stylesheet href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
<link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
<style>


@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900');

body{
       background-image: url('https://mobimg.b-cdn.net/v3/fetch/04/04d09c31a1f97c6e2ba522ba0d4ddeaa.jpeg');
       background-repeat: no-repeat;
       background-size: cover;
	font-family: 'Poppins', sans-serif;
	font-weight: 300;
	font-size: 15px;
	line-height: 1.7;
	color: #c4c3ca;
	background-color: black;
	overflow-x: hidden;
}
h4{
    text-transform:uppercase;
    font-size:.6rem;
}
.btn{
    margin-top: 1rem;
    display: inline-block;
    font-size:1rem;
    color:#fff;
    background: transparent;
    cursor: pointer;
    border:0px;
    background-color:black;
    text-transform:uppercase;
}
.btn:hover{
    letter-spacing: .2rem;
}
.title{
    text-transform:uppercase;
}
.form input[type=text]{
    width:20rem;
    height:1.8rem;
    font-size:1rem;
}
.form input[type=email]{
    width:20rem;
    height:1.8rem;
    font-size:1rem;
}
.form textarea{
    width:20rem;
}
.image{
    padding-top:1rem;
    padding-bottom:0rem;
}
.image .logo{
    width:6rem;
    height:6rem;
    
}

</style>
<body>
<center>
    <div class="image">
    <img class="logo" src="https://i.ibb.co/hs36Vqq/logo.png">
    </div>
    <h1 class="title"> Didi Fake EMail</h1><hr>
    <div class="form">
<form enctype="multipart/form-data"  action="" method="post">
Your Fakemail <br><input type="email" name="email"><br>
victim email<br> <input type="email" name="fake"><br>
subject<br> <input type="text" name="subject"><br>
Message<br><textarea rows="5" name="message" cols="30"></textarea><br>
 <input class="" type="file" name="file" placeholder="Attachment"/>
<input type="submit" name="submit" value="send" class="btn">
</form>
</center>
</div>
	
</body>
</html> 
