  <form class="form-horizontal" role="form">
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="nomor"> Nomor Anggota </label>
      <div class="col-sm-9">
        <input type="text" id="nomor" placeholder="Nomor Anggota" class="form-control" data-bind="value: nomor" disabled="disabled" />
        <p data-bind="visible: id() == 0"><small>Nomor Anggota akan muncul jika data berhasil disimpan</small></p>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="nama"> Nama Anggota </label>
      <div class="col-sm-9">
        <input type="text" id="nama" placeholder="Nama Anggota" class="form-control" data-bind="value: nama" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="nik"> NIK </label>
      <div class="col-sm-9">
        <input type="text" id="nik" placeholder="NIK" class="form-control" data-bind="value: nik" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="email"> Email </label>
      <div class="col-sm-9">
        <input type="text" id="email" placeholder="Email" class="form-control" data-bind="value: email" />
        <p class="text-danger"><small>Email harus valid</small></p>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="no_telp"> No. Telepon </label>
      <div class="col-sm-9">
        <input type="text" id="no_telp" placeholder="No. Telepon" class="form-control" data-bind="value: no_telp" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="no_hp"> No. HP </label>
      <div class="col-sm-9">
        <input type="text" id="no_hp" placeholder="No. HP" class="form-control" data-bind="value: no_hp" />
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="no_sertifikat"> Nomor Sertifikat ED/EDL </label>
      <div class="col-sm-9">
        <input type="text" id="no_sertifikat" placeholder="Nomor Sertifikat ED/EDL" class="form-control" data-bind="value: no_sertifikat" />
      </div>
    </div>
    <div class="form-group" data-bind="visible: file_name_sertifikat !== ''">
      <label class="col-sm-3 control-label no-padding-right" for="file_sertifikat"> Sertifikat ED/EDL </label>
      <div class="col-sm-9">
        <div class="input-group">
          <input type="text" id="file_sertifikat" class="form-control" data-bind="value: file_name_sertifikat" disabled="disabled" />
          <span class="input-group-addon">
            <a href="#" data-bind="click: function(){ showFile('uploads/'+file_name_sertifikat) }" title="Lihat File"><i class="fa fa-search bigger-110"></i></a>
          </span>
          <span class="input-group-addon">
            <a href="#" data-bind="click: function(){ downloadFile(file_name_sertifikat, client_name_sertifikat) }" title="Unduh File"><i class="fa fa-download bigger-110"></i></a>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="col-sm-3 control-label no-padding-right" for="link_gdrive"> Link Google Drive Sertifikat ED/EDL </label>
      <div class="col-sm-9">
        <input type="text" id="link_gdrive" placeholder="Link Google Drive Sertifikat ED/EDL" class="form-control" data-bind="value: link_gdrive" />
        <p class="text-danger"><small>File diunggah ke google doc agar tidak perlu ganti link jika ingin merevisi/mengubah file</small></p>
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