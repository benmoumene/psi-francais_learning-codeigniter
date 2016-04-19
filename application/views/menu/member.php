<div style="position:absolute;right:300px;top:20px;">
	<img src="<?php echo base_url();?>assets/images/<?php echo $user;?>.png" height=30 width=30>
</div>
<div style="position:absolute;right:170px;top:25px;">
	<p id = "show_opt" style="font-size:15px;font-family:museo-sans-rounded, sans-serif;color:white;text-decoration:none;cursor:pointer"><?php echo "$username $level";?></p>
	<ul id="login_yes" class="comment popup" style="display:none;position:absolute;width:100px">
		<li>
			<a href="<?php echo site_url($user.'/logout') ?>">Logout</a>
		</li>
	</ul>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>
	$(document).ready(function() {
			$('#show_opt').click(function() {
							$('.popup').slideToggle("fast");
			});
	});
</script>
