<!-- File: /app/views/conferences/about.ctp -->

<h1><?php echo $view_title; ?></h1>

<p>MathMeetings.net provides a list of conferences and similar
meetings in mathematics.  There are a number of other such lists, but
this list aims to be more complete by allowing <em>anyone at all</em>
to add announcements.  This is similar in spirit to a wiki, but the
announcements are formatted and stored in a database for efficient
searching and sorting.</p>

<p>Announcements are filtered by subject tags, and are curated by <a
href=#curators>the volunteers listed below</a>.  <em>Note</em>: This site
restricts itself to meetings whose focus is mathematics.  Announcements
about more general meetings are typically not appropriate and may be
deleted.</p>

<p>The site is developed by <a href="http://nilesjohnson.net"
target="blank">Niles Johnson</a>.  Please <a href="http://nilesjohnson.net/contact.html"
target="blank">contact Niles</a> if you have
further quesitons or comments!</p>


<h2>Adding Announcements</h2>
<div>
<p>
To add an announcement, use the link at the top of the page.  An email
address is required so that announcements you post can be edited or
deleted.  To prevent spam, some simple arithmetic is also required.
In addition, a security token is stored as a browser cookie.
</p>

<p>
When you add an announcement, you will receive a message like the following:
</p>

<div id="add-message">

<pre>Thanks for adding your announcement to MathMeetings.net.
The announcement data is copied below, and is also available at:
http://mathmeetings.net/conferences/view/28

If you need to edit or delete your announcement, use the unique edit/delete link:
http://mathmeetings.net/conferences/edit/28/YSZf1X2W

Note that you will receive a new edit/delete link after each update to
your announcement.  If you have any difficulties, questions, or
comments, don't hesitate to contact the curators:
http://mathmeetings.net/conferences/about#curators


best,
The Curators


Announcement Data:

My Interesting Conference!
2016-04-01 -- 2016-04-01

http://math.osu.edu

Contact: Niles Johnson
Institution: Ohio State University
City: Columbus, OH
Country: USA
Meeting type: conference
Subject Tags:
  * at.algebraic-topology
  * ag.algebraic-geometry

Description:
This conference is going to be great!  See the website for more details.
</pre>
</div>

<p>
If you need to update your announcement, use the links provided to access the edit or delete pages.  Each announcement is assigned a random string which is required to edit or delete; this appears at the end of the links above and is re-generated each time the announcement is updated.
</p>
</div>


<!-- announcement emails disabled

<h2 class="target" id="ccdata_about">Sending an announcement email</h2>
<div>

<p> It's useful to send your announcements to distribution lists as
well as posting them here.  You can use the "Copy to email lists..."
section for this purpose.  When you show or hide this section, data
from your announcement will be used to prefill the form, as indicated
below:</p>

<form style="margin: 1pc 10%; width: 80%; border: 1px solid black; padding: 2pc 0;">

<p style="padding:0 1pc 1pc 1pc; margin: 0; text-align:center;">This appears inside of the "Add Announcement" form:</p>

<div id="ccdatadiv" style="margin: 0 14%;">
<h4 title="Show/Hide" class="trigger" id="ccdata-toggle">Copy to email lists...</h4>
<div class="subtitle">
<p>Fill in addresses.  The email body will be prefilled with the data entered above, but you may edit the body before submitting.</p>
</div>
<hr style="margin: 0 5%;">
<div id="ccdata" class="togglebox" style="display: block;">

<div class="subtitle">

<p>Fill in the fields below and an email will be
sent to the specified addresses.  Additionally, a copy of the email
will be sent to the supplied <tt>From</tt> address.</p>

<p><span style="font-weight:bold">Please check carefully; the Subject
and Body will be sent <em>exactly</em> as they appear below</span>,
including any changes that you make now.  Note that the information
below is re-filled from the data above each time you show or hide this
section.  Details of how the information below is computed are given
on the <a
href="http://www.nilesjohnson.net/algtop-conf/conferences/about#ccdata_about"
target="blank">About Page</a> (opens in a new window). </p>

<p>If you decide not to send an email of this announcement, simply
leave the <tt>To</tt> field blank.  In that case, the data from this section
will be discarded.</p></div>


<div class="input text required">
<label for="CcDataFrom">From</label>
<input type="text" id="CcDataFrom" maxlength="100" name="data[CcData][from]">
</div>

<div class="input text required">
<label for="CcDataTo">To</label>
<input type="text" id="CcDataTo" maxlength="255" name="data[CcData][to]">Comma-separated list of addresses
<ul>
<li>&#187; Add <a onclick="return false;" href="#">ALGTOP-L</a> (link disabled for this preview)</li>
<li>&#187; Add <a onclick="return false;" href="#">GEOMETRY (UTK)</a> (link disabled for this preview)</li>
</ul>
</div>

<div class="input text required">
<label for="CcDataSubject">Subject</label>
<input type="text" id="CcDataSubject" maxlength="255" name="data[CcData][subject]" value="&lt;Title of your announcement&gt;">
</div>

<div class="input textarea required">
<label for="CcDataBody">Body</label>
<textarea id="CcDataBody" cols="30" rows="15" name="data[CcData][body]">
First announcement:

&lt;Title of your announcement&gt;
&lt;City, State&gt;, &lt;Country&gt;
&lt;Start date&gt; &ndash; &lt;End date&gt;
&lt;Conference website&gt;

&lt;Text from the description&gt;

For more details, see the website:
&lt;Conference website&gt;

Hope to see you there!
&lt;Contact Name&gt;
on behalf of the organizers

</textarea>
</div>

</div>
</div>
</form>

