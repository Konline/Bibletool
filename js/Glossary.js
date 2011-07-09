var Glossary = {
  // display glossary index
  glossaryIndex: function(stroke) {
    $("#glossary-index-table").empty();
    $("div.glossary").remove();
    var url = webroot + '/glossary/stroke/' + stroke;
    var jqxhr = $.getJSON(url, function(data) {
      for(var i=0; i<data.length; i=i++) {
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
  
  glossaryWord: function(word) {
    var url = webroot + '/glossary/word/' + encodeURI(word);
    $("#glossary-index-table").empty();
    var jqxhr = $.getJSON(url, function(data) {
      for (var i=0; i<data.length; i++) {
        var word = data[i];
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
    // 'fragment' below. If nothing is provided, default to UCV:1:1
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
  // trigger the hashchange by default
  $(window).trigger( 'hashchange' );
  
});
