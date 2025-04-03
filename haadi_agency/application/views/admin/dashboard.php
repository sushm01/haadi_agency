<!-- <?php 
$totalVendor = 0; // Initialize the totalVendor variable
?>

<?php if ($getUserVendor !== null && $getUserVendor->num_rows() > 0): ?>
    <?php $i = 1; ?>
    <?php foreach ($getUserVendor->result() as $r): ?>
        <?php if ($r->account_type == 'Vendor' && $r->status == 'confirm'): ?>
            <?php $totalVendor++; // Increment the totalVendor count ?>
        <?php endif; ?>
        <?php $i++; ?>
    <?php endforeach; ?>
<?php else: ?>
<?php endif; ?>

<?php 
$totalUser = 0; // Initialize the totalUser variable
?>

<?php if ($getUserVendor !== null && $getUserVendor->num_rows() > 0): ?>
    <?php $i = 1; ?>
    <?php foreach ($getUserVendor->result() as $r): ?>
        <?php if ($r->account_type == 'User' && $r->status == 'confirm'): ?>
            <?php $totalUser++; // Increment the totalUser count ?>
        <?php endif; ?>
        <?php $i++; ?>
    <?php endforeach; ?>
<?php else: ?>
<?php endif; ?>

<?php
$totalOrders = 0; // Initialize the counter

if ($getUserOrder !== null && $getUserOrder->num_rows() > 0):
    $i = 1;
    foreach ($getUserOrder->result() as $r):
        if ($r->status == 'confirm'):
            $totalOrders++; // Increment the count for confirmed orders
        endif;
        $i++;
    endforeach;
else:
    $totalOrders = 0; // Set to 0 if no orders are found
endif;
?> -->
<style>
    .blink {
    animation: blinker 1s step-start infinite;
}

@keyframes blinker {
    50% {
        opacity: 0;
    }
}

  #successMessage {
        background-color: green; /* Change to your desired color */
        border-color: green;
        color: #ffffff; /* Change to your desired text color */
    /*    //max-height: 350px;*/
        max-width: 350px;
        font-size: 16px; /* Change to your desired font size */
        padding: 10px 20px; /* Adjust padding as needed */
        margin-bottom: 20px; /* Adjust margin as needed */
    }
  </style>
<!-- fisrt Content Wrapper. Contains page content -->
  <?php if ($this->session->flashdata('success_message')) { ?>
        <div id="successMessage" class="alert alert-success">
            <?php echo $this->session->flashdata('success_message'); ?>
        </div>
    <?php } ?>
  <!-- Content Header (Page header) -->
  <!-- <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">ORDER LIST</h1>
        </div>
      </div>
    </div>
  </div> -->
  <!-- /.content-header -->
 <!-- fisrt content -->
 <!--  <section class="content">
    <div class="container-fluid">

      <div class="row">
           <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <a class="btn btn-app bg-blue" href="<?php echo base_url('order-list'); ?>">  
              <?php if ($totalOrders > 0): ?>
                <span class="badge bg-yellow blink">New</span>
              <?php endif; ?><i class="fas fa-shopping-cart"></i></a>
              <div class="info-box-content">
                <span class="info-box-text"><?php echo $totalOrders; ?> New Orders</span>
              </div>
  
            </div>

          </div>
        </div>
      </div>
    </section>
 -->

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">USER</h1>
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    
  </div>
  <!-- /.content-header -->
  <!-- fisrt content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <a class="btn btn-app bg-success" href="<?php echo base_url('admin-user-approval'); ?>">
                <?php if ($totalUser > 0): ?>
                <span class="badge bg-yellow blink"><?php echo $totalUser; ?></span>
                <?php endif; ?><i class="fas fa-users"></i></a>
              <div class="info-box-content">
                <span class="info-box-text">New Users</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        <!-- fix for small devices only --> 
        <!-- <div class="clearfix hidden-md-up"></div> -->
        <!-- <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <a class="info-box-icon bg-danger elevation-1" href="<?php echo base_url('admin-user-list'); ?>" ><i class="fas fa-calculator"></i></a>
              <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number"></span>
              </div>
            </div>
          </div> -->
        <!-- /.col -->
        </div>
      </div>
    </section> 


<script>
  //---------------------Closing flash message autometically-----------------------------//
     $(document).ready(function() {
        // Set a timeout to hide the success message after 5 seconds (adjust as needed)
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
        }, 2000); // 2000 milliseconds = 2 seconds
    });
</script>