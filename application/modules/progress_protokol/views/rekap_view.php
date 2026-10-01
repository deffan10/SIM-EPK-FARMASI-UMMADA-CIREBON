<?php
$daftar_bulan = bulan_list();
$tahun_mulai = 2017;
$tahun_sekarang = date('Y');
?>

<div class="row">
  <div class="col-xs-12">
    <div class="widget-box">
      <div class="widget-header widget-header-flat widget-header-small">
        <h5 class="widget-title">
          <i class="ace-icon fa fa-filter"></i>
          Filter Periode Surat Pembebasan Etik
        </h5>
      </div>

      <div class="widget-body">
        <div class="widget-main">
          <form action="<?php echo base_url()?>progress_protokol/rekap" method="post" class="form-inline" id="form-rekap">
            <div class="form-group">
              <label for="bulan_awal">Dari</label>
              <select name="bulan_awal" id="bulan_awal" class="form-control" required>
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                <option value="<?php echo $i ?>" <?php echo ((int)$bulan_awal == $i) ? 'selected' : '' ?>><?php echo $daftar_bulan[str_pad($i, 2, '0', STR_PAD_LEFT)] ?></option>
                <?php } ?>
              </select>
              <select name="tahun_awal" id="tahun_awal" class="form-control" required>
                <?php for ($i = $tahun_mulai; $i <= $tahun_sekarang; $i++) { ?>
                <option value="<?php echo $i ?>" <?php echo ((int)$tahun_awal == $i) ? 'selected' : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="form-group">
              <label for="bulan_akhir">sampai</label>
              <select name="bulan_akhir" id="bulan_akhir" class="form-control" required>
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                <option value="<?php echo $i ?>" <?php echo ((int)$bulan_akhir == $i) ? 'selected' : '' ?>><?php echo $daftar_bulan[str_pad($i, 2, '0', STR_PAD_LEFT)] ?></option>
                <?php } ?>
              </select>
              <select name="tahun_akhir" id="tahun_akhir" class="form-control" required>
                <?php for ($i = $tahun_mulai; $i <= $tahun_sekarang; $i++) { ?>
                <option value="<?php echo $i ?>" <?php echo ((int)$tahun_akhir == $i) ? 'selected' : '' ?>><?php echo $i ?></option>
                <?php } ?>
              </select>
            </div>

            <button type="submit" name="filter" value="1" class="btn btn-sm btn-primary">
              <i class="ace-icon fa fa-search bigger-110"></i>
              Tampilkan
            </button>

            <a href="<?php echo base_url()?>progress_protokol/cetak_rekap/<?php echo $bulan_awal.'/'.$tahun_awal.'/'.$bulan_akhir.'/'.$tahun_akhir ?>" target="_blank" class="btn btn-sm btn-success">
              <i class="ace-icon fa fa-file-pdf-o bigger-110"></i>
              Cetak PDF
            </a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="space-6"></div>

