
<!-- <div class="content-wrapper"> -->
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
                    <h1>Request Order</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Request Order</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Table Section -->
    <div class="table-card">
        <div class="card">
            <div class="card-header" style="display: flex; align-items: center; padding: 10px;">
             <h3 class="btn btn" style="background-color: #4682B4; color: white; margin: 0;">Request Details</h3>
         <div style="margin-left: auto; text-align: right;">
    <span style="font-weight: bold; color: red; font-size: 15px;">
        Balance Amount: ₹<?php echo number_format($balance_amount, 0); ?>
    </span>

    <!-- Hidden Fields for price and return_qty -->
    <?php foreach ($salesOrders as $order): ?>
        <input type="hidden" name="price[]" value="<?= $order['price']; ?>">
        <input type="hidden" name="return_qty[]" value="<?= $order['return_qty']; ?>">
    <?php endforeach; ?>
</div>


        </div>
            <!-- /.card-header -->
            <form method="post" action="<?php echo base_url('welcome/saveRequestOrder')?>" enctype="multipart/form-data">
                <div class="card-body">
         <!-- Product Details Table -->
<div class="d-flex justify-content-between align-items-center">
    <!-- Bill No (Left-Aligned) -->
    <div class="col-auto">
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text fw-bold">Bill No</span>
            </div>
            <input class="form-control form-control-sm" name="bill_no" type="text" 
                   placeholder="" autocomplete="off" readonly 
                   value="<?php echo isset($bill_no) ? $bill_no : ''; ?>" 
                   style="width: 100px;">
        </div>
    </div> 

    <!-- Requested Name & Date (Right-Aligned) -->
    <div class="col-auto text-end">
        <p><strong>Name:</strong> 
            <?php echo $this->session->userdata('name') ? $this->session->userdata('name') : 'Guest'; ?>
        </p>
        <p><strong>Date: </strong> <span id="currentDate"></span></p>
    </div>
</div>


            <table id="productTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th>Sl.No</th>
                        <th>Category</th>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Quantity</th>
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
                        <td class="slNo">1</td> <!-- Serial Number Column -->
                        <td>
                            <select name="category_id[]" class="form-control category_id">
                                <option value="">Select Category</option>
                                <?php if ($getCategory->num_rows() > 0): ?>
                                    <?php foreach ($getCategory->result() as $category): ?>
                                        <option value="<?php echo $category->id; ?>"><?php echo $category->category; ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No categories available</option>
                                <?php endif; ?>
                            </select>
                        </td>
                        <td>
                            <select name="items[]" class="form-control items">
                                <option value="">Select Items</option>
                            </select>
                        </td>
                        <td>
                            <select name="price[]" class="form-control price">
                                <option value="">Select Price</option>
                            </select>
                        </td>
                        <td><input type="text" name="qty[]" class="form-control" placeholder="Enter Quantity"></td>

                        <td><input type="text" name="amount[]" class="form-control" placeholder="00" readonly></td>

                        <!-- <input type="hidden" name="registration_id" value="<?php echo $this->session->userdata('user_id'); ?>"> -->

                    </tr>
                </tbody>
                     <tfoot>
                               <tr>
                                    <td colspan="6" class="text-right"><strong>Total:</strong></td>
                                    <td><input type="text" name="sub_total" class="form-control total font-weight-bold" id="total" placeholder="00" readonly style="font-weight: bold;"></td>
                                </tr>
                            </tfoot>
            </table>
          <?php
$requested_name = $this->session->userdata('name') ?: 'Guest';
$total_user_orders = $this->Main_model->get_total_order_amount($requested_name);
$order_limit = 200000;
$balance_amount = max(0, $order_limit - $total_user_orders); // Ensure it doesn't go negative
$is_limit_exceeded = ($total_user_orders >= $order_limit);
?>

