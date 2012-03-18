<?php $this->output('header');?>

<div class="container">
    <div class="row">
        <div class="well span6">
        <div class="row head-profile">
            <div class="span2 thumbnail">
                <img src="<?php echo $this->uri->baseUri;?>statics/images/avatar-large.png">
            </div>
            <div class="span3">
                <h2><?php echo $user->username;?></h2>
                @<?php echo $user->username;?>
                <p>This is description of user porifle.</p>
            </div>
            
            <?php if( ! $isOwner ): ?>
            <div class="follow-btn">
                <form action="" method="post">
                    <?php if( $isFollower ): ?>
                    <input type="submit" class="btn btn-primary" name="unfollow" value="Unfollow <?php echo $user->username;?>">
                    <?php else: ?>
                    <input type="submit" class="btn btn-primary" name="follow" value="Follow <?php echo $user->username;?>">
                    <?php endif; ?>
                </form>
            </div>
            <?php endif; ?>
            
        </div>
            
        <table class="table">
            <tbody>
                <?php if($posts):?>
                <?php foreach($posts as $post): ?>
                <tr>
                    <td class="span1">
                        <a href="#">
                            <img src="http://localhost/project/panada/git/samples/twlike/statics/images/avatar-small.png" alt="">
                        </a>
                    </td>
                    <td>
                        <h4><a href="<?php echo $this->location($user->username);?>"><?php echo $user->username;?></a></h4>
                        <p><?php echo $post->post;?></p>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr><td>No post yet!</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
        
        
        <div class="span3 well">
            <h3>Activities:</h3>
            <ul>
                <li><?php echo $totalPosts;?> Posts</li>
                <li><?php echo $totalFollower;?> Follower</li>
                <li><?php echo $totalFollowing;?> Following</li>
            </ul>
        </div>
        
        <?php if($following): ?>
        <div class="span3 well">
            <h4>Following:</h4>
            <table class="table">
                <tbody>
                    <?php foreach($following as $user): ?>
                    <tr>
                        <td class="span1">
                            <a href="<?php echo $this->location($user->username);?>">
                                <img src="http://localhost/project/panada/git/samples/twlike/statics/images/avatar-small.png" alt="">
                            </a>
                        </td>
                        <td>
                            <h4><a href="<?php echo $this->location($user->username);?>"><?php echo $user->username;?></a></h4>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
        <?php if($follower): ?>
        <div class="span3 well">
            <h4>Follower:</h4>
            
            <table class="table">
                <tbody>
                    <?php foreach($follower as $user): ?>
                    <tr>
                        <td class="span1">
                            <a href="<?php echo $this->location($user->username);?>">
                                <img src="http://localhost/project/panada/git/samples/twlike/statics/images/avatar-small.png" alt="">
                            </a>
                        </td>
                        <td>
                            <h4><a href="<?php echo $this->location($user->username);?>"><?php echo $user->username;?></a></h4>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        
    </div>

<?php $this->output('footer');?>