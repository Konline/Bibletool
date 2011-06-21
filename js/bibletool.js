// Global variable action
var action;

// # of chapters in a given book. 0th entry is dummy
var chaptersArray = new Array(0, 50, 40, 27, 36, 34, 24, 21, 4, 31,
                              24, 22, 25, 29, 36, 10, 13, 10, 42, 150,
                              31, 12, 8, 66, 52, 5, 48, 12, 14, 3,
                              9, 1, 4, 7, 3, 3, 3, 2, 14, 4,
                              28, 16, 24, 21, 28, 16, 16, 13, 6, 6,
                              4, 4, 5, 3, 6, 4, 3, 1, 13, 5,
                              5, 3, 5, 1, 1, 1, 22);

// Variable to hold the current style
var currentStyle;

// Function to call whenever there is a change in 
// version, book, or chapter event
var onChangeFn;

// Var to hold the search results
var searchResults;

// Populate a select menu with n chapters
function populateSelect(selectId, n) {
  var select = document.getElementById(selectId);
  for (var i = 1; i <= n; i = i + 1) {
    var option = document.createElement('option');
    option.text = i + ' \u7AE0';
    option.value = i;
    try {
      select.add(option, null);
    } catch (ex) {
      select.add(option);
    };
  };
};

// Toggle the red text
function toggleRedDiv() {
  var allSpans = document.getElementsByTagName('span');
  var toggleImage = document.getElementById('toggle');
  for (var i = 0; i < allSpans.length; i=i+1) {
    var span = allSpans[i];
    if (span.className == 'browse-verse-red') {
      if (span.style.color == 'red') {
        span.style.color = 'black';
        toggleImage.src = webroot + '/images/toggle_red.png';
      } else if (true) {
        span.style.color = 'red';
        toggleImage.src = webroot + '/images/toggle_black.png';
      };
    };
  };
};

// Update the book select menu with book names
function updateSelectWithBook(bookSelectId, chaptersSelectId) {
  var bookSelect = document.getElementById(bookSelectId);
  var bookSelectedIndex = bookSelect.selectedIndex;
  var bookSelectedNumber = bookSelect.options[bookSelectedIndex].value;
  var bookTotalChapters = chaptersArray[bookSelectedNumber];
  $('#'+ chaptersSelectId).empty();
  populateSelect(chaptersSelectId, bookTotalChapters);
};

// Keybinding related functions
function keybinding(e) {
  var evtobj = window.event ? event : e;
  var unicode = evtobj.charCode ? evtobj.charCode : evtobj.keyCode;
  var actualkey = String.fromCharCode(unicode);
  if (actualkey == 'r') {
    toggleRedDiv();
  } else if ((actualkey == 'j' || actualkey == 'd')) {
    rightArrow();
  } else if (actualkey == 'n' || actualkey == 'x') {
    downArrow();
  } else if ((actualkey == 'k' || actualkey == 'a')) {
    leftArrow();
  } else if (actualkey == 'p' || actualkey == 'w') {
    upArrow();
  } else if (actualkey == 't') {
    switch (currentStyle) {
    case 'table':
      currentStyle = 'paragraph';
      break;
    case 'paragraph':
      currentStyle = 'table';
      break;
    default:
      console.log("Unsupported style " + style);
    }
    browse(webroot + 
           '/retrieve/' + selectedVersion() +
           ':' + selectedBook() +
           ':' + selectedChapter());
  } else {
    // do nothing
  };
};

// Return the function that implements the style
function getCurrentStyleFn(style) {
  switch(style) {
  case 'table':
    return tableStyleFn;
    break;
  case 'paragraph':
    return paragraphStyleFn;
    break;
  default:
    console.log("Unsupported style " + style);
  }
}

// Print data in table style
var tableStyleFn = function(data) {
  // get the first entry from data
  var data = data[0];
  
  // get the chapter number from the first verse
  var chapterNo = data.verses[0].chapter;
  
  // Add the chapter header
  $("<div class=browse-chapter-title>" +
    data.book + " 第 " + chapterNo + " 章" +
    ((data.title == null) ? "" : "：" + data.title) +
    "</div>").appendTo('#browse-body');

  // Put the chapter body into browse-body
  var browseTable = $("<div class=browse-table-chapter></div>");
  browseTable.appendTo('#browse-body');

  // Put each verse into browseTable
  $.each(data.verses, function(idx, verse) {
    var verseHeader = '<span class="browse-table-verse-header">' + 
      verse.book + ' ' + verse.chapter + ':' + verse.verse + "</span>";
    var verseSubtitle = verse.subtitle ? '<span class="browse-table-verse-subtitle">' + verse.subtitle + '</span>' : '';
    var verseContent = '<span class="browse-table-verse-content">' + verseSubtitle + ' ' + verse.content + '</span>';
    $('<div class="browse-table-verse">' + verseHeader + verseContent + '</div>').appendTo(browseTable);
  });

  // update the browse toolbar with new book and chapters
  updateSelectWithBook('book', 'chapter');
  
  // make the current chapter selected
  $("#chapter option:nth-child(" + chapterNo + ")").attr('selected', 'selected');
};

