Conference List Web App
-----------------------

https://github.com/nilesjohnson/conference-list

version 2.2

AUGUST 2023

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
    along with this program.  If not, see <https://www.gnu.org/licenses/>.


DESCRIPTION
-----------

Conference List is a web application for community-maintained
public lists (e.g. math conferences).  Its basic functions are:

* A web form for adding new announcements, storing them in a database.
* An interface for viewing announcements, sorted by date or location.
* Interfaces to update and delete announcements.

The application is based on the Cake PHP framework (version 2.4.5):  
https://cakephp.org/


CHANGELOG
---------

### v. 2.2 (August 2023) ###

* New location option: 'Online'
* New database fields 'created' and 'modified'

### v. 2.1.5 (July 2019) ###

* Enable configuration for sending email through external servers 

### v. 2.1.4 ###

* Rudimentary login for curators

### v. 2.1.3 ###

* ICS feed
* Rudimentary search

### v. 2.1.2 ###

* SSL support
* Google reCaptcha

### v. 2.1.1 ###

* support json and xml views

### v. 2.1 ###

* Now filter announcements by subject tags

* Set specific admin email addresses for individual tags

* Form for editing announcements is now the same as that for adding
  new announcements

* New 'view' page for each announcement, and announcement data in
  confirmation emails

* Select boxes improved with select2 (jquery)

* Links to sort by country or show past announcements have been
  removed as these features are rarely used and are incompatible with
  the subject tags.  If you would like to see these features
  reimplemented, please let Niles know!



CONFIGURATION
-------------

### Begin by cloning the git repository ###

    git clone --recursive https://github.com/nilesjohnson/conference-list.git conference-list

The `--recursive` flag automatically clones the two necessary submodules:

- "countries" submodule: https://github.com/mledoze/countries
- "Recaptcha" submodule: https://github.com/CakeDC/recaptcha

You can also use this command: `git submodule update --init --recursive`

### Clone the cakephp repository ###
If you don't already have it:

    git clone https://github.com/cakephp/cakephp.git cakephp


### Set up the app ###
There are five basic configuration steps necessary to get the app running:

1. Set up cakephp library and vendors.

 - Point to a copy of cakephp library:  Put a copy (or symbolic link) of 'cakephp/lib' at 'conference-list/Lib/cakephp-lib'

    `ln -s /path/to/cakephp/lib /path/to/conference-list/Lib/cakephp-lib`

 - Same for 'cakephp/vendors':

    `ln -s /path/to/cakephp/vendors /path/to/conference-list/Lib/vendors`

1. Create a private configuration file by copying the default one:

    `cd conference-list/Config/`
    
    `cp conflistConfigDefault.php conflistConfigPrivate.php`

1. Set up a database and put the connection information 
(user, password, etc.) in the private configuration file from step 2.

1. Register with [Google reCAPTCHA](https://www.google.com/recaptcha) and
set the Recaptcha keys in the private configuration file.

1. Update the rest of the settings in the private configuration file:
     * site info (name, admin email, etc.)
     * new values (random strings) for:
          * admin_key
          * admin_cookie
          * Security.salt
          * Security.cipherSeed
          
   DO NOT leave these default values as this will comprimise your site's security.

1. Create the necessary database tables and (optionally) initial data 
for testing.  This can be done with the file `db_create_3`. 
Edit it to work on the correct database, and run it with the following:

      mysql -p -u <USERNAME> <DB_NAME> < db_create_3 



ADDITIONAL NOTES
----------------

- Incorrect ownership permissions for the `tmp` directory can cause
  cake apps to fail without explanation. To fix, use something like
  `chown -R www-data tmp`.


ADMINISTRATION
--------------

Site administrators receive a copy of every confirmation email.  If
this is lost or the edit keys there are invalid for some reason, you
can get the edit/delete url for conference number `N` as follows:
Navigate to `conferences/admin/N` and use the admin key from your
private config file.  You can also use conference-specific edit key
there.


HISTORY
-------

This project began as `cakephp-conference-list` available at
  * https://bitbucket.org/nilesjohnson/cakephp-conference-list/
  * https://code.google.com/archive/p/cakephp-conference-list/



