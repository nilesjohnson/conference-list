#!/usr/bin/python
#
# Front end to MathMeetings.net by Kiran Kedlaya (2016)
# Note: this front end is currently customized to the context of my web site,
# and is provided for informational purposes only.

import cgi, sys, urllib, re
from datetime import date
#sys.path.append('/home/kedlaya/lib/python2.6/')
#load_source(feedparser, '/home/kedlaya/lib/python2.6/site-packages/feedparser-5.2.1-py2.6.egg')
#import feedparser
print("Content-type: application/xhtml+xml\n\n")
print("""
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
   "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="Content-Style-Type" content="text/css" />
   <meta name="author" content="Kiran S. Kedlaya" />
   <meta name="description" content="Kiran Kedlaya's list of conferences in arithmetic geometry" />
   <meta name="robots" content="nofollow" />

<title>Conferences in Arithmetic Geometry</title>

<link rel="stylesheet" type="text/css" href="stylesheet.css" />

</head>
<body>
""")
# Include navbar here.
f = open("navbar.html")
print(f.read())
f.close()
print("""
<div class="content">
<h1>Conferences in arithmetic geometry</h1>

<p>This is a new incarnation of my list of conferences in arithmetic geometry,
now powered by the site <a href="http://mathmeetings.net/">MathMeetings.net</a>.
Visit that site to upload new conference lists or to see conferences in other areas of mathematics
(or to learn how to write your own front end if you don't like this one).
</p>

<p>
My <a href="http://scripts.mit.edu/~kedlaya/wiki/index.php?title=Conferences_in_Arithmetic_Geometry">old conference wiki</a>
will be maintained through the end of 2016; thereafter, it will be demoted to rumor-tracking (i.e., listing conferences without
web sites).
 </p>

""")
#Insert conferences here, grouped by year.
w = urllib.urlopen('http://mathmeetings.net/ag-nt.rss')
l1 = w.read()
l2 = re.findall('<item>(.*?)</item>', l1)
prog1 = re.compile('<title>(.*)</title>.*<link>(.*)</link>.*<description>(.*) through (.*?), (.*); (.*)</description>')
prog2 = re.compile('(.*?)-(.+?)-(.*)')
entries = {}
for i in l2:
    m = prog1.match(i)
    ti, li, date1, date2, city, country = m.groups()
    m = prog2.match(date1)
    y1, m1, d1 = m.groups()
    dt1 = date(int(y1), int(m1), int(d1))
    m = prog2.match(date2)
    y2, m2, d2 = m.groups()
    dt2 = date(int(y2), int(m2), int(d2))
    if m1 == m2:
        if d1 == d2:
            daterange = dt1.strftime("%B") + ' ' + str(int(d1))
        else:
#            daterange = m1 + '/' + d1 + '-' + d2
            daterange = dt1.strftime("%B") + ' ' + str(int(d1)) + '-' + str(int(d2))
    else:
#        daterange = m1 + '/' + d1 + '-' + m2 + '/' + d2
        daterange = dt1.strftime("%B") + ' ' + str(int(d1)) + '-' + dt2.strftime("%B") + ' ' + str(int(d2))
    s = '<li><a href="' + li + '">' + ti + '</a>, ' + daterange + ', ' + city + ', ' + country + '</li>'
    if y1 in entries.keys():
        entries[y1].append(s)
    else:
        entries[y1] = [s]
w.close()
l = entries.keys()
l.sort()
for y in l:
    print('<h2>' + y + '</h2>\n\n')
    print('<ul>\n')
    for s in entries[y]:
        print s, '\n'
    print('</ul>\n')
print("""
</div>
</body>
</html>
""")
