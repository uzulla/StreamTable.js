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
       $summary.text( summary.from + ' to '+ summary.to +' of '+ summary.total +' entries');
    }
  }

  st = StreamTable('#stream_table',
    { view: view, 
      per_page: 10, 
      callbacks: callbacks,
      pagination: {span: 5, next_text: 'Next &rarr;', prev_text: '&larr; Previous'}
    },
   data
  );

  // Jquery plugin
  //$('#stream_table').stream_table({view: view}, data)

});

