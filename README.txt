MAINTENANCE PLUGIN
------------------

This plugin is written to prevent site wide access to a Wolf website when it is in "Maintenance Mode".

When a client requests a page, we check if the site is in Maintenance Mode or not and decide what to display.

When in Maintenance Mode you can set up this plugin to:

	- Redirect to an allowed page on your site, or to an external site
	- Display a defined set of content, which you can edit in this plugins admin section

You can allow IP addresses through the block and attach names and notes to each IP so you can easily see who is able to access the site.



HOW TO USE
----------

1. Install the plugin via the Administration section of your Wolf installation
2. Visit the "Maintenance" tab in the admin area and configure the plugin to your specifications.



DEVELOPERS
----------

For developers, there are two Observers which are triggered when a page request is dealt with by this plugin:

	- Observer::notify('maintenance_page_requested', $uri);
	- Observer::notify('maintenance_page_displayed', $uri);

By setting up a listener for these Observers, you can use this data in your own context.



NOTES
-----

	BACKDOOR
		There is a backdoor into the site during maintenance mode, but it must be enabled to work.
		It isn't advised to enable it but may come in handy if blocking solely by IP address does not satisfy your needs.
		Adding ?backdoorkey=YOUR_KEY_HERE to the URL of a page which is otherwise restricted will unlock that page for you.
		You need to set up your key in the plugin settings page.

	LOCAL DEVELOPMENT
		If you have a server running on your local machine, when you access it, your IP address in PHP Env will usually be 127.0.0.1
		As part of the enable script, this will be added to the access list to save you the step / headache.