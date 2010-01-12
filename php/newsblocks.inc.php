<?php
/**
 * NewsBlocks Demo
 * <http://newsblocks.simplepie.org>
 *
 * A simple demo that clones the main functionality of sites like PopURLs, 
 * TheWebList, Original Signal, MiniBoxs, and others. Development sponsored 
 * by Level 5 Studio <http://level5studio.com>. Go check them out!
 * 
 * These are the functions that do all of the heavy lifting.
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


/**
 * Define a few constants.
 */
define('NB_FAVICON_DEFAULT', './images/alternate_favicon.png');
define('NB_NEW_HTML', '<img src="./images/new.png" alt="New!" title="This was posted within the last 24 hours.">');


/**
 * A wrapper for all of the functions used.
 */
class newsblocks
{
	/**
	 * Handles all of the heavy lifting for getting the feed, parsing it, and managing customizations.
	 *
	 * @access private
	 * @param mixed $url Either a single feed URL (as a string) or an array of feed URLs (as an array of strings).
	 * @param array $options An associative array of options that the function should take into account when rendering the markup.
	 * <ul>
	 *     <li>string $classname  - The classname that the <div> surrounding the feed should have. Defaults to nb-list for newsblocks::listing() and nb-wide for newsblocks::wide().</li>
	 *     <li>string $copyright - The copyright string to use for a feed. Not part of the standard output, but it's available if you want to use it. Defaults to NULL with multifeeds; Use $item->get_feed()->get_copyright() instead.</li>
	 *     <li>string $date_format - The format to use when displaying dates on items. Uses values from http://php.net/strftime, NOT http://php.net/date.</li>
	 *     <li>string $description - The description for the feed (not the item). Not part of the standard output, but it's available if you want to use it. Defaults to NULL with multifeeds; Use $item->get_feed()->get_description() instead.</li>
	 *     <li>string $direction - The direction of the text. Valid values are "ltr" and "rtl". Defaults to "ltr".</li>
	 *     <li>string $favicon - The favicon URL to use for the feed. Since favicon URLs aren't actually located in feeds, SimplePie guesses. Sometimes that guess is wrong. Give it the correct favicon with this option. Defaults to NULL with multifeeds; Use $item->get_feed()->get_favicon() instead.</li>
	 *     <li>string $id - The ID attribute that the <div> surrounding the feed should have. This value should be unique per feed. Defaults to a SHA1 hash value based on the URL(s).</li>
	 *     <li>string $item_classname - The classname for the items. Useful for styling with CSS. Also useful for JavaScript in creating custom tooltips for a feed. Defaults to "tips".</li>
	 *     <li>integer $items - The number of items to show (the rest are hidden until "More" is clicked). Defaults to 10.</li>
	 *     <li>string $language - The language of the feed. Not part of the standard output, but it's available if you want to use it. Defaults to NULL with multifeeds; Use $item->get_feed()->get_language() instead.</li>
	 *     <li>integer $length - The maximum character length of the item description in the tooltip. Defaults to 200.</li>
	 *     <li>string $more - The text to use for the "More" link. Defaults to "More &raquo;"</li>
	 *     <li>boolean $more_move - Whether the "More" link should move when it's clicked. Defaults to FALSE (i.e. stays in the same place).</li>
	 *     <li>boolean $more_fx - Whether the secondary list should slide or simply appear/disappear when the "More" link is clicked. Defaults to TRUE (i.e. slides).</li>
	 *     <li>string $permalink - The permalink for the feed (not the item). Defaults to NULL with multifeeds; Use $item->get_feed()->get_permalink() instead.</li>
	 *     <li>boolean $show_title - Whether to show the title of the feed. Defaults to TRUE.</li>
	 *     <li>integer $since - A Unix timestamp. Anything posted more recently than this timestamp will get the "New" image applied to it. Defaults to 24 hours ago.</li>
	 *     <li>$string $title - The title for the feed (not the item). Defaults to multiple titles with multifeeds, so you should manually set it in that case.</li>
	 * </ul>
	 * @return string The (X)HTML markup to display on the page.
	 */
	function data($url, $options = null)
	{
		// Create a new SimplePie instance with this feed
		$feed = new SimplePie();
		$feed->set_feed_url($url);
		$feed->init();

		// Prep URL values to hash later.
		if (!is_array($url)) $hash_str = array($url);
		else $hash_str = $url;

		// Set the default values.
		$classname = null;
		$copyright = $feed->get_copyright();
		$date_format = '%a, %e %b %Y, %I:%M %p';
		$description = $feed->get_description();
		$direction = 'ltr';
		$favicon = $feed->get_favicon();
		$id = 'a' . sha1(implode('', $hash_str));
		$item_classname = 'tips';
		$items = 10;
		$language = $feed->get_language();
		$length = 200;
		$more = 'More &raquo;';
		$more_move = false;
		$more_fx = true;
		$permalink = $feed->get_permalink();
		$show_title = true;
		$since = time() - (24*60*60); // 24 hours ago.
		$title = $feed->get_title();

		// Override defaults with passed-in values.
		extract($options);

		// Set values for those that are still null
		if (!$favicon) $favicon = NB_FAVICON_DEFAULT;
		if (!$title)
		{
			if (is_array($url))
			{
				$feed_title = array();
				foreach ($url as $u)
				{
					$feed_title[] = newsblocks::name($u);
				}
				$title = implode(', ', $feed_title);
			}
		}

		// Send the data back to the calling function.
		return array(
			'classname' => $classname,
			'copyright' => $copyright,
			'date_format' => $date_format,
			'description' => $description,
			'direction' => $direction,
			'favicon' => $favicon,
			'feed' => $feed,
			'id' => $id,
			'item_classname' => $item_classname,
			'items' => $items,
			'language' => $language,
			'length' => $length,
			'more' => $more,
			'more_move' => $more_move,
			'more_fx' => $more_fx,
			'permalink' => $permalink,
			'show_title' => $show_title,
			'since' => $since,
			'title' => $title
		);
	}


