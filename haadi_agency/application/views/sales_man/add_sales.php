<style>
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
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
    .table-container {
        margin-bottom: 30px; /* Adds space between tables */
    }
</style>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Sales</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Add Sales</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    <!-- Orders Table -->
    <div class="table-container">
        <div class="card">
            <div class="card-header">
                <h3 class="btn btn" style="background-color: #5F9EA0; color: white;">Orders List</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl.No</th>
                                <th>Order No</th>
                                <th>Name</th>
                                <th>Date & Time</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       <tbody>
    <?php if (!empty($getlist)): ?>
        <?php $i = 1; ?>
        <?php foreach ($getlist as $r): ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo htmlspecialchars($r['bill_no']); ?></td>
                <td><?php echo htmlspecialchars($r['requested_name']); ?></td>
                <td><?php echo htmlspecialchars($r['created_at']); ?></td>
                <td class="sub_total"><?php echo htmlspecialchars($r['sub_total']); ?></td>
                <td>
                    <a href="javascript:void(0);" class="btn btn-info btn-sm viewOrder" data-id="<?php echo htmlspecialchars($r['bill_no']); ?>">
                        <i class="fa fa-eye"></i>
                    </a>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6" class="text-center">No orders found</td>
        </tr>
    <?php endif; ?>
</tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Details -->
    <div class="table-container">
        <div class="card">
          <div class="card-header" style="display: flex; align-items: center; padding: 10px;">
             <h3 class="btn btn" style="background-color: #4682B4; color: white; margin: 0;">Sales Details</h3>
         <span style="font-weight: bold; color: red; font-size: 15px; margin-left: auto;">
    Balance Amount: <?php echo htmlspecialchars($total_balance ?? '0.00'); ?>
</span>

        </div>

            <form method="post" action="<?php echo base_url('welcome/insertData') ?>" enctype="multipart/form-data">
                 <input type="hidden" name="bill_no" value="<?= isset($getlist[0]['bill_no']) ? htmlspecialchars($getlist[0]['bill_no']) : ''; ?>">
<input type="hidden" name="requested_name" value="<?= $this->session->userdata('name') ? htmlspecialchars($this->session->userdata('name')) : 'Guest'; ?>">

                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
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
                                <td colspan="8" class="text-right"><strong>Total Sales Amt:</strong></td>
                                <td><input type="text" name="sales_total" class="form-control total" id="total" readonly></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>


<div class="d-flex justify-content-around">
    <div class="table-container" style="width: 48%;">
        <div class="card">
            <div class="card-header">
                <h3 class="btn btn" style="background-color: #4682B4; color: white;">Bank Transcations</h3>
            </div>
            <!-- <form method="post" enctype="multipart/form-data"> -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sl.No</th>
                                <th>UTR.No</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="table1">
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <span class="addRow1" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:GoldenRod; width:40px; height:25px; border:2px solid GoldenRod; cursor:pointer; margin:5px;">+</span>
                                        <span class="removeRow1" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:DarkSlateGray; width:40px; height:25px; border:2px solid DarkSlateGray; cursor:pointer; margin:5px;">-</span>
                                    </div>
                                </td>
                                <td class="slNo">1</td>
                                <td><input type="text" name="utr_no[]" class="form-control" placeholder="Enter"></td>
                                <td><input type="text" name="b_amt[]" class="form-control" placeholder="Enter"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                <td><input type="text" name="bank_total" class="form-control total" id="total1" readonly></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>

    <div class="table-container" style="width: 48%;">
        <div class="card">
            <div class="card-header">
                <h3 class="btn btn" style="background-color: #4682B4; color: white;">Voucher Details</h3>
            </div>
            <!-- <form method="post" enctype="multipart/form-data"> -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Sl.No</th>
                                <th>Voucher.No</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="table 2">
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <span class="addRow2" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:GoldenRod; width:40px; height:25px; border:2px solid GoldenRod; cursor:pointer; margin:5px;">+</span>
                                        <span class="removeRow2" style="display:inline-flex; align-items:center; justify-content:center; font-size:25px; color:DarkSlateGray; width:40px; height:25px; border:2px solid DarkSlateGray; cursor:pointer; margin:5px;">-</span>
                                    </div>
                                </td>
                                <td class="slNo">1</td>
                                <td><input type="text" name="voucher_no[]" class="form-control" placeholder="Enter"></td>
                                <td><input type="text" name="v_amt[]" class="form-control" placeholder="Enter"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                <td><input type="text" name="voucher_total" class="form-control total" id="total2" readonly></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>
