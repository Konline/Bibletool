#!/bin/bash

# This script attempts to download audio files from Haomuren
#
# The source files from Haomuren looks like this:
#
# "http://media.haomuren.org/AudioBible/OT 01 Ge/Ge 01.mp3"
#
# and should be renamed as:
#
# "01_GEN_001.mp3"

OT="Ge,GEN,50 Ex,EXO,40 Lev,LEV,27 Nu,NUM,36 Dt,DEU,34 Jos,JOS,24 Jdg,JUG,21
    Ru,RUT,4 1Sa,1SA,31 2Sa,2SA,24 1Ki,1KI,22 2Ki,2KI,25 1Ch,1CH,29 2Ch,2CH,36
    Ezr,EZR,10 Ne,NEH,13 Est,EST,10 Job,JOB,42 Ps,PSM,150 Pr,PRO,31 Ecc,ECC,12
    SS,SON,8 Isa,ISA,66 Jer,JER,52 La,LAM,5 Eze,EZE,48 Da,DAN,12 Hos,HOS,14
    Joel,JOE,3 Am,AMO,9 Ob,OBA,1 Jnh,JON,4 Mic,MIC,7 Na,NAH,3 Hab,HAB,3
    Zep,ZEP,3 Hag,HAG,2 Zec,ZEC,14 Mal,MAL,4"
NT="Mt,MAT,28 Mk,MAK,16 Lk,LUK,24 Jn,JHN,21 Ac,ACT,28 Ro,ROM,16 1Co,1CO,16
    2Co,2CO,13 Gal,GAL,6 Eph,EPH,6 Php,PHL,4 Col,COL,4 1Th,1TS,5 2Th,2TS,3
    1Ti,1TI,6 2Ti,2TI,4 Tit,TIT,3 Phm,PHM,1 Heb,HEB,13 Jas,JAS,5 1Pe,1PE,5
    2Pe,2PE,3 1Jn,1JN,5 2Jn,2JN,1 3Jn,3JN,1 Jude,JUD,1 Rev,REV,22"

total_book=0
OLDIFS=$IFS
for entry in $OT $NT; do
  IFS=","
  set -- $entry
  src=$1
  dst=$2
  num_books=$3
  total_book=$(($total_book + 1))
  total_book_padded=$(printf "%02d" $total_book)
  src_book=$(($(($total_book % 40)) + 1))
  src_book_padded=$(printf "%02d" $src_book)
  if [[ $total_book -lt 40 ]]; then
    prefix="OT"
  else
    prefix="NT"
  fi

  IFS=$OLDIFS
  for ch in $(seq 1 $num_books); do
    src_ch=$(printf "%02d" $ch)
    dst_ch=$(printf "%03d" $ch)
    src_url="http://media.haomuren.org/AudioBible/$prefix $src_book_padded $src/$src $src_ch.mp3"
    output="${total_book_padded}_${dst}_${dst_ch}.mp3"

    echo "Downloading: $src_url as $output"
    wget --quiet -c "$src_url" -O "$output"
    if [[ ! -s "$output" ]]; then
      echo "ERROR: $output is empty"
      exit 1
    fi
  done
done
