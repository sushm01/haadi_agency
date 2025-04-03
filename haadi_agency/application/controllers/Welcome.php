<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	 public $benchmark;
    public $hooks;
    public $config;
    public $log;
    public $utf8;
    public $uri;
    public $router;
    public $output;
    public $security;
    public $input;
    public $lang;
    public $email;
    public $session;
    public $Main_model;
    public $db;
    public $upload;

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
        // Load the Main_model
        $this->load->model('Main_model');
        // $this->load->library('form_validation'); // Load the library
       
    }

    public function index()
    {
        $this->load->view('sales_man/registration');
    }

    public function insertRegistration(){
       $this->Main_model->addRegistration();
            redirect('registration');
    }

     public function signin_page()
    {    
         $this->load->view('sign_in');  
    }

   public function verifyLogin() {
        try {
            if ($this->input->post('email')) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                // Fetch user data using model
                $userData = $this->Main_model->getUserByEmail($email);
                
                if ($userData) {
                    // Check if password matches (use password_verify if hashed)
                    if ($userData->password == $password) {
                        if ($userData->status == 'confirmed') {
                            $this->session->set_userdata([
                                'user_id' => $userData->id,
                                'name' => $userData->name,
                                'email' => $userData->email,
                                'is_logged_in' => true
                            ]);

                            $response = [
                                'status' => 'success',
                                'redirect' => base_url('welcome/sales_dashboard')
                            ];
                        } else {
                            $response = [
                                'status' => 'error', 
                                'message' => 'Account not confirmed.'
                            ];
                        }
                    } else {
                        $response = [
                            'status' => 'error', 
                            'password_message' => 'Incorrect password'
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'error', 
                        'email_message' => 'Email not registered.'
                    ];
                }
            } else {
                $response = [
                    'status' => 'error', 
                    'email_message' => 'Invalid request.'
                ];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        } catch (Exception $e) {
            // Return exception as JSON response
            $response = [
                'status' => 'error',
                'message' => 'Exception occurred: ' . $e->getMessage()
            ];
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($response));
        }
    }

    public function S_logout_sessionDestroy() {
        if (!$this->session->userdata('user_id')) redirect('signIn');
        $this->session->sess_destroy();
        redirect('signIn');
    }
//--------------------------------
 public function ConfirmationEmail_user($userId) {
        // Load the email library
        $this->load->library('email');

        // Load user details from the database
        $this->db->where('id', $userId);
        $query = $this->db->get('registration');
        $user = $query->row();

        if ($user) {
            $this->email->from('sushmarathod25@gmail.com', 'Successfully CONFIRMED Admin');
            $this->email->to($user->email);
            $this->email->subject('Registration Confirmation');
            $this->email->message('You have been successfully registered');

            if ($this->email->send()) {
                $response = ['status' => 'success', 'message' => 'Email sent successfully.'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to send email.', 'error_details' => $this->email->print_debugger()];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'User not found.'];
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($response));
    }

    public function updateStatus_user($userId){
    $this->db->where('id', $userId);
    $this->db->where('status !=', 'confirmed');  // Ensure it's not already confirmed
    $this->db->update('registration', array('status' => 'confirmed'));

    if ($this->db->affected_rows() > 0) {
        $response = ['status' => 'success', 'message' => 'Status updated successfully.'];
    } else {
        $response = ['status' => 'error', 'message' => 'Failed to update status or already confirmed.'];
    }

    $this->output
         ->set_content_type('application/json')
         ->set_output(json_encode($response));
}

//-----------------------------
 public function sales_dashboard() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('signIn');
        }
        $data['user_name'] = $this->session->userdata('name');
        $this->load->view('sales_man/sales_header');
        $this->load->view('sales_man/sales_dashboard', $data);
        $this->load->view('sales_man/sales_footer');
    }

//-------------------------

public function userapproval_page()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $result['user_data'] = $this->Main_model->getAlluser();
    $this->load->view('admin/user_approval_list', $result);
    $this->load->view('admin/footer');
}

