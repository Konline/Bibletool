// Get a chapter from the server and update the 'browse-body' div
var Browse = {
  browse: function (url) {
    $('#browse-body').empty();
    var jqxhr = $.getJSON(url, Navigation.getCurrentStyleFn(url))
      .complete(function(){Browse.glossary(url)})
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#browse-body');
      });
  },
  
  // Add glossary foot note once the main body is displayed
  glossary: function(url) {
    var url = url.replace('retrieve', 'glossary/retrieve');
    var jqxhr = $.getJSON(url, function(data) {
      var footnote = $('<div class=footnote></div>');
      for (var i=0; i<data.length; i++) {
        var chinese = data[i].chinese;
        var english = data[i].english;
        var book = data[i].book;
        var chapter = data[i].chapter;
        var startVerse = data[i].start_verse;
        var endVerse = data[i].end_verse;
        var footnoteReference = $('<div class=footnote-reference>' +
                                  chapter + ':' + startVerse + '</div>');
        var link = webroot + '/glossary#word/' + chinese;
        var anchor = $('<a href='+link+'>'+chinese+
                       (english ? '('+english+')' : "") +
                       '</a>');
        var footnoteContent = $('<div class=footnote-content></div>')
        footnoteReference.appendTo(footnote);
        anchor.appendTo(footnoteContent);
        footnoteContent.appendTo(footnote);
      }
      footnote.appendTo($('#browse-body'));
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
