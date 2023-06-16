<?php 
SESSION_START();
include('connect_data.php');

if (isset($_SESSION['ID_connect_hackthon']) AND $_SESSION['ID_connect_hackthon']=='Rendez-vous-project9989' ) {
  
    $membre_existe = $bdd->prepare('SELECT * FROM membre WHERE id = :id ');
    $membre_existe->execute(array('id' => $_SESSION['id']));
    $res_membre_existe = $membre_existe->fetch();

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
  <!--external css-->
  <link href="lib/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="calender/calendar.css">

  <!-- =======================================================
    Template Name: Dashio
    Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
    Author: TemplateMag.com
    License: https://templatemag.com/license/
  ======================================================= -->

  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
</head>

<body>
  <section id="container">
    <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
        <!-- Header -->
        <?PHP INCLUDE('S_include_header.php'); ?>
      
      <!--
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

        <div class="row mt">         
          <div class="col-lg-12">
            <div class="row content-panel">
              <div class="col-md-4 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                  <h4><?PHP echo$res_membre_existe['mail']; ?></h4>
                  <h6>E-mail</h6>
                  <h4><?PHP echo$res_membre_existe['tel']; ?></h4>
                  <h6>Téléphone</h6>
                  <h4><?PHP echo$res_membre_existe['adresse']; ?></h4>
                  <h6>Adresse</h6>
                </div>
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-4 profile-text">
                <h3><?PHP echo$res_membre_existe['nom']; ?></h3>
                <h6>Profession</h6>
                <p>Vous trouvez ici des informations sur moi, vous pouvez egalement prendre rendez-vous dans mon espace via le button</p>
                <br>
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-4 centered">
                <div class="profile-pic">
                  <p><img src="<?PHP echo$res_membre_existe['profile_picture']; ?>" class="img-circle"></p>
                </div>
              </div>
              <!-- /col-md-4 -->
            </div>
            <!-- /row -->
          </div>

          <div data-tab-content="2" style="margin: 20px; display: inline-block;">
            <h3>Vos rendez-vous confirmé</h3>
            <ul>
              <?php

                INCLUDE 'calender/Calendar.php';
                $calendar = new Calendar();
                $calendar_confirm=$bdd->prepare('SELECT * FROM rdv WHERE user_receveur=? AND statu="confirme" ');
                $calendar_confirm->execute(array($_SESSION['id']));
                while ($res_calendar_confirm=$calendar_confirm->fetch()) {
                  $titre=$res_calendar_confirm['titre'];
                  $date_debin=$res_calendar_confirm['date_debut'];
                  $calendar->add_event($titre, $date_debin, 1, 'blue');
                }
            
              ?>
              <div class="content home">
                <?=$calendar?>
              </div>
            </ul>
          </div>

          <!-- Gestion Des Stock -->
          <div class="col-lg-9 col-md-12">
            <h3>Demande en attente de validation</h3>
            <div class="panel panel-default">
            <div class="panel-body">
              <p class="gestion-p">Demande en attente de validation</p>
                <table class="table bootstrap-datatable countries">
                  <thead>
                    <tr>
                      <th>Nom complet</th>
                      <th>E-mail</th>
                      <th>Tel</th>
                      <th>Date de début & Heure</th>
                      <th>Date de fin & Heure</th>
                      <th>Titre</th>
                      <th>Notes</th>
                      <th>Action</th>
                      <th>Fait le</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $calendar_confirm_rdv=$bdd->prepare('SELECT *,DATE_FORMAT(dateposte, \'%y/%m/%d\') AS date_poste, DATE_FORMAT(dateposte, \'%H:%i\') AS time_poste FROM rdv WHERE user_receveur=? AND statu="attente"  ');
                    $calendar_confirm_rdv->execute(array($_SESSION['id']));
                    while ($res_calendar_confirm_rdv=$calendar_confirm_rdv->fetch()) {

                      $dem_confirm_rdv=$bdd->prepare('SELECT * FROM membre WHERE id=? ');
                      $dem_confirm_rdv->execute(array($res_calendar_confirm_rdv['user_demandeur']));
                      $res_dem_confirm_rdv=$dem_confirm_rdv->fetch();

                         $aujourdhuit=date('y/m/d');
                         $hier = new datetime('-1 day');
                         $hier->format('y/m/d');

                         if ($aujourdhuit==$res_calendar_confirm_rdv['date_poste']) {
                           $date_text='Ajourd\'huit, '.$res_calendar_confirm_rdv['time_poste'];
                         }
                         elseif($hier==$res_calendar_confirm_rdv['date_poste']) {
                           $date_text='Hier, '.$res_calendar_confirm_rdv['time_poste'];
                         }
                         else{
                           $date1=str_replace('/','-', $res_calendar_confirm_rdv['date_poste']);
                           setlocale(LC_TIME, "fr_FR" , "French");
                           $date_text=strftime(" %A %d %b", strtotime($date1));
                         }
                   ?>
                    <tr>
                      <td><?php echo$res_dem_confirm_rdv['nom']; ?></td>
                      <td><?php echo$res_dem_confirm_rdv['mail']; ?></td>
                      <td><?php echo$res_dem_confirm_rdv['tel']; ?></td>
                      <td><?php echo$res_calendar_confirm_rdv['date_debut'].' - '.$res_calendar_confirm_rdv['heure_debut']; ?></td>
                      <td><?php echo$res_calendar_confirm_rdv['date_fin'].' - '.$res_calendar_confirm_rdv['heure_fin']; ?></td>
                      <td><?php echo$res_calendar_confirm_rdv['titre']; ?></td>
                      <td><?php echo$res_calendar_confirm_rdv['notes']; ?></td>
                      <td>
                        <a href="S_edith_etat.php?rdv=<?php echo$res_calendar_confirm_rdv['id']; ?>&statu=confirme&user_demandeur=<?php echo$res_dem_confirm_rdv['id']; ?>" style="padding: 5px; background-color: blue; color: #fff; border-radius: 3px; display: block; margin: 3px;">Confirmé</a>  
                        <a href="S_edith_etat.php?rdv=<?php echo$res_calendar_confirm_rdv['id']; ?>&statu=annuler&user_demandeur=<?php echo$res_dem_confirm_rdv['id']; ?>" style="padding: 5px; background-color: blue; color: #fff; border-radius: 3px; display: block; margin: 3px;" >Annuler</a>  
                      </td>
                      <td><?php echo$date_text; ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <!-- /row -->
        </div>
        <!-- /container -->

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
   <script src="lib/calendar-conf-events.js"></script>
   <script src="lib/fullcalendar/fullcalendar.min.js"></script>

  <!-- MAP SCRIPT - ALL CONFIGURATION IS PLACED HERE - VIEW OUR DOCUMENTATION FOR FURTHER INFORMATION -->
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
  <script>
    $('.contact-map').click(function() {

      //google map in tab click initialize
      function initialize() {
        var myLatlng = new google.maps.LatLng(40.6700, -73.9400);
        var mapOptions = {
          zoom: 11,
          scrollwheel: false,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Dashio Admin Theme!'
        });
      }
      google.maps.event.addDomListener(window, 'click', initialize);
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
  $('#heure').timepicker({
    timeFormat: 'HH:mm',
    interval: 15, // Définissez l'intervalle de temps en minutes
    dropdown: true,
    scrollbar: true
  });
});
  </script>

  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/jquery-ui-1.9.2.custom.min.js"></script>
  <script src="lib/fullcalendar/fullcalendar.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <!--common script for all pages-->
  <script src="lib/common-scripts.js"></script>

</body>

</html>
