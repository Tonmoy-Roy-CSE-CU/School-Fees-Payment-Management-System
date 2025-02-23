<?php include 'db_connect.php'; ?>

<?php
$payment = [];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM salary WHERE id = $id");
    if ($qry->num_rows > 0) {
        $payment = $qry->fetch_assoc();
    }
}
?>

<div class="container-fluid">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <b><?php echo isset($_GET['id']) ? "Edit" : "New"; ?> Teacher Payment</b>
            </div>
            <div class="card-body">
                <form id="manage-payment">
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>">
                    <div class="form-group">
                        <label for="teacher_id">Teacher</label>
                        <select class="form-control" id="teacher_id" name="teacher_id" required>
                            <option value="">Select Teacher</option>
                            <?php
                            $teachers = $conn->query("SELECT id, name FROM teacher WHERE delete_status = '0'");
                            while ($row = $teachers->fetch_assoc()):
                                $selected = isset($payment['teacher_id']) && $row['id'] == $payment['teacher_id'] ? 'selected' : '';
                            ?>
                                <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>><?php echo $row['name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" value="<?php echo isset($payment['amount']) ? $payment['amount'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="payment_date">Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" value="<?php echo isset($payment['payment_date']) ? $payment['payment_date'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3"><?php echo isset($payment['remarks']) ? $payment['remarks'] : ''; ?></textarea>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $('#manage-payment').submit(function(e) {
        e.preventDefault();
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_salary',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Payment saved successfully.", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                } else {
                    alert_toast("Error saving payment.", 'error');
                    end_load();
                }
            }
        });
    });
</script>