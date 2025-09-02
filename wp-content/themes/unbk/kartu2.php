<?php
  include ('kop.php');

  if (!isset($_GET['server'])) {
    echo "Gunakan CBT Admin Versi Terbaru";
    exit;
  } else {
    $server = $_GET['server'];
  }

  $mapel = $_GET['mapel'];
  global $wpdb;
  $rows = json_decode(stripslashes($_POST['data']));
  ?>

  <div align="center" class="noprint">
    <button onclick="window.print()" id="printbutton" style="padding:4px 36px; margin-bottom: 20px;">Print</button>
    <p>Mata Pelajaran : <?php echo ($_GET['mapel']) ?></p>
  </div>

<style type="text/css">
  .tg  {border-collapse:collapse;border-spacing:0;border:solid 1px #000; width : 100%;}
  .tg td{font-family:Arial, sans-serif;font-size:14px;padding:2px 7px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
  .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:2px 7px;overflow:hidden;word-break:normal;border-bottom: solid 1px #000;}
  .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:middle}
  
  td:nth-child(3) {
    max-width: 227px; 
    display: block; 
    overflow: hidden; 
    white-space: nowrap;
  }
  td:nth-child(1) {
    max-width: 128px; 
    white-space: nowrap;
  }
  .left {
    float: left;
    width: 48%;
    margin-bottom: 3%;
  }
  .left:nth-child(even) {
    margin-right: 0;
    float: right;
  }

  #page {
    background: white;
    width: 21cm;
    height: 29.7cm;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  }

@media print  
{
  .noprint {
    display: none;
  }
    div{
        page-break-inside: avoid;
    }
}
</style>
<div id="page">
  <div id="innerpage">

      <?php  foreach ( $rows as $row ) : ?>

      <div class="left">
        <table class="tg">
          <colgroup>
            <col style="width: 73px">
            <col style="width: 69px">
            <col style="width: 21px">
            <col style="width: 257px">
          </colgroup>
          <tr>
            <th class="tg-yw4l"><img src="<?php echo ($logokiri) ?>" style="width:50px;" /></th>
            <th class="tg-amwm" colspan="3"><?php echo $namasekolah ?><br/><?php echo $kop1 ?><br/><?php echo strtoupper($acara); ?></th>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Nama Peserta</td>
            <td class="tg-yw4l">:</td>
            <td class="tg-yw4l"><?php echo $row->{'nama'} ?></td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Nomor Induk</td>
            <td class="tg-yw4l">:</td>
            <td class="tg-yw4l"><?php echo $row->{'id'} ?></td>
          </tr>
          <?php 
            $username = $row->{'kode'};
            $password = $row->{'pass'};
          ?>
          <tr>
            <td class="tg-yw4l" colspan="2">User / Pass</td>
            <td class="tg-yw4l">:</td>
            <td class="tg-yw4l"><?php echo "$username / $password" ?></td>
          </tr>
          <?php /* 
          <tr>
            <td class="tg-yw4l" colspan="2">Mata Pelajaran</td>
            <td class="tg-yw4l">:</td>
            <td class="tg-yw4l"><?php echo ($row->mapel) ?></td>
          </tr>
          */ ?>
          <tr>
            <td class="tg-yw4l" colspan="2"><?php echo ($namaket1) ?></td>
            <td class="tg-yw4l">:</td>
            <td class="tg-yw4l"><?php echo ($row->nik) ?></td>
          </tr>
          <tr>
            <td class="tg-yw4l" colspan="2">Server / Sesi</td>
            <td class="tg-yw4l">:</td>
            <td class="tg-yw4l"><?php echo ($row->server) ?> / <?php echo ($row->sesi) ?></td>
          </tr>
        </table>
      </div>
    <?php endforeach; ?>
  </div>
</div>