// Class implementing the subjects functionality
var Subjects = {
  // toggle subjects Plus and Minus Id
  // Parameters:
  // - divId: The subject <div> id
  // - imgId: The + or - <img> id
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

  // display all the available subjects
  // Parameters:
  // - url: URL where we can fetch the JSON data from the server
  subjects: function(url) {
    $("#subjects-body").empty();
    var counter = 0;
    var jqxhr = $.getJSON(url, function(data) {
      for (var subject in data) {
        var val = data[subject];
        // if val is an array, this indicates
        // that there are no subtitles
        // The div looks like this:
        // <div class="subject">
        //   <div class="subject-title"><a
        //   href="/browse#UCV:LEV:20:4-5">勾結罪惡</a></div>
        // </div>
        if ( $.isArray(val) ) {
          var link = $.map(val, function(ele, idx) {
            return ele.replace(" ", ":");
          }).join(';');
          $("<div class=subject>" +
            "<div class=subject-title>" +
            "<a href=" + webroot + "/browse#UCV:" + link +
            ">" + subject + "</a></div></div>").appendTo("#subjects-body");
        } 
        // this subject has subtitles and looks like this:
        // <div class="subject">
        //   <div class="subject-title"
        //     onclick="Subjects.toggleSubjectPlusMinus('plus_minus_0','plus_minus_img_0')">
        //     教唆和共謀
        //     <img id="plus_minus_img_0" src="/images/plus.gif">
        //   </div>
        //   <div class="subject-subtitles" style="display: none;" id="plus_minus_0">
        //     <div class="subject-subtitle">
        //       <a href="/browse#UCV:2JN:1:10-11;PRO:29:24;PSM:50:18;ROM:1:32">一般經文</a>
        //     </div>
        //     <div class="subject-subtitle">
        //       <a href="/browse#UCV:MAK:6:25;MAT:14:8">希羅底的女兒</a>
        //     </div>
        //     <div class="subject-subtitle">
        //       <a href="/browse#UCV:JHN:19:13-16;LUK:23:13-25;MAK:15:9-15;MAT:27:17-26">彼拉多</a>
        //     </div>
        //     <div class="subject-subtitle">
        //       <a href="/browse#UCV:ACT:7:58">保羅</a>
        //     </div>
        //   </div>
        // </div>
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
              "<a href=" + webroot + "/browse#UCV:" + link +
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

