#!/bin/bash

# This script download KJV audio files from
# https://publicdomainaudiobibles.com/KJV.html
#

BOOKS="GEN:GEN EXO:EXO LEV:LEV NUM:NUM DEU:DEU JOS:JOS JDG:JUG
       RUT:RUT 1SA:1SA 2SA:2SA 1KI:1KI 2KI:2KI 1CH:1CH 2CH:2CH
       EZR:EZR NEH:NEH EST:EST JOB:JOB PSA:PSM PRO:PRO ECC:ECC
       SNG:SON ISA:ISA JER:JER LAM:LAM EZK:EZE DAN:DAN HOS:HOS
       JOL:JOE AMO:AMO OBA:OBA JON:JON MIC:MIC NAH:NAH HAB:HAB
       ZEP:ZEP HAG:HAG ZAC:ZEC MAL:MAL
       MAT:MAT MRK:MAK LUK:LUK JHN:JHN ACT:ACT ROM:ROM 1CO:1CO
       2CO:2CO GAL:GAL EPH:EPH PHP:PHL COL:COL 1TH:1TS 2TH:2TS
       1TI:1TI 2TI:2TI TIT:TIT PHM:PHM HEB:HEB JAS:JAS 1PE:1PE
       2PE:2PE 1JN:1JN 2JN:2JN 3JN:3JN JUD:JUD REV:REV"

wget -c "https://publicdomainaudiobibles.com/content/mp3/KJV/KJV_OT.zip"
unzip -n KJV_OT.zip

wget -c "https://publicdomainaudiobibles.com/content/mp3/KJV/KJV_NT.zip"
unzip -n KJV_NT.zip

for book in $BOOKS; do
  old=$(echo "$book" | cut -d: -f1)
  new=$(echo "$book" | cut -d: -f2)
  for file in $(ls *KJV_${old}*.mp3); do
    output=$(echo $file | sed "s/KJV_${old}/${new}_/g")
    echo "$file -> $output"
    mv -f "$file" "$output"
  done
done

# rm -f *.zip
