<?php
/*
Copyright 2013 John Blackbourn

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

*/

class QM_Collector_Overview extends QM_Collector {

	public $id = 'overview';

	public function name() {
		return __( 'Overview', 'query-monitor' );
	}

	public function __construct() {
		parent::__construct();
	}

	public function process() {

		$this->data['time']       = QM_Util::timer_stop_float();
		$this->data['time_limit'] = ini_get( 'max_execution_time' );

		if ( !empty( $this->data['time_limit'] ) )
			$this->data['time_usage'] = ( 100 / $this->data['time_limit'] ) * $this->data['time'];
		else
			$this->data['time_usage'] = 0;

		if ( function_exists( 'memory_get_peak_usage' ) )
			$this->data['memory'] = memory_get_peak_usage();
		else
			$this->data['memory'] = memory_get_usage();

		$this->data['memory_limit'] = QM_Util::convert_hr_to_bytes( ini_get( 'memory_limit' ) );
		$this->data['memory_usage'] = ( 100 / $this->data['memory_limit'] ) * $this->data['memory'];

	}

}

function register_qm_collector_overview( array $qm ) {
	$qm['overview'] = new QM_Collector_Overview;
	return $qm;
}

add_filter( 'query_monitor_collectors', 'register_qm_collector_overview', 10 );
