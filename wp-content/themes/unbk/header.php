<?php
// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function print_header()
{
  global $headerclass;
  include ('indb.php');
  if ($opt_backend) {
    $TEMPLATEDIR = 'https://cbtmyid.b-cdn.net/wp-content/themes/unbk';
  } else {
    $TEMPLATEDIR = get_template_directory_uri();
  }
  $TEMPLATEDIR = get_template_directory_uri();

  $headerclass = (isset($headerclass)) ? $headerclass : '';
  $lisensi = getLisensi('Tq8p9rMiQ8hpgNxd7EYOABGGUKCrJozAVIZNpUdArLCbsuvrwZ7xOTCW1aNh');
  ?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate">
    <title><?php echo $lisensi['namasekolah'] ?> CBT TEST <?php echo date('Y'); ?></title>
    <link href="<?php echo "$TEMPLATEDIR" ?>/archives/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo "$TEMPLATEDIR" ?>/archives/css/style.css?bv=13.10.3" rel="stylesheet">
    <link href="<?php echo "$TEMPLATEDIR" ?>/archives/css/fonts.css" rel="stylesheet">
    <link href="<?php echo "$TEMPLATEDIR" ?>/archives/css/jquery.toast.min.css" rel="stylesheet">

    <script data-cfasync="false" src="<?php echo "$TEMPLATEDIR" ?>/archives/js/jquery.min.js"></script>
    <script data-cfasync="false" src="<?php echo "$TEMPLATEDIR" ?>/archives/js/jquery.connections.js"></script>
    <script data-cfasync="false" src='<?php echo "$TEMPLATEDIR" ?>/archives/js/bootstrap.min.js'></script>
    <script data-cfasync="false" src='<?php echo "$TEMPLATEDIR" ?>/archives/js/jquery.toast.min.js'></script>

    <?php wp_head(); ?>

    <style>
      connection {
        border: none !important;
        z-index: 0;
      }

      .sradio,
      .dradio {
        position: relative;
        z-index: 2;
      }

      .jawabulang {
        background: #2D46B9;
        padding: 10px 15px;
        color: #fff;
        font-weight: bold;
        font-size: 12px;
      }
    </style>

    <script type="text/javascript">
      var randomColor;
      var randomLColor;
      var penjodohanNomorAsli;

      function inIframe() {
        try {
          return window.self !== window.top;
        } catch (e) {
          return true;
        }
      }

      function shadeColor(color, percent) {

        var R = parseInt(color.substring(1, 3), 16);
        var G = parseInt(color.substring(3, 5), 16);
        var B = parseInt(color.substring(5, 7), 16);

        R = parseInt(R * (100 + percent) / 100);
        G = parseInt(G * (100 + percent) / 100);
        B = parseInt(B * (100 + percent) / 100);

        R = (R < 255) ? R : 255;
        G = (G < 255) ? G : 255;
        B = (B < 255) ? B : 255;

        var RR = ((R.toString(16).length == 1) ? "0" + R.toString(16) : R.toString(16));
        var GG = ((G.toString(16).length == 1) ? "0" + G.toString(16) : G.toString(16));
        var BB = ((B.toString(16).length == 1) ? "0" + B.toString(16) : B.toString(16));

        return "#" + RR + GG + BB;
      }

      function randomLightColor() {
        var letters = 'BCDEF'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * letters.length)];
        }
        return color;
      }


      $(document).ready(function() {
        $('body').on("click", ".jawabulang", function() {
          $(this).closest('.soal').find('connection').each(function() {
            $(this).remove();
          })
          $(this).closest('.soal').find('td').each(function() {
            $(this).css("background", "none");
          })
          $(this).closest('.soal').find('.sradio').each(function() {
            $(this).css("background", "none");
          })
          $(this).closest('.soal').find('.dradio').each(function() {
            $(this).css("background", "none");
          })
        })

        $('body').on("click", ".sradio", function() {
          randomColor = "#" + Math.floor(Math.random() * 16777215).toString(16);
          randomLColor = randomLightColor();
          randomColor = "#" + Math.floor(Math.random() * 16777215).toString(16);
          penjodohanNomorAsli = $(this).data("nomor-asli");
          $(this).addClass('rs1');
          $(this).css('background', "#2D46B9");
          $(this).closest('tr').find('td').each(function() {
            $(this).css('background', randomLColor);
          })
        });
        $('body').on("click", ".dradio", function() {
          $('.option[data-nomor-asli="' + penjodohanNomorAsli + '"][data-option-asli="' + $(this).data("option-asli") + '"').click();
          if ($('.rs1').length) {
            $(this).css('background', "#2D46B9");
            $(this).closest('tr').find('td').each(function() {
              $(this).css('background', randomLColor);
            })
            $(this).addClass('rd1');
            $('#soal-body .soal').css("position", "absolute");
            $('#soal-body .soal').css("position", "relative");
            if ($('.rs1').offset().top > $('.rd1').offset().top) {
              $().connections({
                from: ".rs1",
                to: ".rd1",
                within: $(this).closest('.soal'),
                css: {
                  background: 'linear-gradient(to bottom right, transparent calc(50% - 3px), ' + randomColor + ' calc(50% - 3px), ' + randomColor + ' 50%, transparent 50%)'
                }
              });
              let x = $(this).closest('.soal').find('connection').last();
              x.width(x.width() + 15);
              x.height(x.height() + 15);
            } else {
              $().connections({
                from: ".rs1",
                to: ".rd1",
                within: $(this).closest('.soal'),
                css: {
                  background: 'linear-gradient(to bottom left, transparent calc(50% - 3px), ' + randomColor + ' calc(50% - 3px), ' + randomColor + ' 50%, transparent 50%)'
                }
              });
              let x = $(this).closest('.soal').find('connection').last();
              x.width(x.width() + 15);
              x.height(x.height() + 15);
              let topInt = parseInt(x.css('top'));
              console.log(topInt);
              x.css("top", (topInt - 10) + "px");
            }

            $('.rs1').removeClass('rs1');
            $('.rd1').removeClass('rd1');
          }
        });

        $('.summary-log .content').html('<span style="color: #007bff; text-decoration: underline; cursor: pointer;">Aplikasi Simulasi Mandiri</span> :<strong> #13.10.3</strong><br>')
        <?php
        if ($opt_iframe) {
          ?>
          if (inIframe() || (window.location.href.indexOf('bimasoftcbt') >= 0)) {

          } else {
            $('#loginbox').html("<div style='text-align:center'>Wajib Menggunakan Aplikasi Android Untuk Login</div><div>&nbsp;</div>")
          }
        <?php
        }
        ?>
      });
      <?php
      if ($opt_backend) {
        ?>
        localStorage.setItem("backend", "<?php echo $opt_backend ?>");
        localStorage.setItem("themedir2", '<?php echo $opt_backend ?>wp-content/themes/unbk');
        localStorage.setItem("themedir3", '<?php echo $opt_backend ?>wp-content/themes/unbk');
        localStorage.setItem("themedir", '<?php echo $opt_backend ?>wp-content/themes/unbk');
        localStorage.setItem("templatedir", '<?php echo $opt_backend ?>wp-content/themes/unbk');
      <?php
      } else {
        ?>
        localStorage.setItem("backend", "./");
        localStorage.setItem("themedir2", '../wp-content/themes/unbk');
        localStorage.setItem("themedir3", '../../wp-content/themes/unbk');
        localStorage.setItem("themedir", 'wp-content/themes/unbk');
        localStorage.setItem("templatedir", "<?php echo $TEMPLATEDIR ?>");
      <?php
      }
      ?>
      var themedir2 = localStorage.getItem("themedir2");
      var themedir3 = localStorage.getItem("themedir3");
      var themedir = localStorage.getItem("themedir");
    </script>

  </head>

  <body>
    <div id="ajax">
      <img src='<?php echo "$TEMPLATEDIR" ?>/images/ajax-loader.gif' />
      <p>Mengirim Data ke Server</p>
    </div>
    <div id='header' class="<?php echo $headerclass ?>">
      <div class='container-fluid'>
        <div class='row'>
          <div class='col-md-12'>
            <div id='logo'>
              <div id='logo-container'>
                <img src='<?php echo $lisensi['logo'] ?>' />
              </div>
              <?php if ($opt_shownamasekolah == '1'): ?>
                <div id='text-container'>
                  <h1><?php echo $lisensi['namasekolah'] ?></h1>
                  <h3><?php echo $opt_blogdescription ?></h3>
                </div>
              <?php endif; ?>
            </div>
            <div id='welcome'>
              <div id='avatar'>
                <img src='<?php echo "$TEMPLATEDIR" ?>/images/avatar.png' />
              </div>
              <div id='selamat'>
                <div id="timenow" style="display: none;"></div>
                <div id="continue" style="display: none;"></div>
                <div id="waktutelat" style="display: none;"></div>
                <p><b id='nama_siswa2'></b></p>
                <input type="hidden" id="localstorage">
                <p>(<b id='userid'></b>)</p>
                <?php if ($opt_bolehlogout): ?>
                  <p><a href='<?php echo $home_url ?>'>Logout</a></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php
}
