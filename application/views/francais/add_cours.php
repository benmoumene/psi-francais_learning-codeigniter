<center>
    <div class="comment" style="margin:15px auto auto 20">
        <center>
            <h1>Entrez les détails du cours:</h1>
            <br/>
            <?php echo form_open('admin/submit_cours'); ?>
            <textarea name="cours_descr" rows=20 cols=50 class=power-text><?php echo $cours_descr?></textarea>
            </br>
            <button class="check" type="submit" style="font-weight:normal">ajouter cours</button>
            </form>
        </center>
    </div>
</center>
