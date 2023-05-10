<?php
/**
 * Create Coupon- Tab design
 *
 * @package Coupon_X
 * @author  : Premio <contact@premio.io>
 * @license : GPL2
 */

namespace Coupon_X\Dashboard;

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Create new widget - Tab design
 */
class Cx_Widget_Tab
{


    /**
     * Constructor function
     *
     * @param settings $settings array of widget settings.
     */
    public function __construct($settings)
    {
        $this->render_tab_design($settings);

    }//end __construct()


    /**
     * Renders Tab design tab html
     *
     * @param settings $settings array of widget settings.
     */
    public function render_tab_design($settings)
    {

        $coupon_tab_icon = Cx_Helper::coupon_tab_icon();
        $widget_title    = $settings['widget_title'];
        $number          = get_option('cx_total_widget', 1);

        ?>
        <div class='cx-tab'>
            <div class='tab-settings'>
                <h3><?php esc_html_e('Tab Design', 'coupon-x'); ?></h3>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
        <?php esc_html_e('Name Your Widget', 'coupon-x'); ?> 
                        </label>
                        <input type='text' name='cx_settings[tab][widget_title]' class='input-element'
                        placeholder="<?php echo esc_html__("What's the your widget's name?", 'coupon-x'); ?>" value="<?php echo esc_attr($widget_title); ?>">
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements half color-row'>
                        <label> 
        <?php esc_html_e('Tab Color', 'coupon-x'); ?> 
                            <input type='text' id='tab_color' class='jsspan tab-clr' name='cx_settings[tab][tab_color]' value='<?php echo esc_attr($settings['tab_color']); ?>'/>
                        </label>                        
                    </div>
                    <div class='row-elements half color-row'>
                        <label> 
        <?php esc_html_e('Icon Color', 'coupon-x'); ?> 
                            <input type='text' id='icon_color' class='jsspan tab-clr' name='cx_settings[tab][icon_color]' value='<?php echo esc_attr($settings['icon_color']); ?>'/>
                        </label>                        
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements'>
                        <label> 
        <?php esc_html_e('Tab icon', 'coupon-x'); ?> 
                        </label>
                        <ul class="cx-tab-icon">
        <?php
          $tab_icon = $settings['tab_icon'];
        foreach ($coupon_tab_icon as $key => $value) {
            $checked = $tab_icon === $key ? 'checked' : '';
            ?>
                                <li>
                                    <label>
                                        <input type="radio" name="cx_settings[tab][tab_icon]" value="<?php echo esc_attr($key); ?>" <?php echo esc_attr($checked); ?> class="input-field-radio tab-icon" >
                                        <span id="<?php echo esc_attr($key); ?>">
            <?php echo wp_kses($value, Cx_Helper::get_svg_ruleset()); ?>
                                        </span>
                                    </label>
                                </li>
            <?php
        }
        ?>
                                <li>
                                    <span class="seperator"></span>
                                </li>
                                <li>
                                    <label class="upload">
                                        <input id="tab-custom-icon-upload" type="file" class="fileClass" name="cx_settings[tab][tab_custom_icon]" class="input-field-radio" accept="image/*" />
                                        <input id="tab-custom-icon-option" type="radio" name="cx_settings[tab][tab_icon]" value="custom" class="input-field-radio tab-icon" 
                                        <?php
                                        if ('custom' === $tab_icon) {
                                            echo esc_attr('checked');
                                        }
                                        ?>
                                        />
                                        <input type="hidden" name="cx_settings[tab][tab_custom_icon]" value="<?php echo esc_attr($settings['tab_custom_icon']); ?>" />
                                        <span id="tab-custom-icon">                     
              <?php
                echo Cx_Helper::custom_tab_icon();
                ?>

                                        </span>
                                    </label>
                                </li>
                            </ul>        
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Tab Shape', 'coupon-x'); ?> 
                        </label>
                        <select name='cx_settings[tab][tab_shape]' class='input-element tab-shape'>
                            <option value=''>
           <?php esc_html_e('--- Select Tab Shape ---', 'coupon-x'); ?> 
                            </option>
          <?php
            $tab_shapes = [
                'circle'  => esc_html__('Circle', 'coupon-x'),
                'square'  => esc_html__('Square', 'coupon-x'),
                'leaf'    => esc_html__('Leaf', 'coupon-x'),
                'hexagon' => esc_html__('Hexagon', 'coupon-x'),
            ];
            $shape      = $settings['tab_shape'];
            foreach ($tab_shapes as $key => $value) {
                $selected = $shape === $key ? 'selected' : '';
                ?>
                                <option value='<?php echo esc_attr($key); ?>' <?php echo esc_attr($selected); ?>>
                <?php echo esc_attr($value); ?> 
                                </option>
                <?php
            }
            ?>
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Position', 'coupon-x'); ?> 
                        </label>
                        <div>
                            <ul class='custom-list'>
         <?php
            $positions = [
                'left'   => esc_html__('Left', 'coupon-x'),
                'right'  => esc_html__('Right', 'coupon-x'),
                'custom' => esc_html__('Custom', 'coupon-x'),
            ];
            $pos       = $settings['position'];

            foreach ($positions as $key => $value) {
                $checked = $key === $pos ? 'checked' : '';
                ?>
                            <li>
                                <label> 
                                    <input type='radio' name='cx_settings[tab][position]' class='custom-pos' value='<?php echo esc_attr($key); ?>' <?php echo esc_attr($checked); ?>>
                <?php echo esc_attr($value); ?>
                                </label>
                            </li>
                <?php
            }
            ?>
                            </ul>
                    </div>
                    </div>
                </div>
                <div class='row custom-position first <?php echo esc_attr('custom' !== $settings['position'] ? 'hide' : ''); ?>'>
                    <div class='row-elements'>
                        <label> 
          <?php esc_html_e('Slide Selection', 'coupon-x'); ?> 
                        </label>
                        <div>
                            <ul class='custom-list'>
          <?php
            $custom_pos       = $settings['custom_position'];
            $custom_positions = [
                'left'  => esc_html__('Left', 'coupon-x'),
                'right' => esc_html__('Right', 'coupon-x'),
            ];

            foreach ($custom_positions as $key => $value) {
                $checked = $key === $custom_pos ? 'checked' : '';
                ?>
                                <li>
                                    <label> 
                                        <input type='radio' name='cx_settings[tab][custom_position]'  value='<?php echo esc_attr($key); ?>' <?php echo esc_attr($checked); ?> class='custom_position'> 
                <?php echo esc_attr($value); ?> 
                                    </label>
                                </li>
                <?php
            }
            ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class='row  custom-position last <?php echo esc_attr('custom' !== $settings['position'] ? 'hide' : ''); ?>'>
                    <div class='row-elements half'>
                        <label> 
          <?php esc_html_e('Bottom Spacing (px)', 'coupon-x'); ?> 
                        </label>
                        <input type='number' name='cx_settings[tab][bottom_spacing]' value='<?php echo esc_attr($settings['bottom_spacing']); ?>' class='input-element num bottom-spacing'>
                    </div>
                    <div class='row-elements half'>
                        <label> 
          <?php esc_html_e('Side Spacing (px)', 'coupon-x'); ?> 
                        </label>
                        <input type='number' name='cx_settings[tab][side_spacing]' value = '<?php echo esc_attr($settings['side_spacing']); ?>' class='input-element num side-spacing'>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements'>
                        <label> 
          <?php esc_html_e('Tab Size (px)', 'coupon-x'); ?> 
                        </label>
                        <input type='number' name='cx_settings[tab][tab_size]' value='<?php echo esc_attr($settings['tab_size']); ?>' min='20' class='input-element num tab-size'>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Call to action', 'coupon-x'); ?> 
                        </label>
                        <input type='text' name='cx_settings[tab][call_action]' value='<?php echo esc_attr($settings['call_action']); ?>' class='input-element call-action'>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements half color-row'>
                        <label> 
          <?php esc_html_e('Call to action color', 'coupon-x'); ?>                             
                            <input type='text' id='action_color' class='jsspan tab-clr' name='cx_settings[tab][action_color]' value='<?php echo esc_attr($settings['action_color']); ?>'/>
                        </label>                        
                    </div>
                    <div class='row-elements half extra color-row'>                
                        <label> 
                            <span class='lbl'><?php esc_html_e('Call to action background', 'coupon-x'); ?> </span>
                            <input type='text' id='action_bgcolor' class='jsspan tab-clr' name='cx_settings[tab][action_bgcolor]' value='<?php echo esc_attr($settings['action_bgcolor']); ?>'/>
                        </label>
                    </div>                    
                </div>                
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Show CTA', 'coupon-x'); ?> 
                        </label>
                        <ul class='custom-list'>
                            <li>
                                <label> 
                                    <input type='radio' name='cx_settings[tab][show_cta]' value='1' <?php echo checked(esc_attr($settings['show_cta']), 1, false); ?>>
                                    <?php esc_html_e('Always', 'coupon-x'); ?> 
                                </label>
                            </li>
                            <li>
                                <label> 
                                    <input type='radio' name='cx_settings[tab][show_cta]'  value='2' <?php echo checked(esc_attr($settings['show_cta']), 2, false); ?>>
                                    <?php esc_html_e('Until 1st click/hover', 'coupon-x'); ?>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Show Tab', 'coupon-x'); ?> 
                        </label>
                        <ul class='custom-list'>
                            <li>
                                <label> 
                                    <input type='radio' name='cx_settings[tab][show_tab]' value='1' <?php echo checked(esc_attr($settings['show_tab']), 1, false); ?>>
                                    <?php esc_html_e('Always', 'coupon-x'); ?> 
                                </label>
                            </li>
                            <li>
                                <label> 
                                    <input type='radio' name='cx_settings[tab][show_tab]' value='2' <?php echo checked(esc_attr($settings['show_tab']), 2, false); ?>>
                                    <?php esc_html_e('Hide after conversion', 'coupon-x'); ?>

                                    <span class="icon label-tooltip coupon-tab-design" title="<?php esc_html_e('Hide the tab after a user has converted, which means copied the coupon code or submitted their email.', 'coupon-x'); ?>">
                                        <span class="dashicons dashicons-editor-help"></span>
                                    </span>
                                </label>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label>
                            <span class="icon label-tooltip coupon-tab-design" title="<?php esc_html_e("Increase your click-rate by displaying a pending messages icon near your Coupon widget to let your visitors know that you're waiting for them to contact you.", 'coupon-x'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span> 
          <?php esc_html_e('Pending messages', 'coupon-x'); ?> 
                        </label>
                        <label class='couponapp-switch'>
                            <input type='checkbox' name='cx_settings[tab][msg]' class='pmsg' value='1' <?php echo checked(esc_attr($settings['msg']), 1, false); ?>>
                            <span class="cx-slider round">
                                <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                                <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                            </span>
                        </label>
                    </div>
                </div>
                <div class='pending-msg <?php echo esc_attr(1 === (int) $settings['msg'] ? '' : 'hide'); ?> '>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Number of messages', 'coupon-x'); ?> 
                        </label>
                        <input type='number' name='cx_settings[tab][no_msg]' min-value='1' value='<?php echo esc_attr($settings['no_msg']); ?>' min ='1' class='no_msg input-element'>
                    </div>
                    <div class='row-elements full color-row'>
                        <label> 
          <?php esc_html_e('Number color', 'coupon-x'); ?>
                            <input type='text' id='no_color' class='jsspan tab-clr' name='cx_settings[tab][no_color]' value='<?php echo esc_attr($settings['no_color']); ?>'/>
                        </label>
                    </div>
                    <div class='row-elements full color-row'>
                        <label> 
          <?php esc_html_e('Background color', 'coupon-x'); ?> 
                            <input type='text' id='no_bgcolor' class='jsspan tab-clr' name='cx_settings[tab][no_bgcolor]' value='<?php echo esc_attr($settings['no_bgcolor']); ?>'/>
                        </label>                        
                    </div>
                </div>
                <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Font Family', 'coupon-x'); ?> 
                        </label>
                        <select name='cx_settings[tab][font]' class='fonts-input input-element'>
          <?php
            $fnt   = $settings['font'];
            $fonts = Cx_Helper::couponx_fonts();
            foreach ($fonts as $key => $val) {
                ?>
                                <optgroup label="<?php echo esc_attr($key); ?>">
                <?php
                foreach ($val as $font) {
                       $font_value = str_replace(' ', '_', $key).'-'.str_replace(' ', '_', $font);
                    ?>
                                    <option value='<?php echo esc_attr($font_value); ?>' <?php echo selected($fnt, $font_value, false); ?>>
                    <?php echo esc_attr($font); ?>
                                    </option>
                       <?php
                }
                ?>
                                </optgroup>
                <?php
            }

            ?>
                        </select>
                    </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
          <?php esc_html_e('Attention Effect', 'coupon-x'); ?> 
                        </label>
                        <select name='cx_settings[tab][effect]' class='input-element animation-effect'>
                            <option value='none'>
                                <?php esc_html_e('None', 'coupon-x'); ?> 
                            </option>
          <?php
            $effect     = $settings['effect'];
            $tab_shapes = [
                'flash'     => esc_html__('Flash', 'coupon-x'),
                'shake'     => esc_html__('Shake', 'coupon-x'),
                'swing'     => esc_html__('Swing', 'coupon-x'),
                'tada'      => esc_html__('Tada', 'coupon-x'),
                'heartbeat' => esc_html__('Heartbeat', 'coupon-x'),
                'wobble'    => esc_html__('Wobble', 'coupon-x'),
            ];
            foreach ($tab_shapes as $key => $value) {
                ?>
                                <option value='<?php echo esc_attr($key); ?>' <?php echo selected($effect, $key, false); ?>>
                <?php echo esc_attr($value); ?> 
                                </option>
                <?php
            }
            ?>
                        </select>
                    </div>
                </div>
            </div>
        <?php
        $this->render_tab_preview($settings);
        ?>
        </div>
        <?php

    }//end render_tab_design()


