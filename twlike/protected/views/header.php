<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<title>Welcome</title>
<link href="<?php echo $this->uri->baseUri;?>statics/bootsrap/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo $this->uri->baseUri;?>statics/bootsrap/css/style.css" rel="stylesheet">
</head>
<body>

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="<?php echo $this->location();?>">Twlike</a>
            <div class="nav-collapse">
                <ul class="nav">
                    <li><a href="<?php echo $this->location('users');?>">Users</a></li>
                </ul>
            </div><!--/.nav-collapse -->
            
            
            <ul class="nav pull-right">
                <li class="dropdown">
                    
                    <?php if( $username = $this->session->getValue('username') ): ?>
                    
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $this->location($username);?>">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->location('signout');?>">Sign Out</a></li>
                    </ul>
                    
                    <?php else: ?>
                    
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sign In <b class="caret"></b></a>
                    <div class="dropdown-menu nav-signin" style="padding:10px;">
                        <form method="post" action="<?php echo $this->location('home?next='.$this->uri->getClass());?>">
                            <fieldset>
                                <label>Username:</label>
                            <input type="text" name="username">
                                <label>Password:</label>
                            <input type="password" name="password">
                            <input type="hidden" name="signature" value="<?php echo $signature;?>">
                            <input type="submit" class="btn btn-primary" name="submit" value="Sign In">
                            </fieldset>
                        </form>
                    </div>
                    
                    <?php endif; ?>
                </li>
            </ul>
            
        </div>
    </div>
</div>