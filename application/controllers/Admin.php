<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model');
		$this->load->model('Product_model');
		$this->load->model('User_model');
	}
	public function List_Merchant($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){ 
                $leveluser = 'Administrator'; 
            }else{ 
                $leveluser = 'Merchant'; 
            } 
            $id         = $this->session->userdata('logged_id'); 
            $limit         = 10; 
            if(!is_null($offset)){ 
                $offset = $this->uri->segment(3); 
            }
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/Admin/List_Merchant';
			$config['total_rows'] = $this->Admin_model->Count_Merchant();
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
			$masuk		= "Pesanan ditujukan ke Merchant";
			$record 	= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$merchant 	= $this->Admin_model->Merchant();
			$data = [
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
				'ListMerchant'	=> $this->Admin_model->GetDataMerchant($limit,$offset),
				'username'	=> $record->username,
				'trans'		=> $trans,
				'main_view'	=> 'List_Merchant',
				'nameAccess'=> $leveluser,
				'Merchant'	=> $merchant,
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()

			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function List_Buyer($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){ 
                $leveluser = 'Administrator'; 
            }else{ 
                $leveluser = 'Merchant'; 
            } 
            $id         = $this->session->userdata('logged_id'); 
            $limit         = 10; 
            if(!is_null($offset)){ 
                $offset = $this->uri->segment(3); 
            }
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/Admin/List_Buyer';
			$config['total_rows'] = $this->Admin_model->Count_Buyer();
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
			$masuk		= "Pesanan ditujukan ke Merchant";
			$record 	= $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$merchant 	= $this->Admin_model->Merchant();
			$data = [
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
				'Cancel'	=> $this->Product_model->Count_OrderCancel(),
				'ListMerchant'	=> $this->Admin_model->GetDataBuyer($limit,$offset),
				'username'	=> $record->username,
				'trans'		=> $trans,
				'main_view'	=> 'List_Buyer',
				'nameAccess'=> $leveluser,
				'Merchant'	=> $merchant,
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function Product_List()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id = $this->session->userdata('logged_id');
			$masuk		= "Menunggu Pembayaran";
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$record = $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$products = $this->Admin_model->Product();
			$data = [
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
				'CProduct'	=> $this->Admin_model->Count_Buyer(),
				'trans'		=> $trans,
				'product' 	=> $products, 
				'id' 		=> $record->id, 
				'username' 	=> $record->username, 
				'main_view' => 'Product_list',
				'nameAccess'	=> $leveluser,
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()
				];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function CariMerchant(){
		$id = $this->input->post('id');
        $data = $this->Admin_model->GetData(array('id' => $id), 'user_merchant');
        echo $data->id."|".$data->username."|".$data->phone."|".$data->email."|".$data->address."|".$data->last_update;
	}
	public function Transaction_Success($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id 		= $this->session->userdata('logged_id');
			$limit = 10;
			$where = array('product_order_detail.status' => 'Selesai');
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/Admin/Transaction_Success';
			$config['total_rows'] = $this->Admin_model->Total_Records_Transaction($where);
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
			$A_Transaction = $this->Admin_model->Order(array("product_order_detail.status" => $berhasil));
			$data=
			[
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
				//'transaksi'	=> $this->Product_model->orderin($where,$limit,$offset),
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
				'A_Transaction' => $this->Admin_model->GetDataOrder($where,$limit,$offset),
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}

	public function Transaction_Masuk($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id 		= $this->session->userdata('logged_id');
			$limit = 10;
			$where = array('product_order_detail.status' => 'Pesanan Ditujukan Ke Merchant');
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/Admin/Transaction_Masuk';
			$config['total_rows'] = $this->Admin_model->Total_Records_Transaction($where);
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
			$A_Transaction = $this->Admin_model->Order(array("product_order_detail.status" => $masuk));
			$data=
			[
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
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
				'A_Transaction' => $this->Admin_model->GetDataOrder($where,$limit,$offset),
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function Transaction_Batal($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id 		= $this->session->userdata('logged_id');
			$limit = 10;
			$where = array('product_order_detail.status' => 'Order Dibatalkan');
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/Admin/Transaction_Batal';
			$config['total_rows'] = $this->Admin_model->Total_Records_Transaction($where);
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
			$A_Transaction = $this->Admin_model->Order(array("product_order_detail.status" => $batal));
			$data=
			[
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
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
				'A_Transaction' => $this->Admin_model->GetDataOrder($where,$limit,$offset),
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function Transaction_Kirim($offset = NULL)
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id 		= $this->session->userdata('logged_id');
			$limit = 10;
			$where = array('product_order_detail.status' => 'Proses Kirim');
			if(!is_null($offset))
			{
				$offset = $this->uri->segment(3);
			}
			$this->load->library('Pagination');
			$config['uri_segment'] = 3;
			$config['base_url'] = base_url().'index.php/Admin/Transaction_Batal';
			$config['total_rows'] = $this->Admin_model->Total_Records_Transaction($where);
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
			$A_Transaction = $this->Admin_model->Order(array("product_order_detail.status" => $pengiriman));
			$data=
			[
				'Confirm'	=> $this->Admin_model->Trans_Masuk(),
				'Sent'		=> $this->Admin_model->Trans_Kirim(),
				'Finish'	=> $this->Admin_model->Trans_Selesai(),
				'Cancel'	=> $this->Admin_model->Trans_Batal(),
				'CMerchant'	=> $this->Admin_model->Count_Merchant(),
				'CBuyer'	=> $this->Admin_model->Count_Buyer(),
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
				'A_Transaction' => $this->Admin_model->GetDataOrder($where,$limit,$offset),
				'A_AmountProduct'	  =>  $this->Admin_model->Count_Product()
			];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function CariProduk(){
		$id = $this->input->post('id');
        $data = $this->Admin_model->GetDataProduct(array('product.id' => $id));
        echo $data->proid."|".$data->product_name."|".$data->username."|".$data->cat_name."|".$data->status."|".$data->description."|".$data->price."|".$data->stock;
	}
	public function Edit_Product()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			if($this->session->userdata('leveluser') == 1){
				$leveluser = 'Administrator';
			}else{
				$leveluser = 'Merchant';
			}
			$id = $this->session->userdata('logged_id');
			$aw = $this->Product_model->GetData(array("id" => $id) , 'user_merchant');
			$id = $this->uri->segment(3);
			$masuk		= 'Pesanan ditujukan ke Merchant';
			$product = $this->Admin_model->GetDataProduct(array("product.id" => $id) , 'Product');
			$trans	 	= count($this->Product_model->Order(array("merchant_id" => $id, "product_order_detail.status" => $masuk), 'product_order_detail'));
			$data = [
				'Confirm'		=> $this->Product_model->Count_OrderMerchant(),
				'Sent'			=> $this->Product_model->Count_OrderSent(),
				'Finish'		=> $this->Product_model->Count_OrderFinish(),
				'Cancel'		=> $this->Product_model->Count_OrderCancel(),
				'trans'     => $trans,
				'main_view' => 'Admin_EditProduct', 
				'username' 	=> $aw->username, 
				//'id' 		=> $product->id, 
				'nameAccess'=> $leveluser
				];
			$this->load->view('template', $data);
		}
		else {
			redirect('Auth');
		}
	}
	public function Update_Product()
	{
		if ($this->session->userdata('logged_in') == TRUE) {
			$id = $this->uri->segment(3);
			if ($this->input->post('submit')) {
				$this->form_validation->set_rules('id_produk', 'ID Product', 'trim|required');
				$this->form_validation->set_rules('product', 'Nama Product', 'trim|required');
				$this->form_validation->set_rules('harga', 'Harga', 'trim|required');
				$this->form_validation->set_rules('stock', 'Stock', 'trim|required');
				$this->form_validation->set_rules('description', 'Description', 'trim|required');
				if ($this->form_validation->run() == TRUE) {
					if ($this->Product_model->edit_product() == TRUE) {
						redirect('Admin/Product_List');
					}
					else {
						$data['notif'] = 'Update gagal';
						$data['main_view'] = 'edit_Product';
						$this->load->view('template', $data);
					}
				}
				else {
					$data['notif'] = validation_errors();
					$data['main_view'] = 'edit_Product';
					$this->load->view('template', $data);
				}
			}
			else {
				$data['main_view'] = 'edit_Product';
				$this->load->view('template', $data);
			}
		}
		else {
			redirect('Auth');
		}
	}
	public function discussion()
	{

	}
	public function feedback()
	{

	}
	public function broadcast()
	{

	}
	
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */