<div style="position:absolute;right:140px;top:15px;">
	<input  id="showlogin" type=button class=log_in value="Log in">
	<ul id="login_yes" class="comment popup" style="display:none;position:absolute;">
		<form>
			<li>
				<input type="text" name="login_username" class=login placeholder="Username">
			</li>
			<li>
				<input type="password" name="login_password" class=login placeholder="Password" style="margin-top:8px;">
			</li>
			<li>
				<button type="submit" class="check" style="width:100%;padding:4px 0px;margin-top:10px;background: #96d600;border-color: #96d600;">Login</button>
			</li>
		</form>
	</ul>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>
	$(document).ready(function() {
			$('#showlogin').click(function() {
							$('.popup').slideToggle("fast");
			});
	});
</script>