</div>

 <div class="d-flex justify-content-around">
    <!-- Cash Denominations Table -->
    <div class="table-container" style="width: 48%;">
        <div class="card">
            <div class="card-header">
                <h3 class="btn btn" style="background-color: #4682B4; color: white;">Cash Denominations</h3>
            </div>
            <!-- <form method="post" enctype="multipart/form-data"> -->
                <div class="card-body">
                    <table id="productTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Denomination</th>
                                <th>Count (X)</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $denominations = [500, 200, 100, 50, 20, 10];
                            foreach ($denominations as $denom): ?>
                                <tr>
                                    <td><?= $denom ?></td>
                                    <td><input type="number" name="count_<?= $denom ?>" id="count_<?= $denom ?>" oninput="calculateTotal()"></td>
                                    <td id="amount_<?= $denom ?>">0</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td>Coins</td>
                                <td><input type="number" name="coins" id="coins" oninput="calculateTotal()"></td>
                                <td id="coins_amount">0</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td colspan="2" name="total_amount" id="total_amount">0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
        </div>
    </div>

    <!-- Voucher Details Table -->
    <div class="table-container" style="width: 48%;">
        <div class="card">
            <div class="card-header">
                <h3 class="btn btn" style="background-color: #4682B4; color: white;">Payment Details</h3>
            </div>
           <!-- <form method="post" enctype="multipart/form-data"> -->
<div class="card-body">
    <!-- Headline Summary -->
    <h4 class="text-left" style="font-weight: bold; color: #333;">Payment Summary:</h4>

    <!-- Amount Breakdown -->
    <div class="alert alert-light text-left" >
        <div>
            <strong>Total Cash: <span id="total_cash" style="color: #FF6347;">0</span></strong>
        </div>
        <div>
            <strong>Total Voucher:<span id="total_voucher" style="color: #FF6347;">0</span></strong>
        </div>
        <div>
            <strong>Total IMPS:<span id="total_imps" style="color: #FF6347;">0</span></strong>
        </div>
         <div>
            <strong>Total Returns:<span id="total_returns" style="color: #FF6347;">0</span></strong>
        </div>
    </div>

    <!-- Table -->
    <table id="example1" class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td><strong>Payable Amount:</strong></td>
                <td><input type="text" name="payable_amount" id="payable_amount" class="form-control" value="0" readonly style="color: #8B0000; font-weight: bold;"></td>
            </tr>
            <tr>
                <td><strong>Paid Amount:</strong></td>
                <td><input type="text" name="paid_amount" id="paid_amount" class="form-control" value="0" readonly style="color: #1E90FF; font-weight: bold;"></td>
            </tr>
            <tr>
                <td><strong>Balance Amount:</strong></td>
                <td><input type="text" name="balance_amount" value="0" id="balance_amount" class="form-control" readonly style="color: #228B22; font-weight: bold;"></td>
            </tr>
            <tr>
              <td colspan="2" class="text-center">
                 <input type="hidden" name="total_amount" id="total_amount_input" value="0">

    <button type="button" id="confirmButton" class="btn btn" style="background-color: #191970; color: white;">Submit</button>
    <button type="button" id="cancelBtn" class="btn btn" style="background-color: #191970; color: white;">Cancel</button> 
    <p id="successMessage" style="display: none; color: MediumVioletRed; margin-top: 10px; font-weight: bold;">
        Successfully Order Placed!
    </p>
</td>

            </tr>
        </tbody>
    </table>
</div>
            </form>
        </div>
    </div>
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
    function updateTotalCash() {
        // Get the total amount value
        let totalAmount = document.getElementById("total_amount").textContent;
        
        // Set it to the total cash span
        document.getElementById("total_cash").textContent = totalAmount;
    }

    // Update when user clicks anywhere on the page
    document.addEventListener("click", updateTotalCash);

   function updateTotalVoucher() {
        // Get the total amount value from input
        let totalAmount = document.getElementById("total2").value;
        
        // Set it to the total voucher span
        document.getElementById("total_voucher").textContent = totalAmount || 0;
    }

    // Update when user clicks anywhere on the page
    document.addEventListener("click", updateTotalVoucher);

     function updateTotalImps() {
        // Get the total amount value from input
        let totalAmount = document.getElementById("total1").value;
        
        // Set it to the total voucher span
        document.getElementById("total_imps").textContent = totalAmount || 0;
    }

    // Update when user clicks anywhere on the page
    document.addEventListener("click", updateTotalImps);


      function updateTotalReturns() {
        let total = 0;
        let returnInputs = document.querySelectorAll(".return_qty");

        returnInputs.forEach(input => {
            let value = parseFloat(input.value) || 0; // Convert to number, default to 0 if empty
            total += value;
        });

        document.getElementById("total_returns").textContent = total;
    }

    // Update when the user clicks anywhere on the page
    document.addEventListener("click", updateTotalReturns);

