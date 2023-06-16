<?php 
SESSION_START();
include('connect_data.php');

if (isset($_SESSION['ID_connect_hackthon']) AND $_SESSION['ID_connect_hackthon']=='Rendez-vous-project9989' ) {

    if ($_SESSION['auth']!='entrer') {
      $reponse =  'Entrer le code d\'authentification.';
      header("location:auth_d.php?aff_reponse_fausse=".$reponse);
    }
    
}
else{
  $reponse =  'Veuillez vous inscript svp.';
  header("location:inscription.php?aff_reponse_fausse=".$reponse);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
  <title>HACKATHON DAYS - GESTION DES RENDEZ VOUS</title>

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <script src="lib/chart-master/Chart.js"></script>

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
        
        <!-- Header -->
        <?PHP INCLUDE('S_include_header.php'); ?>

    <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
        
        <!-- Header Menu -->
        <?php INCLUDE('S_include_menu.php'); ?>

    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper site-min-height">
        <h3><i class="fa fa-angle-right"></i> Prendre un rendez-vous</h3>
        <div class="row mt">
          <div class="col-lg-12">
            <?php 
            $i = 0;
            $all_membre = $bdd->prepare('SELECT * FROM membre WHERE id != :id ORDER BY ID DESC');
            $all_membre->execute(array('id' => $_SESSION['id']));
            while($res_all_membre = $all_membre->fetch()) {
            ?>
              <!--  PROFILE 01 PANEL -->
              <div class="col-lg-4 col-md-4 col-sm-4 mb">
                <div class="content-panel pn">
                  <div id="profile-01" style="background-image: url('<?php echo $res_all_membre['profile_picture']; ?>');">
                    <h3><?php echo $res_all_membre['nom']; ?></h3>
                    <h6>DISPONIBILITE</h6>
                  </div>
                  <div class="profile-01 centered">
                    <a ><p></p></a>
                  </div>
                  <div class="centered" style="background-color: #337ab7; padding: 5px;">
                    <a href="mailto:<?php echo $res_all_membre['mail']; ?>" ><h6 style="font-size: 15px; color: #fff;"><i class="fa fa-envelope"></i><br/><?php echo $res_all_membre['mail']; ?></h6></a>
                  </div>
                </div>
                <!-- /content-panel -->
              </div>
            <?php 
            } 
            ?>
            </div>
            <!--  END SIXTH ROW OF PANELS -->
          </div>
        </div>
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->

    <!-- Footer -->
    <?PHP INCLUDE('S_include_footer.php'); ?>

  </section>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="lib/jquery.scrollTo.min.js"></script>
  <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script src="lib/jquery.sparkline.js"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
  <script src="lib/sparkline-chart.js"></script>

</body>

</html>
