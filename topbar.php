<style>
  /* Custom Styles for the Topbar */
  .navbar {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 0.3rem 1rem !important; /* Reduced padding */
    background: linear-gradient(135deg, #1a73e8, #1557b0) !important;
    height: 50px; /* Set a fixed height */
  }

  .logo {
    margin: auto;
    font-size: 18px; /* Reduced font size */
    background: white;
    padding: 8px 12px; /* Reduced padding */
    border-radius: 50%;
    color: #000000b3;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .logo:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .navbar .container-fluid {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 100%; /* Ensure container takes full height */
  }

  .navbar .text-white {
    font-size: 1rem; /* Reduced font size */
    font-weight: 600;
    color: white !important;
  }

  .dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 8px;
    color: white !important;
    text-decoration: none;
    transition: color 0.3s ease;
    font-size: 14px; /* Reduced font size */
  }

  .dropdown-toggle:hover {
    color: #f8f9fa !important;
  }

  .dropdown-menu {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    padding: 8px 0; /* Reduced padding */
    margin-top: 8px; /* Reduced margin */
  }

  .dropdown-item {
    padding: 6px 16px; /* Reduced padding */
    font-size: 13px; /* Reduced font size */
    color: #333;
    transition: all 0.3s ease;
  }

  .dropdown-item:hover {
    background: #1a73e8;
    color: white !important;
  }

  .dropdown-item i {
    margin-right: 8px;
  }

  /* Animation for the dropdown */
  @keyframes slideDown {
    0% {
      opacity: 0;
      transform: translateY(-10px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .dropdown-menu {
    animation: slideDown 0.3s ease;
  }
</style>

<nav class="navbar navbar-light fixed-top bg-primary" style="padding:0">
  <div class="container-fluid">
    <!-- Logo or System Name -->
    <div class="col-md-4 float-left text-white">
      <large><b><?php echo isset($_SESSION['system']['name']) ? $_SESSION['system']['name'] : 'My Application' ?></b></large>
    </div>

    <!-- User Menu -->
    <div class="float-right">
      <div class="dropdown mr-4">
        <a href="#" class="text-white dropdown-toggle" id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-user-circle"></i> <?php echo $_SESSION['login_name'] ?>
        </a>
        <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
          <a class="dropdown-item" href="javascript:void(0)" id="manage_my_account">
            <i class="fa fa-cog"></i> Manage Account
          </a>
          <a class="dropdown-item" href="ajax.php?action=logout">
            <i class="fa fa-power-off"></i> Logout
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<script>
  $('#manage_my_account').click(function() {
    uni_modal("Manage Account", "manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own");
  });
</script>