<?php include('indb.php'); ?>
<?php include('bimadb.php'); ?>
<?php if (isset($_POST['ADMINDEBUG'])) {
?>
  <script>
    localStorage.clear();
    var mapel = "<?php echo $_POST['mapel'] ?>";
    localStorage.setItem('siswa.namasiswa', '__ADMINTESTSOAL__');
    localStorage.setItem('ADMINDEBUG', 1);
    localStorage.setItem('siswa.mapel', mapel);
    var url = `<?php echo $_POST['backend'] ?>wp-json/bimasoft-unbk/v1/uploadsoal/` + mapel;
    $.ajax({
      url: url,
      type: 'GET',
    }).done(function(e) {
      window.location.href = './archives/soalujian---' + mapel;
    }).fail(function(e) {
      console.log(e);
      alert(e);
    });
  </script>
<?php
  exit;
} ?>

<script>
  String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
  };


  jQuery(document).ready(function($) {

    var nama_siswa2 = localStorage.getItem("siswa.namasiswa");
    nama_siswa2 = nama_siswa2.replace("\\'", "'");

    $("#refreshWindow").click(function() {
      window.location.reload();
    })

    if (localStorage.getItem("data.finish") == 1) {
      alert('Anda sudah selesai mengerjakan test ini');
      window.location = '<?php echo $home_url ?>';
      exit();
    }

    $('#nama_siswa').text(localStorage.getItem("siswa.username"));
    $('#nama_siswa2').text(nama_siswa2);
    $('#localstorage').val(localStorage.getItem("data.localstorage"));

    $('#mapel').val(localStorage.getItem("siswa.mapel"));
    $('#userid').text(localStorage.getItem("siswa.username"));
    $('#kodetest').val(localStorage.getItem("siswa.mapel"));

    $.ajax({
      url: '<?php echo get_stylesheet_directory_uri() ?>/images/foto/' + localStorage.getItem("siswa.username") + '.jpg',
      type: 'HEAD',
      error: function() {
        console.log("Foto tidak ditemukan. Menggunakan Avatar Default");
        $('#avatar img').prop({
          src: '<?php echo get_stylesheet_directory_uri() ?>/images/avatar.png'
        });
      },
      success: function() {
        $('#avatar img').prop({
          src: '<?php echo get_stylesheet_directory_uri() ?>/images/foto/' + localStorage.getItem("siswa.username") + '.jpg'
        });
      }
    });

    //LOAD SOAL JS PHP

    var mapel = localStorage.getItem("siswa.mapel");
    mapel = mapel.replaceAll(' ', '%20');

    var soaljsphp = "<?php echo get_stylesheet_directory_uri() ?>/js/soal.js.php?bv=13.10.3&shuffle=" + localStorage.getItem("mapel.shuffle") + "&mapel_dikerjakan=" + localStorage.getItem("mapel.dikerjakan") + "&alokasi=" + localStorage.getItem("mapel.alokasi") + "&waktu=" + localStorage.getItem("mapel.waktu") + "&namasiswa=" + localStorage.getItem("siswa.namasiswa").replaceAll(" ", "%20") + "&siswa=" + localStorage.getItem("siswa.username") + "&mapel=" + mapel + "&kodetest=" + localStorage.getItem("siswa.mapel").replaceAll(" ", "%20") + "&_=" + Date.now();

    var soaljsphp2 = "<?php echo get_stylesheet_directory_uri() ?>/archives/js/script.js?bv=13.10.3";
    var soaljsphp0 = "<?php echo get_stylesheet_directory_uri() ?>/archives/js/soal.js?bv=13.10.3";

    $.ajaxSetup({
      cache: true
    });

    console.log('Script 0 Loading : ' + soaljsphp0);
    console.log('Script 1 Loading : ' + soaljsphp);
    console.log('Script 2 Loading : ' + soaljsphp2);

    $.getScript(soaljsphp0, function() {
      console.log('Script 0 Loaded : ' + soaljsphp0);
      $.getScript(soaljsphp, function() {
        console.log('Script 1 Loaded : ' + soaljsphp);
        $.getScript(soaljsphp2, function() {
          console.log('Script 2 Loaded : ' + soaljsphp2);
        })
      });
    })

    $('body').addClass('logged-in');
    $('body').addClass('soal-in');
  });
</script>

<div class="modal" id="yakin-modal">
  <div class="modal-dialog" role="document" style="margin: 120px auto; width:450px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel" style="font-weight:normal">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <span style="font-size:50px; position: absolute; top: 10px;" class="glyphicon glyphicon-warning-sign nomobile" aria-hidden="true"></span>
        <p style="padding-left : 70px" class="nomobile">Anda masih memiliki waktu untuk mata uji ini <br><br> Apakah anda yakin ingin mengakhiri mata uji ini ?</p>

        <table style="width:100%">
          <tbody>
            <tr>
              <td style="text-align:right"><input type="checkbox" id="yakin"></td>
              <td style="text-align:center; width: 350px;"><span class="red">CENTANG</span>, kemudian tekan tombol selesai. <br>Anda tidak akan bisa kembali ke soal<br>jika sudah menekan tombol selesai</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer" style="text-align:center">
        <button type="button" disabled="disabled" id="selesai" class="btn btn-default" data-dismiss="modal" style="width:45%">SELESAI</button>
        <button type="button" class="btn btn-danger close-modal" style="width:45%">TIDAK</button>
      </div>
    </div>
  </div>
