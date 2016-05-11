<center>
    <div class="comment" style="margin:15px auto auto 20;text-align:left;">
        <?php $last_level = 0; foreach($courses as $cours):
if($cours['level']!=$last_level):?>
        </ul>
        <h2 class=cours-frame style="font-size:120%;background-color:#ffcc00;">Niveau: <?php echo $cours['level']; ?></h2>
        <ul style="list-style-type:none">
            </br>
            <?php endif; ?>
            <li>
                <div style="float:left;margin-top:1px;margin-right:3px" />
                <img src="<?php echo base_url();?>assets/images/eye_true.png" height=20 width=20 class=eye style="cursor:pointer" data-cours_id="<?php echo $cours['cours_id'];?>">
                <img src="<?php echo base_url();?>assets/images/cross_wtf.png" height=20 width=20 class="cross" style="cursor:pointer;" data-cours_id="<?php echo $cours['cours_id'];?>">
    </div>
    <a class=cours-frame data-cours_id="<?php echo $cours['cours_id'];?>" style="<?php if(!$cours['visible']) echo 'background-color:#cccccc;'?>" href=<?php echo site_url( "/admin/add_cours/"); ?> >
			<?php echo $cours['name']; ?>
		</a>
    </li>
    </br>
    <?php $last_level = $cours['level'];
endforeach; ?>
    </div>
</center>

<script>
    $(document).ready(function() {
        $('.cours-frame').click(function() {
            $.ajax({
                type: "POST",
                url: "set_cours_id",
                data: {
                    cours_id: $(this).data('cours_id')
                },
                dataType: "text",
                cache: false,
                // success: function(data) {
                //     alert(data); //as a debugging message.
                // }
            });
        });

        $('.cross').click(function() {
            $.ajax({
                type: "POST",
                url: "delete_cours",
                data: {
                    cours_id: $(this).data('cours_id')
                },
                dataType: "text",
                cache: false,
                success: function() {
                    location.reload();
                }
            });
        });

        $('.eye').click(function() {
            $.ajax({
                type: "POST",
                url: "visible_cours",
                data: {
                    cours_id: $(this).data('cours_id')
                },
                dataType: "text",
                cache: false,
                success: function() {
                    location.reload();
                }
            });
        });
    });
</script>
