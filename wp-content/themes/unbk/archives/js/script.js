var themedir2 = localStorage.getItem("themedir2");
var themedir3 = localStorage.getItem("themedir3");
var themedir = localStorage.getItem("themedir");

function checkRestorePenjodohan() {
  if ($(`.soal.active .sradio`).length) {
    restorePenjodohan();
  }
}

var logoutTimer = null;

function selesaiTest() {
  if (!logoutTimer) {
    logoutTimer = setTimeout(() => {
      window.location.href = "../";
    }, 2000);
    toast(
      "Anda teredeteksi keluar dari aplikasi, anda akan logout dalam 2 detik. Silakan menjawab soal untuk membatalkan logout"
    );
  }
}

(function ($) {
  // cancel logoutTimer when document is clicked
  $(document).click(function () {
    if (logoutTimer) {
      clearTimeout(logoutTimer);
      logoutTimer = null;
      toast("Logout di dibatalkan");
    }
  });
})(jQuery);

function toast(text) {
  $.toast({
    heading: "Notifikasi",
    text,
    position: "top-right",
    icon: "info",
    hideAfter: 10000,
    loader: true, // Change it to false to disable loader
    loaderBg: "#9EC600", // To change the background
  });
}

function restorePenjodohan(no) {
  let kodemapel = localStorage.getItem("siswa.mapel");
  let username = localStorage.getItem("siswa.username");
  $(".soal.active")
    .find(".sradio")
    .each(function () {
      let no = $(this).data("nomor-asli");
      let jawaban = localStorage.getItem(`ls[${kodemapel},${username},${no}]`);
      if (jawaban) {
        console.log(no);
        $(this).click();
        $(this).click();
        $(this)
          .closest(".soal")
          .find(`.dradio[data-option-asli="${jawaban}"]`)
          .click();
      }
    });
}

function changesoal(no) {
  akhir = $("#jumlah_soal").text();
  if (no == 0) {
  } else if (no == akhir) {
    $("#nomor span").html(no);
    $(".no").removeClass("active");
    $(".no.no-" + no).addClass("active");
    $("#next-soal").hide();
    $("#last-soal").show();
  } else {
    $("#nomor span").html(no);
    $(".no").removeClass("active");
    $(".no.no-" + no).addClass("active");
    $("#next-soal").show();
    $("#last-soal").hide();
  }

  $(".ragu-check").removeClass("glyphicon-check");
  $(".ragu-check").removeClass("glyphicon-unchecked");
  if ($(".no.active").hasClass("ragu-ragu")) {
    $(".ragu-check").addClass("glyphicon-check");
  } else {
    $(".ragu-check").addClass("glyphicon-unchecked");
  }

  checkRestorePenjodohan();
}

function savewaktu() {
  (function ($) {
    var mapel = $("#mapel").val();
    var userid = $("#userid").text();
    var sisawaktu = $("#countdown").text();
    localStorage.setItem(
      "ls[" + mapel + "," + userid + ",sisawaktu]",
      sisawaktu
    );
  })(jQuery);
}

