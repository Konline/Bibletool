chaptersArray = new Array(0, 50, 40, 27, 36, 34, 24, 21, 4, 31, 24, 22, 25, 29, 36, 10, 13, 10, 42, 150, 31, 12, 8, 66, 52, 5, 48, 12, 14, 3, 9, 1, 4, 7, 3, 3, 3, 2, 14, 4, 28, 16, 24, 21, 28, 16, 16, 13, 6, 6, 4, 4, 5, 3, 6, 4, 3, 1, 13, 5, 5, 3, 5, 1, 1, 1, 22);

function clearSelect(selectId) {
  var select = document.getElementById(selectId);
  while (select.length != 0) {
    select.remove(select.selectedIndex);
  };
};
function populateSelect(selectId, n) {
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
};

function toggleRedDiv() {
  var allSpans = document.getElementsByTagName('span');
  var toggleImage = document.getElementById('toggle');
  var tmpArr4683 = allSpans;
  for (var tmpI4684 = 0; tmpI4684 < tmpArr4683.length; tmpI4684 = tmpI4684 + 1) {
    var span = tmpArr4683[tmpI4684];
    if (span.className == 'browse-verse-red') {
      if (span.style.color == 'red') {
        span.style.color = 'black';
        toggleImage.src = 'images/toggle_red.png';
      } else if (true) {
        span.style.color = 'red';
        toggleImage.src = 'images/toggle_black.png';
      };
    };
  };
};

function updateSelectWithBook(bookSelectId, chaptersSelectId) {
  var bookSelect = document.getElementById(bookSelectId);
  var bookSelectedIndex = bookSelect.selectedIndex;
  var bookSelectedNumber = bookSelect.options[bookSelectedIndex].value;
  var bookTotalChapters = chaptersArray[bookSelectedNumber];
  clearSelect(chaptersSelectId);
  populateSelect(chaptersSelectId, bookTotalChapters);
};

var notInForm = true;
function focusForm() {
    notInForm = null;
};

function blurForm() {
    notInForm = true;
};

function keybinding(e) {
  var evtobj = window.event ? event : e;
  var unicode = evtobj.charCode ? evtobj.charCode : evtobj.keyCode;
  var actualkey = String.fromCharCode(unicode);
  var prevChapAnchor = document.getElementById('prev_chap_anchor');
  var prevBookAnchor = document.getElementById('prev_book_anchor');
  var nextChapAnchor = document.getElementById('next_chap_anchor');
  var nextBookAnchor = document.getElementById('next_book_anchor');
  if (notInForm) {
    if (actualkey == 'r') {
      toggleRedDiv();
    } else if ((actualkey == 'j' || actualkey == 'd') && nextChapAnchor) {
      window.location = nextChapAnchor.href;
    } else if (actualkey == 'n' && nextBookAnchor) {
      window.location = nextBookAnchor.href;
    } else if ((actualkey == 'k' || actualkey == 'a') && prevChapAnchor) {
      window.location = prevChapAnchor.href;
    } else if (actualkey == 'p' && prevBookAnchor) {
      window.location = prevBookAnchor.href;
    } else if (true) {
      null;
    };
  };
};

document.onkeypress = keybinding;