//--------------------------

public function addpurchase_page() {
    if (!$this->session->userdata('is_logged_in')) {
        redirect('signIn');
    }

    $requested_name = $this->session->userdata('name') ?: 'Guest';
    $total_user_orders = $this->Main_model->get_total_order_amount($requested_name);
    $order_limit = 200000;
    
    // Fetch only the logged-in user's sales orders
    $salesOrders = $this->Main_model->getSalesOrders($requested_name);

    // Calculate total return amount
    $total_return_amount = array_sum(array_map(function ($order) {
        return $order['price'] * $order['return_qty'];
    }, $salesOrders));

    // Adjust balance amount
    $balance_amount = max(0, $order_limit - $total_user_orders + $total_return_amount); 

    $this->load->view('sales_man/sales_header');

    // Pass data to view
    $result = [
        'getCategory' => $this->Main_model->getAllCategory(),
        'getItems' => $this->Main_model->getAllItems(),
        'bill_no' => $this->Main_model->getNewBillNumber(),
        'balance_amount' => $balance_amount,
        'salesOrders' => $salesOrders
    ];
    $this->load->view('sales_man/add_purchase', $result);
    $this->load->view('sales_man/sales_footer');
}

    public function saveRequestOrder() {

     // Use requested name instead of user_id
    $user_name = $this->session->userdata('name') ?: 'Guest';

    // Fetch total orders for this requested name
    $total_user_orders = $this->Main_model->get_total_order_amount($user_name);

    // Define per-user order limit (₹2,00,000)
    $order_limit = 200000;

    // Check if adding the new order exceeds the limit
    if (($total_user_orders + $req_total) > $order_limit) {
        $this->session->set_flashdata('error', 'Order limit exceeded! Your total orders cannot exceed ₹2,00,000.');
        redirect('welcome/view_details/' . $bill_no);
        return;
    }

    // Collect purchase order data
    $bill_no = $this->input->post('bill_no');
    $user_name = $this->session->userdata('name');
    $date = date('Y-m-d');
    // $registration_id = $this->session->userdata('user_id');
    $req_total = $this->input->post('sub_total');

    // Insert into add_purchase table
    $purchase_data = [
        'bill_no' => $bill_no,
        'user_name' => $user_name,
        'date' => $date,
        'req_total' => $req_total,
        'status' => 'Pending' // Default status
        // 'registration_id' => $registration_id
    ];
    
    $purchase_id = $this->Main_model->insertPurchase($purchase_data);

    if ($purchase_id) {
        // Insert product details into add_details table
        $categories = $this->input->post('category_id');
        $items = $this->input->post('items');
        $prices = $this->input->post('price');
        $quantities = $this->input->post('qty');
        $amounts = $this->input->post('amount');

        foreach ($categories as $key => $category_id) {
            if (!empty($category_id) && !empty($items[$key]) && !empty($prices[$key]) && !empty($quantities[$key])) {
                $detail_data = [
                    'add_purchase_id' => $purchase_id,
                    'category_id' => $category_id,
                    'items_id' => $items[$key],
                    'price_id' => $prices[$key],
                    'qty' => $quantities[$key],
                    'amount' => $amounts[$key]
                ];
                $this->Main_model->insertDetails($detail_data);
            }
        }

        $this->session->set_flashdata('success', 'Purchase order saved successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to save purchase order.');
    }

    redirect('add-purchase'); // Redirect to purchase order list
}

//-------------------------------

public function viewReqOrder_page() {
        if (!$this->session->userdata('is_logged_in')) {
            redirect('signIn');
        }
        
        $this->load->view('sales_man/sales_header');
        $result['getCategory'] = $this->Main_model->getAllCategory();
        $result['getItems'] = $this->Main_model->getAllItems();
         // Fetch the latest bill number or initialize it
        $result['bill_no'] = $this->Main_model->getNewBillNumber();
        $result['orders'] = $this->Main_model->getOrders(); // Get data
        $this->load->view('sales_man/view_reqOrder', $result);
        $this->load->view('sales_man/sales_footer');
    }

    public function deleteReqOrder(){
        $this->Main_model->disableReqOrder();
        redirect('view-order');
    } 

     public function updateRqOrder() {
        $this->Main_model->update_reqOrder(); 
        redirect('view-order');
    }

