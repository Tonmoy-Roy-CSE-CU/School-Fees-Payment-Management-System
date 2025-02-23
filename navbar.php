<style>
    .collapse a {
        text-indent: 10px;
    }

    nav#sidebar {
        /* Uncomment and use this if you want a background image for the sidebar */
        /* background: url(assets/uploads/<?php echo $_SESSION['system']['cover_img'] ?>) !important */
    }
</style>

<nav id="sidebar" class='mx-lt-5 bg-dark'>
    <div class="sidebar-list">
        <!-- Dashboard -->
        <a href="index.php?page=home" class="nav-item nav-home">
            <span class='icon-field'><i class="fa fa-tachometer-alt"></i></span> Dashboard
        </a>
        
        <!-- Fees & Payments -->
        <a href="index.php?page=fees" class="nav-item nav-fees">
            <span class='icon-field'><i class="fa fa-money-check"></i></span> Enrollment & Fees A/C
        </a>
        <a href="index.php?page=payments" class="nav-item nav-payments">
            <span class='icon-field'><i class="fa fa-receipt"></i></span> Payment Transactions
        </a>

        <!-- Master List -->
        <div class="mx-2 text-white">Master List</div>
        <a href="index.php?page=courses" class="nav-item nav-courses">
            <span class='icon-field'><i class="fa fa-scroll"></i></span> Courses & Fees
        </a>
        <a href="index.php?page=students" class="nav-item nav-students">
            <span class='icon-field'><i class="fa fa-users"></i></span> Students
        </a>
        <a href="index.php?page=teacher" class="nav-item nav-teacher">
            <span class='icon-field'><i class="fa fa-chalkboard-teacher"></i></span> Teachers
        </a>

        <!-- Teacher Payments -->
        <a href="index.php?page=teacher_payments" class="nav-item nav-teacher_payments">
            <span class='icon-field'><i class="fa fa-dollar-sign"></i></span> Teacher Payments
        </a>

        <!-- Reports -->
		<!-- Reports -->
		<div class="mx-2 text-white">Report</div>
		<a href="index.php?page=teacher_payment_report" class="nav-item nav-teacher_payment_report">
    		<span class='icon-field'><i class="fa fa-file-invoice-dollar"></i></span> Teacher Salary Report
		</a>
		<a href="index.php?page=payments_report" class="nav-item nav-payments_report">
			<span class='icon-field'><i class="fa fa-receipt"></i></span> Student Fees Report
		</a>



        <!-- System Settings (Visible Only for Admin) -->
        <div class="mx-2 text-white">Systems</div>
        <?php if ($_SESSION['login_type'] == 1) : ?>
            <a href="index.php?page=users" class="nav-item nav-users">
                <span class='icon-field'><i class="fa fa-users"></i></span> Users
            </a>
        <?php endif; ?>
    </div>
</nav>

<script>
    // Handle sidebar collapse actions
    $('.nav_collapse').click(function() {
        console.log($(this).attr('href'))
        $($(this).attr('href')).collapse()
    })
    
    // Highlight the active page in the sidebar
    $('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
