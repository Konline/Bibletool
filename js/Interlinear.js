var Interlinear = {
  
  // Get chapters from the server and update the 'interlinear-body' div
  interlinear: function (url) { 
    $('#interlinear-body').empty();
    var jqxhr = $.getJSON(url, function(data) {
      // get the number of versions and verses for easier iteration
      var numOfVersions = data.length;
      var numOfVerses = data[0].verses.length;
      
      // get the book name and chapter number from the first verse
      var bookName = data[0].book;
      var chapterNo = data[0].verses[0].chapter;
      
      // Add the chapter header
      $("<div class=browse-chapter-title>" +
        bookName + " 第 " + chapterNo + " 章" +
        ((data.title == null) ? "" : "：" + data.title) +
        "</div>").appendTo('#interlinear-body');
      
      // Put the chapter body into interlinear-body
      var interlinearTable = $("<table class=interlinear-table></table>");
      interlinearTable.appendTo('#interlinear-body');

      // Put each verse into interlinearTable
      for (var verse=0; verse<numOfVerses; verse++) {
        var interlinearVerseNumber = '<td class="interlinear-verse-number">' + 
          chapterNo + ':' + (verse+1) + "</td>";
        var interlinearVerseGroup = '<td class="interlinear-verse-group">';
        for (var version=0; version<numOfVersions; version++) {
          interlinearVerseGroup += '<span class="interlinear-version">[' +
            data[version].verses[verse].language + ']</span>' +
            data[version].verses[verse].content + '<br>';
        }
        interlinearVerseGroup += '</td>';
        $('<tr class="interlinear-verse">' + interlinearVerseNumber + interlinearVerseGroup + '</tr>')
          .appendTo(interlinearTable);
      }
      // update the browse toolbar with new book and chapters
      Navigation.updateSelectWithBook('book', 'chapter');
      
      // make the current chapter selected
      $("#chapter option:nth-child(" + chapterNo + ")").attr('selected', 'selected');
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#interlinear-body');
      });
  },
  updateToolbarFn:  function(parsedURLFragments) {
    var versions = parsedURLFragments[0];
    var book = parsedURLFragments[1];
    var chapter = parsedURLFragments[2];
    
    $("#version option").removeAttr('selected');
    $.each(versions, function(idx, version) {
      $("#version option[value='" + version +"']").attr('selected', 'selected');
    });
    $("#book option").removeAttr('selected');
    $("#book option[value='" + book +"']").attr('selected', 'selected');
        
    $("#chapter option").removeAttr('selected');
    $("#chapter option[value='" + chapter +"']").attr('selected', 'selected');
  }
}

// Main function
$(document).ready(function() {
  Navigation.currentStyle = 'table';
  Navigation.onChangeFn = Interlinear.interlinear;
  Navigation.updateToolbarFn = Interlinear.updateToolbarFn;
  Navigation.init();
});
