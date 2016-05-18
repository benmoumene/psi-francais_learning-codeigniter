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
				<button class="check" data-cours_id=<?php echo $cours_id;?> type="submit" style="font-weight:normal">vérifier cours</button>
				</center>
				</form>
    </div>
</center>

<script>
		//this isn't necessary, beforeunload does the job
    // $(document).ready(function() {
    //     $('.check').click(function() {
    //         $.ajax({
    //             type: "POST",
    //             url: "set_cours_id",
    //             data: {
    //                 cours_id: $(this).data('cours_id')
    //             },
    //             dataType: "text",
    //             cache: false,
    //             success: function(data) {
		// 							alert("Oui, c'est ca. Deux!"); //as a debugging message.
    //             }
    //         });
    //     });
    // });

		$(window).bind('beforeunload',function(){
				$.ajax({
						type: "POST",
						url: "set_cours_id",
						data: {
								cours_id: $('.check').data('cours_id')
						},
						dataType: "text",
						cache: false,
						// success: function(data) {
						//     alert("Oui, c'est ca"); //as a debugging message.
						// }
				});
				//returns undefined 'cause there is no dialog
				return undefined;
		});
</script>
