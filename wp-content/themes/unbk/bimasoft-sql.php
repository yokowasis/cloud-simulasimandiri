<?php

namespace Bimasoft;

class SQL
{

    public $conn = "";

    /**
     * Database SQL Class by Yokowasis
     *
     * @param string $host [Host Machine]
     * @param string $user [ Username ]
     * @param string $password [ Password ]
     * @param string $db [ Database to connect to]
     */
    public function __construct(
        $host,
        $user,
        $password,
        $db,
        $port = NULL,
        $socket = NULL
    ) {

        if ($port == NULL) {
            $port = "3306";
        }
        $port = (int)$port;
        $this->conn = mysqli_connect($host, $user, $password, $db, $port, $socket);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

    }

    private function parsewhere($where)
    {
        if ($where == "OPTIONAL [STRING OR ARRAY]") {
            return "1=1";
        }

        if (is_string($where)) {
            return (htmlentities($where, ENT_QUOTES));

        } else {
            $keys = array_keys($where);
            $whr = [];
            foreach ($keys as $key) {
                if ($where[$key] != "null") {
                    array_push($whr, " {$key} = '" . htmlentities($where[$key], ENT_QUOTES) . "' ");
                } else {
                    array_push($whr, " {$key} = null ");
                }
            }
            $whr = implode(" AND ", $whr);
            return $whr;
        }

    }

    private function run($sql)
    {
        /**
         * DELETE AND UPDATE
         */

        if ($this->conn->query($sql) === true) {
            return ($this->conn->affected_rows);
        } else {
            return ("Error record: " . $this->conn->error . " SQL : {$sql} ");
        }

    }

    private function ins($sql)
    {
        /**
         * INSERT
         */

        if ($this->conn->query($sql) === true) {
            return ($this->conn->insert_id);
        } else {
            return ("Error record: " . $this->conn->error . " SQL : {$sql} ");
        }

    }

