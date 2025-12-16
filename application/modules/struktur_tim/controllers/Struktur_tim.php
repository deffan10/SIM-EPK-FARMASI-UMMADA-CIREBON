<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_tim extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Struktur_tim_model', 'data_model');
  }
  
  public function index()
  {
    $data['title'] = APPNAME.' - Struktur Tim KEPK';
    $data['page_header'] = 'Struktur Tim KEPK';
    $data['breadcrumb'] = 'Struktur Tim KEPK';
    $data['css_content'] = 'struktur_tim_view_css';
    $data['main_content'] = 'struktur_tim_view';
    $data['js_content'] = 'struktur_tim_view_js';
 
    $this->load->view('layout/template', $data);
  }

  public function form($id=0)
  {
    $data['title'] = APPNAME.' - Struktur Tim KEPK';
    $data['page_header'] = 'Form Struktur Tim KEPK';
    $data['breadcrumb'] = 'Struktur Tim KEPK';
    $data['css_content'] = 'struktur_tim_form_css';
    $data['main_content'] = 'struktur_tim_form';
    $data['js_content'] = 'struktur_tim_form_js';
    $data['opt_anggota'] = $this->data_model->get_data_opt_anggota_tim_kepk();

    if ($id > 0)
      $data['data'] = $this->data_model->get_data_by_id($id);

    $this->load->view('layout/template', $data);
    
  }

  public function validation_form()
  {
    $this->form_validation->set_rules('periode_awal', 'Periode Awal', 'trim|required');
    $this->form_validation->set_rules('periode_akhir', 'Periode Akhir', 'trim|required');
    $this->form_validation->set_rules('ketua', 'Ketua', 'trim|required');

    $this->form_validation->set_message('required', '{field} tidak boleh kosong');
  }

  public function proses()
  {
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
          'id' => $result[$i]['id_tim_kepk'],
          'periode' => date('d/m/Y', strtotime($result[$i]['periode_awal'])).' s/d '.date('d/m/Y', strtotime($result[$i]['periode_akhir'])),
          'ketua' => $result[$i]['ketua'],
          'aktif_tim_kepk' => $result[$i]['aktif_tim_kepk']
        );
      }
    }
    
    echo json_encode($response);
  }

  public function get_struktur_by_id($id)
  {
    $result = $this->data_model->get_data_struktur_tim_kepk_by_id($id);

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        switch ($result[$i]['jabatan']) {
          case 1: $nama_jabatan = 'Ketua'; break;
          case 2: $nama_jabatan = 'Wakil Ketua'; break;
          case 3: $nama_jabatan = 'Sekretaris'; break;
          case 4: $nama_jabatan = 'Kesekretariatan'; break;
          case 5: $nama_jabatan = 'Penelaah'; break;
          case 6: $nama_jabatan = 'Lay Person'; break;
          case 7: $nama_jabatan = 'Konsultan Independen'; break;
          default: $nama_jabatan = ''; break;
        }

        $response->data[] = array(
          'no' => $i+1,
          'id_atk' => $result[$i]['id_atk'],
          'nomor' => $result[$i]['nomor'],
          'nama' => $result[$i]['nama'],
          'jabatan' => $result[$i]['jabatan'],
          'nama_jabatan' => $nama_jabatan
        );
      }
    }

    echo json_encode($response->data);
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
