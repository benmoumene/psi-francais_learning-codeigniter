<center>
    <div class=comment style="white-space:nowrap;margin:15px auto 20px auto;text-align:left;">
        <center>
            <h1><?php echo $name; ?></h1>
            <br/>
        </center>
				<?php echo form_open('student/check_cours'); ?>
        <?php echo $data; ?>
        <br/>
				<center>
				<button class="check" type="submit" style="font-weight:normal">vérifier cours</button>
				</center>
				</form>
    </div>
</center>
