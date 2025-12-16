<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends Userpage_Controller {

  public function __construct()
  {
    parent::__construct();

    $this->load->model('Dashboard_model', 'data_model');

  }
 
  public function index()
  {
    $data['title'] = APPNAME.' - Dashboard';
    $data['page_header'] = 'Dashboard';
    $data['breadcrumb'] = 'Dashboard';

    $id_group = $this->session->userdata('id_group_'.APPAUTH);
    switch ($id_group) {
      case 1: 
        $data['main_content'] = 'dashboard_admin_view';
        break;
      
      case 2: 
        $data['main_content'] = 'dashboard_kepk_view';
        break;

      case 3: 
        $data['css_content'] = 'dashboard_pengusul_view_css';
        $data['main_content'] = 'dashboard_pengusul_view';
        $data['js_content'] = 'dashboard_pengusul_view_js';
        break;

      case 4: 
        $data['css_content'] = 'dashboard_sekretaris_view_css';
        $data['main_content'] = 'dashboard_sekretaris_view';
        $data['js_content'] = 'dashboard_sekretaris_view_js';
        break;

      case 5: 
        $data['css_content'] = 'dashboard_sekretariat_view_css';
        $data['main_content'] = 'dashboard_sekretariat_view';
        $data['js_content'] = 'dashboard_sekretariat_view_js';
        break;

      case 6: 
        $data['css_content'] = 'dashboard_penelaah_view_css';
        $data['main_content'] = 'dashboard_penelaah_view';
        $data['js_content'] = 'dashboard_penelaah_view_js';
        break;

      case 7: 
        $data['css_content'] = 'dashboard_ketua_view_css';
        $data['main_content'] = 'dashboard_ketua_view';
        $data['js_content'] = 'dashboard_ketua_view_js';
        break;

      case 8: 
        $data['css_content'] = 'dashboard_waketua_view_css';
        $data['main_content'] = 'dashboard_waketua_view';
        $data['js_content'] = 'dashboard_waketua_view_js';
        break;
    }
 
    $this->load->view('layout/template', $data);
  }

  function get_pembebasan_etik()
  {
    $result = $this->data_model->get_data_pembebasan_etik();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_persetujuan_etik()
  {
    $result = $this->data_model->get_data_persetujuan_etik();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_perbaikan_etik()
  {
    $result = $this->data_model->get_data_perbaikan_etik();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_telaah_pelapor()
  {
    $result = $this->data_model->get_data_telaah_pelapor();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $tim_penelaah = $this->data_model->get_data_tim_penelaah_by_id_pengajuan($result[$i]['id_pengajuan']);
        $anggota = '';
        for ($a=0; $a<count($tim_penelaah); $a++)
        {
          $anggota .= $tim_penelaah[$a]['nama'];

          if ($a < count($tim_penelaah) - 1)
          {
            if ($a == count($tim_penelaah) - 2)
              $anggota .= ' dan ';
            else
              $anggota .= ', ';
          }
        }

        $klasifikasi = $result[$i]['klasifikasi'] == 2 ? 'Expedited' : 'Full Board';
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'klasifikasi' => $klasifikasi,
          'anggota' => $anggota
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_putusan_fullboard()
  {
    $result = $this->data_model->get_data_putusan_fullboard();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_pep'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_pemberitahuan_fullboard()
  {
    $result = $this->data_model->get_data_pemberitahuan_fullboard();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->data[] = array(
          'id' => $result[$i]['id_bfbd'],
          'no' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tgl_fb' => date('d/m/Y', strtotime($result[$i]['tgl_fullboard'])),
          'jam_fb' => date('H:i', strtotime($result[$i]['jam_fullboard'])),
          'tempat_fb' => $result[$i]['tempat_fullboard'],
          'waktu' => date('d/m/Y H:i:s', strtotime($result[$i]['inserted'])),
          'hari_ke' => get_working_days(date('Y-m-d', strtotime($result[$i]['inserted'])), date('Y-m-d'))
        );
      }
    }

    echo json_encode($response->data);
  }

  function get_protokol_belum_kirim()
  {
    $result = $this->data_model->get_data_protokol_belum_kirim();

    $response = (object) NULL;
    $response->data = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        if ($this->session->userdata('id_group_'.APPAUTH) == 3)
        {
          $response->data[] = array(
            'id_pengajuan' => $result[$i]['id_pengajuan'],
            'id_pep' => $result[$i]['id_pep'],
            'no' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'revisi' => $result[$i]['revisi_ke'],
            'klasifikasi' => $result[$i]['klasifikasi']
          );
        }
        else if ($this->session->userdata('id_group_'.APPAUTH) == 6)
        {
          $response->data[] = array(
            'id_pengajuan' => $result[$i]['id_pengajuan'],
            'id_pep' => $result[$i]['id_pep'],
            'no' => $result[$i]['no_protokol'],
            'judul' => $result[$i]['judul'],
            'revisi' => $result[$i]['revisi_ke'],
            'klasifikasi' => $result[$i]['klasifikasi'],
            'keputusan' => $result[$i]['keputusan']
          );
        }
      }
    }

    echo json_encode($response->data);
  }

  public function get_daftar_pengajuan_ditolak()
  {
    $param = array(
      "_search" => $this->input->post('_search'),
      "search_fld" => $this->input->post('searchField'),
      "search_op" => $this->input->post('searchOper'),
      "search_str" => $this->input->post('searchString'),
      "sort_by" => $this->input->post('sidx'),
      "sort_direction" => $this->input->post('sord')
    );

    $count = $this->data_model->get_data_protokol_jqgrid($param, TRUE);

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

    $result = $this->data_model->get_data_protokol_jqgrid($param);
    $response->page = $page;
    $response->total = $total_pages;
    $response->records = $count;

    $response->rows = array();
    if ($result){
      for($i=0; $i<count($result); $i++){
        $response->rows[] = array(
          'id' => $result[$i]['id_pengajuan'],
          'no_protokol' => $result[$i]['no_protokol'],
          'judul' => $result[$i]['judul'],
          'tanggal' => date('d/m/Y', strtotime($result[$i]['tanggal_pengajuan'])),
          'kepk' => $result[$i]['nama_kepk'],
          'alasan_ditolak' => $result[$i]['alasan_ditolak']
        );
      }
    }
    
    echo json_encode($response);
  }

  function download_excel_list_protokol()
  {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $style_head = [
      'font' => [
        'bold' => true,
        'size' => 16
      ],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
      ]
    ];

    $style_col = [
      'font' => ['bold' => true],
      'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
      ]
    ];
    
    $style_row = [
      'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
      ],
      'borders' => [
        'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
        'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
      ]
    ];

    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
    $drawing->setPath('assets/images/logo-keppkn.png');
    $drawing->setCoordinates('A1');
    $drawing->setOffsetX(110);
    $drawing->setOffsetY(10);
    $drawing->getShadow()->setVisible(true);
    $drawing->getShadow()->setDirection(45);
    $drawing->setWorksheet($sheet);

    $sheet->mergeCells('A1:B1');
    $sheet->getStyle('A1:B1')->applyFromArray($style_head);
    $sheet->setCellValue('C1', "KOMITE ETIK PENELITIAN DAN PENGEMBANGAN KESEHATAN NASIONAL (KEPPKN)\n\nLIST PROTOKOL");
    $sheet->mergeCells('C1:R1');
    $sheet->getStyle('C1:R1')->applyFromArray($style_head);
    $sheet->mergeCells('S1:U1');
    $sheet->setCellValue('S1', "Borang\nNo. B01-04/V1\nVersi 1.0");
    $sheet->getStyle('S1:U1')->applyFromArray($style_head);
    $sheet->getRowDimension('1')->setRowHeight(120);

    $sheet->setCellValue('A3', "No");
    $sheet->mergeCells('A3:A5');
    $sheet->setCellValue('B3', "No Protokol");
    $sheet->mergeCells('B3:B5');
    $sheet->setCellValue('C3', "Judul");
    $sheet->mergeCells('C3:C5');
    $sheet->setCellValue('D3', "Peneliti");
    $sheet->mergeCells('D3:D5');
    $sheet->setCellValue('E3', "Jenis Penelitian");
    $sheet->mergeCells('E3:H3');
    $sheet->setCellValue('I3', "Institusi");
    $sheet->mergeCells('I3:I5');
    $sheet->setCellValue('J3', "Sponsor/Non");
    $sheet->mergeCells('J3:J5');
    $sheet->setCellValue('K3', "Jalur Telaah Awal");
    $sheet->mergeCells('K3:M3');
    $sheet->setCellValue('N3', "Reviewer");
    $sheet->mergeCells('N3:N5');
    $sheet->setCellValue('O3', "Status Persetujuan Etik");
    $sheet->mergeCells('O3:P3');
    $sheet->setCellValue('Q3', "Telaah Lanjutan (Beri tanda V/tanggal jika ada)");
    $sheet->mergeCells('Q3:U3');
    $sheet->setCellValue('E4', "Manusia sebagai");
    $sheet->mergeCells('E4:F4');
    $sheet->setCellValue('G4', "Hewan sebagai subyek");
    $sheet->mergeCells('G4:G5');
    $sheet->setCellValue('H4', "Tidak melibatkan hewan sebagai subyek");
    $sheet->mergeCells('H4:H5');
    $sheet->setCellValue('K4', "Dibebaskan");
    $sheet->mergeCells('K4:K5');
    $sheet->setCellValue('L4', "Dipercepat");
    $sheet->mergeCells('L4:L5');
    $sheet->setCellValue('M4', "Fullboard");
    $sheet->mergeCells('M4:M5');
    $sheet->setCellValue('O4', "Tanggal penerimaan berkas");
    $sheet->mergeCells('O4:O5');
    $sheet->setCellValue('P4', "Tanggal persetujuan etik dikeluarkan");
    $sheet->mergeCells('P4:P5');
    $sheet->setCellValue('Q4', "Amandemen");
    $sheet->mergeCells('Q4:Q5');
    $sheet->setCellValue('R4', "Protokol deviasi/violation");
    $sheet->mergeCells('R4:R5');
    $sheet->setCellValue('S4', "Progress report");
    $sheet->mergeCells('S4:S5');
    $sheet->setCellValue('T4', "SAE");
    $sheet->mergeCells('T4:T5');
    $sheet->setCellValue('U4', "Final Report");
    $sheet->mergeCells('U4:U5');
    $sheet->setCellValue('E5', "Uji Klinik");
    $sheet->setCellValue('F5', "Non\nUji Klinik");

    $sheet->getStyle('E5:F5')->getAlignment()->setWrapText(true);
    $sheet->getStyle('G4:H4')->getAlignment()->setWrapText(true);
    $sheet->getStyle('O4:U4')->getAlignment()->setWrapText(true);
    
    $sheet->getStyle('A3:A5')->applyFromArray($style_col);
    $sheet->getStyle('B3:B5')->applyFromArray($style_col);
    $sheet->getStyle('C3:C5')->applyFromArray($style_col);
    $sheet->getStyle('D3:D5')->applyFromArray($style_col);
    $sheet->getStyle('E3:H3')->applyFromArray($style_col);
    $sheet->getStyle('E4:F4')->applyFromArray($style_col);
    $sheet->getStyle('E5')->applyFromArray($style_col);
    $sheet->getStyle('F5')->applyFromArray($style_col);
    $sheet->getStyle('G4')->applyFromArray($style_col);
    $sheet->getStyle('H4')->applyFromArray($style_col);
    $sheet->getStyle('I3:I5')->applyFromArray($style_col);
    $sheet->getStyle('J3:J5')->applyFromArray($style_col);
    $sheet->getStyle('K3:M3')->applyFromArray($style_col);
    $sheet->getStyle('K4:K5')->applyFromArray($style_col);
    $sheet->getStyle('L4:L5')->applyFromArray($style_col);
    $sheet->getStyle('M4:M5')->applyFromArray($style_col);
    $sheet->getStyle('N3:N5')->applyFromArray($style_col);
    $sheet->getStyle('O3:P3')->applyFromArray($style_col);
    $sheet->getStyle('O4:O5')->applyFromArray($style_col);
    $sheet->getStyle('P4:P5')->applyFromArray($style_col);
    $sheet->getStyle('Q3:U3')->applyFromArray($style_col);
    $sheet->getStyle('Q4:Q5')->applyFromArray($style_col);
    $sheet->getStyle('R4:R5')->applyFromArray($style_col);
    $sheet->getStyle('S4:S5')->applyFromArray($style_col);
    $sheet->getStyle('T4:T5')->applyFromArray($style_col);
    $sheet->getStyle('U4:U5')->applyFromArray($style_col);

    $sheet->getColumnDimension('A')->setAutoSize(TRUE);
    $sheet->getColumnDimension('B')->setAutoSize(TRUE);
    $sheet->getColumnDimension('C')->setAutoSize(TRUE);
    $sheet->getColumnDimension('D')->setAutoSize(TRUE);
    $sheet->getColumnDimension('E')->setWidth(15);
    $sheet->getColumnDimension('F')->setWidth(15);
    $sheet->getColumnDimension('G')->setWidth(15);
    $sheet->getColumnDimension('H')->setWidth(15);
    $sheet->getColumnDimension('I')->setAutoSize(TRUE);
    $sheet->getColumnDimension('J')->setAutoSize(TRUE);
    $sheet->getColumnDimension('K')->setWidth(15);
    $sheet->getColumnDimension('L')->setWidth(15);
    $sheet->getColumnDimension('M')->setWidth(15);
    $sheet->getColumnDimension('N')->setWidth(30);
    $sheet->getColumnDimension('O')->setWidth(15);
    $sheet->getColumnDimension('P')->setWidth(15);
    $sheet->getColumnDimension('Q')->setWidth(15);
    $sheet->getColumnDimension('R')->setWidth(15);
    $sheet->getColumnDimension('S')->setWidth(15);
    $sheet->getColumnDimension('T')->setWidth(15);
    $sheet->getColumnDimension('U')->setWidth(15);
    $sheet->getRowDimension('5')->setRowHeight(50);

    $data = $this->data_model->get_data_list_protokol();

    if (!empty($data))
    {
      $no = 1;
      $numrow = 6;
      for ($i=0; $i<count($data); $i++)
      {
        $id_pengajuan = $data[$i]['id_pengajuan'];
        $tim_penelaah = $this->data_model->get_data_tim_penelaah_by_id_pengajuan($id_pengajuan);
        $reviewer = '';
        if (!empty($tim_penelaah))
        {
          for ($a=0; $a<count($tim_penelaah); $a++)
          {
            $reviewer .= $tim_penelaah[$a]['nama'];

            if ($a < count($tim_penelaah) - 1)
            {
              if ($a == count($tim_penelaah) - 2)
                $reviewer .= ' dan ';
              else
                $reviewer .= ', ';
            }
          }
        }

        $sheet->setCellValue('A'.$numrow, $no);
        $sheet->setCellValue('B'.$numrow, $data[$i]['no_protokol']);
        $sheet->setCellValue('C'.$numrow, $data[$i]['judul']);
        $sheet->setCellValue('D'.$numrow, $data[$i]['nama_ketua']);
        $sheet->setCellValue('E'.$numrow, $data[$i]['jenis_penelitian'] == 3 ? 'V' : '');
        $sheet->setCellValue('F'.$numrow, $data[$i]['jenis_penelitian'] != 3 ? 'V' : '');
        $sheet->setCellValue('G'.$numrow, '');
        $sheet->setCellValue('H'.$numrow, '');
        $sheet->setCellValue('I'.$numrow, $data[$i]['nama_institusi']);
        $sheet->setCellValue('J'.$numrow, $data[$i]['sumber_dana']);
        $sheet->setCellValue('K'.$numrow, $data[$i]['klasifikasi'] == 1 ? 'V' : '');
        $sheet->setCellValue('L'.$numrow, $data[$i]['klasifikasi'] == 2 ? 'V' : '');
        $sheet->setCellValue('M'.$numrow, $data[$i]['klasifikasi'] == 3 ? 'V' : '');
        $sheet->setCellValue('N'.$numrow, $reviewer);
        $sheet->setCellValue('O'.$numrow, date('d-m-Y', strtotime($data[$i]['tgl_terima_berkas'])));
        $sheet->setCellValue('P'.$numrow, date('d-m-Y', strtotime($data[$i]['tgl_persetujuan_dikeluarkan'])));
        $sheet->setCellValue('Q'.$numrow, '');
        $sheet->setCellValue('R'.$numrow, '');
        $sheet->setCellValue('S'.$numrow, '');
        $sheet->setCellValue('T'.$numrow, '');
        $sheet->setCellValue('U'.$numrow, '');

        $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('O'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('P'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('Q'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('R'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('S'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('T'.$numrow)->applyFromArray($style_row);
        $sheet->getStyle('U'.$numrow)->applyFromArray($style_row);

        $sheet->getStyle('C'.$numrow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('N'.$numrow)->getAlignment()->setWrapText(true);

        $no++;
        $numrow++;
      }
    }
        
    $sheet->getDefaultRowDimension()->setRowHeight(-1);
    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    $sheet->setTitle("List Protokol");

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="List Protokol.xlsx"');
    header('Cache-Control: max-age=0');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
  }

}
