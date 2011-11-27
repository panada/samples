<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<h3>Login</h3>
<form action="" method="post">
    <label for="username">Username:</label> <input type="text" name="username" id="username"> (admin)<br />
    <label for="password">Password:</label> <input type="password" name="password" id="password"> (admin)<br />
    <input type="submit" name="submit" id="submit" value="Login">
</form>
<?php if($errorMessage): ?>
    <p><?php echo $errorMessage; ?></p>
<?php endif; ?>
</body>
</html>