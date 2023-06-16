<?php 
SESSION_START();
include('connect_data.php');

if (isset($_SESSION['ID_connect_hackthon']) AND $_SESSION['ID_connect_hackthon']=='Rendez-vous-project9989' ) {
  
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
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datetimepicker/datertimepicker.css" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">

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
      <section class="wrapper">
        <h3><i class="fa fa-angle-right"></i> Modifier les informations du profile</h3>
        <!--ADVANCED FILE INPUT-->
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <form action="S_edith_profile.php" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label col-md-3">Nom complet</label>
                  <div class="col-md-4">
                    <input type="text" name="nom" value="<?PHP echo$_SESSION['nom']; ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Adresse</label>
                  <div class="col-md-4">
                    <input type="text" name="adresse" value="<?PHP echo$_SESSION['adresse']; ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">E-mail Adresse</label>
                  <div class="col-md-4">
                    <input type="text" name="mail" value="<?PHP echo$_SESSION['mail']; ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Numéro Télephone</label>
                  <div class="col-md-4">
                    <input type="text" name="tel" value="<?PHP echo$_SESSION['tel']; ?>" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Mot de passe</label>
                  <div class="col-md-4">
                    <input type="password" name="mdp" placeholder="Saisissez l'ancien mot de passe" class="form-control" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3">Mot de passe</label>
                  <div class="col-md-4">
                    <input type="password" name="nmdp" placeholder="Saisissez votre nouveau mot de passe" class="form-control" />
                  </div>
                </div>
                <div class="form-group last">
                  <label class="control-label col-md-3">Sélectionner une image</label>
                  <div class="col-md-9">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                      <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                        <img src="<?PHP echo$_SESSION['profile_picture']; ?>" alt="" />
                      </div>
                      <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                      <div>
                        <span class="btn btn-theme02 btn-file">
                          <span class="fileupload-new"><i class="fa fa-paperclip"></i> Sélectionner une image</span>
                        <span class="fileupload-exists"><i class="fa fa-undo"></i> Modifier</span>
                        <input type="file" name="profile" class="default" />
                        </span>
                        <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Supprimer</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-3"></label>
                  <div class="col-md-4">
                    <input type="submit" value="Modifier" class="form-control" style="background: #337ab7; color: #fff;" />
                  </div>
                </div>
              </form>
            </div>
            <!-- /form-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
        <!-- row -->
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
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>
  <!--script for this page-->
  <script src="lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script type="text/javascript" src="lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
  <script type="text/javascript" src="lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <script type="text/javascript" src="lib/bootstrap-daterangepicker/moment.min.js"></script>
  <script type="text/javascript" src="lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
  <script src="lib/advanced-form-components.js"></script>

</body>

</html>
