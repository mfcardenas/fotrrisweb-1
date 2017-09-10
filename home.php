<?php
    require_once 'includes/translate.php';
    require_once 'includes/functions.php';
    require_once 'includes/combo.php';


    sec_session_start();

    $elementHtml = null;
    $id_project = "";

?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Web Platform FoTRRIS project">
        <meta name="author" content="">
        <link rel="shortcut icon" href="img/favicon.png">
	    <title><?php echo _("Project"); ?> FoTRRIS</title>
        <?php include("section/sincl_html.php"); ?>

        <!-- Tabs -->
        <?php
        if (login_check($mysqli) == true) {
            if (isset($_GET["id_project"]))  {
                $id_project = htmlspecialchars($_GET["id_project"]);
                if ($id_project != null && $id_project != "") {
                    $elementHtml = getPadHtmlUserProject($mysqli, $id_project);
                }
            }

        }
        ?>
        <script>
            $(document).ready(function() {
                $('.nav-tabs > li > a').click(function(event){
                    event.preventDefault();//stop browser to take action for clicked anchor

                    //get displaying tab content jQuery selector
                    var active_tab_selector = $('.nav-tabs > li.active > a').attr('href');

                    //find actived navigation and remove 'active' css
                    var actived_nav = $('.nav-tabs > li.active');
                    actived_nav.removeClass('active');

                    //add 'active' css into clicked navigation
                    $(this).parents('li').addClass('active');

                    //hide displaying tab content
                    $(active_tab_selector).removeClass('active');
                    $(active_tab_selector).addClass('hide');

                    //show target tab content
                    var target_tab_selector = $(this).attr('href');
                    $(target_tab_selector).removeClass('hide');
                    $(target_tab_selector).addClass('active');
                });

                <?php
                if (login_check($mysqli) == true) {
                    if ($elementHtml != null) {
                        foreach ($elementHtml[0] as $obj) {
                            foreach ($obj as $s_obj) {
                                print_r($s_obj);
                                echo "\n";
                            }
                        }
                    }
                }
                ?>

            });
        </script>
        
    </head>

    <body>

        <header>
            <?php include("section/sincl_header.php"); ?>
        </header>
        <!-- validate sesion is live ? -->
        <?php if (login_check($mysqli) == true && $id_project != null && $id_project != '') : ?>
            <!-- Body Main -->
            <div id="headerwrap-pads">
                <div class="container mtb">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <h3><?php echo _("Welcome to the Project"); ?> FoTRRIS</h3>
                            <p><label >
                                    <?php echo _("Working on"); ?>:&nbsp;
                                    <!--select id="id_project" name="id_project"-->
                                    <?php
                                        echo getDescProject($mysqli, $id_project);
                                    ?>
                                    <!--/select-->
                                </label>
                            </p>
                        </div>
                    </div><!-- /row -->
                </div> <!-- /container -->
            </div><!-- /headerwrap -->

            <!-- Tabs -->
            <div>
                <ul class="nav nav-tabs">
                    <?php
                    if ($elementHtml != null) {
                        foreach ($elementHtml[1] as $obj) {
                            foreach ($obj as $s_obj) {
                                print_r($s_obj);
                                echo "\n";
                            }
                        }
                    }
                    ?>
                </ul>
            </div>
            <?php
            if ($elementHtml != null) {
                foreach ($elementHtml[2] as $obj) {
                    foreach ($obj as $s_obj) {
                        print_r($s_obj);
                        echo "\n";
                    }
                }
            }
            ?>
            <script>
                var id_project_ = $("#id_project").val();
            </script>

        <?php else : ?>
            <?php include("section/sincl_404.php"); ?>
        <?php endif; ?>
        <footer>
            <?php include("section/sincl_footer.php"); ?>
        </footer>
    </body>
</html>
    
