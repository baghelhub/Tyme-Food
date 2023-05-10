<?php
/**
 * Coupon X settings
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
 * Coupon X widget frontend
 */
class Cx_Pricing
{


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->render_pricing_plans();

    }//end __construct()


    /**
     * List Coupon X features
     */
    public function render_pricing_plans()
    {
        $proURL = 'https://go.premio.io/?edd_action=add_to_cart&download_id=140318&edd_options[price_id]=';
        ?>
        <div class="key-table">
            <div class="modal-upgrade upgrade-block" id="folder-modal">
                <div class="easy-modal-inner">
                    <div class="container">
                        <div class="pricing-table">
                            <div class="price-title">Unlock All Features</div>
                            <div class="pricing-table-header">
                                <div class="pricing-table-body">
                                    <div class="pricing-table-content first active" data-option="1_year">
                                        <div class="year-col">1 Year</div>
                                        <div class="update-col">Updates &amp; Support</div>
                                        <div class="pricing-discount-col"></div>
                                    </div>
                                    <div class="pricing-table-content second" data-option="2_year">
                                        <div class="year-col">2 Years</div>
                                        <div class="update-col">Updates &amp; Support</div>
                                        <div class="pricing-discount-col"><span>32% off &#128526;</span></div>
                                    </div>
                                    <div class="pricing-table-content third" data-option="lifetime">
                                        <div class="year-col">Lifetime</div>
                                        <div class="update-col">Updates &amp; Support</div>
                                        <div class="pricing-discount-col"><span>63% off &#129395;</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="price-tables">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="price-table basic-feature">
                                            <div class="price-table-top">
                                                <div class="price-head">
                                                    <div class="plan-name">Basic</div>
                                                    <div class="plan-price">$49<span>/year</span></div>
                                                </div>
                                                <div class="plan-center">
                                                    <div class="price-permonth">Less than <b>$4.1</b>/mo · <b>Billed Annually</b></div>
                                                    <div class="price-offer">Renewals for <b>25% off</b></div>
                                                </div>
                                            </div>
                                            <div class="price-table-middle">
                                                <ul>
                                                <li class="col-li-1 h-16 flex items-center w-full border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block w-full">
                                                        1 website <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                        Use Coupon X on 1 domain </span>
                                                        </a>
                                                    </li>                                                                                                       
                                                    <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                        Unlimited widgets <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Create as many widgets as you want and target them based on pages, cart, order, country, and other targeting options</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                        Pop Up Templates <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Create a lightbox pop up, slide-in popup, or floating bar layouts for your pop ups</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-3 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                            Countdown timer <span class="has-tooltip text-blue-800">*</span>
                                                            <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                                Add a countdown timer element to your Coupon X pop up to increase conversion rate. You add a timer to a specific time and date, or just add count from the moment that the pop up appears <img src='https://couponx.premio.io/assets/images/timer-gif.gif' style='width:100%; margin-top:10px'>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                            Mailchimp & Klaviyo integrations <span class="has-tooltip text-blue-800">*</span>
                                                            <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                                Turn on email integration to get leads directly to your Mailchimp or Klaviyo lists when customers submit their emails through the pop-up widget
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <li class="on-screen-pos col-li-5 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                        Cart &amp; order history targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Show the widget based on the customer's order history or cart history. E.g. if your customer has purchased a certain product or has a certain amount in their cart - you can show or don't show the Coupon X widget</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-6 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                        Page targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Show/hide the widget on specific pages</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                        Country targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Target your widget to specific countries. You can create different widgets for different countries</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                            Date & Day Scheduling <span class="has-tooltip text-blue-800">*</span>
                                                            <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Schedule the specific time, date, and day when your Coupon X widget appears. Use this feature to offer time-limited coupons, or to start a promotion from a specific date</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                            Traffic source targeting <span class="has-tooltip text-blue-800">*</span>
                                                            <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Show the widget only to visitors who come from specific traffic sources, including direct traffic, social networks, search engines, Google Ads, or any other traffic source</span>
                                                        </a>
                                                    </li>
                                                    <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                            OS and Browsers <span class="has-tooltip text-blue-800">*</span>
                                                            <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Show the widget only to visitors who come from specific operating systems and browser</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="price-table-bottom">
                                                <div class="custom-dd">
                                                    <select class="multiple-options">
                                                        <option data-per-month="4.1" data-option="1_year" data-header="Renewals for 25% off" data-price="49" value="<?php echo esc_url($proURL) ?>37">Updates &amp; support for 1 year</option>
                                                        <option data-per-month="2.9" data-option="2_year" data-header="For 2 years" data-price="69" value="<?php echo esc_url($proURL) ?>38">Updates &amp; support for 2 years</option>
                                                        <option data-per-month="0" data-option="lifetime" data-header="For lifetime" data-price="149" value="<?php echo esc_url($proURL) ?>39">Updates &amp; support for lifetime</option>
                                                    </select>
                                                </div>
                                                <a class="cart-link" target="_blank" href="<?php echo esc_url($proURL)."37" ?>">Buy now</a>
                                            </div>
                                            <div class="bottom-position"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="price-table plus-feature">
                                            <div class="price-table-top">
                                                <div class="price-head">
                                                    <div class="plan-name">Plus</div>
                                                    <div class="plan-price">$109<span>/year</span></div>
                                                </div>
                                                <div class="plan-center">
                                                    <div class="price-permonth">Less than <b>$9.1</b>/mo · <b>Billed Annually</b></div>
                                                    <div class="price-offer">Renewals for <b>25% off</b></div>
                                                </div>
                                            </div>
                                            <div class="price-table-middle">
                                                <ul>
                                                <li class="col-li-1 h-16 flex items-center w-full border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block w-full">
                                                    5 websites <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                    Use Coupon X on 5 domains </span>
                                                    </a>
                                                </li>
                                                <li class="col-li-2 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                    Unlimited widgets <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Create as many widgets as you want and target them based on pages, cart, order, country, and other targeting options</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                    Pop Up Templates <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Create a lightbox pop up, slide-in popup, or floating bar layouts for your pop ups</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-3 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Countdown timer <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                            Add a countdown timer element to your Coupon X pop up to increase conversion rate. You add a timer to a specific time and date, or just add count from the moment that the pop up appears <img src='https://couponx.premio.io/assets/images/timer-gif.gif' style='width:100%; margin-top:10px'>
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Mailchimp & Klaviyo integrations <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                            Turn on email integration to get leads directly to your Mailchimp or Klaviyo lists when customers submit their emails through the pop-up widget
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="on-screen-pos col-li-5 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                    Cart &amp; order history targeting <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Show the widget based on the customer's order history or cart history. E.g. if your customer has purchased a certain product or has a certain amount in their cart - you can show or don't show the Coupon X widget</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-6 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                    Page targeting <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Show/hide the widget on specific pages</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                    Country targeting <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Target your widget to specific countries. You can create different widgets for different countries</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Date & Day Scheduling <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Schedule the specific time, date, and day when your Coupon X widget appears. Use this feature to offer time-limited coupons, or to start a promotion from a specific date</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Traffic source targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Show the widget only to visitors who come from specific traffic sources, including direct traffic, social networks, search engines, Google Ads, or any other traffic source</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        OS and Browsers <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Show the widget only to visitors who come from specific operating systems and browser</span>
                                                    </a>
                                                </li>
                                                </ul>
                                            </div>
                                            <div class="price-table-bottom">
                                                <div class="custom-dd">
                                                    <select class="multiple-options">
                                                        <option data-per-month="9.1" data-option="1_year" data-header="Renewals for 25% off" data-price="109" value="<?php echo esc_url($proURL) ?>40">Updates &amp; support for 1 year</option>
                                                        <option data-per-month="7.1" data-option="2_year" data-header="For 2 years" data-price="169" value="<?php echo esc_url($proURL) ?>41">Updates &amp; support for 2 years</option>
                                                        <option data-per-month="" data-option="lifetime" data-header="For lifetime" data-price="279" value="<?php echo esc_url($proURL) ?>42">Updates &amp; support for lifetime</option>
                                                    </select>
                                                </div>
                                                <a class="cart-link" target="_blank" href="<?php echo esc_url($proURL) ?>40">Buy now</a>
                                            </div>
                                            <div class="bottom-position"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="price-table agency-feature">
                                            <div class="price-table-top">
                                                <div class="price-head">
                                                    <div class="plan-name">Agency</div>
                                                    <div class="plan-price">$179<span>/year</span></div>
                                                </div>
                                                <div class="plan-center">
                                                    <div class="price-permonth">Less than <b>$15</b>/mo · <b>Billed Annually</b></div>
                                                    <div class="price-offer">Renewals for <b>25% off</b></div>
                                                </div>
                                            </div>
                                            <div class="price-table-middle">
                                            <ul>
                                                <li class="col-li-1 h-16 flex items-center w-full border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <div class="website-package w-full">
                                                        <select class="multiple-web-options" id="multiple-web-options" style="display: none;">
                                                            <option selected="selected" value="50_websites">50 websites</option>
                                                            <option value="500_websites">500 websites</option>
                                                            <option value="1000_websites">1000 websites</option>
                                                        </select>
                                                    </div>
                                                </li>                        
                                                <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Unlimited widgets <span class="has-tooltip text-blue-800">*</span>
                                                    <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Create as many widgets as you want and target them based on pages, cart, order, country, and other targeting options</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                        Pop Up Templates <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Create a lightbox pop up, slide-in popup, or floating bar layouts for your pop ups</span>
                                                        </a>
                                                </li>
                                                <li class="col-li-3 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                        <a class="group cus-tooltip cursor-pointer relative block">
                                                            Countdown timer <span class="has-tooltip text-blue-800">*</span>
                                                            <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                                Add a countdown timer element to your Coupon X pop up to increase conversion rate. You add a timer to a specific time and date, or just add count from the moment that the pop up appears <img src='https://couponx.premio.io/assets/images/timer-gif.gif' style='width:100%; margin-top:10px'>
                                                            </span>
                                                        </a>
                                                </li>
                                                <li class="col-li-4 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Mailchimp & Klaviyo integrations <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">
                                                            Turn on email integration to get leads directly to your Mailchimp or Klaviyo lists when customers submit their emails through the pop-up widget
                                                        </span>
                                                    </a>
                                                </li>
                                                <li class="on-screen-pos col-li-5 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Cart &amp; order history targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Show the widget based on the customer's order history or cart history. E.g. if your customer has purchased a certain product or has a certain amount in their cart - you can show or don't show the Coupon X widget</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-6 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Page targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Show/hide the widget on specific pages</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Country targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible">Target your widget to specific countries. You can create different widgets for different countries</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Date & Day Scheduling <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Schedule the specific time, date, and day when your Coupon X widget appears. Use this feature to offer time-limited coupons, or to start a promotion from a specific date</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        Traffic source targeting <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Show the widget only to visitors who come from specific traffic sources, including direct traffic, social networks, search engines, Google Ads, or any other traffic source</span>
                                                    </a>
                                                </li>
                                                <li class="col-li-7 py-3 w-full block border-b border-b-gray-500 px-4 text-black-800 text-base font-primary">
                                                    <a class="group cus-tooltip cursor-pointer relative block">
                                                        OS and Browsers <span class="has-tooltip text-blue-800">*</span>
                                                        <span class="tooltip__content group-hover:opacity-100 group-hover:visible"> Show the widget only to visitors who come from specific operating systems and browser</span>
                                                    </a>
                                                </li>
                                            </ul>
                                            </div>
                                            <div class="price-table-bottom">
                                                <div class="custom-dd">
                                                    <select class="multiple-options has-multiple-websites">
                                                        <option data-per-month="15" data-option="1_year" data-header="Renewals for 25% off" data-price="179" value="<?php echo esc_url($proURL) ?>43">Updates &amp; support for 1 year</option>
                                                        <option data-per-month="11.7" data-option="2_year" data-header="For 2 years" data-price="279" value="<?php echo esc_url($proURL) ?>44">Updates &amp; support for 2 years</option>
                                                        <option data-per-month="" data-option="lifetime" data-header="For lifetime" data-price="479" value="<?php echo esc_url($proURL) ?>45">Updates &amp; support for lifetime</option>
                                                    </select>
                                                </div>
                                                <a class="cart-link" target="_blank" href="<?php echo esc_url($proURL) ?>43">Buy now</a>
                                            </div>
                                            <div class="bottom-position"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="text-center price-after">
                            <p class="money-guaranteed"><span class="dashicons dashicons-yes"></span>
                                <?php esc_html_e('30 days money back guaranteed'); ?>
                            </p>
                            <p class="money-guaranteed"><span class="dashicons dashicons-yes"></span>
                                <?php esc_html_e("The plugin will always keep working even if you don't renew your license"); ?>
                            </p>
                            <div class="payments">
                                <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/payment.png'); ?>" alt="Payment" class="payment-img" />
                            </div>
                        </div>
                        <div class="folder-testimonial-list">
                            <div class="folder-testimonial">
                                <div class="testimonial-image"> <img src="<?php echo esc_url(COUPON_X_URL.'assets/img/testimonial-img.png'); ?>"> </div>
                                <div class="testimonial-data">
                                    <div class="testimonial-title"></div>
                                    <div class="testimonial-desc">I added this plugin onto a client's website and it works really well. The interface is very well laid out and easy to use and it does exactly what it says on the tin.</div>
                                    <div class="testimonial-author">- Lee Cooper</div>
                                    <div class="testimonial-author">CEO, NG-soft</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php

    }//end render_pricing_plans()


}//end class