</script>

<script>
    function calculateAmounts() {
        let totalAmount = parseFloat(document.getElementById('total_amount').textContent) || 0;
        let total2 = parseFloat(document.getElementById('total2').value) || 0;
        let total1 = parseFloat(document.getElementById('total1').value) || 0;
        let payableAmount = parseFloat(document.getElementById('payable_amount').value) || 0;

        // Calculate paid amount
        let totalPaid = totalAmount + total2 + total1;
        document.getElementById('paid_amount').value = totalPaid.toFixed(0);

        // Calculate balance (if negative, show absolute value)
        let balance = totalPaid - payableAmount;
        document.getElementById('balance_amount').value = Math.abs(balance).toFixed(0);
    }

    // Run the function when the page loads
    document.addEventListener('DOMContentLoaded', calculateAmounts);

    // Update calculations when input changes
    document.getElementById('total2').addEventListener('input', calculateAmounts);
    document.getElementById('total1').addEventListener('input', calculateAmounts);
    document.getElementById('payable_amount').addEventListener('input', calculateAmounts);

    // Run function when the user clicks anywhere on the page
    document.addEventListener('click', calculateAmounts);
</script>

 <script>
function calculateTotal() {
    let total = 0;
    let denominations = [500, 200, 100, 50, 20, 10];

    denominations.forEach(denom => {
        let count = parseInt(document.getElementById('count_' + denom).value) || 0;
        let amount = count * denom;
        document.getElementById('amount_' + denom).innerText = amount;
        total += amount;
    });

    let coins = parseInt(document.getElementById('coins').value) || 0;
    document.getElementById('coins_amount').innerText = coins;
    total += coins;

    document.getElementById('total_amount').innerText = total;
    
    // Update hidden input field
    document.getElementById('total_amount_input').value = total;
}

</script>

