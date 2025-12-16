<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Anggota_tim_model extends Core_Model {

  var $nomor;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'id' => 'a.id_atk',
      'nomor' => 'a.nomor',
      'nama' => 'a.nama', 
      'nik' =>  'a.nik',
      'email' => 'a.email',
      'no_telp' => 'a.no_telepon',
      'no_hp' => 'a.no_hp',
      'no_sertifikat' => 'a.no_sertifikat_ed_edl'
    );
	}

	public function fill_data()
	{
		$id = $this->input->post('id') ? $this->input->post('id') : 0;
		$id_kepk = $this->session->userdata('id_kepk');
	  $nomor = $id == 0 ? $this->get_nomor_anggota($id_kepk) : $this->input->post('nomor');
  	$nama = $this->input->post('nama') ? $this->input->post('nama') : '';
	  $nik = $this->input->post('nik') ? $this->input->post('nik') : '';
  	$email = $this->input->post('email') ? $this->input->post('email') : '';
	  $no_telepon = $this->input->post('no_telp') ? $this->input->post('no_telp') : '';
  	$no_hp = $this->input->post('no_hp') ? $this->input->post('no_hp') : '';
    $no_sertifikat_ed_edl  = $this->input->post('no_sertifikat') ? $this->input->post('no_sertifikat') : '';
    $link_gdrive_sertifikat  = $this->input->post('link_gdrive') ? $this->input->post('link_gdrive') : '';

	  $this->data = array(
	  		'id_atk' => $id,
		  	'id_kepk' => $id_kepk,
	  		'nomor' => $nomor,
				'nama' => $nama,
				'nik' => $nik,
				'email' => $email,
				'no_telepon' => $no_telepon,
				'no_hp' => $no_hp,
        'no_sertifikat_ed_edl' => $no_sertifikat_ed_edl,
				'link_gdrive_sertifikat' => $link_gdrive_sertifikat
		);

    $this->nomor = $nomor;
	}

  function save_detail()
  {
    $this->insert_anggota_tim_kepk();
  }

  function insert_anggota_tim_kepk()
  {
		if (isset($this->data['id_atk']) && $this->data['id_atk'] > 0)
		{
			unset($this->data['nomor']);
			$this->db->where('id_atk', $this->data['id_atk']);
			$this->db->update('tb_anggota_tim_kepk', $this->data);
			$this->check_trans_status('update tb_anggota_tim_kepk failed');
			$this->id = $this->data['id_atk'];
		}
		else
		{
			unset($this->data['id_atk']);
			$this->db->insert('tb_anggota_tim_kepk', $this->data);
			$this->check_trans_status('insert tb_anggota_tim_kepk failed');
			$this->id = $this->db->insert_id();
		}
  }

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select('a.id_atk, a.nomor, a.nama, a.nik, a.no_sertifikat_ed_edl, a.email, a.no_telepon, a.no_hp');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk'));

    // proses parameter pencarian, jika ada
    if (isset($param['_search']) && $param['_search'] == 'true' )
    {
      $fld = $param['search_fld'];
      $str = $param['search_str'];
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
    $this->db->select('atk.id_atk, atk.nomor, atk.nama, atk.nik, atk.email, atk.no_telepon, atk.no_hp, atk.no_sertifikat_ed_edl, atk.client_name_sertifikat, atk.file_name_sertifikat, atk.link_gdrive_sertifikat');
    $this->db->from('tb_anggota_tim_kepk as atk');
    $this->db->where('atk.id_atk', $id);
		$result = $this->db->get()->row_array();

		return $result;
  }

	function get_nomor_anggota($id_kepk)
	{
		$this->db->select('kodefikasi');
		$this->db->from('tb_kepk');
		$this->db->where('id_kepk', $id_kepk);
		$rs = $this->db->get()->row_array();
		$nomor_kepk = $rs['kodefikasi'];

    $this->db->select('max(cast(right(nomor, 2) as signed)) as last_numb');
    $this->db->from('tb_anggota_tim_kepk');
    $this->db->where('id_kepk', $id_kepk);
    $rs = $this->db->get()->row_array();

    $no_urut = $rs['last_numb'] + 1;
		$len = strlen($no_urut);
    $nol = '';
		while($len < 2){
			$nol .= '0';
			$len++;
		}

		return $nomor_kepk . $nol . $no_urut;
	}

	function check_data_nik_exist($id_atk, $nik)
	{
		$this->db->select('1')->from('tb_anggota_tim_kepk')->where('nik', $nik)->where('id_atk <>', $id_atk);
		$rs = $this->db->get()->row_array();

		if ($rs) 
			return TRUE;

		return FALSE;
	}

	function check_data_email_exist($id_atk, $email)
	{
		$this->db->select('1')->from('tb_anggota_tim_kepk')->where('email', $email)->where('id_atk <>', $id_atk);
		$rs = $this->db->get()->row_array();

		if ($rs) 
			return TRUE;

		return FALSE;
	}

  public function check_exist_data($id)
	{
		$this->db->select('
				(select count(b.id_atk) from tb_struktur_tim_kepk as b where b.id_atk = a.id_atk) as struktur_pakai,
				(select count(c.id_atk_sekretaris) from tb_resume as c where c.id_atk_sekretaris  = a.id_atk) as resume_pakai,
				(select count(d.id_atk_penelaah) from tb_telaah_awal as d where d.id_atk_penelaah = a.id_atk) as penelaah_pakai
			');
		$this->db->from('tb_anggota_tim_kepk as a');
		$this->db->where('a.id_atk', $id);
		$result = $this->db->get()->row_array();

		if (isset($result['struktur_pakai']) && $result['struktur_pakai'] > 0)
			return TRUE;
		else if (isset($result['resume_pakai']) && $result['resume_pakai'] > 0)
			return TRUE;
		else if (isset($result['penelaah_pakai']) && $result['penelaah_pakai'] > 0)
			return TRUE;

		return FALSE;
	}

	public function delete_detail($id)
	{
		$this->delete_anggota_tim_kepk($id);
	}

  function delete_anggota_tim_kepk($id)
  {
  	$this->db->where('id_atk', $id);
  	$this->db->delete('tb_anggota_tim_kepk');
  	$this->check_trans_status('delete tb_anggota_tim_kepk failed');
  }

}
