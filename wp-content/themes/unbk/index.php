<?php
require_once('bimadb.php');
require_once('daftarbaru.php');
require_once('header.php');
require_once('login.php');
require_once('footer.php');

// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function indexPage()
{
  print_header();
  include('indb.php');
  if (isset($_GET['logout'])) {
?>
    <script>
      var nowurl = "<?php echo $home_url ?>";
      var ek = localStorage.getItem('examkey');
      if ((ek) && (ek != "null")) {
        nowurl = nowurl + "?examkey=" + ek;
      }
      window.location = nowurl;
    </script>
    <?php
  }

  if (
    ($absolute_url == get_home_url(null, '', null) . '/') ||
    strpos($absolute_url, get_home_url(null, '', null) . '/?') >= 0
  ) {
    if ($opt_examkey) {
      $examkey = (isset($_GET['examkey'])) ? $_GET['examkey'] : false;
      if ($examkey === $opt_examkey) {
        printLogin();
      } else {
    ?>
        <script>
          if (typeof JSBridge !== "undefined") {
            if (typeof JSBridge.checkBimasoftExamClient !== "undefined") {
              localStorage.setItem("examkey", "<?php echo $opt_examkey ?>");
            }
            if (typeof JSBridge.isAppPinned !== "undefined") {
              localStorage.setItem("examkey", "<?php echo $opt_examkey ?>");
            }
            const searchParams = new URLSearchParams(window.location.search);
            const platform = searchParams.get("platform");
            if (platform === "AppleIOS") {
              localStorage.setItem("examkey", "<?php echo $opt_examkey ?>");
            }
          }

          var ek = localStorage.getItem('examkey');
          if (ek == "<?php echo $opt_examkey ?>") {
            window.location.href = "<?php echo $home_url ?>/?examkey=<?php echo $opt_examkey ?>";
          } else {
            localStorage.setItem("examkey", "<?php echo $examkey ?>");
          }
        </script>
        <div class="row">
          <div class="col-md-12">
            <div id="loginbox">
              <div id="logintitle">
                <p class="text-center" style="font-weight: bold;">Access Denied</p>
              </div>
              <div id="loginbody" style="padding:50px; font-weight: normal">
                <p class="text-center">Akses login tidak bisa diberikan</p>
                <p class="text-center">Silakan menggunakan aplikasi Exambrowser yang disediakan</p>
              </div>
            </div>
          </div>
        </div>
<?php
      }
    } else {
      printLogin();
    }
  } else {
    printLogin();
  }

  print_footer();
}
indexPage();
