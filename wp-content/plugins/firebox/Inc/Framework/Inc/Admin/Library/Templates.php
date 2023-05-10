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

namespace FPFramework\Admin\Library;

if (!defined('ABSPATH'))
{
	exit; // Exit if accessed directly.
}

trait Templates
{
	public function templates_init()
	{
		// Get Templates Layout AJAX
		add_action('wp_ajax_fpf_library_get_templates', [$this, 'fpf_library_get_templates']);
		
		// Refresh Templates from Remote and return Layout - AJAX
		add_action('wp_ajax_fpf_library_refresh_templates', [$this, 'fpf_library_refresh_templates']);
		
		// Insert template
		add_action('wp_ajax_fpf_library_insert_template', [$this, 'fpf_library_insert_template']);
	}

	/**
	 * Checks whether we have the template locally and retrives its layout.
	 * If no local template is found, then retrieves it from remote and returns its layout.
	 * 
	 * @return  string
	 */
	public function fpf_library_get_templates()
	{
		if (!current_user_can('manage_options'))
		{
			return false;
		}
		
		$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
		
        // verify nonce
        if (!$verify = wp_verify_nonce($nonce, 'fpf_js_nonce'))
        {
			return false;
		}

		$this->getTemplates($this->getList());
	}

	/**
	 * Returns all available templates.
	 * 
	 * @param   object  $templates
	 * 
	 * @return  void
	 */
	private function getTemplates($templates)
	{
		if (isset($templates->code) || \is_wp_error($templates))
		{
			echo json_encode($templates);
			wp_die();
		}

		$layout_payload = [
			'plugin' => $this->library_settings['plugin'],
			'plugin_name' => $this->library_settings['plugin_name'],
			'plugin_license_type' => $this->library_settings['plugin_license_type'],
			'plugin_version' => $this->library_settings['plugin_version'],
			'plugin_license_settings_url' => $this->library_settings['plugin_license_settings_url'],
			'template_use_url' => $this->library_settings['template_use_url'],
			'license_key' => $this->library_settings['license_key'],
			'license_key_status' => $this->library_settings['license_key_status'],
			'templates' => $templates->templates,
			'favorites' => $this->getFavorites()
		];

		$filters_payload = [
			'filters' => $this->getTemplatesFilters($templates->filters)
		];

		echo json_encode([
			'templates' => fpframework()->renderer->admin->render('library/items_list', $layout_payload, true),
			'filters' => fpframework()->renderer->admin->render('library/filters', $filters_payload, true)
		]);
		wp_die();
	}

	/**
	 * Returns the filters payload.
	 * 
	 * @param   object  $filters
	 * 
	 * @return  array
	 */
	private function getTemplatesFilters($filters)
	{
		// Main filters
		$data = [
			'category' => [
				'label' => isset($this->library_settings['main_category_label']) ? $this->library_settings['main_category_label'] : fpframework()->_('FPF_CATEGORIES'),
				'items' => isset($filters->categories) ? $filters->categories : [],
			],
			'solution' => [
				'label' => fpframework()->_('FPF_SOLUTIONS'),
				'items' => isset($filters->solutions) ? $filters->solutions : [],
			],
			'goal' => [
				'label' => fpframework()->_('FPF_GOAL'),
				'items' => isset($filters->goals) ? $filters->goals : [],
			]
		];

		// Add compatibility filter (Free/Pro filtering) only in the Lite version
		if ($this->library_settings['plugin_license_type'] === 'lite')
		{
			$data['compatibility'] = [
				'label' => fpframework()->_('FPF_COMPATIBILITY'),
				'items' => isset($filters->compatibility) ? $filters->compatibility : []
			];
		}

		return $data;
	}

	/**
	 * Retrieve remote templates, store them locally and return new layout.
	 * 
	 * @return  string
	 */
	public function fpf_library_refresh_templates()
	{
		if (!current_user_can('manage_options'))
		{
			return false;
		}
		
		$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
		
        // verify nonce
        if (!$verify = wp_verify_nonce($nonce, 'fpf_js_nonce'))
        {
			return false;
		}

		$this->getTemplates($this->getRemoteTemplatesAndStore());
	}

