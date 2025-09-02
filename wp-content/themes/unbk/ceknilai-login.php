	<?php include(__DIR__ . '/indb.php') ?>
	<script type="text/javascript">
	  jQuery(document).ready(function($) {
	    $('#nama_siswa').text(localStorage.getItem("siswa.username"));
	    var nama_siswa2 = localStorage.getItem("siswa.namasiswa");
	    nama_siswa2 = nama_siswa2.replace(/'/g, '');

	    $('#nama_siswa2').text(localStorage.getItem("siswa.namasiswa"));

	    $('#mapel').val(localStorage.getItem("mapel.kode"));
	    $('#userid').text(localStorage.getItem("siswa.username"));

	    $('#objnama').html(localStorage.getItem("mapel.nama"));
	    $('#objtanggal').html(localStorage.getItem("mapel.tanggal"));
	    $('#objwaktu').html(localStorage.getItem("mapel.waktu"));
	    $('#objalokasi').html(localStorage.getItem("mapel.alokasi"));

	    $('#nilai').show();
	  });
	</script>
	<div id='notif'>
	  <div class='container'>
	    <div class='row'>
	      <div class='col-md-12'>
	      </div>
	    </div>
	  </div>
	</div>
	<div class='container'>
	  <div class='row'>
	    <div style='height:30px;'></div>
	  </div>
	  <div class='row'>
	    <div class='col-md-12'>
	      <div id='loginbox' class='konfirm konfirm3'>
	        <form action='../' method=POST>
	          <div id='logintitle'>
	            <p>Konfirmasi Tes</p>
	          </div>
	          <div id='loginbody'>
	            <input type="hidden" id="mapel">
	            Terima Kasih Telah Berpartisipasi Dalam Tes ini, <br>
	            Silakan klik tombol LOGOUT untuk mengakhiri <br>
	            test
	            <?php if ($opt_shownilai) : ?>
	              <div id='nilai' style='text-align:center;font-size:50px; font-weight:bold;margin-top:20px;display:none'>
	                <span id='lihatnilai' class="" style='cursor:pointer;font-size:20px;'>LIHAT NILAI</span>
	              </div>
	            <?php endif; ?>
	          </div>
	          <div id='loginfooter'>
	            <input type='submit' value='LOGOUT' />
	            <div class='clear'></div>
	          </div>
	        </form>
	      </div>
	    </div>
	  </div>
	</div>
	<script>
	  $(document).ready(function() {
	    $('#lihatnilai').click(function() {
	      $.post(localStorage.getItem("themedir2") + '/nilai.php', {
	          userid: $('#userid').text(),
	          mapel: "ALL"
	        },
	        function(s) {
	          $('#nilai').html(s);
	        }
	      )
	    })
	  })
	</script>