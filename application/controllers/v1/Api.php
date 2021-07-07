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
		if($jwt->tipe=="desa" && $table=="master_desa"){
			$id					= $jwt->id_desa;
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
		$data["dibuat"]	= date("Y-m-d H:i:s");
		$execute				= $this->db->insert_batch($table, $post);
		$response["status"]		= $execute;
		$response["message"]	= "Data berhasil ditambahkan";	
		$this->json($response);
	}

	public function laporan_penduduk($id_desa){
		$query					= "
			-- laporan penduduk gabung
			select 
				-- penduduk
				master_dusun.nama,
				sum(if(jenis_kelamin='l',1,0)) as l,
				sum(if(jenis_kelamin='p',1,0)) as p,
				
				sum(if(status='lahir' && jenis_kelamin='l',1,0)) as l_lahir,
				sum(if(status='lahir' && jenis_kelamin='p',1,0)) as p_lahir,

				sum(if(status='mati' && jenis_kelamin='l',1,0)) as l_mati,
				sum(if(status='mati' && jenis_kelamin='p',1,0)) as p_mati,
				
				sum(if(status='keluar' && jenis_kelamin='l',1,0)) as l_keluar,
				sum(if(status='keluar' && jenis_kelamin='p',1,0)) as p_keluar,
				
				sum(if(status='datang' && jenis_kelamin='l',1,0)) as l_datang,
				sum(if(status='datang' && jenis_kelamin='p',1,0)) as p_datang,

				sum(if(status_hubungan_dalam_keluarga='kepala keluarga' && jenis_kelamin='l',1,0)) as l_kk,
				sum(if(status_hubungan_dalam_keluarga='kepala keluarga' && jenis_kelamin='p',1,0)) as p_kk,
				
				-- agama
				sum(if(agama='islam' && jenis_kelamin='l',1,0)) as l_islam,
				sum(if(agama='islam' && jenis_kelamin='p',1,0)) as p_islam,
				
				sum(if(agama='kristen' && jenis_kelamin='l',1,0)) as l_kristen,
				sum(if(agama='kristen' && jenis_kelamin='p',1,0)) as p_kristen,
				
				sum(if(agama='khatolik' && jenis_kelamin='l',1,0)) as l_khatolik,
				sum(if(agama='khatolik' && jenis_kelamin='p',1,0)) as p_khatolik,
				
				sum(if(agama='hindu' && jenis_kelamin='l',1,0)) as l_hindu,
				sum(if(agama='hindu' && jenis_kelamin='p',1,0)) as p_hindu,
				
				sum(if(agama='budha' && jenis_kelamin='l',1,0)) as l_budha,
				sum(if(agama='budha' && jenis_kelamin='p',1,0)) as p_budha,

				sum(if(agama='lainnya' && jenis_kelamin='l',1,0)) as l_lainnya,
				sum(if(agama='lainnya' && jenis_kelamin='p',1,0)) as p_lainnya,
				
				-- status perkawinan
				
				sum(if(status_perkawinan='belum' && jenis_kelamin='l',1,0)) as l_belum_kawin,
				sum(if(status_perkawinan='belum' && jenis_kelamin='p',1,0)) as p_belum_kawin,
				
				sum(if(status_perkawinan='kawin tercatat' && jenis_kelamin='l',1,0)) as l_kawin_tercatat,
				sum(if(status_perkawinan='kawin tercatat' && jenis_kelamin='p',1,0)) as p_kawin_tercatat,
				
				sum(if(status_perkawinan='belum tercatat' && jenis_kelamin='l',1,0)) as l_belum_tercatat,
				sum(if(status_perkawinan='belum tercatat' && jenis_kelamin='p',1,0)) as p_belum_tercatat,
				
				sum(if(status_perkawinan='cerai mati' && jenis_kelamin='l',1,0)) as l_cerai_mati,
				sum(if(status_perkawinan='cerai mati' && jenis_kelamin='p',1,0)) as p_cerai_mati,
				
				sum(if(status_perkawinan='cerai hidup' && jenis_kelamin='l',1,0)) as l_cerai_hidup,
				sum(if(status_perkawinan='cerai hidup' && jenis_kelamin='p',1,0)) as p_cerai_hidup,
				
				-- pendidikan
				sum(if(pendidikan='belum',1,0)) as belum_sekolah,
				sum(if(pendidikan='sd',1,0)) as sd,
				sum(if(pendidikan='smp',1,0)) as smp,
				sum(if(pendidikan='sma',1,0)) as sma,
				sum(if(pendidikan='d1' ,1,0)) as d1,
				sum(if(pendidikan='d2',1,0)) as d2,
				sum(if(pendidikan='d3',1,0)) as d3,
				sum(if(pendidikan='d3',1,0)) as d4,
				sum(if(pendidikan='s1',1,0)) as s1,
				sum(if(pendidikan='s2',1,0)) as s2,
				sum(if(pendidikan='s3',1,0)) as s3,
				-- jenis pekerjaan
				
				sum(if(jenis_pekerjaan='belum' && jenis_kelamin='l',1,0)) as l_belum,
				sum(if(jenis_pekerjaan='belum' && jenis_kelamin='p',1,0)) as p_belum,
				
				sum(if(jenis_pekerjaan='petani' && jenis_kelamin='l',1,0)) as l_petani,
				sum(if(jenis_pekerjaan='petani' && jenis_kelamin='p',1,0)) as p_petani,
				
				sum(if(jenis_pekerjaan='nelayan' && jenis_kelamin='l',1,0)) as l_nelayan,
				sum(if(jenis_pekerjaan='nelayan' && jenis_kelamin='p',1,0)) as p_nelayan,
				
				sum(if(jenis_pekerjaan='wiraswasta' && jenis_kelamin='l',1,0)) as l_wiraswasta,
				sum(if(jenis_pekerjaan='wiraswasta' && jenis_kelamin='p',1,0)) as p_wiraswasta,
				
				sum(if(jenis_pekerjaan='pns' && jenis_kelamin='l',1,0)) as l_pns,
				sum(if(jenis_pekerjaan='pns' && jenis_kelamin='p',1,0)) as p_pns,
				
				sum(if(jenis_pekerjaan='honorer' && jenis_kelamin='l',1,0)) as l_honorer,
				sum(if(jenis_pekerjaan='honorer' && jenis_kelamin='p',1,0)) as p_honorer,
				
				sum(if(jenis_pekerjaan='karyawan' && jenis_kelamin='l',1,0)) as l_karyawan,
				sum(if(jenis_pekerjaan='karyawan' && jenis_kelamin='p',1,0)) as p_karyawan,
				
				sum(if(jenis_pekerjaan='tni' && jenis_kelamin='l',1,0)) as l_tni,
				sum(if(jenis_pekerjaan='tni' && jenis_kelamin='p',1,0)) as p_tni,
				
				sum(if(jenis_pekerjaan='polisi' && jenis_kelamin='l',1,0)) as l_polisi,
				sum(if(jenis_pekerjaan='polisi' && jenis_kelamin='p',1,0)) as p_polisi,
				
				sum(if(jenis_pekerjaan='lainnya' && jenis_kelamin='l',1,0)) as l_pekerjaan_lainnya,
				sum(if(jenis_pekerjaan='lainnya' && jenis_kelamin='p',1,0)) as p_pekerjaan_lainnya
			from 
				master_kk_anggota
			left join master_dusun
				on master_dusun.id = master_kk_anggota.id_dusun
			where 
				master_dusun.id_desa	= ".$id_desa."
			group by master_dusun.nama
		";
		$execute				= $this->db->query($query);
		$response["status"]		= true;
		$response["message"]	= "";
		$response["data"]		= $execute->result();
		$this->json($response);
	}
	public function dasborDesa(){
		$jwt					= jwt::decode($this->input->get_request_header("Authorization"), $this->config->item("jwt_key", false));
		$id_desa				= $jwt->id_desa;
		$query					= "
			-- laporan penduduk

			select 

				-- penduduk
				sum(if(status='lahir',1,0)) as lahir,
				sum(if(status='mati',1,0)) as mati,
				sum(if(status='keluar',1,0)) as keluar,
				sum(if(status='datang',1,0)) as datang,
				sum(if(status_hubungan_dalam_keluarga='kepala keluarga',1,0)) as kk,
				sum(1) as penduduk,

				-- agama

				sum(if(agama='islam',1,0)) as islam,
				sum(if(agama='kristen',1,0)) as kristen,
				sum(if(agama='khatolik',1,0)) as khatolik,
				sum(if(agama='hindu',1,0)) as hindu,
				sum(if(agama='budha',1,0)) as budha,
				
				-- status perkawinan
				
				sum(if(status_perkawinan='belum',1,0)) as belum_kawin,
				sum(if(status_perkawinan='kawin tercatat',1,0)) as kawin_tercatat,
				sum(if(status_perkawinan='belum tercatat',1,0)) as kawin_belum_tercatat,
				sum(if(status_perkawinan='cerai mati',1,0)) as cerai_mati
				
			from 
				master_kk_anggota
			left join master_dusun
				on master_dusun.id = master_kk_anggota.id_dusun
			where 
				master_dusun.id_desa	= ".$id_desa."
		";
		$execute					= $this->db->query($query);
		$response["status"]			= true;
		$response["message"]		= "";
		$response["data"]			= $execute->last_row();
		$response["data"]->dusun	= $this->db->query("select count(id) as dusun from master_dusun where id_desa='".$id_desa."'")->last_row()->dusun;
		$response["data"]->desa		= $this->db->query("select nama from master_desa where id='".$id_desa."'")->last_row()->nama;
		$response["data"]->ganda	= $this->db->query("
			select 
				master_desa.nama as desa,
				master_kk_anggota.nama_lengkap,
				master_kk_anggota.nik,
				master_kk_anggota.status
			from master_kk_anggota
			left join master_dusun
				on master_dusun.id = master_kk_anggota.id_dusun
			left join master_desa
				on master_desa.id = master_dusun.id_desa
			where 
				(select count(id) from master_kk_anggota b where b.nik=master_kk_anggota.nik and master_kk_anggota.status='datang')>1
			and master_desa.id = ".$id_desa."
			
		")->result();
		$this->json($response);
	}
}
