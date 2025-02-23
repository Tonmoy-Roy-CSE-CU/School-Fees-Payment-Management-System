<?php
include 'db_connect.php';
$id = $_GET['id'];
$payment = $conn->query("SELECT s.*, t.name as tname, t.id_no, t.email, t.contact, t.address 
                         FROM salary s 
                         INNER JOIN teacher t ON t.id = s.teacher_id 
                         WHERE s.id = $id");
$row = $payment->fetch_assoc();
?>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body" id="invoice-content"> <!-- Added ID for invoice content -->
                <!-- Invoice Header -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h2>Invoice</h2>
                        <p class="mb-0"><b>Invoice ID:</b> <?php echo "INV-" . str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></p>
                        <p class="mb-0"><b>Date:</b> <?php echo date("M d, Y", strtotime($row['payment_date'])); ?></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <h3>School Name</h3>
                        <p class="mb-0">123 School Street</p>
                        <p class="mb-0">City, State, ZIP</p>
                        <p class="mb-0">Phone: (123) 456-7890</p>
                        <p class="mb-0">Email: school@example.com</p>
                    </div>
                </div>
                <hr>

                <!-- Teacher Details -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4>Bill To:</h4>
                        <p class="mb-0"><b>Teacher Name:</b> <?php echo ucwords($row['tname']); ?></p>
                        <p class="mb-0"><b>Teacher ID:</b> <?php echo $row['id_no']; ?></p>
                        <p class="mb-0"><b>Email:</b> <?php echo $row['email']; ?></p>
                        <p class="mb-0"><b>Contact:</b> <?php echo $row['contact']; ?></p>
                        <p class="mb-0"><b>Address:</b> <?php echo $row['address']; ?></p>
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Salary Payment for <?php echo date("F Y", strtotime($row['payment_date'])); ?></td>
                                    <td class="text-right"><?php echo number_format($row['amount'], 2); ?></td>
                                </tr>
                                <tr>
                                    <th class="text-right">Total</th>
                                    <th class="text-right"><?php echo number_format($row['amount'], 2); ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Remarks -->
                <div class="row">
                    <div class="col-md-12">
                        <p><b>Remarks:</b> <?php echo $row['remarks']; ?></p>
                    </div>
                </div>

                <!-- Footer -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <p>Thank you for your service!</p>
                        <p><b>School Name</b></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer display">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="button" id="print_invoice"><i class="fa fa-print"></i> Print Invoice</button>
            </div>
        </div>
    </div>
</div>
<noscript>
    <!-- This is required for printing -->
    <style>
        body { font-family: Arial, sans-serif; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</noscript>
<script>
    $(document).ready(function() {
        // Hide the default modal footer (which contains Save and Cancel buttons)
        $('#uni_modal .modal-footer').hide();

        // Show the custom footer with Close and Print buttons
        $('.modal-footer.display').show();

        // Print functionality
        $('#print_invoice').click(function() {
            // Get only the invoice content
            var invoiceContent = $('#invoice-content').clone(); // Clone the invoice content
            var ns = $('noscript').clone(); // Clone the noscript element (for styles)
            ns.append(invoiceContent); // Append the invoice content to the noscript element

            // Open a new window for printing
            var nw = window.open('', '_blank', 'width=900,height=600');
            nw.document.write('<html><head><title>Invoice - <?php echo "INV-" . str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></title>');
            nw.document.write(ns.html()); // Write the content to the new window
            nw.document.write('</body></html>');
            nw.document.close();

            // Trigger the print dialog
            nw.print();

            // Close the new window after printing
            setTimeout(() => {
                nw.close();
            }, 500);
        });
    });
</script>