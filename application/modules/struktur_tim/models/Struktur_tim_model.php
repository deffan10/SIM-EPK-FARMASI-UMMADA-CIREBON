<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_tim_model extends Core_Model {

  var $data_struktur;
  var $id_stk;
  var $aktif_tim_kepk;
  var $purge_wakil_ketua;
  var $purge_sekretaris;
  var $purge_kesekretariatan;
  var $purge_penelaah;
  var $purge_lay_person;
  var $purge_konsultan;
  var $new_atk_to_stk;

	public function __construct()
	{
		parent::__construct();

    $this->fieldmap_filter = array(
      'id' => 't.id_tim_kepk',
      'aktif_tim_kepk' => "case t.aktif
                            when 1 then 'Ya'
                            when 0 then 'Tidak'
                          end", 
      'ketua' => '(select a.nama from tb_anggota_tim_kepk as a join tb_struktur_tim_kepk as s on s.id_atk = a.id_atk where a.id_kepk = t.id_kepk and s.id_tim_kepk = t.id_tim_kepk and s.jabatan = 1)'
    );
	}

  public function fill_data()
  {
    $id = $this->input->post('id') ? $this->input->post('id') : 0;
    $id_kepk = $this->session->userdata('id_kepk');
    $periode_awal = $this->input->post('periode_awal') ? implode("-", array_reverse(explode("/", $this->input->post('periode_awal')))) : '';
    $periode_akhir = $this->input->post('periode_akhir') ? implode("-", array_reverse(explode("/", $this->input->post('periode_akhir')))) : '';
    $aktif = $this->input->post('aktif') && $this->input->post('aktif') === "true" ? 1 : 0;

    $this->aktif_tim_kepk = $aktif;

    $this->data = array(
        'id_tim_kepk' => $id,
        'id_kepk' => $id_kepk,
        'periode_awal' => $periode_awal,
        'periode_akhir' => $periode_akhir,
        'aktif' => $aktif 
    );

    /*
    Jabatan Tim KEPK
      when 1 then 'Ketua'
      when 2 then 'Wakil Ketua'
      when 3 then 'Sekretaris'
      when 4 then 'Kesekretariatan'
      when 5 then 'Penelaah'
      when 6 then 'Lay Person'
      when 7 then 'Konsultan Independen'
    */

    $ketua = $this->input->post('ketua') ? $this->input->post('ketua') : 0;
    $this->data_struktur[] = array('id_atk' => $ketua, 'jabatan' => 1);

    $wakil_ketua = $this->input->post('wakil_ketua') ? $this->input->post('wakil_ketua') : 0;
    if ($wakil_ketua)
    {   
      for ($i=0; $i<count($wakil_ketua); $i++)
      {
        $id_atk = $wakil_ketua[$i];
        $this->data_struktur[] = array('id_atk' => $id_atk, 'jabatan' => 2);
      }
    }

    $sekretaris = $this->input->post('sekretaris') ? $this->input->post('sekretaris') : 0;
    if ($sekretaris)
    {   
      for ($i=0; $i<count($sekretaris); $i++)
      {
        $id_atk = $sekretaris[$i];
        $this->data_struktur[] = array('id_atk' => $id_atk, 'jabatan' => 3);
      }
    }

    $kesekretariatan = $this->input->post('kesekretariatan') ? $this->input->post('kesekretariatan') : 0;
    if ($kesekretariatan)
    {
      for ($i=0; $i<count($kesekretariatan); $i++)
      {
        $id_atk = $kesekretariatan[$i];
        $this->data_struktur[] = array('id_atk' => $id_atk, 'jabatan' => 4);
      }
    }

    $penelaah = $this->input->post('penelaah') ? $this->input->post('penelaah') : 0;
    if ($penelaah)
    {
      for ($i=0; $i<count($penelaah); $i++)
      {
        $id_atk = $penelaah[$i];
        $this->data_struktur[] = array('id_atk' => $id_atk, 'jabatan' => 5);
      }
    }

    $lay_person = $this->input->post('lay_person') ? $this->input->post('lay_person') : 0;
    if ($lay_person)
    {
      for ($i=0; $i<count($lay_person); $i++)
      {
        $id_atk = $lay_person[$i];
        $this->data_struktur[] = array('id_atk' => $id_atk, 'jabatan' => 6);
      }
    }

    $konsultan = $this->input->post('konsultan') ? $this->input->post('konsultan') : 0;
    if ($konsultan)
    {
      for ($i=0; $i<count($konsultan); $i++)
      {
        $id_atk = $konsultan[$i];
        $this->data_struktur[] = array('id_atk' => $id_atk, 'jabatan' => 7);
      }
    }

    $this->purge_wakil_ketua = $this->input->post('purge_wakil_ketua') ? $this->input->post('purge_wakil_ketua') : '';
    $this->purge_sekretaris = $this->input->post('purge_sekretaris') ? $this->input->post('purge_sekretaris') : '';
    $this->purge_kesekretariatan = $this->input->post('purge_kesekretariatan') ? $this->input->post('purge_kesekretariatan') : '';
    $this->purge_penelaah = $this->input->post('purge_penelaah') ? $this->input->post('purge_penelaah') : '';
    $this->purge_lay_person = $this->input->post('purge_lay_person') ? $this->input->post('purge_lay_person') : '';
    $this->purge_konsultan = $this->input->post('purge_konsultan') ? $this->input->post('purge_konsultan') : '';
  }

  function save_detail()
  {
    $this->insert_tim_kepk();
    $this->insert_struktur_tim_kepk_and_users();

    if ($this->aktif_tim_kepk == 1)
    {
      $this->update_tim_kepk_and_users(); // non aktifkan tim kepk lain karena hanya satu yg status aktif
      $this->kirim_email();
    }
  }

  public function insert_tim_kepk()
  {
    if (isset($this->data['id_tim_kepk']) && $this->data['id_tim_kepk'] > 0)
    {
      $this->db->where('id_tim_kepk', $this->data['id_tim_kepk']);
      $this->db->update('tb_tim_kepk', $this->data);
      $this->check_trans_status('update tb_tim_kepk failed');
      $this->id = $this->data['id_tim_kepk'];
    }
    else
    {
      unset($this->data['id_tim_kepk']);
      $this->db->insert('tb_tim_kepk', $this->data);
      $this->check_trans_status('insert tb_tim_kepk failed');
      $this->id = $this->db->insert_id();
    }
  }

  public function insert_struktur_tim_kepk_and_users()
  {
    if ($this->purge_wakil_ketua)
    {
      // hapus di tb_users dulu
      $this->db->select('id_stk');
      $this->db->from('tb_struktur_tim_kepk');
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 2);
      $this->db->where_in('id_atk', $this->purge_wakil_ketua);
      $result = $this->db->get()->result_array();

      if (!empty($result))
      {
        for ($i=0; $i<count($result); $i++)
        {
          $this->db->where('id_stk', $result[$i]['id_stk']);
          $this->db->delete('tb_users');
        }
      }

      $this->db->where_in('id_atk', $this->purge_wakil_ketua);
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 2);
      $this->db->delete('tb_struktur_tim_kepk');
      $this->check_trans_status('delete tb_struktur_tim_kepk failed');
    }

    if ($this->purge_sekretaris)
    {
      // hapus di tb_users dulu
      $this->db->select('id_stk');
      $this->db->from('tb_struktur_tim_kepk');
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 3);
      $this->db->where_in('id_atk', $this->purge_sekretaris);
      $result = $this->db->get()->result_array();

      if (!empty($result))
      {
        for ($i=0; $i<count($result); $i++)
        {
          $this->db->where('id_stk', $result[$i]['id_stk']);
          $this->db->delete('tb_users');
        }
      }

      $this->db->where_in('id_atk', $this->purge_sekretaris);
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 3);
      $this->db->delete('tb_struktur_tim_kepk');
      $this->check_trans_status('delete tb_struktur_tim_kepk failed');
    }

    if ($this->purge_kesekretariatan)
    {
      // hapus di tb_users dulu
      $this->db->select('id_stk');
      $this->db->from('tb_struktur_tim_kepk');
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 4);
      $this->db->where_in('id_atk', $this->purge_kesekretariatan);
      $result = $this->db->get()->result_array();

      if (!empty($result))
      {
        for ($i=0; $i<count($result); $i++)
        {
          $this->db->where('id_stk', $result[$i]['id_stk']);
          $this->db->delete('tb_users');
        }
      }

      $this->db->where_in('id_atk', $this->purge_kesekretariatan);
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 4);
      $this->db->delete('tb_struktur_tim_kepk');
      $this->check_trans_status('delete tb_struktur_tim_kepk failed');
    }

    if ($this->purge_penelaah)
    {
      // hapus di tb_users dulu
      $this->db->select('id_stk');
      $this->db->from('tb_struktur_tim_kepk');
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 5);
      $this->db->where_in('id_atk', $this->purge_penelaah);
      $result = $this->db->get()->result_array();

      if (!empty($result))
      {
        for ($i=0; $i<count($result); $i++)
        {
          $this->db->where('id_stk', $result[$i]['id_stk']);
          $this->db->delete('tb_users');
        }
      }

      $this->db->where_in('id_atk', $this->purge_penelaah);
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 5);
      $this->db->delete('tb_struktur_tim_kepk');
      $this->check_trans_status('delete tb_struktur_tim_kepk failed');
    }

    if ($this->purge_lay_person)
    {
      // hapus di tb_users dulu
      $this->db->select('id_stk');
      $this->db->from('tb_struktur_tim_kepk');
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 6);
      $this->db->where_in('id_atk', $this->purge_lay_person);
      $result = $this->db->get()->result_array();

      if (!empty($result))
      {
        for ($i=0; $i<count($result); $i++)
        {
          $this->db->where('id_stk', $result[$i]['id_stk']);
          $this->db->delete('tb_users');
        }
      }

      $this->db->where_in('id_atk', $this->purge_lay_person);
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 6);
      $this->db->delete('tb_struktur_tim_kepk');
      $this->check_trans_status('delete tb_struktur_tim_kepk failed');
    }

    if ($this->purge_konsultan)
    {
      // hapus di tb_users dulu
      $this->db->select('id_stk');
      $this->db->from('tb_struktur_tim_kepk');
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 7);
      $this->db->where_in('id_atk', $this->purge_konsultan);
      $result = $this->db->get()->result_array();

      if (!empty($result))
      {
        for ($i=0; $i<count($result); $i++)
        {
          $this->db->where('id_stk', $result[$i]['id_stk']);
          $this->db->delete('tb_users');
        }
      }

      $this->db->where_in('id_atk', $this->purge_konsultan);
      $this->db->where('id_tim_kepk', $this->id);
      $this->db->where('jabatan', 7);
      $this->db->delete('tb_struktur_tim_kepk');
      $this->check_trans_status('delete tb_struktur_tim_kepk failed');
    }

    if (!empty($this->data_struktur))
    {
      for ($i=0; $i<count($this->data_struktur); $i++)
      {
        if ($this->data_struktur[$i]['jabatan'] == 1)
        {
          // insert or update tb_struktur_tim_kepk
          $this->db->select('id_stk')->from('tb_struktur_tim_kepk as s')->where('s.jabatan', 1)->where('s.id_tim_kepk', $this->id);
          $rs = $this->db->get()->row_array();

          if ($rs)
          {
            // update tb_struktur_tim_kepk
            $this->db->where('id_tim_kepk', $this->id);
            $this->db->where('jabatan', $this->data_struktur[$i]['jabatan']);
            $this->db->update('tb_struktur_tim_kepk', $this->data_struktur[$i]);
            $this->check_trans_status('update tb_struktur_tim_kepk failed');
            $this->id_stk = $rs['id_stk'];
          }
          else
          {
            // insert tb_struktur_tim_kepk
            $this->data_struktur[$i]['id_tim_kepk'] = $this->id;
            $this->db->insert('tb_struktur_tim_kepk', $this->data_struktur[$i]);
            $this->check_trans_status('insert tb_struktur_tim_kepk failed');
            $this->id_stk = $this->db->insert_id();
            $this->new_atk_to_stk[] = $this->data_struktur[$i]['id_atk'];
          }

          // get data detail anggota tim kepk untuk insert ke tb_user
          $this->db->select('atk.nomor, atk.nama, atk.email');
          $this->db->from('tb_anggota_tim_kepk as atk');
          $this->db->join('tb_struktur_tim_kepk as stk', 'stk.id_atk = atk.id_atk');
          $this->db->where('stk.id_stk', $this->id_stk);
          $rs1 = $this->db->get()->row_array();

          $data_users = array(
            'nama' => $rs1['nama'],
            'username' => $rs1['nomor'],
            'password' => md5($rs1['nomor']),
            'email' => $rs1['email'],
            'id_group' => 7,
            'id_kepk' => $this->session->userdata('id_kepk'),
            'id_stk' => $this->id_stk,
            'aktif' => 1
          );

          $this->db->select('1')->from('tb_users')->where('id_stk', $this->id_stk)->where('id_group', 7);
          $rs2 = $this->db->get()->row_array();

          if ($rs2)
          {
            $this->db->where('id_stk', $this->id_stk);
            $this->db->update('tb_users', $data_users);
            $this->check_trans_status('insert tb_users failed');
          }
          else
          {
            $this->db->insert('tb_users', $data_users);
            $this->check_trans_status('insert tb_users failed');
          }
        }
        else
        {
          // insert or update tb_struktur_tim_kepk
          $this->db->select('id_stk')->from('tb_struktur_tim_kepk as s')->where('s.id_atk', $this->data_struktur[$i]['id_atk'])->where('s.jabatan', $this->data_struktur[$i]['jabatan'])->where('s.id_tim_kepk', $this->id);
          $rs = $this->db->get()->row_array();

          if ($rs)
          {
            // update tb_struktur_tim_kepk
            $this->db->where('id_tim_kepk', $this->id);
            $this->db->where('id_atk', $this->data_struktur[$i]['id_atk']);
            $this->db->where('jabatan', $this->data_struktur[$i]['jabatan']);
            $this->db->update('tb_struktur_tim_kepk', $this->data_struktur[$i]);
            $this->check_trans_status('update tb_struktur_tim_kepk failed');
            $this->id_stk = $rs['id_stk'];
          }
          else
          {
            // insert tb_struktur_tim_kepk
            $this->data_struktur[$i]['id_tim_kepk'] = $this->id;
            $this->db->insert('tb_struktur_tim_kepk', $this->data_struktur[$i]);
            $this->check_trans_status('insert tb_struktur_tim_kepk failed');
            $this->id_stk = $this->db->insert_id();
            $this->new_atk_to_stk[] = $this->data_struktur[$i]['id_atk'];
          }

          // get data detail anggota tim kepk untuk insert ke tb_user
          $this->db->select('atk.nomor, atk.nama, atk.email');
          $this->db->from('tb_anggota_tim_kepk as atk');
          $this->db->join('tb_struktur_tim_kepk as stk', 'stk.id_atk = atk.id_atk');
          $this->db->where('stk.id_stk', $this->id_stk);
          $rs1 = $this->db->get()->row_array();

        /*
        Jabatan Tim KEPK
          when 1 then 'Ketua', id_group = 7
          when 2 then 'Wakil Ketua', id_group =  8
          when 3 then 'Sekretaris', id_group =  4
          when 4 then 'Kesekretariatan', id_group =  5
          when 5 then 'Penelaah', id_group =  6
          when 6 then 'Lay Person', id_group =  6
          when 7 then 'Konsultan Independen', id_group =  6
        */

          switch($this->data_struktur[$i]['jabatan'])
          {
            case 1: $id_group = 7; break;
            case 2: $id_group = 8; break;
            case 3: $id_group = 4; break;
            case 4: $id_group = 5; break;
            case 5: $id_group = 6; break;
            case 6: $id_group = 6; break;
            case 7: $id_group = 6; break;
            default: $id_group = 0;
          }

          $data_users = array(
            'nama' => $rs1['nama'],
            'username' => $rs1['nomor'],
            'password' => md5($rs1['nomor']),
            'email' => $rs1['email'],
            'id_group' => $id_group,
            'id_kepk' => $this->session->userdata('id_kepk'),
            'id_stk' => $this->id_stk,
            'aktif' => 1
          );

          $this->db->select('1')->from('tb_users')->where('id_stk', $this->id_stk);
          $rs2 = $this->db->get()->row_array();

          if ($rs2)
          {
            $this->db->where('id_stk', $this->id_stk);
            $this->db->update('tb_users', $data_users);
            $this->check_trans_status('insert tb_users failed');
          }
          else
          {
            $this->db->insert('tb_users', $data_users);
            $this->check_trans_status('insert tb_users failed');
          }
        }
      }
    }

  }

  function update_tim_kepk_and_users()
  {
    $this->db->where('id_tim_kepk <>', $this->id);
    $this->db->update('tb_tim_kepk', array('aktif' => 0));

    $this->db->select('id_stk');
    $this->db->from('tb_struktur_tim_kepk');
    $this->db->where('id_tim_kepk <>', $this->id);
    $result = $this->db->get()->result_array();

    // non aktifkan user akun anggota tim kepk dari struktur tim kepk lain yang sudah tidak aktif
    if (!empty($result))
    {
      for ($i=0; $i<count($result); $i++)
      {
        $this->db->where('id_stk', $result[$i]['id_stk']);
        $this->db->update('tb_users', array('aktif' => 0));
      }
    }
  }

  function kirim_email()
  {
    /*
    hanya anggota tim kepk dengan jabatan baru saja yang akan di email
    jadi jika struktur tim kepk baru dibuat maka akan diemail semua anggotanya
    */
    if (!empty($this->new_atk_to_stk) && !empty($this->data_struktur))
    {
      $data = [];
      for ($i=0; $i<count($this->data_struktur); $i++)
      {
        switch ($this->data_struktur[$i]['jabatan']) {
          case 1: $jabatan = 'Ketua'; break;
          case 2: $jabatan = 'Wakil Ketua'; break;
          case 3: $jabatan = 'Sekretaris'; break;
          case 4: $jabatan = 'Kesekretariatan'; break;
          case 5: $jabatan = 'Penelaah'; break;
          case 6: $jabatan = 'Lay Person'; break;
          case 7: $jabatan = 'Konsultan Independen'; break;
          default: $jabatan = ''; break;
        }

        $id_at = $this->data_struktur[$i]['id_atk'];
        $this->db->select('a.nomor, a.nama, a.email, k.nama_kepk');
        $this->db->from('tb_anggota_tim_kepk as a');
        $this->db->join('tb_kepk as k', 'k.id_kepk = a.id_kepk');
        $this->db->where('a.id_atk', $id_at);
        $this->db->where_in('a.id_atk', $this->new_atk_to_stk); // hanya yang baru dimasukkan baru yang diemail
        $rs = $this->db->get()->row_array();

        if ($rs)
        {
          $data[$id_at]['nomor'] = $rs['nomor'];
          $data[$id_at]['nama'] = $rs['nama'];
          $data[$id_at]['email'] = $rs['email'];
          $data[$id_at]['jabatan'][] = $jabatan;
          $data[$id_at]['kepk'] = $rs['nama_kepk'];
        }
      }

      if (!empty($data))
      {
        $this->load->library('email');

        $this->db->select('t.periode_awal, t.periode_akhir');
        $this->db->from('tb_tim_kepk as t');
        $this->db->where('t.id_tim_kepk', $this->id);
        $rs = $this->db->get()->row_array();
        $awal = date('d-m-Y', strtotime($rs['periode_awal']));
        $akhir = date('d-m-Y', strtotime($rs['periode_akhir']));

        foreach ($data as $key=>$val)
        {
          $last  = array_slice($val['jabatan'], -1);
          $first = join(', ', array_slice($val['jabatan'], 0, -1));
          $both  = array_filter(array_merge(array($first), $last), 'strlen');
          $jabatan = join(" dan ", $both);

          $pesan = '';
          $pesan .= '<p><b>'.$val['nama'].'</b> telah terdaftar sebagai anggota tim KEPK di '.$val['kepk'].' dengan nomor anggota <b>'.$val['nomor'].'</b>. Dan menjabat sebagai <b>'.$jabatan.'</b> pada periode <b>'.$awal.' s/d '.$akhir.'</b>.</p>';
          $pesan .= '<p>Gunakan nomor anggota untuk username dan password ketika login sebagai <b>'.$jabatan.'</b> di SIM-EPK '.$val['kepk'].'</p>';

          $email_to = $val['email'];

          $this->email->from('keppkn@kemkes.go.id', 'KEPPKN');
          $this->email->to($email_to);
          $this->email->subject('Struktur Tim KEPK');
          $this->email->message($pesan);

          try {
            $send = $this->email->send();
      /*      if ($send)
            {
              $path = "{mail.kemkes.go.id:993/imap/ssl/novalidate-cert}Sent"; // 993 is my IMAP port.
              //Tell your server to open an IMAP connection using the same username and password as you used for SMTP
              $imapStream = imap_open($path, 'keppkn@kemkes.go.id', 'xRDJ12%H');
              $result = imap_append($imapStream, $path, "From: keppkn@kemkes.go.id\r\n"
                           . "To: ".$email_to."\r\n"
                           . "Subject: Struktur Tim KEPK\r\n"
                           . "\r\n"
                           . $pesan."\r\n");
              imap_close($imapStream);
            }*/
          }
          catch(Exception $e){
            //TODO : log error to file
          }
        }
      }
    }
  }

  public function get_data_jqgrid($param, $isCount=FALSE, $CompileOnly=False)
  {
    $this->db->select("
        t.id_tim_kepk, t.periode_awal, t.periode_akhir, 
        case t.aktif 
          when 1 then 'Ya'
          when 0 then 'Tidak'
        end as aktif_tim_kepk, 
        (select a.nama from tb_anggota_tim_kepk as a join tb_struktur_tim_kepk as s on s.id_atk = a.id_atk where a.id_kepk = t.id_kepk and s.id_tim_kepk = t.id_tim_kepk and s.jabatan = 1) as ketua
      ");
    $this->db->from('tb_tim_kepk as t');
    $this->db->where('t.id_kepk', $this->session->userdata('id_kepk'));

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

	public function get_data_by_id($id)
	{
		$this->db->select('t.id_tim_kepk, t.periode_awal, t.periode_akhir, t.aktif');
		$this->db->from('tb_tim_kepk as t');
		$this->db->where('t.id_tim_kepk', $id);
		$result = $this->db->get()->row_array();

		return $result;
	}

	public function get_data_struktur_tim_kepk_by_id($id)
	{
		$this->db->select("a.id_atk, a.nama, a.nomor, s.jabatan");
		$this->db->from('tb_struktur_tim_kepk as s');
		$this->db->join('tb_anggota_tim_kepk as a', 'a.id_atk = s.id_atk');
		$this->db->where('s.id_tim_kepk', $id);
		$this->db->order_by('s.jabatan');
		$result = $this->db->get()->result_array();

		return $result;
	}

  public function get_data_opt_anggota_tim_kepk()
  {
    $this->db->select('a.id_atk, a.nomor, a.nama');
    $this->db->from('tb_anggota_tim_kepk as a');
    $this->db->where('a.id_kepk', $this->session->userdata('id_kepk'));
    $result = $this->db->get()->result_array();

    return $result;
  }

  public function check_exist_data($id)
	{
		return FALSE;
	}

	public function delete_detail($id)
	{
		$this->delete_user($id);
		$this->delete_struktur($id);
		$this->delete_tim_kepk($id);
	}

	function delete_user($id)
	{
		$this->db->select('id_stk')->from('tb_struktur_tim_kepk')->where('id_tim_kepk', $id);
		$result = $this->db->get()->result_array();

    if (!empty($result))
    {
      for ($i=0; $i<count($rs); $i++)
      {
        $this->db->where('id_stk', $rs[$i]['id_stk']);
        $this->db->delete('tb_users');
        $this->check_trans_status('delete tb_users failed');
      }
    }
	}

	function delete_struktur($id)
	{
		$this->db->where('id_tim_kepk', $id);
		$this->db->delete('tb_struktur_tim_kepk');
		$this->check_trans_status('delete tb_struktur_tim_kepk failed');
	}

	function delete_tim_kepk($id)
	{
		$this->db->where('id_tim_kepk', $id);
		$this->db->delete('tb_tim_kepk');
		$this->check_trans_status('delete tb_tim_kepk failed');
	}

}
