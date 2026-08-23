// Glossary class
var Glossary = {
  // Display all the glossaries that have the same number of strokes or letter
  // Parameters:
  // - stroke: integer or string (e.g. 10 or 'Z')
  glossaryIndex: function(stroke) {
    $("#glossary-word-container").empty().addClass("hidden");
    $("#glossary-index-table").empty();
    $("#glossary-index-container").removeClass("hidden");

    var isAlpha = isNaN(parseInt(stroke, 10));
    var headerText = isAlpha ? stroke + " 開頭的詞彙" : stroke + " 劃的詞彙";
    $("#glossary-index-header").text(headerText).removeClass("hidden");

    var url = webroot + '/glossary/stroke/' + encodeURI(stroke);
    var jqxhr = $.getJSON(url, function(data) {
      for(var i=0; i<data.length; i++) {
        var chinese = data[i].chinese;
        var english = data[i].english ? ' (' + data[i].english + ')' : "";
        var item = $('<a href="#word/' + encodeURI(chinese) + '" class="glossary-index-item block p-3 rounded-lg bg-amber-50/80 dark:bg-slate-800/80 border border-amber-200/80 dark:border-slate-700 hover:bg-amber-100 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-100 font-medium text-center transition-colors shadow-xs hover:shadow-sm truncate">' + chinese + english + '</a>');
        item.appendTo("#glossary-index-table");
      }
    })
    .error(function(){
      $('<p class="text-red-500 text-center my-4">Failed to download data from the server</p>').appendTo('#glossary-body');
    });
  },

  // Given a glossary word, display the definition for the word
  // Parameters:
  // - word: string (in Chinese) representing the glossary word
  glossaryWord: function(word) {
    var url = webroot + '/glossary/word/' + encodeURI(word);
    $("#glossary-index-container").addClass("hidden");
    $("#glossary-index-header").addClass("hidden");
    $("#glossary-word-container").empty().removeClass("hidden");

    var jqxhr = $.getJSON(url, function(data) {
      for (var i=0; i<data.length; i++) {
        var item = data[i];
        var card = $('<div class="glossary-card bg-white/90 dark:bg-slate-900 border border-amber-200/80 dark:border-slate-800 rounded-xl p-5 sm:p-6 shadow-sm space-y-4"></div>');

        // Word name
        $('<div class="glossary-name text-2xl font-bold text-amber-950 dark:text-amber-300 pb-3 border-b border-amber-200/60 dark:border-slate-800 flex flex-wrap items-baseline gap-2">' +
          item.chinese +
          (item.english ? '<span class="text-base font-normal text-slate-600 dark:text-slate-400">(' + item.english + ')</span>' : "") +
          '</div>').appendTo(card);

        // Verses section
        if (item.verses && item.verses.length > 0) {
          var versesWrapper = $('<div class="glossary-verses-container space-y-2"><div class="text-xs font-semibold uppercase tracking-wider text-amber-800 dark:text-amber-400">相關經節：</div></div>');
          var versesFlex = $('<div class="flex flex-wrap gap-1.5"></div>');

          $.each(item.verses, function(idx, v) {
            var book = v[0];
            var name = book2CNabbrev[book] || book;
            var chapter = v[1];
            var start = v[2];
            var end = v[3];
            var verseText = name + ' ' + chapter + ':' + start + (start == end ? '' : '-' + end);
            var href = webroot + '/browse#UCV:' + book + ':' + chapter + ':' + start + (start == end ? '' : '-' + end);

            $('<a href="' + href + '" class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-amber-100/80 dark:bg-slate-800 text-amber-900 dark:text-amber-200 border border-amber-300/70 dark:border-slate-700 hover:bg-amber-200 dark:hover:bg-slate-700 transition-colors shadow-2xs">' + verseText + '</a>').appendTo(versesFlex);
          });

          versesFlex.appendTo(versesWrapper);
          versesWrapper.appendTo(card);
        }

        // Definition
        if (item.definition) {
          $('<div class="glossary-definition pt-2 text-base sm:text-lg text-slate-800 dark:text-slate-100 leading-relaxed space-y-2">' +
            item.definition +
            '</div>').appendTo(card);
        }

        // Notes
        if (item.notes && item.notes.length > 0 && item.notes[0] !== "") {
          $('<div class="glossary-notes pt-3 text-sm text-slate-600 dark:text-slate-400 border-t border-amber-200/60 dark:border-slate-800 space-y-1"><span class="font-semibold text-amber-900 dark:text-amber-300">備註：</span>' +
            item.notes +
            '</div>').appendTo(card);
        }

        card.appendTo("#glossary-word-container");
      }
    })
    .error(function(){
      $('<p class="text-red-500 text-center my-4">Failed to download data from the server</p>').appendTo('#glossary-word-container');
    });
  }
};


// Main function
$(document).ready(function() {
  // populate by-stroke and by-alpha
  var url = webroot + '/glossary/index';
  var jqxhr = $.getJSON(url, function(data) {
    var strokes = data[0];
    var alphas = data[1];

    var strokeTarget = $("#by-stroke-list").length ? $("#by-stroke-list") : $("#by-stroke");
    var alphaTarget = $("#by-alpha-list").length ? $("#by-alpha-list") : $("#by-alpha");

    strokeTarget.empty();
    alphaTarget.empty();

    for(var i=0; i<strokes.length; i++) {
      var stroke = strokes[i];
      $('<a href="#stroke/' + stroke + '" class="glossary-chip inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs sm:text-sm font-semibold bg-white dark:bg-slate-800 border border-amber-300 dark:border-slate-700 hover:bg-amber-100 dark:hover:bg-slate-700 text-amber-900 dark:text-amber-200 shadow-2xs hover:shadow-xs transition-colors whitespace-nowrap">' + stroke + '劃</a>')
        .appendTo(strokeTarget);
    }
    for(var i=0; i<alphas.length; i++) {
      var alpha = alphas[i];
      $('<a href="#stroke/' + alpha + '" class="glossary-chip inline-flex items-center justify-center min-w-[2.25rem] px-2 py-1 rounded-md text-xs sm:text-sm font-semibold bg-white dark:bg-slate-800 border border-amber-300 dark:border-slate-700 hover:bg-amber-100 dark:hover:bg-slate-700 text-amber-900 dark:text-amber-200 shadow-2xs hover:shadow-xs transition-colors whitespace-nowrap">' + alpha + '</a>')
        .appendTo(alphaTarget);
    }
  })
  .error(function(){
    $('<p class="text-red-500 text-center my-4">Failed to download data from the server</p>').appendTo('#glossary-body');
  });

  // use URL hash to implement Ajax bookmarking
  $(window).bind( 'hashchange', function(e) {
    var fragment = $.param.fragment();
    if ( fragment == "" ) {
      window.location.hash = 'stroke/' + 1;
    } else if ( fragment.match(/^stroke/) ) {
      var stroke = fragment.match(/^stroke\/(\S+)/)[1];
      Glossary.glossaryIndex(stroke);
    } else if ( fragment.match(/^word/) ) {
      var word = fragment.match(/^word\/(\S+)/)[1];
      Glossary.glossaryWord(word);
    } else {
      console.log('Unsupported hash string: ' + fragment);
    }
  });

  // Bind ajaxSend and ajaxComplete events
  $("#glossary-body")
    .ajaxSend(function() {
      if ($(".ajax-loader").length === 0) {
        $(ajaxLoader).appendTo("#glossary-body");
      }
    })
    .ajaxComplete(function() {
      $(".ajax-loader").remove();
    });

  // trigger the hashchange by default
  $(window).trigger( 'hashchange' );
});

