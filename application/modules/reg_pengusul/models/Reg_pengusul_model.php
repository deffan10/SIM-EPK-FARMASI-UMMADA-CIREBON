<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reg_pengusul_model extends Core_Model {

	var $data_dok;
  var $data_user;
  var $username;
  var $password;

	public function __construct()
	{
		parent::__construct();

	}

	public function fill_data_proses($id_proses)
	{
    $id_kepk = $this->get_data_id_kepk();
    $nomor = $this->input->post('no_anggota') ? $this->input->post('no_anggota') : '';

    if ($id_proses == 3)
      $nomor = $this->get_data_no_peneliti($id_kepk);

  	$nama = $this->input->post('nama') ? $this->input->post('nama') : '';
  	$nik = $this->input->post('nik') ? $this->input->post('nik') : '';
    $tempat_lahir = $this->input->post('tempat_lahir') ? $this->input->post('tempat_lahir') : '';
    $tgl_lahir = $this->input->post('tgl_lahir') ? $this->input->post('tgl_lahir') : '';

    if ($id_proses == 3)
      $tgl_lahir = $this->input->post('tgl_lahir') ? implode("-", array_reverse(explode("-", $this->input->post('tgl_lahir')))) : '';

    $kewarganegaraan = $this->input->post('kewarganegaraan') ? $this->input->post('kewarganegaraan') : '';
    $id_country = $this->input->post('negara') ? $this->input->post('negara') : '';
	  $alamat = $this->input->post('alamat') ? $this->input->post('alamat') : '';
    $jalan = $this->input->post('jalan') ? $this->input->post('jalan') : '';
    $no_rumah = $this->input->post('no_rumah') ? $this->input->post('no_rumah') : '';
    $rt = $this->input->post('rt') ? $this->input->post('rt') : '';
    $rw = $this->input->post('rw') ? $this->input->post('rw') : '';
    $kode_propinsi = $this->input->post('propinsi') ? $this->input->post('propinsi') : '';
    $kode_kabupaten = $this->input->post('kabupaten') ? $this->input->post('kabupaten') : '';
    $kode_kecamatan = $this->input->post('kecamatan') ? $this->input->post('kecamatan') : '';
    $kode_pos = $this->input->post('kode_pos') ? $this->input->post('kode_pos') : '';
    $no_telp = $this->input->post('no_telp') ? $this->input->post('no_telp') : '';
    $no_hp = $this->input->post('no_hp') ? $this->input->post('no_hp') : '';
    $email = $this->input->post('email') ? $this->input->post('email') : '';
    $username = $this->input->post('username') ? $this->input->post('username') : '';
    $this->password = $this->input->post('password') ? $this->input->post('password') : '';

	  $this->data['id_kepk'] = $id_kepk;
	  $this->data['nomor'] = $nomor;
		$this->data['nama'] = $nama;
		$this->data['nik'] = $nik;
    $this->data['tempat_lahir'] = $tempat_lahir;
    $this->data['tgl_lahir'] = $tgl_lahir;
    $this->data['kewarganegaraan'] = $kewarganegaraan;
    $this->data['id_country'] = $id_country;
		$this->data['alamat'] = $alamat;
    $this->data['jalan'] = $jalan;
    $this->data['no_rumah'] = $no_rumah;
    $this->data['rt'] = $rt;
    $this->data['rw'] = $rw;
		$this->data['kode_propinsi'] = $kode_propinsi;
		$this->data['kode_kabupaten'] = $kode_kabupaten;
    $this->data['kode_kecamatan'] = $kode_kecamatan;
    $this->data['kode_pos'] = $kode_pos;
		$this->data['no_telepon'] = $no_telp;
    $this->data['no_hp'] = $no_hp;
		$this->data['email'] = $email;
    $this->data['aktif'] = 1;

    if ($id_proses == 1)
      $this->data['reg_keppkn'] = 1;
    else if ($id_proses == 2)
    {
      $this->data['reg_kepk_lain'] = 1;
      $this->data['kepk_asal'] = $this->input->post('kepk_asal') ? $this->input->post('kepk_asal') : '';
    }
    if ($id_proses == 3)
    {
      $this->data['reg_kepk_ini'] = 1;
      $this->data['terdaftar_kepk_ini'] = date('Y-m-d H:i:s');
    }

    $this->data = $this->security->xss_clean($this->data);

    $this->data_user['nama'] = $nama;
    $this->data_user['username'] = $id_proses == 3 ? $nik : $username;
    $this->data_user['password'] = $id_proses == 3 ? md5($this->password) : $this->password;
    $this->data_user['email'] = $email;
    $this->data_user['id_group'] = 3;
    $this->data_user['aktif'] = 1;

    $this->data_user = $this->security->xss_clean($this->data_user);

    $dokumen = $this->input->post('dokumen') ? $this->input->post('dokumen') : '';
    if ($dokumen)
    {
      for ($i=0; $i<count($dokumen); $i++)
      {
        $deskripsi = $dokumen[$i]['deskripsi'] ? $dokumen[$i]['deskripsi'] : '';
        $client_name = $dokumen[$i]['client_name'] ? $dokumen[$i]['client_name'] : '';
        $file_name = $dokumen[$i]['file_name'] ? $dokumen[$i]['file_name'] : '';
        $file_size = $dokumen[$i]['file_size'] ? $dokumen[$i]['file_size'] : '';
        $file_type = $dokumen[$i]['file_type'] ? $dokumen[$i]['file_type'] : '';
        $file_ext = $dokumen[$i]['file_ext'] ? $dokumen[$i]['file_ext'] : '';

        $this->data_dok[] = $this->security->xss_clean(
          array(
            'deskripsi_file' => $deskripsi,
            'client_name' => $client_name,
            'file_name' => $file_name,
            'file_size' => $file_size,
            'file_type' => $file_type,
            'file_ext' => $file_ext
          )
        );
      }
    }

  }

	public function save_detail()
	{
		$this->insert_pengusul();
    $this->insert_dokumen();
    $this->insert_users();
	}

	public function insert_pengusul()
	{
		$this->db->insert('tb_pengusul', $this->data);
		$this->check_trans_status('insert tb_pengusul failed');
		$this->id = $this->db->insert_id();
	}

  public function insert_dokumen()
  {
    if (!empty($this->data_dok))
    {
      for ($i=0; $i<count($this->data_dok); $i++)
      {
        $this->data_dok[$i]['id_pengusul'] = $this->id;
        $this->db->insert('tb_dokumen_pengusul', $this->data_dok[$i]);
        $this->check_trans_status('insert tb_dokumen_pengusul failed');
      }
    }
  }

  function insert_users()
  {
    $this->data_user['id_pengusul'] = $this->id;
    $this->db->insert('tb_users', $this->data_user);
    $this->check_trans_status('insert tb_users failed');
  }

  function get_data_id_kepk()
  {
    $this->db->select('id_kepk')->from('tb_kepk');
    $result = $this->db->get()->row_array();

    return isset($result['id_kepk']) ? $result['id_kepk'] : 0;
  }
	
  function get_data_pengusul_by_id($id)
  {
    $this->db->select("p.nomor, p.nama, p.nik, p.kewarganegaraan, p.no_telepon, p.no_hp, p.email, p.kepk_asal, k.nama_kepk, c.name as negara, u.username");
    $this->db->from('tb_pengusul as p');
    $this->db->join('tb_kepk as k', 'k.id_kepk = p.id_kepk');
    $this->db->join('countries as c', 'c.id = p.id_country');
    $this->db->join('tb_users as u', 'u.id_pengusul = p.id_pengusul');
    $this->db->where('p.id_pengusul', $id);
    $result = $this->db->get()->row_array();

    return $result;
  }

  function get_data_opt_propinsi()
	{
		$this->db->select('w.*');
		$this->db->from('wilayah as w');
    $this->db->where('char_length(w.kode)', 2);
		$result = $this->db->get()->result_array();

		return $result;
	}

  function get_data_opt_kabupaten_by_kd_prop($kd_prop='')
  {
    $this->db->select('w.*');
    $this->db->from('wilayah as w');
    $this->db->where('char_length(w.kode)', 5);
    if ($kd_prop != ''){
      $this->db->where('left(w.kode, 2) =', $kd_prop);
    }
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_opt_kecamatan_by_kd_prop($kd_kab='')
  {
    $this->db->select('w.*');
    $this->db->from('wilayah as w');
    $this->db->where('char_length(w.kode)', 8);
    if ($kd_kab != ''){
      $this->db->where('left(w.kode, 5) =', $kd_kab);
    }
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_opt_countries()
  {
    $this->db->select('c.id, c.name');
    $this->db->from('countries as c');
    $result = $this->db->get()->result_array();

    return $result;
  }

  function get_data_no_peneliti($id_kepk)
  {
    $this->db->select('k.kodefikasi');
    $this->db->from('tb_kepk as k');
    $this->db->where('k.id_kepk', $id_kepk);
    $rs = $this->db->get()->row_array();

    $kode = isset($rs['kodefikasi']) ? $rs['kodefikasi'] : '';

    $this->db->select('coalesce(max(cast(right(nomor, 4) as signed)), 0) as last_numb');
    $this->db->from('tb_pengusul');
    $this->db->where('year(terdaftar_kepk_ini)', date('Y'));
    $this->db->where('reg_kepk_ini', 1);
    $rs = $this->db->get()->row_array();

    $no_urut = $rs['last_numb'] + 1;
    $tahun = date('y');
    $len_no_urut = strlen($no_urut);
    $nol_no_urut = '';
    while($len_no_urut < 4){
      $nol_no_urut .= '0';
      $len_no_urut++;
    }

    $nomor = $kode . $tahun . $nol_no_urut . $no_urut;
    return $nomor;
  }

  function check_isset_data_kepk()
  {
    $this->db->select('1')->from('tb_kepk')->where('aktif = 1');
    $rs = $this->db->get()->row_array();

    return $rs ? 1 : 0;
  }

}
