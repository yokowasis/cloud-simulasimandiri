<?php $userid = get_current_user_id(); ?>
<?php include ('kop.php') ?>

<?php
  if (!isset($_GET['server'])) {
    echo "Gunakan CBT Admin Versi Terbaru";
    exit;
  } else {
    $server = $_GET['server'];
  }
?>

<div align="center" class="noprint">
  <button onclick="window.print()" id="printbutton" style="padding:4px 36px; margin-bottom: 20px;">Print</button>
  <p>Mata Pelajaran : <?php echo ($_GET['mapel']) ?></p>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
      window.print();
    });
</script>


<style type="text/css">
  .tg  {border-collapse:collapse;border-spacing:0;border:solid 1px #000; width : 100%;}
  .tg td{font-family:Arial, sans-serif;padding:2px 7px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;}
  .tg th{font-family:Arial, sans-serif;font-weight:normal;padding:2px 7px;overflow:hidden;word-break:normal;border-bottom: solid 1px #000;}
  .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:middle}
  
  .left {
    float: left;
    width: 48%;
    margin-bottom: 3%;
  }
  .left:nth-child(even) {
    margin-right: 0;
    float: right;
  }
  .right {
    float: right;
    width: 300px;
  }

  #page {
    background: white;
    width: 21cm;
    display: block;
    margin: 0 auto;
    margin-bottom: 0.5cm;
    box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
  }

  #innerpage {
    padding: 30px;
  }

  .tbhd td {
    text-align: center;
    font-size: 16px;
    font-weight: bold;
  }

  h1 {
    font-size: 10px;
  }

  body table {
    font-family: "Arial";
    font-size: 12px;
  } 

  .clear {
    clear: both; 
  }

  table.maintable {
    width: 100%;
    border-collapse: collapse;
  }

  table.maintable th {
    background: #C4BC96;
  }
  
  table.maintable td, 
  table.maintable th 
  {
    border: solid 1px #000;
    padding: 5px;
  }

  table.maintable tr:nth-child(odd) .odd,
  table.maintable tr:nth-child(even) .even {
    opacity: 0;
  }


  table.subheader tr td:first-child {
    width :300px;
  }

  .absen-footer p { font-size: 12px; font-family: Arial; margin: 0;}
  .absen-footer table { width: 100% }
  .absen-footer table td { padding : 5px; }

  .screen { border-bottom: dashed 1px #000; margin: 30px 0 }

@media print  
{
    tr,td,div{
        page-break-inside: avoid;
    }
    .tbhd {page-break-before: always;}

    .noprint, 
    .screen {
      display: none;
    }
}
</style>
<?php 
global $wpdb;
$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_identitas` WHERE `ID`=$userid";
if ($rows = $wpdb->get_results($v11sql)){
  $row = $rows[0];

  $namasekolah = $row->{'db-Nama Sekolah'};
  $kotasekolah = $row->{'db-Kota / Kabupaten'};
};
?>
<div id="page">
  <div id="innerpage">

    <?php 
      global $wpdb;
      $rows = json_decode(stripslashes($_POST['data']));
      $kets = $rows;

      global $wpdb;
      $max = $_POST['max'];
    ?>



      <?php 
        for ($i=1; $i <= $max; $i++) { 
          foreach ($kets as $ket) {
            ?>
      <table width="100%" class="tbhd">
        <tr>
          <td rowspan="3" style="text-align: left;"><img style="height: 60px;" src="<?php echo ($logokiri) ?>"></td>
          <td><?php echo ($kop2) ?></td>
          <td rowspan="3" style="text-align: right;"><img style="height: 60px;" src="<?php echo ($logokanan) ?>"></td>
        </tr>
        <tr>
          <td><?php echo (strtoupper($acara)) ?></td>
        </tr>
        <tr>
          <td><?php echo ($tahunpelajaran) ?></td>
        </tr>
      </table>

      <div style="height : 30px;"></div>
    
    <div class="left">
      <table class="subheader">
        <tr>
          <td>Kota / Kabupaten</td>
          <td>: </td>
          <td><?php echo ($kotasekolah) ?></td>
        </tr>
        <tr>
          <td>Sekolah / Madrasah</td>
          <td>:</td>
          <td><?php echo $namasekolah ?></td>
        </tr>
        <tr>
          <td>ID Server / Ruang</td>
          <td>:</td>
          <td><?php echo $ket->{'server'} ?></td>
        </tr>
        <tr>
          <td>Hari</td>
          <td>:</td>
          <td>_____________&nbsp;Tanggal&nbsp;__________</td>
        </tr>
        <tr>
          <td>Mata Pelajaran</td>
          <td>:</td>
          <td><?php echo ($_GET['mapel']) ?></td>
        </tr>
      </table>
    </div>

    <div class="right">
      <table class="subheader">
        <tr>
          <td>Sesi</td>
          <td>:</td>
          <td><?php echo $i ?></td>
        </tr>
        <tr>
          <td>Pukul</td>
          <td>:</td>
          <td>__________________</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
    <div class="clear"></div>

    <table class="maintable">
      <thead>
      <tr>
        <th>No</th>
        <th>Username</th>
        <th>Nama Peserta</th>
        <th colspan="2">Tanda Tangan</th>
        <th><?php echo ($namaket1) ?></th>
      </tr>  
      </thead>            
            <?php
            $rows = json_decode(stripslashes($_POST['data2']));
            
            $j=0;
            foreach ( $rows as $row ) 
            {
                  $j++;
                  if ($row->sesi == $i) {
                    ?>
                    <tr>
                      <td><?php echo $j ?></td>
                      <td style="text-align: center"><?php echo $row->{'kode'} ?></td>
                      <td><?php echo $row->{'nama'} ?></td>
                      <td style="border-right:none; width:100px;" class="odd"><?php echo $j ?></td>
                      <td style="border-left:none; width:100px;" class="even"><?php echo $j ?></td>
                      <td style="text-align: center"><?php echo ($row->nik) ?></td>
                    </tr>                    
                    <?php  
                  }                
            }
            ?>
                  </table>
                  <div class="absen-footer">
                    <div style="height:15px"></div>
                    <p style="font-weight:bold">Keterangan :</p>
                    <p>1. <?php echo ($ket1) ?></p>
                    <p>2. <?php echo ($ket2) ?></p>
                    <p>3. <?php echo ($ket3) ?></p>
                    <div style="height:15px"></div>
                    <table>
                      <tr>
                        <td>Jumlah Peserta Yang Seharusnya Hadir</td>
                        <td>:</td>
                        <td>_________</td>
                        <td></td>
                        <td style="text-align:center">Proktor</td>
                        <td style="text-align:center">Pengawas</td>
                      </tr>
                      <tr>
                        <td>Jumlah Peserta Yang Tidak hadir</td>
                        <td>:</td>
                        <td>_________</td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Jumlah Peserta Hadir</td>
                        <td>:</td>
                        <td>_________</td>
                        <td></td>
                        <td style="text-align: center">( _________________)</td>
                        <td style="text-align: center">( _________________)</td>
                      </tr>
                    </table>
                  </div>
                  <div class="screen"></div>

                  
            <?php
          }
        }
      ?>


  </div>
</div>