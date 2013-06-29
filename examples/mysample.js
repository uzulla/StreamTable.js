var st;
$(document).ready(function() {

  var data = Movies[0]; // data insert.

  var html = $.trim($("#template").html());
  var template = Mustache.compile(html);
  var view = function(record, index){
    return template({record: record, index: index});
  };

  var $summary = $('#summary');
  var $found = $('#found');

  $('#found').hide();

  var callbacks = {
    pagination: function(summary){
        if ($.trim($('#st_search').val()).length > 0){
          $found.text('Found : '+ summary.total).show();
        }else{
          $found.hide();
        }
       $summary.text( summary.total + '件中、' + summary.from + '件目から'+ summary.to +'件目まで表示');
    }
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

  // Jquery plugin
  //$('#stream_table').stream_table({view: view}, data)

});

