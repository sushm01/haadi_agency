
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
                    <h1>Order List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('')?>">Home</a></li>
                        <li class="breadcrumb-item active">Order List</li>
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
            <th>Date</th>
            <th>User Name</th>
            <th>Category</th>
            <th>Items</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Amount</th>
            <th>Sub Total</th>
            <th>Action</th>
                </tr>
                  </thead>
               <tbody>
<?php if (!empty($orders)): ?>
     <?php $i = 1; ?>
    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo $order->bill_no; ?></td>
            <td><?php echo $order->date; ?></td>
            <td><?php echo $order->user_name; ?></td>
            <td><?php echo $order->category; ?></td> <!-- Categories grouped -->
            <td><?php echo $order->items; ?></td> <!-- Items grouped -->
            <td><?php echo $order->price_id; ?></td> <!-- Prices grouped -->
            <td><?php echo $order->qty; ?></td> <!-- Quantities grouped -->
            <td><?php echo $order->amount; ?></td> <!-- Amounts grouped -->
            <td><?php echo $order->req_total; ?></td> <!-- Sub Total -->
            <td>
                <a class="far fa-edit" onclick="setDataFunction(
                    '<?php echo $order->id; ?>',
                    '<?php echo htmlspecialchars($order->bill_no, ENT_QUOTES, 'UTF-8'); ?>'
                )" style="font-size: 25px; color: GoldenRod;"></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="fas fa-trash-alt" onclick="setDeleteFunction('<?php echo $order->id; ?>')" style="font-size:25px; color: DarkSlateGray"></a> 
            </td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr><td colspan="10" class="text-center">No Purchase Orders Found</td></tr>
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

  <!--------------------------Delete Brand Modal ---------------------------------------->

    <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this deatails?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="post" action="<?php echo base_url('welcome/deleteReqOrder')?>">
                        <input type="hidden" name="dlt_id" id="dlt_id">
                        <button type="button" style="color: GoldenRod" class="btn btn-light" data-dismiss="modal">No</button>
                        <button type="submit" style="color: DarkSlateGray" class="btn btn-light">Yes Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div> 
  

<!---------------------------Edit Brand Modal ---------------------------------------->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Customer Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?=base_url('welcome/updateRqOrder')?>" id="editParty">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group inline-block">
                                <label class="inline-block">Bill No</label>
                                <input type="hidden" name="id" id="party_id"> 
                                <input type="text" name="bill_no" id="cat_id" class="form-control inline-block" placeholder="Enter Party Name" readonly />
                            </div>
                        </div>
                              <td>
                            <div class="col-sm-4">
                                   <label class="inline-block">Category</label>
                            <select name="category_id[]" class="form-control inline-block category_id">
                                <option value="">Select Category</option>
                                <?php if ($getCategory->num_rows() > 0): ?>
                                    <?php foreach ($getCategory->result() as $category): ?>
                                        <option value="<?php echo $category->id; ?>"><?php echo $category->category; ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No categories available</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        </td>
                        <td>
                             <div class="col-sm-4">
                                 <label class="inline-block">Items</label>
                            <select name="items[]" class="form-control inline-block items">
                                <option value="">Select Items</option>
                            </select>
                        </div>
                        </td>
                        <td>
                             <div class="col-sm-3">
                                 <label class="inline-block">Price</label>
                            <select name="price[]" class="form-control inline-block price">
                                <option value="">Select Price</option>
                            </select>
                        </div>
                        </td>
                         <div class="col-sm-3">
                            <div class="form-group inline-block">
                                <label class="inline-block">QTY</label>
                                <input type="text" name="qty[]" id="cat_id" class="form-control inline-block" placeholder="Enter Party Name"/>
                            </div>
                        </div>
                         <div class="col-sm-3">
                            <div class="form-group inline-block">
                                <label class="inline-block">Amount</label>
                                <input type="text" name="amount[]" id="cat_id" class="form-control inline-block" placeholder="Enter Party Name"/>
                            </div>
                        </div>
                          <div class="col-sm-3">
                            <div class="form-group inline-block">
                                <label class="inline-block">Sub Total</label>
                                <input type="text" name="req_total[]" id="cat_id" class="form-control inline-block" placeholder="Enter Party Name"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="color: GoldenRod" class="btn btn-light" data-dismiss="modal">Close</button>
                    <button type="submit" style="color: DarkSlateGray" class="btn btn-light editBrand-save">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
//-------------------------START Edit operation-------------------------------------------//
  function setDataFunction(id, category) {
  // alert("Button clicked! ID: " + id); // Alert message to check button click
  // console.log("ID:", id); // Log the ID
  // console.log("Party Name:", party_name); // Log the Bag Name
  // console.log("Mobile:", mobile_no); // Log the Weight
  $('#party_id').val(id); // Set hidden ID field
  $('#cat_id').val(category); // Set Bag Name field
  $('#editModal').modal('show'); // Show the modal
  }      
//--------------------------END Edit operation-------------------------------------------//

//-----------------------START Delete operation-----------------------------------------//
    function setDeleteFunction(dlt_id){
       // alert(dlt_id)
      $('#dlt_id').val(dlt_id); 
      $('#deleteModal').modal('show');
    }
//--------------------------END Delete operation----------------------------------------//
</script>

