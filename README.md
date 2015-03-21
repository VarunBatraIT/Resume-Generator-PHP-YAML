Resume-Generator-PHP-YAML
=========================
Takes YAML as input, without much of custom processing it will generate your Resume

It is quite generic resume creator. Idea is that it can generate Resume for any type of profile. There is not much role for boottrap other than profile tweaks. 

Getting Started
----------------
* Use composer to install it (composer install)
* Then install assets using bower install
* Edit resume.yml

How it works?
-------------

* Resume will be combination of lists and headings.
* Resume will start at level one and thus heading one, with hierarchy headings will go smaller.
* If heading contains only one element, it will be consider as only paragraph.
* Each line will be parsed for markdowns.

A/B Testing
-----------

Currently there are two themes and are being selected randomly. You can add more themes.

Example
-------

resume.yml is parsed to generate [Varun Batra Resume](http://resume.varunbatra.com/ "Varun Batra Resume")

Google Analytics
----------------

It tracks following:

* Percent of Resume Viewed (Currently configured as split of 4 i.e. 25, 50, 75, 100
* H1,H2,H3 headings viewed
* Selected a particular text
* Click on links
* Mouse over links