<p>If you have any further questions, or suggestions, please <a
href="http://www.nilesjohnson.net/contact.html">let Niles know</a>.
Recommendations for other distribution lists to add below the To field are
particularly welcome!</p>

</div>

-->

<h2 class="target" id="tags_about">Subject Tags</h2>
<div>

<p>With subject tags, we can include announcements from a broader
range of fields while still allowing users to focus the conferences
relevant for their field.  When the tagging feature was first
implemented, all announcements were tagged as 'at.algebraic-topology'.
Future announcements are assigned a subject upon entry into the
database.  The subject tags are taken from the <a
href="http://arxiv.org/archive/math">arXiv.org math
categories</a>.</p>

</div>

<h2 class="target" id="rss_about">RSS Feed</h2>
<div>

<p> An RSS feed is an electronic format for publishing information
that is frequently updated.  Using a feed reader, one can quickly scan
the list of topics.  New topics which have not yet been viewed are
highlighted for convenience.</p>

<p>The <a
href="http://www.nilesjohnson.net/algtop-conf/conferences/index.rss">RSS
feed for this site</a> gives a list of conference titles, sorted by
date, and direct links to their homepages.  You can read more about
RSS feeds at the <a href="http://en.wikipedia.org/wiki/RSS"
target="blank">Wikipedia page</a>.  One example of a feed reader is <a
href="http://www.feedly.com" target="blank">Feedly</a>.  There are <a href="http://www.google.com/search?q=rss+aggregator" target="blank">many
others</a>. </p>

</div>

<h2 class="target" id="cal_about">Calendar Links</h2>
<div>

<p> Links are provided to automatically import data from each
conference announcement into <a
href="http://en.wikipedia.org/wiki/Calendaring_software">calendaring
software</a>.  We have a direct link for Google Calendar, and an <a
href="http://en.wikipedia.org/wiki/ICalendar">iCalendar (.ics)</a>
formatted file for importing into other software.</p>

</div>

<h2 class="target" id="curators">Curators</h2>
<div>

<p> The people listed here have volunteered to help curate this site.
They help keep the list up-to-date by adding new announcements, if the
organizers haven't done so themselves.  They receive a copy of the
edit/delete keys for each announcement, and can help if you have any
trouble posting or updating your announcements.  </p>

<p>If you would like to volunteer, please <a
href="http://nilesjohnson.net/contact.html" target="blank">let Niles
know</a>!</p>

<h3>Algebraic and Geometric Topology</h3>
<ul>
<li><a href="http://www.pitt.edu/~krk56/">Chris Kapulkin</a>, University of Pittsburgh</li>
<li>Majid Rasouli</li>
<li><a href="http://dwhite03.web.wesleyan.edu/">David White</a>, Wesleyan University</li>
</ul>

<h3>Arithmetic Geometry</h3>
<ul>
<li><a href="http://www.math.ucsd.edu/~kedlaya/" target="curator">Kiran Kedlaya</a>, UCSD</li>
</ul>
</div>

<!-- reporting disabled
<h2>Reporting Problems</h2>
<div>
<p>
If there are problems with a particular announcement, you can report them using the link provided with each announcement.  This will send an e-mail, together with a brief comment, to the AlgTop-Conf curators.  They will then edit or delete the announcement as necessary.
</p>
</div>
-->

<h2>Searching</h2>
<div>
<p>
The data for each announcement is stored in a database, so search functionality can be easily added.  This will be done in the happy case that the list becomes too large to skim quickly.  
</p>
</div>

<h2>Countries List</h2>
<div>
<p>The list of countries provided when adding new announcements is from the <?php echo $this->Html->link('World countries','https://github.com/mledoze/countries');?> database, licensed under the <?php echo $this->Html->link('Open Database License 1.0','http://opendatacommons.org/licenses/odbl/1.0/')?>.
</p>
</div>

<h2>Tracking</h2>
<div>
<p>
We use Google Analytics for tracking visitors.  This provides a wealth
of useful information about how the site is used, and helps us make
decisions about how to improve functionality.  There are a variety of
options for <a
href="https://duckduckgo.com/?q=google+analytics+disable+tracking"
target="blank">disabling Google Analytics</a>.
</p>

<p>External libraries typically also implement their own tracking.  On
this site, we use some components of the Jquery javascript library and
various social networking buttons on the announcement view pages.</p>

</div>

<h2>Browser Cookies</h2>
<div>

<p> The code from external libraries typically makes use of browser
cookies.  This includes cookies from <tt>google.com</tt>,
<tt>jquery.com</tt>, and <tt>twitter.com</tt>.  These are neither
owned nor set directly by this site, and to our knowledge none of this
site's functionality depends in a critical way on these cookies.<p>

<p>This site does set a browser cookie to store a security key called
a CSRF token.  This is used for processing the New Announcement form
and ensures that malicious users cannot repeatedly submit
announcements using the same successful captcha.  The cookie contains
no user information and is immediately discarded upon use.</p>

</div>

<h2>Source Code</h2>
<div>
<p>
This list application was built with the <a 
href="http://cakephp.org/">CakePHP</a> framework.  The source code is licensed 
under GPL v3, and is hosted in a git repository on GitHub: <a 
href="https://github.com/nilesjohnson/conference-list" target="github">conference-list</a>.</p>

<p>Want to contribute!?  <a
href="https://github.com/nilesjohnson/conference-list"
target="github">Browse the source</a>, have a look at the <a
href="https://github.com/nilesjohnson/conference-list/issues"
target="github">open issues</a>, and clone a working copy of the code.
<a href="http://nilesjohnson.net/contact.html" target="blank">Contact Niles</a> if you have further questions!</p> </div>