    /**
     * Renders Tab design preview html
     *
     * @param settings $settings array of widget settings.
     */
    public function render_tab_preview($settings)
    {

        // Generate css from settings and load it in style tag.
        $css = Cx_Helper::get_tab_css($settings);
        $coupon_tab_icon = Cx_Helper::coupon_tab_icon();
        $couponapp_class = [];
        // Create an array of all applicable class and assign it to parent div.
        if ('custom' === $settings['position']) {
            $couponapp_class[] = 'couponapp-position-'.$settings['custom_position'];
        } else {
            $couponapp_class[] = 'couponapp-position-'.$settings['position'];
        }

        $couponapp_class[] = 'couponapp-tab-shape-'.$settings['tab_shape'];
        $couponapp_class[] = 'couponapp-'.$settings['effect'].'-animation';

        $couponapp_classes = join(' ', $couponapp_class);
        ?>
        <style>
        <?php echo esc_attr($css); ?>
        </style>
        <div class="mobile-preview-btn">
            <a class="btn-previewbtn" href="#">
        <?php esc_html_e('Preview', 'coupon-x'); ?>
            </a>
        </div>
        <div class='tab-preview'>
            <div class='preview-containter'>
            <label class='preview-lbl'>
        <?php esc_html_e('Preview', 'coupon-x'); ?> 
            </label>
            <div class='preview-box'>
                <div class="tab-box <?php echo esc_attr($couponapp_classes); ?>">
                    <div class="tab-box-wrap">
                        <div class="tab-text" >
        <?php echo esc_attr($settings['call_action']); ?>
                        </div>
                        <span class="tab-tooltip" data-title="<?php esc_attr_e('Actual pop up preview will be displayed in the "Pop Up Design" step', 'coupon-x'); ?>"></span>
                        <div class="tab-icon" >                            
                            <span class='icon-img'>
        <?php if ('hexagon' === $settings['tab_shape']) : ?>
                                <span class="after hexagon-after" >
                                </span>
                                <span class="before hexagon-before" >
                                </span>
        <?php endif; ?>
        <?php if ('custom' === $settings['tab_icon'] && '' !== $settings['tab_custom_icon']) : ?>
                                <img class="custom-tab-img" src="<?php echo esc_url($settings['tab_custom_icon']); ?>" />
            <?php
          else :
              echo wp_kses($coupon_tab_icon[$settings['tab_icon']], Cx_Helper::get_svg_ruleset());
          endif;
            ?>
                            </span>
                            <span id='coupon-pending-message' class="coupon-pending-message <?php echo esc_attr('1' === $settings['msg'] ? '' : 'hide'); ?>" >
                                <?php echo esc_attr($settings['no_msg']); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="coupon-preview-close hide" >
            <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink" >
                <path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
            </svg>
        </a>
        </div>
        <?php

    }//end render_tab_preview()


}//end class

