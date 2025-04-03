
   <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sales Bills</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sales Bills</li>
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
        <label for="salesman">Sales Man Name</label>
        <select id="salesman" class="form-control">
            <option value="">Select Salesman</option>
            <?php foreach ($salesmen as $salesman): ?>
                <option value="<?= htmlspecialchars($salesman->name) ?>"><?= htmlspecialchars($salesman->name) ?></option>
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
            <th>View</th>
            <th>Date</th>
            <th>Order.No</th>
            <th>Salesman</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="5">No data available. Please select a Salesman and click "Load Data".</td>
        </tr>
    </tbody>
</table>

        </div>
      </div>
    </div>
  </div>
</section>

 
 <section class="content">
    <div class="table-container">
        <div class="card">
          <div class="card-header" style="display: flex; align-items: center; padding: 10px;">
         <h3 class="btn btn" style="background-color: #4682B4; color: white; margin: 0;">Sales Bills</h3>
        </div>

            <form method="post" action="<?php echo base_url('/') ?>" enctype="multipart/form-data">
                 <input type="hidden" name="bill_no" value="<?= isset($getlist[0]['bill_no']) ? htmlspecialchars($getlist[0]['bill_no']) : ''; ?>">
                <div class="card-body">
                    <table id="example11" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sl.No</th>
                                <th>Category</th>
                                <th>Items</th>
                                <th>Price</th>
                                <th>Quantity(stc)</th>
                                <th>Return</th>
                                <th>Sales</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="productContainer">
                            <tr>
                                       <td>
               <div class="btn-group">
                   <span class="addRow" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:GoldenRod; width:40px; height:25px; border:2px solid GoldenRod; cursor:pointer; margin:5px;">+</span>
                   <span class="removeRow" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:DarkSlateGray; width:40px; height:25px; border:2px solid DarkSlateGray; cursor:pointer; margin:5px;">-</span>
               </div>
            </td>
                                <td class="slNo">1</td>
                                <td><input type="text" name="category[]" class="form-control" placeholder="Enter"></td>
                                <td><input type="text" name="items[]" class="form-control" placeholder="Enter"></td>
                                <td><input type="text" name="price[]" class="form-control price" placeholder="Enter"></td>
                                <td><input type="text" name="quantity_stc[]" class="form-control sales" placeholder="Enter"></td>
                                <td><input type="text" name="return_qty[]" class="form-control return_qty" placeholder="Enter"></td>
                                <td><input type="text" name="sales[]" class="form-control sales" placeholder="Enter"></td>
                                <td><input type="text" name="amount[]" class="form-control total_amount" placeholder="00" readonly></td>
                            </tr>
                        </tbody> 
                        <tfoot>
                            <tr>
                                <td colspan="8" class="text-right"><strong>Total Sales Bills:</strong></td>
                                <td><input type="text" name="sales_total" class="form-control total" id="total" readonly></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
              </form>
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
    var salesmanName = $('#salesman option:selected').text().trim(); // Get Salesman Name
    var orderDate = $('#orderDate').val(); // Get Order Date

    if (!salesmanName || salesmanName === "Select Salesman") {
        salesmanName = ""; // Allow empty selection for all salesmen
    }

    $.ajax({
        url: '<?= base_url("welcome/filter_sales_bills") ?>',
        type: 'POST',
        data: { 
            salesman_name: salesmanName, 
            order_date: orderDate 
        },
        dataType: 'json',
        success: function(response) {
            console.log("AJAX Response:", response); // Debugging

            var tbody = $('#example1 tbody');
            tbody.empty();

            if (response.length > 0) {
                $.each(response, function(index, item) {
                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>
                                <a href="javascript:void(0);" class="btn btn-info btn-sm viewOrder" data-id="${item.bill_no}">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                            <td>${item.created_at}</td>
                            <td>${item.bill_no}</td>
                            <td>${item.requested_name}</td>
                        </tr>
                    `);
                });
            } else {
                tbody.append('<tr><td colspan="5">No data found</td></tr>');
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error); // Debugging
            alert("An error occurred while fetching data.");
        }
    });
}
</script>

<script>
  $(document).on("click", ".viewOrder", function() {
    var billNo = $(this).data("id");

    $.ajax({
        url: "<?php echo base_url('welcome/getSalesDetails'); ?>", 
        type: "POST",
        data: { bill_no: billNo },
        dataType: "json",
        success: function(response) {
            if (response.status == "success") { 
                $("#productContainer").empty(); // Clear old rows
                let totalSalesAmt = 0;

                $.each(response.data, function(index, item) {
                    let salesAmount = parseFloat(item.amount) || 0;
                    totalSalesAmt += salesAmount;

                    let stcQty = item.quantity_stc !== undefined ? item.quantity_stc : 0;
                    let salesQty = item.sales !== undefined ? item.sales : 0;
                    let returnQty = item.return_qty !== undefined ? item.return_qty : 0;

                    var newRow = `<tr>
                        <td>
                            <div class="btn-group">
                                <span class="addRow" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:GoldenRod; width:40px; height:25px; border:2px solid GoldenRod; cursor:pointer; margin:5px;">+</span>
                                <span class="removeRow" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:DarkSlateGray; width:40px; height:25px; border:2px solid DarkSlateGray; cursor:pointer; margin:5px;">-</span>
                            </div>
                        </td>
                        <td class="slNo">${index + 1}</td>
                        <td><input type="text" name="category[]" class="form-control" value="${item.category}" readonly></td>
                        <td><input type="text" name="items[]" class="form-control" value="${item.items}" readonly></td>
                        <td><input type="text" name="price[]" class="form-control price" value="${item.price}" readonly></td>
                        <td><input type="text" name="quantity_stc[]" class="form-control quantity_stc" value="${stcQty}" readonly></td>
                        <td><input type="text" name="return_qty[]" class="form-control return_qty" value="${returnQty}"></td>
                        <td><input type="text" name="sales[]" class="form-control sales" value="${salesQty}" readonly></td>
                        <td><input type="text" name="amount[]" class="form-control total_amount" value="${salesAmount}" readonly></td>
                    </tr>`;

                    $("#productContainer").append(newRow);
                });

                $("#total").val(totalSalesAmt);
                
                $('html, body').animate({ scrollTop: $(".table-container:last").offset().top }, 500);
            } else {
                alert("No data found for this order.");
            }
        },
        error: function() {
            alert("Error fetching order details.");
        }
    });
});

</script>
