var Query = {
  // results per page (this is a constant set in the backend)
  // cannot be changed in the front end
  resultsPerPage: 20,
  
  // Query function, given an URL
  query: function (url) {
    $("#query-result").empty();
    var jqxhr = $.getJSON(url, Query.processQueryData)
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#query-result');
      });
  },
  
  processQueryData: function(data) {
    $("<div class='query-title'>找到 " + data.hits + 
      " 經節 (搜尋時間：" + (Math.round(data.time)/1000) + " 秒)</div>")
      .appendTo("#query-result");
    Query.generatePaginateDiv(data).appendTo("#query-result");
    var browseTableChapter = $("<div class='browse-table-chapter'></div>");
    browseTableChapter.appendTo("#query-result");
    // display the search results
    for (var i=0; i<Query.resultsPerPage; i++) {
      var result = data.verses[i];
      if (!result) {
        continue;
      }
      var name = result.name;
      var book = result.book;
      var chapter = result.chapter;
      var verse = result.verse;
      var content = result.content;
      var subtitle = result.subtitle ? "<span class='browse-table-verse-subtitle'>" + result.subtitle + "</span>" : "";
      $("<div class='query-verse'>" +
        "<span class='browse-table-verse-header'>" +
        "<a href=" + webroot + "/browse/UCV:" + book + ":" + 
        chapter + ">" + name + " " + chapter + ":" + verse + "</a>" +
        "</span>" +
        "<span class='browse-table-verse-content'>" +
        subtitle + content + "</span>" +
        "</div>").appendTo(browseTableChapter);
    }
    Query.generatePaginateDiv(data).appendTo("#query-result");
  },

  generatePaginateDiv: function(data) {
    var currPage = parseInt(data.page);
    var hits = parseInt(data.hits);
    var totalPages = Math.ceil(hits/Query.resultsPerPage);
    var queryPaginate = $("<div class='query-paginate'></div>");
    var queryTerm = $("input[name='query']").val();
    var version = Query.selectedVersion();
    var startPage = Math.max(currPage - 5, 1);
    var stopPage = Math.min(currPage + 5, totalPages);
    for (var i=startPage; i<=stopPage; i++) {
      var url = webroot + "/search/" + 
        version + "/q=" + queryTerm +
        "&page=";
      var span = $("<span class='query-paginate-" + 
                   (i==currPage ? "current" : "other") +
                   "-page'>" + (i==stopPage ? i + " (還有" + (totalPages-i) + "頁)" :
                                i) +
                   "</span>");
      var anchor = ($("<a></a>")
                    .click(function() {
                      // need to rely on the value stored in the span
                      // because this 'click' function is a closure and
                      // the evaluation is deferred
                      var page = parseInt($(this)[0].firstChild.innerText);
                      if ( currPage == i ) {
                        // do nothing because we are already
                        // at the current page
                      } else {
                        Query.query(url + page);
                      }
                    }));
      span.appendTo(anchor);
      anchor.appendTo(queryPaginate);
    }
    return queryPaginate;
  },
  
  selectedVersion: function() {
    // Build a colon ':' separated string of versions
    var versions = $("#version option:selected")
      .map(function() {
        return this.value;
      }).get().join(',');
    return versions;
  }
};

$(document).ready(function() {
  $("#query-form").submit(function() {
    var version = Query.selectedVersion();
    var queryTerm = $("input[name='query']").val();
    var url = webroot + '/search/' + version + '/q=' + queryTerm;
    Query.query(url);
    // prevent the default behavior of submit by returning false
    return false;
  });
});