//-------------------------------
public function addsales_page() {
    if (!$this->session->userdata('is_logged_in')) {
        redirect('signIn');
    }

 $result['getlist'] = $this->Main_model->getConfirm_list();
    $result['total_balance'] = $this->Main_model->getTotalBalance(); 
    $this->load->view('sales_man/sales_header');
    $this->load->view('sales_man/add_sales', $result);
    $this->load->view('sales_man/sales_footer');
}

public function getOrderDetails() {
    $bill_no = $this->input->post('bill_no'); 

    $this->db->where('bill_no', $bill_no);
    $query = $this->db->get('order_list');

    if ($query->num_rows() > 0) {
        $data = $query->result_array();
        $total_amount = array_sum(array_column($data, 'amount'));

        echo json_encode(["status" => "success", "data" => $data, "total_amount" => $total_amount]);
    } else {
        echo json_encode(["status" => "error", "message" => "No records found"]);
    }
}

 public function insertData() {
    if ($this->input->post()) {
        $this->db->trans_start(); // Start Transaction

        $bill_no = $this->input->post('bill_no'); // Get bill_no
        $requested_name = $this->input->post('requested_name'); // Get requested_name

        // Insert Request Details
        $request_data = [];
        foreach ($this->input->post('category') as $key => $category) {
            $request_data[] = [
                'bill_no' => $bill_no,
                'requested_name' => $requested_name,  // Include requested_name
                'category' => $category,
                'items' => $this->input->post('items')[$key],
                'price' => $this->input->post('price')[$key],
                'quantity_stc' => $this->input->post('quantity_stc')[$key],
                'return_qty' => $this->input->post('return_qty')[$key],
                'sales' => $this->input->post('sales')[$key],
                'amount' => $this->input->post('amount')[$key]
            ];
        }

        if (!empty($request_data)) {
            $this->Main_model->insert_request_details($request_data);
            $sales_order_id = $this->db->insert_id();
        }

        // Insert Bank Transactions
        $bank_data = [];
        foreach ($this->input->post('utr_no') as $key => $utr_no) {
            $b_amt = $this->input->post('b_amt')[$key] ?? 0;
            $bank_data[] = [
                'sales_order_id' => $sales_order_id,
                'bill_no' => $bill_no,
                'requested_name' => $requested_name,  // Include requested_name
                'utr_no' => $utr_no,
                'b_amt' => $b_amt
            ];
        }

        if (!empty($bank_data)) {
            $this->Main_model->insert_bank_transactions($bank_data);
        }

        // Insert Voucher Details
        $voucher_data = [];
        foreach ($this->input->post('voucher_no') as $key => $voucher_no) {
            $v_amt = $this->input->post('v_amt')[$key] ?? 0;
            $voucher_data[] = [
                'sales_order_id' => $sales_order_id,
                'bill_no' => $bill_no,
                'requested_name' => $requested_name,  // Include requested_name
                'voucher_no' => $voucher_no,
                'v_amt' => $v_amt
            ];
        }

        if (!empty($voucher_data)) {
            $this->Main_model->insert_voucher_details($voucher_data);
        }

        // Insert Cash Denominations
        $cash_data = [];
        $denominations = [500, 200, 100, 50, 20, 10];
        foreach ($denominations as $denom) {
            if ($this->input->post("count_$denom")) {
                $cash_data[] = [
                    'sales_order_id' => $sales_order_id,
                    'bill_no' => $bill_no,
                    'requested_name' => $requested_name,  // Include requested_name
                    'denomination' => $denom,
                    'count_x' => $this->input->post("count_$denom"),
                    'amount' => $denom * $this->input->post("count_$denom"),
                ];
            }
        }
        if ($this->input->post('coins')) {
            $cash_data[] = [
                'sales_order_id' => $sales_order_id,
                'bill_no' => $bill_no,
                'requested_name' => $requested_name,  // Include requested_name
                'denomination' => 1,
                'count_x' => $this->input->post('coins'),
                'amount' => $this->input->post('coins')
            ];
        }
        if (!empty($cash_data)) {
            $this->Main_model->insert_cash_denominations($cash_data);
        }

      $total_amount = $this->input->post('total_amount'); // Ensure you retrieve it correctly

$payment_data = [
    'sales_order_id' => $sales_order_id,
    'bill_no' => $bill_no,
    'requested_name' => $requested_name,
    'payable_amount' => $this->input->post('payable_amount'),
    'paid_amount' => $this->input->post('paid_amount'),
    'balance_amount' => $this->input->post('balance_amount'),
    'sales_total' => $this->input->post('sales_total'),
    'bank_total' => $this->input->post('bank_total'),
    'voucher_total' => $this->input->post('voucher_total'),
    'total_amount' => $total_amount // Now this will not be undefined
];

if (!empty($payment_data['total_amount'])) { // Ensure it's not null
    $this->Main_model->insert_payment_details($payment_data);
} else {
    echo "Error: Total Amount is missing!";
}


        // **Update order_list status from 'pending' to 'submitted'**
        $this->db->where('bill_no', $bill_no);
        $this->db->where('requested_name', $requested_name);
        $this->db->update('order_list', ['status' => 'submitted']);

        $this->db->trans_complete(); // Commit or Rollback Transaction

        if ($this->db->trans_status()) {
            $this->session->set_flashdata('success', 'Data inserted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Data insertion failed!');
        }

        redirect('add-sales');
    }
}

   public function getItemsByCategory() {
    $category_id = $this->input->post('category_id');
    $result = $this->Main_model->getItemsByCategory($category_id);
    echo json_encode($result);
}

    public function getPriceByItemId() {
        $item_id = $this->input->post('item_id');
        $result = $this->Main_model->getPriceByItemId($item_id);
        echo json_encode($result);
    }
