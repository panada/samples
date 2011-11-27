<!DOCTYPE html>
<html>
<head>
    <title>Welcome <?php echo $username;?></title>
</head>
<body>
<h3>Welcome, <?php echo $username;?></h3>
<p><a href="<?php echo $this->location('dashboard/logout');?>">Logout</a></p>
</body>
</html>