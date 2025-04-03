
    <!-- Content Header 1 (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Approval List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Approval List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- First Table Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
             <!--  <div class="card-header">
                <h3 class="card-title">DataTable with minimal features & hover style</h3>
              </div> -->
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Sl.No</th>
                          <th>Register Name</th>
                          <th>Mobile Number</th>
                          <th>Email</th>
                          <th>Date & Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <?php if (!empty($user_data)): ?>
                          <?php $i = 1; ?>
                          <?php foreach ($user_data as $r): ?>
                              <?php
                              // Check if the account type is 'User'
                              if ($r->account_type == 'user') {
                                  // Convert curr_date to Y-m-d format for comparison
                                  $currDate = (new DateTime($r->curr_date))->format('Y-m-d');
                                
                              ?>
                              <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $r->name; ?></td>
                                  <td><?php echo $r->mobile_no; ?></td>
                                  <td><?php echo $r->email; ?></td>
                                  <td>
                                    <?php 
                                    // Format date as 'd-m-Y'
                                    echo (new DateTime($r->curr_date))->format('d-m-Y'); 
                                    echo ' & ';
                                    // Create a DateTime object for the time
                                    $time = new DateTime($r->curr_time);
                                    // Format time as 'h:i A' (e.g., 01:30 PM)
                                    echo $time->format('h:i A'); 
                                    ?>
                                  </td>
                                  <td>
                                      <?php if ($r->status == 'confirmed'): ?>
                                          <button class="btn btn-sm btn-success custom-btn1">Confirmed</button>
                                      <?php else: ?>
                                          <a class="btn btn-sm btn confirm-btn" style="background-color: YellowGreen; color: white;" data-id="<?php echo $r->id; ?>">Confirm</a>
                                      <?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                      <a class="btn btn-sm btn" style="background-color: IndianRed; color: white;" onclick="setDeleteFunction('<?php echo $r->id; ?>')">Remove</a> 
                                  </td>
                              </tr>
                              <?php $i++; ?>
                              <?php } // End of the display check ?>   
                          <?php endforeach; ?>
                      <?php else: ?>
                          <tr>
                              <td colspan="7">No items found</td>
                          </tr>
                      <?php endif; ?>
                    </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

  <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Remove</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to remove this registration?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post" action="<?php echo base_url('welcome/removeUser')?>">
                        <input type="hidden" name="dlt_id" id="dlt_id">
                        <button type="button" class="btn btn-light" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-secondary">Yes,Remove</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    <!-- End Delete Modal -->

<!-- //--------------------------- Start JavaScript---------------------------// -->
<script>
$(document).ready(function() {
    $('.confirm-btn').on('click', function() {
        var userId = $(this).data('id');

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('welcome/ConfirmationEmail_user'); ?>/' + userId,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                   // location.reload();
                    // Update the status in the database
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('welcome/updateStatus_user'); ?>/' + userId,
                        dataType: 'json',
                        success: function(updateResponse) {
                            if (updateResponse.status === 'success') {
                                  location.reload();
                            } else {
                                alert('Failed to update status.');
                            }
                        }
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.log('Response:', xhr.responseText);
            }
        });
    });
});

     function setDeleteFunction(dlt_id){
       // alert(dlt_id)
      $('#dlt_id').val(dlt_id); 
      $('#deleteModal').modal('show');
    }
</script>

<!-- //---------------------------End JavaScript---------------------------// -->
 
