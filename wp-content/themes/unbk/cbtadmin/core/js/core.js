/* Core - CSS Javascript 
Manual :

  QueryString   -- Usage : var x = QueryString.x
  DatePicker    -- Usage : <input id="abc" class="core-date-picker">
  RandomString  -- Usage : RandomString(5)      => ABC12
  timenow       -- Usage : timenow()            => 12:12:12
  csv2arr       -- Usage : csv2arr(csvstring)   => [1,2,3,4,5]
  csv2tr        -- Usage : csv2tr(csvstring)    => <tr><td>1</td><td>2</td><td>3</td><td>4</td></tr>

*/
var QueryString = function () {
  // This function is anonymous, is executed immediately and 
  // the return value is assigned to QueryString!
  var query_string = {};
  var query = window.location.search.substring(1);
  var vars = query.split("&");
  for (var i=0;i<vars.length;i++) {
    var pair = vars[i].split("=");
        // If first entry with this name
    if (typeof query_string[pair[0]] === "undefined") {
      query_string[pair[0]] = decodeURIComponent(pair[1]);
        // If second entry with this name
    } else if (typeof query_string[pair[0]] === "string") {
      var arr = [ query_string[pair[0]],decodeURIComponent(pair[1]) ];
      query_string[pair[0]] = arr;
        // If third or later entry with this name
    } else {
      query_string[pair[0]].push(decodeURIComponent(pair[1]));
    }
  } 
  return query_string;
}();



jQuery(document).ready(function($) {

  //core-date-picker

  $('input.core-date-picker').each(function(index, el) {
    id = $(this).attr('id');
    html = '';
    html += `
    <span class="core-date-picker">
      <input type="hidden" name="`+id+`" id="`+id+`" class="core-date-picker-input">
    `;

    //date
    html += `<select name="" class="core-datepicker date">`;
    for (var i = 1; i <= 31; i++) {
      if (i<10) {
        pre = '0';
      } else {
        pre = '';
      }
      html += `<option value="`+pre+i+`">`+i+`</option>`;
    }
    html += `</select>`;

    //month
    html += `
    <select name="" class="core-datepicker month">
      <option value="01">January</option>
      <option value="02">February</option>
      <option value="03">March</option>
      <option value="04">April</option>
      <option value="05">May</option>
      <option value="06">June</option>
      <option value="07">July</option>
      <option value="08">August</option>
      <option value="09">September</option>
      <option value="10">October</option>
      <option value="11">November</option>
      <option value="12">December</option>
    </select>
    `;

    //year
    html += `<select name="" class="core-datepicker year">`;
    for (var i = 1900; i <= 2200; i++) {
      html += `<option value="`+i+`">`+i+`</option>`;
    }
    html += `</select>`;

    html += `</span>`;

    $(this).replaceWith(html);
  });

  $('.core-datepicker').change(function(){
    dd = $(this).closest('span').find('.date').val();
    mm = $(this).closest('span').find('.month').val();
    yy = $(this).closest('span').find('.year').val();
    $(this).closest('span').find('input').val(yy+'-'+mm+'-'+dd);
  })

  $('.core-date-picker-input').change(function(event) {
    val = $(this).val();
    s = val.split('-');
    $(this).closest('span').find('.date').val(s[2]);
    $(this).closest('span').find('.month').val(s[1]);
    $(this).closest('span').find('.year').val(s[0]);
  });

});


function RandomString(x)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < x; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function timenow(){
  var d = new Date(); // for now
  h = d.getHours(); // => 9
  m = d.getMinutes(); // =>  30
  s = d.getSeconds(); // => 51
  if (h<10) {
    h = '0' + h;
  };
  if (m<10) {
    m = '0' + m;
  };
  if (s<10) {
    s = '0' + s;
  };
  var res = h + ':' + m + ':' + s;
  return res;
}

function csv2arr(s){
  var a = s.split('|');
  var res = new Array();
  var i = 0;
  var j = 0;
  a.forEach(function(row) {
     j=0;
     row = row.split(';');
     res[i] = new Array();
     row.forEach(function(col) {
         res[i][j] = col;
         j++;
     }); 
     i++;
  });
  return a;
}

function csv2tr(s){
  var a = s.split('|');
  var res = '';
  a.forEach(function(row) {
    // check if ; exists
    if (row.indexOf(';') >= 0) {
      res += '<tr>';
      row = row.split(';');
      row.forEach(function(col) {
          res += '<td>' + col + '</td>';
      }); 
      res += '</tr>'; 
    }
  });
  // console.log(res);
  return res;
}