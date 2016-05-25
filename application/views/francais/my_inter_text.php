<script src="<?php echo base_url().'assets';?>/js/jquery.magnific-popup.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url().'assets';?>/css/magnific-popup.css?<?php echo time();?>">

<center>
    <div class="comment" style="margin:15px auto auto 20;max-width:500px;">
        <h1>Le texte interactive:</h1>
        <br/>
        <div class=inter-text>
            <?php foreach($words as $word):
						echo "<p>$word </p>";
					endforeach; ?>
        </div>
    </div>
</center>

<script>
    $(document).ready(function() {
        $('div.inter-text p').click(function() {
            $.ajax({
                type: "POST",
                url: "check_word",
                data: {
                    word: $(this).text()
                },
                dataType: "text",
                cache: false,
                success: function(data) {
                    var element = '<div id="small-dialog" class="zoom-anim-dialog"><h1>Dictionnaire francais-anglais</h1>' + data + '</div>';
                    $.magnificPopup.open({
                        items: {
                            src: element,
                        },
                        type: 'inline',
                        fixedContentPos: false,
                        fixedBgPos: true,

                        overflowY: 'auto',

                        closeBtnInside: true,
                        preloader: false,

                        midClick: true,
                        removalDelay: 300,
                        mainClass: 'my-mfp-zoom-in'
                    });
                }
            });
        });
    });
</script>
