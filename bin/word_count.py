#!/usr/bin/python3

# Calculates character count for each Bible verse
with open('../data/UCV.utf8') as inf:
    punctuactions =  ['【', '】', "'", '「', '」', '。', '，', '：', '、',
                      '；', '　', ' ', '『', '』', '〔', '〕', '？', '！',
                      '（', '）', '《', '》', '\n']
    for line in inf.readlines():
        if line.startswith('"'):
            continue
        verse, body = line.split('--')
        body = ''.join([char if char not in punctuactions
                        else '' for char in body])
        print(verse, '=', len(body))
