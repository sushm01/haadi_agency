
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category Wise Sales</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Category Wise Sales</li>
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
            <th>Category</th>
            <th>Sold Qty</th>
            <th>Line Total</th>
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
                <td><?php echo $r->category; ?></td>
                <td><?php echo $r->sales; ?></td>
                <td><?php echo $r->amount; ?></td> 
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
    var selectedDate = document.getElementById("orderDate").value;

    $.ajax({
        url: "<?php echo base_url('welcome/fetch_category_wise_report'); ?>",
        type: "POST",
        data: { orderDate: selectedDate },
        dataType: "json",
        success: function(response) {
            var tbody = "";
            if (response.length > 0) {
                var i = 1;
                response.forEach(function(item) {
                    tbody += `<tr>
                        <td>${i++}</td>
                        <td>${item.created_at}</td>
                        <td>${item.bill_no}</td>
                        <td>${item.category}</td>
                        <td>${item.sales}</td>
                        <td>${item.amount}</td>
                    </tr>`;
                });
            } else {
                tbody = `<tr><td colspan="5">No products found</td></tr>`;
            }
            $("#example1 tbody").html(tbody); // Update table body
        }
    });
}
</script>
