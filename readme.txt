=== Plugin Name ===
Contributors: WebTechGlobal
Donate link: http://www.webtechglobal.co.uk/wtg-tasks-manager-wordpress/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: WTG Tasks Manager, Task Manager, Tasks, Task Management, Task, todo, TO DO, to-do, Workflow
Requires at least: 3.8.0
Tested up to: 4.0.0
Stable tag: trunk

Task management with a plan - this plugin will grow to meet the needs of online business managed within WordPress.

== Description ==

Released 2014 and created to manage over 100 projects. The project has a design plan which may take until 2016 to complete
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

= Feature List = 

Remember this plugin is a beta so the list will be short for a while.                                
   
1. Use WYSIWYG editor to describe tasks in detail.
1. Tasks are made as a custom post type.
1. Every post box can be added to the Dashboard as a widget.     
 
== Installation ==

1. You can place the wtgtasksmanager folder in the plugins directory using FTP
1. You can also upload the plugin using Wordpress plugin screen (wp-admin/plugin-install.php)
1. If your Wordpress installation is on a path that includes "wtgtasksmanager" it will trigger debugging to activate. This is meant for localhost development and can be disabled.

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

= 0.0.2 =
* Feature Changes
    * Freelancer Offer field: enter the amount of cash (with currency symbol) that your happy to pay a freelancer who completes the task.
    * Required Capability menu: select the capability required to view a task. Not fully applied - only admin will be able to view tasks for some versions to come. Security related changes will always be rolled out slowly.
    * Now users must select a project before submitting New Task form.
* Technical Information
    * Beta views removed from package.
    * Plugin update view added to package.
* Known Issues
    * Search ability still to be complete.
    * Posts view "All" does not show all posts - it is a WordPress limitation at this time when using custom statuses. I'll seek a workaround like hooking into the query.
* Author Updates
    * New Donators: None
    * New Contributors: None
    
= 0.0.1 =
* Feature Changes
    * Beta plugin - just getting started!
* Technical Information
    * The plugin now adds a custom post type (tasks) and two new tables to the database.
* Known Issues
    * Search ability still to be complete.

== Plugin Author == 

Thank you for considering WTG Tasks Manager. 

== Donators ==
These donators have giving their permission to add their site to this list so that plugin authors can
request their support for their own project. Please do not request donations but instead visit their site,
show interest and tell them about your plugin - you may get lucky. 

* None Yet

== Contributors: Translation ==
These contributors helped to localize WTG Tasks Manager by translating my endless dialog text.

* None Yet

== Contributors: Code ==
These contributers typed some PHP or HTML or CSS or JavaScript or Ajax for WTG Tasks Manager. Bunch of geeks really! 

* None Yet

== Contributors: Design ==
These contributors created graphics for the plugin and are good with Photoshop. The "fake celebrity pics" creators no doubt!

* None Yet

== Contributors: Video Tutorials ==
These contributors published videos on YouTube or another video streaming website. Please take interest in any ads that may appear while watching them!

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