function toast(text) {
  $.toast({
    heading: "Notifikasi",
    text,
    position: "top-right",
    icon: "info",
    loader: true, // Change it to false to disable loader
    loaderBg: "#9EC600", // To change the background
  });
}

jQuery(document).ready(function ($) {
  // get parameter from url
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return "";
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  const examkey = getParameterByName("examkey");
  const localExamkey = localStorage.getItem("examkey");

  if (examkey) {
    localStorage.setItem("examkey", examkey);
  } else {
    if (localExamkey) {
      window.location.href = "./?examkey=" + localExamkey;
    }
  }

  // click mapel
  $("body").on("click", ".dropdown-menu li", function () {
    $("#mapel").val($(this).text());
  });

  $.ajax({
    url:
      localStorage.getItem("backend") +
      "wp-content/themes/unbk/api-18575621/getmapel.php",
  }).done(function (e) {
    e = JSON.parse(e);
    localStorage.setItem("data.pt", JSON.stringify(e));
    if (e.autologin == 1) {
      $("#trtest").hide();
    }
    $("#divtest").html(e.html);
    $("#tombolDaftar").html(e.html2);
    $("#pesan_homepage").html(e.welcome);
  });

  $("#refreshWindow").click(function () {
    window.location.reload();
  });

  $("body").on("click", "span#lihatnilai", function (event) {
    $("span#lihatnilai").text("loading...");
    $.ajax({
      url: localStorage.getItem("themedir") + "/nilai.php",
      type: "POST",
      data: {
        userid: $("#username").val().toUpperCase(),
        mapel: $("#mapel").val().toUpperCase(),
        standalone: 1,
      },
    })
      .done(function (s) {
        $("span#lihatnilai").remove();
        $("#loginbox").addClass("konfirm");
        $("#loginbox").addClass("konfirm3");
        var loginbox =
          "" +
          '<form action="../" method="POST">' +
          '    <div id="logintitle">' +
          "        <p>Lihat Nilai</p>" +
          "    </div>" +
          "" +
          '    <div id="loginbody" style="text-align:center">' +
          "        Nilai Anda Untuk Mata Pelajaran " +
          "        <br>" +
          '        <span style="font-size:25px;">' +
          $("#mapel").val() +
          "</span> <br>" +
          "        adalah <br>" +
          "" +
          '        <div style="text-align:center;font-size:50px; font-weight:bold;margin-top:20px;">' +
          "            " +
          s +
          "" +
          "        </div>" +
          "" +
          "    </div>" +
          '    <div id="loginfooter">' +
          '        <input type="submit" value="LOGOUT">' +
          '        <div class="clear"></div>' +
          "    </div>" +
          "</form>";
        $("#loginbox").html(loginbox);
      })
      .fail(function () {
        $("span#lihatnilai").text("Gagal");
      })
      .always(function () {});
  });

  $("#submitlogin").click(function (event) {
    var s = $("#username").val();

    // check apakah playstore
    if (s.toLowerCase().indexOf("playstore") >= 0) {
      window.location.href = "./archives/playstore---";
    }

    var url = window.location.href;
    if (url.search("bimasoftcbt") >= 0) {
      if (s.search("ADMIN") >= 0) {
      } else {
        alert(
          "Halaman Khusus Admin, Silakan upload siswa dengan username dengan awalan ADMIN untuk menggunakan halaman ini"
        );
        return false;
      }
    }
    if (s.indexOf(" ") >= 0) {
      $("#box_keterangan").html("Username Tidak Boleh Menggunakan Spasi");
    } else if (s.indexOf("'") >= 0) {
      $("#box_keterangan").html("Username Tidak Boleh Menggunakan tanda baca");
    } else if (s.indexOf('"') >= 0) {
      $("#box_keterangan").html("Username Tidak Boleh Menggunakan tanda baca");
    } else {
      $("#ajax").show();
      $.post(
        localStorage.getItem("backend"),
        $("#form_login").serialize(),
        function (data, textStatus, xhr) {
          try {
            data = JSON.parse(data);
            if (data.status == "OK") {
              localStorage.setItem(
                "siswa.username",
                data.siswa.username.toUpperCase()
              );
              localStorage.setItem(
                "siswa.namasiswa",
                data.siswa.namasiswa.toUpperCase()
              );
              localStorage.setItem(
                "siswa.mapel",
                data.siswa.mapel.toUpperCase()
              );
              localStorage.setItem("data.continue", data.continue);
              localStorage.setItem("data.finish", 0);
              localStorage.setItem("data.localstorage", data.localstorage);
              localStorage.setItem("data.all", JSON.stringify(data));
              $("#box_keterangan").html("Login Berhasil...");
              window.location = "./archives/konfirmasi---" + data.siswa.mapel;
            } else {
            }
          } catch (error) {
            console.log(error);
            $("#box_keterangan").html(data);
            localStorage.setItem("siswa.username", $("#username").val());
            localStorage.setItem("siswa.namasiswa", "");
          }
          // $('#notif').css('background', '#eff6f4');
          setTimeout(function () {
            // $('#notif').css('background', '#F4E0DE');
            $("#ajax").hide();
          }, 100);
        }
      );
    }
  });
  $("#eye").hover(
    function () {
      $("#password").prop("type", "text");
    },
    function () {
      $("#password").prop("type", "password");
    }
  );
  $("#tombol_daftar").click(function (event) {
    if (
      $("#inp_nama").val() == "" ||
      $("#inp_username").val() == "" ||
      $("#inp_password").val() == ""
    ) {
      alert("Semua Kotak Data Harus diisi");
    } else {
      if ($("#mapel").val()) {
        $("#ajax").show();
        $.post(
          localStorage.getItem("backend"),
          {
            name_baru: $("#inp_nama").val(),
            user_baru: $("#inp_username").val(),
            passw_baru: $("#inp_password").val(),
            mapel_baru: $("#mapel").val(),
          },
          function (data, textStatus, xhr) {
            if (
              data == "Username Sudah Ada, silakan menggunakan username yg lain"
            ) {
              alert(data);
            } else {
              $("#modal_close").click();
              $("#username").val($("#inp_username").val());
              $("#password").val($("#inp_password").val());
              $("#submitlogin").click();
            }
            $("#ajax").hide();
          }
        );
      } else {
        alert("Kode Ujian Tidak Boleh Kosong");
      }
    }
  });
});
