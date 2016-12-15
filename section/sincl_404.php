<?php
/**
 * Created by IntelliJ IDEA.
 * User: mcardenas
 * Date: 18/06/16
 * Time: 16:05
 */
?>
<section>
    <!-- Body Main -->
    <div id="headerwrap">
        <div class="container">
            <div class="row">
                <h1></h1>
            </div>
            <div class="row">
                <h1></h1>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 himg">
                    <img src="img/FoTRRIs_Logo.jpg" class="img-responsive">
                </div>
                <div class="col-lg-8 col-lg-offset-2">
                    <h3><?php echo _("Welcome to the Project"); ?> FoTRRIS</h3>
                    <h1><?php echo _("Web Platform"); ?></h1>
                    <h5><?php echo _("Responsible Research and Innovation (RRI)"); ?></h5>
                    <h5>H2020 <?php echo _("Project"); ?></h5>
                    <?php if (!login_check($mysqli) == true) { ?>
                    <a href="login.php" ><?php echo _("Please Login"); ?> </a>
                    <?php } ?>
                </div>
            </div><!-- /row -->
        </div> <!-- /container -->
    </div><!-- /headerwrap -->
</section>
