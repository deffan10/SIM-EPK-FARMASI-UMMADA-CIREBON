<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukti_bayar_model extends Core_Model {

  var $fieldmap_filter;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'no_protokol' => 'p.no_protokol',
      'judul' => 'p.judul',
      'nomor' => 'bb.nomor',
      'tanggal' => 'bb.tanggal',
    );
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_pengajuan = $this->input->post('id_pengajuan') ? $this->input->post('id_pengajuan') : 0;
	  $nomor = $this->input->post('nomor') ? $this->input->post('nomor') : '';
	  $tanggal = $this->input->post('tanggal') ? prepare_date($this->input->post('tanggal')) : '';
	  $link_gdrive = $this->input->post('link_gdrive') ? $this->input->post('link_gdrive') : '';

    $this->data = array(
    		'id_bb' => $id,
	  		'id_pengajuan' => $id_pengajuan,
				'nomor' => $nomor,
	 			'tanggal' => $tanggal,
        'link_gdrive' => $link_gdrive
    );
	}

	public function save_detail()
	{
		$this->insert_bb();
	}

	function insert_bb()
	{
		if (isset($this->data['id_bb']) && $this->data['id_bb'] > 0)
		{
			$this->db->where('id_bb', $this->data['id_bb']);
			$this->db->update('tb_bukti_bayar', $this->data);
			$this->check_trans_status('update tb_bukti_bayar failed');
		}
		else
		{
			unset($this->data['id_bb']);
			$this->db->insert('tb_bukti_bayar', $this->data);
			$this->check_trans_status('insert tb_bukti_bayar failed');
		}		
	}

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('bb.id_bb, bb.id_pengajuan, bb.nomor, bb.tanggal, p.no_protokol, p.judul');
    $this->db->from('tb_bukti_bayar as bb');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = bb.id_pengajuan');
    $this->db->join('tb_pengusul as pn', 'pn.id_pengusul = p.id_pengusul');
    $this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      switch($fld){
        case 'tanggal': $str = prepare_date($param['search_str']); break;
        case 'mulai': $str = prepare_date($param['search_str']); break;
        case 'selesai': $str = prepare_date($param['search_str']); break;
        default : $str = $param['search_str']; break;
      }
      $op = $param['search_op'];

      if (strlen($str) > 0)
      {
        switch ($op) {
          case 'eq': $this->db->where($this->fieldmap_filter[$fld] . " = '" .$str . "'"); break;
          case 'ne': $this->db->where($this->fieldmap_filter[$fld] . " <> '" . $str . "'"); break;
          case 'bw': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '%" . $str . "'"); break;
          case 'bn': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "'"); break;
          case 'ew': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '" . $str . "%'"); break;
          case 'en': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '" . $str . "%'"); break;
          case 'cn': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '%" . $str . "%'"); break;
          case 'nc': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '%" . $str . "%'"); break;
          case 'nu': $this->db->where($this->fieldmap_filter[$fld] . " IS NULL"); break;
          case 'nn': $this->db->where($this->fieldmap_filter[$fld] . " IS NOT NULL"); break;
          case 'in': $this->db->where($this->fieldmap_filter[$fld] . " LIKE '" . $str . "'"); break;
          case 'ni': $this->db->where($this->fieldmap_filter[$fld] . " NOT LIKE '" . $str . "'"); break;
        }
      }
    }

    if (isset($param['sort_by']) && $param['sort_by'] != null && !$isCount && $ob = get_order_by_str($param['sort_by'], $this->fieldmap_filter))
    {
      $this->db->order_by($ob, $param['sort_direction']);
    }

    isset($param['limit']) && $param['limit'] ? $this->db->limit($param['limit']['end'], $param['limit']['start']) : '';

    if ($isCount) {
      $result = $this->db->count_all_results();
      return $result;
    }
    else
    {
      if ($CompileOnly)
      {
        return $this->db->get_compiled_select();
      }
      else
      {
        return $this->db->get()->result_array();
      }
    }
    
    return $result;
  }

	function get_data_by_id($id)
	{
		$this->db->select('bb.id_bb, bb.id_pengajuan, bb.nomor, bb.tanggal, bb.file_name, bb.client_name, bb.link_gdrive, p.no_protokol, p.judul');
		$this->db->from('tb_bukti_bayar as bb');
    $this->db->join('tb_pengajuan as p', 'p.id_pengajuan = bb.id_pengajuan');
		$this->db->where('bb.id_bb', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	function get_data_opt_pengajuan()
	{
		$this->db->select('p.id_pengajuan, p.no_protokol, p.judul, p.tempat_penelitian, p.is_multi_senter, p.is_setuju_senter');
		$this->db->from('tb_pengajuan as p');
    $this->db->join('tb_bukti_bayar as bb', 'bb.id_pengajuan = p.id_pengajuan', 'left');
		$this->db->where('p.id_pengusul', $this->session->userdata('id_pengusul'));
		$this->db->where('bb.id_bb is null');
		$result = $this->db->get()->result_array();

		return $result;
	}

  function check_exist_data($id)
	{
		return FALSE;
	}

	function delete_detail($id)
	{
		$this->delete_bb($id);
	}

	function delete_bb($id)
	{
		$this->db->where('id_bb', $id);
		$this->db->delete('tb_bukti_bayar');
	}

}
