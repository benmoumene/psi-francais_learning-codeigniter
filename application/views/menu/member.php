<div style="position:absolute;right:250px;top:20px;">
    <img src="<?php echo base_url();?>assets/images/<?php echo $user;?>.png" height=30 width=30>
    <p id="show_opt" style="font-size:15px;font-family:museo-sans-rounded, sans-serif;color:white;text-decoration:none;cursor:pointer;float:right;margin-left:5px;margin-top:4px;">
        <?php echo "$my_username"; if(isset($my_level)) echo " Niveau: ".$my_level;?>
    </p>
    <ul id="login_yes" class="comment popup" style="display:none;position:absolute;width:100px">
        <li>
            <a style="text-decoration:none" href="<?php echo site_url($user.'/logout') ?>">Logout</a>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function() {
        $('#show_opt').click(function() {
            $('.popup').slideToggle("fast");
        });
    });
</script>
