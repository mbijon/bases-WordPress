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

class QM_Collector_Request extends QM_Collector {

	public $id = 'request';

	public function __construct() {
		parent::__construct();
	}

	public function name() {
		return __( 'Request', 'query-monitor' );
	}

	public function process() {

		global $wp, $wp_query;

		$qo = get_queried_object();

		if ( is_admin() ) {
			$this->data['request']['request'] = $_SERVER['REQUEST_URI'];
			foreach ( array( 'query_string' ) as $item ) {
				$this->data['request'][$item] = $wp->$item;
			}
		} else {
			foreach ( array( 'request', 'matched_rule', 'matched_query', 'query_string' ) as $item ) {
				$this->data['request'][$item] = $wp->$item;
			}
		}

		$plugin_qvars = array_flip( apply_filters( 'query_vars', array() ) );
		$qvars        = $wp_query->query_vars;
		$query_vars   = array();

		foreach ( $qvars as $k => $v ) {
			if ( isset( $plugin_qvars[$k] ) ) {
				if ( '' !== $v )
					$query_vars[$k] = $v;
			} else {
				if ( !empty( $v ) )
					$query_vars[$k] = $v;
			}
		}

		ksort( $query_vars );

		# First add plugin vars to $this->data['qvars']:
		foreach ( $query_vars as $k => $v ) {
			if ( isset( $plugin_qvars[$k] ) ) {
				$this->data['qvars'][$k] = $v;
				$this->data['plugin_qvars'][$k] = $v;
			}
		}

		# Now add all other vars to $this->data['qvars']:
		foreach ( $query_vars as $k => $v ) {
			if ( !isset( $plugin_qvars[$k] ) )
				$this->data['qvars'][$k] = $v;
		}

		switch ( true ) {

			case is_null( $qo ):
				// Nada
				break;

			case is_a( $qo, 'WP_Post' ):
				// Single post
				$this->data['queried_object_type']  = 'post';
				$this->data['queried_object_name']  = get_post_type_object( $qo->post_type )->labels->singular_name;
				$this->data['queried_object_id']    = $qo->ID;
				break;

			case is_a( $qo, 'WP_User' ):
				// Author archive
				$this->data['queried_object_type']  = 'user';
				$this->data['queried_object_name']  = __( 'User', 'query-monitor' );
				$this->data['queried_object_id']    = $qo->ID;
				break;

			case property_exists( $qo, 'term_id' ):
				// Term archive
				$this->data['queried_object_type']  = 'term';
				$this->data['queried_object_name']  = get_taxonomy( $qo->taxonomy )->labels->singular_name;
				$this->data['queried_object_id']    = $qo->term_id;
				break;

			case property_exists( $qo, 'has_archive' ):
				// Post type archive
				$this->data['queried_object_type']  = 'archive';
				$this->data['queried_object_name']  = $qo->labels->singular_name;
				$this->data['queried_object_id']    = $qo->name;
				break;

		}

		$this->data['queried_object'] = $qo;

	}

}

function register_qm_collector_request( array $qm ) {
	$qm['request'] = new QM_Collector_Request;
	return $qm;
}

add_filter( 'query_monitor_collectors', 'register_qm_collector_request', 60 );
