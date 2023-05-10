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

namespace FPFramework\Base\Fields;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Conditions extends SearchDropdown
{
	/**
     * List of available conditions
     *
     * @var array
     */
    public static $conditions = [
		'FPF_DATETIME' => [
			'Date\Date' => 'FPF_DATE',
			'Date\Day' => 'FPF_DAY_OF_WEEK',
			'Date\Month' => 'FPF_MONTH',
			'Date\Time' => 'FPF_TIME'
		],
		'WordPress' => [
			'WP\UserID' => 'FPF_USER',
			'WP\Menu' => 'FPF_MENU',
			'WP\UserGroup' => 'FPF_USER_GROUP',
			'WP\Posts' => 'FPF_POST',
			'WP\Pages' => 'FPF_PAGE',
			'WP\Tags' => 'FPF_POST_TAG',
			'WP\Categories' => 'FPF_POST_CATEGORY',
			'WP\CustomPostTypes' => 'FPF_CPT',
		],
		'FPF_TECHNOLOGY' => [
			'Device' => 'FPF_DEVICES',
			'Browser' => 'FPF_BROWSERS',
			'OS' => 'FPF_OS'
		],
		'FPF_GEOLOCATION' => [
			'Geo\City' => 'FPF_CITY',
			'Geo\Country' => 'FPF_COUNTRY',
			'Geo\Region' => 'FPF_REGION',
			'Geo\Continent' => 'FPF_CONTINENT'
		],
		'FPF_INTEGRATIONS' => [
			'sitepress-multilingual-cms/sitepress.php#WP\Language' => 'FPF_WPML_LANGUAGE'
		],
		'FPF_FIREBOX' => [
			'firebox/firebox.php#FireBox\Popup'=> 'FPF_FIREBOX_VIEWED_ANOTHER_POPUP',
			'firebox/firebox.php#FireBox\Form'=> 'FPF_FIREBOX_SUBMITTED_FORM',
		],
		'FPF_ADVANCED' => [
			'URL' => 'FPF_URL',
			'Referrer' => 'FPF_REFERRER',
			'IP' => 'FPF_IP_ADDRESS',
			'Pageviews' => 'FPF_PAGEVIEWS',
			'Cookie' => 'FPF_COOKIE',
			'PHP' => 'FPF_PHP',
			'TimeOnSite' => 'FPF_TIMEONSITE',
			'NewReturningVisitor' => 'FPF_NEW_RETURNING_VISITOR'
		]
	];

	/**
	 * Set specific field options
	 * 
	 * @param   array  $options
	 * 
	 * @return  void
	 */
	protected function setFieldOptions($options)
	{
		parent::setFieldOptions($options);

		$this->field_options = array_merge($this->field_options, [
			'placeholder' => fpframework()->_('FPF_SELECT_CONDITION'),
			'search_query_placeholder' => fpframework()->_('FPF_TYPE_A_CONDITION'),
			'control_inner_class' => ['fpf-min-width-270', 'fpf-conditions-field'],
			'include_rules' => isset($options['include_rules']) ? $options['include_rules'] : [],
			'exclude_rules' => isset($options['exclude_rules']) ? $options['exclude_rules'] : [],
			'exclude_rules_pro' => isset($options['exclude_rules_pro']) ? $options['exclude_rules_pro'] : false,
			'multiple' => false,
			'local_search' => true,
			'items' => $this->getChoices()
		]);
	}

	/**
	 * Method to get the field option groups.
	 *
	 * @return  array  The field option objects as a nested array in groups.
	 */
	protected function getChoices()
	{
		$include_rules = empty($this->options['include_rules']) ? [] : $this->options['include_rules'];
		$exclude_rules = empty($this->options['exclude_rules']) ? [] : $this->options['exclude_rules'];

		$groups = [];

		foreach (self::$conditions as $conditionGroup => $conditions)
		{
			$childs = [];

			foreach ($conditions as $conditionName => $condition)
			{
				$skip_condition = false;

				/**
				 * Checks conditions that have multiple components as dependency.
				 * Check for multiple given components for a particular condition, i.e. acymailing can be loaded via com_acymailing or com_acym
				 */
				$multiple_components = explode('|', $conditionName);
				if (count($multiple_components) >= 2)
				{
					foreach ($multiple_components as $component)
					{
						$skip_condition = false;

						if (!$conditionName = $this->getConditionName($component))
						{
							$skip_condition = true;
							continue;
						}
					}
				}
				
				// If the condition must be skipped, skip it
				if ($skip_condition)
				{
					continue;
				}

				// Checks for a single condition whether its component exists and can be used.
				if (!$conditionName = $this->getConditionName($conditionName))
				{
					continue;
				}

				// If its excluded, skip it
				if (!$this->options['exclude_rules_pro'] && !empty($exclude_rules) && in_array($conditionName, $exclude_rules))
				{
					continue;
				}

				// If its not included, skip it
				if (!empty($include_rules) && !in_array($conditionName, $include_rules))
				{
					continue;
				}

				// Add condition to the group
				$childs[$conditionName] = fpframework()->_($condition);
			}

			if (!empty($childs))
			{
				$groups[fpframework()->_($conditionGroup)] = $childs;
			}
		}

		return $groups;
	}

	/**
	 * Returns the parsed condition name.
	 * 
	 * i.e. $condition: firebox/firebox.php#Foo\FireBox
	 * will return: Foo\FireBox
	 * 
	 * @param   string  $condition
	 * 
	 * @return  mixed
	 */
	private function getConditionName($condition)
	{
		$conditionNameParts = explode('#', $condition);

		if (count($conditionNameParts) >= 2 && !\is_plugin_active($conditionNameParts[0]))
		{
			return false;
		}
		
		return isset($conditionNameParts[1]) ? $conditionNameParts[1] : $conditionNameParts[0];
	}
}