//---------------------------
	public function adminLogin()
	{
		$this->load->view('admin/admin_login');
	}

	public function authLogin() {
    // Load the form validation library
    $this->load->library('form_validation');

    // Set validation rules for email and password
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
        'required' => 'The Email field is required.',
        'valid_email' => 'Please enter a valid Email address.'
    ]);
    $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
        'required' => 'The Password field is required.',
        'min_length' => 'The Password must be at least 6 characters long.'
    ]);

    if ($this->form_validation->run() == FALSE) {
        // Validation failed, send back to the login page with error messages
        $this->session->set_flashdata('failure_message_email', form_error('email'));
        $this->session->set_flashdata('failure_message_password', form_error('password'));
        redirect('admin-login');
    } else {
        // Validation passed, proceed with authentication
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        
        $adminData = $this->db->get_where('login', array("email" => $email));
        if ($adminData->num_rows() > 0) {
            $userData = $adminData->row();
            if ($userData->password == $password) {
                $_SESSION['user_id'] = $this->input->post('email');
                $this->session->set_flashdata('success_message', 'Welcome, You Are Successfully Logged In.');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('failure_message_password', 'Invalid password');
                $this->session->set_flashdata('failure_message_email', ''); // Reset email error message
                redirect('admin-login');
            }
        } else {
            $this->session->set_flashdata('failure_message_email', 'Invalid email');
            $this->session->set_flashdata('failure_message_password', ''); // Reset password error message
            redirect('admin-login');
        }
    }
}

	public function A_logout_sessionDestroy() {
	    if (!$this->session->userdata('user_id')) redirect('admin-login');
	    $this->session->sess_destroy();
	    redirect('admin-login');
	}
//----------------

public function dashboard_page()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $this->load->view('admin/dashboard');
    $this->load->view('admin/footer');
}
//-------------------------

