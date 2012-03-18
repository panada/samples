<?php $this->output('header');?>

<div class="container">
    <div class="row">
        <div class="span6">
            <table class="table">
                <tbody>
                    <?php if($users): ?>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td class="span1">
                            <a href="<?php echo $this->location($user->username);?>">
                            <img src="<?php echo $this->uri->baseUri;?>statics/images/avatar-small.png" alt="">
                            </a>
                        </td>
                        <td>
                            <h4><a href="<?php echo $this->location($user->username);?>"><?php echo $user->username;?></a></h4>
                            <p>@<?php echo $user->username;?></p>
                            <p>This is description of <?php echo $user->username;?>'s porifle.</p>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        
        <div class="span3 well">
            <h3>All Activities:</h3>
            <ul>
                <li><?php echo $totalPost;?> Posts</li>
                <li><?php echo $totalUser;?> Users</li>
            </ul>
        </div>
    </div>

<?php $this->output('footer');?>