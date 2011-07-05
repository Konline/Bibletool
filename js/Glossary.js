var Glossary = {
  
  // display glossary index
  glossaryIndex: function(stroke) {
    $("#glossary-index-table").empty();
    $("div.glossary").remove();
    var url = webroot + '/glossary/stroke/' + stroke;
    var fn = function(evt) {
      evt.preventDefault();
      var url = $(this.firstChild).attr('href');
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
              webroot + '/browse/UCV:' + 
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
    var jqxhr = $.getJSON(url, function(data) {
      for(var i=0; i<data.length; i=i++) {
        var chinese1 = data[i].chinese;
        var english1 = data[i].english ? ' (' + data[i].english + ')' : "";
        var link1 = $("<td><a href=" + webroot + '/glossary/word/' + 
                      chinese1 + ">" + chinese1 + english1 + "</a></td>");
        i++;
        // check if we have a second link
        var twolinkp = (i<data.length && data[i].chinese) ? true : false;
        var chinese2 = (twolinkp) ? data[i].chinese : "";
        var english2 = (twolinkp && data[i].english) ? ' (' + data[i].english + ')' : "";
        var link2 = (twolinkp) ? 
          $("<td><a href=" + webroot + '/glossary/word/' + 
            chinese2 + ">" + chinese2 + english2 + "</a></td>") : $("<td>&nbsp;</td>");
        var tr = $("<tr></tr>").appendTo("#glossary-index-table");
        link1.click(fn).appendTo(tr);
        if ( twolinkp ) { link2.click(fn).appendTo(tr); }
      }
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#glossary-body');
      })
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
      $("<a>" + stroke + "劃 </a>")
        .click(function() {
          // since this is a closure, rely on the text inside the anchor
          Glossary.glossaryIndex(parseInt(this.text));
        })
        .appendTo($("#by-stroke"));
    }
    for(var i=0; i<alphas.length; i++) {
      var alpha = alphas[i];
      $("<a>" + alpha + "</a>")
        .click(function() {
          // since this is a closure, rely on the text inside the anchor
          Glossary.glossaryIndex(this.text);
        })
        .appendTo($("#by-alpha"));
    }
  })
    .error(function(){
      $('<p>Failed to download data from the server</p>').appendTo('#glossary-body');
    });
  Glossary.glossaryIndex(1);
});
