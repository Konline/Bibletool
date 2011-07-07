// Navigation class encapsulates common functionalities
// used in browse and interlinear
var Navigation = {
  
  // Variable to hold the current style
  currentStyle: null,
  
  // Function to call whenever user changes the URL
  onChangeFn: null,

  // Function to call to update the toolbar
  updateToolbarFn: null,

  // parse URL fragment and return [[version1,..,versionN], book, chapter]
  parseURLFragment: function(fragment) {
    // only look at the first range of the fragment
    // ranges are delimited by ';'
    var tokens = fragment.split(';')[0].split(':');
    if ( tokens.length == 1 ) {
      // invalid URL, default to UCV:1:1
      return [["UCV"], 1, 1];
    } else if ( tokens.length == 2) {
      // GEN:1 or 1:1
      var book = isNaN(tokens[0]) ? 
        book2ENabbrev.findIndex(tokens[0]) : parseInt(tokens[0]);
      var chapter = parseInt(tokens[1]);
      return [["UCV"], book, chapter];
    } else if ( tokens.length == 3) {
      // language:book:chapter, or
      //    UCV:GEN:1
      //    UCV:  1:1
      // book:chapter:verses
      //    GEN:  1:1
      //      1:  1:1
      if ( !isNaN(tokens[0]) ||
           (isNaN(tokens[0]) && 
            book2ENabbrev.findIndex(tokens[0]) != "")) {
        var book = isNaN(tokens[0]) ? 
          book2ENabbrev.findIndex(tokens[0]) : parseInt(tokens[0]);
        var chapter = parseInt(tokens[1]);
        return [["UCV"], book, chapter];
      } else {
        var versions = tokens[0].split(',');
        var book = isNaN(tokens[1]) ? 
          book2ENabbrev.findIndex(tokens[1]) : parseInt(tokens[1]);
        var chapter = parseInt(tokens[2]);
        return [versions, book, chapter];
      }
    } else if ( tokens.length == 4 ) {
      // language:book:chapter:verses
      if ( !isNaN(tokens[0]) ||
           (isNaN(tokens[0]) && 
            book2ENabbrev.findIndex(tokens[0]) != "")) {
        var book = isNaN(tokens[0]) ? 
          book2ENabbrev.findIndex(tokens[0]) : parseInt(tokens[0]);
        var chapter = parseInt(tokens[1]);
        return [["UCV"], book, chapter];
      } else {
        var versions = tokens[0].split(',');
        var book = isNaN(tokens[1]) ? 
          book2ENabbrev.findIndex(tokens[1]) : parseInt(tokens[1]);
        var chapter = parseInt(tokens[2]);
        return [versions, book, chapter];
      } 
    } else {
      // invalid URL, default to UCV:1:1
      return [["UCV"], 1, 1];
    }
  },
  
  // Initialize buttons with callbacks
  init: function() {
    var defaultURLFn = function(id) {
      if ( id == 'book' ) {
        // changing book reset the chapter
        window.location.hash = Navigation.selectedVersion() +
          ':' + Navigation.selectedBook() + ':' + '1';
      } else {
        window.location.hash = Navigation.selectedVersion() +
          ':' + Navigation.selectedBook() + ':' + Navigation.selectedChapter();
      }
    };
    
    // use URL hash to implement Ajax bookmarking
    $(window).bind( 'hashchange', function(e) {
      // the URL is the string after the hash mark, called the
      // 'fragment' below. If nothing is provided, default to UCV:1:1
      var fragment = $.param.fragment();
      if ( fragment == "" ) {
        fragment = 'UCV:1:1';
        window.location.hash = fragment;
      } else {
        Navigation.onChangeFn(webroot + '/retrieve/' + fragment);
        Navigation.updateToolbarFn(Navigation.parseURLFragment(fragment));
      }
    });

    // Add the event call backs
    $("#version").change(function(){defaultURLFn('version')});
    $("#book").change(function(){defaultURLFn('book')});
    $("#chapter").change(function(){defaultURLFn('chapter')});
    
    // arrow keys
    $("#up-arrow").click(function(){Navigation.upArrow()});
    $("#left-arrow").click(function(){Navigation.leftArrow()});
    $("#right-arrow").click(function(){Navigation.rightArrow()});
    $("#down-arrow").click(function(){Navigation.downArrow()});
    $("#paragraph-style").click(function(){Navigation.paragraphStyle()});
    $("#table-style").click(function(){Navigation.tableStyle()});
    
    // toggle red image
    $("#toggle").click(function(){Navigation.toggleRedDiv()});
    
    // enable keybinding
    document.onkeypress = Navigation.keybinding;
    
    // trigger the hashchange by default
    $(window).trigger( 'hashchange' );
  },

  // Populate a select menu with n chapters
  populateSelect: function(selectId, n) {
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
  },
  
  // Toggle the red text
  toggleRedDiv: function() {
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
  },

  // Update the book select menu with book names
  updateSelectWithBook: function(bookSelectId, chaptersSelectId) {
    var bookSelect = document.getElementById(bookSelectId);
    var bookSelectedIndex = bookSelect.selectedIndex;
    var bookSelectedNumber = bookSelect.options[bookSelectedIndex].value;
    var bookTotalChapters = chaptersArray[bookSelectedNumber];
    $('#'+ chaptersSelectId).empty();
    Navigation.populateSelect(chaptersSelectId, bookTotalChapters);
  },

  // Keybinding related functions
  keybinding: function(e) {
    var evtobj = window.event ? event : e;
    var unicode = evtobj.charCode ? evtobj.charCode : evtobj.keyCode;
    var actualkey = String.fromCharCode(unicode);
    if (actualkey == 'r') {
      Navigation.toggleRedDiv();
    } else if ((actualkey == 'j' || actualkey == 'd')) {
      Navigation.rightArrow();
    } else if (actualkey == 'n' || actualkey == 'x') {
      Navigation.downArrow();
    } else if ((actualkey == 'k' || actualkey == 'a')) {
      Navigation.leftArrow();
    } else if (actualkey == 'p' || actualkey == 'w') {
      Navigation.upArrow();
    } else if (actualkey == 't') {
      switch (Navigation.currentStyle) {
      case 'table':
        Navigation.currentStyle = 'paragraph';
        break;
      case 'paragraph':
        Navigation.currentStyle = 'table';
        break;
      default:
        console.log("Unsupported style: " + style);
      }
      $(window).trigger( 'hashchange' );
    } else {
      // do nothing
    };
  },

  // Return the function that implements the style
  // Since the 'browse' api is overloaded for many purposes, we need to
  // look at the url pattern to understand if we are dealing with an
  // entire chapter or just few bible fragments
  getCurrentStyleFn: function(url) {
    return url.match(/;/) ? Navigation.rangeStyleFn :
      url.split(":").length > 3 ? Navigation.rangeStyleFn :
      Navigation.currentStyle == 'table' ? Navigation.tableStyleFn :
      Navigation.currentStyle == 'paragraph' ? Navigation.paragraphStyleFn :
      console.log("Unsupported style: " + Navigation.currentStyle);
  },

  // Print range data in table style
  rangeStyleFn: function(data) {
    for(var i=0; i<data.length; i++) {
      // Put the chapter body into browse-body
      var browseTable = $("<div class=retrieve-range></div>");
      browseTable.appendTo('#browse-body');
      
      // Put each verse into browseTable
      $.each(data[i].verses, function(idx, verse) {
        var book = verse.book;
        var chapter = verse.chapter;
        var name = verse.name;
        var number = verse.verse;
        var verseHeader = '<span class="browse-table-verse-header">' + 
          "<a href=" + webroot + "/browse#UCV:" + book + ":" + 
          chapter + ">" + name + " " + chapter + ":" + number + "</a>" +
          "</span>";
        var verseSubtitle = verse.subtitle ? 
          '<span class="browse-table-verse-subtitle">' + 
          verse.subtitle + '</span>' : '';
        var verseContent = '<span class="browse-table-verse-content">' + 
          verseSubtitle + ' ' + verse.content + '</span>';
        $('<div class="browse-table-verse">' + verseHeader + 
          verseContent + '</div>').appendTo(browseTable);
      });
    }
  },

  // Add audio bible to browse-body
  addAudioBible: function() {
    var version = Navigation.selectedVersion();
    var book = Navigation.selectedBook();
    var chapter = Navigation.selectedChapter();
    var padleft = function (val, ch, num) {
      var re = new RegExp(".{" + num + "}$");
      var pad = "";
      if (!ch) ch = " ";
      do  {
        pad += ch;
      }while(pad.length < num);
      return re.exec(pad + val)[0];
    }

    if ( version == 'UCV' || version == 'KJV') {
      var link = 'http://konline.org/bibletool/audiobible/' +
        version + "/" + 
        padleft(book, '0', 2) + '_' + 
        book2ENabbrev[book] + '_' +
        padleft(chapter, '0', 3) + '.mp3';
      $('<div CLASS=browse-chapter-audio>' +
        '<a HREF=' + link + 
        '>Audio version for this chapter</a></div>')
        .appendTo('#browse-body');
      // trigger anarchy media
      Anarchy.Mp3.go();
    }
  },
  
  // Print data in table style
  tableStyleFn: function(data) {
    // get the first entry from data
    var data = data[0];
    
    // get the chapter number from the first verse
    var chapterNo = data.verses[0].chapter;
    
    // Add the chapter header
    $("<div class=browse-chapter-title>" +
      data.book + " 第 " + chapterNo + " 章" +
      ((data.title == null) ? "" : "：" + data.title) +
      "</div>").appendTo('#browse-body');

    // Audio bible
    Navigation.addAudioBible();

    // Put the chapter body into browse-body
    var browseTable = $("<div class=browse-table-chapter></div>");
    browseTable.appendTo('#browse-body');

    // Put each verse into browseTable
    $.each(data.verses, function(idx, verse) {
      var verseHeader = '<span class="browse-table-verse-header">' + 
        verse.name + ' ' + verse.chapter + ':' + verse.verse + "</span>";
      var verseSubtitle = verse.subtitle ? 
        '<span class="browse-table-verse-subtitle">' + verse.subtitle + 
        '</span>' : '';
      var verseContent = '<span class="browse-table-verse-content">' + 
        verseSubtitle + ' ' + verse.content + '</span>';
      $('<div class="browse-table-verse">' + verseHeader + 
        verseContent + '</div>').appendTo(browseTable);
    });
  },

  // Print data in paragraph
  paragraphStyleFn: function(data) {
    // get the first entry from data
    var data = data[0];
    
    // get the chapter number from the first verse
    var chapterNo = data.verses[0].chapter;
    
    // Add the chapter header
    $("<div class=browse-chapter-title>" +
      data.book + " 第 " + chapterNo + " 章" +
      ((data.title == null) ? "" : "：" + data.title) +
      "</div>").appendTo('#browse-body');

    // Audio bible
    Navigation.addAudioBible();

    // Put the chapter body into browse-body
    var browseParagraph = $("<div class=browse-paragraph-chapter></div>");
    browseParagraph.appendTo('#browse-body');

    // Put each verse into browseParagraph
    $.each(data.verses, function(idx, verse) {
      var verseSubtitle = verse.subtitle ?
        '<div class="browse-paragraph-verse-subtitle">' + 
        verse.subtitle + '</div>' : '';
      var verseNumber = '<span class=' + 
        (verse.subtitle ? 'browse-paragraph-1stverse-number' :
         'browse-paragraph-verse-number') +
        '>' + verse.verse + '</span>';
      var verseContent = '<span class="browse-paragraph-verse-content">' +
        verse.content + '</span>';
      $(verseSubtitle).appendTo(browseParagraph);
      $(verseNumber).appendTo(browseParagraph);
      $(verseContent).appendTo(browseParagraph);
    });
  },

  selectedVersion: function() {
    // Build a colon ':' separated string of versions
    var versions = $("#version option:selected")
      .map(function() {
        return this.value;
      }).get().join(',');
    return versions;
  },

  selectedBook: function() {
    return $('#book option:selected').val();
  },

  selectedChapter: function() {
    return $('#chapter option:selected').val();
  },

  upArrow: function() {
    var book = parseInt(Navigation.selectedBook());
    if ( book > 1 ) {
      window.location.hash = Navigation.selectedVersion() +
        ':' + (book-1) + ':' + '1';
    }
  },

  leftArrow: function() {
    var chapter = parseInt(Navigation.selectedChapter());
    if ( chapter > 1 ) {
      window.location.hash = Navigation.selectedVersion() +
        ':' + Navigation.selectedBook() + ':' + (chapter-1);
    }
  },

  rightArrow: function() {
    var book = parseInt(Navigation.selectedBook());
    var chapter = parseInt(Navigation.selectedChapter());
    if ( chapter < chaptersArray[book] ) {
      window.location.hash = Navigation.selectedVersion() +
        ':' + Navigation.selectedBook() + ':' + (chapter+1);
    }
  },

  downArrow: function() {
    var book = parseInt(Navigation.selectedBook());
    if ( book < 66 ) {
      window.location.hash = Navigation.selectedVersion() +
        ':' + (book+1) + ':' + '1';
    }
  },

  paragraphStyle: function() {
    Navigation.currentStyle = 'paragraph';
    $(window).trigger( 'hashchange' );
  },

  tableStyle: function() {
    Navigation.currentStyle = 'table';
    $(window).trigger( 'hashchange' );
  },
};