function jawabsoal(
  userid,
  nomor,
  opt,
  ragu,
  sisawaktu,
  mapel,
  kodemapel,
  act_no
) {
  (function ($) {
    if ($("#localstorage").val() == "realtime") {
      $("#ajax").show();
      $.ajax({
        url: themedir2 + "/jawab.php",
        type: "POST",
        timeout: 60000,
        data: {
          userid: userid,
          no: nomor,
          option: opt,
          ragu: ragu,
          sisawaktu: sisawaktu,
          mapel: mapel,
          kodemapel: kodemapel,
        },
      })
        .done(function (s) {
          if (s == "logout") {
            alert("UserId anda telah di reset oleh Proktor, anda akan Logout");
            window.location = "../";
          } else if (s == "logselesai") {
            alert("Anda sudah selesai ujian. Anda akan Logout secara otomatis");
            window.location = "../";
          } else if (s == "OK") {
            $("#serial-no-" + nomor).val(opt);
            nomor = act_no.attr("data-nomor");
            $(".no.no-" + nomor + " span").html(act_no.html());
            $(".no.no-" + nomor).addClass("done");
            $(".no.no-" + nomor).removeClass("not-done");
            $("#ajax").hide();
            $("#ajax p").html("Mengirim Data Ke Server");
          } else {
            //act_no.removeClass('checked');
            /*********/
            $("#ajax p").html(
              "Gagal Terhubung ke server. Periksa jaringan dan sambungan ke server"
            );
            console.log(s);
            console.log("Jawaban Gagal Tersimpan");
            var randomint;
            randomint = Math.floor(Math.random() * 31) * 1000;
            setTimeout(function () {
              jawabsoal(
                userid,
                nomor,
                opt,
                ragu,
                sisawaktu,
                mapel,
                kodemapel,
                act_no
              );
            }, randomint);
          }
        })
        .fail(function () {
          console.log(
            "Gagal Terhubung ke Server. Periksa Kembali Jaringan / Refresh Browser"
          );
          $("#ajax p").html(
            "Gagal Terhubung ke server. Periksa jaringan dan sambungan ke server"
          );
          var randomint;
          randomint = Math.floor(Math.random() * 31) * 1000;
          setTimeout(function () {
            jawabsoal(
              userid,
              nomor,
              opt,
              ragu,
              sisawaktu,
              mapel,
              kodemapel,
              act_no
            );
          }, randomint);
        })
        .always(function () {});
    } else {
      $("#ajax").hide();
    }
    console.log("Check browser support");
    if (typeof Storage !== "undefined") {
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth() + 1; //January is 0!
      var yyyy = today.getFullYear();

      if (dd < 10) {
        dd = "0" + dd;
      }

      if (mm < 10) {
        mm = "0" + mm;
      }

      today = mm + "/" + dd + "/" + yyyy;

      console.log("Simpan Jawaban");

      if (localStorage.getItem("timestamp") != today) {
        var ek = localStorage.getItem("examkey");
        localStorage.setItem("examkey", ek);
      } else {
      }

      localStorage.setItem("timestamp", today);

      localStorage.setItem(
        "ls[" + mapel + "," + userid + "," + nomor + "]",
        opt
      );
      localStorage.setItem(
        "ls[" + mapel + "," + userid + ",sisawaktu]",
        sisawaktu
      );
      localStorage.setItem("ls[" + mapel + "," + userid + ",mapel]", mapel);
      localStorage.setItem(
        "ls[" + mapel + "," + userid + ",kodemapel]",
        kodemapel
      );

      $("#serial-no-" + nomor).val(opt);
      nomor = act_no.attr("data-nomor");
      $(".no.no-" + nomor + " span").html(act_no.html());
      $(".no.no-" + nomor).addClass("done");
      $(".no.no-" + nomor).removeClass("not-done");
    } else {
      alert(
        "Maaf... Browser anda tidak didukung oleh aplikasi dengan metode penyimpanan Performance"
      );
    }
  })(jQuery);
}

function kumpuljawaban(jawaban, c) {
  c++;
  (function ($) {
    $("#ajax").show();
    $.ajax({
      url: themedir2 + "/kumpul.php",
      type: "POST",
      timeout: 60000,
      data: {
        nama: jQuery("#userid").text(),
        jawaban: JSON.stringify(jawaban),
        mapel: jQuery("#mapel").val(),
      },
    })
      .done(function (s) {
        console.log("success");
        if (s == "OK") {
          $("#ajax p").html("Mengirim Data Ke Server");
          window.location = "./kumpul---";
          $("#ajax").hide();
        } else {
          console.log(s);
          $("#ajax p").html(
            "Gagal Terkoneksi ke Server. Mengulangi Kirim Jawaban. Percobaan ke : " +
              c
          );
          if (c == 4) {
            alert("Jaringan terputus, Silakan Login Ulang");
            window.location = "../";
          }

          var posx = s.search("tidak ditemukan pada mapel");

          if (posx >= 0) {
            alert(s);
            window.location = "../";
          } else {
            var randomint;
            randomint = Math.floor(Math.random() * 61) * 1000;
            setTimeout(function () {
              kumpuljawaban(jawaban, c);
            }, randomint);
          }
        }
      })
      .fail(function (s) {
        console.log("Gagal Terkoneksi ke Server. Mengulangi Kirim Jawaban");
        $("#ajax p").html(
          "Gagal Terkoneksi ke Server. Mengulangi Kirim Jawaban. Percobaan ke : " +
            c
        );
        if (c == 4) {
          alert("Jaringan terputus, Silakan Login Ulang");
          window.location = "../";
        }
        var randomint;
        randomint = Math.floor(Math.random() * 61) * 1000;
        setTimeout(function () {
          kumpuljawaban(jawaban, c);
        }, randomint);
      })
      .always(function (s) {
        console.log("complete");
      });
  })(jQuery);
}

function inIframe() {
  try {
    return window.self !== window.top;
  } catch (e) {
    return true;
  }
}

function selesaiSemua() {
  var jawaban = [];

  $(".option.checked").each(function (index, el) {
    jawaban[$(this).attr("data-nomor-asli")] = $(this).attr("data-option-asli");
  });

  $(".options.checklist .option:not(.checked)").each(function () {
    jawaban[$(this).attr("data-nomor-asli")] =
      "-" + $(this).attr("data-option-asli");
  });

  $("textarea.essay").each(function (index, el) {
    jawaban[$(this).attr("data-nomor-asli")] = $(this).val() + " ";
  });

  $("select.soallist").each(function (index, el) {
    jawaban[$(this).attr("data-nomor-asli")] = $(this).val() + " ";
  });

  kumpuljawaban(jawaban, 0);
}