// Print data in paragraph
var paragraphStyleFn = function(data) {
  // get the first entry from data
  var data = data[0];
  
  // get the chapter number from the first verse
  var chapterNo = data.verses[0].chapter;
  
  // Add the chapter header
  $("<div class=browse-chapter-title>" +
    data.book + " 第 " + chapterNo + " 章" +
    ((data.title == null) ? "" : "：" + data.title) +
    "</div>").appendTo('#browse-body');

  // Put the chapter body into browse-body
  var browseParagraph = $("<div class=browse-paragraph-chapter></div>");
  browseParagraph.appendTo('#browse-body');

  // Put each verse into browseParagraph
  $.each(data.verses, function(idx, verse) {
    var verseSubtitle = verse.subtitle ? '<div class="browse-paragraph-verse-subtitle">' + verse.subtitle + '</div>' : '';
    var verseNumber = '<span class=' + 
      (verse.subtitle ? 'browse-paragraph-1stverse-number' : 'browse-paragraph-verse-number') +
      '>' + verse.verse + '</span>';
    var verseContent = '<span class="browse-paragraph-verse-content">' + verse.content + '</span>';
    $(verseSubtitle).appendTo(browseParagraph);
    $(verseNumber).appendTo(browseParagraph);
    $(verseContent).appendTo(browseParagraph);
  });
  
  // update the browse toolbar with new book and chapters
  updateSelectWithBook('book', 'chapter');
  
  // make the current chapter selected
  $("#chapter option:nth-child(" + chapterNo + ")").attr('selected', 'selected');
};

// Get a chapter from the server and update the 'browse-body' div
function browse (url) {
  $('#browse-body').empty();
  var jqxhr = $.getJSON(url, getCurrentStyleFn(currentStyle))
    .error(function(){
      $('<p>Failed to download data from the server</p>').appendTo('#browse-body');
    });
};

// Get chapters from the server and update the 'interlinear-body' div
function interlinear (url) { 
  console.log('interlinear: Fetching url ' + url);

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
    updateSelectWithBook('book', 'chapter');
  
    // make the current chapter selected
    $("#chapter option:nth-child(" + chapterNo + ")").attr('selected', 'selected');
  })
    .error(function(){
      $('<p>Failed to download data from the server</p>').appendTo('#interlinear-body');
    });
};

function selectedVersion() {
  // Build a colon ':' separated string of versions
  var versions = $("#version option:selected")
    .map(function() {
      return this.value;
    }).get().join(',');
  return versions;

  // $('#version option:selected').val();
}

function selectedBook() {
  return $('#book option:selected').val();
}

function selectedChapter() {
  return $('#chapter option:selected').val();
}

function upArrow() {
  var book = parseInt(selectedBook());
  if ( book > 1 ) {
    $("#book option:nth-child(" + book + ")").removeAttr('selected');
    $("#book option:nth-child(" + (book-1) + ")").attr('selected', 'selected');
    onChangeFn(webroot + 
               '/retrieve/' + selectedVersion() +
               ':' + selectedBook() +
               ':' + '1');
  }
}

function leftArrow() {
  var chapter = parseInt(selectedChapter());
  if ( chapter > 1 ) {
    $("#chapter option:nth-child(" + chapter + ")").removeAttr('selected');
    $("#chapter option:nth-child(" + (chapter-1) + ")").attr('selected', 'selected');
    onChangeFn(webroot + 
               '/retrieve/' + selectedVersion() +
               ':' + selectedBook() +
               ':' + selectedChapter());
  }
}

function rightArrow() {
  var book = parseInt(selectedBook());
  var chapter = parseInt(selectedChapter());
  if ( chapter < chaptersArray[book] ) {
    $("#chapter option:nth-child(" + chapter + ")").removeAttr('selected');
    $("#chapter option:nth-child(" + (chapter+1) + ")").attr('selected', 'selected');
    onChangeFn(webroot + 
               '/retrieve/' + selectedVersion() +
               ':' + selectedBook() +
               ':' + selectedChapter());
  }
}

