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

namespace FPFramework\Libs;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

class AdminNotice {
    /**
     * Notice Field prefix
     * 
     * @var  String
     */
    const NOTICE_FIELD = 'FPF_admin_notice_message';

    /**
     * Displays a notice.
     * The notice is displayed once and is destroyed upon page refresh.
     * 
     * @return  void
     */
    public function displayAdminNotice()
    {
        $option  = get_option(self::NOTICE_FIELD);
        $message = isset($option['message']) ? $option['message'] : false;

        if (!$message)
        {
            return;
        }
        
        $noticeLevel = ! empty($option['notice-level']) ? $option['notice-level'] : 'notice-error';

        echo '<div class="notice ' . esc_attr($noticeLevel) . ' is-dismissible"><p>' . esc_html($message) . '</p></div>';
        delete_option(self::NOTICE_FIELD);
    }

    /**
     * Displays an error notice
     * 
     * @param   string  $message
     * 
     * @return  void
     */
    public static function displayError($message)
    {
        self::updateOption($message, 'notice-error');
    }

    /**
     * Displays a warning notice
     * 
     * @param   string  $message
     * 
     * @return  void
     */
    public static function displayWarning($message)
    {
        self::updateOption($message, 'notice-warning');
    }

    /**
     * Displays an info notice
     * 
     * @param   string  $message
     * 
     * @return  void
     */
    public static function displayInfo($message)
    {
        self::updateOption($message, 'notice-info');
    }

    /**
     * Displays a success notice
     * 
     * @param   string  $message
     * 
     * @return  void
     */
    public static function displaySuccess($message)
    {
        self::updateOption($message, 'notice-success');
    }

    /**
     * Updates the notice message and its type
     * 
     * @param   string  $message
     * @param   string  $noticeLevel
     * 
     * @return  void
     */
    protected static function updateOption($message, $noticeLevel)
    {
        update_option(self::NOTICE_FIELD, [
            'message' => $message,
            'notice-level' => $noticeLevel
        ]);
    }
}