var st;
var onClickSTCheck; // function
var checkbox_data; // data.

$(document).ready(function() {
  var data = Movies[0]; // data insert.

  var checkbox_prefix = 'st_cb_';
  var checkbox_prefix_reg =  new RegExp('^'+checkbox_prefix);
  checkbox_data = {};

  var html = $.trim($("#template").html());
  var template = Mustache.compile(html);
  var view = function(record, index){
    return template({record: record, index: index});
  };

  var $summary = $('#summary');
  var $found = $('#found');

  $('#found').hide();


  var callbacks = {
    pagination_before: function(){
    },
    pagination: function(summary){
      //save now check
      $('input[name^='+checkbox_prefix+']').each(function(){
        var elm = $(this);
        var idx = elm.attr('name').replace(checkbox_prefix_reg, '');
        if(checkbox_data[idx]){
          elm.attr('checked', true);
        }
      });

      if ($.trim($('#st_search').val()).length > 0){
        $found.text('Found : '+ summary.total).show();
      }else{
        $found.hide();
      }
      $summary.text( summary.total + '件中、' + summary.from + '件目から'+ summary.to +'件目まで表示');
    },
  }

  st = StreamTable('#stream_table',
    { view: view, 
      per_page: 10, 
      callbacks: callbacks,
      pagination: {
        span: 10,
        next_text: '次 &gt;', 
        prev_text: '&lt; 前',
        first_text: '最初', 
        last_text: '最後'
       }
    },
   data
  );

  onClickSTCheck = function (event){
    var elm = $(event.target);
    var idx = elm.attr('name').replace(checkbox_prefix_reg, '');
    if(elm.prop('checked')){
      checkbox_data[idx] = true;
    }else{
      checkbox_data[idx] = false;
    }
    console.log(checkbox_data);
  }

});
