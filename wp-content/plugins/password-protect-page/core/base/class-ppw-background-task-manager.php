<?php
/**
 * Created by PhpStorm.
 * User: gaupoit
 * Date: 7/25/19
 * Time: 11:33
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class PPW_Background_Task_Manager extends PPW_Module {

	/**
	 * @var Background_Task
	 */
	protected $task_runner;

	abstract public function get_action();
	abstract public function get_plugin_name();
	abstract public function get_plugin_label();
	abstract public function get_task_runner_class();
	abstract public function get_query_limit();

	abstract protected function start_run();

	public function __construct() {
		if ( empty( $_GET[ $this->get_action() ] ) ) {
			return;
		}

		if ( 'run' === $_GET[ $this->get_action() ] && check_admin_referer( $this->get_action() . 'run' ) ) {
			$this->start_run();
		}

		if ( 'continue' === $_GET[ $this->get_action() ] && check_admin_referer( $this->get_action() . 'continue' ) ) {
			$this->continue_run();
		}

		wp_safe_redirect(
			remove_query_arg(
				array(
					$this->get_action(),
					'_wpnonce',
				)
			)
		);
		die;
	}

	public function on_runner_start() {
		// Implement logger here
	}

	public function on_runner_complete( $did_tasks = false ) {
		// Implement logger here
		$this->add_flag( 'completed' );

	}

	public function get_task_runner() {
		if ( empty( $this->task_runner ) ) {
			$class_name = $this->get_task_runner_class();
			$this->task_runner = new $class_name( $this );
		}

		return $this->task_runner;
	}

	protected function add_flag( $flag ) {
		update_option( $this->get_plugin_name() . '_' . $this->get_action() . '_' . $flag, 1 );
	}

	protected function get_flag( $flag ) {
		return get_option( $this->get_plugin_name() . '_' . $this->get_action() . '_' . $flag );
	}

	protected function delete_flag( $flag ) {
		delete_option( $this->get_plugin_name() . '_' . $this->get_action() . '_' . $flag );
	}

	protected function get_start_action_url() {
		return wp_nonce_url( add_query_arg( $this->get_action(), 'run' ), $this->get_action() . 'run' );
	}

	protected function get_continue_action_url() {
		return wp_nonce_url( add_query_arg( $this->get_action(), 'continue' ), $this->get_action() . 'continue' );
	}

	private function continue_run() {
		$runner = $this->get_task_runner();
		$runner->continue_run();
	}
}
