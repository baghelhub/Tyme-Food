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

namespace FireBox\Core\Admin\Analytics\Overview;

use FireBox\Core\Admin\Analytics\Helpers\AnalyticsHelper;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class Overview
{
    /**
     * The default Overview filters
     * 
     * @var  array
     */
    private $default_filters = [
        'date' => 'this_month'
    ];

    /**
     * Analytics Toolbar
     * 
     * @var  Toolbar
     */
    private $toolbar;
    
    public function __construct()
    {
        // Ensure we can show analytics overview on current page
        if (!\FireBox\Core\Admin\Analytics\Helpers\AnalyticsHelper::canRun('firebox'))
        {
            return;
        }

        $this->init();

        // render overview filters
        add_action('firebox/analytics/overview/filters', [$this, 'renderFilters']);

        // render overview
        add_action('firebox/dashboard/content', [$this, 'render']);
    }

    public function init()
    {
        $this->toolbar = new \FireBox\Core\Admin\Analytics\Toolbar();
    }

    /**
     * Display the Analytics Overview
     * 
     * @return  void
     */
    public function render()
    {
        // Load CSS & JS files
        $this->loadMedia();
        
        firebox()->renderer->admin->render('analytics/overview/tmpl', [
            'overview_items_names' => $this->getOverviewItemsNames(),
            'default_filters' => $this->default_filters
        ]);
    }

    public function renderFilters()
    {
        firebox()->renderer->admin->render('analytics/overview/filters', [
            'configuration' => firebox()->analytics_configuration,
            'filters' => $this->getFilters()
        ]);
    }

    public function getOverviewItemsNames()
    {
        $names = array_keys($this->getOverviewItemsPayload());

        
        if (FBOX_LICENSE_TYPE === 'lite')
        {
            unset($names['submissions']);
            unset($names['conversionrate']);
            unset($names['countries']);
            unset($names['referrers']);
            unset($names['pie']); // Devices
        }
        

        
        
        return $names;
    }

    public function getOverviewItemsPayload()
    {
        $configuration = firebox()->analytics_configuration;

        return [
            'impressions' => [
                'overview_type' => 'chart',
                'metrics' => ['impressions'],
                'allowed_filters' => [
                    'box',
                    'date'
                ],
                'toolbar_items' => [
                    'date' => [
                        'method' => 'filter',
                        'options_key' => 'this_month',
                    ]
                ],
            ],
            'avg_time_open' => [
                'overview_type' => 'chart',
                'metrics' => ['averagetimeopen'],
                'allowed_filters' => [
                    'box',
                    'date'
                ],
                'toolbar_items' => [
                    'date' => [
                        'method' => 'filter',
                        'options_key' => 'this_month',
                    ]
                ],
            ],
            
            'boxes' => [
                'overview_title' => firebox()->_('FB_TOP_BOXES'),
                'overview_type' => 'boxestable',
                'layout' => 'table',
                'reference_toolbar_item' => 'box',
                'metrics' => ['impressions'],
                'show_total' => false,
                'show_percentage' => false,
                'allowed_filters' => [
                    'box',
                    'date'
                ],
                'other_data' => [
                    'modify_query_data' => [
                        'select' => [
                            'boxes.ID as box_id',
                            'boxes.post_title as label',
                            'count(bl.id) as total'
                        ],
                        'join' => [
                            'left join ' . $configuration['boxes_table'] . ' as boxes' => ' ON boxes.ID = bl.box'
                        ],
                        'groupby' => 'bl.box',
                        'orderby' => 'total desc'
                    ],
                    'options' => [
                        'skip_filling_dates' => true,
                        'skip_compare_check_to_retrieve_previous_data' => true
                    ]
                ],
                'table_columns' => [
                    'box' => [
                        'label' => firebox()->_('FB_POPUP'),
                    ],
                    'impressions' => [
                        'label' => fpframework()->_('FPF_IMPRESSIONS'),
                    ],
                    'percentage' => [
                        'label' => '%',
                        'title' => fpframework()->_('FPF_PERCENTAGE_CHANGE_OVER_PREVIOUS_PERIOD')
                    ]
                ],
                'toolbar_items' => [
                    'date' => [
                        'method' => 'filter',
                        'options_key' => 'this_month',
                    ]
                ],
            ],
            
            
            'submissions_pro' => [
                'overview_title' => fpframework()->_('FPF_SUBMISSIONS'),
                'overview_type' => 'pro',
                'layout' => 'pro',
                'redirect_base' => true,
                'feature' => fpframework()->_('FPF_SUBMISSIONS_CHART'),
                'image' => FBOX_MEDIA_ADMIN_URL . 'images/analytics_overview_submissions.png',
                'show_overlay_message' => true,
                'class' => 'overlay-bg corner',
                'message' => 'FPF_ANALYTICS_OVERVIEW_OVERLAY_PRO_MSG1'
            ],
            'conversionrate_pro' => [
                'overview_title' => fpframework()->_('FPF_CONVERSION_RATE'),
                'overview_type' => 'pro',
                'layout' => 'pro',
                'redirect_base' => true,
                'feature' => fpframework()->_('FPF_CONVERSION_RATE_CHART'),
                'image' => FBOX_MEDIA_ADMIN_URL . 'images/analytics_overview_conversionrate.png',
                'show_overlay_message' => true,
                'class' => 'overlay-bg corner',
                'message' => 'FPF_ANALYTICS_OVERVIEW_OVERLAY_PRO_MSG1'
            ],
            'devices_pro' => [
                'overview_title' => fpframework()->_('FPF_TOP_DEVICES'),
                'overview_type' => 'pro',
                'layout' => 'pro',
                'redirect_base' => true,
                'feature' => fpframework()->_('FPF_TOP_DEVICES'),
                'image' => FBOX_MEDIA_ADMIN_URL . 'images/analytics_overview_devices.png',
                'show_overlay_message' => true,
                'class' => 'overlay-bg corner',
                'message' => 'FPF_ANALYTICS_OVERVIEW_OVERLAY_PRO_MSG1'
            ],
            'countries_pro' => [
                'overview_title' => fpframework()->_('FPF_TOP_COUNTRIES'),
                'overview_type' => 'pro',
                'layout' => 'pro',
                'redirect_base' => true,
                'feature' => fpframework()->_('FPF_TOP_COUNTRIES'),
                'image' => FBOX_MEDIA_ADMIN_URL . 'images/analytics_overview_countries.png',
                'show_overlay_message' => true,
                'class' => 'overlay-bg corner',
                'message' => 'FPF_ANALYTICS_OVERVIEW_OVERLAY_PRO_MSG1'
            ],
            'referrers_pro' => [
                'overview_title' => fpframework()->_('FPF_TOP_REFERRERS'),
                'overview_type' => 'pro',
                'layout' => 'pro',
                'redirect_base' => true,
                'feature' => fpframework()->_('FPF_TOP_REFERRERS'),
                'image' => FBOX_MEDIA_ADMIN_URL . 'images/analytics_overview_referrers.png',
                'show_overlay_message' => true,
                'class' => 'overlay-bg corner',
                'message' => 'FPF_ANALYTICS_OVERVIEW_OVERLAY_PRO_MSG1'
            ],
            
        ];
    }

    public function getFilters($plain = false)
    {
        
        
        return [
            
            
            'box_pro' => [
                'default_label' => firebox()->_('FB_ALL_POPUPS'),
                'item' => firebox()->_('FB_POPUP_SELECTION')
            ],
            'date_pro' => [
                'default_label' => firebox()->_('FB_THIS_MONTH'),
                'item' => fpframework()->_('FPF_DATE_PERIOD')
            ]
            
        ];
    }

    /**
     * Load media for the Analytics Overview page
     * 
     * @return  void
     */
    private function loadMedia()
    {
		// Countries Icons CSS Library
		wp_register_style(
			'firebox-analytics-overview-countries-icons',
			FBOX_MEDIA_ADMIN_URL . 'css/flag-icon.min.css',
			[],
			FBOX_VERSION,
			false
		);
        wp_enqueue_style('firebox-analytics-overview-countries-icons');

		// Chart JS CSS Library
		wp_register_style(
			'firebox-analytics-chart',
			FBOX_MEDIA_ADMIN_URL . 'css/chart.min.css',
			[],
			FBOX_VERSION,
			false
		);
        wp_enqueue_style('firebox-analytics-chart');
        
		// Moments JS
		wp_register_script(
			'firebox-analytics-moment-js-library',
            includes_url('js/dist/vendor/moment.min.js'),
			[],
			FBOX_VERSION,
			false
		);
		wp_enqueue_script('firebox-analytics-moment-js-library');

		// Chart JS
		wp_register_script(
			'firebox-analytics-chart',
			FBOX_MEDIA_ADMIN_URL . 'js/chart.min.js',
			['firebox-analytics-moment-js-library'],
			FBOX_VERSION,
			false
		);
        wp_enqueue_script('firebox-analytics-chart');

        

		// FireBox Analytics Overview JS
		wp_register_script(
			'firebox-analytics-overview',
			FBOX_MEDIA_ADMIN_URL . 'js/fb_analytics_overview.js',
			[],
			FBOX_VERSION,
			false
		);
        wp_enqueue_script('firebox-analytics-overview');
    }

    public function getToolbar()
    {
        return $this->toolbar;
    }
}