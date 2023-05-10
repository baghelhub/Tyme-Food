<?php
/**
 * Create Coupon - Popup Design
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
 * Create new widget - popup design
 */
class Cx_Widget_Popup
{


    /**
     * Constructor function
     *
     * @param : $settings array of widget settings.
     */
    public function __construct($settings)
    {
        $this->render_popup_design($settings);

    }//end __construct()


    /**
     * Renders popup design tab html
     *
     * @param : $settings array of widget settings.
     */
    public function render_popup_design($settings)
    {
        $popup_settings  = $settings['popup'];
        $main_settings   = $settings['main'];
        $style           = $popup_settings['style'];
        $coupon_settings = $settings['coupon'];
        // Get icons from helper file.
        $icons       = Cx_Helper::coupon_type();
        $coupon_type = $popup_settings['coupon_type'];

        ?>
        <div class='cx-tab cx-popup'>
            <div class='popup-settings'>
                <h3><?php esc_html_e('Pop Up Design', 'coupon-x'); ?></h3>
                <div class='row-ul'>
                    <div class=' full'>
                        <label> 
                            <?php esc_html_e('Select your pop up\'s layout:', 'coupon-x'); ?>
                        </label>
                        <ul class='layout-list'>
                            <li class='popup-type slide-in-popup'>
                                <label> 
                                <button disabled class="btn-select-layout hide">Select</button>    
                                <button disabled class="btn-selected-style <?php echo ( isset($_GET['id']) && '' !== $_GET['id'] ) ? '' : 'hide'; ?>">Selected </button>
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/300x198.png'); ?>" />
                                    <span class="popup-style-lable">
                                        <?php esc_html_e('Slide-in Pop up', 'coupon-x'); ?> 
                                    </span>                                    
                                </label>
                            </li>
                            <li class='popup-type lightbox-popup '>
                                <label> 
                                    <span class='popup-upgrade hide'>
                                    <a target='_blank' href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                                        <span class="dashicons dashicons-lock"></span>
                                        UPGRADE NOW
                                    </a>
                                    </span>    
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/300x198.png'); ?>" />
                                    <span class="popup-style-lable">
                                        <?php esc_html_e('Lightbox Pop Up', 'coupon-x'); ?> 
                                    </span>                                    
                                </label>
                            </li>
                            <li class='popup-type floating-bar'>
                                <label> 
                                    <span class='popup-upgrade hide'>
                                    <a target='_blank' href="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                                        <span class="dashicons dashicons-lock"></span>
                                        UPGRADE NOW
                                    </a>
                                    </span>    
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/300x198.png'); ?>" />
                                    <span class="popup-style-lable">
                                        <?php esc_html_e('Floating Bar', 'coupon-x'); ?> 
                                    </span>                                    
                                </label>
                            </li>
                        </ul>                        
                    </div>
                </div>
                <div class='popup-wrapper <?php echo ( isset($_GET['id']) && '' !== $_GET['id'] ) ? '' : 'hide'; ?>'>
                <div class='row hide'>
                    <div class='row-elements full'>
                        <label> 
                            <?php esc_html_e('Select your pop up\'s layout:', 'coupon-x'); ?>
                        </label>
                        <ul>
                            <li class='popup-type'>
                                <label> 
                                    <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/300x198.png'); ?>" />
                                    <span class="popup-style-lable">Slide-in Pop up</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
                            <?php esc_html_e('When visitors click on the tab, show them:', 'coupon-x'); ?>
                        </label>                        
                        <ul class='coupon-widget-style'>
                            <li class='cp <?php echo esc_attr('4' === $coupon_type ? 'hide' : ''); ?>'>
                                <label class='ctype coupon-popup <?php echo esc_attr('style-1' === $style ? 'checked' : ''); ?>'>
                                    <input type="radio" name="cx_settings[popup][style]" value="style-1" id = "input-field-radio-style-1" class="input-field-radio" <?php echo checked($style, 'style-1', false); ?>>
                                    <?php echo wp_kses($icons['coupon_cpy'], Cx_Helper::get_svg_ruleset()); ?>
                                    <span>
                                        <?php esc_html_e('Show a coupon code with a Copy button', 'coupon-x'); ?>
                                    </span>
                                </label>
                            </li>
                            <li  class='cp <?php echo  '4' === $coupon_type ? 'hide' : ''; ?>'>
                                <label class='ctype coupon-popup <?php echo esc_attr('style-2' === $style ? 'checked' : ''); ?>'>
                                    <input type="radio" name="cx_settings[popup][style]" value="style-2" id = "input-field-radio-style-2" class="input-field-radio" <?php echo checked($style, 'style-2', false); ?>>
                                    <?php echo wp_kses($icons['email'], Cx_Helper::get_svg_ruleset()); ?>
                                    <span>
                                        <?php esc_html_e('Collect email first, then show the coupon', 'coupon-x'); ?>
                                    </span>
                                </label>
                            </li>
                            <li  class='cp <?php echo  '4' === $coupon_type ? 'hide' : ''; ?>'>
                                <label class='ctype coupon-popup <?php echo esc_attr('style-3' === $style ? 'checked' : ''); ?>'>
                                    <input type="radio" name="cx_settings[popup][style]" value="style-3" id = "input-field-radio-style-3" class="input-field-radio" <?php echo checked($style, 'style-3', false); ?>>
                                    <?php echo wp_kses($icons['link'], Cx_Helper::get_svg_ruleset()); ?>
                                    <span>
                                        <?php esc_html_e('Link to any page, or use a shareable discount link', 'coupon-x'); ?>
                                    </span>
                                </label>
                            </li>
                            <li  class='an <?php echo  '4' !== $coupon_type ? 'hide' : ''; ?>'>
                                <label class='ctype announcement-popup <?php echo esc_attr('style-4' === $style ? 'checked' : ''); ?>'>
                                    <input type="radio" name="cx_settings[popup][style]" value="style-4" id = "input-field-radio-style-4" class="input-field-radio" <?php echo checked($style, 'style-4', false); ?>>
                                    <?php echo wp_kses($icons['coupon_cpy'], Cx_Helper::get_svg_ruleset()); ?>
                                    <span>
                                        <?php esc_html_e('Show announcement screen right away', 'coupon-x'); ?>
                                    </span>
                                </label>
                            </li>
                            <li  class='an <?php echo  '4' !== $coupon_type ? 'hide' : ''; ?>'>
                                <label class='ctype announcement-popup <?php echo esc_attr('style-5' === $style ? 'checked' : ''); ?>'>
                                    <input type="radio" name="cx_settings[popup][style]" value="style-5" id = "input-field-radio-style-5" class="input-field-radio" <?php echo checked($style, 'style-5', false); ?>>
                                    <?php echo wp_kses($icons['email'], Cx_Helper::get_svg_ruleset()); ?>
                                    <span>
                                        <?php esc_html_e('Collect email first, then show the announcement', 'coupon-x'); ?>
                                    </span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class='row style-3 <?php echo esc_attr('style-3' !== $style ? 'hide' : ''); ?>'>
                <div class='row-elements full style-3'>
                    <label> 
                        <?php esc_html_e('Link type', 'coupon-x'); ?>
                    </label>
                    <select class='input-element link-type' name='cx_settings[coupon][link_type]'>
                        <option value='1' <?php echo selected($coupon_settings['link_type'], 1, false); ?>>
                            <?php esc_html_e('Shareable discount link', 'coupon-x'); ?>
                        </option>
                        <option value='2' <?php echo selected($coupon_settings['link_type'], 2, false); ?>>
                            <?php esc_html_e('Custom link', 'coupon-x'); ?>
                        </option>
                    </select>
                </div>
            </div>
            <div class='row custom-link <?php echo ( 'style-3' !== $style || 1 === (int) $coupon_settings['link_type'] ) ? 'hide' : ''; ?>'>
                <div class='row-elements full'>
                    <label> 
                        <?php esc_html_e('Link', 'coupon-x'); ?>
                    </label>
                    <input type='text' name='cx_settings[coupon][custom_link]' placeholder="<?php esc_attr_e('https://www.anypage.com/you-want', 'coupon-x'); ?>" class='input-element' value='<?php echo esc_attr($coupon_settings['custom_link']); ?>'>
                </div>
            </div>
            <div class='row style-3 <?php echo ( 'style-3' === $style && 1 === (int) $coupon_settings['link_type'] ) ? '' : 'hide'; ?>'>
                <div class='row-elements full'>
                    <label>
                        <?php
                         $new_tab = isset($coupon_settings['new_tab']) ? $coupon_settings['new_tab'] : 0;
                        ?>
                        <input type='checkbox' name='cx_settings[coupon][new_tab]' value='1' <?php echo checked($new_tab, 1, false); ?>> 
                        <?php esc_html_e('Open New Tab', 'coupon-x'); ?>
                    </label>
                </div>
            </div>
            <div class='row'>
                <div class='row-elements full'>
                    <div class="couponapp-countdown" style="position: relative;display: inline-block;">
                        <span class="icon label-tooltip coupon-tab-design" title="<?php esc_html_e('Add a countdown timer element to your Coupon X pop up to increase conversion rate. You add a timer to a specific time and date, or just add count from the moment that the pop up appears.', 'coupon-x'); ?> <img src='https://couponx.premio.io/assets/images/timer-gif.gif' style='width:100%; margin-top:10px'>">
                            <span class="dashicons dashicons-editor-help"></span>
                        </span> 
                        <div class="upgrade-timer">    
                                <span class='txt'> Add a Countdown Timer</span>
                                
                            </a>
                        </div>                        
                    </div>                
                </div>
            </div>
            <div class='row'>
                <div class='row-elements full'>
                    <div class='screen-tab' >
                        <input type='hidden' value='<?php echo esc_attr($popup_settings['coupon_type']); ?>' name='cx_settings[popup][coupon_type]' class='coupon-type'/>
                        <ul class='coupon-tabs screen-tabs <?php echo esc_attr('style-2' !== $style ? 'hide' : ''); ?> '>
                            <li>
                                <a href="#main_screen" class="coupon-tab main-screen">
                                    <?php esc_html_e('Main Screen', 'coupon-x'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#coupon_screen" class="coupon-tab coupon-screen">
                                    <?php esc_html_e('Coupon Screen', 'coupon-x'); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#announcement_screen" class="coupon-tab announcement-screen">
                                    <?php esc_html_e('Announcement Screen', 'coupon-x'); ?>
                                </a>
                            </li>
                        </ul>
                        <div id='main_screen' class='<?php echo esc_attr('style-2' !== $style ? 'hide' : ''); ?> '>
                            <?php $this->render_main_screen_settings($settings); ?>
                        </div>
                        <div id='coupon_screen'>
                            <?php $this->render_coupon_screen_settings($settings); ?>
                        </div>
                        <div id='announcement_screen'>
                            <?php $this->render_announcement_screen_settings($settings); ?>
                        </div>
                    </div>
                </div>
            </div>
            <button class="accordion-btn"><?php esc_html_e('Advanced Settings', 'coupon-x'); ?></button>
            <div class = 'advanced-panel'>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
                            <?php esc_html_e('After Copy Message', 'coupon-x'); ?>
                        </label>
                        <input type='text' name='cx_settings[coupon][cpy_msg]' value="<?php echo esc_attr($coupon_settings['cpy_msg']); ?>" class='input-element '>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full color-row'>
                        <label>
                            <span class="icon label-tooltip" title="<?php esc_html_e('Set an error message that your visitors get when they try to add the same email more than one time', 'coupon-x'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            <?php esc_html_e('Set an error message', 'coupon-x'); ?>
                        </label>
                        <textarea name='cx_settings[main][error]'><?php echo esc_attr($main_settings['error']); ?></textarea>
                        <input type='text' id='error_color' class='jsspan tab-clr' name='cx_settings[main][error_color]' value='<?php echo esc_attr($main_settings['error_color']); ?>'/>
                    </div>
                </div>
                <div class='row'>
                    <div class='row-elements full'>
                        <label> 
                            <?php esc_html_e('Custom CSS', 'coupon-x'); ?>
                            <div class="html-tooltip side">                                                            
                                <span class='icon label-tooltip' title ="<?php esc_html_e('Write custom CSS to customize your widget.', 'coupon-x'); ?><a href='https://premio.io/help/coupon-x/how-to-customize-your-coupon-x-widget-using-css/' target='_blank'><?php esc_html_e('Learn more', 'coupon-x'); ?></a>">
                                    <span class="dashicons dashicons-editor-help">
                                    </span>    
                                </span>
                            </div>
                        </label>
                        <textarea name='cx_settings[popup][custom_css]' class='input-element custom-css' rows="10" placeholder="#tab-box-front-0 .tab-box-content.tab-box-couponcode-content{border-style: dotted;}"><?php echo esc_attr($popup_settings['custom_css']); ?></textarea>
                    </div>
                </div>
                <div class='row '>
                    <div class='row-elements full display-flex'>
                        <label >
                            <span class="icon label-tooltip coupon-tab-design top" title="<?php esc_html_e('After the user have clicked on the copy button or submitted their emails, you can have the widget automatically closed after a few seconds', 'coupon-x'); ?>">
                                <span class="dashicons dashicons-editor-help"></span>
                            </span>
                            <?php esc_html_e('Close automatically after conversion', 'coupon-x'); ?>
                        </label>
                        <div>
                            <?php
                            $auto_close = isset($popup_settings['auto_close']) ? $popup_settings['auto_close'] : 0;
                            ?>
                            <label class='couponapp-switch'>
                                <input type='checkbox' name='cx_settings[popup][auto_close]' class='auto-close' value='1' <?php echo checked($auto_close, 1, false); ?>>
                                <span class="cx-slider round">
                                    <span class="on"><?php esc_html_e('On', 'coupon-x'); ?></span>
                                    <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class='row auto-close-text <?php echo 1 !== (int) $auto_close ? 'hide' : ''; ?>' >
                    <div class='row-elements full'>
                        <label>
                            <?php esc_html_e('Close after:', 'coupon-x'); ?>
                            <input type='number' name='cx_settings[popup][auto_time]' value='<?php echo esc_attr($popup_settings['auto_time']); ?>' class='close-time input-element' min='0'> 
                            <?php esc_html_e('seconds', 'coupon-x'); ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
            </div>
            <div class="mobile-preview-btn <?php echo ( isset($_GET['id']) && '' !== $_GET['id'] ) ? '' : 'hide'; ?>">
                <a class="btn-popup-previewbtn" href="#">
                    <?php esc_html_e('Preview', 'coupon-x'); ?>
                </a>
            </div>
            <div class='popup-preview <?php echo ( isset($_GET['id']) && '' !== $_GET['id'] ) ? '' : 'hide'; ?>'>
                <div class='preview-containter'>
                    <label class='preview-lbl'>
                        <?php esc_html_e('Preview', 'coupon-x'); ?>
                    </label>
                    <div class='preview-box'>
                        <?php $this->render_popup_preview($settings); ?>
                    </div>
                </div>
                <a href="#" class="popup-preview-close  <?php echo ( isset($_GET['id']) && '' !== $_GET['id'] ) ? '' : 'hide'; ?>" >
                    <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="10px" height="10px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 2.19 2.19" xmlns:xlink="http://www.w3.org/1999/xlink" >
                        <path class="fil0" d="M1.84 0.06c0.08,-0.08 0.21,-0.08 0.29,0 0.08,0.08 0.08,0.21 0,0.29l-0.75 0.74 0.75 0.75c0.08,0.08 0.08,0.21 0,0.29 -0.08,0.08 -0.21,0.08 -0.29,0l-0.75 -0.75 -0.74 0.75c-0.08,0.08 -0.21,0.08 -0.29,0 -0.08,-0.08 -0.08,-0.21 0,-0.29l0.74 -0.75 -0.74 -0.74c-0.08,-0.08 -0.08,-0.21 0,-0.29 0.08,-0.08 0.21,-0.08 0.29,0l0.74 0.74 0.75 -0.74z"/>
                    </svg>
                </a>
            </div>
        </div>
        <?php

    }//end render_popup_design()


    /**
     * Renders main screen tab html
     *
     * @param : $settings array of widget settings.
     */
    public function render_main_screen_settings($settings)
    {
        $settings = $settings['main'];
        ?>
                                
        <div class='row'>
            <div class='row-elements full color-row'>
                <label> 
                    <?php esc_html_e('Headline', 'coupon-x'); ?>
                </label>
                <textarea name='cx_settings[main][headline]' class='main-headline'><?php echo esc_attr($settings['headline']); ?></textarea>                
                <input type='text' id='main_hcolor' class='jsspan tab-clr' name='cx_settings[main][headline_color]' value='<?php echo esc_attr($settings['headline_color']); ?>'/>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full'>
                <label> 
                    <?php esc_html_e('Email', 'coupon-x'); ?>
                </label>
                <input type='text' name='cx_settings[main][email]' placeholder="Email" class='input-element main-email' value='<?php echo esc_attr($settings['email']); ?>'>            
            </div>
        </div>            
        <div class='row'>
            <div class='row-elements full'>
                <label> 
                    <?php esc_html_e('Text Inside Button', 'coupon-x'); ?>
                </label>
                <input type='text' name='cx_settings[main][btn_text]' value="<?php echo esc_attr($settings['btn_text']); ?>" class='input-element main-btn-text'>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full color-row'>
                <label> 
                    <?php esc_html_e('Description', 'coupon-x'); ?>
                </label>
                <textarea name='cx_settings[main][desc]' class='main-desc'><?php echo esc_attr($settings['desc']); ?></textarea>
                <input type='text' id='main_desc_color' class='jsspan tab-clr' name='cx_settings[main][desc_color]' value='<?php echo esc_attr($settings['desc_color']); ?>'/>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full'>
                <label>
                    <?php
                    $consent = isset($settings['consent']) ? $settings['consent'] : 0;
                    ?>
                    <input type='checkbox' name='cx_settings[main][consent]' value='1' <?php echo checked($consent, 1, false); ?> class='consent'>
                    <?php esc_html_e('Consent checkbox', 'coupon-x'); ?>
                </label>
            </div>
        </div>
        <?php
        $consent_required = isset($settings['consent_required']) ? $settings['consent_required'] : 0;
        ?>
        <div class='row consent-text 
        <?php
        if (! $consent) {
            echo esc_attr('hide');
        }
        ?>
        ' >
            <div class="row-elements full">
                <input type="text" name="cx_settings[main][consent_text]" value="<?php echo esc_attr($settings['consent_text']); ?>" class="input-element" placeholder="<?php echo esc_html__('Enter your consent text', 'coupon-x'); ?>" />

                <label class='required-lbl'><input type="checkbox" name="cx_settings[main][consent_required]" value="1" <?php echo ( 1 === (int) $consent_required ) ? 'checked' : ''; ?>  />
                    <?php echo esc_html__('Required', 'coupon-x'); ?>
                </label>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Background color', 'coupon-x'); ?>
                    <input type='text' id='main_bgcolor' class='jsspan tab-clr' name='cx_settings[main][bgcolor]' value='<?php echo esc_attr($settings['bgcolor']); ?>'/>
                </label>                
            </div>
            <div class='row-elements half'>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Email Field Color', 'coupon-x'); ?>
                    <input type='text' id='main_email_bgcolor' class='jsspan tab-clr' name='cx_settings[main][email_color]' value='<?php echo esc_attr($settings['email_color']); ?>'/>
                </label>                
            </div>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Text Color(Email)', 'coupon-x'); ?>
                    <input type='text' id='main_email_color' class='jsspan tab-clr' name='cx_settings[main][text_color]' value='<?php echo esc_attr($settings['text_color']); ?>'/>
                </label>                
            </div>
        </div>
        <div class='row'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Email Border Color', 'coupon-x'); ?>
                    <input type='text' id='main_email_brdcolor' class='jsspan tab-clr' name='cx_settings[main][email_brdcolor]' value='<?php echo esc_attr($settings['email_brdcolor']); ?>'/>
                </label>                
            </div>
            <div class='row-elements half'></div>
        </div>
        <div class='row'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Button Color', 'coupon-x'); ?>
                    <input type='text' id='main_btn_bgcolor' class='jsspan tab-clr' name='cx_settings[main][btn_color]' value='<?php echo esc_attr($settings['btn_color']); ?>'/>
                </label>                
            </div>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Text Color', 'coupon-x'); ?>
                    <input type='text' id='main_btn_color' class='jsspan tab-clr' name='cx_settings[main][btn_text_color]' value='<?php echo esc_attr($settings['btn_text_color']); ?>'/>
                </label>                
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full'>                
                <label>
                    <?php
                    $leads_url = admin_url().'admin.php?page=leads_list';
                    ?>
                    <strong>
                        <?php esc_attr_e('Your leads will be saved to', 'coupon-x'); ?>
                        <a href='<?php echo esc_url($leads_url); ?>' class='leads-url' target='_blank'>
                        <?php esc_attr_e('this site', 'coupon-x'); ?>
                        </a> 
                    </strong>                    
                    <span class="icon label-tooltip coupon-tab-design usage-limits" title="<?php echo esc_html__('Your leads will be saved in your local database, you will be able to find them ', 'coupon-x'); ?> <a href='<?php echo esc_attr($leads_url); ?>'><?php echo esc_html__('here', 'coupon-x'); ?>">
                        <span class="dashicons dashicons-editor-help"></span>
                    </span>
                </label>
            </div>
        </div>        
        <div class='row'>
            <div class='row-elements full'>                
                <label>
                    <input type='checkbox' name='' value='1'  disabled>
                    <?php esc_html_e('Send coupon to client (coming soon!) ', 'coupon-x'); ?>
                </label>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full  email-client'>                
                <label  url ="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                    <input type='checkbox' name='' disabled>
                    <?php esc_html_e('Sends leads to Mailchimp', 'coupon-x'); ?>
                </label>
                <span class='upgrade-pro right-aligned' url ="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                    <span class="dashicons dashicons-lock"></span>
                    UPGRADE NOW
                </span>                    
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full email-client'>                
                <label  url ="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                    <input type='checkbox' name='' disabled>
                    <?php esc_html_e('Sends leads to Klaviyo', 'coupon-x'); ?>
                </label>
                <span class='upgrade-pro right-aligned' url ="<?php echo esc_url(admin_url('admin.php?page=couponx_pricing_tbl')); ?>">
                    <span class="dashicons dashicons-lock"></span>
                    UPGRADE NOW
                </span>                    
            </div>
        </div>
        <?php

    }//end render_main_screen_settings()


    /**
     * Renders coupon screen tab html
     *
     * @param : $all_settings array of widget settings.
     */
    public function render_coupon_screen_settings($all_settings)
    {

        $popup_settings = $all_settings['popup'];
        $style          = $popup_settings['style'];
        $coupon_type    = $popup_settings['coupon_type'];
        $settings       = $all_settings['coupon'];
        $enable_styles  = isset($settings['enable_styles']) ? $settings['enable_styles'] : 0;
        ?>
                     
        <div class='row cpn-cpy <?php echo esc_attr((isset($popup_settings['type']) && $popup_settings['type'] !== 'style-2') ? 'hide' : ''); ?>'>
            <div class='row-elements full'>                
                <label class="couponapp-switch">
                    <input type="checkbox" name="cx_settings[coupon][enable_styles]" value="1" <?php echo checked($enable_styles, 1, false); ?> class='cpn-cpy-style' />
                    <span class="cx-slider round">
                        <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                        <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                    </span>
                </label>
                <label style='display: inline;vertical-align: top;margin-left: 10px;font-size: 13px;'> 
                    <?php esc_html_e('Use the same styles like the email collection screen ', 'coupon-x'); ?>
                </label>
            </div>
        </div>        
        <div class='row'>
            <div class='row-elements full color-row'>
                <label> 
                    <?php esc_html_e('Headline', 'coupon-x'); ?>
                </label>
                <textarea name='cx_settings[coupon][headline]' class='coupon-headline'><?php echo esc_attr($settings['headline']); ?></textarea>                
                <input type='text' id='coupon_headline_clr' class='jsspan tab-clr' name='cx_settings[coupon][headline_color]' value='<?php echo esc_attr($settings['headline_color']); ?>'/>                
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full'>
                <label> 
                    <?php esc_html_e('Text Inside Button', 'coupon-x'); ?>
                </label>
                <input type='text' name='cx_settings[coupon][cpy_btn]' value="<?php echo esc_attr($settings['cpy_btn']); ?>" class='input-element cpy-btn'>
            </div>
        </div>            
        <div class='row'>
            <div class='row-elements full color-row'>
                <label> 
                    <?php esc_html_e('Description', 'coupon-x'); ?>
                </label>
                <textarea name='cx_settings[coupon][desc]' class='coupon-desc'><?php echo esc_attr($settings['desc']); ?></textarea>
                <input type='text' id='coupon_desc_color' class='jsspan tab-clr' name='cx_settings[coupon][desc_color]' value='<?php echo esc_attr($settings['desc_color']); ?>'/> 
            </div>
        </div>
        <div class='row cp-clr'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Background Color', 'coupon-x'); ?>
                    <input type='text' id='coupon_bgcolor' class='jsspan tab-clr' name='cx_settings[coupon][bg_color]' value='<?php echo esc_attr($settings['bg_color']); ?>'/>                
                </label>                
            </div>
            <div class='row-elements half'>
            </div>
        </div>
        <div class='row cp-clr'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Coupon Color', 'coupon-x'); ?>
                    <input type='text' id='coupon_pbgcolor' class='jsspan tab-clr' name='cx_settings[coupon][coupon_color]' value='<?php echo esc_attr($settings['coupon_color']); ?>'/>                    
                </label>                
            </div>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Text Color(Coupon)', 'coupon-x'); ?>
                    <input type='text' id='coupon_color' class='jsspan tab-clr' name='cx_settings[coupon][text_color]' value='<?php echo esc_attr($settings['text_color']); ?>'/>
                </label>                
            </div>
        </div>
        <div class='row cp-clr'>
            <div class='row-elements half extra color-row'>
                <label> 
                    <span class='lbl'><?php esc_html_e('Coupon Field Border Color', 'coupon-x'); ?> </span>
                    <input type='text' id='coupon_brdcolor' class='jsspan tab-clr' name='cx_settings[coupon][coupon_brdcolor]' value='<?php echo esc_attr($settings['coupon_brdcolor']); ?>'/>
                </label>                
            </div>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Close Button Color', 'coupon-x'); ?>
                    <input type='text' id='cls_btn_color' class='jsspan tab-clr' name='cx_settings[coupon][clsbtn_color]' value='<?php echo esc_attr($settings['clsbtn_color']); ?>'/>
                </label>                
            </div>
        </div>
        <div class='row cp-clr'>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Button Color', 'coupon-x'); ?>
                    <input type='text' id='cpy_btn_bgcolor' class='jsspan tab-clr' name='cx_settings[coupon][btn_color]' value='<?php echo esc_attr($settings['btn_color']); ?>'/>
                </label>                
            </div>
            <div class='row-elements half color-row'>
                <label> 
                    <?php esc_html_e('Text Color', 'coupon-x'); ?>
                    <input type='text' id='cpy_btn_color' class='jsspan tab-clr' name='cx_settings[coupon][txt_color]' value='<?php echo esc_attr($settings['txt_color']); ?>'/> 
                </label>                
            </div>
        </div>
        <?php

    }//end render_coupon_screen_settings()


    /**
     * Renders Popup design preview html
     *
     * @param : $options array of widget settings.
     */
    public function render_popup_preview($options)
    {

        $settings        = $options['main'];
        $tab_settings    = $options['tab'];
        $coupon_settings = $options['coupon'];
        $popup_settings  = $options['popup'];
        $ann_settings    = $options['announcement'];
        $style           = $popup_settings['style'];
        $css = Cx_Helper::get_popup_css_backend($options);
        // Create an array of all applicable class and assign it to parent div.
        $couponapp_class = [];
        if ('custom' === $tab_settings['position']) {
            $couponapp_class[] = 'couponapp-position-'.$tab_settings['custom_position'];
        } else {
            $couponapp_class[] = 'couponapp-position-'.$tab_settings['position'];
        }

        $couponapp_class[] = 'couponapp-tab-shape-'.$tab_settings['tab_shape'];
        $couponapp_class[] = 'couponapp-'.$tab_settings['effect'].'-animation';

        $couponapp_classes = join(' ', $couponapp_class);

        // Assign coupon code text according to the coupon type - unique code or existing coupon code.
        $coupon_code_text = '';
        $couponcode_type  = ( isset($popup_settings['coupon_type']) ) ? (int) $popup_settings['coupon_type'] : '';

        if (2 === $couponcode_type) {
            $coupon_code_text = esc_html__('Unique Code', 'coupon-x');
        } else if (1 === $couponcode_type) {
            $coupon_code_text = get_the_title($options['ex_coupon']['coupon']);
        } else {
            $coupon_code_text = $options['unique_coupon']['discount_code'];
        }

        ?>
        <div class="tab-box <?php echo esc_attr($couponapp_classes); ?> ">
        <span style="color: <?php echo esc_attr($coupon_settings['clsbtn_color']); ?>;" class="dashicons dashicons-no-alt close-design-popup"></span>
        <!-- close color -->
        <div class="tab-box-content couponapp-email-option <?php echo in_array($style, [ 'style-1', 'style-3', 'style-4' ], true) ? 'hide' : ''; ?>" style="background-color:<?php echo esc_attr($settings['bgcolor']); ?>;">
            <div class="couponx-preview-notfloating-bar">
                <h4 style="color:<?php echo esc_attr($settings['headline_color']); ?>;" >
        <?php echo esc_attr($settings['headline']); ?>
                </h4>
                <div class="form-wrap clear" style="border-color:<?php echo esc_attr($settings['email_brdcolor']); ?>; background-color:<?php echo esc_attr($settings['email_color']); ?>">
                    <p class="coupon-code-text" style="color:<?php echo esc_attr($settings['text_color']); ?>; background-color:<?php echo esc_attr($settings['email_color']); ?> "><?php echo esc_attr($settings['email']); ?></p>
                    <button class="button btn btn-blue coupon-button" id= 'coupon-button' style="color:<?php echo esc_attr($settings['btn_text_color']); ?> !important; background-color:<?php echo esc_attr($settings['btn_color']); ?> !important" disabled ><?php echo esc_attr($settings['btn_text']); ?></button>
                </div> 
                    <?php
                    $consent = isset($settings['consent']) ? $settings['consent'] : 0;
                    ?>
                    <label id="email-content-checkbox" class="email-content-checkbox <?php echo esc_attr((! $consent) ? "hide" : "") ?>">
                        <input type="checkbox" disabled />
                        <span><?php echo esc_attr($settings['consent_text']); ?></span>
                    </label>
                <p class="coupon-description" style="color:<?php echo esc_attr($settings['desc_color']); ?>;" > 
                    <?php echo esc_attr($settings['desc']); ?>
                </p>
            </div>
        </div>
        <div class="tab-box-content couponapp-code-option couponapp-email-code-option <?php echo ( 'style-1' !== $style ) ? 'hide' : ''; ?>">
            <div class="couponx-preview-notfloating-bar">
                <h4>
                    <?php
                    echo esc_attr($coupon_settings['headline']);
                    ?>
                </h4>
                <div class="form-wrap clear">
                    <p class="coupon-code-text"><?php echo esc_attr($coupon_code_text); ?></p>
                    <button class="button btn btn-blue coupon-button" id= 'coupon-buttonn' disabled><?php echo esc_attr($coupon_settings['cpy_btn']); ?></button>
                    <svg class="vector" id='vector-nonfloat-bar' width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.584 3.384C4.722 3.084 4.8 2.754 4.8 2.4C4.8 1.074 3.726 0 2.4 0C1.074 0 0 1.074 0 2.4C0 3.726 1.074 4.8 2.4 4.8C2.754 4.8 3.084 4.722 3.384 4.584L4.8 6L3.384 7.416C3.084 7.278 2.754 7.2 2.4 7.2C1.074 7.2 0 8.274 0 9.6C0 10.926 1.074 12 2.4 12C3.726 12 4.8 10.926 4.8 9.6C4.8 9.246 4.722 8.916 4.584 8.616L6 7.2L10.2 11.4H12V10.8L4.584 3.384ZM2.4 3.6C1.74 3.6 1.2 3.066 1.2 2.4C1.2 1.734 1.74 1.2 2.4 1.2C3.06 1.2 3.6 1.734 3.6 2.4C3.6 3.066 3.06 3.6 2.4 3.6ZM2.4 10.8C1.74 10.8 1.2 10.266 1.2 9.6C1.2 8.934 1.74 8.4 2.4 8.4C3.06 8.4 3.6 8.934 3.6 9.6C3.6 10.266 3.06 10.8 2.4 10.8ZM6 6.3C5.832 6.3 5.7 6.168 5.7 6C5.7 5.832 5.832 5.7 6 5.7C6.168 5.7 6.3 5.832 6.3 6C6.3 6.168 6.168 6.3 6 6.3ZM10.2 0.6L6 4.8L7.2 6L12 1.2V0.6H10.2Z" fill='<?php echo esc_attr($coupon_settings['coupon_brdcolor']); ?> '/>
                    </svg>
                </div>
                <p class="coupon-description"> 
                    <?php echo esc_attr($coupon_settings['desc']); ?>
                </p>
            </div>
        </div>
        <div class="tab-box-content couponapp-link-option  <?php echo ('style-3' === $style ? '' : 'hide'); ?>" style="background-color:<?php echo esc_attr($settings['bgcolor']); ?>;">
            <div class="couponx-preview-notfloating-bar">
                <h4 style="color:<?php echo esc_attr($coupon_settings['headline_color']); ?>;">
                    <?php
                    echo esc_attr($coupon_settings['headline']);
                    ?>
                </h4>
                <div class="form-wrap clear" style="border-color:<?php echo esc_attr($coupon_settings['coupon_brdcolor']); ?>">
                    <button class="button btn btn-blue coupon-button" id= 'coupon-buttonn' style="color:<?php echo esc_attr($coupon_settings['txt_color']); ?> !important; background-color:<?php echo esc_attr($coupon_settings['btn_color']); ?> !important" disabled><?php echo esc_attr($coupon_settings['cpy_btn']); ?></button>
                </div>
                <p class="coupon-description" style="color:<?php echo esc_attr($coupon_settings['desc_color']); ?>;" > 
                    <?php echo esc_attr($coupon_settings['desc']); ?>
                </p>
            </div>
        </div>
        <div class="tab-box-content couponapp-no-coupon-option  <?php echo ( 'style-4' !== $style ) ? 'hide' : ''; ?>" style="background-color:<?php echo esc_attr($ann_settings['bg_color']); ?>;">
            <div class="couponx-preview-notfloating-bar">
                <h4>
                    <?php
                    echo esc_attr($ann_settings['headline']);
                    ?>
                </h4>
                <div class="form-wrap clear <?php echo esc_attr(isset($ann_settings['enable_btn']) && 1 !== (int) $ann_settings['enable_btn'] ? 'hide' : ''); ?>" >
                <button class="button btn btn-blue announcement-button" id= 'announcement-button'  disabled><?php echo esc_attr($ann_settings['cpy_btn']); ?></button>
                </div>
                <p class="coupon-description"  > 
                    <?php echo esc_attr($ann_settings['desc']); ?>
                </p>
            </div>
        </div>
    </div>
    <style>
        <?php
        echo esc_attr($css);
        ?>
    </style>
        <?php

    }//end render_popup_preview()


    /**
     * Renders Announcement screen html
     *
     * @param : $all_settings array of widget settings.
     */
    public function render_announcement_screen_settings($all_settings)
    {
        $popup_settings = $all_settings['popup'];
        $style          = $popup_settings['style'];
        $coupon_type    = $popup_settings['coupon_type'];
        $settings       = $all_settings['announcement'];
        $enable_btn     = ( isset($settings['enable_btn']) && $settings['enable_btn'] ) ? (int) $settings['enable_btn'] : 0;
        $enable_styles  = $settings['enable_styles'] ? (int) $settings['enable_styles'] : 0;
        ?>
        <div class='row an-cpy-style <?php echo esc_attr('style-5' !== $popup_settings['type'] ? 'hide' : ''); ?>'>
            <div class='row-elements full'>
                <label class="couponapp-switch" >
                    <input type="checkbox" name="cx_settings[announcement][enable_styles]" value="1" <?php echo checked($enable_styles, 1, false); ?> class='cpy-style' />
                    <span class="cx-slider round">
                        <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                        <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                    </span>
                </label>
                <label style='display: inline;vertical-align: top;margin-left: 10px;font-size: 13px;'>
                    <?php esc_html_e('Use the same styles like the email collection screen ', 'coupon-x'); ?>
                </label>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full color-row'>
                <label>
                    <?php esc_html_e('Headline', 'coupon-x'); ?>
                </label>
                <textarea name='cx_settings[announcement][headline]' class='announcement-headline'><?php echo esc_attr($settings['headline']); ?></textarea>
                <input type='text' id='announcement_headline_clr' class='jsspan tab-clr' name='cx_settings[announcement][headline_color]' value='<?php echo esc_attr($settings['headline_color']); ?>'/>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full color-row'>
                <label>
                    <?php esc_html_e('Description', 'coupon-x'); ?>
                </label>
                <textarea name='cx_settings[announcement][desc]' class='announcement-desc'><?php echo esc_attr($settings['desc']); ?></textarea>
                <input type='text' id='announcement_desc_color' class='jsspan tab-clr' name='cx_settings[announcement][desc_color]' value='<?php echo esc_attr($settings['desc_color']); ?>'/>
            </div>
        </div>
        <div class='row'>
            <div class='row-elements full display-flex'>
                <label>
                    <?php esc_html_e('Display Button', 'coupon-x'); ?>
                </label>
                <label class="couponapp-switch" >
                    <input type="checkbox" name="cx_settings[announcement][enable_btn]" value="1" <?php echo checked($enable_btn, 1, false); ?> class='enable-btn' />
                    <span class="cx-slider round">
                        <span class="on"> <?php esc_html_e('On', 'coupon-x'); ?></span>
                        <span class="off"><?php esc_html_e('Off', 'coupon-x'); ?></span>
                    </span>
                </label>
            </div>
        </div>
        <div class='row btn-div <?php echo esc_attr(0 === $enable_btn ? 'hide' : ''); ?>'>
            <div class='row-elements full'>
                <label>
                    <?php esc_html_e('Text Inside Button', 'coupon-x'); ?>
                </label>
                <input type='text' name='cx_settings[announcement][cpy_btn]' value="<?php echo esc_attr($settings['cpy_btn']); ?>" class='input-element announcement-btn'>
            </div>
        </div>
        <div class='row btn-div  <?php echo esc_attr($enable_btn === 0 ? 'hide' : ''); ?>'>
            <div class='row-elements full'>
                <label>
                    <?php esc_html_e('Action On Button Click', 'coupon-x'); ?>
                </label>
                <select class='input-element btn-action' name='cx_settings[announcement][btn_action]'>
                    <option value='1' <?php echo selected($settings['btn_action'], 1, false); ?>>
                        <?php esc_html_e('Hide the widget', 'coupon-x'); ?>
                    </option>
                    <option value='2' <?php echo selected($settings['btn_action'], 2, false); ?>>
                        <?php esc_html_e('Redirect the visitor to another URL', 'coupon-x'); ?>
                    </option>
                </select>
            </div>
        </div>
        <div class='row announcement-redirect <?php echo ( 1 === $enable_btn && 2 === (int) $settings['btn_action'] ) ? '' : 'hide'; ?>'>
            <div class='row-elements full '>
                <label>
                    <?php esc_html_e('Button Redirection Link', 'coupon-x'); ?>
                </label>
                <input type='text' name='cx_settings[announcement][redirect_url]' value="<?php echo esc_attr($settings['redirect_url']); ?>" class='input-element'>
            </div>
        </div>
        <div class='row announcement-redirect <?php echo ( 1 === $enable_btn && 2 === (int) $settings['btn_action'] ) ? '' : 'hide'; ?>'>
            <div class='row-elements full'>
                <label>
                    <?php
                    $new_tab = isset($settings['new_tab']) ? $settings['new_tab'] : 0;
                    ?>
                    <input type='checkbox' name='cx_settings[announcement][new_tab]' value='1' <?php echo checked($new_tab, 1, false); ?>>
                    <?php esc_html_e('Open in a New Tab', 'coupon-x'); ?>
                </label>
            </div>
        </div>
        <div class='row an-clr <?php echo esc_attr(1 === $enable_styles ? 'hide' : ''); ?>'>
            <div class='row-elements half color-row'>
                <label>
                    <?php esc_html_e('Background Color', 'coupon-x'); ?>
                    <input type='text' id='announcement_bgcolor' class='jsspan tab-clr' name='cx_settings[announcement][bg_color]' value='<?php echo esc_attr($settings['bg_color']); ?>'/>
                </label>
            </div>
            <div class='row-elements half'>
            </div>
        </div>
        <div class='row btn-div btn-clr <?php echo esc_attr(( 1 === $enable_btn && 2 === (int) $settings['btn_action'] ) ? '' : 'hide'); ?>'>
            <div class='row-elements half color-row'>
                <label>
                    <?php esc_html_e('Button Color', 'coupon-x'); ?>
                    <input type='text' id='announcement_btn_bgcolor' class='jsspan tab-clr' name='cx_settings[announcement][btn_color]' value='<?php echo esc_attr($settings['btn_color']); ?>'/>
                </label>
            </div>
            <div class='row-elements half color-row'>
                <label>
                    <?php esc_html_e('Text Color', 'coupon-x'); ?>
                    <input type='text' id='announcement_btn_color' class='jsspan tab-clr' name='cx_settings[announcement][txt_color]' value='<?php echo esc_attr($settings['txt_color']); ?>'/>
                </label>
            </div>
        </div>
        <?php

    }//end render_announcement_screen_settings()


}//end class
