<center>
    <?php echo validation_errors(); ?>
    <?php 
	$attributes = array('class' => 'comment', 'style' => 'margin:auto 0;padding-right:80px;padding-left:80px;padding-top:30px;margin-top:20px');
	if($my_user == 'student'):
		echo form_open('student/set_info',$attributes); 
	else:
		echo form_open('professor/set_info',$attributes); 
	endif;
?>
    <h1 style="margin-bottom:30px;font-size:23px;">Ajouter des informations</h1>
    <input type="text" name="surname" class="register-input" placeholder="Nom">
    <input type="text" name="name" class="register-input" placeholder="Prenom">
    <input type="text" name="city" class="register-input" placeholder="Ville">
    <input type="text" name="profession" class="register-input" placeholder="Profession">
    <input type="submit" value="Infos ensemble" class="register-button">
    </form>
</center>
