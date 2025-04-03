<?php 

class Main_model extends CI_Model
{

	public function addRegistration() {
       if ($this->input->post('name')) {
        // Retrieve input data
        $data = array(
            'name' => $this->input->post('name'),
            'account_type' => $this->input->post('account_type'),
            'mobile_no' => $this->input->post('mobile_no'),
            'email' => $this->input->post('email'),
            'password' => $this->input->post('password'),
            'curr_date' => date('Y-m-d'),
            'curr_time' => date('H:i:s')
        );
            

        // Insert data into database
        $result = $this->db->insert('registration', $data); 

        return $result; // Ensure to return the result
    }
    return false; // Return false if input data is not present
}
//--------------------------------------

public function getUserByEmail($email) {
        $query = $this->db->get_where('registration', array('email' => $email));
        return $query->row(); // Return single row object
    }

    public function getAlluser(){
        $master = $this->db->get('registration');
        if($master->num_rows()> 0){
            return $master->result();
        } 
    }

       // Get items by category
public function getItemsByCategory($category_id) {
    $this->db->select('id, items');
    $this->db->from('master_items');
    $this->db->where('category_id', $category_id);
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return [];
}

public function getPriceByItemId($item_id) {
    $this->db->select('price');
    $this->db->from('master_items');
    $this->db->where('id', $item_id);
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        return $query->result_array();
    }
    return [];
}
  
    public function insertPurchase($data) {
        $this->db->insert('add_purchase', $data);
        return $this->db->insert_id(); // Return the inserted ID
    }

    public function insertDetails($data) {
        return $this->db->insert('add_details', $data);
    }

   public function get_total_order_amount($user_name) {
    $this->db->select_sum('req_total');
    $this->db->where('user_name', $user_name); // Apply limit based on logged-in user
    $query = $this->db->get('add_purchase'); 
    return $query->row()->req_total ?? 0;
}

public function getSalesOrders($user_name) {
    $this->db->select('id, bill_no, price, return_qty');
    $this->db->from('sales_orders');
    $this->db->where('requested_name', $user_name); // Ensure orders belong to logged-in user
    return $this->db->get()->result_array();
}


  public function getNewBillNumber() {
     // $user_name = $this->session->userdata('name'); // Get logged-in username

    $this->db->select('bill_no');
    $this->db->from('add_purchase');
     // $this->db->where('user_name', $user_name); // Filter by logged-in user
    $this->db->order_by('CAST(bill_no AS UNSIGNED)', 'DESC'); // Sort numerically
    $this->db->limit(1);
    
    $query = $this->db->get();
    $result = $query->row();

    return ($result && is_numeric($result->bill_no)) ? ($result->bill_no + 1) : 1; // Increment properly
}