<button type="submit" id="confirmButton" class="btn btn" style="background-color: #4682B4; color: white;" 
    <?= $is_limit_exceeded ? 'disabled' : '' ?>>
    Confirm Order
</button>

<p id="successMessage" style="display: none; color: MediumVioletRed; margin-top: 10px; font-weight: bold;">
    Successfully Requested!
</p>

<?php if ($is_limit_exceeded): ?>
    <script>
        alert("You have reached your order limit of ₹2,00,000. You cannot place more orders.");
    </script>
<?php endif; ?>

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
    // Set default quantity to 1
    $("#productContainer").find("input[name='qty[]']").val(1);

    // Function to update amount and total
    function updateCalculations() {
        let total = 0;

        $("#productContainer tr").each(function() {
            let price = parseFloat($(this).find(".price").val()) || 0;
            let qty = parseFloat($(this).find("input[name='qty[]']").val()) || 1;
            let amount = price * qty;

            $(this).find("input[name='amount[]']").val(amount.toFixed(2)); // Update amount
            total += amount;
        });

        $("#total").val(total.toFixed(2)); // Update total
    }

    // Event listener for price or quantity change
    $(document).on("change keyup", ".price, input[name='qty[]']", function() {
        updateCalculations();
    });

    // Function to update serial numbers
    function updateSerialNumbers() {
        $('#productContainer tr').each(function(index) {
            $(this).find('.slNo').text(index + 1);
        });
    }

   // Add Row Functionality
$(document).on('click', '.addRow', function() {
    var lastRow = $('#productContainer tr:last'); 
    var newRow = lastRow.clone();

    // Get the last selected category
    var selectedCategory = lastRow.find('.category_id').val(); 

    // Clear all inputs except category selection
    newRow.find('input').val('');
    newRow.find("input[name='qty[]']").val(1); // Set default quantity to 1
    newRow.find("input[name='amount[]']").val(""); // Clear amount field

    // Set the cloned row's category dropdown to the previous row's selected category
    newRow.find('.category_id').val(selectedCategory); 

    $('#productContainer').append(newRow);
    updateSerialNumbers();
    updateCalculations();
});

// Remove Row Functionality
$(document).on('click', '.removeRow', function() {
    if ($('#productContainer tr').length > 1) {
        $(this).closest('tr').remove();
        updateSerialNumbers();
        updateCalculations();
    } else {
        alert("At least one row is required.");
    }
});


    // Load items when category changes
    $(document).on('change', '.category_id', function() {
        var category_id = $(this).val();
        var itemsDropdown = $(this).closest('tr').find('.items');
        var priceDropdown = $(this).closest('tr').find('.price');

        if (category_id) {
            $.ajax({
                url: "<?php echo base_url('welcome/getItemsByCategory'); ?>",
                type: "POST",
                data: { category_id: category_id },
                dataType: "json",
                success: function(data) {
                    itemsDropdown.empty().append('<option value="">Select Items</option>');
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            itemsDropdown.append('<option value="' + value.id + '">' + value.items + '</option>');
                        });
                    }
                }
            });
        } else {
            itemsDropdown.empty().append('<option value="">Select Items</option>');
            priceDropdown.empty().append('<option value="">Select Price</option>');
        }
    });

    // Load price when item changes
    $(document).on('change', '.items', function() {
        var item_id = $(this).val();
        var priceDropdown = $(this).closest('tr').find('.price');

        if (item_id) {
            $.ajax({
                url: "<?php echo base_url('welcome/getPriceByItemId'); ?>",
                type: "POST",
                data: { item_id: item_id },
                dataType: "json",
                success: function(data) {
                    priceDropdown.empty().append('<option value="">Select Price</option>');
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            priceDropdown.append('<option value="' + value.price + '">' + value.price + '</option>');
                        });
                    }
                }
            });
        } else {
            priceDropdown.empty().append('<option value="">Select Price</option>');
        }
    });

    // Initial serial number update
    updateSerialNumbers();
});

</script>
