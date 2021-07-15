<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {
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
	public function masukGoogle(){
		// setdata
		$data			= [];
		$post 			= json_decode($this->security->xss_clean($this->input->raw_input_stream));

		$crl 			= curl_init("https://www.googleapis.com/oauth2/v3/userinfo");
		$headr 			= array();
		$headr[] 		= 'Authorization: '.$post->token;
		curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
		$google			= json_decode(curl_exec($crl));
		
		// set reponse
		$response["status"]		= !isset($google->error);
		$response["message"]	= !$response["status"]?"Unauthorized":"";
		// $response["data"]		= $google;
		
		$this->db->select("id");
		$this->db->where("email", $google->email);
		$this->db->where("tipe", $post->tipe);
		$akun		= $this->db->get("akun");
		
		// set data
		$data["nama"]			= $google->name;
		$data["gambar"]			= $google->picture;
		$data["terakhir_masuk"]	= date("Y-m-d H:i:s");
		$data["email"]			= $google->email;
		$data["sub"]			= $google->sub;

		// jika akun nya ada
		if($akun->num_rows()>0){
			$akun				= $akun->last_row();
			$jwt["id_akun"]		= $akun->id;
			$this->db->where("id", $akun->id);
			$this->db->update("akun", $data);
		}else{
			if($post->tipe=="desa" || $post->tipe=="kecamatan"){
				$data["tipe"]	= $post->tipe;
				$this->db->insert("akun", $data);
				$jwt["id_akun"]			= $this->db->insert_id();
			}else{
				$response["status"]		= false;
				$response["message"]	= "email ini tidak terdaftar";
			}
		}

		if($response["status"]){
			$jwt["tipe"]		= $post->tipe;
			if($post->tipe=="desa"){
				$this->db->where("email_pengelola", $google->email);
				$desa	= $this->db->get("master_desa");
				if($desa->num_rows()>0){
					$desa				= $desa->last_row();
					$query				= $this->db->query("select 
												master_desa.id as id_desa,
												master_kecamatan.id as id_kecamatan,
												master_kabupaten.id as id_kabupaten,
												master_kabupaten.id_provinsi
											from master_desa
											left join master_kecamatan on master_kecamatan.id = master_desa.id_kecamatan
											left join master_kabupaten on master_kabupaten.id = master_kecamatan.id_kabupaten
											where master_desa.id='".$desa->id."'")->last_row();
					$jwt["id_desa"]		= $query->id_desa;
					$jwt["id_kecamatan"]= $query->id_kecamatan;
					$jwt["id_kabupaten"]= $query->id_kabupaten;
					$jwt["id_provinsi"]	= $query->id_provinsi;
				}else{
					$response["status"]		= false;
					$response["message"]	= "email ini tidak terdaftar";
				}
			}else if($post->tipe=="kecamatan"){
				$this->db->where("email_pengelola", $google->email);
				$desa	= $this->db->get("master_kecamatan");
				if($desa->num_rows()>0){
					$kecamatan			= $desa->last_row();
					$query				= $this->db->query("select 
												master_kecamatan.id as id_kecamatan,
												master_kabupaten.id as id_kabupaten,
												master_kabupaten.id_provinsi
											from master_kecamatan
											left join master_kabupaten on master_kabupaten.id = master_kecamatan.id_kabupaten
											where master_kecamatan.id='".$kecamatan->id."'")->last_row();
					$jwt["id_kecamatan"]= $query->id_kecamatan;
					$jwt["id_kabupaten"]= $query->id_kabupaten;
					$jwt["id_provinsi"]	= $query->id_provinsi;
				}else{
					$response["status"]		= false;
					$response["message"]	= "email ini tidak terdaftar";
				}
			}
			$response["data"]	= jwt::encode($jwt, $this->config->item("jwt_key"));
		}
		
		$this->json($response);
	}
	public function ubah($table, $id){
		$data			= [];
		$post 			= json_decode($this->security->xss_clean($this->input->raw_input_stream));
		foreach($post as $key => $val){  
			$data[$key]	= $val;
		} 
		$data["diubah"]	= date("Y-m-d H:i:s");
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
	public function data($table){
		$execute				= $this->db->get($table);
		$response["status"]		= $execute;
		$response["message"]	= "";	
		$response["data"]		= $execute->result();	
		$this->json($response);
	}
	public function detil($table, $id){
		$this->db->where("id", $id);
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
}