//   public function insert_sales($data) {
//         return $this->db->insert_batch('sales_entry', $data);
//     }

  public function getOrders() {
    $user_name = $this->session->userdata('name'); // Get logged-in username

    $this->db->select('ap.id, ap.bill_no, ap.user_name, ap.date, ap.req_total, ap.status, 
                       GROUP_CONCAT(DISTINCT master_category.category ORDER BY master_category.category ASC SEPARATOR "<br><hr>") as category, 
                       GROUP_CONCAT(DISTINCT master_items.items ORDER BY master_items.items ASC SEPARATOR "<br><hr>") as items, 
                       GROUP_CONCAT(ad.price_id ORDER BY ad.items_id ASC SEPARATOR "<br><hr>") as price_id, 
                       GROUP_CONCAT(ad.qty ORDER BY ad.items_id ASC SEPARATOR "<br><hr>") as qty, 
                       GROUP_CONCAT(ad.amount ORDER BY ad.items_id ASC SEPARATOR "<br><hr>") as amount');
    $this->db->from('add_purchase ap');
    $this->db->join('add_details ad', 'ap.id = ad.add_purchase_id', 'left');
    $this->db->join('master_category', 'master_category.id = ad.category_id', 'left');
    $this->db->join('master_items', 'master_items.id = ad.items_id', 'left');

    $this->db->where('ap.user_name', $user_name); // Filter by logged-in username
    $this->db->group_by('ap.bill_no');
    $this->db->order_by('ap.date', 'DESC');

    $query = $this->db->get();
    return $query->result();
}


   public function disableReqOrder()
{
    // Initialize the response
    $response = ['status' => false, 'message' => ''];

    // Check if 'dlt_id' is provided in the POST request
    if ($this->input->post('dlt_id')) {
        // Retrieve and sanitize the ID from the POST request
        $id = intval($this->input->post('dlt_id'));

        // Begin a database transaction
        $this->db->trans_start();

        // Delete from `purchase_order_details` using foreign key
        $this->db->where('add_purchase_id', $id); // Assuming foreign key is `purchase_order_id`
        $this->db->delete('add_details');

        // Delete from `purchase_orders`
        $this->db->where('id', $id);
        $this->db->delete('add_purchase');

        // Complete the transaction
        $this->db->trans_complete();

        // Check transaction status
        if ($this->db->trans_status() === FALSE) {
            $response['message'] = 'Failed to delete data. Please try again.';
            $this->session->set_flashdata('error_message', 'Failed to delete data');
        } else {
            $response['status'] = true;
            $response['message'] = 'Data deleted successfully.';
            $this->session->set_flashdata('success_message', 'Data deleted successfully');
        }
    } else {
        // Invalid ID or no ID provided
        $response['message'] = 'Invalid ID provided.';
    }

    // Return the response as JSON
    echo json_encode($response);
}

public function update_reqOrder() {
    $response = ['data' => [], 'error' => ''];
    if ($this->input->post('category')) {
        $data = [
            'category' => $this->input->post('category')
       
        ];

        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('master_category', $data);

        if ($result) {
            $response['data'] = ['message' => 'Data updated successfully'];
        } else {
            $response['error'] = 'Failed to update data';
        }
    } else {
        $response['error'] = 'Invalid input';
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

//-----------------------------

public function getConfirm_list() {
    $user_name = $this->session->userdata('name'); // Get logged-in user's name

    $this->db->select('bill_no, requested_name, MIN(created_at) as created_at, sub_total');
    $this->db->from('order_list');
    $this->db->where('requested_name', $user_name); 
    $this->db->where('status', 'pending'); // Fetch only pending orders
    $this->db->group_by('bill_no, requested_name'); 
    $query = $this->db->get();
    
    return $query->result_array();
}

public function getTotalBalance() { 
    $user_name = $this->session->userdata('name'); // Get logged-in user's name

    // Get the sum of sub_total, ensuring only one value per bill_no and excluding 'submitted' orders
    $orderTotal = $this->db
        ->select_sum('sub_total')
        ->from('order_list')
        ->where('requested_name', $user_name)
        ->where("status != 'submitted'") // Exclude submitted orders
        ->where("id IN (SELECT MAX(id) FROM order_list WHERE requested_name = '$user_name' GROUP BY bill_no)", NULL, FALSE)
        ->get()
        ->row()
        ->sub_total ?? 0;

    // Get the sum of balance_amount from payment_details for the logged-in user
    $balanceTotal = $this->db
        ->select_sum('balance_amount')
        ->from('payment_details')
        ->where('requested_name', $user_name) // Use $user_name instead of $requested_name
        ->get()
        ->row()
        ->balance_amount ?? 0;

    return $orderTotal + $balanceTotal;
}


    public function insert_request_details($data) {
        return $this->db->insert_batch('sales_orders', $data);
    }

    public function insert_bank_transactions($data) {
        return $this->db->insert_batch('bank_transactions', $data);
    }

    public function insert_voucher_details($data) {
        return $this->db->insert_batch('voucher_details', $data);
    }

    public function insert_cash_denominations($data) {
        return $this->db->insert_batch('cash_denominations', $data);
    }

    public function insert_payment_details($data) {
    return $this->db->insert('payment_details', $data);
}

  //-----------------------------------------

	public function add_category()
{
    $response = ['data' => [], 'error' => '']; // Initialize response array

    if ($this->input->post('category')) {
        $data = array(
            'category' => $this->input->post('category')
        );

        $result = $this->db->insert('master_category', $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data added successfully');
            $response['data'] = ['message' => 'Data added successfully']; // Add success message
        } else {
            $response['error'] = 'Failed to add data'; // Set error message
        }
    } else {
        $response['error'] = 'Invalid request'; // Set error message for invalid request
    }
    
    // Set JSON response without echoing
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($response));
}

	public function getAllCategory()
		{
			$this->db->order_by('master_category.id');
	    	$query = $this->db->get("master_category");
		    if ($query->num_rows() > 0)
		    {
		        return $query;
		    }
	  	}

	 public function disableCategory(){
    $response = ['data' => [], 'error' => ''];

    // Check if 'id' is provided in the POST request
    if ($this->input->post('dlt_id')) {
        // Retrieve the ID from the POST request
        $id = $this->input->post('dlt_id');
        
        // Perform the delete operation
        $this->db->where('id', $id);
        $result = $this->db->delete('master_category');

        if ($result) {
                    $this->session->set_flashdata('success_message', 'Data deleted successfully');
                } else {
                    //echo json_encode(['status' => 'error', 'message' => 'Failed to disable data mode']);
                }
   }
}

    public function update_category() {
    $response = ['data' => [], 'error' => ''];
    if ($this->input->post('category')) {
        $data = [
            'category' => $this->input->post('category')
       
        ];

        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('master_category', $data);

        if ($result) {
            $response['data'] = ['message' => 'Data updated successfully'];
        } else {
            $response['error'] = 'Failed to update data';
        }
    } else {
        $response['error'] = 'Invalid input';
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}

//------------------------------

public function add_items()
{
    $response = ['data' => [], 'error' => '']; // Initialize response array

    if ($this->input->post('items')) {
        $data = array(
            'items' => $this->input->post('items'),
            'category_id' => $this->input->post('category_id'),
            'price' => $this->input->post('price')
        );

        $result = $this->db->insert('master_items', $data);

        if ($result) {
            $this->session->set_flashdata('success_message', 'Data added successfully');
            $response['data'] = ['message' => 'Data added successfully']; // Add success message
        } else {
            $response['error'] = 'Failed to add data'; // Set error message
        }
    } else {
        $response['error'] = 'Invalid request'; // Set error message for invalid request
    }
    
    // Set JSON response without echoing
    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($response));
}

	public function getAllItems(){
    $this->db->select('master_items.*, master_category.category');
    $this->db->from('master_items');
    $this->db->join('master_category', 'master_category.id = master_items.category_id', 'left');
    $master = $this->db->get();
    if($master->num_rows() > 0){
        return $master; // Return the result here
    } 
    return null; // Return null if no data is found
}


	 public function disableItems(){
    $response = ['data' => [], 'error' => ''];

    // Check if 'id' is provided in the POST request
    if ($this->input->post('dlt_id')) {
        // Retrieve the ID from the POST request
        $id = $this->input->post('dlt_id');
        
        // Perform the delete operation
        $this->db->where('id', $id);
        $result = $this->db->delete('master_items');

        if ($result) {
                    $this->session->set_flashdata('success_message', 'Data deleted successfully');
                } else {
                    //echo json_encode(['status' => 'error', 'message' => 'Failed to disable data mode']);
                }
   }
}

    public function update_items() {
    $response = ['data' => [], 'error' => ''];
    if ($this->input->post('items')) {
        $data = [
            'items' => $this->input->post('items'),
            'category_id' => $this->input->post('category_id'),
            'price' => $this->input->post('price')
       
        ];

        $this->db->where('id', $this->input->post('id'));
        $result = $this->db->update('master_items', $data);

        if ($result) {
            $response['data'] = ['message' => 'Data updated successfully'];
        } else {
            $response['error'] = 'Failed to update data';
        }
    } else {
        $response['error'] = 'Invalid input';
    }

    $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($response));
}
//------------------------
 public function getAllpurchase() {
        $this->db->select('*');
        $this->db->from('add_purchase');
        return $this->db->get();
    }

  public function get_confirmed_orders() {
        $this->db->select('bill_no');
        $this->db->distinct();
        $this->db->from('order_list');
        $query = $this->db->get();
        
        return array_column($query->result_array(), 'bill_no');
    }
 
public function getViewdata($add_purchase_id) {
    $this->db->select('add_details.*, add_purchase.req_total, add_purchase.bill_no, master_category.category, master_items.items');
    $this->db->from('add_details');
    $this->db->join('add_purchase', 'add_purchase.id = add_details.add_purchase_id', 'left');
    $this->db->join('master_category', 'master_category.id = add_details.category_id', 'left');
    $this->db->join('master_items', 'master_items.id = add_details.items_id', 'left');
    $this->db->where('add_details.add_purchase_id', $add_purchase_id);
    $query = $this->db->get();
    return $query->result_array();
}

public function getUserNameByPurchaseId($add_purchase_id)
{
    $this->db->select('user_name');
    $this->db->from('add_purchase');
    $this->db->where('id', $add_purchase_id);
    $query = $this->db->get();
    return ($query->num_rows() > 0) ? $query->row()->user_name : 'Unknown';
}

public function getUserNameByBillNo($bill_no)
{
    $this->db->select('user_name');
    $this->db->from('add_purchase');
    $this->db->where('bill_no', $bill_no);
    $query = $this->db->get();
    return ($query->num_rows() > 0) ? $query->row()->user_name : 'Unknown';
}

// Rename function to avoid conflict
public function insert_order_batch($data) {
    return $this->db->insert_batch('order_list', $data);
}

//--------------------------------
   
    public function insertCashDenominations($data) {
        return $this->db->insert('cash_denom', $data);
    }

    public function insertCashDenomDetails($data) {
        $this->db->insert('cash_denom_details', $data);
        return $this->db->insert_id(); // Return last inserted ID
    }

//------------------------------------

     public function insert_vouchers($total_amount, $voucher_data) {
        // Insert total amount into `voucher_table`
        $this->db->insert('voucher', ['total_amount' => $total_amount]);
        $voucher_id = $this->db->insert_id(); // Get last inserted ID

        // Prepare data for `voucher_detail`
        foreach ($voucher_data as &$voucher) {
            $voucher['voucher_id'] = $voucher_id;
        }

        // Insert batch into `voucher_detail`
        return $this->db->insert_batch('voucher_detail', $voucher_data);
    }

    public function getVoucherAmount($voucher_no) {
    $this->db->select('amount');
    $this->db->from('voucher_detail');
    $this->db->where('voucher_no', $voucher_no);
    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->row()->amount;
    }
    return null;
}  
  
    public function insert_payment($payment_data) {
        return $this->db->insert_batch('payments', $payment_data);

     }
