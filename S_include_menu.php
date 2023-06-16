    <!--sidebar start-->
    <aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="index.php"><img src="<?PHP echo$_SESSION['profile_picture']; ?>" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?PHP echo$_SESSION['nom']; ?></h5>
          <li class="mt">
            <a href="Dashboard_user.php">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>
          <li>
            <a href="panels.php">
              <i class="fa fa-map-marker"></i>
              <span>Prise de rendez-vous</span>
              </a>
          </li>
          <li>
            <a href="advanced_form_components.php">
              <i class="fa fa-map-marker"></i>
              <span> Paramètre </span>
              </a>
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
    </aside>
    <!--sidebar end-->