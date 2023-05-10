<?php
/**
 * @package         FirePlugins Framework
 * @version         1.1.57
 * 
 * @author          FirePlugins <info@fireplugins.com>
 * @link            https://www.fireplugins.com
 * @copyright       Copyright © 2023 FirePlugins All Rights Reserved
 * @license         GNU GPLv3 <http://www.gnu.org/licenses/gpl.html> or later
*/

namespace FPFramework\Base\Conditions\Conditions;

defined('ABSPATH') or die;

use FPFramework\Base\Conditions\Condition;

class PHP extends Condition 
{
	/**
	 *  Pass check Custom PHP
	 *
	 *  @return  bool
	 */
	public function pass()
	{
		return (bool) $this->value();
	}
	
	public function value()
	{
		// Enable buffer output
		ob_start();
		$pass = $this->factory->getExecuter($this->selection)->run();
		ob_end_clean();

		return $pass;
	}
}