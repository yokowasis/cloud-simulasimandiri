<script>
  function timeToMins(time) {
    var b = time.split(':');
    return b[0] * 60 + +b[1];
  }

  // Convert minutes to a time in format hh:mm
  // Returned value is in range 00  to 24 hrs
  function timeFromMins(mins) {
    function z(n) {
      return (n < 10 ? '0' : '') + n;
    }
    var h = (mins / 60 | 0) % 24;
    var m = mins % 60;
    return z(h) + ':' + z(m);
  }

  // Add two times in hh:mm format
  function addTimes(t0, t1) {
    return timeFromMins(timeToMins(t0) + timeToMins(t1));
  }

  jQuery(document).ready(function($) {

    var nama_siswa2 = localStorage.getItem("siswa.namasiswa");
    nama_siswa2 = nama_siswa2.replace("'", "");

    var today = new Date();
    if (today.getHours() < 10) {
      var thh = "0" + today.getHours();
    } else {
      var thh = today.getHours();
    }
    if (today.getMinutes() < 10) {
      var tmm = "0" + today.getMinutes();
    } else {
      var tmm = today.getMinutes();
    }
    var timeNow = thh + ":" + tmm;

    $('#nama_siswa2').text(nama_siswa2);
    $('#userid').text(localStorage.getItem("siswa.username"));
    $('#timenow').html(timeNow);
    $('#continue').html(localStorage.getItem("data.continue"));

    var waktutelat = 0;
    if (waktutelat < 10) {
      waktutelat = '0' + waktutelat;
    }

    $('#waktutelat').html(addTimes('00:' + waktutelat, $('#waktutest').html()));

    if ($('#timenow').html() >= $('#waktutest').html()) {
      $('#mulai').removeAttr('disabled');
      $('#mulai').removeAttr('style');
    }

    var cont;
    cont = $('#continue').html();

    if (cont == 1) {
      console.log('SISWA PERNAH LOGIN SEBELUMNYA');

    } else {
      console.log('SISWA LOGIN PERTAMA KALINYA');

      if ($('#waktutelat').html() == $('#waktutest').html()) {
        console.log('TIDAK AKTIF TELAT');
      } else {
        console.log('Opsi Telat Aktif');
        if ($('#timenow').html() >= $('#waktutelat').html()) {

          console.log('Siswa Terlambat');

          if ($('#timenow').html() >= $('#waktutest').html()) {
            $('#mulai').attr('disabled', 'disabled');
            $('#mulai').css('background', '#333');
          }

        } else {
          console.log('siswa tidak telat');
        }
      }
    }
  });

  const handlePinApp = () => {
    // @ts-ignore
    window?.JSBridge?.startPinningApp?.();
  };

  const isPinned = () => {
    // @ts-ignore
    if (window?.JSBridge?.isAppPinned) {
      // @ts-ignore
      return window?.JSBridge?.isAppPinned?.();
    }

    return true;
  };

  const isDevice = () => {
    // @ts-ignore
    if (window?.JSBridge?.isDevice) {
      // @ts-ignore
      return window?.JSBridge?.isDevice?.();
    }

    return false;
  };

  const isForbidden = () => {
    // @ts-ignore
    if (window?.JSBridge?.isForbidden) {
      // @ts-ignore
      return window?.JSBridge?.isForbidden?.();
    }

    return false;
  };

  const handleUnpinApp = () => {
    // @ts-ignore
    window?.JSBridge?.stopPinningApp?.();
  };

  const handleCheckExam = () => {
    // @ts-ignore
    window?.JSBridge?.checkBimasoftExamClient?.("XXX");
  };
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
    <div class='col-md-8'>
      <div id='loginbox' class='konfirm konfirm2'>
        <div id='logintitle'>
          <p>Konfirmasi Test</p>
        </div>
        <div id='loginbody'>
          <script>
            var dataTest = JSON.parse(localStorage.getItem('data.all'));
            var dataPT = JSON.parse(localStorage.getItem('data.pt'));
            console.log(dataTest);
            localStorage.setItem("mapel.kode", dataTest.mapel.kode);
            localStorage.setItem("mapel.nama", dataTest.mapel.nama);
            localStorage.setItem("mapel.tanggal", dataTest.mapel.tanggal);
            localStorage.setItem("mapel.waktu", dataTest.mapel.waktu);
            localStorage.setItem("mapel.alokasi", dataTest.mapel.alokasi);
            localStorage.setItem("mapel.shuffle", dataTest.mapel.shuffle);
            localStorage.setItem("mapel.shuffle2", dataTest.mapel.shuffle2);
            localStorage.setItem("mapel.jumlahsoal", dataTest.mapel.jumlahsoal);
            localStorage.setItem("mapel.dikerjakan", dataTest.mapel.dikerjakan);
            localStorage.setItem("mapel.minimalsisawaktu", dataPT.minimalsisawaktu);
          </script>
          <script>
            document.write("<input type='hidden' name='mapel' id='mapel' value='" + dataTest.mapel.kode + "'>")
          </script>
          <div class='datasiswa'>
            <p class='bold'>Nama Test</p>
            <p>
              <script>
                document.write(dataTest.mapel.nama)
              </script>
            </p>
          </div>
          <div class='datasiswa status'>
            <p class='bold'>Status Test</p>
            <p class='text-danger'>
              <script>
                document.write(dataTest.mapel.status)
              </script>
            </p>
          </div>
          <div class='datasiswa'>
            <p class='bold'>Tanggal Test</p>
            <script>
              var tanggal = dataTest.mapel.tanggal;
              tanggal = tanggal.split("-");

              switch (tanggal[1]) {
                case "01":
                  tanggal[1] = "Januari"
                  break;

                case "02":
                  tanggal[1] = "Februari"
                  break;

                case "03":
                  tanggal[1] = "Maret"
                  break;

                case "04":
                  tanggal[1] = "April"
                  break;

                case "05":
                  tanggal[1] = "Mei"
                  break;

                case "06":
                  tanggal[1] = "Juni"
                  break;

                case "07":
                  tanggal[1] = "Juli"
                  break;

                case "08":
                  tanggal[1] = "Agustus"
                  break;

                case "09":
                  tanggal[1] = "September"
                  break;

                case "10":
                  tanggal[1] = "Oktober"
                  break;

                case "11":
                  tanggal[1] = "Nopember"
                  break;

                case "12":
                  tanggal[1] = "Desember"
                  break;

                default:
                  break;
              }

              tanggal = [
                tanggal[2],
                tanggal[1],
                tanggal[0]
              ]
            </script>
            <p>
              <script>
                document.write(tanggal.join(" "))
              </script>
            </p>
          </div>
          <div class='datasiswa'>
            <p class='bold'>Waktu Test</p>
            <p id="waktutest"></p>
            <script>
              document.querySelector('#waktutest').innerHTML = dataTest.mapel.waktu;
            </script>
          </div>
          <div class='datasiswa'>
            <p class='bold'>Alokasi Waktu Test</p>
            <p>
              <script>
                document.write(dataTest.mapel.alokasi)
              </script> Menit
            </p>
          </div>
          <div class='datasiswa'>
            <p class='bold'>Token</p>
            <p><input type="text" name="token" id="token" placeholder="masukan token"></p>
          </div>
        </div>
      </div>
    </div>
    <div class='col-md-4'>
      <form method=POST id="form_mulai">
        <input type="hidden" name="step" value="3">
        <p class='warn'>
          TOMBOL MULAI hanya akan aktif apabila waktu sekarang sudah melewati waktu mulai test
          <input id="mulai" type="button" class="btn-danger" value='MULAI' disabled=disabled style="background:#333" />
        </p>

      </form>

    </div>
  </div>
</div>


<script type="text/javascript">
  function do_start() {
    if (isDevice()) {
      alert("Error 102. Terjadi kesalahan. Silakan lapor kepada panitia ujian");
      return;
    }

    if (isForbidden()) {
      alert(
        "Error 101. Terjadi kesalahan. Silakan lapor kepada proktor untuk informasi lebih lanjut",
      );
      return;
    }

    window.location = './soalujian---' + $('#mapel').val();
  }

  jQuery(document).ready(function($) {
    handlePinApp();

    $('body').addClass('logged-in');
    console.log(dataPT);
    if (dataPT.autotoken === "1") {
      $('#token').val('AUTO');
    }
  });

  $('#mulai').click(function(event) {

    if ($('#timenow').html() >= $('#waktutest').html()) {
      if (dataPT.autotoken === "1") {
        do_start();
      } else {
        var token = $('#token').val();
        $.post(themedir2 + '/api-18575621/cektoken.php', {}, function(e) {
          e = e.trim();
          if (token == e) {
            do_start();
          } else {
            alert('Token Salah, Silakan Hubungi Proktor untuk mendapatkan Token');
          }
        })
      }
    } else {
      alert("Waktu Test Belum Dimulai");
    }
  });
</script>
