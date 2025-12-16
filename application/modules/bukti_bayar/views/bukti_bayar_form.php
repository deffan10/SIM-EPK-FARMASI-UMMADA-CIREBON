<form class="form-horizontal" role="form" enctype="multipart/form-data" method="post">
  <h4 class="header smaller lighter blue">
		Protokol
	</h4>
	<div class="row">
    <div class="col-sm-12">
      <select class="select2 form-control" id="id_pengajuan" data-bind="value: id_pengajuan, enable: id() == 0" data-placeholder="Nomor Protokol">
        <option value=""></option>
        <?php
        if (!empty($opt_pengajuan))
        {
          for ($i=0; $i<count($opt_pengajuan); $i++)
            echo '<option value="'.$opt_pengajuan[$i]['id_pengajuan'].'">'.$opt_pengajuan[$i]['no_protokol'].' - '.$opt_pengajuan[$i]['judul'].'</option>';
        }
        if (isset($data['id_bb']) && $data['id_bb'] > 0)
          echo '<option value="'.$data['id_pengajuan'].'">'.$data['no_protokol'].' - '.$data['judul'].'</option>';
        ?>
      </select>
    </div>
	</div>

  <h4 class="header smaller lighter blue">Bukti Bayar <small class="text-danger"><i>(*Bagi instansi yang tidak memungut biaya mahasiswanya, upload Kartu Mahasiswa)</i></small></h4>
  <div class="row">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-sm-4">
					<label for="nomor"> Nomor Bukti Bayar <small class="text-danger">(*Nomor Mahasiswa)</small> </label>
					<input type="text" id="nomor" placeholder="Nomor" class="form-control" data-bind="value: nomor" />
				</div>
				<div class="col-sm-2">
					<label for="tanggal">Tanggal Bukti Bayar</label>
					<div class="input-group">
						<input type="text" id="tanggal" placeholder="Tanggal" class="form-control date-picker" data-date-format="dd/mm/yyyy" data-bind="value: tanggal" />
						<span class="input-group-addon">
							<i class="fa fa-calendar bigger-110"></i>
						</span>
  				</div>
				</div>
			</div>

      <?php if (isset($data['client_name']) && $data['client_name'] !== "") { ?>
      <div class="space-8"></div>

			<div class="row">
				<div class="col-sm-12">
          <label for="file"> File Bukti Bayar </label>
          <p>
            <?php echo $data['client_name']; ?>
            &nbsp;
            <a href="#" data-bind="click: function(){ showFile('uploads/<?php echo isset($data['file_name']) ? $data['file_name'] : 0;?>') }" title="Lihat File">
              <i class="ace-icon fa fa-search bigger-110"></i>
            </a>&nbsp;
            <a href="#" data-bind="click: function() { downloadFile('<?php echo isset($data['file_name']) ? rawurlencode(urlencode($data['file_name'])) : 0;?>', '<?php echo isset($data['client_name']) ? $data['client_name'] : 0;?>')}">
              <i class="fa fa-download"></i>
            </a>
          </p>
				</div>
			</div>
      <?php } ?>

      <div class="space-8"></div>

      <div class="row">
				<div class="col-sm-8">
					<label for="link_gdrive"> Link Google Drive </label>
					<input type="text" id="link_gdrive" placeholder="Link Google Drive" class="form-control" data-bind="value: link_gdrive" />
          <p class="text-danger"><small>File diunggah ke google doc agar tidak perlu ganti link jika ingin merevisi/mengubah file</small></p>
        </div>
			</div>
    </div>
	</div>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-floppy-o bigger-110"></i>
				Simpan
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn btn-warning" type="button" data-bind="click: back, enable: !processing()">
				<i class="ace-icon fa fa-list bigger-110"></i>
				Lihat Daftar
			</button>
		</div>
	</div>

</form>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
        <h4 class="modal-title">Lihat File</h4>
      </div>
      <div class="modal-body" id="myModalbody">
        <div id="show_data_modal"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="ace-icon fa fa-icon fa-close"></i> Tutup</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->
