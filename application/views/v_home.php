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

<style>
  .manual-links a {
    display: inline-block;
    max-width: 100%;
    white-space: normal;
    word-break: break-word;
    line-height: 1.4;
  }
</style>

<div class="row" style="margin-top: 30px;">
  <!-- Kolom Kiri: Konten -->
  <div class="col-sm-6">
    <h2>Selamat Datang di Aplikasi SIM-EPK KEPPKN</h2>
    <p>
      Aplikasi dirancang untuk kemudahan penggunaan dalam pengajuan etik penelitian kesehatan oleh Peneliti ke KEPK secara online sistem,<br>
      serta proses telaah etik secara online sistem.
    </p>

    <h4>Kemudahan Pengunaan</h4>
    <p>User pada aplikasi ini dikelompokkan antara lain:</p>
    <ul class="list-unstyled spaced">
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> Peneliti (pengusul protokol etik penelitian kesehatan)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> KEPK (manajemen team Penelaah KEPK)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> Penelaah (penelaah protokol etik yang diusulkan oleh peneliti berdasarkan 7 standar CIOMS)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> KEPPKN melakukan monitoring terhadap proses telaah etik KEPK.</li>
    </ul>

    <h3>Petunjuk Manual unduh di bawah ini:</h3>
    <ul class="list-unstyled spaced manual-links">
      <li><a href="<?php echo base_url()?>home/download/Manual_48_Protokol.docx/<?php echo rawurlencode('Manual_48_Protokol.docx') ?>">Manual 48 Protokol</a></li>
      <li><a href="<?php echo base_url()?>home/download/Check_List_7_Standar_dan_Indikator.pdf/<?php echo rawurlencode('Check_List_7_Standar_dan_Indikator.pdf') ?>">Check List 7 Standar dan Indikator</a></li>
      <li><a href="<?php echo base_url()?>home/download/Formulir_Informed_Consent_WHO.pdf/<?php echo rawurlencode('Formulir_Informed_Consent_WHO.pdf') ?>">Formulir Informed Consent WHO</a></li>
      <li><a href="<?php echo base_url()?>home/download/INFORM_CONSENT_35_BUTIR.docx/<?php echo rawurlencode('INFORM_CONSENT_35_BUTIR.docx') ?>">Formulir Informed Consent 35 Butir</a></li>
      <li><a href="<?php echo base_url()?>home/download/<?php echo rawurlencode('Manual Registrasi Peneliti SIM-EPK v202501.pdf') ?>/<?php echo rawurlencode('Manual Registrasi Peneliti SIM-EPK v202501.pdf') ?>">Manual Registrasi Peneliti SIM-EPK v202501</a></li>
    </ul>
    <h3><i class="ace-icon fa fa-phone bigger-120"></i> Chat Kesekretariatan</h3>
      <div class="alert alert-info" style="border-left: 4px solid #0066cc; margin-top: 15px;">
        <strong>Kesekretariatan KEPK / KEPPKN</strong><br>
        <i class="ace-icon fa fa-phone"></i> <strong>Whatsapp (Hanya Chat):</strong> <span style="color: #0066cc; font-size: 16px; font-weight: bold;">0877-2898-7474</span><br>
        <span style="font-size: 12px; color: #555;">Siap membantu Anda dalam proses pengajuan etik penelitian kesehatan</span>
      </div>
  </div>

  <!-- Kolom Kanan: Alur Pengajuan Gambar -->
  <div class="col-sm-6">
    <h3>Alur Pengajuan Etik Penelitian Kesehatan</h3>
    <div style="background-color: #f5f5f5; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center;">
      <img src="<?php echo base_url()?>assets/images/alur.png" alt="Alur Pengajuan Etik" style="max-width: 100%; height: auto; border: 1px solid #ddd; border-radius: 5px;">
    </div>
  </div>
</div>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/6287728987474?text=Halo%2C%20saya%20ingin%20berkonsultasi%20tentang%20pengajuan%20etik%20penelitian%20kesehatan" target="_blank" style="
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 60px;
  height: 60px;
  background-color: #25d366;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  z-index: 999;
  text-decoration: none;
  transition: all 0.3s ease;
" onmouseover="this.style.backgroundColor='#1fae4f'; this.style.transform='scale(1.1)'" onmouseout="this.style.backgroundColor='#25d366'; this.style.transform='scale(1)'" title="Chat WhatsApp">
  <i class="fa fa-whatsapp" style="font-size: 32px; color: white;"></i>
</a>

<!-- Tooltip WhatsApp -->
<div style="
  position: fixed;
  bottom: 100px;
  right: 30px;
  background-color: #333;
  color: white;
  padding: 10px 15px;
  border-radius: 5px;
  font-size: 12px;
  white-space: nowrap;
  z-index: 999;
  pointer-events: none;
">
  Kesekretariatan: 0877-2898-7474
</div>