	/**
	 * Insert template.
	 * 
	 * @return  void
	 */
	public function fpf_library_insert_template()
	{
		if (!current_user_can('manage_options'))
		{
			return false;
		}
		
		$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
		
        // verify nonce
        if (!$verify = wp_verify_nonce($nonce, 'fpf_js_nonce'))
        {
			return false;
		}
		
		$template = isset($_POST['template']) ? sanitize_text_field($_POST['template']) : '';
		
		$license = get_option($this->library_settings['plugin'] . '_license_key');
		$site_url = preg_replace('(^https?://)', '', get_site_url());
		$site_url = preg_replace('(^www.)', '', $site_url);
        $site_url = rtrim($site_url, '/') . '/';
        
        // get remote templates
		$templates_url = str_replace('{{PLUGIN}}', $this->library_settings['plugin'], FPF_TEMPLATE_GET_URL);
		$templates_url = str_replace('{{TEMPLATE}}', $template, $templates_url);
		$templates_url = str_replace('{{LICENSE_KEY}}', $license, $templates_url);
		$templates_url = str_replace('{{SITE_URL}}', $site_url, $templates_url);

        $response = wp_remote_get($templates_url);

        if (!is_array($response) || \is_wp_error($response))
        {
			echo json_encode([
				'error' => true,
				'message' => 'Cannot insert template. Please try again.'
			]);
			wp_die();
        }
        else
        {
            $body = json_decode($response['body']);

            // an error has occurred
            if (isset($body->error))
            {
				echo json_encode([
					'error' => true,
					'message' => $body->message
				]);
				wp_die();
            }

			// Save template locally so we can fetch its contents on redirect
			file_put_contents($this->getTemplatesPath() . '/template.json', json_encode($body));
            
			echo json_encode([
				'error' => false,
				'message' => 'Inserting template.',
				'redirect' => $this->library_settings['template_use_url'] . $template
			]);
			wp_die();
        }
	}

    /**
     * Save templates locally
     * 
     * @param   array  $body
     * 
     * @return  void
     */
    private function saveLocalTemplate($body)
    {
        $path = $this->getTemplatesPath() . '/templates.json';
        
        file_put_contents($path, json_encode($body));
    }

    /**
     * Returns the local templates
     * 
     * @return  array
     */
	private function getLocalTemplates()
	{
        $path = $this->getTemplatesPath() . '/templates.json';

		if (!file_exists($path))
		{
			return false;
        }

		// If templates are old, fetch remote list
		if ($this->templatesRequireUpdate())
		{
			return false;
		}

		return json_decode(file_get_contents($path));
	}

	/**
	 * Checks whether the local templates list
	 * is older than 15 days.
	 * 
	 * @return  bool
	 */
	private function templatesRequireUpdate()
	{
        $path = $this->getTemplatesPath() . '/templates.json';

		$days_old = 15;

		/**
		 * If its older than 15 days, then request remote list
		 */
		// Get the modification time of the templates file
		$modTime = @filemtime($path);

		// Current time
		$now = time();

		// Minimum time difference
		$threshold = $days_old * 24 * 3600;

		// Do we need an update?
		return ($now - $modTime) >= $threshold;
	}

    /**
     * Returns the remote templates
     * 
     * @return  array
     */
	private function getRemoteTemplates()
	{
        $license = get_option($this->library_settings['plugin'] . '_license_key');
		$site_url = preg_replace('(^https?://)', '', get_site_url());
		$site_url = preg_replace('(^www.)', '', $site_url);
        $site_url = rtrim($site_url, '/') . '/';
        
        // get remote templates
		$templates_url = str_replace('{{PLUGIN}}', $this->library_settings['plugin'], FPF_TEMPLATES_GET_URL);
		$templates_url = str_replace('{{LICENSE_KEY}}', $license, $templates_url);
		$templates_url = str_replace('{{PLUGIN_VERSION}}', $this->library_settings['plugin_version'], $templates_url);
		$templates_url = str_replace('{{SITE_URL}}', $site_url, $templates_url);

        $response = wp_remote_get($templates_url);

        if (!is_array($response) || \is_wp_error($response))
        {
			// If the request timed out, then let plugin show a more helpful error message
			if (isset($response->errors) && array_key_exists('http_request_failed', $response->errors))
			{
				return false;
			}
			
			// Otherwise show error message from server
            return $response;
        }
        else
        {
            $body = json_decode($response['body']);

            // an error has occurred
            if (isset($body->error))
            {
                return $body->error;
            }
            
            return $body;
        }
    }
    
    /**
     * Gets the remote templates and stores them locally
     * 
     * @return  array
     */
    public function getRemoteTemplatesAndStore()
    {
        $templates = $this->getRemoteTemplates();

        if (!$templates)
        {
            return new \WP_Error('cannot_retrieve_templates', fpframework()->_('FPF_TEMPLATES_CANNOT_BE_RETRIEVED'));
        }

        // return errors
        if (isset($templates->errors) || isset($templates->code) || \is_wp_error($templates))
        {
            return $templates;
        }
        
        $this->saveLocalTemplate($templates);

        return $templates;
    }

    /**
     * Get templates list
     * 
     * @return  array
     */
    public function getList()
    {
		// try to find local templates with fallback remote templates
        return $this->getLocalTemplates() ?: $this->getRemoteTemplatesAndStore();
    }
}