<?php require_once(dirname(__FILE__) . '/../bimadb.php'); ?>
<?php header("content-type: application/x-javascript");  ?>

<?php
$mapel = $_GET['mapel'];
$siswa = $_GET['siswa'];
$mapel = str_ireplace('%20', ' ', $mapel);

$kodemapel = $mapel;

$alokasi = $_GET['alokasi'];

function convertToHoursMins($time, $format = '%02d:%02d')
{
  if ($time < 1) {
    return;
  }
  $hours = floor($time / 60);
  $minutes = ($time % 60);
  return sprintf($format, $hours, $minutes);
}

switch ($opt_modetimer) {
  case 'Dynamic':
    $seconds  = $alokasi = (int) $alokasi * 60;
    break;

  case 'Classic':
    $waktumulai = $_GET['waktu']; //15:00
    $secs = convertToHoursMins($alokasi);
    $secs = strtotime($secs) - strtotime("00:00:00");
    $waktuselesai = date("H:i", strtotime($waktumulai) + $secs);
    $waktusekarang = date("H:i");
    $seconds = strtotime($waktuselesai) - strtotime($waktusekarang);
    $classicseconds = $seconds;
    break;

  default:
    # code...
    break;
}
?>

//CountDown
<?php

if ($opt_localstorage == 'realtime') {
  $v11sql = "SELECT * FROM `{$table_prefix}bsfsm_hasil` WHERE `indexkey`='$kodemapel-$siswa'";
  $result = $conn->query($v11sql);

  if ($result->num_rows > 0) {
    // output data of each row
    $hasil = $result->fetch_assoc();
    $time = $hasil['stamp'];
    if ($time == '') {
    } else {

      if ($time == 'NaN:NaN:NaN') {
        $time = "00:00:00";
      }

      if ($time == 'Completed') {
        $time = "00:00:00";
      }

      $time = explode(":", $time);
      $seconds = $time[0] * 3600 + $time[1] * 60 + $time[2];
    }

    if (isset($classicseconds)) {
      $seconds = $classicseconds;
    }
  }
}
?>


