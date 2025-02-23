<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Summary Box Styling */
        .summary-box {
            padding: 20px;
            border-radius: 10px;
            color: white;
            position: relative;
            text-align: center;
            min-height: 120px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .summary-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .summary-box i {
            font-size: 3rem;
            position: absolute;
            right: 20px;
            top: 20px;
            opacity: 0.7;
        }
        .summary-box h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: bold;
        }
        .summary-box p {
            font-size: 1.2rem;
            margin: 5px 0 0;
        }

        /* Card Styling */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }
        .card-header {
            background-color: #343a40;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <h2>Welcome back, <?php echo $_SESSION['login_name']; ?>!</h2>
    <hr>

    <div class="row">
        <!-- Total Students -->
        <div class="col-md-3">
            <div class="summary-box bg-primary">
                <h3>
                    <?php
                        $student_count = $conn->query("SELECT COUNT(*) FROM student")->fetch_row()[0];
                        echo $student_count;
                    ?>
                </h3>
                <p>Total Students</p>
                <i class="fas fa-users"></i>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="col-md-3">
            <div class="summary-box bg-info">
                <h3>
                    <?php
                        $teacher_count = $conn->query("SELECT COUNT(*) FROM teacher")->fetch_row()[0];
                        echo $teacher_count;
                    ?>
                </h3>
                <p>Total Teachers</p>
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>

        <!-- Total Courses -->
        <div class="col-md-3">
            <div class="summary-box bg-secondary">
                <h3>
                    <?php
                        $course_count = $conn->query("SELECT COUNT(*) FROM courses")->fetch_row()[0];
                        echo $course_count;
                    ?>
                </h3>
                <p>Total Courses</p>
                <i class="fas fa-book"></i>
            </div>
        </div>

        <!-- Pending Fees -->
        <div class="col-md-3">
            <div class="summary-box bg-danger">
                <h3>
                    <?php
                        $total_fees = $conn->query("SELECT SUM(total_fee) FROM student_ef_list")->fetch_row()[0] ?? 0;
                        $total_paid = $conn->query("SELECT SUM(amount) FROM payments")->fetch_row()[0] ?? 0;
                        $pending_fees = $total_fees - $total_paid;
                        echo "$" . number_format(max($pending_fees, 0), 0);
                    ?>
                </h3>
                <p>Pending Fees</p>
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Overall Income -->
        <div class="col-md-3">
            <div class="summary-box bg-success">
                <h3>
                    <?php
                        $overall_income = $conn->query("SELECT SUM(amount) FROM payments")->fetch_row()[0] ?? 0;
                        echo "৳" . number_format($overall_income, 0);
                    ?>
                </h3>
                <p>Overall Income</p>
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>

        <!-- Monthly Income -->
        <div class="col-md-3">
            <div class="summary-box bg-warning">
                <h3>
                    <?php
                        $current_month = date('Y-m'); 
                        $monthly_income = $conn->query("SELECT SUM(amount) FROM payments WHERE DATE_FORMAT(date_created, '%Y-%m') = '$current_month'")->fetch_row()[0] ?? 0;
                        echo "৳" . number_format($monthly_income, 0);
                    ?>
                </h3>
                <p>Monthly Income</p>
                <i class="fas fa-calendar-alt"></i>
            </div>
        </div>

        <!-- Yearly Income -->
        <div class="col-md-3">
            <div class="summary-box bg-primary">
                <h3>
                    <?php
                        $current_year = date('Y'); 
                        $yearly_income = $conn->query("SELECT SUM(amount) FROM payments WHERE YEAR(date_created) = '$current_year'")->fetch_row()[0] ?? 0;
                        echo "৳" . number_format($yearly_income, 0);
                    ?>
                </h3>
                <p>Yearly Income</p>
                <i class="fas fa-chart-line"></i>
            </div>
        </div>

        <!-- Total Teacher Salary Payments -->
        <div class="col-md-3">
            <div class="summary-box bg-info">
                <h3>
                    <?php
                        $total_salary = $conn->query("SELECT SUM(amount) FROM salary")->fetch_row()[0] ?? 0;
                        echo "৳" . number_format($total_salary, 0);
                    ?>
                </h3>
                <p>Total Salary Paid</p>
                <i class="fas fa-money-bill-wave"></i>
            </div>
        </div>
    </div>

    <!-- Monthly Income Bar Chart -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Monthly Income (Last 12 Months)</h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyIncomeBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart for Students Per Course -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Students Per Course</h5>
                </div>
                <div class="card-body">
                    <canvas id="studentPieChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart for Teacher Salary Payments -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Teacher Salary Payments</h5>
                </div>
                <div class="card-body">
                    <canvas id="teacherSalaryPieChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Fetch data for Students Per Course Pie Chart
$query = "SELECT courses.course AS course_name, COUNT(student_ef_list.student_id) AS student_count 
          FROM student_ef_list 
          JOIN courses ON student_ef_list.course_id = courses.id 
          GROUP BY courses.id 
          LIMIT 25";
$result = $conn->query($query);
$course_names = [];
$student_counts = [];
while ($row = $result->fetch_assoc()) {
    $course_names[] = $row['course_name'];
    $student_counts[] = $row['student_count'];
}

// Fetch data for Teacher Salary Payments Pie Chart
$salary_query = "SELECT t.name AS teacher_name, SUM(s.amount) AS total_salary 
                 FROM salary s 
                 JOIN teacher t ON s.teacher_id = t.id 
                 GROUP BY t.id 
                 LIMIT 25";
$salary_result = $conn->query($salary_query);
$teacher_names = [];
$salary_amounts = [];
while ($row = $salary_result->fetch_assoc()) {
    $teacher_names[] = $row['teacher_name'];
    $salary_amounts[] = $row['total_salary'];
}

// Fetch data for Monthly Income Bar Chart (Last 12 Months)
$monthly_income_query = "SELECT DATE_FORMAT(date_created, '%Y-%m') AS month, SUM(amount) AS total_income 
                         FROM payments 
                         WHERE date_created >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                         GROUP BY month 
                         ORDER BY month ASC";
$monthly_income_result = $conn->query($monthly_income_query);
$months = [];
$monthly_incomes = [];
while ($row = $monthly_income_result->fetch_assoc()) {
    $months[] = $row['month'];
    $monthly_incomes[] = $row['total_income'];
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Students Per Course Pie Chart
        var ctx1 = document.getElementById("studentPieChart").getContext("2d");
        new Chart(ctx1, {
            type: "pie",
            data: {
                labels: <?php echo json_encode($course_names); ?>,
                datasets: [{
                    data: <?php echo json_encode($student_counts); ?>,
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4CAF50", "#9966FF", "#FF9F40"]
                }]
            }
        });

        // Teacher Salary Payments Pie Chart
        var ctx2 = document.getElementById("teacherSalaryPieChart").getContext("2d");
        new Chart(ctx2, {
            type: "pie",
            data: {
                labels: <?php echo json_encode($teacher_names); ?>,
                datasets: [{
                    data: <?php echo json_encode($salary_amounts); ?>,
                    backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4CAF50", "#9966FF", "#FF9F40"]
                }]
            }
        });

        // Monthly Income Bar Chart
        var ctx3 = document.getElementById("monthlyIncomeBarChart").getContext("2d");
        new Chart(ctx3, {
            type: "bar",
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: "Monthly Income",
                    data: <?php echo json_encode($monthly_incomes); ?>,
                    backgroundColor: "#36A2EB",
                    borderColor: "#36A2EB",
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "Amount (৳)"
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: "Month"
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>