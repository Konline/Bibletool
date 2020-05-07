// Calendar class
var Calendar = {
  // Use this variable to hold calendar JSON data
  data: null,

  // Variable to hold the current month being displayed in the
  // calendar. This variables is updated by a callback attached to the
  // calendar
  currMonth: null,
  
  // populate the calendar pull down menu with different bible
  // progress data
  calendar: function(url) {
    $("select[name='calendar-type']").empty();
    var jqxhr = $.getJSON(url, function(data) {
      // data is a hash that looks like:
      // {
      //     "OT1/NT2": {
      //     "title": "一 年讀完舊約一次，新約兩次",
      //     "type": "calendar",
      //     "schedule": {
      //       "1/1": "GEN:1;GEN:2;PSM:1;PSM:2;MAT:1;MAT:2",
      //       "1/2": "GEN:3;GEN:4;PSM:3;PSM:5;MAT:3;MAT:4",
      Calendar.data = data;
      for (var key in data) {
        $("<option value='" + key + "'>" + data[key].title + "</option>")
          .appendTo($("select[name='calendar-type']"));
      }
    })
      .error(function(){
        $('<p>Failed to download data from the server</p>').appendTo('#calendar-body');
      })
      .complete(function() {
        // use URL hash to implement Ajax bookmarking
        // we bind at this stage because this fn requires a fully
        // populated pull down menu
        $(window).bind( 'hashchange', function(e) {
          // the URL is the string after the hash mark, called the
          // 'fragment' below. 
          var fragment = $.param.fragment();
          if ( fragment == "" ) {
            // if there is no fragment, defaults to the first calendar
            var option = $("select[name='calendar-type'] option:first-child");
            window.location.hash = option.val();
          } else {
            var calendarType = fragment;
            // make this calendar selected
            $("select[name='calendar-type'] option").removeAttr('selected');
            var option = $("select[name='calendar-type'] option[value='" + fragment + "']");
            option.attr('selected', 'selected');
          }

          // get the current month and trigger displaySchedule fn
          var date = new Date();
          Calendar.displaySchedule(null, // year (not needed) 
                                   (Calendar.currMonth ? Calendar.currMonth : (date.getMonth()+1)), // month
                                   null); // inst (not needed)
        });
        
        // create the calendar
        $("#calendar")
          .datepicker({
            showOtherMonths: true,
            selectOtherMonths: true,
            numberOfMonths: [1, 3],
            dateFormat: 'm/d',
            onSelect: Calendar.onSelectFn,
            onChangeMonthYear: Calendar.displaySchedule
          });

        // trigger the hashchange by default
        $(window).trigger( 'hashchange' );
      });
  },                      
 
  // determine # of days in the month
  // Parameters:
  // - n: integer [1-12]
  daysInMonth: function(n) {
    return (n==1 ? 31 :
            n==2 ? 28 :
            n==3 ? 31 :
            n==4 ? 30 :
            n==5 ? 31 :
            n==6 ? 30 :
            n==7 ? 31 :
            n==8 ? 31 :
            n==9 ? 30 :
            n==10 ? 31 :
            n==11 ? 30 :
            n==12 ? 31 : 0);
  },
  
  // display the schedule on the div calendar-schedule
  displaySchedule: function(year, month, inst) {
    // update the currMonth variable
    Calendar.currMonth = month;

    $("#calendar-schedule").empty();
    var key = $("select[name='calendar-type'] option:selected").val();
    for (var i=month; i<=month+2; i++) {
      var wrappedMonth = i>12 ? (i-12) : i;
      var monthName = $.datepicker.regional['zh-TW'].monthNames[wrappedMonth-1];
      $("<div class=calendar-month-name>"+monthName+"</div>")
        .appendTo($("#calendar-schedule"));
      for (var j=1; j<=Calendar.daysInMonth(wrappedMonth); j++) {
        var passage = Calendar.data[key].schedule[wrappedMonth+'/'+j];
        var url = webroot + '/browse#' + passage;
        // convert actual passage to something humanly readable
        var humanUrl = $.map(passage.split(/;/), function(ele, idx) {
          var bookName = ele.match(/^(...)/)[1];
          var chineseName = book2CNabbrev[book2ENabbrev.findIndex(bookName)];
          return ele.replace(/^(...)/, chineseName);
        }).join(', ');
        
        var anchor = '<a href=' + url + '>' + humanUrl + '</a>';
        $("<div class=calendar-day>" + 
          "<span>" + j + "：</span>" +
          anchor + "</div>")
          .appendTo($("#calendar-schedule"));
      }
    }
  },

  // Fn to call when user selects a data
  onSelectFn: function (dateText, inst) {
    // get the selected calendar
    var key = $("select[name='calendar-type'] option:selected").val();
    var passage = Calendar.data[key].schedule[dateText];
    var url = webroot + '/browse#' + passage;
    window.location.href=url;
  }
};

// Main function
$(document).ready(function() {
  // Bind ajaxSend and ajaxComplete events
  $("#calendar-body")
    .ajaxSend(function() {
      $(ajaxLoader).appendTo(this);
    })
    .ajaxComplete(function() {
      $(ajaxLoader).remove();
    });

  // fetch data from the server
  Calendar.calendar(webroot + '/calendar/index');

  $("select[name='calendar-type']").change(function() {
    var option = $("select[name='calendar-type'] option:selected");
    window.location.hash = option.val();
  });
  
});
