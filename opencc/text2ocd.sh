#!/bin/bash 

for x in TSCharacters TSPhrases; do
  opencc_dict -i $x.txt -o $x.ocd -f text -t ocd
done
