
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment Report</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Payment Report</li>
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
          <!-- New Rows Added -->
         <div class="row mb-3">
               <div class="col-md-4">
        <label for="salemen">Sales Man Name</label>
        <select id="salemen" class="form-control">
            <option value="">Select Salesman</option>
            <?php foreach ($salemen as $salemen): ?>
                <option value="<?= htmlspecialchars($salemen->name) ?>"><?= htmlspecialchars($salemen->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
            <div class="col-md-4">
                <label for="orderDate">Order Date</label>
                <input type="date" id="orderDate" class="form-control">
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-50" onclick="loadData()">Load Data</button>
            </div>
        </div>
    <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Bill Date</th>
            <th>Bill No</th>
            <th>Sales Person</th>
            <th>Cash Denomination</th>
            <th>Voucher Amt</th>
            <th>IMPS/UPI Amt</th>
            <th>Total Amt</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($get_cat)): ?>
        <?php $i = 1; ?>
        <?php foreach ($get_cat as $r): ?> <!-- No need for ->result() -->
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $r->created_at; ?></td>
                <td><?php echo $r->bill_no; ?></td>
                <td><?php echo $r->requested_name; ?></td>
                <td><?php echo $r->total_amount; ?></td>
                <td><?php echo $r->voucher_total; ?></td> 
                <td><?php echo $r->bank_total; ?></td>
                <td><?php echo $r->paid_amount; ?></td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="13">No products found</td>
        </tr>
    <?php endif; ?>
</tbody>

</table>

        </div>
      </div>
    </div>
  </div>
</section>

 
<script>
  function loadData() {
    alert("Load button clicked! Implement AJAX or other logic here.");
  }
</script>

<script>
function loadData() {
    var salesman = document.getElementById("salemen").value;
    var orderDate = document.getElementById("orderDate").value;

    $.ajax({
        url: "<?= base_url('welcome/filter_payment') ?>", // Replace with actual controller
        type: "POST",
        data: { salesman_name: salesman, order_date: orderDate },
        dataType: "json",
        success: function(response) {
            var tableBody = $("tbody");
            tableBody.empty(); // Clear previous data

            if (response.length > 0) {
                response.forEach(function(row, index) {
                    tableBody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${row.created_at}</td>
                            <td>${row.bill_no}</td>
                            <td>${row.requested_name}</td>
                            <td>${row.total_amount}</td>
                            <td>${row.voucher_total}</td>
                            <td>${row.bank_total}</td>
                            <td>${row.paid_amount}</td>
                        </tr>
                    `);
                });
            } else {
                tableBody.append(`<tr><td colspan="6">No records found</td></tr>`);
            }
        }
    });
}

</script>

