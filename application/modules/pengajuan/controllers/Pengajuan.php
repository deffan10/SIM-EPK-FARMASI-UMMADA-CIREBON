<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengajuan extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Pengajuan_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Pengajuan';
    $data['page_header'] = 'Pengajuan Kaji Etik Protokol Penelitian';
    $data['breadcrumb'] = 'Pengajuan';
    $data['css_content'] = 'pengajuan_view_css';
    $data['main_content'] = 'pengajuan_view';
    $data['js_content'] = 'pengajuan_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Pengajuan';
    $data['page_header'] = 'Form Pengajuan Kaji Etik Protokol Penelitian';
    $data['breadcrumb'] = 'Form Pengajuan';
    $data['css_content'] = 'pengajuan_form_css';
    $data['main_content'] = 'pengajuan_form';
    $data['js_content'] = 'pengajuan_form_js';
    $data['kepk'] = $this->data_model->get_data_kepk();

    if ($id > 0)
    {
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('id_kepk', 'KEPK', 'trim|required');
    $this->form_validation->set_rules('jns_penelitian', 'Jenis Penelitian', 'trim|required');
    $this->form_validation->set_rules('asal_pengusul', 'Asal Pengusul', 'trim|required');
    $this->form_validation->set_rules('jns_lembaga', 'Jenis Lembaga Asal Pengusul', 'trim|required');
    $this->form_validation->set_rules('status_pengusul', 'Status Pengusul', 'trim|required');
    $this->form_validation->set_rules('strata_pend', 'Strata Pendidikan', 'trim|required');
    $this->form_validation->set_rules('judul', 'Judul Protokol', 'trim|required|max_length[500]|callback_check_judul_exist');
    $this->form_validation->set_rules('title', 'Title of Protokol', 'trim|required|max_length[500]');
    $this->form_validation->set_rules('nm_ketua', 'Ketua Pelaksana / Peneliti Utama', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('telp_peneliti', 'Nomor Telepon Peneliti', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('email_peneliti', 'Email Peneliti', 'trim|required|valid_email|max_length[100]');
    $this->form_validation->set_rules('nm_institusi', 'Nama Institusi', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('alm_inst', 'Alamat Institusi', 'trim|required');
    $this->form_validation->set_rules('telp_inst', 'Nomor Telepon Institusi / Fax', 'trim|required|max_length[20]');
    $this->form_validation->set_rules('email_inst', 'Email Institusi', 'trim|required|valid_email|max_length[100]');
    $this->form_validation->set_rules('sumber_dana', 'Sumber Dana', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('total_dana', 'Total Dana', 'trim|required');
    $this->form_validation->set_rules('penelitian', 'Penelitian', 'trim|required');
    $this->form_validation->set_rules('tempat_penelitian', 'Tempat Penelitian', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('waktu_mulai', 'Waktu Mulai Penelitian', 'trim|required|callback_check_valid_waktu_mulai');
    $this->form_validation->set_rules('waktu_selesai', 'Waktu Selesai Penelitian', 'trim|required|callback_check_valid_waktu_selesai');
    $this->form_validation->set_rules('tempat_multi_senter', 'Tempat Multi Senter', 'callback_check_tempat_multi_senter');
    $this->form_validation->set_rules('anggota_peneliti', 'Anggota Penelitian', 'callback_check_id_pengusul');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
    $this->form_validation->set_message('valid_email', '{field} tidak valid');
  }

  function check_judul_exist($judul)
  {
    $id_pengajuan = $this->input->post('id');
    $id_pengusul = $this->session->userdata('id_pengusul');
    $id_kepk = $this->input->post('id_kepk');
    $check = $this->data_model->check_data_judul($id_pengajuan, $id_pengusul, $id_kepk, $judul);

    if ($check === TRUE) return TRUE;
    else
    {
      $this->form_validation->set_message('check_judul_exist', $check);          
      return FALSE;
    } 
  }

  function check_tempat_multi_senter($tempat)
  {
    $is_multi_senter = $this->input->post('is_multi_senter');

    if ($is_multi_senter === 'true' && trim($tempat) == '') {
        $this->form_validation->set_message('check_tempat_multi_senter', 'Tempat Multi Senter belum diisi');
        return FALSE;
    }
    else return TRUE;
  }

  function check_valid_waktu_mulai($waktu_mulai)
  {
  	$inserted = $this->input->post('inserted');
  	$waktu_mulai = prepare_date($waktu_mulai);

  	if (strtotime($waktu_mulai) < strtotime($inserted)){
  		$this->form_validation->set_message('check_valid_waktu_mulai', 'Waktu Mulai Penelitian tidak boleh kurang dari waktu pengajuan.');
  		return FALSE;
  	}
  	else return TRUE;
  }

  function check_valid_waktu_selesai($waktu_selesai)
  {
  	$waktu_mulai = prepare_date($this->input->post('waktu_mulai'));
  	$waktu_selesai = prepare_date($waktu_selesai);

  	if (strtotime($waktu_selesai) < strtotime($waktu_mulai)){
  		$this->form_validation->set_message('check_valid_waktu_selesai', 'Waktu Selesai Penelitian tidak valid');
  		return FALSE;
  	}
  	else return TRUE;
  }

  function check_id_pengusul($nomor)
  {
    $nomor_null = array();
    $nomor_null_text = '';
    $nomor_failed = array();
    $nomor_failed_text = '';
    $anggota = $this->input->post('anggota_peneliti') ? json_decode($this->input->post('anggota_peneliti')) : '';
    for ($a=0; $a<count($anggota); $a++)
    {
      $nomor = isset($anggota[$a]->nomor) ? $anggota[$a]->nomor : 0;
      $nama = isset($anggota[$a]->nama) ? $anggota[$a]->nama : '';
      $id_pengusul = isset($anggota[$a]->nomor) ? $this->data_model->get_id_pengusul_by_nomor($anggota[$a]->nomor) : 0;

      if ($nama != '')
      {
        if ($nomor == '')
        {
          $nomor_null[] = $nama;
        }
        else 
        {
          if ($id_pengusul == 0)
          {
            $nomor_failed[] = $nomor;
          }
        }
      }
    }

    if (count($nomor_null) > 0)
    {
      for ($x=0; $x<count($nomor_null); $x++)
      {
        if ($x+1 < count($nomor_null) && $x != 0)
          $nomor_null_text .= ', ';
        else if ($x+1 == count($nomor_null) && $x != 0)
          $nomor_null_text .= ' dan ';

        $nomor_null_text .= $nomor_null[$x];
      }
      $this->form_validation->set_message('check_id_pengusul', 'Masukkan nomor anggota penelitian '.$nomor_null_text);
      return FALSE;          
    }
    else if (count($nomor_failed) > 0) {
      for ($y=0; $y<count($nomor_failed); $y++)
      {
        if ($y+1 < count($nomor_failed) && $y != 0)
          $nomor_failed_text .= ', ';
        else if ($y+1 == count($nomor_failed) && $y != 0)
          $nomor_failed_text .= ' dan ';
        
        $nomor_failed_text .= $nomor_failed[$y];
      }
      $this->form_validation->set_message('check_id_pengusul', 'Nomor anggota penelitian '.$nomor_failed_text.' tidak terdaftar');
      return FALSE;          
    }
    else
      return TRUE;

  }

  public function proses()
  {
    $oper = $this->input->post('oper');

    if ($oper == 'del')
      return $this->hapus();
    
    $response = (object)null;

    $this->load->library('form_validation');
    $this->validation_form();

    if ($this->form_validation->run() == TRUE)
    {
      $this->data_model->fill_data();
      $success = $this->data_model->save_data();
      if ($success)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data berhasil disimpan';
        $response->id = $this->data_model->id;
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data gagal disimpan';       
      }
    }
    else
    {
      $response->isSuccess = FALSE;
      $response->message = validation_errors();
    }

    echo json_encode($response);
  }

  public function get_daftar()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_jqgrid($param, TRUE);

    $response = (object) NULL;

    $page = $this->input->post('page');
    $limit = $this->input->post('rows');
    $total_pages = ceil($count/$limit);

    if ($page > $total_pages) $page = $total_pages;
    $start = $limit * $page - $limit;
    if($start < 0) $start = 0;
    $param['limit'] = array(
        'start' => $start,
        'end' => $limit
    );

    $result = $this->data_model->get_data_jqgrid($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    $response->rows = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[] = array(
          'id' => $result[$i]['id_pengajuan'],
          'no_protokol' => $result[$i]['no_protokol'],
          'no_gabungan' => $result[$i]['nomor'] . $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tanggal' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'kepk' => $result[$i]['nama_kepk'],
          'mulai' => date('d/m/Y', strtotime($result[$i]['waktu_mulai'])),
          'selesai' => date('d/m/Y', strtotime($result[$i]['waktu_selesai']))
        );
      }
    }
    
    echo json_encode($response);
  }

  function get_anggota_by_id($id)
  {
    $result = $this->data_model->get_data_anggota_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_ap'],
          'nama' => $result[$i]['nama'],
          'nomor' => $result[$i]['nomor'],
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_pa_by_id($id)
  {
    $result = $this->data_model->get_data_pa_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pa'],
          'nama' => $result[$i]['nama'],
          'institusi' => $result[$i]['institusi'],
          'tugas' => $result[$i]['tugas'],
          'telp' => $result[$i]['telp'],
        );
      }
    }
    
    echo json_encode($response->data);
  }

  function get_tarif_telaah_by_param($id_kepk=0, $jns_penelitian=0, $asal_pengusul=0, $jns_lembaga=0, $status_pengusul=0, $strata_pend=0)
  {
    $result = $this->data_model->get_data_tarif_telaah_by_param($id_kepk, $jns_penelitian, $asal_pengusul, $jns_lembaga, $status_pengusul, $strata_pend);

    $response = (object) NULL;
    if (isset($result['tarif_telaah']))
      $response->tarif_telaah = number_format($result['tarif_telaah'],2,",",".");
    else
      $response->tarif_telaah = '';

    echo json_encode($response);
  }

  public function do_upload($file)
  {
    $response = (object)null;

    $dir = './uploads/';
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);         
      chmod($dir, 0777);
    }

    $config['upload_path'] = $dir;
    $config['allowed_types'] = 'pdf|png|jpg|jpeg';
    $config['max_size'] = 100000;
    $config['encrypt_name'] = TRUE;

    $this->load->library('upload', $config);

    if ( ! $this->upload->do_upload($file))
    {
      $response->isSuccess = FALSE;
      $response->message = $this->upload->display_errors();
    }
    else
    {
      $response->isSuccess = TRUE;
      $response->message = 'Data berhasil diunggah';
      $response->data_fileupload = $this->upload->data();
      $response->file = $file;
    }

    echo json_encode($response);
  }

/*  public function kirim_email()
  {
    $htmlContent = '<h1>Mengirim email HTML dengan Codeigniter</h1>';
    $htmlContent .= '<div>Contoh pengiriman email yang memiliki tag HTML dengan menggunakan Codeigniter</div>';
        
    $config['mailtype'] = 'html';
    $this->email->initialize($config);
    $this->email->to('trisugi@yahoo.co.id');
    $this->email->from('admin@jurnalweb.com','JurnalWeb');
    $this->email->subject('Test Email (HTML)');
    $this->email->message($htmlContent);
    $this->email->send();
    echo 'ok';
  }
*/

  function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');

    $check = $this->data_model->check_exist_data($id);

    if ($check)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data dipakai di tabel lain. Lihat di daftar protokol.';
    }
    else
    {
      $result = $this->data_model->delete_data($id);

      if ($result)
      {
        $response->isSuccess = TRUE;
        $response->message = 'Data berhasil dihapus';
      }
      else
      {
        $response->isSuccess = FALSE;
        $response->message = 'Data gagal dihapus';
      }     
    }
    
    echo json_encode($response);
  }
}
?>