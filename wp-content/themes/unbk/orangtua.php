<?php

add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>

    <?php
    global $current_user; // Use global
   wp_get_current_user(); // Make sure global is set, if not set it.
    if ( ! user_can( $current_user, "subscriber" ) ) {
        ?> 

            <h3><?php _e("Extra profile information", "blank"); ?></h3>

            <table class="form-table">
            <tr>
            <th><label for="useranak"><?php _e("Username Anak"); ?></label></th>
                <td>
                    <input type="text" name="useranak" id="useranak" value="<?php echo esc_attr( get_the_author_meta( 'useranak', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Masukkan Username Anak."); ?></span>
                </td>
            </tr>
            </table>

        <?php
    } // Check user object has not got subscriber role        
    else {
        // echo 'User is a Subscriber';
    }        
    ?>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'useranak', $_POST['useranak'] );
}

// Remove Default Dashboard

function remove_dashboard_widgets() {
    global $wp_meta_boxes;
 
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
 
}
 
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

if (!current_user_can('manage_options')) {
    add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
}


// Add Dashboard 

add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets');
  
function my_custom_dashboard_widgets() {
    global $wp_meta_boxes;
    global $current_user; // Use global
   wp_get_current_user(); // Make sure global is set, if not set it.
    if ( ! user_can( $current_user, "subscriber" ) ) {
    } else {
        wp_add_dashboard_widget('custom_help_widget', 'Daftar Nilai', 'custom_dashboard_help');
    }
}
 
function custom_dashboard_help() {

    global $current_user; // Use global
    include 'indb.php';
   wp_get_current_user(); // Make sure global is set, if not set it.

    $username = get_user_meta(get_current_user_id(), 'useranak', true);

    global $wpdb;
    $v11sql =
        "
        SELECT nama 
        FROM `{$table_prefix}bsfsm_siswa`
        WHERE kode = %s 
            LIMIT 1
        ";
    
    $namasiswa = $wpdb->get_var($wpdb->prepare($v11sql,array($username)));

    ?> 
    <h3 style="font-size:24px; font-weight: bold; text-decoration: underline"><?php echo "$namasiswa" ?></h3>
    <h4 style="font-size:18px;" id='usersiswa'><?php echo "$username" ?></h4>
    <p>&nbsp;</p>
    <table style="width:100%; border-collapse: collapse">
        <thead>
            <tr>
                <th style="padding: 10px; border:solid 1px #000;">No</th>
                <th style="padding: 10px; border:solid 1px #000;">Kode Mapel</th>
                <th style="padding: 10px; border:solid 1px #000;">Nilai</th>
            </tr>
        </thead>
        <tbody>
            <?php 

            global $wpdb;
            $v11sql =
                "
                SELECT *
                FROM `{$table_prefix}bsfsm_hasil`
                WHERE userid = %s 
                ";
            $rows = $wpdb->get_results($wpdb->prepare($v11sql,array($username)));

            $i=1;
            
            foreach ( $rows as $row ) 
            {
                ?> 
                <tr class='rowmapel'>
                    <td style="text-align: center; padding: 10px; border:solid 1px #000;"><?php echo $i++ ?></td>
                    <td style="padding: 10px; border:solid 1px #000;"><?php echo $row->test ?></td>
                    <td style="text-align: center; padding: 10px; border:solid 1px #000;"></td>
                </tr>
                <?php
            }
            
            ?>
        </tbody>
    </table>
    <script>
        (function( $ ) {
            function get_nilai($index, $mapel, $username){
                var $url = '<?php echo (get_home_url()); ?>/wp-content/themes/unbk/api-18575621/hitungnilai.php?mapel='+$mapel+'&username='+$username;
                console.log ($url);

                $.post($url, {}, function(data, textStatus, xhr) {
                    $('.rowmapel').eq($index).find('td').eq(2).html(data);
                });		
            }

            $('.rowmapel').each(function (index, element) {
                get_nilai(
                    index, 
                    $(this).find('td').eq(1).html(),
                    $('#usersiswa').html()
                );
            });


            
        })( jQuery );


    </script>
    <?php
}