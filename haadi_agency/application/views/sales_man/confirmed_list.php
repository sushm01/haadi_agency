
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
                    <h1>Confirmed List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('')?>">Home</a></li>
                        <li class="breadcrumb-item active">Confirmed List</li>
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
            <th>Bill No</th>
            <th>Date&Time</th>
            <th>Product Deatails</th>
            <th>Return(QTY)</th>
            <th>Sales</th>
            <th>Sales Total</th>
            <th>Bank Total</th>
            <th>Voucher Total</th>
            <th>Payable Amt</th>
            <th>Paid Amt</th>
            <th>Balance Amt</th>
            <th>Action</th>
                </tr>
                  </thead>
             <tbody>
<?php if (!empty($sales)): ?>
     <?php $i = 1; ?>
    <?php foreach ($sales as $order): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $order->bill_no; ?></td>
            <td><?php echo $order->created_at; ?></td>
            <td><?php echo $order->category; ?></td>
            <td><?php echo $order->return_qty; ?></td>
            <td><?php echo $order->sales; ?></td>
            <td><?php echo $order->sales_total; ?></td>
            <td><?php echo $order->bank_total; ?></td>
            <td><?php echo $order->voucher_total; ?></td>
            <td><?php echo $order->payable_amount; ?></td>
            <td><?php echo $order->balance_amount; ?></td>
            <td><?php echo $order->paid_amount; ?></td>
            <td>
                <a class="far fa-edit" onclick="setDataFunction(
                    '<?php echo $order->id; ?>',
                    '<?php echo htmlspecialchars($order->bill_no, ENT_QUOTES, 'UTF-8'); ?>'
                )" style="font-size: 25px; color: SteelBlue;"></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="fas fa-trash-alt" onclick="setDeleteFunction('<?php echo $order->id; ?>')" style="font-size:25px; color: RosyBrown"></a> 
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="13" class="text-center">No Purchase Orders Found</td></tr>
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

