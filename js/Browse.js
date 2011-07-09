// Browse class
var Browse = {
  // Fetch JSON from server and format data to the browser
  // Since the actual formatting is style dependent (ie. 'table'
  // format, 'paragraph' format, etc...), we rely on
  // Navigation.getCurrentStyle() to return the function used to
  // format the data. After the bible data is properly displayed, we
  // call on Browse.glossary() to display the glossary footnote
  // Parameters:
  // - url: A string representing the url that will return the JSON data
  browse: function (url) {
    $('#browse-body').empty();
    var jqxhr = $.getJSON(url, Navigation.getCurrentStyleFn(url))
      .complete(function(){Browse.glossary(url)})
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#browse-body');
      });
  },
  
  // Add glossary foot note once the main body is displayed
  // Parameters:
  // - url: A string representing the url that will return the JSON data
  glossary: function(url) {
    var url = url.replace('retrieve', 'glossary/retrieve');
    var jqxhr = $.getJSON(url, function(data) {
      // data is a JSON array that represents the glossary footnotes
      // Convert 'data' into a <div> that looks like this
      // <div class="footnote">
      //   <div class="footnote-reference">1:1</div>
      //   <div class="footnote-content">
      //     <a href="/glossary#word/%E4%B8%8A%E5%B8%9D">上帝</a>
      //   </div>
      //   [... other footnotes ...]
      // </div>
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
        var link = webroot + '/glossary#word/' + encodeURI(chinese);
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

  // Update the navigation tool bar to reflect the current version,
  // book, and chapter
  // This function is not included in Navigation.js because navigation
  // toolbar between 'browse' and 'interlinear' are different
  // (e.g. interlinear allows multiple bible versions to be chosen,
  // while browse does not)
  // Parameters:
  // - parsedURLFragments: A 3-entry array that looks like:
  //     [[version1,...,versionN], book, chapter]
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