<?php if (false) : ?>
  <script>
    <?php endif; ?>

    <?php if ($opt_modetimer == 'Dynamic') : ?>
      if (localStorage.getItem('ls[<?php echo "$kodemapel" ?>,<?php echo "$siswa" ?>,sisawaktu]')) {

        var hms = localStorage.getItem('ls[<?php echo "$kodemapel" ?>,<?php echo "$siswa" ?>,sisawaktu]') * 1;
        if ((typeof hms != 'number') || Number.isNaN(hms)) {
          hms = "999999";
        }
        if (<?php echo $seconds ?> < hms) {
          hms = <?php echo $seconds ?>;
        }
        var upgradeTime = hms;

      } else {
        var upgradeTime = <?php echo $seconds ?>;
      }
    <?php else : ?>
      var upgradeTime = <?php echo $seconds ?>;
    <?php endif; ?>

    var seconds = upgradeTime;
    var countdownTimer = setInterval('timer()', 1000);

    (function($) {


      //jQuery('#summary-button').click();

      WordToWordpress();

      //repopulate answer from database
      <?php

      $v11sql =
        "SELECT *
			FROM `{$table_prefix}bsfsm_jawabanpg`
			WHERE indexkey LIKE '$mapel-$siswa-%' 
			";
      $result = $conn->query($v11sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          $nomor = ltrim(strrchr($row['indexkey'], '-'), "-");
          if (is_numeric($nomor)) {
            (int)$nomor;
          } else {
            error_log($nomor);
          }
          if ($nomor > 0) {
            $ans = $row['opsi'];
      ?>
            jQuery('.option[data-nomor-asli=<?php echo $nomor ?>]').removeClass('checked');

            jQuery('.option[data-nomor-asli=<?php echo $nomor ?>][data-option-asli="<?php echo $ans ?>"]').addClass('checked');

            jQuery('#summary .nomor-asli-<?php echo $nomor ?>').removeClass('not-done');
            jQuery('#summary .nomor-asli-<?php echo $nomor ?>').addClass('done');
            jQuery('#summary .nomor-asli-<?php echo $nomor ?> span').text(jQuery('.option[data-nomor-asli=<?php echo $nomor ?>].checked').text());

            var nomorasli = jQuery('.option[data-nomor-asli=<?php echo $nomor ?>][data-option-asli="<?php echo $ans ?>"]').closest('.soal').attr('data-nomor-asli');
            jQuery('#summary .nomor-asli-' + nomorasli).removeClass('not-done');
            jQuery('#summary .nomor-asli-' + nomorasli).addClass('done');

          <?php
          }
        }
      } else {
      }

      $v11sql =
        "SELECT *
			FROM `{$table_prefix}bsfsm_jawabanessay`
			WHERE indexkey LIKE '$mapel-$siswa-%' 
			";
      $result = $conn->query($v11sql);

      if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
          $nomor = ltrim(strrchr($row['indexkey'], '-'), "-");
          if (is_numeric($nomor)) {
            (int)$nomor;
          } else {
            error_log($nomor);
          }
          if ($nomor > 0) {
            $ans = $row['opsi'];
            $ans = preg_replace("/\r\n|\r|\n/", '\r\n', $ans);
            $ans = str_ireplace('"', "`", $ans);
            $ans = str_ireplace("'", "`", $ans);
          ?>

            jQuery('.soallist[data-nomor-asli=<?php echo $nomor ?>]').val("<?php echo trim($ans) ?>");
            jQuery('textarea[data-nomor-asli=<?php echo $nomor ?>]').val("<?php echo $ans ?>");
            jQuery('#summary .nomor-asli-<?php echo $nomor ?>').removeClass('not-done');
            jQuery('#summary .nomor-asli-<?php echo $nomor ?>').addClass('done');
            jQuery('#summary .nomor-asli-<?php echo $nomor ?> span').text(jQuery('.option[data-nomor-asli=<?php echo $nomor ?>].checked').text());

            jQuery('.option[data-nomor-asli=<?php echo $nomor ?>]').removeClass('checked');
            jQuery('.option[data-nomor-asli=<?php echo $nomor ?>][data-option-asli="<?php echo $ans ?>"]').addClass('checked');

            var nomorasli = jQuery('.option[data-nomor-asli=<?php echo $nomor ?>][data-option-asli="<?php echo $ans ?>"]').closest('.soal').attr('data-nomor-asli');
            jQuery('#summary .nomor-asli-' + nomorasli).removeClass('not-done');
            jQuery('#summary .nomor-asli-' + nomorasli).addClass('done');

      <?php
          }
        }
      } else {
      }
      ?>

      //PERFORMANCE

      console.log('READY');

      jQuery(document).ready(function($) {

        $('#ajax').show();


        if (typeof(Storage) !== "undefined") {

          var daftarSoal = [];

          $('.option').each(function() {
            daftarSoal.push($(this).attr('data-nomor-asli'));
          })

          daftarSoal = daftarSoal.filter(function(item, pos) {
            return daftarSoal.indexOf(item) == pos;
          })

          var mapel = $('#mapel').val();
          var user = $('#userid').text();

          daftarSoal.forEach(function(val, index) {
            nomor_asli = val;
            if (localStorage.getItem("ls[" + mapel + "," + user + "," + nomor_asli + "]") === null) {

              //Jawaban tidak ada, abaikan

            } else {
              //Jawaban ada, input jawaban

              var jawabanini = localStorage.getItem("ls[" + mapel + "," + user + "," + nomor_asli + "]");
              var jawabancheck;

              jawabanini = jawabanini.replace(/['"|;]+/g, '');
              jawabancheck = jawabanini.replace(/\s/g, "");

              if (jawabancheck) {
                jQuery('.option[data-nomor-asli=' + nomor_asli + ']').removeClass('checked');


                jQuery('.option[data-nomor-asli=' + nomor_asli + '][data-option-asli="' + jawabanini + '"]').addClass('checked');

                jQuery('textarea[data-nomor-asli=' + nomor_asli + ']').val(jawabanini);


                jQuery('#summary .nomor-asli-' + nomor_asli + '').removeClass('not-done');
                jQuery('#summary .nomor-asli-' + nomor_asli + '').addClass('done');

                jQuery('#summary .nomor-asli-' + nomor_asli + ' span').text(jQuery('.option[data-nomor-asli=' + nomor_asli + '].checked').text());
              }
            }
          })
        } else {
          alert('Maaf... Browser anda tidak didukung oleh aplikasi dengan metode penyimpanan Performance');
        }
        $('#ajax').hide();
        console.log("Selesai Mengambil Jawaban");

      });

      jQuery(document).ready(function($) {
        jQuery('.essay').prev().remove();
      });


    })(jQuery);

    function WordToWordpress() {
      const kodesoal = localStorage.getItem("mapel.kode");
      // javascript get current url
      const currentURL = window.location.href;
      const kodesoalFromUrl = decodeURIComponent(currentURL.split("soalujian---")[1]);
      // console.log (kodesoalFromUrl);
      // console.log(kodesoal);
      if (kodesoal !== kodesoalFromUrl) return;
      tabletodiv(jQuery('#soal-body>div>table'));
      removeOuterTag(jQuery('#soal-body>div'));
      for (i = 1; i <= 2; i++) {
        removeOuterTag(jQuery('#soal-body>div'));
      }

      //Convert Html ke Class Object
      jumlahsoal = jQuery('div.ex-tr').length / 6;
      console.log(jumlahsoal);


      let errorMSG = "";
      let $ = jQuery;
      if (jumlahsoal % 1 !== 0) {
        $('#error-msg').html("Soal Error. Terdapat Kesalahan Format. Jumlah Soal Terbaca : " + jumlahsoal + "<br/><br/>");
        errorMSG = $('#error-msg').html();
      } else
      if (jumlahsoal === 0) {
        $('#error-msg').html("Soal <span style='font-size:2rem;color:red;font-weight:bold'><?php echo $kodemapel ?></span> Belum di Publish atau sudah di Publish, tapi tidak sama antara kode soal Word dan Excel.<br/></br><img src='./../wp-content/themes/unbk/images/image200.png' />");
        errorMSG = $('#error-msg').html();
      }

      jQuery('#jumlah_soal').text(jumlahsoal);
      var soal = [];
      for (i = 1; i <= jumlahsoal; i++) {
        console.log(i);
        if (jumlahsoal % 1 !== 0) {
          $('#error-msg').html(errorMSG + "Soal Error No : <span style='color:red;font-weight:bold'>" + i + "</span>" + "<br/><br/><img src='./../wp-content/themes/unbk/images/image82.png' />");
        } else {
          $('#error-msg').html(errorMSG + "Soal Error No : <span style='color:red;font-weight:bold'>" + i + "</span>");
        }
        soal[i] = {};
        soal[i].n = i;
        soal[i].q = jQuery('div.ex-tr').eq((i - 1) * 6 + 0).children('.ex-td').eq(1).html();

        if (jQuery('div.ex-tr').eq((i - 1) * 6 + 1).children('.ex-td').eq(2).html().indexOf('__') >= 0) {
          soal[i].a = '<textarea maxlength="5100" data-nomor-asli=' + i + ' class="essay" style="width:100%;background:#fff" rows=5></textarea>';
        } else {
          if (jQuery('div.ex-tr').eq((i - 1) * 6 + 1).children('.ex-td').eq(2).html() == '&nbsp;') {
            soal[i].a = '<p class="to-be-removed">@</p>';
          } else {
            soal[i].a = jQuery('div.ex-tr').eq((i - 1) * 6 + 1).children('.ex-td').eq(2).html();
          }
        }


        if (jQuery('div.ex-tr').eq((i - 1) * 6 + 2).children('.ex-td').eq(2).html() == '&nbsp;') {
          soal[i].b = '<p class="to-be-removed">@</p>';
        } else {
          soal[i].b = jQuery('div.ex-tr').eq((i - 1) * 6 + 2).children('.ex-td').eq(2).html();
        }

        if (jQuery('div.ex-tr').eq((i - 1) * 6 + 3).children('.ex-td').eq(2).html() == '&nbsp;') {
          soal[i].c = '<p class="to-be-removed">@</p>';
        } else {
          soal[i].c = jQuery('div.ex-tr').eq((i - 1) * 6 + 3).children('.ex-td').eq(2).html();
        }

        if (jQuery('div.ex-tr').eq((i - 1) * 6 + 4).children('.ex-td').eq(2).html() == '&nbsp;') {
          soal[i].d = '<p class="to-be-removed">@</p>';
        } else {
          soal[i].d = jQuery('div.ex-tr').eq((i - 1) * 6 + 4).children('.ex-td').eq(2).html();
        }

        if (jQuery('div.ex-tr').eq((i - 1) * 6 + 5).children('.ex-td').eq(2).html() == '&nbsp;') {
          soal[i].e = '<p class="to-be-removed">@</p>';
        } else {
          soal[i].e = jQuery('div.ex-tr').eq((i - 1) * 6 + 5).children('.ex-td').eq(2).html();
        }

      }

      if (jumlahsoal % 1 === 0 && jumlahsoal > 0) {
        $('#error-msg').hide();
      }

      //Clear HTML
      var body = jQuery('#soal-body');
      body.html('');

      //Masukkan Soal ke HTML
      html = '';
      for (i = 1; i <= jumlahsoal; i++) {
        no = soal[i].n;
        html += '<div data-nomor-asli="' + no + '" id="nomor-asli-' + no + '" class="soal nomor-asli-' + no + '">';
        html += '<div class="nomor">' + no + '</div>';
        html += soal[i].q;
        html += '<div class="options-group">';

        for (j = 1; j <= 5; j++) {
          html += '<div class="options">';
          html += '<span data-nomor-asli="' + no + '" data-option-asli="' + String.fromCharCode(64 + j) + '" class="option">X</span>';
          html += soal[i][String.fromCharCode(96 + j)];
          html += '</div>';
        }


        html += '</div>';
        html += '</div>';

      }
      body.html(html);

      //Jumlahsoal dan Yang harus Dikerjakan
      <?php
      $v11sql = "SELECT shuffle2,shuffle,jumlahsoal, dikerjakan FROM `{$table_prefix}bsfsm_options` WHERE `kode`='" . $mapel . "'";
      $stmt = $conn->prepare($v11sql);
      $stmt->execute();
      $stmt->bind_result($shuffle2, $shuffle, $mapel_jumlahsoal, $mapel_dikerjakan);
      while ($stmt->fetch()) {
      }
      $stmt->close();
      ?>

      //Acak and Grouping
      <?php include('acak.js.php'); ?>

      //Re-Index

      jQuery('.to-be-removed').parent().remove();

      var i = 0;
      jQuery('div.soal').each(function(index, el) {
        //Soal
        no = i + 1;
        jQuery(this).addClass('nomor-' + (no));
        jQuery(this).find('div.nomor').text(no);

        //Pilihan
        var j = 0;
        <?php if ($shuffle2) : ?>
          jQuery(this).children('div.options-group').find('.options').shuffle();
        <?php endif; ?>

        jQuery(this).find('.options').each(function() {
          var span = jQuery(this).children('span');
          span.attr('data-nomor', no);
        })

        jQuery(this).children('div.options-group').find('.options').each(function(index, el) {
          span = jQuery(this).children('span');
          //span.text(String.fromCharCode(65+j));
          span.html('<span class="inneroption">' + String.fromCharCode(65 + j) + '</span>');
          // span.attr('data-nomor',no);
          span.attr('data-option', String.fromCharCode(65 + j));
          span.addClass('option-' + String.fromCharCode(65 + j))
          j++;
        });
        jQuery(this).children('div.options-group').find('textarea').each(function(index, el) {
          span = jQuery(this);
          span.attr('data-nomor', no);
          j++;
        });

        i++;

      });

      //summary
      var i = 0;
      jQuery('div.soal').each(function(index, el) {
        i++;
        var no_asli = jQuery(this).attr('data-nomor-asli');
        jQuery('#summary').append('<div id="jawaban-' + i + '" style="display:none"></div>');
        jQuery('#summary').append('<div class="not-done no nomor-asli-' + no_asli + ' no-' + i + ' "><p>' + i + '</p><span></span></div>');
      });
      jQuery('#summary .no-1').addClass('active')

      jQuery('.no:gt(<?php echo $mapel_dikerjakan - 1 ?>)').remove();
      jQuery('.soal:gt(<?php echo $mapel_dikerjakan - 1 ?>)').remove();
      jQuery('#jumlah_soal').text('<?php echo $mapel_dikerjakan ?>');


      //Simpan Urutan Acak
      <?php if ($saveurutansoal == 1) : ?>
        console.log("Menyimpan Urutan Soal");
        var s = '';
        var i = 0;
        jQuery('div.soal').each(function(index, el) {
          i++;
          id = jQuery(this).prop('id');
          id = id.replace("nomor-asli-", "");
          s = s + i + "=" + id + "&";
        });

        var date = new Date(null);
        date.setSeconds(seconds);
        var stamp = date.toISOString().substr(11, 8);

        $.get(themedir2 + '/api-18575621/saveurutan.php?' + s, {
          mapel: '<?php echo ($mapel) ?>',
          siswa: '<?php echo ($siswa) ?>',
          namasiswa: localStorage.getItem('siswa.namasiswa'),
          stamp: stamp,
          starttime: '<?php echo (date("H:i:s")) ?>',
        }, function(s) {
          //console.log (s);
        });
      <?php endif; ?>

      //Aktifkan
      jQuery('#soal-body').show();
      jQuery('div.soal').eq(0).addClass('active');
    }

    <?php if (false) : ?>
  </script>
<?php endif; ?>