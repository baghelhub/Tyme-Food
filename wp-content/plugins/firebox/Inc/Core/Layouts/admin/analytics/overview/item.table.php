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

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}
$item = new \FPFramework\Libs\Registry($this->data);

$table_columns = (array) $item->get('table_columns', []);

$current_data = (array) $item->get('current_period.data', []);
$last_period_data = (array) $item->get('last_period.data', []);
?>
<table class="table table-header-fixed cols-<?php echo esc_attr(count($table_columns)); ?>">
    <thead>
        <?php
        foreach ($table_columns as $key => $value)
        {
            $title = isset($value['title']) ? $value['title'] : '';
            ?>
            <th<?php echo ($title) ? ' title="' . esc_attr($title) . '"' : ''; ?>><?php echo esc_html($value['label']); ?></th>
            <?php
        }
        ?>
    </thead>
    <tbody>
        <?php
        if (count($current_data))
        {
            $allowed_tags = [
                'a' => [
                    'href' => true
                ],
                'span' => [
                    'class' => true
                ]
            ];
            
            foreach ($current_data as $key => $value)
            {
                $value = (array) $value;
                ?>
                <tr>
                <?php
                foreach ($value as $_key => $_value)
                {
                    if (is_object($_value) || is_array($_value))
                    {
                        $_value = (array) $_value;
                    }

                    $col_label = isset($_value['label']) ? $_value['label'] : (!is_array($_value) ? $_value : '');
                    $col_link = isset($_value['link']) ? $_value['link'] : '';
                    $col_class = isset($_value['class']) ? $_value['class'] : '';
                    
                    $link_start = $col_link ? '<a href="' . esc_url($col_link) . '">' : '';
                    $link_end = $col_link ? '</a>' : '';
                    ?>
                    <td<?php echo !empty($col_class) ? ' class="' . esc_attr($col_class) . '"' : ''; ?>><?php echo ($link_start ? wp_kses($link_start, $allowed_tags) : '') . ($col_label ? wp_kses($col_label, $allowed_tags) : '-') . ($link_end ? wp_kses($link_end, $allowed_tags) : ''); ?></td>
                    <?php
                }
                ?>
                </tr>
                <?php
            }
        }
        else
        {
            ?><tr class="empty"><td colspan="<?php echo esc_attr(count($table_columns)); ?>"><?php echo esc_html(fpframework()->_('FPF_ANALYTICS_TABLE_NO_DATA_TO_DISPLAY')); ?></td></tr><?php
        }
        ?>
    </tbody>
</table>