public function category_page()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $result['getCategory'] = $this->Main_model->getAllCategory();
    $this->load->view('admin/master/category', $result);
    $this->load->view('admin/footer');
}

public function insertCategory(){
        $this->Main_model->add_category();
         redirect('category');
    }

    public function deleteCategory(){
        $this->Main_model->disableCategory();
        redirect('category');
    } 

    public function updateCategory() {
        $this->Main_model->update_category(); 
        redirect('category');
    }
//-----------------------------


public function item_page()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $result['getCategory'] = $this->Main_model->getAllCategory();
    $result['getItems'] = $this->Main_model->getAllItems();
    $this->load->view('admin/master/items', $result);
    $this->load->view('admin/footer');
}

public function insertItem(){
        $this->Main_model->add_items();
         redirect('items');
    }

    public function deleteItems(){
        $this->Main_model->disableItems();
        redirect('items');
    } 

    public function updateItems() {
        $this->Main_model->update_items(); 
        redirect('items');
    }
//-----------------------------

    public function purchase_view()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $result['purchase_data'] = $this->Main_model->getAllpurchase();
    // echo "<pre>";
    // print_r($result['purchase_data']);
    // echo "</pre>";
    // exit;  
    $this->load->view('admin/purchase_view', $result);
    $this->load->view('admin/footer');
}

public function view_details($add_purchase_id)
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');

    // Fetch data from the model
    $data['viewdata'] = $this->Main_model->getViewdata($add_purchase_id);
    
    // Fetch user_name from add_purchase table
    $data['user_name'] = $this->Main_model->getUserNameByPurchaseId($add_purchase_id);

    $this->load->view('admin/header');
    $this->load->view('admin/view_details', $data);
    $this->load->view('admin/footer');
}

public function insert_order() { 
    $categories = $this->input->post('category');
    $items = $this->input->post('items');
    $prices = $this->input->post('price_id');
    $qtys = $this->input->post('qty');
    $stc_qtys = $this->input->post('stc_qty');
    $amounts = $this->input->post('amount');
    $sub_total = $this->input->post('sub_total');
    $bill_no = $this->input->post('bill_no'); 

    // Get the user's name from add_purchase table
    $user_name = $this->Main_model->getUserNameByBillNo($bill_no);

    // Prepare order data
    $order_data = [];
    for ($i = 0; $i < count($categories); $i++) {
        $order_data[] = [
            'bill_no' => $bill_no,
            'requested_name' => $user_name, // Store requested name from database
            'category' => $categories[$i],
            'items' => $items[$i],
            'price' => $prices[$i],
            'qty' => $qtys[$i],
            'stc_qty' => $stc_qtys[$i],
            'amount' => $amounts[$i],
            'sub_total' => $sub_total,
            'created_at' => date('Y-m-d H:i:s')
        ];
    }

    // Insert order batch
    if ($this->Main_model->insert_order_batch($order_data)) {
        $this->session->set_flashdata('success', 'Order placed successfully!');
    } else {
        $this->session->set_flashdata('error', 'Failed to place order.');
    }

    redirect('welcome/view_details/' . $bill_no);
}

//---------------------------

 public function sales_report_page()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $result['get_sales'] = $this->Main_model->getAllsales();
    $this->load->view('admin/reports/sales_report', $result);
    $this->load->view('admin/footer');
}
//---------------------------
 public function sales_bill_page()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');

    $this->load->view('admin/header');
    $data['salesmen'] = $this->Main_model->getSalesmen();
    $this->load->view('admin/reports/all_sales_bill', $data);
    $this->load->view('admin/footer');
}

public function filter_sales_bills()
{
    $salesman_name = $this->input->post('salesman_name');
    $order_date = $this->input->post('order_date');

    // Debugging logs
    log_message('debug', 'Salesman Name: ' . $salesman_name);
    log_message('debug', 'Order Date: ' . $order_date);

    $filteredData = $this->Main_model->getSales_bills($salesman_name, $order_date);

    echo json_encode($filteredData);
}

