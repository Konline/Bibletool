// Glossary class
var Glossary = {
  // Display all the glossaries that have the same number of strokes
  // in Chinese
  // Parameters:
  // - stroke: integer representing # of strokes
  glossaryIndex: function(stroke) {
    $("#glossary-index-table").empty();
    $("div.glossary").remove();
    var url = webroot + '/glossary/stroke/' + stroke;
    var jqxhr = $.getJSON(url, function(data) {
      for(var i=0; i<data.length; i++) {
        // Populate the table "#glossary-index-table" with the
        // information found in 'data'
        // Table is hardcoded to be 2 columns. Each row in the table
        // looks like this:
        // <tr>
        //   <td>
        //     <a href="#word/%E4%B8%80%E6%8C%87">一指 (Finger)</a>
        //   </td>
        //   <td>
        //     <a href="#word/%E4%B8%80%E6%8E%8C">一掌 (Handbreadth)</a>
        //   </td>
        // </tr>
        var chinese1 = data[i].chinese;
        var english1 = data[i].english ? ' (' + data[i].english + ')' : "";
        var link1 = $("<td><a href=#word/" + encodeURI(chinese1) + 
                      ">" + chinese1 + english1 + "</a></td>");
        i++;
        // check if we have a second link
        var twolinkp = (i<data.length && data[i].chinese) ? true : false;
        var chinese2 = (twolinkp) ? data[i].chinese : "";
        var english2 = (twolinkp && data[i].english) ? ' (' + data[i].english + ')' : "";
        var link2 = (twolinkp) ? 
          $("<td><a href=#word/" + encodeURI(chinese2) +
            ">" + chinese2 + english2 + "</a></td>") : $("<td>&nbsp;</td>");
        var tr = $("<tr></tr>").appendTo("#glossary-index-table");
        link1.appendTo(tr);
        if ( twolinkp ) { link2.appendTo(tr); }
      }
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#glossary-body');
      })
  },

  // Given a glossary word, display the definition for the word
  // Parameters:
  // - word: string (in Chinese) representing the glossary word
  glossaryWord: function(word) {
    var url = webroot + '/glossary/word/' + encodeURI(word);
    $("#glossary-index-table").empty();
    var jqxhr = $.getJSON(url, function(data) {
      // Each entry in the data array looks like this:
      // { "strokes":"1",
      //   "chinese":"\u4e00\u6307",
      //   "english":"Finger",
      //   "definition":"",
      //   "notes":["note1"],
      //   "verses":[["24","52","21","21"]]
      // }
      for (var i=0; i<data.length; i++) {
        var word = data[i];
        // Build a div that looks like this:
        // <div class="glossary">
        //   <div class="glossary-name">一指 (Finger)</div>
        //   <a href="/browse#UCV:24:52:21">耶 52:21</a>
        //   <div class="glossary-definition">
        //   </div>
        //   <div class="glossary-notes">聖經中的長度單位，合 1.85 公分；0.72 英寸。</div>
        // </div>
        var glossary = $("<div class=glossary>");
        
        // word name
        $("<div class=glossary-name>" + 
          word.chinese + 
          (word.english ? ' (' + word.english + ')' : "") +
          "</div>").appendTo(glossary);
          
        // verses
        var links = $.map(word.verses, function(v, idx) {
          var book = v[0];
          var name = book2CNabbrev[book];
          var chapter = v[1];
          var start = v[2];
          var end = v[3];
          var link = '<a href=' + 
            webroot + '/browse#UCV:' + 
            book + ':' + chapter + ':' + start +
            (start == end ? "" : '-' + end) +
            '>' + name + ' ' + chapter + ':' +
            start + (start==end ? '' : '-' + end) +
            '</a>';
          return link;
        }).join(" ");
        $(links).appendTo(glossary);
          
        // word definition
        $("<div class=glossary-definition>" + 
          word.definition +
          "</div>").appendTo(glossary);
        
        // word notes
        $("<div class=glossary-notes>" + 
          word.notes +
          "</div>").appendTo(glossary);
        
        glossary.appendTo("#glossary-body");
      }
    });
  }
};


// Main function
$(document).ready(function() {
  // populate by-stroke and by-alpha td's
  var url = webroot + '/glossary/index';
  var jqxhr = $.getJSON(url, function(data) {
    // data is a 2-element array of arrays that looks like this:
    // [["1","2","3",...],
    //  ["A","B","C",...]]
    var strokes = data[0];
    var alphas = data[1];
    for(var i=0; i<strokes.length; i++) {
      var stroke = strokes[i];
      $("<a href=#stroke/" + stroke + ">" + stroke + "劃 </a>")
        .appendTo($("#by-stroke"));
    }
    for(var i=0; i<alphas.length; i++) {
      var alpha = alphas[i];
      $("<a href=#stroke/" + alpha + ">" + alpha + "</a>")
        .appendTo($("#by-alpha"));
    }
  })
    .error(function(){
      $('<p>Failed to download data from the server</p>').appendTo('#glossary-body');
    });
  
  // use URL hash to implement Ajax bookmarking
  $(window).bind( 'hashchange', function(e) {
    // the URL is the string after the hash mark, called the
    // 'fragment' below. There are few possibilities:
    // 1. No fragments
    //    Default to showing the index for words with stroke=1
    // 2. #strokes/10, or #strokes/Z
    //    Display the words with stroke=10, or with english names
    //    starting with 'Z'
    // 3. #word/foo <-- foo is in Chinese
    //    Display the definition for the word 'foo'
    // 4. Everything else is undefined
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
      // unrecognized hash
      console.log('Unsupported hash string: ' + fragment);
    }
  });

  // Bind ajaxSend and ajaxComplete events
  $("#glossary-body")
    .ajaxSend(function() {
      $(ajaxLoader).appendTo(this);
    })
    .ajaxComplete(function() {
      $(ajaxLoader).remove();
    });

  // trigger the hashchange by default
  $(window).trigger( 'hashchange' );
});