jQuery(document).ready(function ($) {
  $("#refresh").click(function () {
    location.reload();
  });
  jQuery("#last-soal").click(function () {
    var lanjut = true;
    if (localStorage.getItem("mapel.minimalsisawaktu") > 0) {
      var secs = localStorage.getItem("mapel.minimalsisawaktu");
      secs = secs * 60;
      var hms = jQuery("#countdown").text();
      var a = hms.split(":"); // split it at the colons

      var waktunow = +a[0] * 60 * 60 + +a[1] * 60 + +a[2];
      if (waktunow > secs) {
        lanjut = false;
      }
    }
    if (lanjut) {
      if (jQuery(".not-done").length > 0 && jQuery("#ragu-modal").length > 0) {
        jQuery("#ragu-modal").show();
      } else {
        if (jQuery(".ragu-ragu").length > 0) {
          jQuery("#ragu-modal").show();
        } else {
          jQuery("#yakin-modal").show();
        }
      }
    } else {
      alert("Anda Terlalu Cepat Mengumpulkan");
    }
  });

  jQuery("#selesai").click(function () {
    selesaiSemua();
  });

  $("body").keyup(function (event) {
    if (event.keyCode == 65) {
      $(".soal.active .option-A").click();
    } else if (event.keyCode == 66) {
      $(".soal.active .option-B").click();
    } else if (event.keyCode == 67) {
      $(".soal.active .option-C").click();
    } else if (event.keyCode == 68) {
      $(".soal.active .option-D").click();
    } else if (event.keyCode == 69) {
      $(".soal.active .option-E").click();
    } else if (event.keyCode == 39 && !($("#next-soal:visible").length == 0)) {
      if ($("#blocker").css("display") == "none") {
        $("#next-soal").click();
      }
    } else if (event.keyCode == 37) {
      if ($("#blocker").css("display") == "none") {
        $("#prev-soal").click();
      }
    } else {
    }
  });

  $("audio").click(function (event) {
    $(this).closest(".listeningwrapper").find(".layer").css("display", "block");
    $("#blocker").css("display", "block");
  });

  $(".listening-player").on("ended", function () {
    console.log("Listening Ended");
    $("#blocker").css("display", "none");
    var dataplayed = $(this).attr("data-played");
    dataplayed = parseInt(dataplayed);
    if (dataplayed <= 0) {
      dataplayed++;
      $(this).attr("data-played", dataplayed);
      $(this)
        .closest(".listeningwrapper")
        .find(".layer")
        .css("display", "none");
    }
  });

  $(window).scroll(function (event) {
    var scroll = $(window).scrollTop();
    if (scroll > 135) {
      $("#soal-head").addClass("fixed-top");
      $("body.logged-in.soal-in").css("padding-top", "80px");
    } else {
      $("#soal-head").removeClass("fixed-top");
      $("body").css("padding-top", "0px");
    }
  });

  $(".option").click(function () {
    var act_no, nomor, opt, sisawaktu, ragu;

    sisawaktu = $("#countdown").text();
    $("#ajax").show();
    // $(this).closest('.options-group').find('.option').each(function(){
    // 	$(this).removeClass('checked');
    // })

    nomorAsli = $(this).attr("data-nomor-asli");
    nomor = $(this).attr("data-nomor");

    act_no = $(this);

    // debugger;
    var parent = $(this).closest("div");

    if (parent.hasClass("checklist")) {
      if ($(this).hasClass("checked")) {
        $(this).removeClass("checked");
        opt = "-" + $(this).attr("data-option-asli");
      } else {
        $(this).addClass("checked");
        opt = $(this).attr("data-option-asli");
      }
    } else {
      $(".option[data-nomor-asli=" + nomorAsli + "]").removeClass("checked");
      act_no.addClass("checked");
      opt = $(this).attr("data-option-asli");
    }

    ragu = $(".no.no-" + nomor).hasClass("ragu-ragu");
    nomor = $(this).attr("data-nomor-asli");
    userid = $("#userid").text();
    $("#jawaban-" + nomor).html(opt);
    //alert($('#jawaban-'+nomor).html());
    if (ragu) {
      ragu = "YA";
    } else {
      ragu - "TIDAK";
    }

    mapel = $("#mapel").val();

    jawabsoal(
      userid,
      nomor,
      opt,
      ragu,
      sisawaktu,
      mapel,
      $("#kodetest").val(),
      act_no
    );
  });

  $(".essay").focusout(function (event) {
    $("#ajax").show();
    sisawaktu = $("#countdown").text();
    act_no = $(this);
    jawaban = $(this).val();
    nomor = $(this).attr("data-nomor");
    ragu = $(".no.no-" + nomor).hasClass("ragu-ragu");
    nomor = $(this).attr("data-nomor-asli");
    opt = jawaban + " ";
    userid = $("#userid").text();
    $("#jawaban-" + nomor).html("X");
    //alert($('#jawaban-'+nomor).html());
    if (ragu) {
      ragu = "YA";
    } else {
      ragu - "TIDAK";
    }

    mapel = $("#mapel").val();

    act_no.removeClass("checked");

    jawabsoal(
      userid,
      nomor,
      opt,
      ragu,
      sisawaktu,
      mapel,
      $("#kodetest").val(),
      act_no
    );
  });

  $(".soallist").change(function (event) {
    $("#ajax").show();
    sisawaktu = $("#countdown").text();
    act_no = $(this);
    jawaban = $(this).val();
    nomor = $(this).attr("data-nomor");
    ragu = $(".no.no-" + nomor).hasClass("ragu-ragu");
    nomor = $(this).attr("data-nomor-asli");
    opt = jawaban + " ";
    userid = $("#userid").text();
    $("#jawaban-" + nomor).html("X");
    //alert($('#jawaban-'+nomor).html());
    if (ragu) {
      ragu = "YA";
    } else {
      ragu - "TIDAK";
    }

    mapel = $("#mapel").val();

    act_no.removeClass("checked");

    jawabsoal(
      userid,
      nomor,
      opt,
      ragu,
      sisawaktu,
      mapel,
      $("#kodetest").val(),
      act_no
    );
  });

  $(".no.done").removeClass("not-done");

  $(".ragu").click(function () {
    a = $(this).find(".ragu-check");
    sisawaktu = $("#countdown").text();
    if (a.hasClass("glyphicon-unchecked")) {
      a.removeClass("glyphicon-unchecked");
      a.addClass("glyphicon-check");
      nomor = $(".soal.active").find(".nomor").text();
      $(".no.no-" + nomor).addClass("ragu-ragu");
    } else {
      a.removeClass("glyphicon-check");
      a.addClass("glyphicon-unchecked");
      nomor = $(".soal.active").find(".nomor").text();
      $(".no.no-" + nomor).removeClass("ragu-ragu");
    }
    $(".soal.active .option.checked").click();
  });

  $(".no").click(function (event) {
    nomor = $(this).find("p").html();
    $(".soal").removeClass("active");
    $(".soal.nomor-" + nomor).addClass("active");
    changesoal(nomor);
    $("#myModal2").modal("hide");
  });

  $("#next-soal").click(function () {
    $(".soal.active").next().addClass("active");
    $(".soal.active").eq(0).removeClass("active");
    nomor = $(".soal.active").find(".nomor").text();
    changesoal(nomor);
  });
  $("#prev-soal").click(function () {
    $(".soal.active").prev().addClass("active");
    $(".soal.active").eq(1).removeClass("active");
    nomor = $(".soal.active").find(".nomor").text();
    changesoal(nomor);
  });

  $(".close").click(function () {
    $(".modal").hide();
  });
  $(".close-modal").click(function () {
    $(".modal").hide();
  });

  $("#yakin").change(function () {
    if ($(this).is(":checked")) {
      $("#selesai").removeClass("btn-default");
      $("#selesai").removeAttr("disabled");
      $("#selesai").addClass("btn-success");
    } else {
      $("#selesai").removeClass("btn-success");
      $("#selesai").attr("disabled", "disabled");
      $("#selesai").addClass("btn-default");
    }
  });

  $(".a3").click(function () {
    fontsize = parseInt($(".soal").css("font-size"));
    font = fontsize + 5 + "px";
    font2 = fontsize + 3 + "px";
    width = $(".option").css("width");
    width = parseInt(width.replace("px", "")) + 4 + "px";
    height = $(".option").css("height");
    height = parseInt(height.replace("px", "")) + 4 + "px";
    $(".soal").css({ "font-size": font });
    $(".option").css({ "font-size": font2 });
    $(".option").css({ height: height });
    $(".option").css({ width: width });
  });

  $(".a1").click(function () {
    fontsize = parseInt($(".soal").css("font-size"));
    font = fontsize - 5 + "px";
    font2 = fontsize - 3 + "px";
    width = $(".option").css("width");
    width = parseInt(width.replace("px", "")) - 4 + "px";
    height = $(".option").css("height");
    height = parseInt(height.replace("px", "")) - 4 + "px";
    $(".soal").css({ "font-size": font });
    $(".option").css({ "font-size": font2 });
    $(".option").css({ height: height });
    $(".option").css({ width: width });
  });

  $(".a2").click(function () {
    fontsize = "14px";
    $(".soal").css({ "font-size": fontsize });
    $(".option").css({ height: "23px" });
    $(".option").css({ width: "23px" });
    $(".option").css({ "font-size": "12px" });
  });
});