function downArrow() {
  var book = parseInt(selectedBook());
  if ( book < 66 ) {
    $("#book option:nth-child(" + book + ")").removeAttr('selected');
    $("#book option:nth-child(" + (book+1) + ")").attr('selected', 'selected');
    onChangeFn(webroot + 
               '/retrieve/' + selectedVersion() +
               ':' + selectedBook() +
               ':' + '1');
  }
}

function paragraphStyle() {
  currentStyle = 'paragraph';
  onChangeFn(webroot + 
             '/retrieve/' + selectedVersion() +
             ':' + selectedBook() +
             ':' + selectedChapter());
}

function generatePaginateDiv(data) {
  return $("<div class='query-paginate'>" +
           "<span class='query-paginate-other-page'>&lt;&lt;</span>" +
           "<span class='query-paginate-current-page'>1</span>&gt;&gt;" +
           "</div>");
}

function processQueryData(data) {
  queryResults = data;
  $("#query-result").empty();
  $("<div class='query-title'>找到 " + queryResults.hits + 
    " 經節 (搜尋時間：" + (queryResults.time/1000) + " 秒)</div>")
    .appendTo("#query-result");
  generatePaginateDiv(data).appendTo("#query-result");
  var browseTableChapter = $("<div class='browse-table-chapter'></div>");
  browseTableChapter.appendTo("#query-result");
  // display the search results
  for (var i=0; i<queryResults.hits; i++) {
    var result = queryResults.verses[i];
    var book = result.book;
    var chapter = result.chapter;
    var verse = result.verse;
    var content = result.content;
    var subtitle = result.subtitle ? "<span class='browse-table-verse-subtitle'>" + result.subtitle + "</span>" : "";
    $("<div class='query-verse'>" +
      "<span class='browse-table-verse-header'>" +
      "<a href=" + webroot + "/browse/UCV:" + book + ":" + 
      chapter + ">" + book + " " + chapter + ":" + verse + "</a>" +
      "</span>" +
      "<span class='browse-table-verse-content'>" +
      subtitle + content + "</span>" +
      "</div>").appendTo(browseTableChapter);
  }
  generatePaginateDiv(data).appendTo("#query-result");
}

function tableStyle() {
  currentStyle = 'table';
  onChangeFn(webroot + 
             '/retrieve/' + selectedVersion() +
             ':' + selectedBook() +
             ':' + selectedChapter());
}

// Main function
$(document).ready(function() {
  // browse and interlinear action are similar, to they are
  // implemented together
  if ( action == 'browse' ||
       action == 'interlinear') {
    // Default style is table
    currentStyle = 'table';
    
    switch (action) {
    case 'interlinear':
      onChangeFn = interlinear;
      break;
    case 'browse':
      onChangeFn = browse;
      break;
    default:
      console.log("Unsupported action: " + action);
    }

    // default URL
    var defaultURLFn = function() { 
      onChangeFn(webroot + '/retrieve/' + 
                 selectedVersion() + ':' + 
                 selectedBook() + ':' + 
                 selectedChapter());
    };
    
    // Add the event call backs
    $("#version").change(defaultURLFn);
    $("#book").change(defaultURLFn);
    $("#chapter").change(defaultURLFn);
    
    // arrow keys
    $("#up-arrow").click(function(){upArrow()});
    $("#left-arrow").click(function(){leftArrow()});
    $("#right-arrow").click(function(){rightArrow()});
    $("#down-arrow").click(function(){downArrow()});
    $("#paragraph-style").click(function(){paragraphStyle()});
    $("#table-style").click(function(){tableStyle()});
    
    // toggle red image
    $("#toggle").click(function(){toggleRedDiv()});
    
    // enable keybinding
    document.onkeypress = keybinding;
    
    // load the default chapter
    defaultURLFn();
  } 

  // Query action
  else if ( action == 'query' ) {
    $("#query-form").submit(function() {
      var version = selectedVersion();
      var queryTerm = $("input[name='query']").val();
      var url = webroot + '/search/' + version + '/q=' + queryTerm;
      var jqxhr = $.getJSON(url, processQueryData)
        .error(function(){
          $('<p>Failed to download data from the server</p>').appendTo('#browse-body');
        });
      
      // prevent the default behavior of submit by returning false
      return false;
    });
  }
});

    

    

