<?php $tdu =  get_template_directory_uri(); ?>
</div><!-- allbutfooter closing -->
<!-- footer -->
<footer id="footer" class="footer" role="contentinfo">
    <div class="container">
        <div class="row">
            <p style="line-height:55px" class="col-sm-4">&copy; <?php echo date('Y'); ?>  | <a href="https://webfactor.ch">Website by Webfactor</a></p>

            <ul class="col-sm-8" id="partners">
                <li><a><img src="<?php echo $tdu; ?>/img/artistiqua.png"  alt="logo" />artistiqua</a></li>
                <li><a><img src="<?php echo $tdu; ?>/img/cegmwhite.png"  alt="logo" />CEGM</a></li>
                <li><a><img src="<?php echo $tdu; ?>/img/geneve.png"  alt="logo" />avec le soutien de la République et canton de Genève</a></li>
            </ul>
        </div>
    </div>
</footer>
<!-- /footer -->

<?php wp_footer(); ?>

<script type="text/javascript" src="<?php echo $tdu; ?>/js/underscore.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="//maps.google.com/maps/api/js?key=AIzaSyAXUQ-XwYU2zw4L1HDhFQzjXKv8CRY7dYk"></script>
<script type="text/javascript" src="<?php echo $tdu; ?>/js/lib/modernizr-2.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $tdu; ?>/js/unslider-min.js"></script>
<script type="text/javascript" src="<?php echo $tdu; ?>/js/matchHeight.min.js"></script>
<script type="text/javascript" src="<?php echo $tdu; ?>/js/featherlight.min.js"></script>
<script type="text/javascript" src="<?php echo $tdu; ?>/js/scripts.js?v=3.1"></script>

<!-- analytics -->
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

ga('create', 'UA-96353592-1', 'auto');
ga('send', 'pageview');

</script>
<div id="bg"></div>
</body>
</html>
