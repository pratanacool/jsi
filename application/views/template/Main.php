<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="Materialize is a Material Design Admin Template,It's modern, responsive and based on Material Design by Google. ">
    <meta name="keywords" content="materialize, admin template, dashboard template, flat admin template, responsive admin template,">
    <title>E-DPT</title>

    <!-- Favicons-->
    <link rel="icon" href="<?php echo base_url('assets');?>/images/favicon/favicon-32x32.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('assets');?>/images/favicon/apple-touch-icon-152x152.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="<?php echo base_url('assets');?>/images/favicon/mstile-144x144.png">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->
    <link href="<?php echo base_url('assets');?>/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo base_url('assets');?>/css/style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->    
    <link href="<?php echo base_url('assets');?>/css/custom/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="<?php echo base_url('assets');?>/js/plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo base_url('assets');?>/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="<?php echo base_url('assets');?>/js/plugins/chartist-js/chartist.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <link href="<?php echo base_url('assets');?>/js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">


    <!-- jQuery Library -->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/jquery-1.11.2.min.js"></script>    
  </head>

  <body>
    <!-- Header -->
    <?php echo $header; ?>
    <!-- /Header -->
      <div id="main">
        <div class="wrapper">


          <!-- Left Menu -->
          <?php echo $leftMenu; ?>
          <!-- /Left Menu -->
          
          <section id="content">

            <!--breadcrumbs start-->
            <div id="breadcrumbs-wrapper">
                <!-- Search for small screen -->
                <div class="header-search-wrapper grey hide-on-large-only">
                    <i class="mdi-action-search active"></i>
                    <input type="text" name="Search" class="header-search-input z-depth-2" placeholder="Explore Materialize">
                </div>
              <div class="container">
                <div class="row">
                  <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title"><?php echo $judul;?></h5>
                    <?php $bc = explode(";", $breadcrumbs);?>
                    <ol class="breadcrumbs">
                        <?php
                          $class = "";
                          $linkf = "<a href='#'>";
                          $linkl = "</a>";
                          for($i = 0; $i < count($bc); $i++){

                            if($i === (count($bc)-1)){
                              $class = "active";
                              $linkf="";
                              $linkl="";
                            }

                            echo "<li class='".$class."'>".$linkf.$bc[$i].$linkl."</a></li>";
                          }

                        ?>
                         
                    </ol>
                  </div>
                </div>
              </div>
            </div>
            <!--breadcrumbs end-->
              
          <div class="container">
          
            <div class="section">
              <div class="divider"></div>
              <?php echo $isi; ?>
            </div>

          </div>


          <!-- Floating Action Button -->
<!--             <div class="fixed-action-btn" style="bottom: 50px; right: 19px;">
                <a class="btn-floating btn-large">
                  <i class="mdi-action-stars"></i>
                </a>
                <ul>
                  <li><a href="css-helpers.html" class="btn-floating red"><i class="large mdi-communication-live-help"></i></a></li>
                  <li><a href="app-widget.html" class="btn-floating yellow darken-1"><i class="large mdi-device-now-widgets"></i></a></li>
                  <li><a href="app-calendar.html" class="btn-floating green"><i class="large mdi-editor-insert-invitation"></i></a></li>
                  <li><a href="app-email.html" class="btn-floating blue"><i class="large mdi-communication-email"></i></a></li>
                </ul>
            </div> -->
            <!-- Floating Action Button -->
            
          </section>
          
          <!-- Right Menu -->
          <!-- <?php echo $rightMenu; ?> -->
          <!-- /Right Menu -->


        </div>
      </div>

    <!-- Footer -->
    <?php echo $footer; ?>
    <!-- /Footer -->

    <!--floatThead -->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/floatThead/jquery.floatThead.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/floatThead/jquery.floatThead-slim.min.js"></script>

    <!--materialize js-->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/materialize.js"></script>
    <!--prism
    <script type="text/javascript" src="js/prism/prism.js"></script>-->
    <!--scrollbar-->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- chartist -->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/chartist-js/chartist.min.js"></script>   
    
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/custom-script.js"></script>


    <!-- data-tables -->
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets');?>/js/plugins/data-tables/data-tables-script.js"></script>
    
  </body>
</html>
