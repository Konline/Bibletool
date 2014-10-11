# -*- coding: utf-8 -*-

# Extracts original UCV text for comparison.
#
# Extracts the Bible content from the HTML files embedded in:
# https://sites.google.com/site/downloadbibles/uniont
#
# Normalizes both texts for comparison.

import glob
import re

BOOKS_MAPPING = {
    1: '創',
    2: '出',
    3: '利',
    4: '民',
    5: '申',
    6: '書',
    7: '士',
    8: '得',
    9: '撒上',
    10: '撒下',
    11: '王上',
    12: '王下',
    13: '代上',
    14: '代下',
    15: '拉',
    16: '尼',
    17: '斯',
    18: '伯',
    19: '詩',
    20: '箴',
    21: '傳',
    22: '歌',
    23: '賽',
    24: '耶',
    25: '哀',
    26: '結',
    27: '但',
    28: '何',
    29: '珥',
    30: '摩',
    31: '俄',
    32: '拿',
    33: '彌',
    34: '鴻',
    35: '哈',
    36: '番',
    37: '該',
    38: '亞',
    39: '瑪',
    40: '太',
    41: '可',
    42: '路',
    43: '約',
    44: '徒',
    45: '羅',
    46: '林前',
    47: '林後',
    48: '加',
    49: '弗',
    50: '腓',
    51: '西',
    52: '帖前',
    53: '帖後',
    54: '提前',
    55: '提後',
    56: '多',
    57: '門',
    58: '來',
    59: '雅',
    60: '彼前',
    61: '彼後',
    62: '約壹',
    63: '約貳',
    64: '約參',
    65: '猶',
    66: '啟',
}


def NormalizeLine(line):
    line = line.strip()
    # Removes '【　神創造天地】' 
    line = re.sub(r'【.*】', '', line)
    # Removes '〔註就是相爭的意思〕'
    line = re.sub(r'〔.*〕', '', line)
    # Removes ﹝此包括徒1：23-24﹞
    line = re.sub(r'﹝.*﹞', '', line)
    # Replaces '...併入第...' with '見上節'
    line = re.sub(r'--.*併入第.*節中', '--見上節', line)
    # Replaces 併第24上節中
    line = re.sub(r'併第.*上節中', '見上節', line)
    # Removes "God's words tagging'
    line = line.replace("' ", '')
    line = line.replace(" '", '')
    # Removes all punctuations.
    line = line.replace('，', '')
    line = line.replace('「', '')
    line = line.replace('」', '')
    line = line.replace('。', '')
    line = line.replace('；', '')
    line = line.replace('、', '')
    line = line.replace('：', '')
    line = line.replace('！', '')
    line = line.replace('？', '')
    line = line.replace('『', '')
    line = line.replace('』', '')
    line = line.replace('．', '')
    line = line.replace('－', '')
    line = line.replace('）', '')
    line = line.replace('（', '')
    # Normalize a few common words.
    line = line.replace('裏', '裡')
    line = line.replace('喫', '吃')
    line = line.replace('哪', '那')
    line = line.replace('纔', '才')
    line = line.replace('啊', '阿')
    line = line.replace('麼', '嗎')
    line = line.replace('罷', '吧')
    line = line.replace('挂', '掛')
    line = line.replace('毗', '毘')
    line = line.replace('姐姐', '姊姊')
    line = line.replace('流便', '呂便')
    line = line.replace('西乃', '西奈')
    line = line.replace('姐妹', '姊妹')
    # Replace '作' -> '做'
    # TODO(koyao): Remove this replacement once other low-hanging fruit typos
    # are fixed.
    line = line.replace('作', '做')
    line = line.replace('地', '的')
    line = line.replace('得', '的')
    # Replace all pronouns. We'll resolve these later.
    line = line.replace('我', 'XX')
    line = line.replace('你', 'XX')
    line = line.replace('妳', 'XX')
    line = line.replace('祢', 'XX')
    line = line.replace('他', 'XX')
    line = line.replace('祂', 'XX')
    line = line.replace('她', 'XX')
    line = line.replace('牠', 'XX')
    line = line.replace('它', 'XX')
    return '%s\n' % line


def main():
    # Generate original source.
    print 'Generating original source for comparison.'
    with open('../data/UCV.utf8', 'r') as inf:
        with open('UCV_original.txt', 'w') as outf:
            line = inf.readline()
            while line:
                if line.startswith('"'):
                    line = inf.readline()
                    continue
                outf.write(NormalizeLine(line))
                line = inf.readline()

    # Generate external source.
    print 'Generating external source for comparison.'
    with open('UCV_external.txt', 'w') as outf:
        files = glob.glob('cut/*.htm')
        book = 1
        for file in files:
            line_num = 1
            with open(file) as inf:
                line = inf.readline()
                while line:
                    match = re.match('<small>(\d+):(\d+)</small> (.*)<br>', line)
                    if match:
                        chapter = match.group(1)
                        verse = match.group(2)
                        content = match.group(3)
                        outf.write('%s %s:%s--%s' % (
                            BOOKS_MAPPING[book],
                            chapter,
                            verse,
                            NormalizeLine(content)))
                    line = inf.readline()
                    line_num += 1
            book += 1

    print 'Done.'


if __name__ == '__main__':
    main()
