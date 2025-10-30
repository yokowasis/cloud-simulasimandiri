if (localStorage.getItem("siswa.namasiswa") !== "__ADMINTESTSOAL__") {
  if (typeof jQuery.fn.shuffle === "undefined") {
    jQuery.fn.shuffle = function () {
      var allElems = this.get(),
        getRandom = function (max) {
          return Math.floor(Math.random() * max);
        },
        shuffled = $.map(allElems, function () {
          var random = getRandom(allElems.length),
            randEl = jQuery(allElems[random]).clone(true)[0];
          allElems.splice(random, 1);
          return randEl;
        });

      this.each(function (i) {
        jQuery(this).replaceWith(jQuery(shuffled[i]));
      });

      return jQuery(shuffled);
    };
  }
}

if (isAcak) {
  jQuery("textarea.essay").each(function () {
    jQuery(this).closest("div.soal").addClass("soalessay");
  });
  jQuery("div.soal").shuffle();
  jQuery(".soalessay").each(function () {
    jQuery(this).appendTo(jQuery("#soal-body"));
  });
}
