<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
	public function __construct(){
		header( 'Access-Control-Allow-Origin: *' );
		if ( $_SERVER[ 'REQUEST_METHOD' ] == "OPTIONS" )
		{
			log_message( 'debug', 'Configure webserver to handle OPTIONS-request without invoking this script' );
			header( 'Access-Control-Allow-Credentials: true' );
			header( 'Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS' );
			header( 'Access-Control-Allow-Headers: ACCEPT, ORIGIN, X-REQUESTED-WITH, CONTENT-TYPE, AUTHORIZATION' );
			header( 'Access-Control-Max-Age: 86400' );
			header( 'Content-Length: 0' );
			header( 'Content-Type: text/plain' );
			exit ;
		}
		parent::__construct();
	}
	public function json($response){
		$this->output
			->set_content_type('application/json')
			->set_output(json_encode($response));
	}
	public function index(){
		$response["status"]		= true;
		$response["message"]	= "1.0.1";
		$this->json($response);
	}
	public function tambah($table){
		$data			= [];
		$post 			= json_decode($this->security->xss_clean($this->input->raw_input_stream));
		foreach($post as $key => $val){  
			$data[$key]	= $val;
		} 
		if(isset($_GET['id_perusahaan'])){
			
			$jwt					= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
			if($jwt->tipe=="perusahaan"){
				$data['id_perusahaan']	=	$jwt->id_perusahaan;
			}else{
				$data['id_perusahaan']	= $_GET['id_perusahaan'];
			}
		}
		$data["dibuat"]	= date("Y-m-d H:i:s");
		$execute				= $this->db->insert($table, $data);
		$response["status"]		= $execute;
		$response["message"]	= "Data berhasil ditambahkan";	
		$this->json($response);
	}
	public function ubah($table, $id){
		$data			= [];
		$post 			= json_decode($this->security->xss_clean($this->input->raw_input_stream));
		foreach($post as $key => $val){  
			$data[$key]	= $val;
		} 
		$data["diubah"]	= date("Y-m-d H:i:s");
		if($table=='perusahaan'){
			$jwt				= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
			if($jwt->tipe=='perusahaan'){
				$id					= $jwt->id_perusahaan;
			}
		}
		$this->db->where("id", $id);
		$execute				= $this->db->update($table, $data);
		$response["status"]		= $execute;
		$response["message"]	= "Data berhasil diubah";	
		$this->json($response);
	}
	public function hapus($table, $id){
		$this->db->where("id", $id);
		$execute				= $this->db->delete($table);
		$response["status"]		= $execute;
		$response["message"]	= "Data berhasil dihapus";	
		$this->json($response);
	}
	public function data($table, $field=null, $value=null){
		if($field!=null){
			if($field=='id_perusahaan'){
				$jwt					= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
				if($jwt->tipe=="perusahaan"){
					$value		=	$jwt->id_perusahaan;
				}
			}
			$this->db->where($field, $value);
		}
		$execute				= $this->db->get($table);
		$response["status"]		= true;
		$response["message"]	= "";	
		$response["data"]		= $execute->result();	
		$this->json($response);
	}
	public function query($table){
		$where					= $this->input->get("where");
		$jwt					= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
		if($where){
			if($jwt->tipe=="desa"){
				if($table=="master_provinsi"){
					$this->db->where("id", $jwt->id_provinsi);
				}
				else if($table=="master_kabupaten"){
					$this->db->where("id", $jwt->id_kabupaten);
				}
				else if($table=="master_kecamatan"){
					$this->db->where("id", $jwt->id_kecamatan);
				}
				else if($table=="master_kecamatan"){
					$this->db->where("id", $jwt->id_kecamatan);
				}
				else if($table=="master_desa"){
					$this->db->where("id", $jwt->id_desa);
				}
			}
			$this->db->where($where, null, false);
		}
		$execute				= $this->db->get($table);
		$response["status"]		= true;
		$response["message"]	= "";	
		$response["data"]		= $execute->result();	
		$this->json($response);
	}
	public function detil($table, $id, $field="id"){
		$jwt					= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
		if($jwt->tipe=="perusahaan" && $table!="pengumuman"){
			$id	=	$jwt->id_perusahaan;
		}
		$this->db->where($field, $id);
		$execute				= $this->db->get($table);
		$response["status"]		= true;
		$response["message"]	= "";	
		$response["data"]		= $execute->last_row();	
		$this->json($response);
	}
	public function dasborPerusahaan(){
		$data["total_perusahaan"]	= $this->db->query("select count(id) as total from perusahaan")->last_row()->total ;
		$data["luas_lokasi"]		= $this->db->query("select sum(lokasi_luas) as total from perusahaan_legalitas")->last_row()->total ;
		$data["luas_ppub"]			= $this->db->query("select sum(ppub_luas) as total from perusahaan_legalitas")->last_row()->total ;
		$data["luas_ipl"]			= $this->db->query("select sum(ipl_luas) as total from perusahaan_legalitas")->last_row()->total ;
		$response["status"]			= true;
		$response["message"]		= "";	
		$response["data"]			= $data;	
		$this->json($response);
	}
	public function upload(){
		$config = array(
            'upload_path'   => './uploads/',
            'allowed_types' => '*',
        );

        $this->load->library('upload', $config);
		$file				= "";
		if ($this->upload->do_upload('files')) {
			$response["status"]			= true;
			$response["message"]		= "";	
			$file = "/uploads/".$this->upload->data()["file_name"];
		}else{
			$response["status"]			= false;
			$file = $this->upload->display_errors();
		}
		
		$response["message"]		= "";	
		$response["data"]			= $file;	
		$this->json($response);
	}

	public function tambah_master_kk_anggota(){
		$table			= "master_kk_anggota";
		$data			= [];
		$post 			= json_decode($this->security->xss_clean($this->input->raw_input_stream));
		// foreach($post as $key => $val){  
		// 	$data[$key]	= $val;
		// } 
		// if(isset($_GET['id_perusahaan'])){
			
		// 	$jwt					= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
		// 	if($jwt->tipe=="perusahaan"){
		// 		$data['id_perusahaan']	=	$jwt->id_perusahaan;
		// 	}else{
		// 		$data['id_perusahaan']	= $_GET['id_perusahaan'];
		// 	}
		// }
		$data["dibuat"]	= date("Y-m-d H:i:s");
		$execute				= $this->db->insert_batch($table, $post);
		$response["status"]		= $execute;
		$response["message"]	= "Data berhasil ditambahkan";	
		$this->json($response);
	}
}
