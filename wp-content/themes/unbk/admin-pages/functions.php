<?php

class Bimasoft_Page {
    function __construct($page_title,$icon,$position,$childs = [],$jsonSaveLocation=NULL,$saveCallback=NULL)
    {
        $slug = strtolower(str_ireplace(" ","-",$page_title));
        $this->page_title = $page_title;
        $this->menu_title = $page_title;
        $this->menu_slug = $slug;
        $this->icon = $icon;
        $this->position = $position;
        $this->childs = $childs;
        $this->options = [];
        $this->jsonSaveLocation=$jsonSaveLocation;
        $this->saveCallback=$saveCallback;
        $this->save_options();
    }

    function doSaveCallback($saveCallback) {
        $saveCallback();
    }

    function save_options() {
        if ( isset($_POST["is_{$this->menu_slug}_submit"]) && $_POST["is_{$this->menu_slug}_submit"]) {
            if ($this->jsonSaveLocation) {
                // save POST to json file
                $myfile = fopen($this->jsonSaveLocation, "w") or die("Unable to open file (0) !");
                $txt = json_encode($_POST);
                if (fwrite($myfile, $txt)) {
                } else {
                    die ("Gagal Menyimpan, error : 103");
                }
                fclose($myfile);
            }    
            foreach ($_POST as $key => $value) {
                update_option( $key, $value );
            }
            if ($this->saveCallback) {
                $this->doSaveCallback($this->saveCallback);
            }    
        }
    }

    function generate() {
        $this->callback = function(){
            echo "<div class='bimasoft_pages'>";
            echo "<link rel='stylesheet' href='".get_stylesheet_directory_uri()."/admin-pages/functions.css'>";
            echo "<h2>{$this->page_title}</h2>";
            echo "<form id='form' method='POST'>";  
            echo "<table style='width:100%'>";
            foreach ($this->options as $option) {
                echo "<tr class='{$option['type']}'>";
                switch ($option['type']) {
                    case 'text':
                        echo "<td style='width:400px'>{$option['title']}</td>";
                        echo "<td><input type='text' name='{$option['name']}' value='{$option['value']}' /><br/><span class='notes'>{$option['notes']}</span></td>";
                        break;
                    
                    case 'title':
                        echo "<td colspan=2><h3>{$option['title']}</h3><p>{$option['notes']}</p></td>";
                        break;
                    
                    case 'hr':
                        echo "<td colspan='2'><hr/></td>";
                        break;
                    
                    case 'textarea':
                        echo "<td style='width:400px'>{$option['title']}</td>";
                        echo "<td><textarea cols=50 rows=5 name='{$option['name']}'>{$option['value']}</textarea></td>";
                        break;
                    
                    case 'checkbox':
                        echo "<td style='width:400px'>{$option['title']}</td>";
                        echo "<td>";
                        echo "<select name='{$option['name']}'>";
                        $option['data'] = ["Tidak", "Ya"];
                        foreach ($option['data'] as $data) {
                            if ($data == $option['value']) {
                                echo "<option value='{$data}' selected>{$data}</option>";
                            } else {
                                echo "<option value='{$data}'>{$data}</option>";
                            }
                        }                    
                        echo "</select><br/><span class='notes'>{$option['notes']}</span>";
                        echo "</td>";
                        break;
                    
                    case 'select':
                        echo "<td style='width:400px'>{$option['title']}</td>";
                        echo "<td>";
                        echo "<select name='{$option['name']}'>";
                        foreach ($option['data'] as $data) {
                            if ($data == $option['value']) {
                                echo "<option value='{$data}' selected>{$data}</option>";
                            } else {
                                echo "<option value='{$data}'>{$data}</option>";
                            }
                        }                    
                        echo "</select><br/><span class='notes'>{$option['notes']}</span>";
                        echo "</td>";
                        break;
                    
                    case 'hidden':
                        echo "<td></td>";
                        echo "<td><input type='hidden' name='{$option['name']}' value='{$option['value']}' /></td>";
                        break;
                    
                    default:
                        # code...
                        break;                    
                }   
                echo "</tr>";
            }            
            echo "</table>";
            echo "<hr/>";
            echo "<input type='submit' class='submit' id='submit' value='Save Changes' />";
            echo "<input type='hidden' name='is_{$this->menu_slug}_submit' value='true' />";
            echo "</form>";   
            echo "</div>";
            echo "<script src='".get_stylesheet_directory_uri()."/admin-pages/functions.js'></script>";
        };

        add_action( 'admin_menu', function(){
            add_menu_page( $this->page_title, $this->menu_title, 'manage_options', $this->menu_slug, $this->callback, $this->icon, $this->position );
        });
    }

    function add_option($title, $notes, $type, $data=[],$value=false) {
        $slug = strtolower(str_ireplace(" ","-",$title));
        $slug = str_ireplace("_","",$slug);
        $title = str_ireplace("_"," ",$title);
        $name = $slug;
        array_push($this->options, [
            'name' => $name,
            'title' => $title,
            'notes' => $notes,
            'type' => $type,
            'data' => $data,
            'value' => ( $value ? $value : stripslashes(get_option($name)) )
        ]);
    }

    function add_submenu_page($page_title,$menu_title,$menu_slug,$callback)
    {
        add_submenu_page( 'parent_menu_slug', $page_title, $menu_title, 'manage_options', $menu_slug, $callback );
    }

}
