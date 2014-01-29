Introduction
============

This plugin will prevent site wide access to a Wolf CMS website when it is in "maintenance mode". When a client
requests a page, the plugin checks if the site is in maintenance mode or not and decides what to display.

With the site in maintenance mode, you can instruct the plugin to:

	- Redirect to an allowed page on your site,
	- Redirect to an external site, or
	- Display a pre-defined set of content, which you can edit in the plugin's admin section

You can allow certain IPv4 addresses through the block and attach names and notes to each IPv4 address so you can
easily see who is able to access the site.


Usage
-----

1. Install the plugin as normal and enable it via the administrative section of your Wolf CMS installation.
2. Visit the "Maintenance" tab in the admin area and configure the plugin to your specifications.


Developers
----------

For developers, there are three Observer notifications which are triggered when a page request is dealt with by this plugin:

	- Observer::notify('maintenance_page_requested', $uri);
	- Observer::notify('maintenance_page_displayed', $uri);
	- Observer::notify('maintenance_page_bypassed', $ip, $uri);

By setting up a listener for these notifications, you can use the provided data in your own context.



Notes
-----

	BACKDOOR
		There is a backdoor into the site during maintenance mode, but it must be enabled to work.
		
		It isn't advised to enable it but may come in handy if blocking solely by IP address does
		not satisfy your needs.
		
		Adding ?backdoorkey=YOUR_KEY_HERE to the URL of a page which is otherwise restricted will
		unlock that page for you. You need to set up your key in the plugin settings page.

	LOCAL DEVELOPMENT
		If you have a server running on your local machine, when you access it, your IP address in
		PHP Env will usually be 127.0.0.1
		
		As part of the enable script, this will be automatically added to the access list.

	IP WISHLIST
		- Although not here now, I would like to build in the option to use IPv6 and IPv4 in the future.
		- Also, I would like to build in IP ranges rather than individual addresses as they are now.
		- Display a message to users who can access Pages ("You are viewing this page because...")
		- Allow users with backdoor keys access to the whole site (maybe a javascript function to append
		  the backdoor key to each internal url on a page)


Changelog
---------

1.1.0

+ Major Model refactor
+ Minor bug fixes
+ New Observer added: maintenance_page_bypassed

1.0.1

+ Fixed bug in controller so that mod_rewrite doesn't break access control

1.0.0

+ First Build
