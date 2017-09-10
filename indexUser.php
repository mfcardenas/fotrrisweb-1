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
        <title>FoTRRIS Users </title>
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
                        <h1><small><?php echo _("list"); ?></small> <?php echo _("Users"); ?></h1>
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
                                        $('#table-user').dynatable({
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
                                    <table id="table-user" class="table table-bordered responsive">
                                        <thead>
                                        <tr>
                                            <th class="dynatable-head" data-dynatable-column="name">
                                                <?php echo _("Name"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="username">
                                                <?php echo _("Username"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="email">
                                                <?php echo _("email"); ?>
                                            </th>
                                            <th class="dynatable-head" data-dynatable-column="perfil">
                                                <?php echo _("Profile"); ?>
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
                                            <!--th class="dynatable-head" style="text-align: center;" data-dynatable-column="image">
                                                Picture
                                            </th-->
                                            <th class="dynatable-head" style="text-align: center;" data-dynatable-column="actions">
                                                <?php echo _("Actions"); ?>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($alluser as $user) {?>
                                            <tr>
                                                <td style='text-align: left;'><?php echo $user->getName(); ?></td>
                                                <td style='text-align: left;'><?php echo $user->getUsername(); ?></td>
                                                <td style='text-align: left;'><?php echo $user->getEmail(); ?></td>
                                                <td style='text-align: left;'>
                                                    <select name="perfil" id="perfil" disabled>
                                                        <?php
                                                        echo $combo->getPerfiles($user->getIdPerfil(), false);
                                                        ?>
                                                    </select>
                                                </td>
                                                <td style='text-align: left;'>
                                                    <?php echo date(FORMAT_DATE, strtotime($user->getDateCreate())); ?>
                                                </td>
                                                <td style='text-align: left;'><?php echo $user->getUserCreate(); ?></td>
                                                <td style='text-align: left;'>
                                                    <select name="snactive" id="snactive" disabled>
                                                        <?php
                                                        echo $combo->getStatus($user->getSnActive(), false);
                                                        ?>
                                                    </select>
                                                    <span style="display: none;"><?php echo $user->getSnActive(); ?></span>
                                                </td>
                                                <!--td style='text-align: left;'>< ?php echo $user->getIdPerfil(); ?></td-->
                                                <td>
                                                    <?php if ($user->getSnActive() == 'S') {
                                                        $send_status = "&status=N";
                                                        $icon_class = "glyphicon glyphicon-trash";
                                                    }else {
                                                        $send_status = "&status=S";
                                                        $icon_class = "glyphicon glyphicon-thumbs-up";
                                                    }
                                                    ?>
                                                    <a href="<?php echo $helper->url("user","chstatus"); ?><?php echo $send_status; ?>&id_user=<?php echo $user->getId(); ?>" >
                                                        <span class="<?php echo $icon_class; ?>"></span>
                                                    </a>
                                                    <a href="<?php echo $helper->url("user","modify"); ?>&id_user=<?php echo $user->getId(); ?>" >
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
                                <p><a class="btn btn-primary btn-md" role="button" href="<?php echo $helper->url("user","add"); ?>"><?php echo _("Create User"); ?></a></p>
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
