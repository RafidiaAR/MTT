<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

	public function add_product($foto){
        $this->db->insert('product', array(
            'merchant_id'   => $this->input->post('merchant_id'),
            'id'       		=> $this->input->post('id_produk'),
            'name'         	=> $this->input->post('product'),
            'image'      	=> $foto['file_name'],
            'price'			=> $this->input->post('harga'),
            'stock'        	=> $this->input->post('stock'),
            'description'  	=> $this->input->post('description'),
            'category_id'   => $this->input->post('category')
        ));
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function edit_product(){
        $id = $this->input->post('id_produk');
        $this->db->where(['id'=>$id])->update('product', array(
            'name'           => $this->input->post('product'),
            'price'          => $this->input->post('harga'),
            'stock'          => $this->input->post('stock'),
            'description'    => $this->input->post('description'),
          ));
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function product($where){
    return $this->db->select('*, product.name as product_name, user_merchant.name as merchant_name, product.id as pro_id')
                    ->where($where)
                    ->join('user_merchant', 'product.merchant_id = user_merchant.id')
                    ->get('product')
                    ->result();
    }
    public function order($where){
    return $this->db->select('*, product_order.id as id_order, product_order_detail.id as id_detail,product_order.status as status_order,product_order_detail.status as status_detail')
                    ->where($where)
                    ->join('product_order', 'product_order.id = product_order_detail.order_id')
                    ->get('product_order_detail')
                    ->result();
    
    }
    public function orderin($where,$limit,$offset){
    return $this->db->select('*')
                    ->from('product_order')
                    ->join('product_order_detail', 'product_order.id = product_order_detail.order_id')
                    ->where($where)
                    ->order_by('product_order.id','ASC')
                    ->limit($limit,$offset)
                    ->get()
                    ->result();
    }
    public function total_record_transaction($where)
    {
        $this->db->select('*')
                    ->from('product_order')
                    ->join('product_order_detail', 'product_order.id = product_order_detail.order_id')
                    ->where($where)
                    ->order_by('product_order.id','ASC');
        return $this->db->count_all_results();
        //return $this->db->count_all('product_order','product_order_detail');
    }
    public function GetDataOrderIn($limit,$start,$where)
    {   
        return $this->db->limit($limit,$start)
                        ->select('*, product_order.id as id_order, product_order_detail.id as id_detail,product_order.status as status_order,product_order_detail.status as status_detail')
                        ->where($where)
                        ->join('product_order', 'product_order.id = product_order_detail.order_id')
                        ->get('product_order_detail')
                        ->result();
    }
    public function stock($where){
    return $this->db->select('*, product.id as id_product,product_order_detail.id as id_detail, product.merchant_id as id_merchant')
                    ->where($where)
                    ->join('product', 'product.id = product_order_detail.product_id')
                    ->get('product_order_detail')
                    ->result();
    }
    public function Get_Feedback($where)
    {
       return $this->db->select('*, product_order.id as id_order, product_order_detail.id as id_detail,product_order.status as status_order,product_order_detail.status as status_detail, product_order_detail.last_update as tgl_update')
                    ->where($where)
                    ->join('product_order', 'product_order.id = product_order_detail.order_id')
                    ->get('product_order_detail')
                    ->result();
    }

    public function delete($where, $table)
    {
        $query = $this->db->where($where)->delete($table);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function del_product($id){
        $this->db->where('id',$id)
                 ->delete('Product');
      
        if ($this->db->affected_rows() > 0) {
            return "true";
        } else {
            return "false";
        }
    }
    public function acc_order($product_id,$amount,$last_update,$order_id,$stats){
        $stock = $this->GetData(['id'=>$product_id], 'product')->stock;
        $newstock = $stock - $amount;
        $this->db->where(['id'=>$product_id])->update('product', array(
            'stock'         => $newstock,
            'last_update'   => $last_update
          ));

        $this->db->where(['product_order_detail.id'=>$order_id])->update('product_order_detail', array(
            'status'    =>$stats
          ));
        
        
        if ($this->db->affected_rows() > 0) {
            return "true";
        } else {
            return "false";
        }       
    }
    public function send_comment($product_id,$comment){
        $id = $this->session->userdata('logged_id');
        $this->db->insert('discussion', array(
            'level'        => '1',
            'id_user'      => $id,
            'product_id'   => $product_id,
            'merchant_id'  => $id,
            'comment'      => $comment,
            ));

        
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }       
    }
    public function Change_Status($id,$status){
        $this->db->where(['product_order_detail.id'=>$id])->update('product_order_detail', array(
            'status'    =>$status
          ));
        if ($this->db->affected_rows() > 0) {
            return "true";
        } else {
            return "false";
        }       
    }

    public function GetDiscussDetail($where){
        return $this->db->select('*, discussion.merchant_id as merchant_discuss, product.merchant_id as product_merchant, discussion.created_at as discussion_created, product.id as product_id, user_merchant.id as user_id, product.name as product_name, user_merchant.name as user_name')
                        ->where($where)
                        ->join('product', 'product.id = discussion.product_id')
                        ->join('user_merchant', 'user_merchant.id = discussion.id_user')
                        ->get('discussion')
                        ->result();
    }
    public function GetDiscussList($where){
        // return $this->db->select('*, discussion.merchant_id as merchant_discuss, product.merchant_id as product_merchant, discussion.created_at as discussion_created, count(comment) as count_comment')
        //             ->where($where)
        //             ->join('product', 'product.id = discussion.product_id')
        //             ->get('discussion')
        //             ->result();
        return $this->db->select('*, discussion.merchant_id as merchant_discuss, product.merchant_id as product_merchant, discussion.created_at as discussion_created')
                        ->where($where)
                        ->join('discussion', 'product.id = discussion.product_id')
                        ->group_by('product_id')
                        ->get('product')
                        ->result();
    }
    public function GetDisucssCount(){
        return $this->db->select('count(comment)')
                        // ->where($where)
                        ->join('product', 'product.id = discussion.product_id')
                        ->get('discussion')
                        ->result();
    }
    public function Count_OrderMerchant()
    {
        $this->db->select('*')
                    ->from('product_order')
                    ->join('product_order_detail', 'product_order.id = product_order_detail.order_id')
                    ->where(array('merchant_id' => $this->session->userdata('logged_id'),'product_order_detail.status' => 'Pesanan ditujukan ke Merchant'))
                    ->order_by('product_order.id','ASC');
        return $this->db->count_all_results();
        //return $this->db->count_all('product_order','product_order_detail');
    }
    public function Count_OrderSent()
    {
        $this->db->select('*')
                    ->from('product_order')
                    ->join('product_order_detail', 'product_order.id = product_order_detail.order_id')
                    ->where(array('merchant_id' => $this->session->userdata('logged_id'),'product_order_detail.status' => 'Proses Kirim'))
                    ->order_by('product_order.id','ASC');
        return $this->db->count_all_results();
        //return $this->db->count_all('product_order','product_order_detail');
    }
    public function Count_OrderFinish()
    {
        $this->db->select('*')
                    ->from('product_order')
                    ->join('product_order_detail', 'product_order.id = product_order_detail.order_id')
                    ->where(array('merchant_id' => $this->session->userdata('logged_id'),'product_order_detail.status' => 'Selesai'))
                    ->order_by('product_order.id','ASC');
        return $this->db->count_all_results();
        //return $this->db->count_all('product_order','product_order_detail');
    }
    public function Count_OrderCancel()
    {
        $this->db->select('*')
                    ->from('product_order')
                    ->join('product_order_detail', 'product_order.id = product_order_detail.order_id')
                    ->where(array('merchant_id' => $this->session->userdata('logged_id'),'product_order_detail.status' => 'Order Dibatalkan'))
                    ->order_by('product_order.id','ASC');
        return $this->db->count_all_results();
        //return $this->db->count_all('product_order','product_order_detail');
    }

    public function GetAllData($table)
    {
      return $this->db->get($table)->result();
    }
    public function GetListData($where, $table)
    {
      return $this->db->where($where)->get($table)->result();
    }
    public function GetData($where, $table)
    {
      return $this->db->where($where)->get($table)->row();
    }
    public function GetLastId($table, $field) {
        return $this->db->order_by($field, 'desc')->get($table)->row($field);
    }

}

/* End of file Product.php */
/* Location: ./application/models/Product.php */