<div class="row">
  <div class="col-xs-12">
    <div class="widget-box">
      <div class="widget-header widget-header-flat widget-header-small">
        <h5 class="widget-title">
          <i class="ace-icon fa fa-list"></i>
          Hasil Rekap
          <span class="badge badge-info"><?php echo count($rekap) ?> judul</span>
        </h5>
      </div>

      <div class="widget-body">
        <div class="widget-main">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="center" width="30">No</th>
                  <th width="120">No. Protokol</th>
                  <th width="150">Nama Peneliti</th>
                  <th>Judul Penelitian</th>
                  <th class="center" width="80">Acc Sekretaris</th>
                  <th class="center" width="100">Penelaah 1</th>
                  <th class="center" width="100">Penelaah 2</th>
                  <th class="center" width="100">Penelaah 3</th>
                  <th class="center" width="100">Penelaah 4</th>
                  <th class="center" width="100">Penelaah 5</th>
                  <th class="center" width="80">Acc Ketua</th>
                  <th class="center" width="90">Disahkan Kesekretariatan</th>
                  <th class="center" width="90">Sudah Dikirim ke Peneliti</th>
                </tr>
              </thead>
              <tbody>
                <?php if (empty($rekap)) { ?>
                <tr>
                  <td colspan="13" class="center">Tidak ada data</td>
                </tr>
                <?php } else { 
                  $no = 1;
                  foreach ($rekap as $row) { 
                    $penelaah1 = isset($row['penelaah'][0]) ? $row['penelaah'][0]['nama'] : '-';
                    $penelaah2 = isset($row['penelaah'][1]) ? $row['penelaah'][1]['nama'] : '-';
                    $penelaah3 = isset($row['penelaah'][2]) ? $row['penelaah'][2]['nama'] : '-';
                    $penelaah4 = isset($row['penelaah'][3]) ? $row['penelaah'][3]['nama'] : '-';
                    $penelaah5 = isset($row['penelaah'][4]) ? $row['penelaah'][4]['nama'] : '-';

                    $acc_sekretaris = !empty($row['nama_sekretaris']) ? '<i class="ace-icon fa fa-check green bigger-110"></i><br><small>'.$row['nama_sekretaris'].'<br>'.date('d/m/Y', strtotime($row['tgl_acc_sekretaris'])).'</small>' : '<i class="ace-icon fa fa-minus grey bigger-110"></i>';
                    $acc_ketua = !empty($row['nama_ketua_putusan']) ? '<i class="ace-icon fa fa-check green bigger-110"></i><br><small>'.$row['nama_ketua_putusan'].'<br>'.date('d/m/Y', strtotime($row['tgl_acc_ketua'])).'</small>' : '<i class="ace-icon fa fa-minus grey bigger-110"></i>';
                    $disahkan = !empty($row['tgl_disahkan']) ? '<i class="ace-icon fa fa-check green bigger-110"></i><br><small>'.date('d/m/Y', strtotime($row['tgl_disahkan'])).'</small>' : '<i class="ace-icon fa fa-minus grey bigger-110"></i>';
                    $kirim = !empty($row['sudah_kirim']) ? '<i class="ace-icon fa fa-check green bigger-110"></i><br><small>'.date('d/m/Y', strtotime($row['tgl_kirim_peneliti'])).'</small>' : '<i class="ace-icon fa fa-minus grey bigger-110"></i>';
                ?>
                <tr>
                  <td class="center"><?php echo $no++ ?></td>
                  <td><?php echo $row['no_protokol'] ?></td>
                  <td><?php echo $row['nama_ketua'] ?></td>
                  <td><?php echo $row['judul'] ?></td>
                  <td class="center"><?php echo $acc_sekretaris ?></td>
                  <td class="center"><?php echo $penelaah1 ?></td>
                  <td class="center"><?php echo $penelaah2 ?></td>
                  <td class="center"><?php echo $penelaah3 ?></td>
                  <td class="center"><?php echo $penelaah4 ?></td>
                  <td class="center"><?php echo $penelaah5 ?></td>
                  <td class="center"><?php echo $acc_ketua ?></td>
                  <td class="center"><?php echo $disahkan ?></td>
                  <td class="center"><?php echo $kirim ?></td>
                </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="space-6"></div>

<div class="row">
  <div class="col-xs-12">
    <div class="widget-box">
      <div class="widget-header widget-header-flat widget-header-small">
        <h5 class="widget-title">
          <i class="ace-icon fa fa-bar-chart"></i>
          Ringkasan
        </h5>
      </div>

      <div class="widget-body">
        <div class="widget-main">
          <div class="row">
            <?php for ($pos = 1; $pos <= 5; $pos++) { 
              if (!empty($summary['penelaah'][$pos])) { 
            ?>
            <div class="col-sm-3">
              <h5 class="header smaller lighter blue">Penelaah <?php echo $pos ?></h5>
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th class="center" width="60">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($summary['penelaah'][$pos] as $nama => $jumlah) { ?>
                  <tr>
                    <td><?php echo $nama ?></td>
                    <td class="center"><span class="badge badge-info"><?php echo $jumlah ?></span></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } } ?>
          </div>

          <div class="row">
            <?php if (!empty($summary['sekretaris'])) { ?>
            <div class="col-sm-4">
              <h5 class="header smaller lighter blue">Sekretaris</h5>
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th class="center" width="60">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($summary['sekretaris'] as $nama => $jumlah) { ?>
                  <tr>
                    <td><?php echo $nama ?></td>
                    <td class="center"><span class="badge badge-info"><?php echo $jumlah ?></span></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>

            <?php if (!empty($summary['ketua'])) { ?>
            <div class="col-sm-4">
              <h5 class="header smaller lighter blue">Ketua / Wakil Ketua</h5>
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th class="center" width="60">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($summary['ketua'] as $nama => $jumlah) { ?>
                  <tr>
                    <td><?php echo $nama ?></td>
                    <td class="center"><span class="badge badge-info"><?php echo $jumlah ?></span></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>

            <?php if (!empty($summary['kesekretariatan'])) { ?>
            <div class="col-sm-4">
              <h5 class="header smaller lighter blue">Kesekretariatan</h5>
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th class="center" width="60">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($summary['kesekretariatan'] as $nama => $jumlah) { ?>
                  <tr>
                    <td><?php echo $nama ?></td>
                    <td class="center"><span class="badge badge-info"><?php echo $jumlah ?></span></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
