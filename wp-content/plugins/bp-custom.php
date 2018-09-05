<?php


//function jturet_group_front_template( $context = ''  ) {

//if ( empty( $context ) ) {
//		return array();
//	}
//
//	$action = '';
//	if ( 'user' === $context ) {
//		$action = 'bp_member_group_order_options';
//	} elseif ( 'directory' === $context ) {
//		$action = 'bp_groups_directory_order_options';
//	}
//
//	/**
//	 * Recommended, filter here instead of adding an action to 'bp_member_group_order_options'
//	 * or 'bp_groups_directory_order_options'
//	 *
//	 * @since 3.0.0
//	 *
//	 * @param array  the members filters.
//	 * @param string the context.
//	 */
//	$filters = apply_filters( 'bp_nouveau_get_groups_filters', array(
//		'active'       => __( 'Last Active', 'buddypress' ),
//		'popular'      => __( 'Most Members', 'buddypress' ),
//		'newest'       => __( 'Newly Created', 'buddypress' ),
//		'alphabetical' => __( 'Alphabetical', 'buddypress' ),
//	), $context );
//
//	if ( $action ) {
//		return bp_nouveau_parse_hooked_options( $action, $filters );
//	}
//
//	return $filters;
//
//}
//add_filter( 'bp_nouveau_get_groups_filters', 'jturet_group_front_template' );

//function bp_nouveau_get_groups_filters( $context = '' ) {
//	if ( empty( $context ) ) {
//		return array();
//	}
//
//	$action = '';
//	if ( 'user' === $context ) {
//		$action = 'bp_member_group_order_options';
//	} elseif ( 'directory' === $context ) {
//		$action = 'bp_groups_directory_order_options';
//	}
//
//	/**
//	 * Recommended, filter here instead of adding an action to 'bp_member_group_order_options'
//	 * or 'bp_groups_directory_order_options'
//	 *
//	 * @since 3.0.0
//	 *
//	 * @param array  the members filters.
//	 * @param string the context.
//	 */
//	$filters = apply_filters( 'bp_nouveau_get_groups_filters', array(
//		'active'       => __( 'Last Active', 'buddypress' ),
//		'popular'      => __( 'Most Members', 'buddypress' ),
//		'newest'       => __( 'Newly Created', 'buddypress' ),
//		'alphabetical' => __( 'Alphabetical', 'buddypress' ),
//	), $context );
//
//	if ( $action ) {
//		return bp_nouveau_parse_hooked_options( $action, $filters );
//	}
//
//	return $filters;
//}
    ?>