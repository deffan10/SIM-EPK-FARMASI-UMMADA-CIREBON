<!-- page specific plugin scripts -->
<script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url()?>assets/js/app.js"></script>
<script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url()?>assets/js/bootstrap-datepicker.id.js"></script>
<script src="<?php echo base_url()?>assets/js/select2.min.js"></script>
<script src="<?php echo base_url()?>assets/js/id.js"></script>
<script type="text/javascript">
	jQuery(function($) {
    $('.date-picker').datepicker({
      autoclose: true,
      todayHighlight: true,
      language: 'id'
    })
    //show datepicker when clicking on the icon
    .next().on(ace.click_event, function(){
      $(this).prev().focus();
    });
    
    $(".select2").select2({
      placeholder: "Pilih...",
      language: "id",
      allowClear: true
    });

    $('#propinsi').on('select2:select', function(e){
      App.get_opt_kabupaten();
    })

    $('#kabupaten').on('select2:select', function(e){
      App.get_opt_kecamatan();
    })

    $('.toggle-password1').click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $('#password');
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });

    $('.toggle-password2').click(function() {
      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $('#confirm_password');
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
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
    self.processing = ko.observable(false);
		self.registered = ko.observable(false);
		self.username = ko.pureComputed(function() {
      return self.nik();
    }, this);
		self.password = ko.observable('');
		self.passconf = ko.observable('');
	}

	var App = new RegPengusulModel();

  App.get_opt_kabupaten = function(){
    var prop = $('#propinsi').val();

    $('#kabupaten').empty();
    $.ajax({
      url: '<?php echo base_url()?>reg_pengusul/get_opt_kabupaten_by_kd_prop/'+prop,
      type: 'post',
      cache: false,
      dataType: 'json',
      success: function(res, xhr){
        if (res.length > 0)
        {
          $.each(res, function(i, item){
            var newOption = new Option(item.nama, item.kode, false, false);
            $('#kabupaten').append(newOption).trigger('change');
          })
        }
        $('#kabupaten').val("").trigger("change");
        App.kabupaten("");
        App.get_opt_kecamatan();
      }       
    })
  }

  App.get_opt_kecamatan = function(){
    var kab = $('#kabupaten').val();

    $('#kecamatan').empty();
    $.ajax({
      url: '<?php echo base_url()?>reg_pengusul/get_opt_kecamatan_by_kd_kab/'+kab,
      type: 'post',
      cache: false,
      dataType: 'json',
      success: function(res, xhr){
        if (res.length > 0)
        {
          $.each(res, function(i, item){
            var newOption = new Option(item.nama, item.kode, false, false);
            $('#kecamatan').append(newOption).trigger('change');
          })
        }
        $('#kecamatan').val("").trigger("change");
        App.kecamatan("");
      }       
    })
  }
  
	App.save = function(createNew){
	  var data = JSON.parse(ko.toJSON(App));
	  var $btn = $('#submit');

	  $btn.button('loading');
	  App.processing(true);
	  $.ajax({
	    url: '<?php echo base_url()?>reg_pengusul/proses/3',
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
