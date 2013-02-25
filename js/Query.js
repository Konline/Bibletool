// Class implementing the query functionality
var Query = {
  // results per page (this is a constant set in the backend)
  // cannot be changed in the front end
  resultsPerPage: 20,
  
  // # of pixels to scroll in paginate
  scrollIncrement: 5,

  // # of milliseconds between scrolling interval
  scrollInterval: 20,

  // variable to hold the interval handle
  // this is needed in order to cancel the interval when
  // the user leaves the prev or next div
  intervalHandle: null,

  // Center the query-paginate div
  // so that the chosen page is always shown in the middle
  centerDiv: function() {
    var center = parseInt(document.body.clientWidth/2);
    var current = $("span.query-paginate-current-page");
    while ( current.offset().left > (center+20) ||
            current.offset().left < (center-20) ) {
      if ( current.offset().left > center ) {
        // shift to the left
        $("div.query-paginate").each(function(idx,ele) {
          ele.style.left = (parseInt(ele.style.left) - 5) + 'px';
        });
      } else {
        // shift to the right
        $("div.query-paginate").each(function(idx,ele) {
          ele.style.left = (parseInt(ele.style.left) + 5) + 'px';
        });
      }
    }
  },
  
  // scroll the paginate div to the left
  // This is a recursive function
  // Parameter:
  // - increment: # of pixel to scroll
  nextFn: function(increment) {
    Query.intervalHandle = setInterval(function() {
      var queryPaginate = $("div.query-paginate");
      var left = parseInt(queryPaginate[0].style.left);
      var width = parseInt(document.body.clientWidth/2);
      var scrollWidth = parseInt($(".query-paginate span:last").position().left); // use this because of FF
      // console.log('***nextFn: left = ' + left + ' width = ' + width + ' scrollWidth = ' + scrollWidth + ' offsetWidth = ' + parseInt(queryPaginate[0].offsetWidth) +
      //            ' clientWidth = ' + parseInt(queryPaginate[0].clientWidth));
      if ( scrollWidth >= width && left > width - scrollWidth - 120 ) {
        queryPaginate.each(function(idx, ele) {
          ele.style.left = (left-increment)+"px";
        });
      }
    }, Query.scrollInterval);
  },

  // scroll the paginate div to the right
  // This is a recursive function
  // Parameter:
  // - increment: # of pixel to scroll
  prevFn: function(increment) {
    Query.intervalHandle = setInterval(function() {
      var queryPaginate = $("div.query-paginate");
      var left = parseInt(queryPaginate[0].style.left);
      // console.log("***prevFn left = " + left);
      if ( left < 70 ) {
        queryPaginate.each(function(idx, ele) {
          ele.style.left = (left+increment)+"px";
        });
      }
    }, Query.scrollInterval);
  },

  // Process the query data and display results to the user
  // Parameters:
  // - data: Parsed JSON data returned from the server
  processQueryData: function(data) {
    // get the version and queryterm from the fragment
    var fragment = $.param.fragment();
    var version = fragment.match(/^([^\/]+)/)[1];
    var queryTerm = decodeURI(fragment.match(/q=([^&\/]+)/)[1]);
    
    // update toolbar
    $("select[name='version'] option").removeAttr('selected');
    $("select[name='version'] option[value='"+version+"']").attr('selected', 'selected');
    $("input[name='query']").val(queryTerm);

    // process query data
    if (data.page >= 0) {
        $("<div class='query-title'>找到 " + data.hits + 
          " 經節含有「" + queryTerm + "」<br>（搜尋時間：" + (Math.round(data.time)/1000) + " 秒）</div>")
          .appendTo("#query-result");
        Query.generatePaginateDiv(data, queryTerm).appendTo("#query-result");
    }

    var browseTableChapter = $("<div class='browse-table-chapter'></div>");
    browseTableChapter.appendTo("#query-result");
    // display the search results
    for (var i=0; i < data.verses.length; i++) {
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
        "<a href=" + webroot + "/browse#UCV:" + book + ":" + 
        chapter + ">" + name + " " + chapter + ":" + verse + "</a>" +
        "</span>" +
        "<span class='browse-table-verse-content'>" +
        subtitle + content + "</span>" +
        "</div>").appendTo(browseTableChapter);
    }

    if (data.page >= 0) {
        Query.generatePaginateDiv(data, queryTerm).appendTo("#query-result");
        if (data.hits > 0) { 
          Query.centerDiv();
        }
    }
  },

  // Generate the pagination divs
  // Parameters:
  // - data: Parsed JSON datastructure
  // - queryTerm: string representing the query term
  generatePaginateDiv: function(data, queryTerm) {
    var currPage = parseInt(data.page);
    var hits = parseInt(data.hits);
    var totalPages = Math.ceil(hits/Query.resultsPerPage);
    var queryPaginate = $("<div class='query-paginate' style='left:70px;'></div>");
    var version = Query.selectedVersion();
    var startPage = 1;
    var stopPage = totalPages;
    for (var i=startPage; i<=stopPage; i++) {
      var link = webroot + '/query/#' + version + '/q=' + encodeURI(queryTerm) + '&page=' + i;
      var span = $("<span class='query-paginate-" + 
                   (i==currPage ? "current" : "other") +
                   "-page'>" + i + "</span>");
      var anchor = $("<a></a>");
      if ( currPage != i ) {
        anchor.attr('href', link);
      }
      span.appendTo(anchor);
      anchor.appendTo(queryPaginate);
    }
    // wrap the div into another div to allow scrolling
    var searchScroller = $("<div class=search-scroller></div>");
    $("<div class=search-prev></div>")
      .mouseover(function() {
        Query.prevFn(Query.scrollIncrement);
      })
      .mouseleave(function() {
        clearInterval(Query.intervalHandle);
      })
      .appendTo(searchScroller);
    $("<div class=search-next></div>")
      .mouseover(function() {
        Query.nextFn(Query.scrollIncrement);
      })
      .mouseleave(function() {
        clearInterval(Query.intervalHandle);
      })
      .appendTo(searchScroller);
    queryPaginate.appendTo(searchScroller);
    return searchScroller;
  },
  
  // Query the pulldown menu and return an array of the selected bible
  // versions E.g. ['UCV', 'KJV']
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
  // use URL hash to implement Ajax bookmarking
  $(window).bind( 'hashchange', function(e) {
    // the URL is the string after the hash mark, called the
    // 'fragment' below. If fragment is non-empty, then perform the
    // actual query
    var fragment = $.param.fragment();
    if ( fragment != "" ) {
      var url = webroot + '/search/' + fragment;
      $("#query-result").empty();
      var jqxhr = $.getJSON(url, Query.processQueryData)
        .error(function(){
          $('<p>Failed to download data from the server</p>').appendTo('#query-result');
        });
    }
  });
  
  // Bind action to the submit button
  // This simply updates the URL with the hash. The 'hashchange' event
  // will take care of the rest
  $("#query-form").submit(function() {
    var version = Query.selectedVersion();
    var queryTerm = $("input[name='query']").val();
    if ( queryTerm != "") {
      window.location.hash = version + '/q=' + encodeURI(queryTerm);
    }
    // prevent the default behavior of submit by returning false
    return false;
  });
  
  // trigger the hashchange by default
  $(window).trigger( 'hashchange' );
  
  // Bind ajaxSend and ajaxComplete events
  $("#query-result")
    .ajaxSend(function() {
      $(ajaxLoader).appendTo(this);
    })
    .ajaxComplete(function() {
      $(ajaxLoader).remove();
    })
    .ajaxError(function() {
      $(ajaxLoader).remove();
    });
});

