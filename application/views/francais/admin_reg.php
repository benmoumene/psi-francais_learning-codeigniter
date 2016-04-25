<center>
<?php echo validation_errors(); ?>
<?php 
	$attributes = array('class' => 'comment', 'style' => 'margin:auto 0;padding-right:80px;padding-left:80px;padding-top:30px;margin-top:20px');
	echo form_open('admin/add_admin',$attributes); 
?>
	<h1 style="margin-bottom:30px;font-size:23px;">Ajouter administrateur</h1>
	<input type="email" name="email" class="register-input" value="<?php echo set_value('email'); ?>" placeholder="Email">
	<input type="text" name="username" class="register-input" value="<?php echo set_value('username'); ?>" placeholder="Username">
	<input type="password" name="password" class="register-input" placeholder="Password">
	<input type="password" name="passconf" class="register-input" placeholder="Confirm Password">
	<input type="submit" value="Create Account" class="register-button">
</form>
</center>