</div>


<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div id="soal">
        <div id="soal-head">
          <div id="nomor">
            SOAL NOMOR <span>1</span>
          </div>
          <div id="summary-button" class="">
            <button type="button" data-toggle="modal" data-target="#myModal2" class="btn btn-danger">Daftar Soal &nbsp;&nbsp;<span class="glyphicon glyphicon-th" aria-hidden="true"></span></button>

            <!-- Modal -->
            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style='font-weight:normal'>Nomor Soal</h4>
                  </div>
                  <div class="modal-body">
                    <div id="summary">
                    </div>
                    <div style='clear:both'></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div id="waktu">
            <span>Sisa Waktu</span>
            <span class="sisa" id="countdown">02:00:00</span>
          </div>
          <div class="clear"></div>
        </div>
        <div id="font-size">
          Ukuran Soal : <span class="a1">A</span><span class="a2">A</span><span class="a3">A</span>
        </div>
        <div id="error-msg" style="margin:25px">
        </div>
        <div id="soal-body">
          <?php

          $kodemapel = substr($absolute_url, 12 + strpos($absolute_url, 'soalujian---'));
          $kodemapel = str_ireplace('%20', ' ', $kodemapel);
          $mapel = $kodemapel;
          $args = array(
            'title' => $mapel,
            'order' => 'DESC',
            'orderby' => 'modified date'
          );
          query_posts($args);
          ?>
          <?php if (have_posts()) : ?>
            <?php the_post(); ?>
            <?php the_content(); ?>
          <?php endif; ?>
        </div>
        <div id="soal-foot">
          <table width="100%">
            <tbody>
              <tr>
                <!-- <td align="left"><button type="button" id="refresh" class="btn btn-info"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Refresh</button></td> -->
                <td align="left"><button type="button" id="prev-soal" class="btn btn-primary"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>&nbsp;&nbsp;Soal Sebelumnya</button></td>
                <td align="center"><button type="button" class="btn btn-warning ragu"><span class="glyphicon glyphicon-unchecked ragu-1 ragu-check" aria-hidden="true"></span>&nbsp;&nbsp;Ragu Ragu</button></td>
                <td align="right"><button type="button" id="next-soal" class="btn btn-primary">Soal Selanjutnya&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></button></td>
                <td align="right"><button style="display:none" type="button" data-toggle="modal" data-target="#myModal" id="last-soal" class="btn btn-success"><span id='kumpultext'>Selesai&nbsp;&nbsp;</span><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button></td>
                <td align="center" class="mobileOnly"><button type="button" id="refreshWindow" class="btn btn-warning">Refresh</button></td>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
</div>

<div id="jumlah_soal" style="display:none">1</div>

<?php if ($opt_bolehkumpul == "1") : ?>
<?php else : ?>
  <div class="modal" id='ragu-modal'>
    <div class="modal-dialog" role="document" style='margin: 120px auto'>
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel" style='font-weight:normal'>Konfirmasi</h4>
        </div>
        <div class="modal-body">
          <span style='font-size:50px; position: absolute; top: 10px;' class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
          <p style='padding-left : 70px'>Anda masih ragu - ragu / belum mengisi terhadap beberapa jawaban. Silakan tinjau lagi jawaban anda.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger close-modal" data-dismiss="modal" style='width: 100%'>Ya</button>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="modal" id='yakin-modal'>
  <div class="modal-dialog" role="document" style='margin: 120px auto; width:450px;'>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel" style="font-weight: normal">Konfirmasi</h4>
      </div>
      <div class="modal-body">
        <span style='font-size:50px; position: absolute; top: 10px;' class="glyphicon glyphicon-warning-sign nomobile" aria-hidden="true"></span>
        <p style='padding-left : 70px' class="nomobile">Anda masih memiliki waktu untuk mata uji ini <br /><br /> Apakah anda yakin ingin mengakhiri mata uji ini ?</p>

        <table style='width:100%'>
          <tr>
            <td style='text-align:right'><input type='checkbox' id='yakin' /></td>
            <td style='text-align:center; width: 350px;'><span class='red'>CENTANG</span>, kemudian tekan tombol selesai. <br />Anda tidak akan bisa kembali ke soal<br />jika sudah menekan tombol selesai</td>
          </tr>
        </table>
      </div>
      <div class="modal-footer" style='text-align:center'>
        <button type="button" id='selesai' class="btn btn-default" data-dismiss="modal" style='width:45%'>SELESAI</button>
        <button type="button" class="btn btn-danger close-modal" style='width:45%'>TIDAK</button>
      </div>
    </div>
  </div>
</div>