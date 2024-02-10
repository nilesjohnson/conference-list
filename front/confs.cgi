#!/usr/bin/python3

import urllib.request, urllib.error, json
from datetime import date
print("Content-type: text/html; charset=utf-8\n\n")
# Include HTML header.
with open("../confs-header.html") as f:
    print(f.read())
# Include navbar.
with open("../navbar.html") as f:
    print(f.read())
# Include topmatter.
with open("../confs-topmatter.html") as f:
    print(f.read())
# Insert conferences here, grouped by year.
try:
    req  = urllib.request.Request(url='https://mathmeetings.net/ag-gm-nt.json', 
                                  headers={'User-Agent': 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:23.0) Gecko/20100101 Firefox/23.0'})
    with urllib.request.urlopen(req) as f:
        l1 = f.read().decode()
    confs = json.loads(l1)['conferences']
    entries = {}
    for i in confs:
        ti = i['title']
        li = i['homepage']
        date1 = i['start_date']
        date2 = i['end_date']
        city = i['city']
        country = i['country']
        dt1 = date.fromisoformat(date1)
        y1, m1, d1 = dt1.timetuple()[:3]
        dt2 = date.fromisoformat(date2)
        y2, m2, d2 = dt2.timetuple()[:3]
        if m1 == m2:
            if d1 == d2:
                daterange = dt1.strftime("%B") + ' ' + str(int(d1))
            else:
                daterange = dt1.strftime("%B") + ' ' + str(int(d1)) + '-' + str(int(d2))
        else:
            daterange = dt1.strftime("%B") + ' ' + str(int(d1)) + '-' + dt2.strftime("%B") + ' ' + str(int(d2))
        # Special processing for online events.
        if "Antarctica" in country or "Online" in country or "Online" in city:
            place = "<b>online</b>"
        else:
            place = city + ', ' + country
        s = '<li><a href="{}">{}</a>, {}, {} </li>'.format(li, ti, daterange, place)
        if y1 not in list(entries.keys()):
            entries[y1] = []
        entries[y1].append((s, int(m1)))
    l = list(entries.keys())
    l.sort()
    for y in l:
        print('<h2>{}</h2>\n\n'.format(y))
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
with open("../confs-footer.html") as f:
    print(f.read())

