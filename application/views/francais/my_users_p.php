<div class="comment" style="margin:15px auto auto 20">
    <h1><?php echo ($show == 'students_req') ? 'étudiants requêtee' : 'etudiants'?></h1>

    <ul style="list-style-type:none">
        <?php foreach($users as $user):?>
        <li>
            <a id="user" data-user_id=<?php echo $user[ 'user_id'];?> href=<?php echo ($show == 'students_req') ? site_url('professor/show_student_requests') : site_url( "professor/show_student");?> >
							<?php echo $user['username']; ?>
						</a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

<script>
    $(document).ready(function() {
        $('#user').click(function() {
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
