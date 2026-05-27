<?php
/**
 * Modul: dashboard
 *
 * Pentru PASUL 1 datele sunt demo (vor deveni reale când construim modulele Leads + Clients).
 */

$current_route = 'dashboard';
$page_title    = 'Dashboard';

// Date demo (vor fi înlocuite cu queries reale în pașii următori)
$stats = [
	'leads_new'      => 0,
	'awaiting_pay'   => 0,
	'awaiting_total' => 0.00,
	'active_clients' => 0,
	'standards'      => 9,
	'monthly_rev'    => 0.00,
];

$recent_requests = [];  // gol — apar când avem cereri reale

view( 'dashboard', [
	'page_title'      => $page_title,
	'current_route'   => $current_route,
	'stats'           => $stats,
	'recent_requests' => $recent_requests,
] );
