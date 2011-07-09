// This file contains constant arrays and generic functions 
// that are needed by other files

// # of chapters in a given book
// array index is the book index. 0th entry is dummy
// E.g. chaptersArray[1] = 50 chapters in Genesis
//      chaptersArray[66] = 22 chapters in Revelation
var chaptersArray = new Array(0, 50, 40, 27, 36, 34, 24, 21, 4, 31,
                              24, 22, 25, 29, 36, 10, 13, 10, 42, 150,
                              31, 12, 8, 66, 52, 5, 48, 12, 14, 3,
                              9, 1, 4, 7, 3, 3, 3, 2, 14, 4,
                              28, 16, 24, 21, 28, 16, 16, 13, 6, 6,
                              4, 4, 5, 3, 6, 4, 3, 1, 13, 5,
                              5, 3, 5, 1, 1, 1, 22);

// Convert book index to abbreviation.
// 0th entry is dummy
// CN array is for Chinese version
// EN array is for English version
var book2CNabbrev = new Array( '', '創', '出', '利', '民', '申', '書', '士', '得', '撒上', '撒下', '王上', '王下', '代上', '代下', '拉', '尼', '斯', '伯', '詩', '箴', '傳', '歌', '賽', '耶', '哀', '結', '但', '何', '珥', '摩', '俄', '拿', '彌', '鴻', '哈', '番', '該', '亞', '瑪', '太', '可', '路', '約', '徒', '羅', '林前', '林後', '加', '弗', '腓', '西', '帖前', '帖後', '提前', '提後', '多', '門', '來', '雅', '彼前', '彼後', '約壹', '約貳', '約參', '猶', '啟');
var book2ENabbrev = new Array('', 'GEN', 'EXO', 'LEV', 'NUM', 'DEU', 'JOS', 'JUG', 'RUT', '1SA', '2SA', '1KI', '2KI', '1CH', '2CH', 'EZR', 'NEH', 'EST', 'JOB', 'PSM', 'PRO', 'ECC', 'SON', 'ISA', 'JER', 'LAM', 'EZE', 'DAN', 'HOS', 'JOE', 'AMO', 'OBA', 'JON', 'MIC', 'NAH', 'HAB', 'ZEP', 'HAG', 'ZEC', 'MAL', 'MAT', 'MAK', 'LUK', 'JHN', 'ACT', 'ROM', '1CO', '2CO', 'GAL', 'EPH', 'PHL', 'COL', '1TS', '2TS', '1TI', '2TI', 'TIT', 'PHM', 'HEB', 'JAS', '1PE', '2PE', '1JN', '2JN', '3JN', 'JUD', 'REV');

// Add findIndex method to the Array class
// This is useful to allow reverse lookup of books2*abbrev
Array.prototype.findIndex = function(value){
  var ctr = "";
  for (var i=0; i < this.length; i++) {
    // use === to check for Matches. ie., identical (===), ;
    if (this[i] == value) {
      return i;
    }
  }
  return ctr;
};
