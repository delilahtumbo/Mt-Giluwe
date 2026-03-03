<!DOCTYPE html>
<html>
<head>
	<title>login form</title>
	<meta http-equiv="content-type" content="text/html"; charset="UTF-8">
	<meta name="viewport" content="width=device, inital-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/form.css">
	<script type="text/javascript" src="js/form.js"></script>
	
</head>
<body>
	<div class="button-area">
        <a href="../index.html" src="" >BACK</a>
    </div>
		
	<form id='userForm' action="loginForm.php" method="post">
		<h1>Login Form</h1>
		<p>Please enter your username and password</p>	
        
		<label for='username'>Username:</label>
		<input type="text" id="username" name="username"/><br>

		<label for='pwd'>Password:</label>
        <input type="password" id="password" name="password"/>
        
		<button type="reset" id="reset">Reset</button>
		<button id="submit" href="../home.html" onclick="submitForm()">Submit</button>	
		<br><br>

		<div class="no_acc">
			<h3>Don't have a account</h3>
			<button id="register" herf="../Assignment1 Giluwe Website/Registration/register.html">Sign Up</button>
		</div>
		
	</form>   

</body> 
</html>

 