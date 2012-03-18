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
            
            <?php if( $username = $this->session->getValue('username') ): ?>
            <ul class="nav pull-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $username;?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $this->location($username);?>">Profile</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo $this->location('signout');?>">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
            <?php endif; ?>
            
        </div>
    </div>
</div>