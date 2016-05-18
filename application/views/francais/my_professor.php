<center>
    <table border=0 cellspacing=2 class=comment style="margin:15px auto 20px auto">
        <tr>
            <th colspan=2>
                <h1>Informations sur <?php echo $username ?></h1></th>
        </tr>
        <tr>
            <td>Nom
            </td>
            <td>
                <?php if(isset($surname)) echo $surname; ?>
            </td>
        </tr>
        <tr>
            <td>Prenom:</td>
            <td>
                <?php if(isset($name)) echo $name; ?>
            </td>
        </tr>
        <tr>
            <td>
                <p>Ville:</p>
            </td>
            <td>
                <?php if(isset($city)) echo $city; ?>
            </td>
        </tr>
        <tr>
            <td>
                <p>Profession:</p>
            </td>
            <td>
                <?php if(isset($profession))  echo $profession; ?>
            </td>
        </tr>
        <tr>
            <td>Niveau:</td>
            <td>
                <?php echo $level; ?>
            </td>
        </tr>
    </table>
    </br>
    <?php if(isset($accepted) and $accepted):?>
			<?php echo form_open('chat/talk'); ?>
			<input type="submit" data-user_id=<?php echo $user_id; ?> value="aller discuter" class=send>
			</form>
    <?php elseif(isset($accepted) and !$accepted):?>
			<?php echo form_open('chat/talk'); ?>
			<input type="hidden" data-user_id=<?php echo $user_id; ?> value="aller discuter" class=send>
			</form>
			<p class=request-sent>requête envoyée</p>
    <?php else: ?>
			<?php echo form_open('chat/talk'); ?>
			<input type="hidden" data-user_id=<?php echo $user_id; ?> value="aller discuter" class=send>
			</form>
			<p class=request style="cursor:pointer" >envoyer une requête</p>
    <?php endif?>
</center>

<script>
    $(window).bind('beforeunload', function() {
        $.ajax({
            type: "POST",
            url: "set_user_id",
            data: {
                user_id: $('.send').data('user_id')
            },
            dataType: "text",
            cache: false,
            // success: function(data) {
            //     alert(data); //as a debugging message.
            // }
        });
        //prevent dialog -> undefined
        return undefined;
    });

    $(document).ready(function() {
        $('.request').click(function() {
            $.ajax({
                type: "POST",
                url: "send_request",
                data: {
									prof_id: $('.send').data('user_id')
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
