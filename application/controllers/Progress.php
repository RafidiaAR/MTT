	<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Progress extends CI_Controller

{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Product_model');
		$this->load->library('pagination');
		$this->load->model('Admin_model');
	}

	public 	function index()
	{
		if ($this->session->userdata('logged_in') == true) {
			redirect('Page');
		}
		else {
			redirect('Auth/login');
		}
	}
	public function add_product()
	{
		if ($this->session->userdata('logged_in') == true) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id = $this->session->userdata('logged_id');
			$record 	= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$record2 	= $this->Product_model->GetAllData('Category');
			$int = (int) $this->Product_model->GetLastId('Product', 'id');
            $newid = $int + 1;
            $masuk		= "Pesanan ditujukan ke Merchant";
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$data = [
				'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
				'Sent'			=> $this->Product_model->Count_OrderSent(),
				'Finish'		=> $this->Product_model->Count_OrderFinish(),
				'Cancel'		=> $this->Product_model->Count_OrderCancel(),
				'trans'			=> $trans,
				'main_view'		=> 'add_product',
				'merchant_id'	=> $record->id,
				'username'		=> $record->username,
				'id_product'	=> $newid,
				'category'		=> $record2,
				'nameAccess'	=> $leveluser,
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth/login');
		}
	}
	public function List_merchant()
	{
		if($this->session->userdata('logged_in') == TRUE)
		{

		}else{

		}
	}
	public function profile(){
		if ($this->session->userdata('logged_in') == true) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id = $this->session->userdata('logged_id');

			$masuk		= "Pesanan ditujukan ke Merchant";
			$record = $this->Product_model->GetData(array("id" => $id) , 'User_merchant');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$data = [
				'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
				'Sent'			=> $this->Product_model->Count_OrderSent(),
				'Finish'		=> $this->Product_model->Count_OrderFinish(),
				'Cancel'		=> $this->Product_model->Count_OrderCancel(),
				'trans'		=> $trans,	
				'main_view' => 'edit_Product', 
				'id' 		=> $record->id, 
				'username' 	=> $record->username, 
				'email' 	=> $record->email, 
				'phone' 	=> $record->phone,
				'almt'		=> $record->address,
				'nik'		=> $record->nik_tsel,
				'nameAccess'	=> $leveluser
				];

			$data['main_view'] = 'profile';
			$this->load->view('template',$data);
		}
		else {
			redirect('Auth/login');
		}
	}
	public	function transaction($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id 		= $this->session->userdata('logged_id');
			$limit = 10;
			$where = array('merchant_id' => $this->session->userdata('logged_id'),
                           'product_order_detail.status' => 'Pesanan ditujukan ke Merchant');
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/progress/transaction';
			$config['total_rows'] = $this->Product_model->total_record_transaction($where);
			$config['per_page'] = $limit;
			$config['num_links'] = 3;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$this->pagination->initialize($config);
			//$b = $this->Product_model->feedback(array("merchant_id" => $id),'product_order_detail');

			
			$batal		= "Order Dibatalkan";
			$berhasil	= "Selesai";
			$pengiriman	= "Proses Kirim";
			$masuk		= "Pesanan ditujukan ke Merchant";
			$wher		= "merchant_id = "+$id+",product_order_detail.status = "+$masuk+",product_order_detail";
			$record 	= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$stock 		= $this->Product_model->Stock(array("product_order_detail.merchant_id" => $id), 'product_order_detail');
			$product 	= $this->Product_model->Order(array("merchant_id" => $id), 'product_order');
			$failed 	= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $batal), 'product_order_detail');
			$success 	= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $berhasil), 'product_order_detail');
			$wait	 	= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail');
			$sent 		= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $pengiriman), 'product_order_detail');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$count 		= count($wait);
			$data=
			[
				'Confirm'	=> $this->Product_model->Count_OrderMerchant(),
				'Sent'		=> $this->Product_model->Count_OrderSent(),
				'Finish'	=> $this->Product_model->Count_OrderFinish(),
				'Cancel'	=> $this->Product_model->Count_OrderCancel(),
				'transaksi'	=> $this->Product_model->orderin($where,$limit,$offset),
			//	'feedback'	=> $b,
				'stock'		=> $stock,
				'wait'		=> $wait,
				'sent'		=> $sent,
				'success'	=> $success,
				'fail'		=> $failed,
				'order'		=> $product,
				'username'	=> $record->username,
				'trans'		=> $trans,
				'main_view'	=>	'transaction',
				'nameAccess'=> $leveluser,
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}

	public function discussion(){
		if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$masuk ="Pesanan ditujukan ke Merchant";
			$id = $this->session->userdata('logged_id');
			$list_discuss = $this->Product_model->GetDiscussList(array("product.merchant_id" => $id));
			$record = $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$trans = count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));

				$data=
			[	
				'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
				'Sent'			=> $this->Product_model->Count_OrderSent(),
				'Finish'		=> $this->Product_model->Count_OrderFinish(),
				'Cancel'		=> $this->Product_model->Count_OrderCancel(),
				'list_discuss'	=> $list_discuss,
				'username'		=> $record->username,
				'trans'			=> $trans,
				'main_view'	=>	'Discussion',
				'nameAccess'	=> $leveluser

			];
			$this->load->view('template', $data);
	}
	public function discussion_detail(){
		if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$masuk 			="Pesanan ditujukan ke Merchant";
			$id 			= $this->session->userdata('logged_id');
			$product_id 	= $this->uri->segment(3);
			$product_name 	= $this->Product_model->GetData(array("id" => $product_id) , 'product');
			$detail_discuss = $this->Product_model->GetDiscussDetail(array("discussion.product_id" => $product_id));
			$record 		= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$trans 			= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));

				$data=
			[	
				'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
				'Sent'			=> $this->Product_model->Count_OrderSent(),
				'Finish'		=> $this->Product_model->Count_OrderFinish(),
				'Cancel'		=> $this->Product_model->Count_OrderCancel(),
				'product'		=> $product_name,
				'detail_discuss'	=> $detail_discuss,
				'username'		=> $record->username,
				'trans'			=> $trans,
				'main_view'	=>	'Discussion_detail',
				'nameAccess'	=> $leveluser
			];
			$this->load->view('template', $data);
	}

	public	function feedback()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id 				= $this->session->userdata('logged_id');
			$masuk				= "Pesanan ditujukan ke Merchant";
			$Selesai 			= "Selesai";
			$feedback	 		= $this->Product_model->Get_Feedback(array("merchant_id" => $id, "product_order_detail.status" => $Selesai), 'product_order_detail');
			$trans	 			= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$record 			= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$data 				= 
			[
				'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
				'Sent'			=> $this->Product_model->Count_OrderSent(),
				'Finish'		=> $this->Product_model->Count_OrderFinish(),
				'Cancel'		=> $this->Product_model->Count_OrderCancel(),
				'username'	=> $record->username,
				'trans'		=> $trans,
				'feedback'	=> $feedback,
				'main_view'	=> 'feedback',
				'nameAccess'	=> $leveluser
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function OrderSent($offset = NULL)
	{
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$masuk		= "Pesanan ditujukan ke Merchant";
			$pengiriman	= "Proses Kirim";
			$id 		= $this->session->userdata('logged_id');
			$record 	= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$sent 		= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $pengiriman), 'product_order_detail');
			$limit 		= 10;
			$where 		= array('merchant_id' => $id,
                           'product_order_detail.status' => $pengiriman);
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/progress/OrderSent';
			$config['total_rows'] = $this->Product_model->total_record_transaction($where);
			$config['per_page'] = $limit;
			$config['num_links'] = 3;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$this->pagination->initialize($config);

			
		$data = 
		[
		'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
		'Sent'			=> $this->Product_model->Count_OrderSent(),
		'Finish'		=> $this->Product_model->Count_OrderFinish(),
		'Cancel'		=> $this->Product_model->Count_OrderCancel(),
		'transaksi'	=> $this->Product_model->orderin($where,$limit,$offset),
		'main_view' => 'OrderSent',
		'trans'		=> $trans,
		'username'	=> $record->username,
		'sent'		=> $sent,
		'nameAccess'	=> $leveluser
		];
		$this->load->view('template',$data);
	}
	public function OrderFinish($offset = NULL)
	{
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$masuk		= "Pesanan ditujukan ke Merchant";
			$pengiriman	= "Proses Kirim";

			$berhasil	= "Selesai";
			$selesai 	= "Selesai";
			$id = $this->session->userdata('logged_id');
			$record = $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$success 	= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $berhasil), 'product_order_detail');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$sent 		= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $pengiriman), 'product_order_detail');
			$limit = 10;
			$where = array('merchant_id' => $id,
                           'product_order_detail.status' => $selesai);
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/progress/OrderFinish';
			$config['total_rows'] = $this->Product_model->total_record_transaction($where);
			$config['per_page'] = $limit;
			$config['num_links'] = 3;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$this->pagination->initialize($config);
		$data = 
		[
		'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
		'Sent'			=> $this->Product_model->Count_OrderSent(),
		'Finish'		=> $this->Product_model->Count_OrderFinish(),
		'Cancel'		=> $this->Product_model->Count_OrderCancel(),
		'transaksi'	=> $this->Product_model->orderin($where,$limit,$offset),
		'main_view' => 'OrderFinish',
		'trans'		=> $trans,
		'username'	=> $record->username,
		'success'	=> $success,
		'nameAccess'	=> $leveluser,
		'head'		=> 'Order Selesai'
		];
		$this->load->view('template',$data);
	}
	public function OrderCancel($offset = NULL)
	{
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$masuk		= "Pesanan ditujukan ke Merchant";
			$pengiriman	= "Proses Kirim";

			$berhasil	= "Selesai";
			$selesai 	= "Selesai";
			$cancel 	= "Order Dibatalkan";
			$id = $this->session->userdata('logged_id');
			$record = $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$success 	= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $berhasil), 'product_order_detail');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$sent 		= $this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $pengiriman), 'product_order_detail');
			$limit = 10;
			$where = array('merchant_id' => $id,
                           'product_order_detail.status' => $cancel);
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/progress/OrderCancel';
			$config['total_rows'] = $this->Product_model->total_record_transaction($where);
			$config['per_page'] = $limit;
			$config['num_links'] = 3;
			$config['full_tag_open'] = "<ul class='pagination'>";
			$config['full_tag_close'] = "</ul>";
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";
			$this->pagination->initialize($config);
		$data = 
		[
		'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
		'Sent'			=> $this->Product_model->Count_OrderSent(),
		'Finish'		=> $this->Product_model->Count_OrderFinish(),
		'Cancel'		=> $this->Product_model->Count_OrderCancel(),
		'transaksi'	=> $this->Product_model->orderin($where,$limit,$offset),
		'main_view' => 'OrderFinish',
		'trans'		=> $trans,
		'username'	=> $record->username,
		'success'	=> $success,
		'nameAccess'	=> $leveluser,
		'head'		=> 'Order Dibatalkan'
		];
		$this->load->view('template',$data);
	}
	public function CariProduk(){
		$id = $this->input->post('id');
        $data = $this->Product_model->GetData(array('id' => $id), 'product');
        echo $data->id."|".$data->name."|".$data->stock."|".$data->price."|".$data->description."|".$data->status."|".$data->last_update."|".$data->image;
	}
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
