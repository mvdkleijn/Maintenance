<h1>Maintenance Manager</h1>

<p>&nbsp;</p>

<h3>About</h3>
<p>This plugin is written to prevent site wide access to a Wolf website when it is in "Maintenance Mode".</p>
<p>When a client requests a page, we check if the site is in Maintenance Mode or not and decide what to display.</p>
<p>When in Maintenance Mode you can set up this plugin to:</p>
<ul>
	<li>- Redirect to an allowed page on your site, or to an external site</li>
	<li>- Display a defined set of content, which you can edit in this plugins admin section</li>
</ul>
<p>You can allow IP addresses through the block and attach names and notes to each IP so you can easily see who is able to access the site.</p>

<p>&nbsp;</p>

<h3>Backdoor</h3>
<p>You can allow access to a page that would otherwise be restricted by using a specified GET variable in the URL.</p>
<p>For example, if your page is:</p>
<p><small><strong><?php echo URL_PUBLIC; ?>about-us/what-we-do</strong></small></p>
<p>And maintenance mode is on, you can view this page by visiting this URL:</p>
<p><small><strong><?php echo URL_PUBLIC; ?>about-us/what-we-do?backdoorkey=<?php echo $settings['maintenanceBackdoorKey']; ?></strong></small></p>
