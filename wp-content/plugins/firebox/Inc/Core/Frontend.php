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

namespace FireBox\Core;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

use FPFramework\Libs\Registry;

class Frontend
{
    public function __construct()
    {
		// ensure we run only on front-end
		if (is_admin())
		{
			return;
		}

		// Prepare Gutenberg Blocks that contain attributes by FireBox
		new \FireBox\Core\FB\BoxBlocksParser();

		/**
		 * Event that runs before any rendering of popups.
		 */
		do_action('firebox/boxes/before_render');

        $this->render();

		\FireBox\Core\Helpers\Actions::run();

		/**
		 * Event that runs after popups have been rendered.
		 */
		do_action('firebox/boxes/after_render');
	}
	
	/**
	 * Renders all boxes on front-end
	 * 
	 * @return  void
	 */
	private function render()
	{
		if ($this->checkForBoxPreview())
		{
			return;
		}

		// increment session counter
		\FPFramework\Libs\Functions::incrementSession();
		
		/**
		 * Adds all boxes at the end of page.
		 */
		add_action('wp', function() {
			firebox()->boxes->render();
		});
	}

	/**
	 * Check if we are previewing a box and do not show other boxes.
	 * 
	 * @return  boolean
	 */
	private function checkForBoxPreview()
	{
		$previewer = new Previewer();
		return $previewer->init();
	}
}