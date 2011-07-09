// Class implementing the interlinear functionality
var Interlinear = {
  
  // Get chapters from the server and update the 'interlinear-body'
  // div
  // Parameters:
  // - url: URL representing the JSON data from the server
  interlinear: function (url) { 
    $('#interlinear-body').empty();
    var jqxhr = $.getJSON(url, function(data) {
      // data looks like this:
      // [{"book":"\u5275\u4e16\u8a18",
      //   "title":"\u795e\u9020\u5929\u5730",
      //   "verses":
      //   [{"language":"UCV"
      //     "name":"\u5275"
      //     "book":"1"
      //     "chapter":"1"
      //     "verse":"1"
      //     "subtitle":"\u3010\u3000\u795e\u5275\u9020\u5929\u5730\u3011"
      //     "content":"\u8d77\u521d\u3000\u795e\u5275\u9020\u5929\u5730\u3002"},
      //    (... other verses in this range ...)
      //   ]
      //  },
      //  {"book":"Genesis",
      //   "title":null,
      //   "verses":
      //   [{"language":"KJV"
      //     "name":"GEN"
      //     "book":"1"
      //     "chapter":"1"
      //     "verse":"1"
      //     "subtitle":""
      //     "content":"In the beginning God created the heaven and the earth."},
      //    (... other verses in this range ...)
      //   ]
      //  }]
      
      // get the number of versions and verses for easier iteration
      var numOfVersions = data.length;
      var numOfVerses = data[0].verses.length;
      
      // get the book name and chapter number from the first verse
      var bookName = data[0].book;
      var chapterNo = data[0].verses[0].chapter;
      
      // Add the chapter header, which looks like this:
      // <div class="browse-chapter-title">創世記 第 1 章：神造天地</div>
      $("<div class=browse-chapter-title>" +
        bookName + " 第 " + chapterNo + " 章" +
        ((data.title == null) ? "" : "：" + data.title) +
        "</div>").appendTo('#interlinear-body');
      
      // Put the chapter body into interlinear-body
      // Chapter body is implemented as a table
      var interlinearTable = $("<table class=interlinear-table></table>");
      interlinearTable.appendTo('#interlinear-body');

      // Put each verse into interlinearTable
      for (var verse=0; verse<numOfVerses; verse++) {
        // Each verse is implemented as a table row, that looks like
        // this:
        // <tr class="interlinear-verse">
        //   <td class="interlinear-verse-number">1:1</td>
        //   <td class="interlinear-verse-group">
        //     <span class="interlinear-version">[UCV]</span>起初　神創造天地。<br>
        //   </td>
        // </tr>
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

  // Update the navigation tool bar to reflect the current version,
  // book, and chapter
  // This function is not included in Navigation.js because navigation
  // toolbar between 'browse' and 'interlinear' are different
  // (e.g. interlinear allows multiple bible versions to be chosen,
  // while browse does not)
  // Parameters:
  // - parsedURLFragments: A 3-entry array that looks like:
  //     [[version1,...,versionN], book, chapter]
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
