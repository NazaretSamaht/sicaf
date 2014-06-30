<script>site_url='<?php echo  site_url() ?>';</script>
<?php if (!is_array(@$arrayJs)) $arrayJs = array(); ?>
<?php if (!is_array(@$arrayCss)) $arrayCss = array(); ?>
<?php array_unshift($arrayJs, 'jquery-1.10.2.min.js','jquery-ui-1.8.23.custom.min.js','datepicker.js'); ?>
<?php array_unshift($arrayCss, 'custom-theme/jquery-ui-1.8.23.custom.css','estilo_blueprint.css?x=6','font-awesome/css/font-awesome.min.css'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if (isset($arrayCss)): ?>
            <?php foreach ($arrayCss as $dirCss): ?>
                <link type="text/css" href="<?php echo  base_url() . "application/css/$dirCss" ?>" rel="stylesheet" />
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if (isset($arrayJs)): ?>
            <?php foreach ($arrayJs as $dirJs): ?>
                <script type="text/javascript" src="<?php echo  base_url() . "application/js/$dirJs" ?>"></script>
            <?php endforeach; ?>
        <?php endif; ?>
<!--        <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
        <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
      <link rel="stylesheet" href="<?php echo  base_url() . "application/css/framework-blueprint/blueprint/screen.css"?>" type="text/css" media="screen, projection">
	     <link rel="stylesheet" href="<?php echo  base_url() . "application/css/framework-blueprint/blueprint/print.css"?>" type="text/css" media="print">	
        <title><?php echo  (isset($title)) ? $title : 'titulo' ?></title>
    </head>
    <body>
<div class="container">
	
    
    <div id="vacios" class="span-24 last"></div>
        <div class="span-20">
            <div id="logotipo">
               <span id="titulo_sist">
                   <b>
                       SICAF
                   </b>
                   
               </span> 
                <span id="sub_sist">
                   <b>
                       SISTEMA DE CORRESPONDENCIA Y ATENCI&Oacute;N AL FUNCIONARIO
                   </b>
                   
               </span> 
            </div>
	</div>
        <div class="span-4 last">
               <div id="logo_rrhh">
                
                </div>
        </div>
    <div id="vacios" class="span-24 last"></div>
	<div id="espacios" class="span-24 last"></div>
        
        <div class="span-24 last">
            <div id="contenido" class="clearfix">