	/**
	 * Renders the display for a normal text-oriented feed.
	 *
	 * @access public
	 * @param mixed $url Either a single feed URL (as a string) or an array of feed URLs (as an array of strings).
	 * @param array $options An associative array of options that the function should take into account when rendering the markup. See documentation for data() for details.
	 * @return string The HTML markup to display on the page.
	 */
	function listing($url, $options = null)
	{
		// Retrieve the data and break out the individual variables (i.e. $title and $permalink are usable)
		if (!$options) $options = array();
		extract(newsblocks::data($url, $options));

		if (!$classname) $classname = 'nb-list';

		// Open a <div> with a class of "block" (which we'll use for styling) and an id of some random value (for targetting via JavaScript)
		$html = '<div class="' . $classname . '" id="' . $id . '">' . "\n";

		// As long as we're supposed to show the title.
		if ($show_title)
		{
			// Here's the name of the feed, formatted the way we want.
			$html .= '<h3>'; // Header tag
			$html .= '<img src="' . $favicon . '" width="16" height="16" /> '; // Favicon
			if ($permalink) $html .= '<a href="' . $permalink . '">'; // Link (if available)
			$html .= $title; // Title
			if ($permalink) $html .= '</a>'; // Close link (if available)
			$html .= '</h3>' . "\n"; // Close header
		}

		// Go through the same thing twice -- once for the primary, and once for the secondary.
		for ($x = 0; $x < 2; $x++)
		{
			$secondary = ($x % 2);

			// If we want the "More" link to stay, put it between the first and second lists.
			if (!$more_move && $secondary)
			{
				// If we have more than ($items) items in the feed...
				if ($feed->get_item_quantity() > $items)
				{
					// Add a little "More" link for people to click on.
					$html .= '<p class="more"><a href="" class="more" id="m_' . $id . '">' . $more . '</a></p>' . "\n";
				}
			}

			// Start the <ul> list. Automatically set whether this is the shown or hidden part of the list, as well as the direction of the text.
			$html .= '<ul id="' . ($secondary ? 's_' : 'p_') . $id . '" class="' . ($secondary ? 'secondary' : 'primary') . '" style="direction:' . $direction . ';' . ($secondary ? 'display:none;' : '') . '">' . "\n";

			// Ensure that the right lists are being generated for shown/hidden items (as per the "More" link).
			if ($secondary) // 0 or 1
			{
				// Secondary
				$counter_start = $items;
				$counter_length = 0;
			}
			else
			{
				// Primary
				$counter_start = 0;
				$counter_length = $items;
			}

			foreach ($feed->get_items($counter_start, $counter_length) as $item)
			{
				// Set default values to be overridden by newsblocks::has_enclosure().
				$class = '';
				$type = '';
				$new = '';

				// Set some values if the item has an enclosure.
				extract(newsblocks::has_enclosure($item));

				// Compare the timestamp of the feed item with $since (defaults to 24 hours ago).
				if ($item->get_date('U') > $since)
				{
					// Let's add a "new" image to the end.
					$new = NB_NEW_HTML;
				}

				// Create the title attribute
				$title_attr = newsblocks::get_title_attr($item, $length, $date_format);

				// Add each item: item title, linked back to the original posting, with a tooltip containing the description.
				$html .= '<li class="' . $item_classname . (($class != '') ? ' ' . $class : '') . '">'; // <li> tag.
				$html .= '<a href="' . $item->get_permalink() . '" title="' . $title_attr . '">'; // <a> tag with a short description in the title attribute.
				$html .= $item->get_title(); // The title for the link
				$html .= '</a>'; // Close the </a>
				$html .= ' ' . $new . '</li>' . "\n"; // Add the "New" image (if necessary), then close the </li>
			}

			// Close out of the primary list
			$html .= '</ul>' . "\n";
		}

		// If we want the "More" link to move, put it at the end of the list.
		if ($more_move)
		{
			// If we have more than ($items) items in the feed...
			if ($feed->get_item_quantity() > $items)
			{
				// Add a little "More" link for people to click on.
				$html .= '<p class="more"><a href="" class="more" id="m_' . $id . '">' . $more . '</a></p>' . "\n";
			}
		}

		// Close out of this <div> block.
		$html .= '</div>' . "\n";

		// Return all of the HTML, so that we can display it as we choose or manipulate it further.
		return $html;
	}