<script>
   $(document).ready(function() {

   // Fetch Order Details on Button Click
$(document).on("click", ".viewOrder", function() {
    var billNo = $(this).data("id");

    $.ajax({
        url: "<?php echo base_url('welcome/getOrderDetails'); ?>", 
        type: "POST",
        data: { bill_no: billNo },
        dataType: "json",
        success: function(response) {
            if (response.status == "success") {
                $("#productContainer").empty(); // Clear old rows
                let totalSalesAmt = 0; // Initialize total sales amount

                $.each(response.data, function(index, item) {
                    let salesAmount = parseFloat(item.amount) || 0;
                    totalSalesAmt += salesAmount;

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
                        <td><input type="text" name="quantity_stc[]" class="form-control quantity_stc" value="${item.stc_qty}" readonly></td>
                        <td><input type="text" name="return_qty[]" class="form-control return_qty" value="0"></td>
                        <td><input type="text" name="sales[]" class="form-control sales" value="0" readonly></td>
                        <td><input type="text" name="amount[]" class="form-control total_amount" value="${item.amount}" readonly></td>
                    </tr>`;

                    $("#productContainer").append(newRow);
                });

                updateTotalSum();
                updateBalance(totalSalesAmt); // Update balance dynamically
                
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

function updateBalance(deductAmount) {
    let balanceElement = $("span:contains('Balance Amount:')");
    let currentBalance = parseFloat(balanceElement.text().replace(/[^0-9.-]+/g, "")) || 0;
    let newBalance = currentBalance - deductAmount;

    balanceElement.html(`Balance Amount: ${newBalance.toFixed(0)}`);
}

$(document).on("click", "#cancelBtn", function() {
    window.location.href = "<?php echo base_url('add-sales'); ?>"; // Change to your desired redirection URL
});


    // Function to Calculate Row Total
    function calculateRowTotal(row) {
        var price = parseFloat($(row).find(".price").val()) || 0;
        var quantity_stc = parseFloat($(row).find(".quantity_stc").val()) || 0;
        var returnQty = parseFloat($(row).find(".return_qty").val()) || 0;
        
        var sales = quantity_stc - returnQty;
        if (sales < 0) {
            sales = 0; // Prevent negative sales
        }
        $(row).find(".sales").val(sales);

        var total = price * sales;
        $(row).find(".total_amount").val(total.toFixed(2));
    }

    function updateTotalSum() {
    var totalSum = 0;

    $(".total_amount").each(function() {
        var amount = parseFloat($(this).val()) || 0;
        totalSum += amount;
    });

    $("#total").val(totalSum.toFixed(0)); // Update total sales amount
    $("#payable_amount").val(totalSum.toFixed(0)); // Set payable amount equal to total
}


    // Auto Calculate when Quantity or Return changes
    $(document).on("input", ".quantity_stc, .return_qty", function() {
        var row = $(this).closest("tr");
        calculateRowTotal(row);
        updateTotalSum();
    });

    // Add Row Functionality
    $(document).on('click', '.addRow', function() {
        var newRow = $('#productContainer tr:last').clone();
        newRow.find('input').val('');
        newRow.find('input.sales').val('0');
        newRow.find('input.total_amount').val('0.00');
        $('#productContainer').append(newRow);
        updateSerialNumbers();
    });

    // Remove Row Functionality
    $(document).on('click', '.removeRow', function() {
        if ($('#productContainer tr').length > 1) {
            $(this).closest('tr').remove();
            updateSerialNumbers();
            updateTotalSum();
        } else {
            alert("At least one row is required.");
        }
    });

    // Function to Update Serial Numbers
    function updateSerialNumbers() {
        $('#productContainer tr').each(function(index) {
            $(this).find('.slNo').text(index + 1);
        });
    }

    // Initialize Calculations on Page Load
    $("#productContainer tr").each(function() {
        calculateRowTotal(this);
    });
    updateTotalSum();
});

</script>

<script>
    $(document).ready(function () {
    $(document).on("click", ".addRow1", function () {
        let tableBody = $("#table1"); // Select the tbody
        let lastRow = tableBody.find("tr:last"); // Find the last row
        let newRow = lastRow.clone(); // Clone the last row

        // Update serial number
        let newSlNo = parseInt(lastRow.find(".slNo").text()) + 1;
        newRow.find(".slNo").text(newSlNo);

        // Clear input values in the cloned row
        newRow.find("input").val("");

        // Append new row to the table body
        tableBody.append(newRow);
    });

    $(document).on("click", ".removeRow1", function () {
        let tableBody = $("#table1");
        if (tableBody.find("tr").length > 1) { // Ensure at least one row remains
            $(this).closest("tr").remove();
            
            // Reorder serial numbers
            tableBody.find("tr").each(function (index) {
                $(this).find(".slNo").text(index + 1);
            });
        }
    });
});

$(document).ready(function() {
    function calculateTotal() {
        let total1 = 0;
        $('input[name="b_amt[]"]').each(function() {
            let value = parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            total1 += value;
        });
        $('#total1').val(total1.toFixed(0)); // Display total with 2 decimal places
    }

    // Trigger calculation on input change
    $(document).on('input', 'input[name="b_amt[]"]', calculateTotal);
});

</script>

<script>
    $(document).ready(function () {
    $(document).on("click", ".addRow2", function () {
        let tableBody = $("#table\\ 2"); // Select the tbody
        let lastRow = tableBody.find("tr:last"); // Find the last row
        let newRow = lastRow.clone(); // Clone the last row

        // Update serial number
        let newSlNo = parseInt(lastRow.find(".slNo").text()) + 1;
        newRow.find(".slNo").text(newSlNo);

        // Clear input values in the cloned row
        newRow.find("input").val("");

        // Append new row to the table body
        tableBody.append(newRow);
    });

    $(document).on("click", ".removeRow2", function () {
        let tableBody = $("#table\\ 2");
        if (tableBody.find("tr").length > 1) { // Ensure at least one row remains
            $(this).closest("tr").remove();
            
            // Reorder serial numbers
            tableBody.find("tr").each(function (index) {
                $(this).find(".slNo").text(index + 1);
            });
        }
    });
});

$(document).ready(function() {
    function calculateTotal() {
        let total2 = 0;
        $('input[name="v_amt[]"]').each(function() {
            let value = parseFloat($(this).val()) || 0; // Convert to number, default to 0 if empty
            total2 += value;
        });
        $('#total2').val(total2.toFixed(0)); // Display total with 2 decimal places
    }

    // Trigger calculation on input change
    $(document).on('input', 'input[name="v_amt[]"]', calculateTotal);
});
</script>


