<center>
    <div class="comment" style="margin:15px auto auto 20">
        <center>
            <h1>Entrer du texte:</h1>
            <br/>
            <?php echo form_open('admin/submit_text'); ?>
            <textarea name="my_text" rows=20 cols=50 class=power-text><?php echo $text?></textarea>
            </br>
            <button class="check" type="submit" style="font-weight:normal">ajouter text</button>
            </form>
        </center>
    </div>
</center>
