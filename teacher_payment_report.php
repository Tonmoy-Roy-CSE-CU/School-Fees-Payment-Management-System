<?php
include 'db_connect.php';
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card_body">
                <div class="row justify-content-center pt-4">
                    <label for="" class="mt-2">Month</label>
                    <div class="col-sm-3">
                        <input type="month" name="month" id="month" value="<?php echo $month ?>" class="form-control">
                    </div>
                </div>
                <hr>
                <div class="col-md-12">
                    <table class="table table-bordered" id='report-list'>
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="">Date</th>
                                <th class="">Teacher ID</th>
                                <th class="">Teacher Name</th>
                                <th class="">Paid Amount</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total = 0;
                            $payments = $conn->query("SELECT s.*, t.name as tname, t.id_no 
                                                     FROM salary s 
                                                     INNER JOIN teacher t ON t.id = s.teacher_id 
                                                     WHERE date_format(s.payment_date, '%Y-%m') = '$month' 
                                                     ORDER BY s.payment_date ASC");
                            if ($payments->num_rows > 0) :
                                while ($row = $payments->fetch_array()) :
                                    $total += $row['amount'];
                            ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++; ?></td>
                                        <td>
                                            <p><b><?php echo date("M d, Y H:i A", strtotime($row['payment_date'])); ?></b></p>
                                        </td>
                                        <td>
                                            <p><b><?php echo $row['id_no']; ?></b></p>
                                        </td>
                                        <td>
                                            <p><b><?php echo ucwords($row['tname']); ?></b></p>
                                        </td>
                                        <td class="text-right">
                                            <p><b><?php echo number_format($row['amount'], 2); ?></b></p>
                                        </td>
                                        <td>
                                            <p><b><?php echo $row['remarks']; ?></b></p>
                                        </td>
                                    </tr>
                            <?php
                                endwhile;
                            else :
                            ?>
                                <tr>
                                    <th class="text-center" colspan="6">No Data.</th>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th class="text-right"><?php echo number_format($total, 2); ?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <hr>
                    <div class="col-md-12 mb-4">
                        <center>
                            <button class="btn btn-success btn-sm col-sm-3" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<noscript>
    <style>
        table#report-list {
            width: 100%;
            border-collapse: collapse;
        }
        table#report-list td, table#report-list th {
            border: 1px solid;
        }
        p {
            margin: unset;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
    </style>
</noscript>
<script>
    $('#month').change(function() {
        location.replace('index.php?page=teacher_payment_report&month=' + $(this).val());
    });

    $('#print').click(function() {
        var _c = $('#report-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c);
        var nw = window.open('', '_blank', 'width=900,height=600');
        nw.document.write('<p class="text-center"><b>Teacher Salary Payment Report as of <?php echo date("F, Y", strtotime($month)) ?></b></p>');
        nw.document.write(ns.html());
        nw.document.close();
        nw.print();
        setTimeout(() => {
            nw.close();
        }, 500);
    });
</script>