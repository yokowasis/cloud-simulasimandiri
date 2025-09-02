<?php

    function shortcode_opsi( $atts ) {
        $a = shortcode_atts( array(
            'no' => '1',
            'pg' => '',
        ), $atts );
        ob_start();
        ?><div class="options" style="display:inline-block; margin:0;">
            <span 
                data-nomor-asli="<?php echo $a['no'] ?>" 
                data-option-asli="<?php echo $a['pg'] ?>" 
                style="position: relative; font-size:16px;top: 5px;"
                class="option option-<?php echo $a['pg'] ?>">
            </span>
			</div><?php
        return ob_get_clean();
    }
    add_shortcode( 'opsi', 'shortcode_opsi' );

    function shortcode_checklist( $atts ) {
        $a = shortcode_atts( array(
            'no' => '1',
            'pg' => '',
        ), $atts );
        ob_start();
        ?><div class="options checklist" style="display:inline-block; margin:0;">
            <span 
                data-nomor-asli="<?php echo $a['no'] ?>" 
                data-option-asli="<?php echo $a['pg'] ?>" 
                style="position: relative; font-size:13px;color: #fff;"
                class="glyphicon glyphicon-ok option option-<?php echo $a['pg'] ?>">                
            </span>
			</div><?php
        return ob_get_clean();
    }
    add_shortcode( 'checklist', 'shortcode_checklist' );

    function shortcode_isian( $atts ) {
        $a = shortcode_atts( array(
            'no' => '1',
            'pg' => '',
        ), $atts );
        ob_start();
        ?>

        <div class="options isian" style="display:block; margin:0;">
            <textarea maxlength="5100" data-nomor-asli="<?php echo $a['no'] ?>" class="essay" style="width:100%;background:#fff" rows="5"></textarea>
        </div>

        <?php
        return ob_get_clean();
    }
    add_shortcode( 'isian', 'shortcode_isian' );

    function isiansingkat( $atts, $content = null ) {
     $a = shortcode_atts( array(
         'no' => '1',
         'pgr' => '',
     ), $atts );
     ob_start();
     ?>


        <span class="options isian">
            <textarea maxlength="5100" data-nomor-asli="<?php echo $a['no'] ?>" class="essay" style="width:100px;background:#fff" rows="1"></textarea>
        </span>

    
     <?php

     return ob_get_clean();
    }
    add_shortcode( 'isiansingkat', 'isiansingkat' );

    function pdf( $atts, $content = null ) {
         $a = shortcode_atts( array(
             'foo' => 'something',
             'bar' => 'something else',
         ), $atts );
         ob_start();

         $file = $atts['file'];
         echo "<iframe style='width:100%;height:800px;' src='$file'>Browser tidak di support</iframe>";

         return ob_get_clean();
     }
     add_shortcode( 'pdf', 'pdf' );
 

    function upload( $atts, $content = null ) {
         $a = shortcode_atts( array(
            'no' => '1',
            'pg' => '',
         ), $atts );
         $no = $a['no'];
         ob_start();        
        ?>
            <div style="font-size:14px;padding: 20px; color : #000">
                <input style="display:inline" type="file" id="uploadFile-<?php echo $no ?>" accept="image/*,.doc,.docx,.pdf" capture="camera" />
                <button class="gdriveUploadInnerBtn" data-nomor-asli="<?php echo $no ?>" id="uploadBtn-<?php echo $no ?>">Upload</button>
            </div>      
<!-- 
            <script>
                $(document).ready(function() {
                    $('#uploadBtn-<?php echo $no ?>').click(function(){
                        document.querySelector("#gdriveNo").value = "<?php echo $no ?>";
                        document.querySelector("#gdriveUploadBtn").click();
                        var file = document.getElementById("uploadFile-<?php echo $no ?>").files[0];
                        var kodesoal = $('#mapel').val();
                        var username = $('#userid').val();
                        var nomor = "<?php echo $no?>";
                        var filename = kodesoal+"-"+username+"-"+nomor;
                        var ext = file.name.match(/\.[0-9a-z]+$/g)[0];
                        var reader = new FileReader();
                        reader.onloadend = function() {
                            var fileData = reader.result.replace(/data.+base64,/g,"");
                        }                        
                        reader.readAsDataURL(file)
                    })
                });
            </script> -->
        <?php
         return ob_get_clean();
     }
     add_shortcode( 'upload', 'upload' );

     function shortcode_list( $atts ) {
         $a = shortcode_atts( array(
             'no' => '1',
             'pilihan' => '',
         ), $atts );
         ob_start();

         $lists = explode(";",$a['pilihan']);



         ?>

        <div class="options" style="margin:0; display:inline-block">
            <select data-nomor-asli='<?php echo $a['no'] ?>' class="soallist">
<?php
                 echo "<option value='-'>-</option>";
                 foreach ($lists as $list) {
                     echo "<option value='$list'>$list</option>";
                 }
?>
            </select>
        </div>          

         <?php
         return ob_get_clean();
     }
     add_shortcode( 'list', 'shortcode_list' );

    function bimasoft_embed( $atts, $content=null ) {
        $a = shortcode_atts( array(
            'w' => '800px',
            'h' => '800px',
            'link' => ''
        ), $atts );
        $s ="<div align='center' style='margin:auto;max-width:100%;width:{$a['w']};height:{$a['h']}'><iframe style='width:100%; height:100%;' src='{$a['link']}'></iframe></div>";
        return $s;
    }
    add_shortcode( 'bimasoft_embed', 'bimasoft_embed' );

    function ljk( $atts ) {
        $a = shortcode_atts( array(
            'no' => '1',
            'jumlah' => '1'
        ), $atts );
        ob_start();

        ?>
            <div class="row">
                <?php for ($i=1; $i <= $a['jumlah'] ; $i++) : ?>
                <div class="col-md-3">
                    <table>
                        <tr><td style="font-weight:bold;width:25px;"><?php echo $i ?>.</td>
                        <td>
                            <div class="options" style="display:inline-block; margin:0;">
                                <span 
                                    data-nomor-asli="<?php echo $a['no'] . str_pad($i,3,"0",STR_PAD_LEFT) ?>" 
                                    data-option-asli="A" 
                                    style="position: relative; font-size:16px;top: 5px;"
                                    class="option option-A"><span class="inneroption">A</span>
                                </span>
                            </div>
                        </td>
                        <td>
                            <div class="options" style="display:inline-block; margin:0;">
                                <span 
                                    data-nomor-asli="<?php echo $a['no'] . str_pad($i,3,"0",STR_PAD_LEFT) ?>" 
                                    data-option-asli="B" 
                                    style="position: relative; font-size:16px;top: 5px;"
                                    class="option option-B"><span class="inneroption">B</span>
                                </span>
                            </div>                            
                        </td>
                        <td>
                            <div class="options" style="display:inline-block; margin:0;">
                                <span 
                                    data-nomor-asli="<?php echo $a['no'] . str_pad($i,3,"0",STR_PAD_LEFT) ?>" 
                                    data-option-asli="C" 
                                    style="position: relative; font-size:16px;top: 5px;"
                                    class="option option-C"><span class="inneroption">C</span>
                                </span>
                            </div>                            
                        </td>
                        <td>
                            <div class="options" style="display:inline-block; margin:0;">
                                <span 
                                    data-nomor-asli="<?php echo $a['no'] . str_pad($i,3,"0",STR_PAD_LEFT) ?>" 
                                    data-option-asli="D" 
                                    style="position: relative; font-size:16px;top: 5px;"
                                    class="option option-D"><span class="inneroption">D</span>
                                </span>
                            </div>                            
                        </td>
                        <td>
                            <div class="options" style="display:inline-block; margin:0;">
                                <span 
                                    data-nomor-asli="<?php echo $a['no'] . str_pad($i,3,"0",STR_PAD_LEFT) ?>" 
                                    data-option-asli="E" 
                                    style="position: relative; font-size:16px;top: 5px;"
                                    class="option option-E"><span class="inneroption">E</span>
                                </span>
                            </div>                            
                        </td>
                        </tr>
                    </table>                                    
                </div>
                <?php endfor; ?>
            </div>
        <?php

        return ob_get_clean();
    }
    add_shortcode( 'ljk', 'ljk' );

    function bimasoft_dragdrop( $atts ) {
        $a = shortcode_atts( array(
            'no' => '',
            'gambar1' => '',
            'gambar2' => '',
            'gambar3' => '',
            'gambar4' => '',
            'gambar5' => '',
            'gambar6' => '',
            'gambar7' => '',
            'gambar8' => '',
            'gambar9' => '',
            'gambar10' => '',
            'pertanyaan1' => '',
            'pertanyaan2' => '',
            'pertanyaan3' => '',
            'pertanyaan4' => '',
            'pertanyaan5' => '',
            'pertanyaan6' => '',
            'pertanyaan7' => '',
            'pertanyaan8' => '',
            'pertanyaan9' => '',
            'pertanyaan10' => '',
        ), $atts );
        ob_start();
        ?>
            <br>
            <?php
                ?>
                <table class='table table-striped'>
                    <?php
                        for ($i=1; $i <=10 ; $i++) { 
                            if ($a['gambar' . $i]) {
                                echo "<tr><td style='vertical-align:middle'>{$a['pertanyaan'.$i]}</td><td style='vertical-align:middle'><div class='dropbox' data-dropnomor='".$a['no'] . (str_pad($i,3,'0',STR_PAD_LEFT))."' style='border:solid 1px #000;width :100px;height:100px;' ondrop='drop(event)' ondragover='allowDrop(event)'></div></td><td style='vertical-align:middle'><img id='dropelement".$a['no'].(str_pad($i,3,'0',STR_PAD_LEFT))."' data-dropnomor='$i' class='dropelement'  src='".$a['gambar' . $i]."' draggable='true' ondragstart='drag(event)' /></td></tr>";
                            }
                        }
                        echo "<tr><td>{$a['pertanyaan'.$i]}</td><td><div class='dropbox' data-dropnomor='".$a['no'] . (str_pad($i,3,'0',STR_PAD_LEFT))."' style='border:solid 1px #000;width :100px;height:100px;' ondrop='drop(event)' ondragover='allowDrop(event)'></div></td><td></td></tr>";
                    ?>
                    
                </table>
                
                <?php
                echo "<p><b>Jawaban</b></p>";
                for ($i=1; $i <=10 ; $i++) { 
                    if ($a['pertanyaan' . $i]) {
                        ?>
                            <span class="options isian">
                                <textarea maxlength="5100" id="droptext<?php echo $a['no']; echo (str_pad($i,3,"0",STR_PAD_LEFT)) ?>" data-nomor-asli="<?php echo $a['no']; echo (str_pad($i,3,"0",STR_PAD_LEFT)) ?>" class="essay" style="width:100px;background:#fff" rows="1"></textarea>
                            </span>
                        <?php
                    }
                }
            ?>
            


        <?php
        return ob_get_clean();
    }
    add_shortcode( 'bimasoft_dragdrop', 'bimasoft_dragdrop' );

    function radio( $atts ) {
        $a = shortcode_atts( array(
            'no' => '',
        ), $atts );
        ob_start();
        ?>
            <div class="sradio" data-nomor-asli="<?php echo $a['no'] ?>"  id="s-<?php echo $a['no'] ?>" style="border:solid 2px #000; width:20px; height:20px; border-radius:100%"></div>
            <div style="display:none">
            <?php
                for ($i=65; $i <=90 ; $i++) { 
                    ?>
                        <span 
                            data-nomor-asli="<?php echo $a['no'] ?>" 
                            data-option-asli="<?php echo chr($i) ?>" 
                            class="option option-<?php echo chr($i) ?>"><span class="inneroption"><?php echo chr($i) ?></span>
                        </span>
                    <?php
                }
            ?>
            </div>
        <?php
        return ob_get_clean();
    }
    add_shortcode( 'radio', 'radio' );

    function radio2( $atts ) {
        $a = shortcode_atts( array(
            'no' => '',
            'opsi' => '',
        ), $atts );
        ob_start();
        ?>
            <div class="dradio" data-option-asli="<?php echo $a['opsi'] ?>" style="border:solid 2px #000; width:20px; height:20px; border-radius:100%"></div>
        <?php
        return ob_get_clean();
    }
    add_shortcode( 'radio2', 'radio2' );

    function clearradio( $atts ) {
        $a = shortcode_atts( array(
            'foo' => 'something',
            'bar' => 'something else',
        ), $atts );
        ob_start();
        ?>
            <p>&nbsp;</p>
            <button class='jawabulang'>Jawab Ulang</button>
        <?php
        return ob_get_clean();
    }
    add_shortcode( 'clearradio', 'clearradio' );

