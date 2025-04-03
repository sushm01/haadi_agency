
    <style>
        .content-wrapper {
            background-color: white;
        }
        .table-container {
            display: flex;
            justify-content: space-between;
            gap: 20px; /* Adjust gap as needed */
        }
        .table-card {
            flex: 1; /* Make sure each card takes equal space */
            margin: 10px; /* Optional margin around cards */
        }
    </style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Order Manegement</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('')?>">Home</a></li>
                        <li class="breadcrumb-item active">Order Manegement</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

            <!-- /.card -->
   <div class="col-md-12">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card card-outline custom-outline">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>O.Bill No</th>
                    <th>O.Date</th>
                    <th>O.User Name</th>
                    <th>Action</th>
                  </tr>
                  </thead>
              <tbody>
    <?php 
    $confirmed_orders = $this->Main_model->get_confirmed_orders();
    if ($purchase_data !== null && $purchase_data->num_rows() > 0): ?>
        <?php $i = 1; ?>
        <?php foreach ($purchase_data->result() as $r): ?>
            <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $r->bill_no ?></td>
                <td><?php echo $r->date ?></td>
                <td><?php echo $r->user_name ?></td>
                <td>
                    <a href="<?php echo base_url('welcome/view_details/'.$r->id); ?>" 
   class="btn btn-sm btn-info <?php echo in_array($r->bill_no, $confirmed_orders) ? 'disabled' : ''; ?>" 
   <?php echo in_array($r->bill_no, $confirmed_orders) ? 'aria-disabled="true" tabindex="-1"' : ''; ?>>
    View Details
</a>

                </td>
                <td>
                    <input type="checkbox" class="order-confirm" data-bill-no="<?php echo $r->bill_no; ?>" disabled 
                        <?php echo in_array($r->bill_no, $confirmed_orders) ? 'checked' : ''; ?> />
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">No products found</td>
        </tr>
    <?php endif; ?>
</tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