//-------------------------------------
public function getAllSales()
{
    $this->db->select('
        order_list.id,
        order_list.requested_name,
        order_list.bill_no,
        order_list.created_at,
        GROUP_CONCAT(DISTINCT order_list.category SEPARATOR "<br><hr>") AS category,
        GROUP_CONCAT(order_list.items SEPARATOR "<br><hr>") AS items,             
        GROUP_CONCAT(order_list.price SEPARATOR "<br><hr>") AS price,
        GROUP_CONCAT(order_list.qty SEPARATOR "<br><hr>") AS qty,              
        GROUP_CONCAT(sales_orders.quantity_stc ORDER BY sales_orders.id SEPARATOR "<br><hr>") AS quantity_stc,
        GROUP_CONCAT(sales_orders.sales ORDER BY sales_orders.id SEPARATOR "<br><hr>") AS sales, 
        GROUP_CONCAT(sales_orders.return_qty ORDER BY sales_orders.id SEPARATOR "<br><hr>") AS return_qty,
        MAX(sales_orders.created_at) AS sales_created_at, 
        MAX(payment_details.sales_total) AS sales_total
    ');

    $this->db->from('order_list');
    $this->db->join('sales_orders', 'order_list.bill_no = sales_orders.bill_no AND order_list.items = sales_orders.items', 'left'); 
    $this->db->join('payment_details', 'payment_details.sales_order_id = sales_orders.id', 'left');

    // Ensure only records with sales are shown
    $this->db->where('sales_orders.sales IS NOT NULL AND sales_orders.sales >', 0);

    $this->db->group_by('order_list.bill_no');  
    $this->db->order_by('order_list.bill_no', 'ASC');

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return [];
    }
}