	/**
	 * Renders a simpler, wider display for media-oriented feeds containing thumbnails.
	 *
	 * @access public
	 * @param mixed $url Either a single feed URL (as a string) or an array of feed URLs (as an array of strings).
	 * @param array $options An associative array of options that the function should take into account when rendering the markup. See documentation for data() for details.
	 * @return string The (X)HTML markup to display on the page.
	 */
	function wide($url, $options = null)
	{
		// Retrieve the data and break out the individual variables (i.e. $title and $permalink are usable)
		if (!$options) $options = array();
		extract(newsblocks::data($url, $options));

		if (!$classname) $classname = 'nb-wide';

		// Open a <div> with a class of "block" (which we'll use for styling) and an id of some random value (for targetting via JavaScript)
		$html = '<div class="' . $classname . '" id="' . $id . '">' . "\n";

		// As long as we're supposed to show the title.
		if ($show_title)
		{
			// Here's the name of the feed, formatted the way we want.
			$html .= '<h3>'; // Header tag
			$html .= '<img src="' . $favicon . '" width="16" height="16" /> '; // Favicon
			if ($permalink) $html .= '<a href="' . $permalink . '">'; // Link (if available)
			$html .= $title; // Title
			if ($permalink) $html .= '</a>'; // Close link (if available)
			$html .= '</h3>' . "\n"; // Close header
		}

		$html .= '<ul>' . "\n";

		foreach ($feed->get_items(0, $items) as $item)
		{
			// Check to see if we have an enclosure so we can add a special icon
			if ($enclosure = $item->get_enclosure())
			{
				// Check to see if we have a thumbnail.  We need it because this is going to display an image.
				if ($thumb = $enclosure->get_thumbnail())
				{
					// Create the title attribute
					$title_attr = newsblocks::get_title_attr($item, $length, $date_format);

					// Add each item: item title, linked back to the original posting, with a tooltip containing the description.
					$html .= '<li class="' . $item_classname . '">';
					$html .= '<a href="' . $item->get_permalink() . '" title="' . $title_attr . '">'; // <a> tag with a short description in the title attribute.
					$html .= '<img src="' . $thumb . '" alt="' . $item->get_title() . '" border="0" />';
					$html .= '</a>';
					$html .= '</li>' . "\n";
				}
			}
		}

		// Close out of the primary list
		$html .= '</ul>' . "\n";

		// Close out of this <div> block.
		$html .= '</div>' . "\n";

		// Return all of the HTML, so that we can display it as we choose or manipulate it further.
		return $html;
	}


