<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>
<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
<script type="text/javascript">
	jQuery(function($) {

	});

<?php if (isset($isset_kepk) && $isset_kepk == 1) { ?>
	var RegPengusulModel = function(){
		var self = this;
		self.id = ko.observable(0);
    self.no_anggota = ko.observable('');
    self.nama = ko.observable("");
    self.nik = ko.observable("");
    self.tempat_lahir = ko.observable("");
    self.tgl_lahir = ko.observable("");
    self.kewarganegaraan = ko.observable("");
    self.negara = ko.observable("");
    self.alamat = ko.observable("");
    self.jalan = ko.observable("");
    self.no_rumah = ko.observable("");
    self.rt = ko.observable("");
    self.rw = ko.observable("");
    self.propinsi = ko.observable("");
    self.kabupaten = ko.observable("");
    self.kecamatan = ko.observable("");
    self.kode_pos = ko.observable("");
    self.email = ko.observable("");
    self.no_telp = ko.observable("");
    self.no_hp = ko.observable("");
    self.dokumen = ko.observableArray([]);
    self.processing = ko.observable(false);
		self.registered = ko.observable(false);
		self.username = ko.observable('');
		self.password = ko.observable('');
    self.kepk_asal = ko.observable('');
    self.url_kepk_lain = ko.observable('');
	}

	var App = new RegPengusulModel();

  App.tampilkan_data_peneliti = function(){
    App.get_peneliti();
  }

  App.get_peneliti = function(){
    const nik = App.nik();
    const email = App.email();
    const url_kepk_lain = App.url_kepk_lain();

    if (nik.trim() == "")
      show_error(true, 'Nik harus diisi');
    else if (email.trim() == "")
      show_error(true, 'Email harus diisi');
    else if (url_kepk_lain.trim() == "")
      show_error(true, 'Alamat URL KEPK Asal harus diisi');
    else
    {
      $('#frm').append('<div class="message-loading-overlay"><i class="fa-spin ace-icon fa fa-spinner orange2 bigger-160"></i></div>');
      $('#search_peneliti').button('loading');
      $.ajax({
        url: '<?php echo base_url()?>reg_pengusul/get_peneliti_from_kepk_lain/',
        type: 'post',
        cache: false,
        dataType: 'json',
        data: {'nik': nik, 'email': email, 'url_kepk_lain': url_kepk_lain},
        success: function(res, xhr){
          if (res.isSuccess){
            var data = res.data;
            App.no_anggota(data.nomor);
            App.nama(data.nama);
            App.nik(data.nik);
            App.tempat_lahir(data.tempat_lahir);
            App.tgl_lahir(data.tgl_lahir);
            App.kewarganegaraan(data.kewarganegaraan);
            App.negara(data.id_country);
            App.alamat(data.alamat);
            App.jalan(data.jalan);
            App.no_rumah(data.no_rumah);
            App.rt(data.rt);
            App.rw(data.rw);
            App.propinsi(data.kode_propinsi);
            App.kabupaten(data.kode_kabupaten);
            App.kecamatan(data.kode_kecamatan);
            App.kode_pos(data.kode_pos);
            App.email(data.email);
            App.no_telp(data.no_telepon);
            App.no_hp(data.no_hp);
            App.username(data.username);
            App.password(data.password);
            App.kepk_asal(data.nama_kepk);
          }
          else show_error(true, res.message);

          $('#search_peneliti').button('reset');
          $('#frm').find('.message-loading-overlay').remove();
        }
      });
    }
  }

	App.save = function(createNew){
	  var data = JSON.parse(ko.toJSON(App));
	  var $btn = $('#submit');

	  $btn.button('loading');
	  App.processing(true);
	  $.ajax({
	    url: '<?php echo base_url()?>reg_pengusul/proses/2',
	    type: 'post',
	    cache: false,
	    dataType: 'json',
	    data: data,
	    success: function(res, xhr){
	      if (res.isSuccess)
	        App.registered(true);
	      else
          show_error(true, res.message);

	      $btn.button('reset');
	      App.processing(false);
	    }
	  });

	}

  App.back = function(){
    window.location.href = '<?php echo base_url()?>reg_pengusul/';
  }

	ko.applyBindings(App);
<?php } ?>
</script>
