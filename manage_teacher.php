<?php
include('db_connect.php');

$id = isset($_GET['id']) ? $_GET['id'] : null;
$name = '';
$id_no = '';
$email = '';
$contact = '';
$address = '';

if ($id) {
    $result = $conn->query("SELECT * FROM teacher WHERE id = $id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $id_no = $row['id_no'];
        $email = $row['email'];
        $contact = $row['contact'];
        $address = $row['address'];
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <b><?php echo $id ? "Edit Teacher" : "New Teacher"; ?></b>
                </div>
                <div class="card-body">
                    <form id="manage_teacher">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="id_no">ID No.</label>
                            <input type="text" class="form-control" id="id_no" name="id_no" value="<?php echo $id_no; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="contact">Contact #</label>
                            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $contact; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" required><?php echo $address; ?></textarea>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#manage_teacher').submit(function(e) {
            e.preventDefault();
            start_load();
            $.ajax({
                url: 'ajax.php?action=save_teacher',
                method: 'POST',
                data: $(this).serialize(),
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Data successfully saved.", 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        alert_toast("Error saving data.", 'error');
                        end_load();
                    }
                }
            });
        });
    });
</script>