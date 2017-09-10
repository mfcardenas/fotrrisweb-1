<?php
require_once 'includes/functions.php';
require_once 'includes/translate.php';

sec_session_start();

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

</head>

<body>

<header>
    <?php include("section/sincl_header.php"); ?>
</header>
<!-- validate sesion is live ? -->
<?php if (true) : ?>
    <div id="bar_top">
        <div class="container">
            <div class="row">
                <h1></h1>
            </div>
            <div class="row">
                <h1><small><?php echo _("list"); ?></small> <?php echo _("Projects"); ?></h1>
            </div>
        </div>
    </div>
    <section>
        <div class="headerwrap-form">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row team-bar">
                            <div class="first-one-arrow hidden-xs">
                                <hr>
                            </div>
                            <div class="first-arrow hidden-xs">
                                <hr>
                                <i class="fa fa-angle-up"></i>
                            </div>
                            <div class="second-arrow hidden-xs">
                                <hr>
                                <i class="fa fa-angle-down"></i>
                            </div>
                            <div class="third-arrow hidden-xs">
                                <hr>
                                <i class="fa fa-angle-up"></i>
                            </div>
                            <div class="fourth-arrow hidden-xs">
                                <hr>
                                <i class="fa fa-angle-down"></i>
                            </div>
                        </div> <!--skill_border-->
                        <div class="dynatable-demo">
                            <ul id="ul-example" class="row-fluid">
                                <?php foreach($allproject as $project) { ?>
                                    <li class="span4" data-color="color">
                                        <div class="thumbnail">
                                            <div class="thumbnail-image">
                                                <img src="img/<?php echo $project->getImages(); ?>" class="img_responsive"/>
                                            </div>
                                            <div class="caption">
                                                <h4><?php echo $project->getName(); ?></h4>
                                                <p>
                                                    <!--?php echo _("Hub"); ?>:-->
                                                    <span title="<?php echo _("Hub"); ?>"><?php echo $project->getNameArena(); ?></span>
                                                </p>
                                                <p class="keywords">
                                                    <!--?php echo _("Keywords"); ? > : -->
                                                    <?php $i = 1;
                                                    $class_keywords = "Keywords";
                                                    $keywords = $gm->getKeywordsProj($project->getId(), $class_keywords);
                                                    if (!is_array($keywords)){
                                                        $keywords = array();
                                                    }
                                                    foreach ($keywords as $keyword){ ?>
                                                        <span title="<?php echo _("Keywords"); ?>" class="<?php echo $combo->getStyleTags(); ?>"><?php echo $keyword->getKeyword(); ?></span>
                                                    <?php } ?>
                                                </p>
                                                <p>
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal<?php echo $project->getId(); ?>"><?php echo _("Description"); ?></button>
                                                    <?php if ($project->getWebSite() != '') { ?>
                                                        <a target="_blank" href="<?php echo $project->getWebSite(); ?>" class="btn btn-primary"><?php echo _("WebSite"); ?></a>
                                                    <?php } ?>
                                                    <?php
                                                    if (login_check($mysqli) == true) {
                                                        if (isUserToJoin($mysqli, $project->getId(), $_SESSION['id_user']) == 'F') { ?>
                                                            <a href="<?php echo $helper->url("project", "join"); ?>&id_project=<?php echo $project->getId(); ?>&id_user=<?php echo htmlentities($_SESSION['id_user']); ?>&nam=<?php echo htmlentities($_SESSION['username']); ?>"
                                                               class="btn btn-primary btn-sm" id="project_<?php echo $project->getId(); ?>" onclick="return confirm('<?php echo _("Your request is send to the projectleader"); ?>')"><?php echo _("Join"); ?></a>
                                                        <?php }
                                                    }?>
                                                    <span title="<?php echo _("PDF"); ?>" >
                                                        <?php
                                                        $pad_name = $gm->getPadAbsProject($project->getId());
                                                        if($pad_name != ''){
                                                            ?>
                                                            <a href="<?php echo URL_SERVER_PAD . "/p/".$pad_name."/export/pdf"  ?>" target="_blank" title="<?php echo _("Work in Progress"); ?>">
                                                                  <img id="img_simple" src="img/img_ico_pdf.png" alt="<?php echo _("Work in Progress"); ?>" title="<?php echo _("Work in Progress"); ?>" width="28px" height="28px"/>
                                                              </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </span>
                                                    <span class="label label-success" title="<?php echo _("Users"); ?>"><?php echo $gm->getUsersProject($project->getId())->num;?> <?php echo _("Users"); ?>
                                                    </span>
                                                </p>
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal<?php echo $project->getId(); ?>" role="dialog">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title"><?php echo _("Project Description"); ?></h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><?php echo $project->getDescProject(); ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _("Close"); ?></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <p>
                            <cite>
                                <i>
                                    <?php if (login_check($mysqli) == true) { ?>
                                        <?php if ($_SESSION['type'] == 3) {?>
                                            * <?php echo _("List of projects associated with the Hub user"); ?>.
                                        <?php } else { echo _("List of all projects"); } ?>
                                    <?php } else { ?>
                                        * <?php echo _("List of all projects"); ?>.
                                    <?php } ?>
                                </i>
                            </cite>
                        </p>

                        <script>
                            $(function() {
                                // Function that renders the list items from our records
                                function ulWriter(rowIndex, record, columns, cellWriter) {
                                    var cssClass = "span4", li;
                                    if (rowIndex % 3 === 0) { cssClass += ' first'; }
                                    li = '<li class="' + cssClass + '"><div class="thumbnail"><div class="thumbnail-image">' + record.thumbnail + '</div><div class="caption">' + record.caption + '</div></div></li>';
                                    return li;
                                }

                                // Function that creates our records from the DOM when the page is loaded
                                function ulReader(index, li, record) {
                                    var $li = $(li),
                                        $caption = $li.find('.caption');
                                    record.thumbnail = $li.find('.thumbnail-image').html();
                                    record.caption = $caption.html();
                                    record.label = $caption.find('h4').text();
                                    record.description = $caption.find('p').text();
                                    record.color = $li.data('color');
                                }

                                $('#ul-example').dynatable({
                                    table: {
                                        bodyRowSelector: 'li'
                                    },
                                    dataset: {
                                        perPageDefault: 3,
                                        perPageOptions: [3]
                                    },
                                    writers: {
                                        _rowWriter: ulWriter
                                    },
                                    readers: {
                                        _rowReader: ulReader
                                    },
                                    params: {
                                        records: 'Projects'
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<footer>
    <?php include("section/sincl_footer.php"); ?>
</footer>
</body>
</html>

