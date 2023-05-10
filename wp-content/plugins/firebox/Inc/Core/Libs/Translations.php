<?php
/**
 * @package         FireBox
 * @version         2.0.3 Free
 * 
 * @author          FirePlugins <info@fireplugins.com>
 * @link            https://www.fireplugins.com
 * @copyright       Copyright © 2023 FirePlugins All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace FireBox\Core\Libs;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Translations
{
	/**
	 * Holds all translations of the plugin.
	 * 
	 * @var  array
	 */
	private $translations = [];

	/**
	 * Stores cached translations.
	 * 
	 * @var  array
	 */
	private $cached = [];
	
	public function __construct()
	{
		$this->translations = $this->getTranslations();
	}

	/**
	 * Retrieves the translation of $text
	 * 
	 * @param  String  $text
	 * @param  String  $fallback
	 * 
	 * @return  String
	 */
	public function _($text, $fallback = null)
	{
		if (!is_string($text) && !is_int($text))
		{
			return '';
		}

		if (isset($this->cached[$text]))
		{
			return $this->cached[$text];
		}

		if ($fallback && isset($this->cached[$fallback]))
		{
			return $this->cached[$fallback];
		}
		
		if ($translation = $this->retrieve($text, $fallback))
		{
			$this->cached[$translation['source']] = $translation['value'];
			
			return $translation['value'];
		}

		return $fallback ? trim($fallback) : trim($text);
	}

	/**
	 * Retrieves translation of given text or of fallback text.
	 * If none found, returns false
	 * 
	 * @param   string  $text
	 * @param   string  $fallback
	 * 
	 * @return  mixed
	 */
	public function retrieve($text, $fallback = '')
	{
		if (!is_string($text) && !is_numeric($text))
		{
			return '';
		}

		$translationOfText = $this->findText($text);
		if ($translationOfText !== false)
		{
			return [
				'source' => $text,
				'value' => $translationOfText
			];
		}

		$fallback = !empty($fallback) ? $fallback : $text;

		$translationOfFallback = $this->findText($fallback);
		if ($translationOfFallback !== false)
		{
			return [
				'source' => $fallback,
				'value' => $translationOfFallback
			];
		}

		return false;
	}

	/**
	 * Tries to find translation of text. Returns false if fails.
	 * 
	 * @param   string  $text
	 * 
	 * @return  mixed
	 */
	private function findText($text)
	{
		return isset($this->translations[strtoupper(trim($text))]) ? $this->translations[strtoupper(trim($text))] : false;
	}

	/**
	 * All Translations
	 * 
	 * @return array
	 */
	public function getTranslations()
	{
		return [
			'FB_PLUGIN_NAME' => __('FireBox', 'firebox'),
			'FB_ADD_FIREBOX' => __('Add FireBox', 'firebox'),
			'FB_ADD_BUTTON' => __('Add Button', 'firebox'),
			'FB_PLUGIN_PLULAR_NAME' => __('Popups', 'firebox'),
			'FB_NEW_POPUP' => __('New Popup', 'firebox'),
			'FB_LIST_PAGE_TITLE' => __('FireBox Items', 'firebox'),
			'FB_IMPORT_PAGE_TITLE' => __('FireBox Import Items', 'firebox'),
			'FB_SETTINGS_PAGE_TITLE' => __('FireBox Settings', 'firebox'),
			'FB_METABOX_BEHAVIOR_DESC' => __('Set when to fire the popup.', 'firebox'),
			'FB_METABOX_POSITION' => __('Position', 'firebox'),
			'FB_METABOX_POSITION_DESC' => __('Select the position of the popup.', 'firebox'),
			'FB_METABOX_POSITION_TL' => __('Top Left', 'firebox'),
			'FB_METABOX_POSITION_TC' => __('Top Center', 'firebox'),
			'FB_METABOX_POSITION_TR' => __('Top Right', 'firebox'),
			'FB_METABOX_POSITION_BL' => __('Bottom Left', 'firebox'),
			'FB_METABOX_POSITION_BC' => __('Bottom Center', 'firebox'),
			'FB_METABOX_POSITION_BR' => __('Bottom Right', 'firebox'),
			'FB_METABOX_POSITION_ML' => __('Middle Left', 'firebox'),
			'FB_METABOX_POSITION_MC' => __('Middle Center', 'firebox'),
			'FB_METABOX_POSITION_MR' => __('Middle Right', 'firebox'),
			'FB_METABOX_POSITION_C' => __('Center', 'firebox'),
			'FB_TRIGGER' => __('Trigger', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD' => __('Trigger Point', 'firebox'),
			'FB_METABOX_MORE_TRIGGER_METHOD_DESC' => __('The following Trigger Points are available in the Pro version of FireBox.<br><br><strong>on Scroll Depth</strong>: Fires when the visitor has reached the specified amount of scroll depth.<br><strong>on Element Visibility</strong>: Fires when the specified element enters the viewport after scroll down.<br><strong>on Exit</strong>: Fires when the visitor intends to leave the page.<br><strong>on Hover</strong>: Fires when the visitor moves their mouse over specified element.<br><strong>on AdBlock Detect</strong>: Fires when the visitor has been detected using an AdBlocker.<br><strong>on Idle</strong>: Fires when the visitor goes idle for a specific amount of time.', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_PL' => __('Page Load', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_PR' => __('Page Ready', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_PH' => __('Scroll Depth', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_EL' => __('Element Visibility', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_UL' => __('Exit', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_OC' => __('Click', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_EH' => __('Hover', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_ONADBLOCKDETECT' => __('AdBlock Detect', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_ONIDLE' => __('Idle', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_OD' => __('Manually', 'firebox'),
			'FB_METABOX_TRIGGER_ELEMENT' => __('Trigger Element', 'firebox'),
			'FB_METABOX_TRIGGER_ELEMENT_DESC' => __('Specify the ID or the Class of the element(s) that should fire this trigger. You can specify multiple elements separated by comma. Example 1: .item-100, .item-101, #logo', 'firebox'),
			'FB_METABOX_PREVENTDEFAULT' => __('Disable Default Action', 'firebox'),
			'FB_METABOX_PREVENTDEFAULT_DESC' => __('If enabled, stops the default action of the element from occuring. For example: Prevents a link from following the URL.', 'firebox'),
			'FB_METABOX_TRIGGER_PERCENTAGE' => __('Scroll Percentage', 'firebox'),
			'FB_METABOX_TRIGGER_PERCENTAGE_DESC' => __('Popup will appear when the user has scrolled at a selected percentage of the document\'s total height. Enter a number 1-100.', 'firebox'),
			'FB_METABOX_TRIGGER_DELAY' => __('Delay', 'firebox'),
			'FB_METABOX_TRIGGER_DELAY_DESC_FREE' => __('Delay trigger in seconds. Leave 0 for immediate execution or select the seconds to delay the popup from appearing.', 'firebox'),
			'FB_METABOX_TRIGGER_DELAY_DESC' => __('Delay trigger in seconds. Leave 0 for immediate execution or select the seconds to delay the popup from appearing. If the trigger point is set to "on Hover" then this value is used to delay or prevent the accidental firing of the popup and attempts to determine the user\'s intent. It is recommended to use at least 30 ms.', 'firebox'),
			'FB_METABOX_EXIT_TIMER' => __('Minimum Time', 'firebox'),
			'FB_METABOX_EXIT_TIMER_DESC' => __('By default, the "on Exit" event won\'t fire in the first second to prevent false positives, as it\'s unlikely the user will be able to exit the page within less than a second. If you want to change the amount of time that firing is surpressed for, you can pass in a number of milliseconds to timer.', 'firebox'),
			'FB_METABOX_LIMIT_IMPRESSIONS_DESC2' => __('In order for this feature to work, the Analytics option must be enabled under Settings > Advanced and the user browsing the site must have cookies enabled. The period calculation is based on the time of your server, not that of the visitors system.', 'firebox'),
			'FB_METABOX_ASSIGN_IMPRESSIONS_DESC' => __('Limit the display of the popup to the same visitor to a certain number of impressions.', 'firebox'),
			'FB_METABOX_ASSIGN_IMPRESSIONS_LIST' => __('Limit To', 'firebox'),
			'FB_METABOX_ASSIGN_IMPRESSIONS_LIST_DESC' => __('Set the the amount of times a user can see the popup until it is hidden.', 'firebox'),
			'FB_METABOX_CLOSING_BEHAVIOR' => __('Closing Behavior', 'firebox'),
			'FB_METABOX_CLOSING_BEHAVIOR_DESC' => __('Choose how your popup will behave after a visitor closes it. You can keep showing the popup or hide it for a set amount of time before it starts to reappear.', 'firebox'),
			'FB_METABOX_CLOSING_BEHAVIOR_BEHAVIOR_TITLE' => __('If the user closes the popup,', 'firebox'),
			'FB_METABOX_COOKIE_DURATION' => __('Cookie Duration', 'firebox'),
			'FB_METABOX_COOKIE_DURATION_DESC' => __('Enter the cookie duration in Minutes, Hours or Days depending on the After Close Stay Hidden value. Example: 5 for 5 Days or 500 for 500 seconds.', 'firebox'),
			'FB_METABOX_ANIMATION' => __('Animations', 'firebox'),
			'FB_METABOX_ANIMATION_DESC' => __('Set the entrace & exit animations of the popup as well as the duration of the animation.', 'firebox'),
			'FB_METABOX_ANIMATION_IN' => __('Open Animation', 'firebox'),
			'FB_METABOX_ANIMATION_OUT' => __('Close Animation', 'firebox'),
			'FB_METABOX_DURATION' => __('Duration', 'firebox'),
			'FB_METABOX_DESIGN_POPUP' => __('Popup', 'firebox'),
			'FB_METABOX_DESIGN_POPUP_DESC' => __('Configure the popup colors, text alignment, space within and around the popup as well as it\'s shadow.', 'firebox'),
			'FB_METABOX_DESIGN_POPUP_SIZE' => __('Popup Size', 'firebox'),
			'FB_METABOX_DESIGN_POPUP_SIZE_DESC' => __('Configure the popup width and height.', 'firebox'),
			'FB_METABOX_PADDING_DESC' => __('The CSS padding properties are used to generate space around an element\'s content, inside of any defined borders.', 'firebox'),
			'FB_METABOX_MARGIN_DESC' => __('The CSS margin propertiy is used to generate space around the popup and set the size of the white space outside the border.', 'firebox'),
			'FB_METABOX_SHADOW' => __('Shadow', 'firebox'),
			'FB_METABOX_SHADOW_S1' => __('Style 1', 'firebox'),
			'FB_METABOX_SHADOW_S2' => __('Style 2', 'firebox'),
			'FB_METABOX_SHADOW_S3' => __('Style 3', 'firebox'),
			'FB_ELEVATION' => __('Elevation', 'firebox'),
			'FB_METABOX_BORDERRADIUS' => __('Radius', 'firebox'),
			'FB_METABOX_BORDERRADIUS_DESC' => __('Add rounded borders to popup. The border radius option will be applied despite the chosen style.', 'firebox'),
			'FB_METABOX_BG_OVERLAY' => __('Overlay', 'firebox'),
			'FB_METABOX_BG_OVERLAY_DESC' => __('Configure the popup background overlay to bring your popup\'s content to your users attention.', 'firebox'),
			'FB_METABOX_OVERLAY_COLOR_DESC' => __('Set the popup overlay background color.', 'firebox'),
			'FB_METABOX_OVERLAY_CLICK' => __('Close on Click', 'firebox'),
			'FB_METABOX_OVERLAY_CLICK_DESC' => __('If enabled, allows the closing of the popup by clicking on the background overlay.', 'firebox'),
			'FB_METABOX_BG_IMAGE_FILE_DESC' => __('Select or a upload a background image.', 'firebox'),
			'FB_METABOX_BGREPEAT_TOOLTIP' => __('<strong>Repeat</strong>: The background image will be repeated both vertically and horizontally.<br><br><strong>Repeat-x</strong>: The background image will be repeated only horizontally<Br><br><strong>Repeat-y</strong>: The background image will be repeated only vertically<br><br><strong>No-repeat</strong>: The background-image will not be repeated.', 'firebox'),
			'FB_METABOX_BGREPEAT_DESC' => __('The background-repeat property sets if/how a background image will be repeated. By default, a background-image is repeated both vertically and horizontally.', 'firebox'),
			'FB_METABOX_BGREPEAT_NOREPEAT' => __('No-repeat', 'firebox'),
			'FB_METABOX_BGREPEAT_REPEATX' => __('Repeat-X', 'firebox'),
			'FB_METABOX_BGREPEAT_REPEATY' => __('Repeat-Y', 'firebox'),
			'FB_METABOX_BGSIZE_TOOLTIP' => __('<strong>Auto</strong>: The background-image contains its width and height<br><br><strong>Cover</strong>: Scale the background image to be as large as possible so that the background area is completely covered by the background image. Some parts of the background image may not be in view within the background positioning area<br><br><strong>Contain</strong>: Scale the image to the largest size such that both its width and its height can fit inside the content area<br><br><strong>100% 100%</strong>: Stretch the background image to completely cover the content area.', 'firebox'),
			'FB_METABOX_BGSIZE_DESC' => __('Specify the size of a background image.', 'firebox'),
			'FB_METABOX_BGSIZE_COVER' => __('Cover', 'firebox'),
			'FB_METABOX_BGSIZE_CONTAIN' => __('Contain', 'firebox'),
			'FB_METABOX_BG_POSITION_DESC' => __('The background-position property sets the starting position of a background image. By default, a background-image is placed at the top-left corner. The first value is the horizontal position and the second value is the vertical.', 'firebox'),
			'FB_METABOX_BG_POSITION_LEFT_TOP' => __('Left Top', 'firebox'),
			'FB_METABOX_BG_POSITION_LEFT_CENTER' => __('Left Center', 'firebox'),
			'FB_METABOX_BG_POSITION_LEFT_BOTTOM' => __('Left Bottom', 'firebox'),
			'FB_METABOX_BG_POSITION_RIGHT_TOP' => __('Right Top', 'firebox'),
			'FB_METABOX_BG_POSITION_RIGHT_CENTER' => __('Right Center', 'firebox'),
			'FB_METABOX_BG_POSITION_RIGHT_BOTTOM' => __('Right Bottom', 'firebox'),
			'FB_METABOX_BG_POSITION_CENTER_TOP' => __('Center Top', 'firebox'),
			'FB_METABOX_BG_POSITION_CENTER_CENTER' => __('Center Center', 'firebox'),
			'FB_METABOX_BG_POSITION_CENTER_BOTTOM' => __('Center Bottom', 'firebox'),
			'FB_METABOX_CLOSE_BUTTON' => __('Close Button', 'firebox'),
			'FB_METABOX_CLOSE_BUTTON_TITLE_DESC' => __('Configure the close button of the popup by displaying either an icon or an image of your choice. You may also delay the appearance of the close button to ensure the popup gets the visibility you need.', 'firebox'),
			'FB_METABOX_CLOSE_BUTTON_OUTSIDE' => __('Show Outside Popup', 'firebox'),
			'FB_METABOX_CLOSE_BUTTON_INSIDE' => __('Show Inside Popup', 'firebox'),
			'FB_METABOX_CLOSE_BUTTON_TYPE' => __('Choose Button Type', 'firebox'),
			'FB_METABOX_HOVER_COLOR' => __('Hover Color', 'firebox'),
			'FB_METABOX_SELECT_IMAGE_DESC' => __('Select an image for the close button.', 'firebox'),
			'FB_METABOX_DELAY' => __('Delay', 'firebox'),
			'FB_METABOX_PA_MATCHING_METHOD' => __('Matching Method', 'firebox'),
			'FB_METABOX_PA_MATCHING_METHOD_DESC' => __('Choose \'All\' to display the popup when all conditions are met. Choose \'Any\' to display the popup when at least 1 condition is met.', 'firebox'),
			'FB_METABOX_PA_PAGE_URL' => __('Page / URL', 'firebox'),
			'FB_METABOX_PA_PAGE_URL_DESC' => __('Target visitors who are browsing specific menu items or URLs', 'firebox'),
			'FB_METABOX_PA_DATETIME' => __('Datetime', 'firebox'),
			'FB_METABOX_PA_DATETIME_DESC' => __('Trigger a popup based on your server\'s date and time', 'firebox'),
			'FB_METABOX_PA_USER_VISITOR' => __('User / Visitor', 'firebox'),
			'FB_METABOX_PA_USER_VISITOR_DESC' => __('Target registered users or visitors who have viewed a certain number of pages', 'firebox'),
			'FB_METABOX_ADV_ENABLE_RTL' => __('Enable RTL', 'firebox'),
			'FB_METABOX_ADV_ENABLE_RTL_DESC' => __('The right-to-left text direction is essential for right-to-left scripts such as Arabic, Hebrew, Syriac, and Thaana.', 'firebox'),
			'FB_METABOX_ADV_PREVENT_PAGE_SCROLLING' => __('Prevent Page Scrolling', 'firebox'),
			'FB_METABOX_ADV_PREVENT_PAGE_SCROLLING_DESC' => __('Prevent page from scrolling while the popup is opened.', 'firebox'),
			'FB_METABOX_ADV_STATISTICS' => __('Statistics', 'firebox'),
			'FB_METABOX_ADV_ZINDEX' => __('Ordering (z-index)', 'firebox'),
			'FB_METABOX_ADV_ZINDEX_DESC' => __('A higher z-index moves toward the front of the page. The default z-index is 99999.', 'firebox'),
			'FB_USER_IDS_AS_DESC' => __('Enter comma separated WordPress user IDs', 'firebox'),
			'FB_NUMBER_PAGEVIEWS_MATCH_DESC' => __('The used matching method to compare the value', 'firebox'),
			'FB_NUMBER_PAGEVIEWS_PAGEVIEWS_DESC' => __('Enter the number of page views', 'firebox'),
			'FB_VIEWED_ANOTHER_BOX' => __('Viewed Another Popup', 'firebox'),
			'FB_VIEWED_ANOTHER_BOX_DESC' => __('Target visitors who have viewed another popup', 'firebox'),
			'FB_VIEWED_ANOTHER_BOX_AS_DESC' => __('Select Popups', 'firebox'),
			'FB_TIMEONSITE_SELECTION_DESC' => __('Enter a duration in seconds to compare with the user\'s total time (Visit duration) spent on your entire site.<Br>Example:<Br> If you want to display a popup after the user has spent 3 minutes on your the entire site, enter 180.', 'firebox'),
			'FB_METABOX_GENERAL_DESC' => __('Set popup general settings such as the popup mode, whether the popup will be in test mode as well as the popup position.', 'firebox'),
			'FB_METABOX_BOX_MODE' => __('Popup Mode', 'firebox'),
			'FB_METABOX_BOX_MODE_DESC' => __('Choose Popup to display a lightbox popup on top of the page\'s content or Page Slide to display a slide-in from the top of the page. This way your users can just scroll down to reach your content.', 'firebox'),
			'FB_POPUP' => __('Popup', 'firebox'),
			'FB_BOX' => __('Popup', 'firebox'),
			'FB_METABOX_MODE_POPUP' => __('Popup', 'firebox'),
			'FB_METABOX_MODE_PAGESLIDE' => __('Page Slide', 'firebox'),
			'FB_METABOX_TEST_MODE' => __('Test Mode', 'firebox'),
			'FB_METABOX_TEST_MODE_DESC' => __('Test Mode shows the popup to Administrators only for testing purposes. If enabled, the User Group condition is ignored and the Cookie Functions are completely disabled.', 'firebox'),
			'FB_PA_POSTS_AS_DESC' => __('Select posts to display the popup.', 'firebox'),
			'FB_PA_BOX_HINT' => __('Start searching for popups.', 'firebox'),
			'FB_PA_PAGES_AS_DESC' => __('Select pages to display the popup.', 'firebox'),
			'FB_PA_CPTS_AS_DESC' => __('Select custom post types to display the popup.', 'firebox'),
			'FB_PA_POST_TAGS_AS_DESC' => __('Select post tags to display the popup.', 'firebox'),
			'FB_PA_POST_CATEGORIES_AS_DESC' => __('Select post categories to display the popup.', 'firebox'),
			'FB_THE_FB_ID' => __('The Popup ID (will appear after saving)', 'firebox'),
			'FB_THE_FB_TITLE' => __('The Popup Title (will appear after saving)', 'firebox'),
			'FB_METABOX_LANGUAGE_DESC' => __('Select the language where the popup will appear.', 'firebox'),
			'FB_METABOX_SYSTEM_INTEGRATIONS' => __('System / Integrations', 'firebox'),
			'FB_METABOX_SYSTEM_INTEGRATIONS_DESC' => __('Target visitors who have interacted with WordPress Plugins', 'firebox'),
			'FB_SETTINGS_LOAD_CSS' => __('Load Stylesheet', 'firebox'),
			'FB_SETTINGS_LOAD_CSS_DESC' => __('Select to load the plugins stylesheet. You can disable this if you place all your own styles in some other stylesheet, like the Custom Code field or the templates stylesheet', 'firebox'),
			'FB_SETTINGS_LOAD_VELOCITY' => __('Load Velocity', 'firebox'),
			'FB_SETTINGS_LOAD_VELOCITY_DESC' => __('Velocity is an animation engine that is required for the plugin to run properly. You can disable this if your template or a plugin is already loading both Velocity and Velocity UI Pack libraries.', 'firebox'),
			'FB_SETTINGS_SHOW_COPYRIGHT' => __('Show Copyright', 'firebox'),
			'FB_SETTINGS_SHOW_COPYRIGHT_DESC' => __('If selected, extra copyright info will be displayed in the admin pages.', 'firebox'),
			'FB_SETTINGS_DEBUG' => __('Debug', 'firebox'),
			'FB_SETTINGS_DEBUG_DESC' => __('Debug plugin using your browser\'s Developers Console (Press F12).', 'firebox'),
			'FB_SETTINGS_ANALYTICS' => __('Analytics', 'firebox'),
			'FB_SETTINGS_ANALYTICS_DESC' => __('Log the events of your popups to the database. This option is required for the Opening Behavior > Show Frequency feature to work properly.', 'firebox'),
			'FB_SETTINGS_STATS_PERIOD' => __('Maximum Impressions Storage Period', 'firebox'),
			'FB_SETTINGS_STATS_PERIOD_DESC' => __('Automatically delete old impressions after a period', 'firebox'),
			'FB_SETTINGS_STATS_DAYS_CUSTOM' => __('Specifiy Days', 'firebox'),
			'FB_SETTINGS_STATS_DAYS_CUSTOM_DESC' => __('Automatically delete old impressions after specified days', 'firebox'),
			'FB_SETTINGS_GAT' => __('Google Analytics Tracking', 'firebox'),
			'FB_SETTINGS_GAT_DESC' => __('Enable event tracking with Google Analytics. The events which will be tracked is the Open and Close events.', 'firebox'),
			'FB_SETTINGS_GAID' => __('Google Analytics ID', 'firebox'),
			'FB_SETTINGS_GAID_DESC' => __('Your Google Analytics Tracking ID: UA-XXXXXXX-X.', 'firebox'),
			'FB_SETTINGS_GA_CAT' => __('Event Category Label', 'firebox'),
			'FB_SETTINGS_GA_CAT_DESC' => __('The Event Category Label that will appear on your Google Analytics report.', 'firebox'),
			'FB_DUPLICATE_BOX' => __('Duplicate Popup', 'firebox'),
			'FB_RESET_IMPRESSIONS' => __('Reset Impressions', 'firebox'),
			'FB_SETTINGS_PUBLISH_ITEMS' => __('Publish Items', 'firebox'),
			'FB_METABOX_SCROLL_DEPTH' => __('Scroll Depth', 'firebox'),
			'FB_METABOX_SCROLL_DEPTH_DESC' => __('The vertical scroll depths reached to fire the event. If the specified scroll depth is visible in the viewport when the page loads, the trigger will fire without a scroll occurring.', 'firebox'),
			'FB_METABOX_TRIGGER_PIXEL' => __('Pixel', 'firebox'),
			'FB_METABOX_TRIGGER_PIXEL_DESC' => __('Popup will appear when the user has scrolled a selected number of pixels of the document\'s total height.', 'firebox'),
			'FB_METABOX_SCROLL_DIRECTION' => __('Scroll Direction', 'firebox'),
			'FB_METABOX_SCROLL_DIRECTION_DESC' => __('Select the direction the user has to scroll to trigger the popup.', 'firebox'),
			'FB_GALLERY_LICENSE_KEY' => __('To be able to use FireBox Gallery you will need enter a valid License Key first.', 'firebox'),
			'FB_METABOX_FIRING_FREQUENCY' => __('Firing Frequency', 'firebox'),
			'FB_METABOX_FIRING_FREQUENCY_DESC' => __('Configure the fire frequency of this trigger per page. Once Per Page: The trigger will fire only once per page. Unlimited: The trigger will fire whenever the event occurs on the page.', 'firebox'),
			'FB_METABOX_CLOSE_OUT_VIEWPORT' => __('Close Outside Viewport', 'firebox'),
			'FB_METABOX_CLOSE_OUT_VIEWPORT_DESC' => __('Automatically close the popup when it is outside of the viewport. It respects the Minimum Percent Visible option.', 'firebox'),
			'FB_METABOX_UNLIMITED' => __('Unlimited', 'firebox'),
			'FB_METABOX_ONCE_PER_PAGE' => __('Once Per Page', 'firebox'),
			'FB_METABOX_CLOSE_RVRS_SCROLL' => __('Close on Reverse Scroll', 'firebox'),
			'FB_METABOX_CLOSE_RVRS_SCROLL_DESC' => __('Close the popup when the user scrolls on the opposite direction.', 'firebox'),
			'FB_METABOX_THRESHOLD' => __('Min Percent Visible', 'firebox'),
			'FB_METABOX_THRESHOLD_DESC' => __('Specify how much of the selected element must be visible on screen before the trigger fires.<br>A value of 25 means that the trigger will fire when 25% of the element is visible while a value of 100 will fire the trigger when the element becomes fully (100%) visible.', 'firebox'),
			'FB_METABOX_IDLE_TIME' => __('Idle Time', 'firebox'),
			'FB_METABOX_IDLE_TIME_DESC' => __('The time in seconds the visitor must be inactive in order to trigger the popup.', 'firebox'),
			'FB_METABOX_IDLE_REPEAT' => __('Idle Repeat', 'firebox'),
			'FB_METABOX_IDLE_REPEAT_DESC' => __('Once the popup is closed, should the onIdle event fire again?', 'firebox'),
			'FB_METABOX_ACTIONS' => __('Actions', 'firebox'),
			'FB_ADD_ACTION' => __('Add Action', 'firebox'),
			'FB_ACTIONS_ALERT_DESC' => __('In FireBox, every popup fires certain types of events like Open and Close. An Action listens to those events and gets executed when the specified event is occured.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC' => __('Select the event of this popup that will fire the specified action.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC_BEFOREOPEN' => __('Fires before the popup opens. Use it to cancel open by returning false in a script.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC_OPEN' => __('Fires when the popup is about to open and the animation starts.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC_AFTEROPEN' => __('Fires when the popup is fully opened and the animation has ended.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC_BEFORECLOSE' => __('Fires before the popup closes. Use it to cancel close by returning false in a script.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC_CLOSE' => __('Fires when the popup is about to close and the animation starts.', 'firebox'),
			'FB_METABOX_ACTION_WHEN_DESC_AFTERCLOSE' => __('Fires when the popup is fully closed and the animation has ended.', 'firebox'),
			'FB_METABOX_ACTION_DO_DESC' => __('Select the action to execute when the specified event fires.', 'firebox'),
			'FB_METABOX_ACTION_DO_OPEN_A_BOX' => __('Open a Popup', 'firebox'),
			'FB_METABOX_ACTION_DO_CLOSE_A_BOX' => __('Close a Popup', 'firebox'),
			'FB_METABOX_ACTION_DO_CLOSE_ALL_OPENED_BOX' => __('Close all opened Popups', 'firebox'),
			'FB_METABOX_ACTION_DO_DESTROY_A_BOX' => __('Destroy a Popup', 'firebox'),
			'FB_METABOX_ACTION_DO_REDIRECT_TO_URL' => __('Redirect to a URL', 'firebox'),
			'FB_METABOX_ACTION_DO_RUN_JS' => __('Run JavaScript', 'firebox'),
			'FB_METABOX_ACTION_DO_DELAY_DESC' => __('Optionally, delay the execution of the specified Action.', 'firebox'),
			'FB_METABOX_ACTION_DO_RELOAD_PAGE' => __('Reload Page', 'firebox'),
			'FB_METABOX_ACTION_POPUP_DESC' => __('Select the popup to apply the action to.', 'firebox'),
			'FB_METABOX_ACTION_DELAY_DESC' => __('Optionally, delay the execution of the specified Action.', 'firebox'),
			'FB_METABOX_ACTION_URL_DESC' => __('Set the URL to redirect the visitor to. You can create dynamic URLs using Smart Tags. Example: <strong>{fpf url}?box_closed=true</strong> or <strong>{fpf site.url}?user={fpf user.id}</strong>.', 'firebox'),
			'FB_METABOX_ACTION_NEW_TAB' => __('Open in new tab', 'firebox'),
			'FB_METABOX_ACTION_NEW_TAB_DESC' => __('Enable to redirect in a new tab.', 'firebox'),
			'FB_METABOX_ACTION_CUSTOM_CODE_DESC' => __('Enter the Javascript code to execute. Do not include &lt;script> tags. Use <strong>me</strong> variable to access current popup\'s instance.', 'firebox'),
			'FB_POPUP_RESET_STATS' => __('Popup statistics has been reset.', 'firebox'),
			'FB_POPUP_LIBRARY' => __('FireBox Popup Library', 'firebox'),
			'FB_IMPORT_POPUP' => __('Import Popup', 'firebox'),
			'FB_FULLSCREEN' => __('Fullscreen', 'firebox'),
			'FB_SLIDEIN' => __('Slide-in', 'firebox'),
			'FB_FLOATING_BAR' => __('Floating Bar', 'firebox'),
			'FB_SIDEBAR' => __('Sidebar', 'firebox'),
			'FB_SPECIALS' => __('Specials', 'firebox'),
			'FB_HIDDEN_BY_COOKIE' => __('Hidden by cookie', 'firebox'),
			'FB_CLEAR_COOKIE' => __('Clear Cookie', 'firebox'),
			/* translators: %s: popup total impressions */
			'FB_POPUP_TOTAL_IMPRESSIONS' => __('This item has %s total impressions so far', 'firebox'),
			'FB_REMOVE_IMPRESSIONS' => __('Remove Popup Impressions', 'firebox'),
			'FB_USERNAME_OR_EMAIL_ADDRESS' => __('Username or Email Address', 'firebox'),
			'FB_GALLERY_LICENSE_KEY' => __('To be able to use FireBox Gallery you will need enter a valid License Key first.', 'firebox'),
			'FB_CHOOSE_BOX_TO_HANDLE' => __('Choose the FireBox you\'d like to handle.', 'firebox'),
			'FB_SELECT_A_POPUP' => __('Select a Popup', 'firebox'),
			'FB_FIREBOX_ACTION' => __('FireBox Action', 'firebox'),
			'FB_ADD_A_FIREBOX_BUTTON' => __('Add a FireBox Button', 'firebox'),
			'FB_OPEN' => __('Open', 'firebox'),
			'FB_CLOSE' => __('Close', 'firebox'),
			'FB_TOGGLE' => __('Toggle', 'firebox'),
			'FB_BUTTON_LABEL' => __('Button Label', 'firebox'),
			'FB_BUTTON_CLASSES' => __('Button Classes', 'firebox'),
			'FB_BUTTON_LINK' => __('Button Link', 'firebox'),
			'FB_POPUP_IMPORT_CONTENTS_ERROR' => __('Popup Import could not be completed successfully. It appears it contains invalid data.', 'firebox'),
			'FB_ANALYTICS_TOP_DESC' => __('View and analyze the performance of your popups.', 'firebox'),
			'FB_LAST_7_DAYS' => __('Last 7 days', 'firebox'),
			'FB_PREVIOUS_7_DAYS' => __('Previous 7 days', 'firebox'),
			'FB_THIS_MONTH' => __('This month', 'firebox'),
			'FB_PREVIOUS_MONTH' => __('Previous month', 'firebox'),
			'FB_LAST_3_MONTHS' => __('Last 3 months', 'firebox'),
			'FB_LAST_6_MONTHS' => __('Last 6 months', 'firebox'),
			'FB_LAST_12_MONTHS' => __('Last 12 months', 'firebox'),
			'FB_LAST_16_MONTHS' => __('Last 16 months', 'firebox'),
			'FB_PREVIOUS_3_MONTHS' => __('Previous 3 months', 'firebox'),
			'FB_PREVIOUS_6_MONTHS' => __('Previous 6 months', 'firebox'),
			'FB_PREVIOUS_12_MONTHS' => __('Previous 12 months', 'firebox'),
			'FB_PREVIOUS_16_MONTHS' => __('Previous 16 months', 'firebox'),
			'FB_COMPARE_LAST_7_DAYS' => __('Compare last 7 days to previous period', 'firebox'),
			'FB_COMPARE_THIS_MONTH' => __('Compare this month to previous period', 'firebox'),
			'FB_COMPARE_LAST_3_MONTHS' => __('Compare last 3 months to previous period', 'firebox'),
			'FB_COMPARE_LAST_6_MONTHS' => __('Compare last 6 months to previous period', 'firebox'),
			'FB_COMPARE_LAST_7_DAYS_YOY' => __('Compare last 7 days year over year', 'firebox'),
			'FB_COMPARE_THIS_MONTH_YOY' => __('Compare this month year over year', 'firebox'),
			'FB_COMPARE_LAST_3_MONTHS_YOY' => __('Compare last 3 months year over year', 'firebox'),
			'FB_TOTAL_IMPRESSIONS_TOOLTIP' => __('<strong>Impressions</strong> is the number of times a popup has been displayed to your users on your site.', 'firebox'),
			'FB_TOTAL_IMPRESSIONS_PERCENTAGE_TITLE' => __('The percentage change since previous period or percentage difference when comparing.', 'firebox'),
			'FB_OPEN_BOX' => __('Open Popup', 'firebox'),
			'FB_CLOSE_BOX' => __('Close Popup', 'firebox'),
			'FB_TOTAL_CLICKS' => __('Total Clicks', 'firebox'),
			'FB_TOTAL_CLICKS_TOOLTIP' => __('<strong>Total Clicks</strong> is how many times a user clicked through your popups on your site.', 'firebox'),
			'FB_AVG_CTR' => __('Average CTR', 'firebox'),
			'FB_AVG_CTR_TOOLTIP' => __('<strong>Average CTR</strong> is the percentage of impressions that resulted in a click.', 'firebox'),
			'FB_ANALYTICS_PAGE_TITLE' => __('FireBox Analytics', 'firebox'),
			'FB_AVG_TIME_OPEN_TOOLTIP' => __('<strong>Average Time Open</strong> is the average amount of time a popup remains open in the browser.', 'firebox'),
			'FB_ANALYTICS_OVERVIEW' => __('Analytics Overview', 'firebox'),
			'FB_TOP_BOXES' => __('Top Popups', 'firebox'),
			'FB_LAST_DATE_VIEWED' => __('Last Date Viewed', 'firebox'),
			'FB_ALL_POPUPS' => __('All Popups', 'firebox'),
			'FB_POPUP_SELECTION' => __('Popup Selection', 'firebox'),
			'FB_THIS_BOX' => __('This Popup', 'firebox'),
			'FB_SETTINGS_MEDIA_DESC' => __('Set whether to enable the FireBox CSS library as well as whether to load the popup animations.', 'firebox'),
			'FB_SETTINGS_OTHER_DESC' => __('Set whether to display the copyright message or whether to enable the debug mode.', 'firebox'),
			'FB_METABOX_CUSTOM_HEIGHT_DESC' => __('By default the height is calculated automatically. Enable to enter a fixed height.', 'firebox'),
			'FB_PREVIEW_POPUP' => __('Preview Popup', 'firebox'),
			'FB_PREVIEW' => __('Preview', 'firebox'),
			'FB_EDIT_FIREBOX' => __('Edit FireBox', 'firebox'),
			'FB_VIEW_FIREBOX_ITEMS' => __('View FireBox Items', 'firebox'),
			'FB_FIREBOX_PREVIEW_DESC' => __('This is a preview of how your FireBox popup will look like in a page. This page is not publicly accessible.', 'firebox'),
			'FB_FIREBOX_POPUP_PREVIEW' => __('FireBox Popup Preview', 'firebox'),
			'FB_OPENING_SOUND' => __('Opening Sound', 'firebox'),
			'FB_OPENING_SOUND_DESC' => __('Select a sound to play when the popup appears.', 'firebox'),
			'FB_CUSTOM_OPENING_SOUND' => __('Custom Opening Sound', 'firebox'),
			'FB_CUSTOM_OPENING_SOUND_HINT' => __('Enter the URL of the sound file.', 'firebox'),
			'FB_CUSTOM_OPENING_SOUND_FILE_DESC' => __('Select a sound file.', 'firebox'),
			'FB_CUSTOM_OPENING_SOUND_URL_DESC' => __('Enter the URL of the sound file.', 'firebox'),
			'FB_OPENING_SOUND_NOTICE' => __('Browsers on iOS and Android (e.g. Safari, Chrome, etc...) may refuse to play the sound due to requiring user interaction.', 'firebox'),
			/* translators: %s: popup ID */
			'FB_METABOX_TRIGGER_ELEMENT_ALTERNATIVE_METHOD_DESC' => __('Alternatively, you can insert this in your link or button: <span class="fpf-badge outline">data-fbox="%s"</span>', 'firebox'),
			'FB_KEEP_SHOWING_POPUP' => __('keep showing the popup', 'firebox'),
			'FB_DO_NOT_SHOW_POPUP_AGAIN' => __('do not show the popup again', 'firebox'),
			'FB_DO_NOT_SHOW_POPUP_AGAIN_SESSION' => __('do not show the popup again for the session', 'firebox'),
			'FB_DO_NOT_SHOW_POPUP_AGAIN_PERIOD' => __('do not show the popup again for X (days, hours, minutes)', 'firebox'),
			'FB_AUTO_CLOSE_POPUP' => __('Auto-Close popup', 'firebox'),
			'FB_AUTO_CLOSE_POPUP_DESC' => __('Set whether to auto close the popup after an amount of seconds.', 'firebox'),
			'FB_METABOX_OPENING_BEHAVIOR' => __('Opening Behavior', 'firebox'),
			'FB_METABOX_OPENING_BEHAVIOR_DESC' => __('Choose how your popup will behavior prior to your users seeing it.', 'firebox'),
			'FB_SHOW_FREQUENCY_DESC' => __('Set how often the popup can appear.', 'firebox'),
			'FB_TRANSITION_IN_HINT' => __('Select an open animation.', 'firebox'),
			'FB_TRANSITION_OUT_HINT' => __('Select an close animation.', 'firebox'),
			'FB_ACTION_SETTINGS' => __('Action Settings', 'firebox'),
			'FB_AUTO_CLOSE_POPUP_AFTER' => __('Automatically close popup after', 'firebox'),
			'FB_POPUPS' => __('Popups', 'firebox'),
			'FB_MIRROR_POPUP_SELECT_DESC' => __('Select the popup you want to mirror its Display Conditions.', 'firebox'),
			'FB_ACCESSIBILITY' => __('Accessibility', 'firebox'),
			'FB_ACCESSIBILITY_DESC' => __('Set accessibility settings for the popup.', 'firebox'),
			'FB_AUTO_FOCUS' => __('Auto Focus', 'firebox'),
			'FB_AUTO_FOCUS_DESC' => __('When then popups opens, set focus to the first focusable element within the content of the popup.', 'firebox'),
			'FB_DISPLAY_POPUP' => __('Display Popup', 'firebox'),
			'FB_DISPLAY_POPUP_DESC' => __('Select whether to display the popup on all pages (sitewide), mirror the conditions from another popup or set your own custom conditions.', 'firebox'),
			'FB_DISPLAY_CONDITIONS' => __('Display Conditions', 'firebox'),
			'FB_DISPLAY_CONDITIONS_TYPE_ALL_PAGES' => __('On all pages', 'firebox'),
			'FB_DISPLAY_CONDITIONS_TYPE_MIRROR' => __('Mirror Popup', 'firebox'),
			'FB_DISPLAY_CONDITIONS_TYPE_CUSTOM' => __('Set conditions', 'firebox'),
			'FB_POPUP_TYPE' => __('Popup Type', 'firebox'),
			'FB_BLANK_POPUP' => __('Blank Popup', 'firebox'),
			'FB_METABOX_OVERLAY_BLUR_RADIUS' => __('Blur background', 'firebox'),
			'FB_METABOX_OVERLAY_BLUR_RADIUS_DESC' => __('To make the overlay background blur, set the radius of the blur. The higher the radius, the more blur the background will be.', 'firebox'),
			'FB_METABOX_BG_COLOR_DESC' => __('Set the background color of the popup. Enter <strong>transparent</strong> to have a transparent background.', 'firebox'),
			'FB_SETTINGS_SHOW_ADMIN_BAR_MENU_ITEM' => __('Show Admin Bar Menu Item', 'firebox'),
			'FB_SETTINGS_SHOW_ADMIN_BAR_MENU_ITEM_DESC' => __('Set whether to show the FireBox menu item in the admin bar, at the top of the page. This adds helpful links to get you to the most used pages of the FireBox plugin.', 'firebox'),
			'FB_METABOX_TRIGGER_METHOD_ELC' => __('External Link Click', 'firebox'),
			'FB_SUBMISSION_CONFIRMED' => __('Confirmed', 'firebox'),
			'FB_SUBMISSION_UNCONFIRMED' => __('Unconfirmed', 'firebox'),
			'FB_SUBMISSION_TRASHED' => __('Trashed', 'firebox'),
			'FB_SUBMISSIONS_PAGE_TITLE' => __('FireBox Submissions', 'firebox'),
			'FB_NO_SUBMISSIONS_FOUND' => __('No submissions found.', 'firebox'),
			'FB_DATE_SUBMITTED' => __('Date Submitted', 'firebox'),
			'FB_UNTITLED_FORM' => __('Untitled form', 'firebox'),
			'FB_PLEASE_SELECT_A_FORM' => __('- Please select a form -', 'firebox'),
			'FB_SUBMISSIONS_PAGE_TITLE' => __('FireBox Submissions', 'firebox'),
			'FB_CANNOT_UPDATE_SUBMISSION' => __('Cannot update submission', 'firebox'),
			'FB_THIS_IS_A_REQUIRED_FIELD' => __('This is a required field.', 'firebox'),
			'FB_USER_SUBMITTED_DATA' => __('User Submitted Data', 'firebox'),
			'FB_SUBMISSION_INFO' => __('Submission Info', 'firebox'),
			'FB_UPDATE_SUBMISSION' => __('Update Submission', 'firebox'),
			'FB_BACK_TO_SUBMISSIONS' => __('Back to submissions', 'firebox'),
			'FB_FORM' => __('Form', 'firebox'),
			'FB_CREATED_DATE' => __('Created Date', 'firebox'),
			'FB_MODIFIED_DATE' => __('Modified Date', 'firebox'),
			'FB_SUBMISSIONS_UPDATED' => __('Submissions updated.', 'firebox'),
			'FB_HONEYPOT_FIELD_TRIGGERED' => __('Honeypot field triggered.', 'firebox'),
			'FB_FIREBOX_FORM' => __('FireBox Form', 'firebox'),
			'FB_ASSIGN_FIREBOX_FORM_DESC' => __('Target visitors who have submitted a FireBox Form', 'firebox'),
			'FB_ASSIGN_SEARCH_FIREBOX_FORM_HINT' => __('Start searching for FireBox forms.', 'firebox'),
			'FB_ASSIGN_SEARCH_FIREBOX_FORM_AS_DESC' => __('Select the FireBox forms to assign to.', 'firebox'),
			'FB_METRIC_SUBMISSIONS_TOOLTIP' => __('<strong>Submissions</strong> is the number of times a form created by the Gutenberg block "FireBox Form" has been submitted within your popups.', 'firebox'),
			'FB_CONVERSION_RATE_TOOLTIP' => __('<strong>Conversion Rate</strong> is the average number of conversion per the Gutenberg block "FireBox Form", shown as a percentage.', 'firebox'),
			'FB_ANALYTICS_LOADING_METRICS' => __('Loading metrics...', 'firebox'),
			'FB_JSON_API' => __('JSON API', 'firebox'),
			'FB_JSON_API_DESC' => __('The JSON API allows you to retrieve FireBox data using HTTP requests.', 'firebox'),
			'FB_ENABLE_JSON_API' => __('Enable JSON API', 'firebox'),
			'FB_ENABLE_JSON_API_DESC' => __('Set whether to enable the FireBox API endpoints.', 'firebox'),
			'FB_API_KEY' => __('API Key', 'firebox'),
			'FB_JSON_API_KEY_DESC' => __('Enter a unique alphanumeric that will act as the API key that will be used to authenticate all FireBox API requests.', 'firebox'),
		];
	}
}