    /**
     * Retrieve SQL Query
     *
     * @param string $sql
     * @return array
     */
    private function ret($sql)
    {
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            $data = [];
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            return $data;
        } else {
            return (0);
        }
    }

    /**
     * Select Query. Return 2 Dimensional Arrray
     * $rows[0]['columname]'
     *
     * @param string $column
     * @param string $table
     * @param string $where
     * @return array rows
     */
    public function _select($column, $table, $where = NULL)
    {

        if ($where == NULL) {$where="OPTIONAL [STRING OR ARRAY]";}

        $column = htmlentities($column, ENT_QUOTES);
        $table = htmlentities($table, ENT_QUOTES);

        $whr = $this->parsewhere($where);

        return ($this->ret("SELECT {$column} FROM {$table} WHERE {$whr};"));
    }

    /**
     * Delete Query
     *
     * @param string $table
     * @param string $where
     * @return int affected rows
     */
    public function _delete($table, $where = NULL)
    {
        if ($where == NULL) {
            $where = "OPTIONAL [STRING OR ARRAY]";
        }
        $whr = $this->parsewhere($where);

        return ($this->run("DELETE FROM {$table} WHERE {$whr};"));

    }

    /**
     * Update Query
     *
     * @param string $table
     * @param array $update
     * @param string $where
     * @return int Affected Rows
     */
    public function _update($table, $update, $where = NULL)
    {
        if ($where == NULL) {$where="OPTIONAL [OR ARRAY]";}
        $table = htmlentities($table, ENT_QUOTES);
        $whr = $this->parsewhere($where);
        $update = $this->parsewhere($update);
        $update = str_ireplace("AND", ",", $update);

        $sql = "UPDATE {$table} SET {$update} WHERE {$whr};";
        return ($this->run($sql));

    }

    /**
     * Insert Query
     *
     * @param string $table
     * @param array $data
     * @return int insert_id
     */
    public function _insert($table, $data)
    {

        $keys = array_keys($data);

        $values = [];

        foreach ($keys as $key) {
            array_push($values, "'" . htmlentities($data[$key], ENT_QUOTES) . "'");
        }

        $keys = implode(",", $keys);
        $values = implode(",", $values);

        return ($this->ins("INSERT INTO {$table} ({$keys}) VALUES ({$values});"));

    }

    public function _insertUpdate($table, $data, $where) {
        $res = $this->_select("1",$table,$where);
        if ($res) {
            $this->_update($table,$data,$where);
        } else {
            $this->_insert($table,$data);
        }
    }


    /**
     * Render data tables based on query
     *
     * @param string $query [Full Complete Sanitized Query]
     * @return void
     */
    public function render($query, $table=NULL){
        if ($table == NULL) {$table="";}
        if (isset($_POST['rowdelete'])) {
            $this->_delete($table,[
                $_POST['colid'] => $_POST['rowdelete']
            ]);
        }

        if (isset($_POST['rowsave'])) {
            $data =  (array) json_decode(str_ireplace("\\","",$_POST['data']));
            $this->_update($table,$data,[
                $_POST['colid'] => $_POST['rowsave']
            ]);
        }


        $res = $this->ret($query);
        if ($res == 0) {
            return "Tidak ada Data saat ini";
        }
        ob_start();
        //Do Something
        ?> 
            <table class="dataTables">
                <thead>
                    <th><input id="checkall" type="checkbox" /></th>
                    <?php $keys = array_keys($res[0]) ?>
                    <?php foreach ($keys as $key) : ?>
                    <th><?php echo ucwords(str_ireplace("_"," ",$key)) ?></th>
                    <?php endforeach ?>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php foreach ($res as $row) : ?>
                    <tr>
                        <td style="text-align:center"><input class="rowcheck" type="checkbox" /></td>
                        <?php foreach ($keys as $key) : ?>
                        <td><?php echo $row[$key] ?></td>
                        <?php endforeach ?>
                        <td style='text-align:center'>
                            <a style='color:red;font-weight:bold' href='#delete' class='rowdelete'>Del</a> | 
                            <a href='#edit' class='rowedit'>Edit</a> |
                            <a href='#save' class='rowsave'>Save</a> |
                            <a href='#cancel' class='rowcancel'>Cancel</a> 
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <script>
                (function($){
                    $('.dataTables').dataTable({
                        "stripeClasses" : ['odd', 'even'],
                    });

                    $('body').on('click','.rowcancel',function(){
                        var i = 0;
                        var counts = $(this).closest('tr').find('td').length;
                        $(this).closest('tr').find('td').each(function(){
                            if (i > 0 && i < counts - 1) {
                                var s = $(this).find('input').val();
                                $(this).html(s);
                            }
                            i++;
                        })                        
                    })                    

                    $('body').on('change','#checkall',function(){
                        var checkall = $(this);
                        var status = checkall.prop("checked");
                        $('.rowcheck').prop("checked",status);
                    })                    

                    $('body').on('click','.rowdelete',function(){
                        var thisrow = $(this).closest('tr');
                        $.ajax({
                            url: window.location,
                            type: 'POST',
                            data: {
                                rowdelete : $(this).closest('tr').find('td').eq(1).text(),
                                colid : $(this).closest('table').find('th').eq(1).text().toLowerCase()
                            },
                        }).done(function(e) {
                            thisrow.remove();
                        }).fail(function(e) {
                            alert (e);
                        });
                    })

                    $('body').on('click','.rowsave',function(){

                        var i = 0;
                        var thisrow = $(this).closest('tr');
                        var counts = $(this).closest('tr').find('td').length;
                        $(this).closest('tr').find('td').each(function(){
                            if (i > 0 && i < counts - 1) {
                                var s = $(this).find('input').eq(1).val();
                                $(this).html(s);
                            }
                            i++;
                        })                        

                        var fields = [];

                        var i = 0;
                        var j = 0;
                        $(this).closest('table').find('th').each(function(){
                            if (i > 0 && i < counts - 1) {
                                fields[j] = $(this).text().toLowerCase();
                                j++;
                            }
                            i++;
                        })

                        var values = {};

                        var i = 0;
                        var j = 0;
                        $(this).closest('tr').find('td').each(function(){
                            if (i > 0 && i < counts - 1) {
                                var s = $(this).find('input').val();
                                var t = $(this).text();
                                if (s) {
                                    values[fields[j]] = s;
                                } else {
                                    values[fields[j]] = t;
                                }
                                j++;
                            }
                            i++;
                        })

                        $.ajax({
                            url: window.location,
                            type: 'POST',
                            data: {
                                rowsave : $(this).closest('tr').find('td').eq(1).text(),
                                colid : $(this).closest('table').find('th').eq(1).text().toLowerCase(),
                                data : JSON.stringify(values)
                            },
                        }).done(function(e) {
                            thisrow.find('.rowcancel').click();
                        }).fail(function(e) {
                            alert (e);
                        });
                    })

                    $('body').on('click','.rowedit',function(){
                        var i = 0;
                        var counts = $(this).closest('tr').find('td').length;
                        $(this).closest('tr').find('td').each(function(){
                            if (i > 1 && i < counts - 1) {
                                var s = $(this).text();
                                $(this).html("<input type='text' name='asd' value='" + s + "' />");
                            }
                            i++;
                        })                        
                    })

                })(jQuery)
            </script>
            <style>
                tr.even td { background : #f3f3f3;}
            </style>
        <?php
        return ob_get_clean();
    }
}
