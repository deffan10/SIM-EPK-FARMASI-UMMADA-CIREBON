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
      var purge_wakil_ketua = [], purge_sekretaris = [], purge_kesekretariatan = [], purge_penelaah = [], purge_lay_person = [], purge_konsultan = [];
    	jQuery(function($) {
    	  $(".select2").select2({
        	placeholder: "Pilih...",
          language: "id",
          allowClear: true
        });

				//or change it into a date range picker
				$('.input-daterange').datepicker({
          autoclose:true,
          todayHighlight: true,
          language: 'id'
        });

        $('#ketua').on('select2:select', function(e){
          var selText = e.params.data.text;
              sp = selText.split(' :: ');

          App.nama_ketua(sp[1])
        }).trigger('change');

        $('#wakil_ketua, #sekretaris, #kesekretariatan, #penelaah, #lay_person, #konsultan').on('select2:select', function(e){
          var ele_id = e.target.id;
              selId = e.params.data.id;
              selText = e.params.data.text;
              sp = selText.split(' :: ');

          switch(ele_id){
            case 'wakil_ketua': 
              if ($.inArray(sp[1], App.nama_wakil_ketua()) < 0)
                App.nama_wakil_ketua.push(sp[1]);
                purge_wakil_ketua = jQuery.grep(purge_wakil_ketua, function(value) {
                  return value != selId;
                });
              break;
            case 'sekretaris': 
              if ($.inArray(sp[1], App.nama_sekretaris()) < 0)
                App.nama_sekretaris.push(sp[1]);
                purge_sekretaris = jQuery.grep(purge_sekretaris, function(value) {
                  return value != selId;
                });
              break;
            case 'kesekretariatan': 
              if ($.inArray(sp[1], App.nama_sekretariat()) < 0)
                App.nama_sekretariat.push(sp[1]);
                purge_kesekretariatan = jQuery.grep(purge_kesekretariatan, function(value) {
                  return value != selId;
                });
              break;
            case 'penelaah': 
              if ($.inArray(sp[1], App.nama_penelaah()) < 0)
                App.nama_penelaah.push(sp[1]);
                purge_penelaah = jQuery.grep(purge_penelaah, function(value) {
                  return value != selId;
                });
              break;
            case 'lay_person': 
              if ($.inArray(sp[1], App.nama_lay_person()) < 0)
                App.nama_lay_person.push(sp[1]);
                purge_lay_person = jQuery.grep(purge_lay_person, function(value) {
                  return value != selId;
                });
              break;
            case 'konsultan': 
              if ($.inArray(sp[1], App.nama_konsultan()) < 0)
                App.nama_konsultan.push(sp[1]);
                purge_konsultan = jQuery.grep(purge_konsultan, function(value) {
                  return value != selId;
                });
              break;
          }
        }).trigger('change');

        $('#wakil_ketua, #sekretaris, #kesekretariatan, #penelaah, #lay_person, #konsultan').on('select2:unselect', function(e){
          var ele_id = e.target.id;
              selId = e.params.data.id;
              selText = e.params.data.text;
              sp = selText.split(' :: ');

          switch(ele_id){
            case 'wakil_ketua': 
                App.nama_wakil_ketua.remove(sp[1]);
                purge_wakil_ketua.push(selId);
              break;
            case 'sekretaris': 
                App.nama_sekretaris.remove(sp[1]);
                purge_sekretaris.push(selId);
              break;
            case 'kesekretariatan': 
                App.nama_sekretariat.remove(sp[1]);
                purge_kesekretariatan.push(selId);
              break;
            case 'penelaah': 
                App.nama_penelaah.remove(sp[1]);
                purge_penelaah.push(selId);
              break;
            case 'lay_person': 
                App.nama_lay_person.remove(sp[1]);
                purge_lay_person.push(selId);
              break;
            case 'konsultan': 
                App.nama_konsultan.remove(sp[1]);
                purge_konsultan.push(selId);
              break;
          }
        }).trigger('change');
    	});

    	var StrukturTimKEPKModel = function(){
        var self = this;
        self.id = ko.observable(<?php echo isset($data['id_tim_kepk']) ? $data['id_tim_kepk'] : 0?>);
        self.periode_awal = ko.observable('<?php echo isset($data['periode_awal']) ? date('d/m/Y', strtotime($data['periode_awal'])) : ''?>');
        self.periode_akhir = ko.observable('<?php echo isset($data['periode_akhir']) ? date('d/m/Y', strtotime($data['periode_akhir'])) : ''?>');
        self.ketua = ko.observable(<?php echo isset($data['ketua']) ? $data['ketua'] : ""?>);
        self.wakil_ketua = ko.observableArray([]);
        self.sekretaris = ko.observableArray([]);
        self.kesekretariatan = ko.observableArray([]);
        self.penelaah = ko.observableArray([]);
        self.lay_person = ko.observableArray([]);
        self.konsultan = ko.observableArray([]);
        self.nama_ketua = ko.observable('');
        self.nama_wakil_ketua = ko.observableArray([]);
        self.nama_sekretaris = ko.observableArray([]);
        self.nama_sekretariat = ko.observableArray([]);
        self.nama_penelaah = ko.observableArray([]);
        self.nama_lay_person = ko.observableArray([]);
        self.nama_konsultan = ko.observableArray([]);
        self.aktif = ko.observable(<?php echo isset($data['aktif']) && $data['aktif'] == 1 ? 'true' : 'false' ?>);
    		self.processing = ko.observable(false);
    	}

    	var App = new StrukturTimKEPKModel();

      App.get_struktur = function(){
        var id = App.id();

        $.ajax({
          url: '<?php echo base_url()?>struktur_tim/get_struktur_by_id/'+id,
          type: 'post',
          cache: false,
          dataType: 'json',
          success: function(res, xhr){
            if (res.length > 0)
            {
              var wakil_ketua = [], sekretaris = [], kesekretariatan = [], penelaah = [], lay_person = [], konsultan = [];
              
              $.each(res, function(i, item){
                if (item.jabatan == 1){
                  $('#ketua').val(item.id_atk).trigger('change');
                  App.nama_ketua(item.nama);
                }
                else if (item.jabatan == 2){
                  wakil_ketua.push(item.id_atk);
                  App.nama_wakil_ketua.push(item.nama);
                }
                else if (item.jabatan == 3){
                  sekretaris.push(item.id_atk);
                  App.nama_sekretaris.push(item.nama);
                }
                else if (item.jabatan == 4){
                  kesekretariatan.push(item.id_atk);
                  App.nama_sekretariat.push(item.nama);
                }
                else if (item.jabatan == 5){
                  penelaah.push(item.id_atk);
                  App.nama_penelaah.push(item.nama);
                }
                else if (item.jabatan == 6){
                  lay_person.push(item.id_atk);
                  App.nama_lay_person.push(item.nama);
                }
                else if (item.jabatan == 7){
                  konsultan.push(item.id_atk);
                  App.nama_konsultan.push(item.nama);
                }
              });

              $('#wakil_ketua').val(wakil_ketua).trigger('change');
              $('#sekretaris').val(sekretaris).trigger('change');
              $('#kesekretariatan').val(kesekretariatan).trigger('change');
              $('#penelaah').val(penelaah).trigger('change');
              $('#lay_person').val(lay_person).trigger('change');
              $('#konsultan').val(konsultan).trigger('change');
            }
          }       
        })
      }

      App.back = function(){
    		window.location.href = '<?php echo base_url()?>struktur_tim/';
    	}

      App.save = function(createNew){
        var data = JSON.parse(ko.toJSON(App));
            data['purge_wakil_ketua'] = purge_wakil_ketua;
            data['purge_sekretaris'] = purge_sekretaris;
            data['purge_kesekretariatan'] = purge_kesekretariatan;
            data['purge_penelaah'] = purge_penelaah;
            data['purge_lay_person'] = purge_lay_person;
            data['purge_konsultan'] = purge_konsultan;
        var $btn = $('#submit');

        $btn.button('loading');
        App.processing(true);
        $.ajax({
          url: '<?php echo base_url()?>struktur_tim/proses',
          type: 'post',
          cache: false,
          dataType: 'json',
          data: data,
          success: function(res, xhr){
            if (res.isSuccess){
              App.id(res.id);
              show_success(true, res.message);

              if (createNew)
                setTimeout(function(){
                  window.location.href = '<?php echo base_url()?>struktur_timkep/form/';
                }, 1000)
            }
            else
              show_error(true, res.message);

            $btn.button('reset');
            App.processing(false);
          }
        });
      }

      ko.applyBindings(App);
      <?php if (isset($data['id_tim_kepk']) && $data['id_tim_kepk'] > 0) { ?>
        App.get_struktur();
      <?php } ?>
    </script>
