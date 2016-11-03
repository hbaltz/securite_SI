<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Formation sécurité des SI - GTSI</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php
    // Chargement des CSS
    $styles = array('oswald', 'bootstrap', 'bootstrap-responsive', 'jquery.lightbox-0.5', 'custom-styles');
    foreach($styles as $s) {
        echo css_url($s) . "\n";
    }

    // Chargement des JS
    $scripts = array('jquery.min', 'bootstrap.min');
    foreach($scripts as $s) {
        echo js_url($s) . "\n";
    }
?>

<!--[if lt IE 9]>
    <?php echo js_url('html5') . "\n"; ?>
    <?php echo css_url('style-ie') . "\n"; ?>
<![endif]-->

<body>
	<div class="color-bar-1"></div>
    <div class="color-bar-2 color-bg"></div>

    <div class="container main-container">

        <div class="row header">

        <div class="span5 logo">
        	<a href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-ensg.jpg'); ?>" alt="" /></a>
            <h5>Formation sécurité des SI - GTSI</h5>
        </div>

        <div class="span7 navigation">
            <div class="navbar hidden-phone">

                <ul class="nav">
                    <li><a href="<?php echo base_url(); ?>">Accueil</a></li>
                    <?php if(is_logged_in()) : ?>
                        <li><a href="<?php echo base_url('dashboard'); ?>">Administration</a></li>
                        <li><a href="<?php echo base_url('logout'); ?>">Se déconnecter</a></li>
                    <?php else : ?>
                        <li><a href="<?php echo base_url('register'); ?>">S'enregistrer</a></li>
                        <li><a href="<?php echo base_url('login'); ?>">Login</a></li>
                    <?php endif; ?>
                </ul>

            </div>

            <form action="#" id="mobile-nav" class="visible-phone">
                <div class="mobile-nav-select">
                    <select onchange="window.open(this.options[this.selectedIndex].value,'_top')">
                        <option value="">Navigate...</option>
                        <option value="<?php echo base_url(); ?>">Accueil</option>
                        <?php if(is_logged_in()) : ?>
                            <option value="<?php echo base_url('dashboard'); ?>">Administration</option>
                            <option value="<?php echo base_url('logout'); ?>">Se déconnecter</option>
                        <?php else : ?>
                            <option value="<?php echo base_url('login'); ?>">Login</option>
                        <?php endif; ?>
                    </select>
                </div>
            </form>

        </div>

      </div>
