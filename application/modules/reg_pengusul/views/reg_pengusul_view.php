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
  <div class="col-sm-12">
    <p>Apakah pernah mendaftar peneliti di SIM EPK KEPPKN (<a href="https://sim-epk-keppkn.kemkes.go.id" target="_blank">https://sim-epk-keppkn.kemkes.go.id</a>)?</p>
    <div class="radio">
      <label>
        <input name="reg1" type="radio" class="ace" value="ya" data-bind="checked: reg1" />
        <span class="lbl"> Ya</span>
      </label>
    </div>
    <div class="radio">
      <label>
        <input name="reg1" type="radio" class="ace" value="belum" data-bind="checked: reg1" />
        <span class="lbl"> Belum</span>
      </label>
    </div>
    <button type="button" data-bind="visible: reg1() == 'ya', click: form1">Lanjut</button>
  </div>
  <div class="col-sm-12" data-bind="visible: reg1() == 'belum'">
    <p>Apakah pernah mendaftar peneliti di SIM EPK KEPK lain?</p>
    <div class="radio">
      <label>
        <input name="reg2" type="radio" class="ace" value="ya" data-bind="checked: reg2" />
        <span class="lbl"> Ya</span>
      </label>
    </div>
    <div class="radio">
      <label>
        <input name="reg2" type="radio" class="ace" value="belum" data-bind="checked: reg2" />
        <span class="lbl"> Belum</span>
      </label>
    </div>
    <button type="button" data-bind="visible: reg2() == 'ya', click: form2">Lanjut</button>
    <button type="button" data-bind="visible: reg2() == 'belum', click: form3">Lanjut</button>
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