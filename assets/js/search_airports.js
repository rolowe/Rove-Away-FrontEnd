var dataList = document.getElementById('json-datalist');
var airport_search = document.getElementById('airport-search');

$(document).ready(function() {

  var current_search = "";
  $(airport_search).keyup(function(event) {
     if( $(airport_search).val() != current_search) {

       var val = $(this).val().trim();
           val = val.replace(/\s+/g, '');
           // Fire new query of airports
           getAirports(val);
     }
  });

});



function getAirports(searchParam) {

  $.ajax({
    url: "functions/search_airports.php",
    cache: false,
    data: {
      search: searchParam
    },
    contentType: 'application/json',
    success: function(data){

      airport_search.placeholder = "Leaving from...";
      $("#json-datalist select").empty().append(data);

    },
    error: function(){
      alert("Cannot get data");
    }
  });

}
