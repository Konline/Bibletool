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
  default:
    console.log("Unsupported style " + style);
  }
}

// Print data in table style
var tableStyleFn = function(data) {
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
};

// Get a chapter from the server and update the 'browse-body' div
function getChapter(version, book, chapter) {
  var url = webroot + '/get_verses/' + version + '/' + book + '/' + chapter;
  $('#browse-body').empty();
  var jqxhr = $.getJSON(url, getCurrentStyleFn(currentStyle))
    .complete(function() {
      // update the browse toolbar with new book and chapters
      updateSelectWithBook('book', 'chapter');
      // make the current chapter selected
      $("#chapter option:nth-child(" + chapter + ")").attr('selected', 'selected');
    })
    .error(function(){
      $('<p>Failed to get chapter information from the server</p>').appendTo('#browse-body');
    });
};

function selectedVersion() {
  return $('#version option:selected').val();
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
    getChapter(selectedVersion(),
               selectedBook(),
               1);
  }
}

function leftArrow() {
  var chapter = parseInt(selectedChapter());
  if ( chapter > 1 ) {
    $("#chapter option:nth-child(" + chapter + ")").removeAttr('selected');
    $("#chapter option:nth-child(" + (chapter-1) + ")").attr('selected', 'selected');
    getChapter(selectedVersion(),
               selectedBook(),
               selectedChapter());
  }
}

function rightArrow() {
  var book = parseInt(selectedBook());
  var chapter = parseInt(selectedChapter());
  if ( chapter < chaptersArray[book] ) {
    $("#chapter option:nth-child(" + chapter + ")").removeAttr('selected');
    $("#chapter option:nth-child(" + (chapter+1) + ")").attr('selected', 'selected');
    getChapter(selectedVersion(),
               selectedBook(),
               selectedChapter());
  }
}

function downArrow() {
  var book = parseInt(selectedBook());
  if ( book < 66 ) {
    $("#book option:nth-child(" + book + ")").removeAttr('selected');
    $("#book option:nth-child(" + (book+1) + ")").attr('selected', 'selected');
    getChapter(selectedVersion(),
               selectedBook(),
               1);
  }
}

function paragraphStyle() {
  console.log("paragraph style");
}

function tableStyle() {
  console.log("Table style");
}

// Main function
$(document).ready(function() {
  // enable keybinding
  document.onkeypress = keybinding;
  
  // Use the presence of the version select to tell if we are in
  // browse mode
  if ( $('#version').length > 0) {
    // Default style is table
    currentStyle = 'table';
    
    // fetch Genesis 1:1
    getChapter('UCV', 1, 1);
    
    // add on-change events to select menus
    var selectOnChangeEvt = function() {
      getChapter(selectedVersion(),
                 selectedBook(),
                 selectedChapter());
    }
    $("#version").change(selectOnChangeEvt);
    $("#book").change(selectOnChangeEvt);
    $("#chapter").change(selectOnChangeEvt);

    // arrow keys
    $("#up-arrow").click(function(){upArrow()});
    $("#left-arrow").click(function(){leftArrow()});
    $("#right-arrow").click(function(){rightArrow()});
    $("#down-arrow").click(function(){downArrow()});
    $("#paragraph-style").click(function(){paragraphStyle()});
    $("#table-style").click(function(){tableStyle()});
    
    // toggle red image
    $("#toggle").click(function(){toggleRedDiv()});
  }
});

