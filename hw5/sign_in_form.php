<html>
  <head>
    <title>2DO</title>
    <meta charset="utf-8" />
    <link href="css/main.css" type="text/css" rel="stylesheet" />
    <link href="css/form.css" type="text/css" rel="stylesheet" />
  </head>

<body>
	
	<div id="top_banner">
		<form method="post" action="home.php">
			<div>
				<span class="left">Welcome to <span id="logo">2DO</span> your personal todo-lists manager!</span>
			</div>
			<div class="right">
				<input class="button" type="submit" value="Sign-up" title="Sign-up"/>
			</div>
		</form>
	</div>
	
	<div class="form_style">
 
		<form class="form_style" method="post" action="sign_in.php">
	
			<div>Sign in to continue to 2DO</div>
	
			<label for="login">Login</label><input name="login" type="text" required="required"/><br />
			<label for="password">Password</label><input name="password" type="password" required="required"/><br />	
		
			<div class="submit">
				<input class="button" type="submit" value="Sign in" />
			</div>
	
		</form>

	</div>

</body>
</html>