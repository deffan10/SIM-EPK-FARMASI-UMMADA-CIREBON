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
		self.reg1 = ko.observable('');
    self.reg2 = ko.observable('');
	}

	var App = new RegPengusulModel();

  App.form1 = function(){
    window.location.href = '<?php echo base_url()?>reg_pengusul/form1/';
  }

  App.form2 = function(){
    window.location.href = '<?php echo base_url()?>reg_pengusul/form2/';
  }

  App.form3 = function(){
    window.location.href = '<?php echo base_url()?>reg_pengusul/form3/';
  }

  ko.applyBindings(App);
<?php } ?>
</script>
