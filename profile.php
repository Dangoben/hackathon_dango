<?php 
SESSION_START();
include('connect_data.php');

if (isset($_SESSION['ID_connect_hackthon']) AND $_SESSION['ID_connect_hackthon']=='Rendez-vous-project9989' ) {
  
    if (isset($_GET['profile'])) {
        $profile=htmlspecialchars($_GET['profile']);
        $membre_existe = $bdd->prepare('SELECT * FROM membre WHERE id = :id ');
        $membre_existe->execute(array('id' => $profile));
        $res_membre_existe = $membre_existe->fetch();

        if (empty($res_membre_existe['id'])) {
          $reponse =  'Utilisateur non existant';
          header("location:panels.php?aff_reponse_fausse=".$reponse);
        }
    }
    else{
      $reponse =  'Sélectionner un utilisateur';
      header("location:panels.php?aff_reponse_fausse=".$reponse);
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
  <!--external css-->
  <link href="lib/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet">
  <link href="css/style-responsive.css" rel="stylesheet">

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


          <?php
          $user__ = ''; // Initialise la variable $user__

          if (isset($res_membre_existe['id']) && !empty($res_membre_existe['id'])) {
              $user__ = 'user_receveur';
          } else {
              $user__ = 'user_demandeur';
          }


          $events = array();

          $EventSelect = $bdd->prepare('SELECT * FROM rdv WHERE '.$user__.' = :id ORDER BY ID DESC');
          $EventSelect->execute(array('id' => $res_membre_existe['id'] ));

          while ($res_EventSelect = $EventSelect->fetch()) {
              $start = new DateTime($res_EventSelect['date_debut']);
              $end = new DateTime($res_EventSelect['date_fin']);
              
              $events[] = array(
                  'title' => $res_EventSelect['titre'],
                  'start' => $start->format('Y, n-1, j'), // Utilisez format() pour formater la date au format requis
                  'end' => $end->format('Y, n-1, j') // Utilisez format() pour formater la date au format requis
              );
          }

          ?>          
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
                <p>
                  <button class="btn btn-theme">
                    <a href="#calendar" style="color: #fff;"><i class="fa fa-calendar-o"></i> Prise de rendez-vous</a>
                  </button>
                </p>
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


          <!-- page start-->
          <div class="row mt" style="display: inline-block;">
            <aside class="col-lg-3 mt">
              <h4><i class="fa fa-angle-right"></i>Ces rendez-vous confirmé</h4>
              <div id="external-events">
                <?php 
                  $EventSelect = $bdd->prepare('SELECT * FROM rdv WHERE user_receveur = :id AND statu="confirme" ORDER BY ID DESC');
                  $EventSelect->execute(array('id' => $res_membre_existe['id'] ));
                  while($res_EventSelect = $EventSelect->fetch()) {
                ?>
                <div class="external-event label label-theme"><?PHP echo$res_EventSelect['titre']; ?></div>
                <?PHP 
                  }
                ?>
                <!-- <p class="drop-after">
                  <input type="checkbox" id="drop-remove"> Remove After Drop
                </p> -->
              </div>
            </aside>
            <aside class="col-lg-9 mt">
              <section class="panel">
                <div class="panel-body">
                  <div id="calendar" class="has-toolbar"></div>
                </div>
              </section>
            </aside>

            <!-- Form de prise de rendez-vous -->
            <div id="popupForm" style="display: none;">
              <form id="myForm" action="S_ajout_rendez_vous.php" method="post" >
                <input type="hidden" name="user_demandeur" value="<?PHP echo$_SESSION['id']; ?>" required>
                <input type="hidden" name="user_receveur" value="<?PHP echo$res_membre_existe['id']; ?>" required>
                <input type="hidden" name="user_receveur_mail" value="<?PHP echo$res_membre_existe['mail']; ?>" required>

                <label for="selectedDate">Date début :</label>
                <input type="date" id="selectedDate" name="datebegin" required>
                <br>

                <label for="heure"> Heure début :</label>
                <input type="text" id="heure" name="time_begin" required>
                <br>

                <label for="date_end"> Date fin :</label>
                <input type="date" id="date_end" name="date_end" required>
                <br>

                <label for="time_end"> Heure fin :</label>
                <input type="time" id="heure" name="time_end" required>
                <br>

                <label for="titre"> Titre :</label>
                <input type="text" id="titre" name="titre" required>
                <br>

                <label for="additionalInfo">Note :</label>
                <textarea name="note" required></textarea>
                <br>

                <button class="butt_sub" type="submit">Envoyer</button>
              </form>
            </div>


          </div>
          <!-- page end-->

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
  <!--script for this page-->
<!--   <script src="lib/calendar-conf-events.js"></script>
 -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

  <script type="text/javascript">
    var Script = function () {
    /* initialize the external events
     -----------------------------------------------------------------*/
    $('#external-events div.external-event').each(function() {
        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
            zIndex: 999,
            revert: true,      // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
        });
    });

    /* initialize the calendar
     -----------------------------------------------------------------*/
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar !!!
        drop: function(date, allDay) { // this function is called when something is dropped
            // retrieve the dropped element's stored Event Object
            var originalEventObject = $(this).data('eventObject');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            copiedEventObject.allDay = allDay;
            // render the event on the calendar
            // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
            $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        },
        events: <?php echo json_encode($events); ?>,
        dayClick: function(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');
            var selectedDate = year + '-' + month + '-' + day;

            // alert(selectedDate);

            $("#selectedDate").val(selectedDate);
            var x = document.getElementById("popupForm");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }

            $("#popupForm").dialog("open");
        }
    });
}();

  </script>

</body>

</html>
