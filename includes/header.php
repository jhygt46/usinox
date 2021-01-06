<?php
session_start();
if($_SERVER["HTTPS"] == "on"){
	$url = "https://www.usinox.cl";
}else{
	$url = "http://www.usinox.cl";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml">

    <head>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KQQ859V');</script>
        <!-- End Google Tag Manager -->
        <title>Usinox</title>

        <meta property="og:title" content="usinox"/>

        <meta property="og:type" content="website"/>

        <meta property="og:url" content="http://www.usinox.cl"/>

        <meta property="og:image" content="images/usinox.jpg"/>

        <meta property="og:site_name" content=""/>

        <meta property="fb:admins" content="753686445"/>

        <meta property="og:description" content=""/>

        <meta name="description" content="" />

        <meta name="language" content="spanish">

        <link media="all" type="text/css" href="<?php echo $url; ?>/css/reset.css" rel="stylesheet" />
	<link media="all" type="text/css" href="<?php echo $url; ?>/css/layout.css" rel="stylesheet" />
	<link media="all" type="text/css" href="<?php echo $url; ?>/css/pure-min.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Signika" />

        <link rel="shortcut icon" type="image/x-icon" href="<?php echo $url; ?>/ico/usinox.ico" />

        <script type="text/javascript" src="<?php echo $url; ?>/js/jquery-1.6.2.min.js"></script>

        <script type="text/javascript" src="<?php echo $url; ?>/js/base.js"></script>

        <script src="https://maps.googleapis.com/maps/api/js"></script>

        <script>

        var myCenter=new google.maps.LatLng(-33.4864051,-70.7093302);



        function initialize()

        {

        var mapProp = {

          center:myCenter,

          zoom:15,

          mapTypeId:google.maps.MapTypeId.ROADMAP

          };



        var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);



        var marker=new google.maps.Marker({

          position:myCenter,

          });



        marker.setMap(map);

        }



        google.maps.event.addDomListener(window, 'load', initialize);

        </script>

        <?php

    

            $partes_ruta = pathinfo($_SERVER["SCRIPT_FILENAME"]);

            if($partes_ruta['basename'] == "galeria.php" || $partes_ruta['basename'] == "noticias.php" || $partes_ruta['basename'] == "proyectos.php"){



                echo "<script type='text/javascript' src='".$url."/fancybox/jquery.fancybox-1.3.4.pack.js'></script>";

                echo "<link media='all' type='text/css' href='".$url."/fancybox/jquery.fancybox-1.3.4.css' rel='stylesheet' />";

                

                ?>

                <script type='text/javascript'>

                    $(document).ready(function() {



                            $("a[rel=example_group0]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group1]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group2]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group3]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group4]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group5]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group6]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group7]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group8]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });

                            $("a[rel=example_group9]").fancybox({

                                    'transitionIn'		: 'elastic',

                                    'transitionOut'		: 'elastic',

                                    'titlePosition'             : 'over'

                            });



                            

                    });

                </script>

                <?php

                

            }

    

        ?>

    </head>

    

    