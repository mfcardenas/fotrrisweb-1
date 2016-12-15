<?php
    require_once 'config/db_connect.php';
    require_once 'includes/functions.php';

    sec_session_start();
?>
<!-- Fixed navbar -->
    
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <div id="logo">
				<div class='logo_img transparent_logo_flip'>
					<a href="http://fotrris-h2020.eu/" title="FoTRRIS" rel="home">
					   <img src="http://fotrris-h2020.eu/wp-content/uploads/2016/01/logo-fotrris.png" alt="FoTRRIS"/>
					</a>
				</div>
              </div>
            </div>
            <div class="navbar-collapse collapse navbar-right">
              <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo _("Language");?></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo setParameterForURL(array("lang"=>"es_ES")); ?>"><img src="img/img_spain_a.png" width="22" height="22" alt="Spain" title="Lenguaje Castellano">&nbsp;&nbsp;<?php echo _("Spanish");?></a></li>
                        <li><a href="<?php echo setParameterForURL(array("lang"=>"en_GB")); ?>"><img src="img/img_uk_a.png" width="22" height="22" alt="UK" title="Lenguaje Inglés">&nbsp;&nbsp;<?php echo _("English");?></a></li>
                        <li><a href="<?php echo setParameterForURL(array("lang"=>"it_IT")); ?>"><img src="img/img_italia_a.png" width="22" height="22" alt="Italia" title="Lenguaje Italiano">&nbsp;&nbsp;<?php echo _("Italian");?></a></li>
                    </ul>
                </li>
                <li class="active"><a href="home.php"><?php echo _("Home");?></a></li>
                <li><a href="index.php?controller=project&action=show"><?php echo _("Show Projects");?> </a></li>
                <?php if (login_check($mysqli) == true) { ?>
                    <?php if ($_SESSION['type'] == 2) { ?>
                        <li><a href="index.php?controller=user&action=index"><?php echo _("User");?> </a></li>
                        <li><a href="index.php?controller=perfil&action=index"><?php echo _("Profile");?> </a></li>
                        <li><a href="index.php?controller=arena&action=index"><?php echo _("Hubs");?> </a></li>
                    <?php } ?>
                    <?php if ($_SESSION['type'] != 1) { ?>
                        <li>
                            <a href="index.php?controller=project&action=index&param=id_<?php echo htmlentities($_SESSION['id_user']); ?>_type_<?php echo htmlentities($_SESSION['type']); ?>"><?php echo _("Projects");?> </a>
                        </li>
                        <li>
                            <a href="index.php?controller=assign&action=index&param=id_<?php echo htmlentities($_SESSION['id_user']); ?>_type_<?php echo htmlentities($_SESSION['type']); ?>"><?php echo _("Assign Projects");?></a>
                        </li>
                    <?php } ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo _("My Projects");?></a>
                        <ul class="dropdown-menu">
                            <?php
                                require_once 'core/Combo.php';
                                $combo_ = new Combo();
                                echo $combo_->getLinkProject($_SESSION['email']);// getListProjectU($mysqli, $_SESSION['email']);
                            ?>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <!--?php require_once 'includes/image_user.php'; ?-->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img
                                src="includes/image_user.php?id=<?php echo htmlentities($_SESSION['id_user']); ?>"
                                alt="<?php echo htmlentities($_SESSION['username']); ?>" title="<?php echo htmlentities($_SESSION['username']); ?>" width="32" height="32"/></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><?php echo _("Signed in as");?> <?php echo htmlentities($_SESSION['username']); ?></a></li>
                            <li><br/></li>
                            <li></li>
                            <li>
                                <a href="<?php echo get_parameter_url(array('controller' => 'user', 'action' => 'setting', 'iu' => htmlentities($_SESSION['id_user']))) ?>"><?php echo _("My profile");?></a>
                            </li>
                            <li><br/></li>
                            <li><a href="includes/logout.php"><?php echo _("Sing out");?></a></li>
                        </ul>
                    </li>
                <?php } else { ?>
                    <li><a href="login.php"><?php echo _("Sing in/up");?></a></li>
                <?php }; ?>
              </ul>
        </div>
          </div>
        </div>
    