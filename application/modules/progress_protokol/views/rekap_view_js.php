<script type="text/javascript">
  jQuery(function($) {
    $('#form-rekap').on('submit', function() {
      var btn = $(this).find('button[type="submit"]');
      btn.button('loading');
    });
  });
</script>
