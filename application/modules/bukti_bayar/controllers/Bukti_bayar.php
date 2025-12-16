<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukti_bayar extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Bukti_bayar_model', 'data_model');
  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Bukti Bayar';
    $data['page_header'] = 'Bukti Bayar';
    $data['breadcrumb'] = 'Bukti Bayar';
    $data['css_content'] = 'bukti_bayar_view_css';
    $data['main_content'] = 'bukti_bayar_view';
    $data['js_content'] = 'bukti_bayar_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Bukti Bayar';
    $data['page_header'] = 'Form Bukti Bayar';
    $data['breadcrumb'] = 'Form Bukti Bayar';
    $data['css_content'] = 'bukti_bayar_form_css';
    $data['main_content'] = 'bukti_bayar_form';
    $data['js_content'] = 'bukti_bayar_form_js';
    $data['opt_pengajuan'] = $this->data_model->get_data_opt_pengajuan();

    if ($id > 0)
    {
      $data['data'] = $this->security->xss_clean($this->data_model->get_data_by_id($id));
    }

    $this->load->view('layout/template', $data);
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('id_pengajuan', 'Nomor Protokol', 'trim|required|is_natural_no_zero');
    $this->form_validation->set_rules('nomor', 'Nomor', 'trim|required|max_length[100]');
    $this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
    $this->form_validation->set_rules('link_gdrive', 'Link Google Drive', 'trim|required|max_length[500]|valid_url');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
    $this->form_validation->set_message('max_length', '{field} tidak boleh melebihi {param} karakter');
    $this->form_validation->set_message('valid_url', '{field} tidak valid');
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
          'id' => $result[$i]['id_bb'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'nomor' => $result[$i]['nomor'],
          'tanggal' => date('d/m/Y', strtotime($result[$i]['tanggal'])),
        );
      }
    }
    
    echo json_encode($response);
  }

  function cek_file_exist($file_name)
  {
    $response = (object)null;

    if (file_exists('./uploads/'.$file_name))
      $response->isSuccess = TRUE;
    else
      $response->isSuccess = FALSE;

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

  function hapus()
  {
    $response = (object)null;

    $id = $this->input->post('id');

    $check = $this->data_model->check_exist_data($id);

    if ($check)
    {
      $response->isSuccess = FALSE;
      $response->message = 'Data dipakai di tabel lain.';
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