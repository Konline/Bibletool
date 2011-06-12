#!/usr/bin/env python2.6

# Make sure a JSON file is well formatted

import glob
import sys
import json

def main():

  x = sys.argv[1]
  print "Reading JSON file '%s'" % x
  input = open(x, 'r')
  content = ''.join(input.readlines())
  input.close()

  data = json.loads(content)

if __name__ == '__main__':
  main()
