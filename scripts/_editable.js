/**
 * NewsBlocks Demo
 * <http://newsblocks.simplepie.org>
 *
 * A simple demo that clones the main functionality of sites like PopURLs, 
 * TheWebList, Original Signal, MiniBoxs, and others. Development sponsored 
 * by Level 5 Studio <http://level5studio.com>. Go check them out!
 * 
 * Uses the following from MooTools 1.11:
 *   * Array.each <http://docs.mootools.net/Native/Array.js#Array.each>
 *   * Element.setStyle <http://docs.mootools.net/Native/Element.js#Element.setStyle>
 *   * Element.addEvent <http://docs.mootools.net/Element/Element-Event.js#Element.addEvent>
 *   * Event.stop <http://docs.mootools.net/Element/Element-Event.js#Event.stop>
 *   * Fx.Slide <http://docs.mootools.net/Effects/Fx-Slide.js>
 *   * Tips <http://docs.mootools.net/Plugins/Tips.js>
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


/***********************************************************
 RUN WHEN PAGE LOADS
***********************************************************/

// Wait for the DOM to be loaded.
window.addEvent('domready', function() {


	/***********************************************************
	 PREPARATION
	***********************************************************/

	// This will help us keep track of sliders already initialized.
	var store = [];

	// Grab all <ul class="secondary"> tags.
	$$('ul.secondary').each(function(e) {

		// Determine the part of the ID that is shared.
		var eid = e.id.replace(/s_/gi, '');

		// Keep track of it.
		store[eid] = new Fx.Slide(e).hide();

		// Set the secondary list to display:block instead of display:none
		$('s_' + eid).setStyle('display', 'block');
	});


	/***********************************************************
	 TOOLTIPS
	***********************************************************/

	// Define all elements to be tooltips.
	var tooltips = $$('li.tips a');

	// Generate the tooltips.
	var tipHandle = new Tips(tooltips, {
		maxTitleChars: 200
	});


	/***********************************************************
	 HANDLE "MORE" LINKS
	***********************************************************/

	// Attach an onclick event to all <a class="more"> elements.
	$$('a.more').addEvent('click', function(e) {

		// This will be the slider store identifier for this event.
		var id = this.id.replace(/m_/gi, '');

		// Retrieve the object from the store and toggle it.
		var fx = store[id];
		fx.toggle();

		// Prevent the link from going through.
		(new Event(e)).stop();
	});
});
