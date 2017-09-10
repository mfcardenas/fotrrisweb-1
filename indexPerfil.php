<?php

    require_once 'includes/functions.php';

    sec_session_start();

    if (login_check($mysqli) == true) {
        $logged = 'in';
    } else {
        $logged = 'out';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>FoTRRIS Profile </title>
        <?php include("section/sincl_html.php"); ?>
        <link rel="stylesheet" href="css/util.css" />
    </head>
    <body>
        
        <header>
            <?php include("section/sincl_header.php"); ?>
        </header>
        
        <?php if (login_check($mysqli) == true) : ?>
            <div id="bar_top">
                <div class="container">
                    <div class="row">
                        <h1></h1>
                    </div>
                    <div class="row">
                        <h1><small><?php echo _("list"); ?></small> <?php echo _("Profiles"); ?></h1>
                    </div>
                </div>
            </div>
            <section>
                <div id="headerwrap-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <script type="text/javascript">
                                    $(function() {
                                        $('#table-perfiles').dynatable({
                                            features: {
                                                pushState: true
                                            },
                                            readers: {
                                                /*'project': function(el, record) {
                                                 return Number(el.innerHTML) || 0;
                                                 }, */
                                                'number': function (el, record) {
                                                    return Number(el.innerHTML.replace(/,/g, ''));
                                                }
                                            },
                                            writers: {
                                                /*'project': function(record) {
                                                 return record['project'] ? record['project'].toString() : '-';
                                                 }, */
                                                'number': function (record) {
                                                    return record['number'].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                                }
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                if (isset($_GET['key'])) {
                                    echo getNotification($_GET['key'], $_GET['type'] );
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dynatable-demo">
                                    <table id="table-perfiles" class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="dynatable-head" data-dynatable-column="name">
                                                <?php echo _("Name"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="type">
                                                <?php echo _("Type"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="create">
                                                <?php echo _("Created"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="user_create">
                                                <?php echo _("Created By"); ?>
                                            </th>
                                            <th class="dynatable-head" style="text-align: center;" data-dynatable-column="status">
                                                <?php echo _("Status"); ?>
                                            </th>
                                            <th class="dynatable-head" style="text-align: center;" data-dynatable-column="actions">
                                                <?php echo _("Actions"); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($allperfil as $perfil) {?>
                                            <tr>
                                                <td style='text-align: left;'><?php echo $perfil->getName(); ?></td>
                                                <td style='text-align: left;'><?php echo $perfil->getType(); ?></td>
                                                <td style='text-align: left;'>
                                                    <?php echo date(FORMAT_DATE, strtotime($perfil->getDateCreate())); ?>
                                                </td>
                                                <td style='text-align: left;'><?php echo $perfil->getUserCreate(); ?></td>
                                                <td style='text-align: left;'>
                                                    <select name="snactive" id="snactive" disabled>
                                                        <?php
                                                        echo $combo->getStatus($perfil->getSnActive(), true);
                                                        ?>
                                                    </select>
                                                    <span style="display: none;"><?php echo $perfil->getSnActive(); ?></span>
                                                </td>
                                                <td>
                                                    <?php if ($perfil->getSnActive() == 'S') {
                                                        $send_status = "&status=N";
                                                        $icon_class = "glyphicon glyphicon-trash";
                                                    }else {
                                                        $send_status = "&status=S";
                                                        $icon_class = "glyphicon glyphicon-thumbs-up";
                                                    }
                                                    ?>
                                                    <?php if (!in_array($perfil->getId(), [1,2,3] )){ ?>
                                                        <a href="<?php echo $helper->url("perfil","chstatus"); ?><?php echo $send_status; ?>&id_perfil=<?php echo $perfil->getId(); ?>" >
                                                            <span class="<?php echo $icon_class; ?>"></span>
                                                        </a>
                                                    <?php } ?>
                                                    <a href="<?php echo $helper->url("perfil","modify"); ?>&id_perfil=<?php echo $perfil->getId(); ?>" >
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </a>

                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                               <!-- <p><a class="btn btn-primary btn-md" role="button" href="<?php echo $helper->url("perfil","add"); ?>">Create Profile</a></p>-->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <?php include("section/sincl_404.php"); ?>
        <?php endif; ?>
        <footer>
            <?php include("section/sincl_footer.php"); ?>
        </footer>
    </body>
</html>