public function getSalesDetails() {
    $bill_no = $this->input->post('bill_no', TRUE); // Sanitize input

    $this->db->where('bill_no', $bill_no);
    $query = $this->db->get('sales_orders');

    if ($query->num_rows() > 0) {
        $data = $query->result_array();

        // Ensure the fields exist in the response
        foreach ($data as &$row) {
            $row['quantity_stc'] = isset($row['quantity_stc']) ? $row['quantity_stc'] : 0;
            $row['sales'] = isset($row['sales']) ? $row['sales'] : 0;
            $row['return_qty'] = isset($row['return_qty']) ? $row['return_qty'] : 0;
            $row['amount'] = isset($row['amount']) ? floatval($row['amount']) : 0; // Ensure numerical value
        }

        // Ensure correct summation
        $total_amount = array_sum(array_map('floatval', array_column($data, 'amount')));

        echo json_encode(["status" => "success", "data" => $data, "total_amount" => $total_amount]);
    } else {
        echo json_encode(["status" => "error", "message" => "No records found"]);
    }
}

//----------------------------
 public function category_wise_report()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $this->load->view('admin/reports/cat_wise_sales');
    $this->load->view('admin/footer');
}

public function fetch_category_wise_report()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');

    $order_date = $this->input->post('orderDate'); // Get selected date from AJAX request

    // Fetch filtered data from the model
    $result = $this->Main_model->getCategory_sales_by_date($order_date);
    
    echo json_encode($result); // Return data in JSON format
}

//------------------------------
 public function product_wise_report()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $this->load->view('admin/reports/prod_wise_sales');
    $this->load->view('admin/footer');
}

public function fetch_item_wise_report()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');

    $order_date = $this->input->post('orderDate'); // Get selected date from AJAX request

    // Fetch filtered data from the model
    $result = $this->Main_model->getItem_sales_by_date($order_date);
    
    echo json_encode($result); // Return data in JSON format
}

//-----------------------
public function payment_report()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $data['salemen'] = $this->Main_model->getSalemen();
    // $data['getsalesbills'] = $this->Main_model->getSales_bills();
    $this->load->view('admin/reports/sales_payment', $data);
    $this->load->view('admin/footer');
}

public function filter_payment()
{
    $salesman_name = $this->input->post('salesman_name');
    $order_date = $this->input->post('order_date');

    log_message('debug', 'Salesman Name: ' . $salesman_name);
    log_message('debug', 'Order Date: ' . $order_date);

    $filteredData = $this->Main_model->get_payment_rep($salesman_name, $order_date);

    echo json_encode($filteredData);
}

//---------------------------
public function cofirm_order_list()
{
    if (!$this->session->userdata('user_id')) redirect('admin-login');
    
    // Load the necessary views
    $this->load->view('admin/header');
    $this->load->view('admin/reports/confirm_order_list');
    $this->load->view('admin/footer');

}

public function filter_order_list()
{
    $order_date = $this->input->post('order_date');

    log_message('debug', 'Order Date: ' . $order_date);

    $filteredData = $this->Main_model->getOrder_list($order_date);

    echo json_encode($filteredData);
}

public function getOrder_details() {
    $bill_no = $this->input->post('bill_no', TRUE); // Sanitize input

    $this->db->where('bill_no', $bill_no);
    $query = $this->db->get('order_list');

    if ($query->num_rows() > 0) {
        $data = $query->result_array();

        // Ensure the fields exist in the response
        foreach ($data as &$row) {
            $row['qty'] = isset($row['qty']) ? $row['qty'] : 0;
            $row['stc_qty'] = isset($row['stc_qty']) ? $row['stc_qty'] : 0;
        }

        // Ensure correct summation
        $total_amount = array_sum(array_map('floatval', array_column($data, 'amount')));

        echo json_encode(["status" => "success", "data" => $data, "total_amount" => $total_amount]);
    } else {
        echo json_encode(["status" => "error", "message" => "No records found"]);
    }
}

}