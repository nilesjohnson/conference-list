Conference List Web App

version 2.0
March 2014

Copyright (C) 2009--2014 Niles Johnson <http://www.nilesjohnson.net>
Licensed under GNU GPL v.3 or later.  See LICENSE.txt for a copy of
the license.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.


DESCRIPTION
-----------

Conference List is a web application for community-maintained
public lists (e.g. math conferences).  Its basic functions are:

* A web form for adding new announcements, storing them in a database.
* An interface for viewing announcements, sorted by date or location.
* Interfaces to update and delete announcements.

The application is based on the Cake PHP framework (version 2.4.5).


CONFIGURATION
-------------

Begin by cloning the git repository, e.g:

    git clone <URL.git> conference-list

If you don't yet have cake available, clone that too:

    git clone https://github.com/cakephp/cakephp.git cakephp

Then there are four basic configuration steps necessary to get the app running:

1. Point to a copy of cakephp library:  Put a copy (or symbolic link) of 
'cakephp/lib' at 'conference-list/Lib/cakephp-lib'

    ln -s /path/to/cakephp/lib /path/to/conference-list/Lib/cakephp-lib

2. Create a private configuration file by copying the default one:

    cd conference-list/Config/
    cp conflistConfigDefault.php conflistConfigPrivate.php

3. Set up a database and put the connection information 
(user, password, etc.) in the private configuration file from step 2.

4. Update the rest of the settings in the private configuration file 
from step 2.