	/**
	 * Sets special classnames if $item contains an enclosure.
	 *
	 * @access public
	 * @param SimplePie_Item $item The item object to check.
	 * @return array Class and Type values.
	 */
	function has_enclosure($item)
	{
		// Set default values
		$class = '';
		$type = '';

		// Check to see if we have an enclosure so we can add a special icon
		if ($enclosure = $item->get_enclosure())
		{
			// Figure out the mime type of the enclosure
			$type = $enclosure->get_real_type();

			// Is it a video?
			if (stristr($type, 'video/') || stristr($type, 'x-shockwave-flash'))
			{
				$class = 'enclosure video';
			}

			// Is it audio?
			elseif (stristr($type, 'audio/'))
			{
				$class = 'enclosure audio';
			}

			// Is it an image?
			elseif (stristr($type, 'image/'))
			{
				$class = 'enclosure image';
			}
		}

		return array(
			'class' => $class, 
			'type' => $type
		);
	}


	/**
	 * Pieces together the title attribute without using inline ternary conditional statements
	 *
	 * @access public
	 * @param SimplePie_Item $item The item to generate the title attribute for.
	 * @param integer $length The number of characters to return in the description.
	 * @param string $date_format The format to use when displaying dates on items. Uses values from http://php.net/strftime, NOT http://php.net/date.
	 * @return string The string for the title attribute.
	 */
	function get_title_attr($item, $length, $date_format)
	{
		// Get a handle for the item's parent feed object for PHP 4.x.
		$parent = $item->get_feed();

		$title_attr = '';

		$title_attr .= $item->get_title(); // The title of the post
		$title_attr .= ' :: '; // The separator between the title and the description (required by MooTools)
		$title_attr .= newsblocks::cleanup($item->get_description(), $length); // The cleaned-up and shortened version of the description
		$title_attr .= '<span>'; // This marks the beginning of the date/domain line (and is CSS styleable)

		// Does the item have a timestamp?
		if ($item->get_local_date($date_format))
		{
			$title_attr .= $item->get_local_date($date_format); // Use the locale-friendly version for non-English languages.
			$title_attr .= ' // '; // Visual separator.
		}

		$title_attr .= newsblocks::name($parent->subscribe_url()); // The domain name that the item is coming from.
		$title_attr .= '</span>'; // Mark the end of the date/domain line.

		return $title_attr;
	}


	/**
	 * Cleans up text for special output.
	 *
	 * Namely for use inside 'title' attributes. Strips HTML, removes double-quotes (since 
	 * that's what this demo uses for attributes), reduces all linebreaks and multiple 
	 * spaces into a single space, and can shorten a string to a number of characters.
	 *
	 * @access public
	 * @param string $s The string of text to clean up.
	 * @param integer $length The number of characters to return in the description.
	 * @return string The cleaned up string.
	 */
	function cleanup($s, $length = 0)
	{
		// Convert all HTML entities to their character counterparts.
		$s = html_entity_decode($s, ENT_QUOTES, 'UTF-8');

		// Strip out HTML tags.
	    $s = strip_tags($s);

		// Get rid of double quotes so they don't interfere with the title tag.
	    $s = str_replace('"', '', $s);

		// Strip out superfluous whitespace and line breaks.
	    $s = preg_replace('/(\s+)/', ' ', $s);

		// Shorten the string to the number of characters requested (multibyte safe), and strip wrapping whitespace.
		if ($length > 0 && strlen($s) > $length)
		{
			$s = trim(newsblocks::substr($s, 0, $length, 'UTF-8')) . '&hellip;';
		}

		// Return the value.
	    return $s;
	}


	/**
	 * Generates a default name for a given feed URL.
	 *
	 * Takes the feed's permalink, and reduces that to its hostname.
	 *
	 * @access public
	 * @param string $s The url to get the hostname for.
	 * @return string The hostname.
	 */
	function name($s)
	{
		// Look at the feed homepage URLs and get rid of http://www. and anything after a slash.
		preg_match('/http(s)?:\/\/(www.)?([^\/]*)/i', $s, $d);

		// Return the value we want (i.e. just the domain name).
		return $d[3];
	}


	/**
	 * Performs a multibyte-safe substring function, if mbstring is available.
	 *
	 * @access public
	 * @param string $str The string being checked.
	 * @param integer $start The first position used in $str.
	 * @param integer $length The maximum length of the returned string.
	 * @param string $encoding The encoding parameter is the character encoding. If it is omitted, the internal character encoding value will be used (mb_substr() only).
	 * @return string The hostname.
	 */
	function substr($str, $start, $length, $encoding = null)
	{
		if (function_exists('mb_substr'))
		{
			return mb_substr($str, $start, $length, $encoding);
		}
		else
		{
			return substr($str, $start, $length);
		}
	}
}
?>