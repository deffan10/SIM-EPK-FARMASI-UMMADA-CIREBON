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

<div class="col-sm-12">
  <h2>Selamat Datang di Aplikasi SIM-EPK KEPPKN</h2>
  <p>Aplikasi di rancang untuk kemudahan penggunaan dalam pengajuan etik penelitian kesehatan oleh Peneliti ke KEPK secara online sistem, dan proses telaah etik secara online sistem.</p>

  <h4>Kemudahan Pengunaan</h4>
  <p>User pada aplikasi ini dikelompokkan antara lain:
    <ul class="list-unstyled spaced">
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> Peneliti (pengusul protokol etik penelitian kesehatan)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> KEPK (manajemen team Penelaah KEPK)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> Penelaah (penelaah protokol etik yang diusulkan oleh peneliti berdasarkan 7 standar CIOMS)</li>
      <li><i class="ace-icon fa fa-check bigger-110 green"></i> KEPPKN melakukan monitoring terhadap proses telaah etik KEPK.</li>
    </ul>
  </p>

  <h3>Alur Pengajuan Etik Penelitian Kesehatan</h3>
  <div style="background-color: #f5f5f5; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
    <svg viewBox="0 0 1200 600" style="width: 100%; height: auto;">
      <!-- Start: Protokol Diajukan -->
      <ellipse cx="150" cy="300" rx="70" ry="40" fill="#90EE90" stroke="black" stroke-width="2"/>
      <text x="150" y="300" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">
        <tspan x="150" dy="0">Protokol</tspan>
        <tspan x="150" dy="15">Diajukan</tspan>
      </text>

      <!-- Arrow -->
      <line x1="220" y1="300" x2="300" y2="300" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>

      <!-- Process: Diversifikasi TIM KEPK -->
      <rect x="300" y="270" width="150" height="60" fill="#ADD8E6" stroke="black" stroke-width="2" rx="5"/>
      <text x="375" y="300" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">
        <tspan x="375" dy="0">Diversifikasi</tspan>
        <tspan x="375" dy="15">TIM KEPK STFMC</tspan>
      </text>

      <!-- Arrow -->
      <line x1="450" y1="300" x2="530" y2="300" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>

      <!-- Decision: Layak Etik? -->
      <polygon points="600,300 670,260 740,300 670,340" fill="#DDA0DD" stroke="black" stroke-width="2"/>
      <text x="670" y="303" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">
        <tspan x="670" dy="0">Apakah</tspan>
        <tspan x="670" dy="15">Layak Etik?</tspan>
      </text>

      <!-- Arrow Disetujui (down) -->
      <line x1="670" y1="340" x2="670" y2="420" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <text x="685" y="380" font-size="11" font-weight="bold" fill="green">Disetujui</text>

      <!-- Result: Exempted -->
      <rect x="600" y="420" width="140" height="50" fill="#FFD700" stroke="black" stroke-width="2" rx="5"/>
      <text x="670" y="448" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">Exempted</text>
      <text x="670" y="463" text-anchor="middle" dominant-baseline="middle" font-size="10">(Layak Etik)</text>

      <!-- Arrow Ditolak (up-right) -->
      <line x1="740" y1="300" x2="900" y2="250" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <text x="810" y="270" font-size="11" font-weight="bold" fill="red">Ditolak</text>

      <!-- Result: Tidak Dapat Ditelaah -->
      <rect x="850" y="220" width="140" height="50" fill="#FFB6C6" stroke="black" stroke-width="2" rx="5"/>
      <text x="920" y="248" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">Tidak Dapat</text>
      <text x="920" y="263" text-anchor="middle" dominant-baseline="middle" font-size="11">Ditelaah</text>

      <!-- Arrow Revisi (right) -->
      <line x1="740" y1="300" x2="820" y2="300" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <text x="770" y="290" font-size="11" font-weight="bold" fill="orange">Revisi</text>

      <!-- Decision: Tipe Review -->
      <polygon points="890,300 950,270 1010,300 950,330" fill="#87CEEB" stroke="black" stroke-width="2"/>
      <text x="950" y="303" text-anchor="middle" dominant-baseline="middle" font-size="10" font-weight="bold">
        <tspan x="950" dy="0">Expedited?</tspan>
      </text>

      <!-- Arrow Expedited (up) -->
      <line x1="950" y1="270" x2="950" y2="150" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <text x="960" y="210" font-size="10" font-weight="bold" fill="blue">Ya</text>

      <!-- Result: Expedited Review -->
      <rect x="880" y="80" width="140" height="50" fill="#87CEEB" stroke="black" stroke-width="2" rx="5"/>
      <text x="950" y="108" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">Expedited</text>
      <text x="950" y="123" text-anchor="middle" dominant-baseline="middle" font-size="10">(Revisi Protokol)</text>

      <!-- Arrow Full Board (down) -->
      <line x1="950" y1="330" x2="950" y2="420" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <text x="960" y="375" font-size="10" font-weight="bold" fill="blue">Tidak</text>

      <!-- Result: Full Board -->
      <rect x="880" y="420" width="140" height="50" fill="#87CEEB" stroke="black" stroke-width="2" rx="5"/>
      <text x="950" y="448" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">Full Board</text>
      <text x="950" y="463" text-anchor="middle" dominant-baseline="middle" font-size="10">(Telaah Lanjut)</text>

      <!-- Arrow to Final Result -->
      <line x1="670" y1="470" x2="670" y2="520" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <line x1="950" y1="470" x2="950" y2="500" stroke="black" stroke-width="2"/>
      <line x1="950" y1="500" x2="730" y2="500" stroke="black" stroke-width="2" marker-end="url(#arrowhead)"/>
      <line x1="920" y1="270" x2="920" y2="500" stroke="black" stroke-width="2"/>
      <line x1="920" y1="500" x2="730" y2="500" stroke="black" stroke-width="2"/>

      <!-- Final: Selesai -->
      <ellipse cx="670" cy="540" rx="60" ry="35" fill="#B0E0E6" stroke="black" stroke-width="2"/>
      <text x="670" y="545" text-anchor="middle" dominant-baseline="middle" font-size="12" font-weight="bold">Selesai</text>

      <!-- Arrow marker definition -->
      <defs>
        <marker id="arrowhead" markerWidth="10" markerHeight="10" refX="9" refY="3" orient="auto">
          <polygon points="0 0, 10 3, 0 6" fill="black"/>
        </marker>
      </defs>
    </svg>
  </div>

  <h3>Petunjuk Manual unduh di bawah ini:</h3>
  <ul class="list-unstyled spaced">
    <li><a href="<?php echo base_url()?>home/download/Manual_48_Protokol.docx/<?php echo rawurlencode('Manual_48_Protokol.docx') ?>">Manual 48 Protokol</a></li>
    <li><a href="<?php echo base_url()?>home/download/Check_List_7_Standar_dan_Indikator.pdf/<?php echo rawurlencode('Check_List_7_Standar_dan_Indikator.pdf') ?>">Check List 7 Standar dan Indikator</a></li>
    <li><a href="<?php echo base_url()?>home/download/Formulir_Informed_Consent_WHO.pdf/<?php echo rawurlencode('Formulir_Informed_Consent_WHO.pdf') ?>">Formulir Informed Consent WHO</a></li>
    <li><a href="<?php echo base_url()?>home/download/INFORM_CONSENT_35_BUTIR.docx/<?php echo rawurlencode('INFORM_CONSENT_35_BUTIR.docx') ?>">Formulir Informed Consent 35 Butir</a></li>
    <li><a href="<?php echo base_url()?>home/download/<?php echo rawurlencode('Manual Registrasi Peneliti SIM-EPK v202501.pdf') ?>/<?php echo rawurlencode('Manual Registrasi Peneliti SIM-EPK v202501.pdf') ?>">Manual Registrasi Peneliti SIM-EPK v202501</a></li>
  </ul>

  <hr style="margin: 30px 0;">

  <h3><i class="ace-icon fa fa-phone bigger-120"></i> Chat Kesekretariatan</h3>
  <div class="alert alert-info" style="border-left: 4px solid #0066cc; margin-top: 15px;">
    <strong>Kesekretariatan KEPK / KEPPKN</strong><br>
    <i class="ace-icon fa fa-phone"></i> <strong>Whatsapp (Hanya Chat):</strong> <span style="color: #0066cc; font-size: 16px; font-weight: bold;">0877-2898-7474</span><br>
    <span style="font-size: 12px; color: #555;">Siap membantu Anda dalam proses pengajuan etik penelitian kesehatan</span>
  </div>
</div>

