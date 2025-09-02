<?php

// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function printLogin()
{
  $lisensi = getLisensi("Tq8p9rMiQ8hpgNxd7EYOABGGUKCrJozAVIZNpUdArLCbsuvrwZ7xOTCW1aNh");
  $examkey = isset($_GET['examkey']) ? $_GET['examkey'] : false;
  if ($examkey) {
?>
    <script>
      localStorage.setItem("examkey", "<?php echo $examkey ?>");
      window?.JSBridge?.stopPinningApp?.();
    </script>
  <?php
  }
  ?>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div id='loginbox'>
          <div id='notif'>
            <div id="box_keterangan">
              <div id="pesan_homepage" style="color:#000"></div>
            </div>
          </div>

          <div id='logintitle'>
            <h3>Selamat Datang</h3>
            <p>Silakan login menggunakan username dan password yang anda miliki</p>
          </div>
          <div id='loginbody'>
            <div style='height :10px'></div>
            <form method='POST' id="form_login" autocomplete="off">
              <table>
                <tr>
                  <td style="position: relative;"><span class="glyphicon glyphicon-user" aria-hidden="true"> </span><input oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" type='text' name='username_login' id='username' placeholder="Username" /></td>
                </tr>
                <tr>
                  <td style="position: relative;"><span class="glyphicon glyphicon-lock" aria-hidden="true"> </span><input type='password' placeholder="Password" name='password' id='password' /> <span class="glyphicon glyphicon-eye-open showPassword" aria-hidden="true" id="eye"></span></td>
                </tr>
                <tr id="trtest">
                  <td style="position: relative;">
                    <div id="divtest">
                      <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span><select name="mapel" id="mapel">
                        <option value="Loading">Loading ...</option>
                      </select>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td></td>
                </tr>
                <tr>
                  <td>
                    <div id="tombolLogin"><button type="button" id="submitlogin" class="btn btn-primary">Login</button></div>
                    <div id="tombolDaftar"></div>
                    <div id="tombolRefresh" class="mobileOnly"><button type="button" id="refreshWindow" class="btn btn-warning">Refresh</button></div>
                  </td>
                </tr>
              </table>
            </form>
          </div>
        </div>
        <div id='loginfooter'>
          <p>© Copyright <?php echo date("Y"); ?>, <?php echo $lisensi['namasekolah'] ?></a></p>
          <div class="summary-log">
            <div class="content">
              <?php // echo ('<a href="#bimasoft.web.id" title="https://bimasoft.web.id/">Aplikasi Simulasi Mandiri</a> :<strong> #13.10.3</strong><br>') 
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Pendaftaran Peserta Test</h4>
        </div>
        <div class="modal-body">
          <form id="daftar_baru">
            <div class="form-group">
              <label for="inp_nama">Nama Lengkap</label>
              <input type="text" class="form-control" id="inp_nama" placeholder="Nama Lengkap">
            </div>
            <div class="form-group">
              <label for="inp_username">Username</label>
              <input oninput="let p=this.selectionStart;this.value=this.value.toUpperCase();this.setSelectionRange(p, p);" type="text" class="form-control" id="inp_username" placeholder="Username">
            </div>
            <div class="form-group">
              <label for="inp_password">Password</label>
              <input type="password" class="form-control" id="inp_password" placeholder="Password">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close">Close</button>
          <button type="button" id="tombol_daftar" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  <script src="<?php echo get_template_directory_uri(); ?>/archives/js/login-lihat-nilai.js?bv=13.10.3"></script>
<?php
}