//-----------------------------

    public function getSalesmen() {
        $query = $this->db->select('id, name')->from('registration')->get();
        return $query->result();
    }

 public function getSales_bills($salesman_name = null, $order_date = null)
{
    $this->db->select('so.bill_no, so.requested_name, MIN(so.created_at) as created_at');
    $this->db->from('sales_orders as so');
    $this->db->join('registration as r', 'r.name = so.requested_name', 'inner');

    if (!empty($salesman_name)) {
        $this->db->where('r.name', $salesman_name); // Filter by Salesman Name
    }

    if (!empty($order_date)) {
        $this->db->where('DATE(so.created_at)', $order_date); // Filter by Order Date
    }

    $this->db->group_by('so.bill_no, so.requested_name');
    $query = $this->db->get();

    return $query->result_array();
}
//---------------------------------------
public function getCategory_sales_by_date($order_date)
{
    $this->db->select('
        sales_orders.bill_no,
        sales_orders.created_at, 
        GROUP_CONCAT(sales_orders.category SEPARATOR "<br><hr>") AS category,
        GROUP_CONCAT(sales_orders.sales SEPARATOR "<br><hr>") AS sales,
        GROUP_CONCAT(sales_orders.amount SEPARATOR "<br><hr>") AS amount
          ');
    $this->db->from('sales_orders'); // Replace with actual table name
    $this->db->where('DATE(created_at)', $order_date); // Filter by date
    $this->db->group_by('sales_orders.bill_no, sales_orders.created_at');
    $query = $this->db->get();
    return $query->result(); // Return results
}

//-------------------------------------

public function getItem_sales_by_date($order_date)
{
    $this->db->select('
        sales_orders.bill_no,
        sales_orders.created_at, 
        GROUP_CONCAT(sales_orders.items SEPARATOR "<br><hr>") AS items,
        GROUP_CONCAT(sales_orders.sales SEPARATOR "<br><hr>") AS sales,
        GROUP_CONCAT(sales_orders.amount SEPARATOR "<br><hr>") AS amount
          ');
    $this->db->from('sales_orders'); // Replace with actual table name
    $this->db->where('DATE(created_at)', $order_date); // Filter by date
    $this->db->group_by('sales_orders.bill_no, sales_orders.created_at');
    $query = $this->db->get();
    return $query->result(); // Return results
}

//-------------------------------------
public function getSalemen() {
        $query = $this->db->select('id, name')->from('registration')->get();
        return $query->result();
    }

   public function get_payment_rep($salesman_name = null, $order_date = null)
{
    $this->db->select('sales_orders.created_at, sales_orders.bill_no, payment_details.requested_name, payment_details.total_amount, payment_details.voucher_total, payment_details.bank_total, payment_details.paid_amount');
    $this->db->from('payment_details'); 
    $this->db->join('sales_orders', 'sales_orders.id = payment_details.sales_order_id', 'inner');
    $this->db->join('registration r', 'r.name = sales_orders.requested_name', 'inner'); // Correct join with registration

    if (!empty($salesman_name)) {
        $this->db->where('r.name', $salesman_name);
    }

    if (!empty($order_date)) {
        $this->db->where('DATE(sales_orders.created_at)', $order_date);
    }

    $this->db->group_by('sales_orders.id'); // Fix the alias
    $query = $this->db->get();

    return $query->result_array();
}

//-----------------------------
public function getOrder_list($order_date = null)
{
    $this->db->select('ol.bill_no, ol.sub_total, ol.requested_name, MIN(ol.created_at) as created_at');
    $this->db->from('order_list as ol');
    $this->db->join('registration as r', 'r.name = ol.requested_name', 'inner');

    if (!empty($order_date)) {
        $this->db->where('DATE(ol.created_at)', $order_date); // Filter by Order Date
    }

    $this->db->group_by('ol.bill_no, ol.requested_name');
    $query = $this->db->get();

    return $query->result_array();
}

}

