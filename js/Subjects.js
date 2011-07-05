var Subjects = {
  // toggle subjects Plus and Minus Id
  toggleSubjectPlusMinus: function(divId, imgId) {
    var div = document.getElementById(divId);
    var img = document.getElementById(imgId);
    if (div.style.display == 'none') {
      div.style.display = '';
      img.src = webroot + '/images/minus.gif';
    } else if (true) {
      div.style.display = 'none';
      img.src = webroot + '/images/plus.gif';
    };
  },

  // display subjects
  subjects: function(url) {
    $("#subjects-body").empty();
    var counter = 0;
    var jqxhr = $.getJSON(url, function(data) {
      for (var subject in data) {
        var val = data[subject];
        // if val is an array, this indicates
        // that there are no subtitles
        if ( $.isArray(val) ) {
          var link = $.map(val, function(ele, idx) {
            return ele.replace(" ", ":");
          }).join(';');
          $("<div class=subject>" +
            "<div class=subject-title>" +
            "<a href=" + webroot + "/browse/UCV:" + link +
            ">" + subject + "</a></div></div>").appendTo("#subjects-body");
        } 
        // this subject has subtitles
        else {
          var divId = 'plus_minus_' + counter;
          var imgId = 'plus_minus_img_' + counter;
          counter++;
          var onClick = "onclick=Subjects.toggleSubjectPlusMinus('" + divId + "','" + imgId + "')";
          var subjectTitle = $("<div class=subject>" +
                               "<div class=subject-title " + onClick + ">" +
                               subject + "<img id=" + imgId +  
                               " src=" + webroot + "/images/plus.gif>" +
                               "</div></div>").appendTo("#subjects-body");
          var subjectSubtitles = $("<div class=subject-subtitles style='display: none;' id='" + 
                                   divId + 
                                   "'></div>")
            .appendTo(subjectTitle);
          for (var subtitle in val) {
            var link = $.map(val[subtitle], function(ele, idx) {
              return ele.replace(" ", ":");
            }).join(';');
            $("<div class=subject-subtitle>" + 
              "<a href=" + webroot + "/browse/UCV:" + link +
              ">" + subtitle + "</a></div>").appendTo(subjectSubtitles);
          }
        }
      }
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#subjects-body');
      });
  }

};

$(document).ready(function() {
  Subjects.subjects(webroot + '/subjects/index');
});

