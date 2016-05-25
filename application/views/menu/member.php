	<div style="position:absolute;right:250px;top:50%;transform:translateY(-50%);">
			<img src="<?php echo base_url();?>assets/images/<?php echo $my_user;?>.png" height=35 width=35>
			<p id="show_opt" style="font-size:15px;font-family:museo-sans-rounded,sans-serif;color:white;text-decoration:none;cursor:pointer;float:right;margin-left:5px;margin-top:7px;">
					<?php echo "$my_username"; if(isset($my_level)) echo " Niveau: ".$my_level;?>
			</p>
			<ul id="login_yes" class="comment popup" style="display:none;position:absolute;width:100px;top:43px;padding:15px;text-align:center;">
					<li>
							<a style="text-decoration:none" href="<?php echo site_url($my_user.'/logout') ?>">Logout</a>
					</li>
			</ul>
	</div>
</div>

<script>
    $(document).ready(function() {
        $('#show_opt').click(function() {
            $('.popup').slideToggle("fast");
        });
    });
</script>
