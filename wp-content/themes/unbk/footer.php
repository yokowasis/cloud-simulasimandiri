<?php

// @ioncube.dk cekversi() -> 'Bimasoft 13.10.3'
function print_footer()
{
  $mapel = (isset($mapel)) ? $mapel : ""; ?>
  <input type="hidden" id="mapel" value="<?php echo $mapel ?>">
  <input type="hidden" id="kodetest" value="">

  <div class="container">
    <div class="row">
      <div style="height:50px;"></div>
    </div>
  </div>

  <div id="blocker"></div>
  <?php wp_footer(); ?>

  <script>
    // Bimasoft HTML DRAG AND DROP

    function allowDrop(ev) {
      ev.preventDefault();
    }

    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
      ev.preventDefault();
      var data = ev.dataTransfer.getData("text");
      if (ev.target.innerHTML == "" && ev.target.className == "dropbox") {
        ev.target.appendChild(document.getElementById(data));
        //1
        document.getElementById('droptext' + ev.target.dataset.dropnomor).value = document.getElementById(data).dataset.dropnomor;
        jQuery('#droptext' + ev.target.dataset.dropnomor).focusout();
      };
    }
  </script>
<?php
}
