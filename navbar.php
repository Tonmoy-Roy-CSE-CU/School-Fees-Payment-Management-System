<style>
    /* Sidebar Styling */
    nav#sidebar {
        background: linear-gradient(180deg, #1b1b32 0%, #0f0f23 100%); /* Gradient Navy */
        height: 100vh;
        overflow-y: auto; /* Enables scrolling */
        scrollbar-width: thin;
        scrollbar-color: #00adb5 #1b1b32;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3); /* Subtle shadow for depth */
    }

    /* Custom Scrollbar */
    nav#sidebar::-webkit-scrollbar {
        width: 6px;
    }

    nav#sidebar::-webkit-scrollbar-thumb {
        background: #00adb5; /* Cyan */
        border-radius: 4px;
    }

    nav#sidebar::-webkit-scrollbar-track {
        background: #1b1b32;
    }

    /* Sidebar List */
    .sidebar-list {
        padding: 20px 0;
    }

    .nav-item {
        display: flex;
        align-items: center;
        color: #dcdcdc;
        padding: 12.2px 25px;
        text-decoration: none;
        transition: all 0.3s ease-in-out;
        font-size: 10px;
        font-weight: 300;
        border-radius: 5px;
        position: relative;
        margin: 4px 8px;
    }

    /* Hover Effect */
    .nav-item:hover {
        background: linear-gradient(90deg, #00adb5 0%, #008c9e 100%); /* Gradient Cyan */
        color: #ffffff;
        transform: translateX(10px); /* Smooth movement */
        box-shadow: 0 4px 8px rgba(0, 173, 181, 0.3); /* Glow effect */
    }

    /* Active Item */
    .nav-item.active {
        background: linear-gradient(90deg, #ff2e63 0%, #ff1a4a 100%); /* Gradient Pink */
        color: #ffffff;
        font-weight: bold;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(255, 46, 99, 0.4); /* Glow effect */
    }

    .icon-field {
        margin-right: 15px;
        font-size: 18px;
        transition: transform 0.3s ease-in-out;
    }

    /* Icon animation on hover */
    .nav-item:hover .icon-field {
        transform: rotate(10deg); /* Slight rotation */
    }

    /* Section Titles */
    .mx-2 {
        font-size: 14px;
        font-weight: bold;
        color: #00adb5;
        margin-top: 20px;
        padding: 10px 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
        background: rgba(0, 173, 181, 0.1); /* Subtle background */
        border-radius: 5px;
        margin: 15px 10px;
    }

    /* Subtle border for sections */
    .mx-2::after {
        content: '';
        display: block;
        width: 100%;
        height: 1px;
        background: rgba(0, 173, 181, 0.2);
        margin-top: 10px;
    }
</style>

<nav id="sidebar" class='mx-lt-5'>
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
        <div class="mx-2">Master List</div>
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
        <div class="mx-2">Report</div>
        <a href="index.php?page=teacher_payment_report" class="nav-item nav-teacher_payment_report">
            <span class='icon-field'><i class="fa fa-file-invoice-dollar"></i></span> Teacher Salary Report
        </a>
        <a href="index.php?page=payments_report" class="nav-item nav-payments_report">
            <span class='icon-field'><i class="fas fa-donate"></i></span> Student Fees Report
        </a>

        <!-- System Settings (Visible Only for Admin) -->
        <div class="mx-2">Systems</div>
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