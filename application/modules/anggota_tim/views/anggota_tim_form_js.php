    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url()?>assets/js/spinbox.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/jquery.gritter.min.js"></script>
    <script src="<?php echo base_url()?>assets/js/app.js"></script>
    <script src="<?php echo base_url()?>assets/js/knockout-3.4.2.js"></script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
      jQuery(function($) {

      });

      function rawurlencode (str) {
        str = (str+'').toString();        
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A');
      }

      var AnggotaTim = function(){
        var self = this;
        self.id = ko.observable(<?php echo isset($data['id_atk']) ? $data['id_atk'] : 0 ?>);
        self.nomor = ko.observable("<?php echo isset($data['nomor']) ? $data['nomor'] : '' ?>");
        self.nama = ko.observable("<?php echo isset($data['nama']) ? $data['nama'] : '' ?>");
        self.nik = ko.observable("<?php echo isset($data['nik']) ? $data['nik'] : '' ?>");
        self.email = ko.observable("<?php echo isset($data['email']) ? $data['email'] : '' ?>");
        self.no_telp = ko.observable("<?php echo isset($data['no_telepon']) ? $data['no_telepon'] : '' ?>");
        self.no_hp = ko.observable("<?php echo isset($data['no_hp']) ? $data['no_hp'] : '' ?>");
        self.no_sertifikat = ko.observable("<?php echo isset($data['no_sertifikat_ed_edl']) ? $data['no_sertifikat_ed_edl'] : '' ?>");
        self.client_name_sertifikat = "<?php echo isset($data['client_name_sertifikat']) ? $data['client_name_sertifikat'] : '' ?>";
        self.file_name_sertifikat = "<?php echo isset($data['file_name_sertifikat']) ? $data['file_name_sertifikat'] : '' ?>";
        self.link_gdrive = ko.observable("<?php echo isset($data['link_gdrive_sertifikat']) ? $data['link_gdrive_sertifikat'] : '' ?>");
        self.processing = ko.observable(false);
      }

      var App = new AnggotaTim();

      App.showFile = function(path){
        if (path.substring(path.lastIndexOf('/') + 1) == "")
          show_error(true, 'File tidak ada');
        else
        {
          $.ajax({
            url:'<?php echo base_url()?>'+path,
            type:'GET',
            error: function() {
              show_error(true, 'File tidak ditemukan');
            },
            success: function(data) {
              $('#myModal').modal('show');
              html = '<embed width="100%" height="500px" src="<?php echo base_url()?>'+path+'">';
              $('#show_data_modal').html(html);
            }
          });
        }
      };

      App.downloadFile = function(file_name, client_name){
        if (file_name.trim() != "" && client_name.trim() !== "")
        {
          $.ajax({
            url:'<?php echo base_url()?>uploads/'+file_name,
            type:'GET',
            error: function() {
              show_error(true, 'File tidak ditemukan');
            },
            success: function(data) {
              window.location.href = '<?php echo base_url()?>anggota_tim/download/'+rawurlencode(file_name)+'/'+rawurlencode(client_name);
            }
          });
        }
        else
          show_error(true, 'File tidak ada');
      }

      App.back = function(){
        window.location.href = '<?php echo base_url()?>anggota_tim/';
      }

      App.save = function(createNew){
        var data = JSON.parse(ko.toJSON(App));
        var $btn = $('#submit');

        $btn.button('loading');
        App.processing(true);
        $.ajax({
          url: '<?php echo base_url()?>anggota_tim/proses',
          type: 'post',
          cache: false,
          dataType: 'json',
          data: data,
          success: function(res, xhr){
            if (res.isSuccess){
              show_success(true, res.message);
              App.id(res.id);
              App.nomor(res.nomor);
            }
            else show_error(true, res.message);

            $btn.button('reset');
            App.processing(false);
          }
        });
      }

      ko.applyBindings(App);
    </script>
