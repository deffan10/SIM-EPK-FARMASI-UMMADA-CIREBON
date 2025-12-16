  	<div class="widget-box">
  		<div class="widget-header">
  		</div>

  		<div class="widget-body">
  			<div class="widget-main">
          <div class="row">
            <div class="col-sm-7">
              <form class="form-horizontal" role="form" id="frm">
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="periode"> Periode </label>
                  <div class="col-sm-6">
                    <div class="input-daterange input-group" data-date-format="dd/mm/yyyy">
                      <input type="text" class="form-control" name="periode_awal" placeholder="Mulai" data-bind="value: periode_awal" />
                      <span class="input-group-addon">
                        <i class="fa fa-exchange"></i>
                      </span>
                      <input type="text" class="form-control" name="periode_akhir" placeholder="Selesai" data-bind="value: periode_akhir" />
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="ketua"> Ketua </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="ketua" data-placeholder="Ketua" data-bind="value: ketua">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="wakil_ketua"> Wakil Ketua </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="wakil_ketua" multiple="true" data-placeholder="Wakil Ketua" data-bind="selectedOptions: wakil_ketua">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="sekretaris"> Sekretaris </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="sekretaris" multiple="true" data-placeholder="Sekretaris" data-bind="selectedOptions: sekretaris">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="kesekretariatan"> Kesekretariatan </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="kesekretariatan" multiple="true" data-placeholder="Kesekretariatan" data-bind="selectedOptions: kesekretariatan">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="penelaah"> Penelaah </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="penelaah" multiple="true" data-placeholder="Penelaah" data-bind="selectedOptions: penelaah">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="lay_person"> Lay Person </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="lay_person" multiple="true" data-placeholder="Lay Person" data-bind="selectedOptions: lay_person">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="konsultan"> Konsultan Independen (opsional) </label>
                  <div class="col-sm-9">
                    <select class="select2 form-control" id="konsultan" multiple="true" data-placeholder="Konsultan Independen" data-bind="selectedOptions: konsultan">
                      <option value=""></option>
                      <?php
                      if (!empty($opt_anggota))
                      {
                        for ($a=0; $a<count($opt_anggota); $a++)
                          echo '<option value="'.$opt_anggota[$a]['id_atk'].'">'.$opt_anggota[$a]['nomor'].' :: '.$opt_anggota[$a]['nama'].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="aktif"> Aktif </label>
                  <div class="col-sm-9">
                    <label class="inline">
                      <input id="aktif" type="checkbox" class="ace ace-switch" data-bind="checked: aktif" />
                      <span class="lbl middle" data-lbl="Ya&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tidak"></span>
                    </label>
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
            </div>

            <div class="col-sm-5">
              <br/><br/>
              <dl class="dl-horizontal">
                <dt style="width: 150px;">Ketua</dt>
                <dd><span data-bind="text: nama_ketua"></span></dd>
                <dt style="width: 150px;">Wakil Ketua</dt>
                <dd>
                  <ol data-bind="foreach: nama_wakil_ketua">
                    <li><span data-bind="text: $data"></span></li>
                  </ol>
                </dd>
                <dt style="width: 150px;">Sekretaris</dt>
                <dd>
                  <ol data-bind="foreach: nama_sekretaris">
                    <li><span data-bind="text: $data"></span></li>
                  </ol>
                </dd>
                <dt style="width: 150px;">Kesekretariatan</dt>
                <dd>
                  <ol data-bind="foreach: nama_sekretariat">
                    <li><span data-bind="text: $data"></span></li>
                  </ol>
                </dd>
                <dt style="width: 150px;">Penelaah</dt>
                <dd>
                  <ol data-bind="foreach: nama_penelaah">
                    <li><span data-bind="text: $data"></span></li>
                  </ol>
                </dd>
                <dt style="width: 150px;">Lay Person</dt>
                <dd>
                  <ol data-bind="foreach: nama_lay_person">
                    <li><span data-bind="text: $data"></span></li>
                  </ol>
                </dd>
                <dt style="width: 150px;">Konsultan Independen</dt>
                <dd>
                  <ol data-bind="foreach: nama_konsultan">
                    <li><span data-bind="text: $data"></span></li>
                  </ol>
                </dd>
              </dl>
            </div>
          </div>
  			</div>
  		</div>
  	</div>

