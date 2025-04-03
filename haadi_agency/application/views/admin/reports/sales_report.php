
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Report</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                      <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sl.No</th>
                    <th>Order.No</th>
                    <th>Order Date</th>
                    <th>User Name</th>
                    <th>Category</th>
                    <th>Items</th>
                    <th>Price</th>
                    <th>Requsted(QTY)</th>
                    <th>Taken(QTY)</th>
                    <th>Return(QTY)</th>
                    <th>Sales(QTY)</th>
                    <th>Line Total</th>
                    <th>Sales Date</th>
                    <!-- <th>Actions</th> -->
                  </tr>
                  </thead>
<tbody>
    <?php
    $total_lt = 0;
    // $total_sales = 0;
    // $total_taken = 0;
    // $total_return = 0;
    // $total_requested = 0;

    if (!empty($get_sales)): 
        $i = 1;
        foreach ($get_sales as $r): 
            if ($r->sales_total > 0): // Ensure only completed sales are displayed
                $total_lt += $r->sales_total;
    ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $r->bill_no; ?></td>
                <td><?php echo $r->created_at; ?></td>
                <td><?php echo $r->requested_name; ?></td>
                <td><?php echo $r->category; ?></td>
                <td><?php echo $r->items; ?></td>
                <td><?php echo $r->price; ?></td>
                <td><?php echo $r->qty; ?></td>
                <td><?php echo $r->quantity_stc; ?></td>
                <td><?php echo $r->return_qty; ?></td>
                <td><?php echo $r->sales; ?></td>
                <td><?php echo $r->sales_total; ?></td>
                <td><?php echo $r->sales_created_at; ?></td>
            </tr>
    <?php 
                $i++;
            endif;
        endforeach;
    else: 
    ?>
        <tr>
            <td colspan="13">No completed sales found</td>
        </tr>
    <?php endif; ?>
</tbody>

<tfoot>
    <tr>
        <td colspan="11" class="text-right"><strong>Total:</strong></td> 
        <td id="total_lt"><?php echo $total_lt; ?></td>
        <td></td> <!-- Empty column for alignment -->
    </tr>
</tfoot>

                </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

  <!-- /.content-wrapper -->