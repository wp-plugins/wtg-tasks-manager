=== Plugin Name ===
Contributors: WebTechGlobal
Donate link: http://www.webtechglobal.co.uk/wtg-tasks-manager-wordpress/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: WTG, Task Manager, Tasks, Task Management, Task, todo, TO DO, to-do, Workflow, project management
Requires at least: 3.8.0
Tested up to: 4.0.0
Stable tag: trunk

Task management with a plan - this plugin will grow to meet the needs of online business managed within WordPress.

== Description ==

Released November 2014 and created to manage multiple projects. The project has a design plan which may take until 2016 to complete
due to some specifications involving integration with plugins not even created yet. Use of Google Docs and other
cloud services is planned. I have a long list of features that will make WTG Tasks Manager more than just a fancy todo list.
Right now the plugin is in-line with most task manager plugins for WordPress but I need more. So you can bet it will grow
as my business grows. I will be using it daily and whenever I need it to do more I'll make it do more. 

= Main Links = 
*   <a href="http://www.webtechglobal.co.uk/wtg-tasks-manager/" title="WebTechGlobals Task Manager Portal">Plugins Portal</a>
*   <a href="http://forum.webtechglobal.co.uk/viewforum.php?f=40" title="WebTechGlobal Forum for Task Manager">Plugins Forum</a>
*   <a href="https://www.facebook.com/pages/WTG-Tasks-Manager-for-WordPress/302610946614839" title="WTG Task Manager Facebook Page">Plugins Facebook</a>
*   <a href="http://www.webtechglobal.co.uk/category/wordpress/wtg-tasks-manager/" title="WebTechGlobal blog category for tasks manager">Plugins Blog</a>
*   <a href="http://www.twitter.com/WebTechGlobal" title="WebTechGlobal Tweets">Plugins Twitter</a>
*   <a href="http://www.youtube.com/playlist?list=PLMYhfJnWwPWD5P2vNf2c9gRsRNqRSVSoV" title="Official YouTube channel for WTG Tasks Manager">YouTube Playlist</a>
*   <a href="#" title="WTG Tasks Manager Review One">Review 1: get your review here</a>
*   <a href="#" title="WTG Tasks Manager Review Two">Review 2: get your review here</a>
*   <a href="#" title="WTG Tasks Manager Review Three">Review 3: get your review here</a>

= Feature List = 

Remember this plugin is a beta so the list will be short for a while.                                
   
1. Use WYSIWYG editor to describe tasks in detail.
1. Tasks are made as a custom post type.
1. Every post box can be added to the Dashboard as a widget.     
 
== Installation ==

1. You can place the wtgtasksmanager folder in the plugins directory using FTP
1. You can also upload the plugin using WordPress plugin screen (wp-admin/plugin-install.php)
1. If your WordPress installation is on a path that includes "wtgtasksmanager" it will trigger debugging to activate. This is meant for localhost development and can be disabled.

== Frequently Asked Questions ==

= Can I import tasks from a .csv file? =
You can import tasks to WTG Tasks Manager from a .csv file using my CSV 2 POST plugin. Tasks in this plugin are
simply posts and CSV 2 POST allows the creation of posts for custom post types. Please use my forum to get help
on this subject.
  
== Screenshots ==

1. Manage Multiple Projects.
2. Simple Import Statistics.
3. Category Data Selection.

== Upgrade Notice ==

Please do not update without backing up your database.

== Changelog == 

= 0.0.32 =
* Feature Changes
    * Import Tasks CSV: new tab on Tasks page for importing .csv file - it is a basic importer, if you need more done to it please make a request in the plugins forum
    * Automatically generated task titles (not handy for everyone) shortened from 50 to 30 characters.
* Technical Information
    * Fix in tasknew() which will allow post excerpt (short description) to be set when it has not been by user.
* Known Issues
    * Search ability still to be complete.
    * Posts view "All" does not show all posts - I think it is a WordPress limitation at this time when using custom statuses. I'll seek a workaround like hooking into the query.
    * post-new.php (Create Task) view cannot be used yet - it does not have all required fields. Please use form provided on plugins own pages until it is improved.
    
== Plugin Author == 

Thank you for considering WTG Tasks Manager. 

== Donators ==
These donators have giving their permission to add their site to this list so that plugin authors can
request their support for their own project. Please do not request donations but instead visit their site,
show interest and tell them about your own plugin - you may get lucky. 

* <a href="" title="">Ryan Bayne from WebTechGlobal</a>

== Contributors: Translation ==
These contributors helped to localize WTG Tasks Manager by translating my endless dialog text.

* None Yet

== Contributors: Code ==
These contributers typed some PHP or HTML or CSS or JavaScript or Ajax for WTG Tasks Manager. Bunch of geeks really! 

* None Yet

== Contributors: Design ==
These contributors created graphics for the plugin and are good with Photoshop. No doubt they spend their time merging different species together!

* None Yet

== Contributors: Video Tutorials ==
These contributors published videos on YouTube or another video streaming website for the community to enjoy...and maybe to get some ad clicks.

* None Yet

== Version Numbers and Updating ==

Explanation of versioning used by myself Ryan Bayne. The versioning scheme I use is called "Semantic Versioning 2.0.0" and more
information about it can be found at http://semver.org/ 

These are the rules followed to increase the WTG Tasks Manager plugin version number. Given a version number MAJOR.MINOR.PATCH, increment the:

MAJOR version when you make incompatible API changes,
MINOR version when you add functionality in a backwards-compatible manner, and
PATCH version when you make backwards-compatible bug fixes.
Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.

= When To Update = 

Browse the changes log and decide if an update is required. There is nothing wrong with skipping version if it does not
help you - look for security related changes or new features that could really benefit you. If you do not see any you may want
to avoid updating. If you decide to apply the new version - do so after you have backedup your entire WordPress installation 
(files and data). Files only or data only is not a suitable backup. Every WordPress installation is different and creates a different
environment for WTG Task Manager - possibly an environment that triggers faults with the new version of this software. This is common
in software development and it is why we need to make preparations that allow reversal of major changes to our website.