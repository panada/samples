<hr>
    <footer>
    <p>&copy; Twlike <?php echo date('Y');?></p>
    </footer>

<script type="text/javascript" src="<?php echo $this->uri->baseUri;?>statics/jquery-1.7.1.js"></script>
<script type="text/javascript" src="<?php echo $this->uri->baseUri;?>statics/bootsrap/js/bootstrap.js"></script>
<script type="text/javascript">
$(function(){
    $('.dropdown-toggle').dropdown();
    $('.nav-signin').click(function(e){
        e.stopPropagation();
    });
});
</script>
</div> <!-- /container -->
</body>
</html>