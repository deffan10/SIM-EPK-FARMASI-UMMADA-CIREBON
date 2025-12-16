<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_tim extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Anggota_tim_model', 'data_model');
  }
  
  public function index()
  {
    $data['title'] = APPNAME.' - Anggota Tim KEPK';
    $data['page_header'] = 'Anggota Tim KEPK';
    $data['breadcrumb'] = 'Anggota Tim KEPK';
    $data['css_content'] = 'anggota_tim_view_css';
    $data['main_content'] = 'anggota_tim_view';
    $data['js_content'] = 'anggota_tim_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Anggota Tim KEPK';
    $data['page_header'] = 'Form Anggota Tim KEPK';
    $data['breadcrumb'] = 'Form Anggota Tim KEPK';
    $data['css_content'] = 'anggota_tim_form_css';
    $data['main_content'] = 'anggota_tim_form';
    $data['js_content'] = 'anggota_tim_form_js';
 
    if ($id > 0)
    {
      $data['data'] = $this->data_model->get_data_by_id($id);
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('nama', 'Nama', 'trim|required|max_length[200]');
    $this->form_validation->set_rules('nik', 'NIK', 'trim|required|max_length[100]|callback_check_nik_exist');
    $this->form_validation->set_rules('no_sertifikat', 'Nomor Sertifikat ED/EDL', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|valid_email|callback_check_email_exist');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
    $this->form_validation->set_message('valid_email', '{field} tidak valid');
  }

  function check_nik_exist($nik)
  {
    $id_atk = $this->input->post('id');
    $exist = $this->data_model->check_data_nik_exist($id_atk, $nik);

    if (trim($nik) !== "" && $exist) {
      $this->form_validation->set_message('check_nik_exist', 'NIK sudah ada');          
      return FALSE;
    } 
    else return TRUE;
  }

  function check_email_exist($email)
  {
    $id_atk = $this->input->post('id');
    $exist = $this->data_model->check_data_email_exist($id_atk, $email);

    if (trim($email) !== "" && $exist) {
      $this->form_validation->set_message('check_email_exist', 'Email sudah ada');          
      return FALSE;
    } 
    else return TRUE;

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
        $response->nomor = $this->data_model->nomor;
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

    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[$i] = array(
          'id' => $result[$i]['id_atk'],
          'nomor' => $result[$i]['nomor'],
          'nama' => $result[$i]['nama'],
          'nik' => $result[$i]['nik'],
          'email' => $result[$i]['email'],
          'no_telp' => $result[$i]['no_telepon'],
          'no_hp' => $result[$i]['no_hp'],
          'no_sertifikat' => $result[$i]['no_sertifikat_ed_edl']
        );
      }
    }

    echo json_encode($response);
  }

  public function download($file_name, $client_name)
  {
    $this->load->helper('download');

    $pathfile = './uploads/'.$file_name;
    $data = file_get_contents($pathfile);

    $client_name = urldecode(rawurldecode($client_name));
    
    force_download($client_name, $data);
  }

  public function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');

    $check = $this->data_model->check_exist_data($id);

    if ($check)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data dipakai di tabel lain';
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
