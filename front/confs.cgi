#!/usr/bin/python3

import cgi, sys, urllib.request, urllib.error, re
from datetime import date
print("Content-type: text/html; charset=utf-8\n\n")
# Include HTML header.
with open("confs-header.html") as f:
    print(f.read())
# Include topmatter.
with open("confs-topmatter.html") as f:
    print(f.read())
# Insert conferences here, grouped by year.
try:
    req  = urllib.request.Request(url='https://mathmeetings.net/ag-nt.rss', 
                                  headers={'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0'})
    with urllib.request.urlopen(req) as f:
        l1 = str(f.read())
    l2 = re.findall(r'<item>(.*?)</item>', l1)
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
                daterange = dt1.strftime("%B") + ' ' + str(int(d1)) + '-' + str(int(d2))
        else:
            daterange = dt1.strftime("%B") + ' ' + str(int(d1)) + '-' + dt2.strftime("%B") + ' ' + str(int(d2))
        # Special processing for online events.
        if "Antarctica" in country:
            place = "<b>online</b>"
        else:
            place = city + ', ' + country
        s = '<li><a href="' + li + '">' + ti + '</a>, ' + daterange + ', ' + place + '</li>'
        if y1 in list(entries.keys()):
            entries[y1].append((s, int(m1)))
        else:
            entries[y1] = [(s, int(m1))]
    l = list(entries.keys())
    l.sort()
    for y in l:
        print(('<h2>' + y + '</h2>\n\n'))
        print('<ul>\n')
        m0 = None
        for (s, m1) in entries[y]:
    # Add an extra newline each time the month changes.
            if m0 is not None and m0 != m1:
                print('<br />\n')
            m0 = m1
            print((s + '\n'))
        print('</ul>\n')
except urllib.error.HTTPError as e:
    print("<p>Sorry, an error occurred when retrieving the data. Please try again later.</p>")
    print("<p>Error code: {}</p>".format(e.code))
    pass
    
# Include HTML footer.
with open("confs-footer.html") as f:
    print(f.read())

