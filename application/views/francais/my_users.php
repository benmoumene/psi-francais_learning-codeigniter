<center>
    <div class="comment" style="margin:15px auto auto 20">
        <h1><?php echo ($show == 'professors') ? 'Les professeurs:' : 'Les étudiants:'?></h1>

        <ul style="list-style-type:none;text-align:left">
            <?php foreach($users as $user):?>
						<br/>
            <li>
                <a id="user" class='cours-frame' style="background-color:<?php echo ($show == 'professors') ? '#B0E57C' : '#587498';?>" data-user_id=<?php echo $user[ 'user_id'];?> href=<?php echo ($show == 'professors') ? site_url('student/show_professor') : site_url( "/student/show_student");?> >
							<?php echo $user['username']; ?>
						</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</center>

<script>
    $(document).ready(function() {
        $('.cours-frame').click(function() {
            $.ajax({
                type: "POST",
                url: "set_user_id",
                data: {
                    user_id: $(this).data('user_id')
                },
                dataType: "text",
                cache: false,
                // success: function(data) {
                //     alert(data); //as a debugging message.
                // }
            });
        });
    });
</script>
