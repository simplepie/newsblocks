<?php
/**
 * NewsBlocks Demo
 * <http://newsblocks.simplepie.org>
 *
 * A simple demo that clones the main functionality of sites like PopURLs, 
 * TheWebList, Original Signal, MiniBoxs, and others. Development sponsored 
 * by Level 5 Studio <http://level5studio.com>. Go check them out!
 * 
 * This is a sample homepage that adds several feeds with various test 
 * configurations. There are lots of configuration options available that 
 * are documented at <http://newsblocks.simplepie.org>.
 * 
 * THIS IS NOT INTENDED TO BE A COMPREHENSIVE SOLUTION. THIS IS INTENDED 
 * AS A SOLID STARTING POINT FROM WHICH TO WRITE YOUR OWN CODE TO CUSTOMIZE 
 * IT HOWEVER YOU CHOOSE. IF YOU DON'T KNOW HTML, CSS, JAVASCRIPT, OR PHP, 
 * YOUR CUSTOMIZATION OPTIONS ARE LIMITED.
 *
 * @package NewsBlocks
 * @version 2.0
 * @author Ryan Parman
 * @link http://simplepie.org/wiki/tutorial/how_to_replicate_popurls NewsBlocks tutorial page.
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */


/****************************************************
 INCLUDE EXTERNAL LIBRARIES
****************************************************/
//require_once('./php/simplepie.inc');
require_once('../../../releases/1.1.1/simplepie.inc');
require_once('./php/newsblocks.inc.php');


/****************************************************
 SET HTTP HEADERS
****************************************************/
header('Content-type:text/html; charset=utf-8');


/****************************************************
 SET THE LOCALE
 Affects the language of datestamps for items. 
****************************************************/
// setlocale(LC_TIME, 'en_US');


/****************************************************
 BEGIN HTML OUTPUT
****************************************************/
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>NewsBlocks Demo</title>
		<link rel="stylesheet" href="./css/newsblocks.css" type="text/css" media="screen" title="NewsBlocks" charset="utf-8" />
	</head>

	<body>
		<div id="site">

			<div id="navigation">
				<h1>NewsBlocks Demo 2.0</h1>
				<p>Made possible by <a href="http://mootools.net/">MooTools</a>, <a href="http://simplepie.org">SimplePie</a>, and a sponsorship from <a href="http://level5studio.com">Level 5 Studio</a>.</p>
			</div>

			<div id="content">

				<div class="hr" rel="hr"><hr /></div>

				<!-- FIRST 3-COLUMN SECTION -->
				<div class="container thirds">
					<div class="section">
						<?php echo newsblocks::listing(array(
							'http://digg.com/rss/containertechnology.xml',
							'http://feeds.mixx.com/MixxScienceTech'
						), array(
							'title' => 'Technology News',
							'direction' => 'ltr',
							'items' => 5
						)); ?>
					</div>

					<div class="section">
						<?php echo newsblocks::listing('http://daringfireball.net/index.xml', array(
							'items' => 5
						)); ?>
					</div>

					<div class="section">
						<?php echo newsblocks::listing('http://images.apple.com/main/rss/hotnews/hotnews.rss', array(
							'more_move' => true,
							'items' => 5
						)); ?>
					</div>
				</div>

				<div class="hr" rel="hr"><hr /></div>

				<!-- FIRST THUMBNAIL SECTION -->
				<?php echo newsblocks::wide('http://api.flickr.com/services/feeds/photos_public.gne?id=33495701@N00&lang=en-us&format=rss_200', array(
					'items' => 11,
					'title' => 'Ryan\'s Flickr (thumbnails)',
					'favicon' => 'http://www.flickr.com/favicon.ico'
				)); ?>

				<div class="hr" rel="hr"><hr /></div>

				<!-- SECOND 3-COLUMN SECTION -->
				<div class="container thirds">
					<div class="section">
						<?php echo newsblocks::listing('http://youtube.com/rss/global/top_rated.rss', array(
							'title' => 'YouTube'
						)); ?>
					</div>

					<div class="section">
						<?php echo newsblocks::listing('http://revision3.com/diggnation/feed/quicktime-large/', array(
							'title' => 'Diggnation'
						)); ?>
					</div>

					<div class="section">
						<?php echo newsblocks::listing('http://api.flickr.com/services/feeds/photos_public.gne?id=33495701@N00&lang=en-us&format=rss_200', array(
							'title' => 'Ryan\'s Flickr'
						)); ?>
					</div>
				</div>

				<div class="hr" rel="hr"><hr /></div>

				<!-- SECOND THUMBNAIL SECTION -->
				<?php echo newsblocks::wide('http://youtube.com/rss/global/top_rated.rss', array(
					'items' => 7,
					'title' => 'YouTube (thumbnails)',
					'permalink' => 'http://youtube.com'
				)); ?>

				<div class="hr" rel="hr"><hr /></div>

				<!-- THIRD 3-COLUMN SECTION -->
				<div class="container thirds">
					<div class="section">
						<?php echo newsblocks::listing('http://blog.japan.cnet.com/lessig/index.rdf'); ?>
					</div>

					<div class="section">
						<?php echo newsblocks::listing('http://newsrss.bbc.co.uk/rss/russian/news/rss.xml'); ?>
					</div>

					<div class="section">
						<?php echo newsblocks::listing('http://hagada.org.il/hagada/html/backend.php', array(
							'direction' => 'rtl'
						)); ?>
					</div>
				</div>

			</div>

			<div id="footer">
				<p>NewsBlocks Demo 2.0 by <a href="http://ryanparman.com">Ryan Parman</a>. Made possible by <a href="http://mootools.net/">MooTools</a>, <a href="http://simplepie.org">SimplePie</a>, and a sponsorship from <a href="http://level5studio.com">Level 5 Studio</a>.</p>
			</div>

		</div>

		<script src="./scripts/newsblocks.js" type="text/javascript" charset="utf-8"></script>

	</body>
</html>
