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
        <title>FoTRRIS Projects </title>
        <?php include("section/sincl_html.php"); ?>
        <link rel="stylesheet" href="css/util.css" />
        <link href="css/jquery-ui.min.css" rel="stylesheet" />
        <script src="js/jquery-ui.min.js"></script>
        
        <script>
            $(function() {
                $( "#date_from" ).datepicker({
                    defaultDate: "+1w",
                    dateFormat: "<?php echo FORMAT_DATE_CALENDAR;?>",
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#date_to" ).datepicker( "option", "minDate", selectedDate );
                    }
                });
                $( "#date_to" ).datepicker({
                    defaultDate: "+1w",
                    dateFormat: "<?php echo FORMAT_DATE_CALENDAR;?>",
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function( selectedDate ) {
                        $( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
                    }
                });
            });
        </script>
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
                        <h1><small><?php echo _($action); ?></small> <?php echo _("Project"); ?></h1>
                    </div>
                </div>
            </div>
            <section>
                <div id="headerwrap-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                foreach ($keys as $key){
                                    echo getNotification($key, null )."<br/>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <form data-toggle="validator" class="form-horizontal" enctype="multipart/form-data" action="<?php if ($action == 'Create') { echo $helper->url('project','create');} else {echo $helper->url('project','update');} ?>" method="POST" role="form">
                                <div class="form-group">
                                    <label for="name" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" name="name" id="name" placeholder="<?php echo _("Name"); ?>" tabindex="1" value="<?php echo $project->getName(); ?>"/>
                                        <input type="hidden" id="id" name="id" value="<?php echo $project->getId(); ?>"/>
                                        <input type="hidden" id="id_user_log" name="id_user_log" value="<?php echo htmlentities($_SESSION['id_user']); ?>"/>
                                        <input type="hidden" id="type" name="type" value="<?php echo htmlentities($_SESSION['type']); ?>"/>
                                        <input type="hidden" id="userapp" name="userapp" value="<?php echo htmlentities($_SESSION['username']); ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="id_arena" class="control-label col-xs-3"><?php echo _("Hub"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <select required name="id_arena" id="id_arena" tabindex="2" class="form-control">
                                            <?php
                                            if ($_SESSION['type'] == 3){
                                                echo $combo->getArenas($project->getIdArena(), true, true, true, $_SESSION['id_user']);
                                            } else {
                                                echo $combo->getArenas($project->getIdArena(), true);
                                            }
                                            ?> 
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ubication" class="control-label col-xs-3"><?php echo _("Location"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" id="ubication" name="ubication" placeholder="<?php echo _("Ubication"); ?>" tabindex="3" value="<?php echo $project->getUbication(); ?>"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="desc_proj" class="control-label col-xs-3"><?php echo _("Description"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <!--input type="text" class="form-control" id="desc_proj" name="desc_proj" placeholder="Description of project" tabindex="4" value="< ?php echo $project->getDescProject(); ?>"/-->
                                        <textarea required class="form-control" rows="3" id="desc_proj" name="desc_proj" tabindex="4" ><?php echo $project->getDescProject(); ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-xs-3"><?php echo _("Duration"); ?>:</label>
                                    <div class="col-xs-9">
                                        <div class="col-xs-4">
                                            <label for="date_from" class="control-label col-xs-4"><?php echo _("From"); ?>:*</label>
                                            <div class="input-group date">
                                                <input required type="text" class="form-control" id="date_from" name="date_from" tabindex="5" value="<?php echo ($project->getDateFrom()!='')?date(FORMAT_DATE, strtotime($project->getDateFrom())):""; ?>" data-error="The start date is necessary!"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="date_to" class="control-label col-xs-4"><?php echo _("To"); ?>:</label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control" id="date_to" name="date_to" tabindex="6" value="<?php echo ($project->getDateTo()!='')?date(FORMAT_DATE, strtotime($project->getDateTo())):""; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="num_pad" class="control-label col-xs-3"><?php echo _("Pads"); ?></label>
                                    <div class="col-xs-9">
                                        <div class="col-xs-4">
                                            <label class="control-label col-xs-4"><?php echo _("Number"); ?>:*</label>
                                            <div class="col-sm-5">
                                                <select required id="num_pad_t" name="num_pad_t" tabindex="7" >
                                                    <?php echo $combo->getNumPad($project->getNumPad(), false, 15); ?>
                                                </select>
                                                <input type="hidden" id="num_pad" name="num_pad" value="<?php echo $project->getNumPad(); ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-xs-6">
                                            <p class="help-block"><?php echo _("A project can only have most ten pads"); ?></p>
                                        </div>
                                        <script type="text/javascript">
                                            $(function () {
                                                showFieldDescPha($("#num_pad_t").val(), true);
                                                $("#num_pad_t").change(function(){
                                                    $("#num_pad").val($("#num_pad_t").val());
                                                    showFieldDescPha($("#num_pad_t").val(), true);
                                                });

                                                $("#num_pad").val($("#num_pad_t").val());
                                            });

                                            function showFieldDescPha(valor, sh){
                                                $( "div[class*='desc_pad']" ).hide();
                                               // $(".desc_pad?").hide();
                                                for(var i = 1; i <= parseInt(valor); i++){
                                                    if(sh){
                                                        $(".desc_pad" + i).show();    
                                                    }else{
                                                        $(".desc_pad" + i).hide();    
                                                    }

                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group desc_pad1">
                                    <label class="control-label col-xs-3"><?php echo _("Description"); ?>:</label>
									<div class="col-xs-4">
                                        <label for="name_p1" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input required type="text" class="form-control" id="name_p1" name="name_p1" tabindex="8" value="<?php echo ($project->getNamePad1()=='')?NAME_FASE_1:$project->getNamePad1(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p1" class="control-label col-xs-3"><?php echo _("Phase"); ?> 1:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p1" name="desc_p1" tabindex="9" value="<?php echo ($project->getDescPad1()=='')?DESC_FASE_1:$project->getDescPad1(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad2">
                                    <label class="control-label col-xs-3"></label>
									 <div class="col-xs-4">
                                        <label for="name_p2" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p2" name="name_p2" tabindex="10" value="<?php echo ($project->getNamePad2()=='')?NAME_FASE_2:$project->getNamePad2(); ?>"/>
                                        </div>
                                    </div>
                                     <div class="col-xs-5">
                                        <label for="desc_p2" class="control-label col-xs-3"><?php echo _("Phase"); ?> 2:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p2" name="desc_p2" tabindex="11" value="<?php echo ($project->getDescPad2()=='')?DESC_FASE_2:$project->getDescPad2(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad3">
                                    <label class="control-label col-xs-3"></label>
									<div class="col-xs-4">
                                        <label for="name_p3" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p3" name="name_p3" tabindex="12" value="<?php echo ($project->getNamePad3()=='')?NAME_FASE_3:$project->getNamePad3(); ?>"/>
                                        </div>
                                    </div>
                                     <div class="col-xs-5">
                                        <label for="desc_p3" class="control-label col-xs-3"><?php echo _("Phase"); ?> 3:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p3" name="desc_p3" tabindex="13" value="<?php echo ($project->getDescPad3()=='')?DESC_FASE_3:$project->getDescPad3(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad4">
                                    <label class="control-label col-xs-3"></label>
									<div class="col-xs-4">
                                        <label for="name_p4" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p4" name="name_p4" tabindex="14" value="<?php echo ($project->getNamePad4()=='')?NAME_FASE_4:$project->getNamePad4(); ?>"/>
                                        </div>
                                    </div>
                                     <div class="col-xs-5">
                                        <label for="desc_p4" class="control-label col-xs-3"><?php echo _("Phase"); ?> 4:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p4" name="desc_p4" tabindex="15" value="<?php echo ($project->getDescPad4()=='')?DESC_FASE_4:$project->getDescPad4(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad5" >
                                    <label class="control-label col-xs-3"></label>
									 <div class="col-xs-4">
                                        <label for="name_p5" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p5" name="name_p5" tabindex="16" value="<?php echo ($project->getNamePad5()=='')?NAME_FASE_5:$project->getNamePad5(); ?>"/>
                                        </div>
                                    </div>
                                     <div class="col-xs-5">
                                        <label for="desc_p5" class="control-label col-xs-3"><?php echo _("Phase"); ?> 5:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p5" name="desc_p5" tabindex="17" value="<?php echo ($project->getDescPad5()=='')?DESC_FASE_5:$project->getDescPad5(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad6">
                                    <label class="control-label col-xs-3"></label>
									<div class="col-xs-4">
                                        <label for="name_p6" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p6" name="name_p6" tabindex="18" value="<?php echo ($project->getNamePad6()=='')?NAME_FASE_6:$project->getNamePad6(); ?>"/>
                                        </div>
                                    </div>
                                     <div class="col-xs-5">
                                        <label for="desc_p6" class="control-label col-xs-3"><?php echo _("Phase"); ?> 6:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p6" name="desc_p6" tabindex="19" value="<?php echo ($project->getDescPad6()=='')?DESC_FASE_6:$project->getDescPad6(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad7">
                                    <label class="control-label col-xs-3"></label>
									<div class="col-xs-4">
                                        <label for="name_p7" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p7" name="name_p7" tabindex="20" value="<?php echo ($project->getNamePad7()=='')?NAME_FASE_7:$project->getNamePad7(); ?>"/>
                                        </div>
                                    </div>
                                     <div class="col-xs-5">
                                        <label for="desc_p7" class="control-label col-xs-3"><?php echo _("Phase"); ?> 7:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p7" name="desc_p7" tabindex="21" value="<?php echo ($project->getDescPad7()=='')?DESC_FASE_7:$project->getDescPad7(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad8">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p8" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p8" name="name_p8" tabindex="22" value="<?php echo ($project->getNamePad8()=='')?NAME_FASE_8:$project->getNamePad8(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p8" class="control-label col-xs-3"><?php echo _("Phase"); ?> 8:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p8" name="desc_p8" tabindex="23" value="<?php echo ($project->getDescPad8()=='')?DESC_FASE_8:$project->getDescPad8(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad9">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p9" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p9" name="name_p9" tabindex="24" value="<?php echo ($project->getNamePad9()=='')?NAME_FASE_9:$project->getNamePad9(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p9" class="control-label col-xs-3"><?php echo _("Phase"); ?> 9:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p9" name="desc_p9" tabindex="25" value="<?php echo ($project->getDescPad9()=='')?DESC_FASE_9:$project->getDescPad9(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad10">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p10" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p10" name="name_p10" tabindex="26" value="<?php echo ($project->getNamePad10()=='')?NAME_FASE_10:$project->getNamePad10(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p10" class="control-label col-xs-3"><?php echo _("Phase"); ?> 10:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p10" name="desc_p10" tabindex="27" value="<?php echo ($project->getDescPad10()=='')?DESC_FASE_10:$project->getDescPad10(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad11">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p11" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p11" name="name_p11" tabindex="26" value="<?php echo ($project->getNamePad11()=='')?NAME_FASE_11:$project->getNamePad11(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p11" class="control-label col-xs-3"><?php echo _("Phase"); ?> 11:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p11" name="desc_p11" tabindex="27" value="<?php echo ($project->getDescPad11()=='')?DESC_FASE_11:$project->getDescPad11(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad12">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p12" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p12" name="name_p12" tabindex="26" value="<?php echo ($project->getNamePad12()=='')?NAME_FASE_12:$project->getNamePad12(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p12" class="control-label col-xs-3"><?php echo _("Phase"); ?> 12:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p12" name="desc_p12" tabindex="27" value="<?php echo ($project->getDescPad12()=='')?DESC_FASE_12:$project->getDescPad12(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad13">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p13" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p13" name="name_p13" tabindex="26" value="<?php echo ($project->getNamePad13()=='')?NAME_FASE_13:$project->getNamePad13(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p13" class="control-label col-xs-3"><?php echo _("Phase"); ?> 13:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p13" name="desc_p13" tabindex="27" value="<?php echo ($project->getDescPad13()=='')?DESC_FASE_13:$project->getDescPad13(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad14">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p14" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p14" name="name_p14" tabindex="26" value="<?php echo ($project->getNamePad14()=='')?NAME_FASE_14:$project->getNamePad14(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p14" class="control-label col-xs-3"><?php echo _("Phase"); ?> 14:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p14" name="desc_p14" tabindex="27" value="<?php echo ($project->getDescPad14()=='')?DESC_FASE_14:$project->getDescPad14(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group desc_pad15">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-4">
                                        <label for="name_p15" class="control-label col-xs-3"><?php echo _("Name"); ?>:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="name_p15" name="name_p15" tabindex="26" value="<?php echo ($project->getNamePad15()=='')?NAME_FASE_15:$project->getNamePad15(); ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5">
                                        <label for="desc_p15" class="control-label col-xs-3"><?php echo _("Phase"); ?> 15:*</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="desc_p15" name="desc_p15" tabindex="27" value="<?php echo ($project->getDescPad15()=='')?DESC_FASE_15:$project->getDescPad15(); ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sn_active" class="control-label col-xs-3"><?php echo _("Status"); ?>:*</label>
                                    <div class="col-xs-2">
                                        <select required name="sn_active" id="sn_active" tabindex="28">
                                            <?php echo $combo->getStatus($project->getSnActive(), false); ?>
                                        </select>
                                    </div>
                                    <label for="abstract" class="control-label col-xs-2"><?php echo _("Abstract"); ?>:*</label>
                                    <div class="col-xs-2">
                                        <select required name="abstract" id="abstract" tabindex="29">
                                            <?php echo $combo->getStatus($project->getSnAbstract(), false); ?>
                                        </select>
                                    </div>
                                    <label for="repository" class="control-label col-xs-1"><?php echo _("Repository"); ?>:*</label>
                                    <div class="col-xs-2">
                                        <select required name="repository" id="repository" tabindex="29">
                                            <?php echo $combo->getStatus($project->getSnRepository(), false); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keywords" class="control-label col-xs-3"><?php echo _("Keywords"); ?>:*</label>
                                    <div class="col-xs-9">
                                        <input required type="text" class="form-control" id="keywords" name="keywords" placeholder="<?php echo _("Keywords of project (separe for comma)"); ?>"
                                               tabindex="29"
                                               value="<?php
                                               $size = count($keywords);
                                               $i = 0;
                                               foreach ($keywords as $keyword){
                                                   $i = $i + 1;
                                                   if ($keyword == ''){
                                                       continue;
                                                   } else {
                                                       echo $keyword->getKeyword();
                                                       if ($size > $i) {
                                                           echo ", ";
                                                       }
                                                   }

                                               } ?>" data-error="The keywords are needed to describe the project!"/>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="keywords" class="control-label col-xs-3"></label>
                                    <div class="col-xs-9">
                                        <?php $i = 1;
                                            foreach ($keywords as $keyword){ ?>
                                            <span class="<?php echo $combo->getStyleTags(); ?>"><?php echo $keyword->getKeyword(); ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"><?php echo _("Image for project"); ?>:</label>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_01.png"
                                                <?php if ($project->getImages() == '' || $project->getImages() == "img_project_01.png") echo "checked";?> />
                                            <img src="img/img_project_01.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_02.png"
                                                <?php if ($project->getImages() == "img_project_02.png") echo "checked";?>/>
                                            <img src="img/img_project_02.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_03.png"
                                                <?php if ($project->getImages() == "img_project_03.png") echo "checked";?>/>
                                            <img src="img/img_project_03.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_04.png"
                                                <?php if ($project->getImages() == "img_project_04.png") echo "checked";?>/>
                                            <img src="img/img_project_04.png" title="Image for Project">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_05.png"
                                                <?php if ($project->getImages() == "img_project_05.png") echo "checked";?>/>
                                            <img src="img/img_project_05.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_06.png"
                                                <?php if ($project->getImages() == "img_project_06.png") echo "checked";?>/>
                                            <img src="img/img_project_06.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_07.png"
                                                <?php if ($project->getImages() == "img_project_07.png") echo "checked";?>/>
                                            <img src="img/img_project_07.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_08.png"
                                                <?php if ($project->getImages() == "img_project_08.png") echo "checked";?>/>
                                            <img src="img/img_project_08.png" title="Image for Project">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_09.png"
                                                <?php if ($project->getImages() == "img_project_09.png") echo "checked";?>/>
                                            <img src="img/img_project_09.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_10.png"
                                                <?php if ($project->getImages() == "img_project_10.png") echo "checked";?>/>
                                            <img src="img/img_project_10.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_11.png"
                                                <?php if ($project->getImages() == "img_project_11.png") echo "checked";?>/>
                                            <img src="img/img_project_11.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_12.png"
                                                <?php if ($project->getImages() == "img_project_12.png") echo "checked";?>/>
                                            <img src="img/img_project_12.png" title="Image for Project">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_13.png"
                                                <?php if ($project->getImages() == "img_project_13.png") echo "checked";?>/>
                                            <img src="img/img_project_13.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_14.png"
                                                <?php if ($project->getImages() == "img_project_14.png") echo "checked";?>/>
                                            <img src="img/img_project_14.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_15.png"
                                                <?php if ($project->getImages() == "img_project_15.png") echo "checked";?>/>
                                            <img src="img/img_project_15.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_16.png"
                                                <?php if ($project->getImages() == "img_project_16.png") echo "checked";?>/>
                                            <img src="img/img_project_16.png" title="Image for Project">
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3"></label>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">
                                            <input type="radio" name="images" id="images" value="img_project_17.png"
                                                <?php if ($project->getImages() == "img_project_17.png") echo "checked";?> />
                                            <img src="img/img_project_17.png" title="Image for Project">
                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">

                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">

                                        </label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label class="radio-inline">

                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="file_img_project" class="control-label col-xs-3"></label>
                                    <div class="col-xs-9">
                                      </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4 col-xs-offset-3">
                                        <input type="submit" name="register-submit" id="register-submit" tabindex="30" class="btn btn-primary" value="<?php echo $action; ?>"
                                               onclick="return regformproject(this.form,
                                                               this.form.name,
                                                               this.form.id_arena,
                                                               this.form.date_from,
                                                               this.form.date_to,
                                                               this.form.ubication,
                                                               this.form.num_pad,
                                                               this.form.desc_p1,
                                                               this.form.name_p1,
                                                               this.form.desc_p2,
                                                               this.form.name_p2,
                                                               this.form.desc_p3,
                                                               this.form.name_p3,
                                                               this.form.desc_p4,
                                                               this.form.name_p4,
                                                               this.form.desc_p5,
                                                               this.form.name_p5,
                                                               this.form.desc_p6,
                                                               this.form.name_p6,
                                                               this.form.desc_p7,
                                                               this.form.name_p7,
                                                               this.form.desc_p8,
                                                               this.form.name_p8,
                                                               this.form.desc_p9,
                                                               this.form.name_p9,
                                                               this.form.desc_p10,
                                                               this.form.name_p10,
                                                               this.form.desc_proj,
                                                               this.form.keywords,
                                                               this.form.sn_active,
                                                               this.form.images,
                                                               this.form.id,
                                                               this.form.userapp);"
                                               />
                                        <input type="reset" class="btn btn-default" value="<?php echo _("Clear"); ?>" tabindex="25"/>

                                    </div>
                                    <div class="col-xs-offset-10">
                                        <a class="btn btn-default " role="button" href="<?php echo $helper->url('project', 'index'); ?>&param=id_<?php echo htmlentities($_SESSION['id_user']); ?>_type_<?php echo htmlentities($_SESSION['type']); ?>"><?php echo _("Back"); ?></a>
                                    </div>
                                </div>
                                <br>
                            </form>
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
