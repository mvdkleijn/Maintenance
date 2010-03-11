<?php if(!defined('IN_CMS')) { exit(); } ?>

<h1>Maintenance Plugin</h1>

<h2>About</h2>
<p>This plugin is written to prevent site wide access to a Wolf website when it is in "Maintenance Mode".</p>
<p>When a client requests a page, we check if the site is in Maintenance Mode or not and decide what to display.</p>
<p>When in Maintenance Mode you can set up this plugin to:</p>
<ul>
	<li>- Redirect to an allowed page on your site, or to an external site</li>
	<li>- Display some custom HTML, which you can <a href="<?php echo get_url('maintenance/settings'); ?>">edit here</a></li>
</ul>
<p>You can allow access to the site by IP and attach names and notes to each IP so you can easily see who is able to access the site.</p>

<h2>Backdoor</h2>
<p>You can allow access to a page that would otherwise be restricted by using a specified GET variable in the URL.</p>
<p>For example, if your page is:</p>
<p><small><strong><?php echo URL_PUBLIC; ?>about-us/what-we-do</strong></small></p>
<p>And maintenance mode is on, you can view this page by visiting this URL:</p>
<p><small><strong><?php echo URL_PUBLIC; ?>about-us/what-we-do?backdoorkey=<?php echo $settings['maintenanceBackdoorKey']; ?></strong></small></p>

<h2>Observers</h2>
<p>There are two observers which you can use to hook into your own functions:</p>
<p><small><strong>maintenance_page_requested($uri)</strong></small><br />Fired when a page is requested in maintenance mode. The Page URI is passed to your listener.</p>
<p><small><strong>maintenance_page_displayed($uri)</strong></small><br />Fired when an unauthorised person tries to access your site whilst in maintenance mode. The Page URI is passed to your listener.</p>
<p><small><strong>maintenance_page_bypassed($ip, $uri)</strong></small><br />Fired when an authorised person accesses a page, either with a backdoor key or because they are from a validated IP address. The IP address and Page URI is passed to your listener.</p>