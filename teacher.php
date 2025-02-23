<?php include('db_connect.php'); ?>
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.3); /* IE */
        -moz-transform: scale(1.3); /* FF */
        -webkit-transform: scale(1.3); /* Safari and Chrome */
        -o-transform: scale(1.3); /* Opera */
        transform: scale(1.3);
        padding: 10px;
        cursor: pointer;
    }
</style>
<div class="container-fluid">
    <div class="col-lg-12">
        <div class="row mb-4 mt-4">
            <div class="col-md-12">
                <!-- You can add additional content here if needed -->
            </div>
        </div>
        <div class="row">
            <!-- Table Panel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>List of Teachers</b>
                        <span class="float:right">
                            <a class="btn btn-primary btn-block btn-sm col-sm-2 float-right" href="javascript:void(0)" id="new_teacher">
                                <i class="fa fa-plus"></i> New
                            </a>
                        </span>
                    </div>
                    <div class="card-body">
                        <table class="table table-condensed table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="">ID No.</th>
                                    <th class="">Name</th>
                                    <th class="">Information</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                $teacher = $conn->query("SELECT * FROM teacher ORDER BY name ASC");
                                while ($row = $teacher->fetch_assoc()) :
                                ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <td>
                                            <p><b><?php echo $row['id_no'] ?></b></p>
                                        </td>
                                        <td>
                                            <p><b><?php echo ucwords($row['name']) ?></b></p>
                                        </td>
                                        <td class="">
                                            <p><small>Email: <i><b><?php echo $row['email'] ?></i></small></p>
                                            <p><small>Contact #: <i><b><?php echo $row['contact'] ?></i></small></p>
                                            <p><small>Address: <i><b><?php echo $row['address'] ?></i></small></p>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary edit_teacher" type="button" data-id="<?php echo $row['id'] ?>">Edit</button>
                                            <button class="btn btn-sm btn-outline-danger delete_teacher" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
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
    $(document).ready(function() {
        $('table').dataTable();
    });

    $('#new_teacher').click(function() {
        uni_modal("New Teacher", "manage_teacher.php", "mid-large");
    });

    $('.edit_teacher').click(function() {
        uni_modal("Manage Teacher Details", "manage_teacher.php?id=" + $(this).attr('data-id'), "mid-large");
    });

    $('.delete_teacher').click(function() {
        _conf("Are you sure you want to delete this Teacher?", "delete_teacher", [$(this).attr('data-id')]);
    });

    function delete_teacher($id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_teacher',
            method: 'POST',
            data: {
                id: $id
            },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>