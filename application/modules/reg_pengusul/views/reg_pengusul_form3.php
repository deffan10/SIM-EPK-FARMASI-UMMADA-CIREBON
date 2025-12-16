<div class="page-header">
	<h1>
		<?php echo isset($page_header) ? $page_header : 'Dashboard' ?>
		<?php if (isset($subheader)) { ?>
		<small>
			<i class="ace-icon fa fa-angle-double-right"></i>
			<?php echo $subheader ?>
		</small>
		<?php } ?>
	</h1>
</div><!-- /.page-header -->

<?php if (isset($isset_kepk) && $isset_kepk == 1) { ?>
<form class="form-horizontal" role="form" id="frm" data-bind="visible: !registered()">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nama"> Nama Lengkap </label>
		<div class="col-sm-9">
			<input type="text" id="nama" placeholder="Nama Lengkap" class="form-control" data-bind="value: nama" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="nik"> NIK </label>
		<div class="col-sm-9">
			<input type="text" id="nik" placeholder="NIK" class="form-control" data-bind="value: nik, valueUpdate: 'keyup'" />
      <p class="text-danger"><small>NIK harus valid. Digunakan sebagai username.</small></p>
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="ttl"> Tempat, Tanggal Lahir </label>
    <div class="col-sm-6">
      <input type="text" id="tempat_lahir" placeholder="Tempat Lahir" class="form-control" data-bind="value: tempat_lahir" />
    </div>
    <div class="col-sm-3">
      <div class="input-group">
        <input class="form-control date-picker" id="tgl_lahir" type="text" data-date-format="dd-mm-yyyy" data-bind="value: tgl_lahir" />
        <span class="input-group-addon">
          <i class="fa fa-calendar bigger-110"></i>
        </span>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="kewarganegaraan"> Kewarganegaraan </label>
    <div class="col-sm-9">
      <div class="radio">
        <label>
          <input name="kewarganegaraan" type="radio" class="ace" value="WNI" data-bind="checked: kewarganegaraan" />
          <span class="lbl"> WNI</span>
        </label>
        <label>
          <input name="kewarganegaraan" type="radio" class="ace" value="WNA" data-bind="checked: kewarganegaraan" />
          <span class="lbl"> WNA</span>
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="negara"> Negara </label>
    <div class="col-sm-9">
      <select class="form-control select2" id="negara" data-placeholder="Negara" data-bind="value: negara">
        <option value=""></option>
        <?php
        for ($a=0; $a<count($opt_country); $a++)
        {
          echo '<option value="'.$opt_country[$a]['id'].'">'.$opt_country[$a]['name'].'</option>';
        }
        ?>
      </select>
    </div>
  </div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="alamat"> Alamat </label>
		<div class="col-sm-9">
			<textarea id="alamat" class="autosize-transition form-control" data-bind="value: alamat"></textarea>
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="jalan"> Jalan </label>
    <div class="col-sm-9">
      <input type="text" id="jalan" placeholder="Jalan" class="form-control" data-bind="value: jalan" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="no_rumah"> Nomor </label>
    <div class="col-sm-9">
      <input type="text" id="no_rumah" placeholder="Nomor" class="form-control" data-bind="value: no_rumah" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="rt_rw"> RT / RW </label>
    <div class="col-sm-1">
      <input type="text" id="rt" placeholder="RT" class="form-control" data-bind="value: rt" />
    </div>
    <div class="col-sm-1">
      <input type="text" id="rw" placeholder="RW" class="form-control" data-bind="value: rw" />
    </div>
  </div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="propinsi"> Propinsi </label>
		<div class="col-sm-9">
			<select class="form-control select2" id="propinsi" data-placeholder="Propinsi" data-bind="value: propinsi">
				<option value=""></option>
				<?php
				for ($a=0; $a<count($opt_propinsi); $a++)
				{
          echo '<option value="'.$opt_propinsi[$a]['kode'].'">'.$opt_propinsi[$a]['nama'].'</option>';
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="kabupaten"> Kabupaten/Kotamadya </label>
		<div class="col-sm-9">
			<select class="form-control select2" id="kabupaten" data-placeholder="Kabupaten/Kotamadya" data-bind="value: kabupaten">
				<option value=""></option>
			</select>
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="kecamatan"> Kecamatan </label>
    <div class="col-sm-9">
      <select class="form-control select2" id="kecamatan" data-placeholder="Kecamatan" data-bind="value: kecamatan">
        <option value=""></option>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="kode_pos"> Kode Pos </label>
    <div class="col-sm-9">
      <input type="text" id="kode_pos" placeholder="Kode Pos" class="col-xs-10 col-sm-5" data-bind="value: kode_pos" />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="ln_solid"></label>
    <div class="col-sm-9">
    	<div class="hr hr-16"></div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="email"> Email </label>
    <div class="col-sm-9">
      <input type="text" id="email" placeholder="Email" class="col-xs-10 col-sm-5" data-bind="value: email" />
      <p class="text-danger"><small>Email harus valid.</small></p>
    </div>
  </div>
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="no_telp"> Nomor Telepon </label>
		<div class="col-sm-9">
			<input type="text" id="no_telp" placeholder="Nomor Telepon" class="col-xs-10 col-sm-5" data-bind="value: no_telp" />
		</div>
	</div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="no_hp"> Nomor Handphone </label>
    <div class="col-sm-9">
      <input type="text" id="no_hp" placeholder="Nomor HP" class="col-xs-10 col-sm-5" data-bind="value: no_hp" />
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="ln_solid"></label>
    <div class="col-sm-9">
    	<div class="hr hr-16"></div>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="username"> Username </label>
    <div class="col-sm-9">
      <input type="text" id="username" placeholder="Username" class="form-control" data-bind="value: username" disabled="disabled" />
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="password"> Password </label>
    <div class="col-sm-9">
      <span class="input-icon input-icon-right">
        <input type="password" id="password" placeholder="Password" class="form-control" data-bind="value: password" />
        <i class="ace-icon fa fa-eye toggle-password1"></i>
      </span>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-3 control-label no-padding-right" for="passconf"> Konfirmasi Password </label>
    <div class="col-sm-9">
      <span class="input-icon input-icon-right">
        <input type="password" id="passconf" placeholder="Konfirmasi Password" class="form-control" data-bind="value: passconf" />
        <i class="ace-icon fa fa-eye toggle-password2"></i>
      </span>
    </div>
  </div>

  <div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
			<button class="btn btn-info" id="submit" type="button" data-loading-text="Proses..." data-bind="click: function(data, event){save(false, data, event) }">
				<i class="ace-icon fa fa-check bigger-110"></i>
				Simpan
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn" type="reset" data-bind="enable: !processing()">
				<i class="ace-icon fa fa-undo bigger-110"></i>
				Batal
			</button>

			&nbsp; &nbsp; &nbsp;
			<button class="btn btn-warning" type="button" data-bind="click: back, enable: !processing()">
				<i class="ace-icon fa fa-arrow-left bigger-110"></i>
				Kembali
			</button>
    </div>
	</div>

</form>

<div class="alert alert-block alert-success" data-bind="visible: registered()">
  <h4 class="blue">Pendaftaran Peneliti Berhasil</h4>
</div>

<?php } else { ?>
<div class="alert alert-block alert-warning">
  <button type="button" class="close" data-dismiss="alert">
    <i class="ace-icon fa fa-times"></i>
  </button>
  <i class="ace-icon fa fa-exclamation-triangle yellow"></i>
  KEPK belum aktif
</div>
<?php } ?>