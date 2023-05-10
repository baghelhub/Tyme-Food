<?php
/**
 * Coupon X APIs
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Rest;

use WP_REST_Request;
use WP_REST_Response;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Rest APIs
 */
class Cx_Rest
{


    /**
     * Constructor.
     */
    public function __construct()
    {
        add_action('rest_api_init', [ $this, 'cx_endpoints' ]);

    }//end __construct()


    /**
     * Register rest api endpoints
     */
    public function cx_endpoints()
    {

        // Update widget status enable/disable.
        register_rest_route(
            'couponx/v1',
            '/update_status',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'update_status',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Delete widget.
        register_rest_route(
            'couponx/v1',
            '/delete_widget',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'delete_widget',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Add new widget.
        register_rest_route(
            'couponx/v1',
            '/create_widget',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'save_widget_data',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Track widget statistics.
        register_rest_route(
            'couponx/v1',
            '/update_widget_stats',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'update_widget_stats',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Create new coupon.
        register_rest_route(
            'couponx/v1',
            '/generate_coupon',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'generate_coupon',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Capture email and save it in leads table.
        register_rest_route(
            'couponx/v1',
            '/capture_email',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'capture_email',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Track status of welcome popup.
        register_rest_route(
            'couponx/v1',
            '/update_popup_status',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'update_popup_status',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

        // Delete email.
        register_rest_route(
            'couponx/v1',
            '/delete_leads',
            [
                'methods'             => 'POST',
                'callback'            => [
                    $this,
                    'delete_leads',
                ],
                'permission_callback' => [
                    $this,
                    'get_user_permissions',
                ],
                'args'                => [],
            ]
        );

    }//end cx_endpoints()


    /**
     * Check user permission before API call. We are always returning true, because WP handles authentication through nonce.
     *
     * @param WP_REST_Request $request object.
     *
     * @return boolean true
     */
    public function get_user_permissions(WP_REST_Request $request)
    {
        return true;

    }//end get_user_permissions()


    /**
     * Update Welcome popup status
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function update_popup_status(WP_REST_Request $request)
    {
        add_option('cx_wc_popup', false, '', 'no');
        return new WP_REST_Response(
            [
                'status'   => 200,
                'response' => 'success',
            ]
        );

    }//end update_popup_status()


    /**
     * Update widget status
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function update_status(WP_REST_Request $request)
    {
        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        $status = $request->get_param('status');
        $id     = $request->get_param('id');
        if (! current_user_can('manage_options')) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Unauthorized request',
                ]
            );
        }

        if ('' !== $id && '' !== $status) {
            update_post_meta($id, 'status', $status);
            return new WP_REST_Response(
                [
                    'status'   => 200,
                    'response' => 'success',
                ]
            );
        } else {
            return new WP_REST_Response(
                [
                    'status'   => 201,
                    'response' => 'error',
                    'error'    => esc_html__('Request could not be completed due to missing parameters', 'coupon-x'),
                ]
            );
        }

    }//end update_status()


    /**
     * Delete widget
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function delete_widget(WP_REST_Request $request)
    {
        $id = $request->get_param('id');
        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        if (! current_user_can('manage_options')) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Unauthorized request',
                ]
            );
        }

        if ('' !== $id) {
            wp_delete_post($id);
            global $wpdb;
            $widgets = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts WHERE post_type='cx_widget'");
            if (0 === $widgets) {
                update_option('cx_total_widget', 1);
            }

            return new WP_REST_Response(
                [
                    'status'   => 200,
                    'response' => 'success',
                ]
            );
        } else {
            return new WP_REST_Response(
                [
                    'status'   => 201,
                    'response' => 'error',
                    'error'    => esc_html__('Request could not be completed due to missing parameters', 'coupon-x'),
                ]
            );
        }//end if

    }//end delete_widget()


    /**
     * Create new widget
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response object
     */
    public function save_widget_data(WP_REST_Request $request)
    {
        global $wpdb;
        $fields = $request->get_param('cx_settings');

        $files       = $request->get_file_params();
        $headers     = $request->get_headers();
        $custom_icon = '';
        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        if (! current_user_can('manage_options')) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Unauthorized request',
                ]
            );
        }

        if (! empty($files) && ! empty($files['file'])) {
            if (! function_exists('wp_handle_upload')) {
                include_once ABSPATH.'wp-admin/includes/file.php';
            }

            $uploadedfile = $files['file'];

            /*
                You can use wp_check_filetype() function to check the
                file type and go on wit the upload or stop it.
            */

            $movefile = wp_handle_upload($uploadedfile, [ 'test_form' => false ]);

            if ($movefile && ! isset($movefile['error'])) {
                $custom_icon = $movefile['url'];
                $fields['tab']['tab_custom_icon'] = $custom_icon;
            } else {
                $fields['tab']['tab_custom_icon'] = $movefile['error'];
            }
        }//end if

        $fields    = map_deep($fields, 'sanitize_text_field');
        $widget_id = 0;

        if (isset($fields['tab']['cx_widget_id']) && '' !== $fields['tab']['cx_widget_id']) {
            $widget_id = $fields['tab']['cx_widget_id'];
            $title     = sanitize_text_field($fields['tab']['widget_title']);
            $post      = [
                'ID'           => $widget_id,
                'post_title'   => $title,
                'post_content' => serialize($fields),
            ];
            $res       = wp_update_post($post);

            $version = get_post_meta($widget_id, 'version', true);
            if ('' === $version) {
                $version = 1;
            } else {
                $version++;
            }

            update_post_meta($widget_id, 'version', $version);
        } else {
            $count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts WHERE post_type='cx_widget'");
            if ($count > 0) {
                return new WP_REST_Response(
                    [
                        'status'   => 201,
                        'response' => 'error',

                    ]
                );
            }

            $title = sanitize_text_field($fields['tab']['widget_title']);
            $post  = [
                'post_title'   => $title,
                'post_type'    => 'cx_widget',
                'post_status'  => 'publish',
                'post_content' => serialize($fields),
            ];

            $widget_id = wp_insert_post($post);

            update_post_meta($widget_id, 'status', 1);
            $total = get_option('cx_total_widget');
            if ('' === $total) {
                $total = 2;
            } else {
                $total++;
            }

            update_option('cx_total_widget', $total);
            update_post_meta($widget_id, 'version', 1);
        }//end if

        update_post_meta($widget_id, 'coupon_type', $fields['popup']['coupon_type']);

        update_post_meta($widget_id, 'widget_type', $fields['popup']['style']);

        if ('3' === $fields['popup']['coupon_type']) {
            $this->generate_or_update_coupon($fields, $widget_id);
        }

        return new WP_REST_Response(
            [
                'status'    => 200,
                'response'  => 'success',
                'widget_id' => $widget_id,
            ]
        );

    }//end save_widget_data()


    /**
     * Delete widget
     *
     * @param array $settings  widget settings.
     * @param int   $widget_id int widget id.
     */
    public function generate_or_update_coupon($settings, $widget_id)
    {
        $coupon_code = $settings['unique_coupon']['discount_code'];
        $coupon      = new \WC_Coupon($coupon_code);

        $discount_type = $settings['unique_coupon']['discount_type'];
        if ('percent' === $discount_type) {
            $coupon->set_discount_type('percent');
        } else {
            $coupon->set_discount_type('fixed_cart');
        }

        $coupon->set_amount($settings['unique_coupon']['discount_value']);

        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['end_date']
        ) {
            $coupon->set_date_expires($settings['unique_coupon']['end_date']);
        } else {
            $coupon->set_date_expires(null);
        }

        $coupon->set_individual_use(true);

        if ('products' === $settings['unique_coupon']['applies_to']
            && isset($settings['unique_coupon']['products'])
            && count($settings['unique_coupon']['products']) > 0
        ) {
            $coupon->set_product_ids($settings['unique_coupon']['products']);
        } else {
            $coupon->set_product_ids(null);
        }

        if ('collections' === $settings['unique_coupon']['applies_to']
            && isset($settings['unique_coupon']['cats'])
            && count($settings['unique_coupon']['cats']) > 0
        ) {
            $coupon->set_product_categories($settings['unique_coupon']['cats']);
        } else {
            $coupon->set_product_categories(null);
        }

        if (isset($settings['unique_coupon']['enable_usage_limits'])
            && isset($settings['unique_coupon']['enable_no_item_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_no_item_limit']
        ) {
            $coupon->set_usage_limit($settings['unique_coupon']['no_item_limit']);
        } else {
            $coupon->set_usage_limit(null);
        }

        if (isset($settings['unique_coupon']['enable_usage_limits'])
            && isset($settings['unique_coupon']['enable_user_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_user_limit']
        ) {
            $coupon->set_usage_limit_per_user(1);
        } else {
            $coupon->set_usage_limit_per_user(null);
        }

        if ('subtotal' === $settings['unique_coupon']['min_req']) {
            $coupon->set_minimum_amount($settings['unique_coupon']['min_val']);
        } else {
            $coupon->set_minimum_amount(null);
        }

        $coupon->save();

        $coupon_id = $coupon->get_id();
        update_post_meta($coupon_id, 'status', 1);
        update_post_meta($coupon_id, 'cx_widget_id', $widget_id);
        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['start_date']
        ) {
            update_post_meta($coupon_id, 'start_date', $start_date);
            update_post_meta($coupon_id, 'end_date', $end_date);
        }

    }//end generate_or_update_coupon()


    /**
     * Track widget statistics.
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response
     */
    public function update_widget_stats(WP_REST_Request $request)
    {
        $nonce = $request->get_param('nonce');
        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        if (! wp_verify_nonce($nonce, 'wp_rest') && ! is_user_logged_in()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Unauthorized request',
                ]
            );
        }

        $widget_id = $request->get_param('id');
        $meta_key  = $request->get_param('key');

        $meta_value = get_post_meta($widget_id, $meta_key, true);
        if ('' === $meta_value) {
            $meta_value = 1;
        } else {
            $meta_value++;
        }

        update_post_meta($widget_id, $meta_key, $meta_value);

        return new WP_REST_Response(
            [
                'status'   => 200,
                'response' => 'success',
            ]
        );

    }//end update_widget_stats()


    /**
     * Create new coupon
     *
     * @param WP_REST_Request $request object.
     * @param boolean         $plain   . Decide whether to return plain array or WP_REST_Request object.
     *
     * @return WP_REST_Response/array
     */
    public function generate_coupon(WP_REST_Request $request, $plain=false)
    {

        global $wpdb;
        $coupon_code = '';

        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        if (false === $plain && ! is_user_logged_in()) {
            $nonce = $request->get_param('nonce');
            if (! wp_verify_nonce($nonce, 'wp_rest')) {
                return new WP_REST_Response(
                    [
                        'status'   => 401,
                        'response' => 'Unauthorized request',
                    ]
                );
            }
        }

        $widget_id = $request->get_param('id');

        $content     = get_the_content(null, false, $widget_id);
        $settings    = unserialize($content);
        $widget_type = (int) $settings['popup']['coupon_type'];
        if (4 === $widget_type) {
            return new WP_REST_Response(
                [
                    'status'   => 200,
                    'response' => 'success',
                    'code'     => '',
                    'type'     => $widget_type,
                ]
            );
        }

        if (1 === $widget_type) {
            $coupon_id   = $settings['ex_coupon']['coupon'];
            $coupon_code = get_the_title($coupon_id);
            $code        = [
                'code' => $coupon_code,
                'id'   => $coupon_id,
            ];
        } else if (2 === $widget_type) {
            $random = substr(time(), 2).rand(10, 99);

            $coupon_code = null !== $request->get_param('coupon_code') ? $request->get_param('coupon_code') : 'COUPONX'.$random;
            $coupon_id   = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts WHERE post_title= %s AND post_type = 'shop_coupon' AND post_status='publish'",
                    $coupon_code
                )
            );
            if (null === $coupon_id) {
                $coupon_id = $this->create_coupon($settings, $coupon_code, $widget_id);
            }

            $code = [
                'code' => $coupon_code,
                'id'   => $coupon_id,
            ];
        } else {
            $coupon_code = $settings['unique_coupon']['discount_code'];
            $coupon_id   = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT ID FROM $wpdb->posts WHERE post_title= %s AND post_type = 'shop_coupon' AND post_status='publish'",
                    $coupon_code
                )
            );
            if ($coupon_id > 0) {
                $code = [
                    'code' => $coupon_code,
                    'id'   => $coupon_id,
                ];
            } else {
                $coupon_id = $this->create_coupon($settings, $coupon_code, $widget_id);
                $code      = [
                    'code' => $coupon_code,
                    'id'   => $coupon_id,
                ];
            }
        }//end if

        if (true === $plain) {
            return $code;
        }

        return new WP_REST_Response(
            [
                'status'   => 200,
                'response' => 'success',
                'code'     => $code,
                'type'     => $widget_type,
            ]
        );

    }//end generate_coupon()


    /**
     * Create new WooCommerce coupon.
     *
     * @param settings    $settings    Array of widget settings.
     * @param coupon_code $coupon_code string coupon code.
     * @param widget_id   $widget_id   int widget id.
     *
     * @return int coupond id
     */
    public function create_coupon($settings, $coupon_code, $widget_id)
    {
        $coupon = new \WC_Coupon();
        $coupon->set_code($coupon_code);
        $discount_type = $settings['unique_coupon']['discount_type'];
        if ('percent' === $discount_type) {
            $coupon->set_discount_type('percent');
        } else {
            $coupon->set_discount_type('fixed_cart');
        }

        $coupon->set_amount($settings['unique_coupon']['discount_value']);

        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['end_date']
        ) {
            $coupon->set_date_expires($settings['unique_coupon']['end_date']);
        }

        $coupon->set_individual_use(true);

        if (isset($settings['unique_coupon']['products'])
            && count($settings['unique_coupon']['products']) > 0
        ) {
            $coupon->set_product_ids($settings['unique_coupon']['products']);
        }

        if (isset($settings['unique_coupon']['cats'])
            && count($settings['unique_coupon']['cats']) > 0
        ) {
            $coupon->set_product_categories($settings['unique_coupon']['cats']);
        }

        if (isset($settings['unique_coupon']['enable_no_item_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_no_item_limit']
        ) {
            $coupon->set_usage_limit($settings['unique_coupon']['no_item_limit']);
        }

        if (isset($settings['unique_coupon']['enable_user_limit'])
            && 1 === (int) $settings['unique_coupon']['enable_user_limit']
        ) {
            $coupon->set_usage_limit_per_user(1);
        }

        if ($settings['unique_coupon']['min_req']) {
            $coupon->set_minimum_amount($settings['unique_coupon']['min_val']);
        }

        $coupon->save();

        $coupon_id = $coupon->get_id();
        update_post_meta($coupon_id, 'status', 1);
        update_post_meta($coupon_id, 'cx_widget_id', $widget_id);
        if (isset($settings['unique_coupon']['enable_date'])
            && 1 === (int) $settings['unique_coupon']['enable_date']
            && '' !== $settings['unique_coupon']['start_date']
        ) {
            update_post_meta($coupon_id, 'start_date', $settings['unique_coupon']['start_date']);
            update_post_meta($coupon_id, 'end_date', $settings['unique_coupon']['end_date']);
        }

        return $coupon_id;

    }//end create_coupon()


    /**
     * Validate email sent by user and store it in leads table.
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response obeject
     */
    public function capture_email(WP_REST_Request $request)
    {
        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        $nonce = $request->get_param('nonce');
        if (! wp_verify_nonce($nonce, 'wp_rest')) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Unauthorized request',
                ]
            );
        }

        global $wpdb;

        $lead_table  = $wpdb->prefix.'cx_leads';
        $email       = sanitize_email($request->get_param('email'));
        $widget_id   = sanitize_text_field($request->get_param('widget_id'));
        $coupon_code = sanitize_text_field($request->get_param('coupon_code'));
        $is_consent  = sanitize_text_field($request->get_param('is_consent'));

        $content  = get_the_content(null, false, $widget_id);
        $settings = unserialize($content);

        if ('' !== $email) {
            // Update Coupon Code Get
            $email_subject      = \esc_html__('Coupon X New Lead', 'coupon-x');
            $consent_required   = ( isset($settings['main']['consent_required']) ) ? $settings['main']['consent_required'] : '';
            $consent_checkbox   = isset($settings['main']['consent']) ? $settings['main']['consent'] : '';
            $error_message_text = ( isset($settings['main']['error']) ) ? $settings['main']['error'] : \esc_html__(" You've already used this email address, please try another email address", 'coupon-x');

            if ('' === $consent_checkbox && false === $is_consent) {
                $is_consent       = true;
                $consent_checkbox = true;
            }

            $discount_code = '';
            $errors        = '';
            $request       = new \WP_REST_Request();
            $request->set_param('id', $widget_id);
            $request->set_param('coupon_code', $coupon_code);
            if ('style-5' !== $settings['popup']['style']) {
                // If coupon is present in cookie then return coupon from cookie else generate new coupon.
                $discount_code = isset($_COOKIE['couponx_unique'.$widget_id]) ? sanitize_text_field($_COOKIE['couponx_unique'.$widget_id]) : $this->generate_coupon($request, true);
            }

            if (isset($discount_code['id'])) {
                $discount_code = $discount_code['code'];
            }

            if (! empty($discount_code)) {
                $coupon     = new \WC_Coupon($discount_code);
                $usage_left = 1;

                // Check if coupon is valid.
                if ($coupon->get_usage_limit('view') > 0) {
                    $usage_left = ($coupon->get_usage_limit('view') - $coupon->get_usage_count());
                }

                if ($usage_left < 1) {
                    $errors = ( '' === $error_message_text ) ? \esc_html__('The coupon has reached its maximum number of usage.', 'coupon-x') : $error_message_text;

                    return new WP_REST_Response(
                        [
                            'status'      => 401,
                            'response'    => 'error',
                            'error'       => $errors,
                            'show_coupon' => false,
                        ]
                    );
                }
            }//end if

            $customer_id = $wpdb->get_var(
          //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
                $wpdb->prepare("SELECT id FROM $lead_table WHERE email = %s", $email)
            );

            // If email does not exist then insert record into table.
            if (null === $customer_id) {
                $d           = gmdate('Y-m-d');
                $ip          = $this->get_the_user_ip();
                $customer_id = $wpdb->insert(
                    $lead_table,
                    [
                        'email'       => $email,
                        'widget_id'   => $widget_id,
                        'widget_name' => get_the_title($widget_id),
                        'coupon_code' => $discount_code,
                        'date'        => $d,
                        'ip_address'  => $ip,
                    ],
                    [
                        '%s',
                        '%d',
                        '%s',
                        '%s',
                        '%s',
                        '%s',
                    ]
                );
            }//end if

            // } /* Finish Save email to leads table.*/
            $meta_value = get_post_meta($widget_id, 'coupon', true);
            if ('' === $meta_value) {
                $meta_value = 1;
            } else {
                $meta_value++;
            }

            update_post_meta($widget_id, 'coupon', $meta_value);

            return new WP_REST_Response(
                [
                    'status'        => 200,
                    'response'      => 'success',
                    'discount_code' => $discount_code,
                    'show_coupon'   => true,

                ]
            );
        }//end if

        $error_message = \esch_html__('Something went wrong. Please contact site administrator', 'coupon-x');

        return new WP_REST_Response(
            [
                'status'      => 401,
                'response'    => 'error',
                'error'       => $error_message,
                'show_coupon' => false,
            ]
        );

    }//end capture_email()


    /**
     * Get Ip address of user.
     */
    public function get_the_user_ip()
    {

        if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
        } else if (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
        }

        return $ip;

    }//end get_the_user_ip()


    /**
     * Deleate lead(s)
     *
     * @param WP_REST_Request $request object.
     *
     * @return WP_REST_Response obeject
     */
    public function delete_leads(WP_REST_Request $request)
    {
        if (! $request->sanitize_params()) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Invalid request',
                ]
            );
        }

        $leadIds = $request->get_param('id');
        if (! current_user_can('manage_options')) {
            return new WP_REST_Response(
                [
                    'status'   => 401,
                    'response' => 'Unauthorized request',
                ]
            );
        }

        if ('' !== $leadIds) {
            global $wpdb;
            $leads_tbl = $wpdb->prefix.'cx_leads';
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            foreach ($leadIds as $id) {
                $query = "DELETE FROM {$leads_tbl} WHERE id = %d";
                $query = $wpdb->prepare($query, $id);
                $wpdb->query($query);
            }

            return new WP_REST_Response(
                [
                    'status'   => 200,
                    'response' => 'success',
                ]
            );
        } else {
            return new WP_REST_Response(
                [
                    'status'   => 201,
                    'response' => 'error',
                    'error'    => esc_html__('Request could not be completed due to missing parameters', 'coupon-x'),
                ]
            );
        }//end if

    }//end delete_leads()


}//end class


new Cx_Rest();
