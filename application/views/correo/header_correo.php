<script>site_url='<?php echo  site_url() ?>';</script>

<?php array_unshift($arrayCss, 'custom-theme/jquery-ui-1.8.23.custom.css','estilo_blueprint.css?x=6'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php if (isset($arrayCss)): ?>
            <?php foreach ($arrayCss as $dirCss): ?>
                <link type="text/css" href="<?php echo  base_url() . "application/css/$dirCss" ?>" rel="stylesheet" />
            <?php endforeach; ?>
        <?php endif; ?>
        
        <link rel="stylesheet" href="<?php echo  base_url() . "application/css/framework-blueprint/blueprint/screen.css"?>" type="text/css" media="screen, projection">
	<link rel="stylesheet" href="<?php echo  base_url() . "application/css/framework-blueprint/blueprint/print.css"?>" type="text/css" media="print">	
        <title><?php echo  (isset($title)) ? $title : 'titulo' ?></title>
        <style type="text/css" media = "all">

            root { 
                display: block;
            }

            .tablas{
                border-collapse: separate;
                border-spacing: 3px;
            }
            .td_tablas{
                border: orange 1px solid !important;

            } 

            td .tablas{
                border: orange 1px solid !important;
            }
            
            #banner{
                min-height: 85px;
                font-size: 1.0em;
                -moz-border-radius: 6px;
                padding-bottom: 5px;
            }
            #logo_rrhh{
                background-image: url("../../images/logo_rrhh.png");
                background-repeat: no-repeat; 
                min-height: 85px;
            }
            #logo_tlf {
                background: url(../../images/AtencionTelefonica_249x36.gif) 0 0 no-repeat;
                background-repeat: no-repeat; 
                min-height: 85px;
                background-position: right;

            }
            #titulo_sist{

                font-size: 60px;
                font-family: Helvetica, Verdana, sans-serif;
                font-style: oblique;
                color: #FFFFFF;
                margin-top: 20px;
                margin-left: 15px;

            }
            #contenido{

                /*	background-color:#8DB865;*/
                -moz-border-radius: 6px;
            }
            #logotipo{
/*                background-image: url("imagenes/fondo_alcaldia.png");
                background-repeat: repeat-x;
                text-align: left;
                min-height: 85px;*/

            }
            #sub_sist{

                font-size: 17px;
                font-family: Helvetica, Verdana, sans-serif;
                font-style: oblique;
                color: #FFFFFF;
                margin-top: 20px;
                margin-left: 15px;

            }
            #espacios{
                padding-bottom: 3px;
                background-color: #F9AE43;

            }

            #vacios{
                padding-bottom: 3px;
                background-color: #FFFFFF;

            } 
        </style>
    </head>
    <body>

	
    
    <!--<div id="vacios" class="span-24 last"></div>-->
        <div>
            <div>
                <img src="<?php echo base_url('imagenes/banner1.jpg'); ?>" >
                    
                </img>
               
            </div>
	</div>
        
    
	
        
        