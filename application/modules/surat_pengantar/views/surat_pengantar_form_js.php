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
    	  $(".select2").select2({
        	placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });

        $('.date-picker').datepicker({
          autoclose: true,
          todayHighlight: true,
          language: 'id'
        })
        //show datepicker when clicking on the icon
        .next().on(ace.click_event, function(){
          $(this).prev().focus();
        });
    	});

      function rawurlencode (str)
      {
        str = (str+'').toString();
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
      }

      function getNewid()
    	{
    	  return 'new_' + parseFloat((new Date().getTime() + '').slice(7))+ Math.round(Math.random() * 100);
    	}

    	var SuratPengantarModel = function(){
    		var self = this;
    		self.id = ko.observable(<?php echo isset($data['id_sp']) ? htmlentities($data['id_sp'], ENT_QUOTES) : 0 ?>);
    		self.id_pengajuan = ko.observable(<?php echo isset($data['id_pengajuan']) ? htmlentities($data['id_pengajuan'], ENT_QUOTES) : 0 ?>);
        self.nomor = ko.observable('<?php echo isset($data['nomor']) ? htmlentities($data['nomor'], ENT_QUOTES) : "" ?>');
    		self.tanggal = ko.observable('<?php echo isset($data['tanggal']) ? htmlentities(date('d/m/Y', strtotime($data['tanggal'])), ENT_QUOTES) : "" ?>');
        self.link_gdrive = ko.observable('<?php echo isset($data['link_gdrive']) ? htmlentities($data['link_gdrive'], ENT_QUOTES) : "" ?>');
    		self.processing = ko.observable(false);
    	}

    	var App = new SuratPengantarModel();

      App.showFile = function(path){
        sp = path.split('/');
        file_name = sp[1];
        $.ajax({
          url: '<?php echo base_url()?>surat_pengantar/cek_file_exist/'+file_name,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            if (res.isSuccess)
            {
              $('#myModal').modal('show');
              html = '<embed width="100%" height="500px" src="<?php echo base_url()?>'+path+'">';
              $('#show_data_modal').html(html);
            }
            else
            {
              $('#myModal').modal('show');
              html = '<div class="alert alert-block alert-danger"><button class="close" type="button" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>File tidak ditemukan</div>';
              $('#show_data_modal').html(html);          
            }
          }
        });
      };

      App.downloadFile = function(file_name, client_name){
        $.ajax({
          url: '<?php echo base_url()?>surat_pengantar/cek_file_exist/'+file_name,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            if (res.isSuccess)
            {
              window.location.href = '<?php echo base_url()?>surat_pengantar/download/'+rawurlencode(file_name)+'/'+rawurlencode(client_name);
            }
            else
              show_error(true, 'File tidak ditemukan');
          }
        });
      }

      App.back = function(){
    		window.location.href = '<?php echo base_url()?>surat_pengantar/';
    	}

    	App.save = function(createNew){
    	  var data = JSON.parse(ko.toJSON(App));
    	  var $btn = $('#submit');

    	  $btn.button('loading');
    	  App.processing(true);
    	  $.ajax({
    	    url: '<?php echo base_url()?>surat_pengantar/proses',
    	    type: 'post',
    	    cache: false,
    	    dataType: 'json',
    	    data: data,
    	    success: function(res, xhr){
    	      if (res.isSuccess){
    	      	show_success(true, res.message);
    	      }
    	      else show_error(true, res.message);

    	      $btn.button('reset');
    	      App.processing(false);
    	    }
    	  });

    	}

    	ko.applyBindings(App);
    </script>
