<!DOCTYPE html>
<html>
    <head>
  	    <meta charset="utf-8"/>
  	    <link href="css/form.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
    	<div class="welcome">Welcome to e-swap</div>
    	<div class="info">Please sign up to continue</div>
    	<div class="form_style">
        	<form class="form_style" action="sign_up.php" method="post">
        	<label for="Login">Login:</label><input name="s_u_login" type="text" required="required"/><br />
			<label for="Password">Password:</label><input name="s_u_password" type="password" required="required"/><br />
    		<label for="Repeat pswd">Repeat pswd:</label><input name="s_u_password_repeat" type="password" required="required"/><br />
    		<label for="Nickname">Nickname:</label><input name="s_u_nickname" type="text" required="required"/><br />
    		<label for="E-mail">E-mail:</label><input name="s_u_email" type="text" required="required"/><br />
    		<label for="Phone">Phone:</label><input name="s_u_phone" type="text" required="required"/><br />
    		<label for="Address">City of residence:</label><input name="s_u_addr" type="text" required="required"/><br />    		
    	<div class="submit">
			<input class="button" type="submit" value="Sign-up" />
		</div>
        </form>
        </div>
    </body>
</html>