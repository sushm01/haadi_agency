
   <style>
        .table td, .table th {
            vertical-align: middle;
        }
        .form-control {
            width: 100%;
        }
        .btn-group {
            display: flex;
        }
        .btn-group .btn {
            flex: 1;
        }
        .btn-group .btn:not(:last-child) {
            margin-right: 5px;
        }
    </style>

    <!-- Content Header 1 (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Order List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

 <!-- Table Section -->
<div class="table-card">
    <div class="card">
        <div class="card-header">
            <h3 class="btn btn" style="background-color: #6A5ACD; color: white;">View Order List</h3>
        </div>
        <!-- /.card-header -->
<form method="post" action="<?= base_url('welcome/insert_order') ?>" enctype="multipart/form-data">
    <input type="hidden" name="bill_no" value="<?= isset($viewdata[0]['bill_no']) ? htmlspecialchars($viewdata[0]['bill_no']) : ''; ?>">
    <!-- Rest of the form remains unchanged -->
    <div class="card-body">
        <!-- Requested Name & Date (Right-Aligned) -->
    <div class="col-auto text-end">
       <p><strong>Name:</strong> <?php echo isset($user_name) ? $user_name : 'Unknown'; ?></p>

        <p><strong>Date: </strong> <span id="currentDate"></span></p>
    </div>
        <div class="row">
            <!-- Product Details Table -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group inline-block">
                        <table id="productTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Sl.No</th>
                                    <th>Category</th>
                                    <th>Items</th>
                                    <th>Price</th>
                                    <th>Given Qty</th>
                                    <th>Stock Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                        <tbody id="productContainer">
    <?php
    $total = 0;
    if (!empty($viewdata)) {
        foreach ($viewdata as $key => $row) {
            $rowTotal = (float)$row['price_id'] * (float)$row['qty'];
            $total += $rowTotal;
    ?>
        <tr>
            <td>
               <div class="btn-group">
                   <span class="addRow" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:GoldenRod; width:40px; height:25px; border:2px solid GoldenRod; cursor:pointer; margin:5px;">+</span>
                   <span class="removeRow" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:DarkSlateGray; width:40px; height:25px; border:2px solid DarkSlateGray; cursor:pointer; margin:5px;">-</span>
               </div>
            </td>
            <td class="slNo"><?= $key + 1 ?></td> 
            <td><input type="text" name="category[]" class="form-control" value="<?= htmlspecialchars($row['category']) ?>" readonly></td>
            <td><input type="text" name="items[]" class="form-control" value="<?= htmlspecialchars($row['items']) ?>" readonly></td>
            <td><input type="text" name="price_id[]" class="form-control price_id" value="<?= htmlspecialchars($row['price_id']) ?>" readonly></td>
            <td><input type="text" name="qty[]" class="form-control qty" value="<?= htmlspecialchars($row['qty']) ?>" readonly></td>
           <td><input type="text" name="stc_qty[]" class="form-control stc_qty" value="<?= htmlspecialchars($row['qty']) ?>"></td>

            <td><input type="text" name="amount[]" class="form-control amount" value="<?= htmlspecialchars($row['amount']) ?>" readonly></td>
        </tr>
    <?php
        }
    } else { 
    ?>
        <tr>
            <td colspan="8" class="text-center">No records found.</td>
        </tr>
    <?php 
    } 
    ?>
</tbody>

 <tfoot>
    <tr>
        <td colspan="7" class="text-right"><strong>Total:</strong></td>
        <td>
            <input type="hidden" name="sub_total" value="<?= htmlspecialchars($total) ?>">
            <input type="text" name="sub_total" class="form-control total font-weight-bold" id="total" value="<?= htmlspecialchars($total) ?>" readonly style="font-weight: bold;">
        </td>
    </tr>
</tfoot>

                        </table>
                      <button type="submit" class="btn btn confirmButton" style="background-color: #6A5ACD; color: white;" id="confirmButton">Confirm Order</button>
            <p id="successMessage" style="display: none; color: MediumVioletRed; margin-top: 10px; font-weight: bold;">
                Successfully Order Confirmed!
            </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    </div>
</div>

  <script>
    document.getElementById("confirmButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent immediate form submission
        
        let message = document.getElementById("successMessage");
        message.style.display = "block"; // Show message

        // Wait for 2 seconds before submitting the form
        setTimeout(function() {
            message.style.display = "none";
            document.querySelector("form").submit(); // Submit the form after 2 seconds
        }, 2000);
    });
</script>


<script>
     document.getElementById("currentDate").textContent = new Date().toLocaleDateString();
$(document).ready(function() {

    // Function to calculate row total
    function calculateRowTotal(row) {
        var price = parseFloat($(row).find('.price_id').val()) || 0;
        var qty = parseFloat($(row).find('.stc_qty').val()) || 0;
        var rowTotal = price * qty;
        $(row).find('.amount').val(rowTotal.toFixed(2));
    }

    // Function to update total sum
    function updateTotalSum() {
        var total = 0;
        $(".amount").each(function() {
            total += parseFloat($(this).val()) || 0;
        });
        $("#total").val(total.toFixed(2));
    }

    // Trigger calculation on page load
    $("#productContainer tr").each(function() {
        calculateRowTotal(this);
    });
    updateTotalSum();

   var maxRows = 5; // Set this dynamically based on data received

$(document).on('click', '.addRow', function() {
    var rowCount = $('#productContainer tr').length;
    if (rowCount < maxRows) {
        var newRow = $('#productContainer tr:first').clone();
        newRow.find('input').val('');
        newRow.find('.stc_qty').val(newRow.find('.qty').val()); // Set stc_qty = qty
        $('#productContainer').append(newRow);
        updateSerialNumbers();
    } else {
        alert("You cannot add more than " + maxRows + " rows.");
    }
});

// Remove Row Functionality
$(document).on('click', '.removeRow', function() {
    if ($('#productContainer tr').length > 1) {
        $(this).closest('tr').remove();
        updateTotalSum();
        updateSerialNumbers();
    } else {
        alert("At least one row is required.");
    }
});


    // Calculate amount whenever stc_qty is updated
    $(document).on('input', '.stc_qty', function() {
        var row = $(this).closest('tr');
        calculateRowTotal(row);
        updateTotalSum();
    });

    function updateSerialNumbers() {
        $(".slNo").each(function(index) {
            $(this).text(index + 1);
        });
    }

});
</script>


