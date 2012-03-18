<?php $this->output('header');?>

<div class="container">
    <div class="row">
        <div class="well span6">
            <form class="form-horizontal" action="" method="post">
                <fieldset>
                    <legend>What's in your mind?</legend>
                    <div class="control-group">
                    <textarea class="input-xlarge" id="textarea" name="post" rows="3" placeholder="Write your post..."></textarea>
                    </div>
                    <div class="control-group submit-post">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </fieldset>
            </form>
            
            <?php if($timeline): ?>
            
            <table class="table">
                <tbody>
                    <?php foreach($timeline as $post): ?>
                    <tr>
                        <td class="span1">
                            <a href="<?php echo $this->location($post->username);?>">
                                <img src="<?php echo $this->uri->baseUri;?>statics/images/avatar-small.png" alt="<?php echo $post->username;?>">
                            </a>
                        </td>
                        <td>
                            <h4><a href="<?php echo $this->location($post->username);?>"><?php echo $post->username;?></a></h4>
                            <p><?php echo $post->post;?></p>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
            
            <?php else: ?>
                <p>No post yet!</p>
            <?php endif;?>
            

            
        </div>
        
        
        <div class="span3 well">
            <h3>Your activities:</h3>
            <ul>
                <li><?php echo $posts;?> Posts</li>
                <li><?php echo $follower;?> Follower</li>
                <li><?php echo $following;?> Following</li>
            </ul>
        </div>
    </div>

<?php $this->output('footer');?>