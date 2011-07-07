// Get a chapter from the server and update the 'browse-body' div
var Browse = {
  browse: function (url) {
    $('#browse-body').empty();
    var jqxhr = $.getJSON(url, Navigation.getCurrentStyleFn(url))
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#browse-body');
      });
  },
  
  updateToolbarFn: function(parsedURLFragments) {
    var versions = parsedURLFragments[0];
    var book = parsedURLFragments[1];
    var chapter = parsedURLFragments[2];
 
    $("#version option").removeAttr('selected');
    $("#version option[value='" + versions[0] +"']").attr('selected', 'selected');
    
    $("#book option").removeAttr('selected');
    $("#book option[value='" + book +"']").attr('selected', 'selected');
        
    $("#chapter option").removeAttr('selected');
    $("#chapter option[value='" + chapter +"']").attr('selected', 'selected');
  }
};

// Main function
$(document).ready(function() {
  Navigation.currentStyle = 'table';
  Navigation.onChangeFn = Browse.browse;
  Navigation.updateToolbarFn = Browse.updateToolbarFn;
  Navigation.init();
});
