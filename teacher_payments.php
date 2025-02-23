<?php include 'db_connect.php'; ?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <!-- Additional content can go here -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Teacher Payments</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_payment">
                                <i class="fa fa-plus"></i> New Payment
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover" id="payment-list">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">Date</th>
                                    <th class="">Teacher ID</th>
                                    <th class="">Teacher Name</th>
                                    <th class="">Paid Amount</th>
                                    <th class="">Remarks</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $payments = $conn->query("
                                    SELECT p.*, t.name AS teacher_name, t.id_no 
                                    FROM salary p 
                                    INNER JOIN teacher t ON p.teacher_id = t.id 
                                    ORDER BY p.payment_date DESC
                                ");
                                if ($payments->num_rows > 0):
                                    while ($row = $payments->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td>
                                        <p><b><?php echo date("M d, Y", strtotime($row['payment_date'])); ?></b></p>
                                    </td>
                                    <td>
                                        <p><b><?php echo $row['id_no']; ?></b></p>
                                    </td>
                                    <td>
                                        <p><b><?php echo ucwords($row['teacher_name']); ?></b></p>
                                    </td>
                                    <td class="text-right">
                                        <p><b><?php echo number_format($row['amount'], 2); ?></b></p>
                                    </td>
                                    <td>
                                        <p><b><?php echo $row['remarks']; ?></b></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary view_payment" type="button" data-id="<?php echo $row['id']; ?>">View</button>
                                        <button class="btn btn-sm btn-outline-primary edit_payment" type="button" data-id="<?php echo $row['id']; ?>">Edit</button>
                                        <button class="btn btn-sm btn-outline-danger delete_payment" type="button" data-id="<?php echo $row['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                else:
                                ?>
                                <tr>
                                    <th class="text-center" colspan="7">No data.</th>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    td {
        vertical-align: middle !important;
    }
    td p {
        margin: unset;
    }
    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>
<script>
    $(document).ready(function(){
        $('table').dataTable();
    });

    $('#new_payment').click(function(){
        uni_modal("New Payment", "manage_teacher_payment.php", "mid-large");
    });

    $('.view_payment').click(function(){
        uni_modal("Payment Details", "teacher_view_payment.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.edit_payment').click(function(){
        uni_modal("Edit Payment", "manage_teacher_payment.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_payment').click(function(){
        _conf("Are you sure to delete this payment?", "delete_payment", [$(this).attr('data-id')]);
    });

    $('#print_report').click(function(){
        var _c = $('#payment-list').clone();
        var ns = $('noscript').clone();
        ns.append(_c);
        var nw = window.open('', '_blank', 'width=900,height=600');
        nw.document.write('<p class="text-center"><b>Teacher Payment Report</b></p>');
        nw.document.write(ns.html());
        nw.document.close();
        nw.print();
        setTimeout(() => {
            nw.close();
        }, 500);
    });

    function delete_payment($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_salary',
            method: 'POST',
            data: { id: $id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>