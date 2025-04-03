<!-- Content Wrapper. Contains page content -->
  
     <?php if ($this->session->flashdata('success_message')) { ?>
        <div id="successMessage" class="alert alert-success">
            <?php echo $this->session->flashdata('success_message'); ?>
        </div>
    <?php } ?>

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
        max-width: 450px;
        font-size: 16px; /* Change to your desired font size */
        padding: 10px 20px; /* Adjust padding as needed */
        margin-bottom: 20px; /* Adjust margin as needed */
    }
  </style>

  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h1 class="m-0">Dashboard</h1> -->
        </div>
      </div>
    </div>
  </div> 
  <!-- /.content-header -->

  <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
      <!-- Welcome Message -->
      <p style="font-weight: bold; font-size: 24px;">
        <?php if (isset($user_name)): ?>
        <?php echo htmlspecialchars($user_name); ?>!
        <?php else: ?>
          Hello, User!
        <?php endif; ?>
      </p>
      </div>

      <!-- Second content section -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-4">
          <a href="<?php echo base_url('confirmed-details'); ?>" class="info-box">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Confirmed Order List</span>
            </div>
          </a>
        </div>
      </div>
  </section>
  <!-- /.content -->

<!-- /.content-wrapper -->

<script>
  //---------------------Closing flash message autometically-----------------------------//
     $(document).ready(function() {
        // Set a timeout to hide the success message after 5 seconds (adjust as needed)
        setTimeout(function() {
            $('#successMessage').fadeOut('slow');
        }, 2000); // 2000 milliseconds = 2 seconds
    });
</script>
