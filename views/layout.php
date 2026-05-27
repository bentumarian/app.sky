<?php
// Modulele organizate pe categorii pentru sidebar
$nav_sections = [
	'OPERAȚIONAL' => [
		'dashboard' => [ 'label' => 'Dashboard',  'icon' => 'ti-layout-dashboard', 'url' => '/dashboard' ],
		'leads'     => [ 'label' => 'Leads',      'icon' => 'ti-target-arrow',     'url' => '/leads',     'badge' => 0 ],
		'clients'   => [ 'label' => 'Clienți',    'icon' => 'ti-building',         'url' => '/clients' ],
		'documents' => [ 'label' => 'Documente',  'icon' => 'ti-file-certificate', 'url' => '/documents' ],
	],
	'FINANCIAR' => [
		'invoicing' => [ 'label' => 'Facturare',  'icon' => 'ti-receipt-2',        'url' => '/invoicing' ],
		'payments'  => [ 'label' => 'Încasări',   'icon' => 'ti-cash-banknote',    'url' => '/payments' ],
	],
	'AUTOMATIZARE' => [
		'reminders' => [ 'label' => 'Reminders',  'icon' => 'ti-bell-ringing',     'url' => '/reminders' ],
		'reports'   => [ 'label' => 'Rapoarte',   'icon' => 'ti-chart-histogram',  'url' => '/reports' ],
	],
];
?><!doctype html>
<html lang="ro">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo e( $page_title ?? 'SkyCert' ); ?> · SkyCert Platform</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.40.0/iconfont/tabler-icons.min.css">
	<style>
		*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
		html, body { height: 100%; }
		body {
			font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
			background: #0B1426;
			color: #E2E8F0;
			font-size: 14px;
			line-height: 1.5;
			-webkit-font-smoothing: antialiased;
		}
		a { color: inherit; text-decoration: none; }
		button { font-family: inherit; cursor: pointer; }

		/* ============== APP LAYOUT ============== */
		.app { display: grid; grid-template-columns: 260px 1fr; min-height: 100vh; }

		/* ============== SIDEBAR ============== */
		.sidebar {
			background: linear-gradient(180deg, #131D36 0%, #0F1830 100%);
			border-right: 1px solid rgba(148,163,184,0.08);
			padding: 20px 14px;
			display: flex; flex-direction: column;
			position: sticky; top: 0; height: 100vh;
		}
		.brand {
			padding: 6px 10px 22px;
			border-bottom: 1px solid rgba(148,163,184,0.08);
			margin-bottom: 16px;
			display: flex; align-items: center; gap: 10px;
		}
		.brand-mark {
			width: 36px; height: 36px;
			background: linear-gradient(135deg, #1AB4E5, #2563EB);
			border-radius: 9px;
			display: flex; align-items: center; justify-content: center;
			font-weight: 700; font-style: italic;
			color: #fff; font-size: 18px;
			box-shadow: 0 4px 12px rgba(26,180,229,0.25);
		}
		.brand-text {
			font-weight: 600; font-style: italic; font-size: 20px;
			letter-spacing: -0.5px;
		}
		.brand-text .sky  { color: #1AB4E5; }
		.brand-text .cert { color: #fff; }

		.nav-section { margin-bottom: 18px; }
		.nav-section-title {
			color: #64748B;
			font-size: 10px;
			font-weight: 600;
			letter-spacing: 1px;
			padding: 0 12px;
			margin-bottom: 6px;
		}
		.nav-item {
			display: flex; align-items: center; gap: 12px;
			padding: 9px 12px;
			color: #94A3B8;
			border-radius: 8px;
			font-size: 13px;
			font-weight: 500;
			transition: all .15s;
			margin-bottom: 2px;
		}
		.nav-item:hover { background: rgba(148,163,184,0.06); color: #E2E8F0; }
		.nav-item.active {
			background: linear-gradient(90deg, rgba(26,180,229,0.15), rgba(37,99,235,0.08));
			color: #1AB4E5;
			box-shadow: inset 2px 0 0 #1AB4E5;
		}
		.nav-item i { font-size: 18px; flex-shrink: 0; }
		.nav-badge {
			margin-left: auto;
			background: #1AB4E5; color: #fff;
			font-size: 10px; font-weight: 700;
			padding: 1px 7px; border-radius: 10px;
			min-width: 18px; text-align: center;
		}

		.sidebar-footer {
			margin-top: auto;
			padding-top: 14px;
			border-top: 1px solid rgba(148,163,184,0.08);
		}

		/* ============== MAIN AREA ============== */
		.main { display: flex; flex-direction: column; min-width: 0; }

		/* ============== TOPBAR ============== */
		.topbar {
			background: rgba(15,24,48,0.6);
			backdrop-filter: blur(8px);
			-webkit-backdrop-filter: blur(8px);
			border-bottom: 1px solid rgba(148,163,184,0.08);
			padding: 14px 28px;
			display: flex; align-items: center; gap: 24px;
			position: sticky; top: 0; z-index: 50;
		}
		.topbar h1 { font-size: 18px; font-weight: 600; color: #fff; flex-shrink: 0; }
		.search-box { flex: 1; max-width: 360px; position: relative; }
		.search-box i {
			position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
			color: #64748B; font-size: 16px;
		}
		.search-box input {
			width: 100%;
			background: rgba(15,24,48,0.8);
			border: 1px solid rgba(148,163,184,0.12);
			color: #E2E8F0;
			padding: 9px 14px 9px 42px;
			border-radius: 8px;
			font-size: 13px;
			font-family: inherit;
		}
		.search-box input::placeholder { color: #64748B; }
		.search-box input:focus { outline: none; border-color: rgba(26,180,229,0.5); }

		.topbar-actions { margin-left: auto; display: flex; align-items: center; gap: 8px; }
		.icon-btn {
			width: 36px; height: 36px;
			border-radius: 8px;
			border: 1px solid rgba(148,163,184,0.12);
			background: rgba(15,24,48,0.6);
			color: #94A3B8;
			display: flex; align-items: center; justify-content: center;
			font-size: 16px;
			transition: all .15s;
			position: relative;
		}
		.icon-btn:hover { background: rgba(26,180,229,0.1); color: #1AB4E5; border-color: rgba(26,180,229,0.3); }
		.icon-btn .dot {
			position: absolute; top: 7px; right: 7px;
			width: 7px; height: 7px;
			background: #EF4444; border-radius: 50%;
			border: 2px solid #0B1426;
		}

		.user-chip {
			display: flex; align-items: center; gap: 10px;
			padding: 5px 12px 5px 5px;
			border: 1px solid rgba(148,163,184,0.12);
			border-radius: 8px;
			background: rgba(15,24,48,0.6);
			position: relative;
		}
		.user-chip:hover { background: rgba(26,180,229,0.06); }
		.avatar {
			width: 28px; height: 28px;
			border-radius: 50%;
			background: linear-gradient(135deg, #1AB4E5, #2563EB);
			color: #fff;
			display: flex; align-items: center; justify-content: center;
			font-size: 11px; font-weight: 700;
		}
		.user-name { font-size: 13px; color: #E2E8F0; font-weight: 500; }
		.user-chip i.chevron { font-size: 14px; color: #64748B; }

		.dropdown {
			position: absolute; top: calc(100% + 8px); right: 0;
			background: #131D36;
			border: 1px solid rgba(148,163,184,0.1);
			border-radius: 10px;
			padding: 6px;
			min-width: 200px;
			box-shadow: 0 8px 24px rgba(0,0,0,0.4);
			display: none;
			z-index: 100;
		}
		.dropdown.open { display: block; }
		.dropdown-item {
			display: flex; align-items: center; gap: 10px;
			padding: 10px 12px;
			color: #E2E8F0;
			font-size: 13px;
			border-radius: 6px;
		}
		.dropdown-item:hover { background: rgba(148,163,184,0.08); }
		.dropdown-item i { font-size: 16px; color: #94A3B8; }
		.dropdown-divider { border-top: 1px solid rgba(148,163,184,0.08); margin: 4px 0; }
		.dropdown-item.danger { color: #FCA5A5; }
		.dropdown-item.danger i { color: #EF4444; }

		/* ============== CONTENT ============== */
		.content { padding: 28px; flex: 1; min-width: 0; }
		.page-title { font-size: 24px; font-weight: 700; color: #fff; margin-bottom: 4px; }
		.page-subtitle { font-size: 14px; color: #94A3B8; margin-bottom: 28px; }

		/* ============== STAT CARDS ============== */
		.stats-grid {
			display: grid;
			grid-template-columns: repeat(4, 1fr);
			gap: 16px;
			margin-bottom: 24px;
		}
		.stat-card {
			position: relative;
			padding: 22px;
			border-radius: 14px;
			overflow: hidden;
			border: 1px solid rgba(148,163,184,0.1);
		}
		.stat-card.gradient-cyan   { background: linear-gradient(135deg, #0E7490, #06B6D4); }
		.stat-card.gradient-blue   { background: linear-gradient(135deg, #1E3A8A, #3B82F6); }
		.stat-card.gradient-purple { background: linear-gradient(135deg, #5B21B6, #8B5CF6); }
		.stat-card.gradient-orange { background: linear-gradient(135deg, #C2410C, #F97316); }
		.stat-icon {
			width: 44px; height: 44px;
			background: rgba(255,255,255,0.15);
			border-radius: 10px;
			display: flex; align-items: center; justify-content: center;
			font-size: 22px;
			color: #fff;
			margin-bottom: 14px;
		}
		.stat-value { font-size: 28px; font-weight: 700; color: #fff; line-height: 1; margin-bottom: 4px; }
		.stat-label { font-size: 12px; color: rgba(255,255,255,0.85); font-weight: 500; }
		.stat-trend { font-size: 11px; color: rgba(255,255,255,0.7); margin-top: 8px; }

		/* ============== TABLE / CARD ============== */
		.card {
			background: linear-gradient(180deg, #131D36 0%, #111A30 100%);
			border: 1px solid rgba(148,163,184,0.08);
			border-radius: 12px;
			overflow: hidden;
		}
		.card-header {
			display: flex; justify-content: space-between; align-items: center;
			padding: 16px 20px;
			border-bottom: 1px solid rgba(148,163,184,0.08);
		}
		.card-title { font-size: 15px; font-weight: 600; color: #fff; }
		.card-link { font-size: 12px; color: #1AB4E5; }
		.card-link:hover { text-decoration: underline; }

		table { width: 100%; border-collapse: collapse; }
		thead th {
			text-align: left;
			padding: 10px 20px;
			background: rgba(15,24,48,0.5);
			font-size: 10px;
			font-weight: 600;
			letter-spacing: 1px;
			color: #64748B;
			text-transform: uppercase;
			border-bottom: 1px solid rgba(148,163,184,0.08);
		}
		tbody td {
			padding: 14px 20px;
			color: #E2E8F0;
			font-size: 13px;
			border-bottom: 1px solid rgba(148,163,184,0.05);
		}
		tbody tr:last-child td { border-bottom: none; }
		tbody tr:hover { background: rgba(148,163,184,0.03); }
		td.muted { color: #94A3B8; }
		td.r, th.r { text-align: right; }

		.badge {
			display: inline-block;
			padding: 3px 10px;
			border-radius: 12px;
			font-size: 11px;
			font-weight: 600;
		}
		.badge.b-yellow { background: rgba(245,158,11,0.15); color: #FCD34D; }
		.badge.b-green  { background: rgba(16,185,129,0.15); color: #6EE7B7; }
		.badge.b-blue   { background: rgba(59,130,246,0.15); color: #93C5FD; }
		.badge.b-purple { background: rgba(139,92,246,0.15); color: #C4B5FD; }
		.badge.b-cyan   { background: rgba(6,182,212,0.15);  color: #67E8F9; }

		.empty-state { padding: 60px 24px; text-align: center; color: #64748B; }
		.empty-state i { font-size: 48px; color: #334155; display: block; margin-bottom: 12px; }
		.empty-state p { font-size: 13px; }

		.info-banner {
			margin-top: 20px;
			padding: 14px 18px;
			background: rgba(26,180,229,0.08);
			border: 1px solid rgba(26,180,229,0.2);
			border-radius: 10px;
			color: #94A3B8;
			font-size: 13px;
			display: flex; align-items: flex-start; gap: 12px;
		}
		.info-banner i { color: #1AB4E5; font-size: 18px; flex-shrink: 0; margin-top: 1px; }
		.info-banner strong { color: #E2E8F0; }

		.placeholder-screen {
			text-align: center;
			padding: 80px 28px;
			background: linear-gradient(180deg, #131D36 0%, #111A30 100%);
			border: 1px solid rgba(148,163,184,0.08);
			border-radius: 14px;
		}
		.placeholder-icon {
			width: 80px; height: 80px;
			background: linear-gradient(135deg, rgba(26,180,229,0.2), rgba(37,99,235,0.1));
			border-radius: 20px;
			margin: 0 auto 20px;
			display: flex; align-items: center; justify-content: center;
		}
		.placeholder-icon i { font-size: 38px; color: #1AB4E5; }
		.placeholder-screen h2 { font-size: 22px; color: #fff; margin-bottom: 10px; font-weight: 600; }
		.placeholder-screen p { font-size: 14px; color: #94A3B8; max-width: 460px; margin: 0 auto 8px; }
		.placeholder-screen code {
			background: rgba(15,24,48,0.6);
			padding: 2px 8px;
			border-radius: 4px;
			font-size: 12px;
			color: #67E8F9;
			border: 1px solid rgba(148,163,184,0.1);
		}
		.placeholder-screen .placeholder-note {
			display: inline-block;
			margin-top: 18px;
			padding: 10px 16px;
			background: rgba(15,24,48,0.4);
			border-radius: 8px;
			font-size: 12px;
		}

		/* Responsive */
		@media (max-width: 900px) {
			.app { grid-template-columns: 72px 1fr; }
			.brand-text, .nav-section-title, .nav-item span:not(.nav-badge), .user-name { display: none; }
			.nav-item { justify-content: center; }
			.brand { justify-content: center; padding: 6px 0 22px; }
			.search-box { display: none; }
			.stats-grid { grid-template-columns: repeat(2, 1fr); }
		}
		@media (max-width: 600px) {
			.stats-grid { grid-template-columns: 1fr; }
			.content { padding: 18px; }
		}
	</style>
</head>
<body>
<div class="app">

	<aside class="sidebar">
		<a href="<?php echo e( url( '/dashboard' ) ); ?>" class="brand">
			<div class="brand-mark">s</div>
			<div class="brand-text"><span class="sky">sky</span><span class="cert">CERT</span></div>
		</a>

		<?php foreach ( $nav_sections as $section_title => $items ) : ?>
			<div class="nav-section">
				<div class="nav-section-title"><?php echo e( $section_title ); ?></div>
				<?php foreach ( $items as $key => $mod ) : ?>
					<a href="<?php echo e( url( $mod['url'] ) ); ?>" class="nav-item <?php echo ( ( $current_route ?? '' ) === $key ) ? 'active' : ''; ?>">
						<i class="ti <?php echo e( $mod['icon'] ); ?>"></i>
						<span><?php echo e( $mod['label'] ); ?></span>
						<?php if ( ! empty( $mod['badge'] ) ) : ?>
							<span class="nav-badge"><?php echo (int) $mod['badge']; ?></span>
						<?php endif; ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endforeach; ?>

		<div class="sidebar-footer">
			<a href="<?php echo e( url( '/settings' ) ); ?>" class="nav-item <?php echo ( ( $current_route ?? '' ) === 'settings' ) ? 'active' : ''; ?>">
				<i class="ti ti-settings"></i>
				<span>Setări</span>
			</a>
		</div>
	</aside>

	<div class="main">

		<header class="topbar">
			<h1><?php echo e( $page_title ?? '' ); ?></h1>

			<div class="search-box">
				<i class="ti ti-search"></i>
				<input type="text" placeholder="Caută clienți, cereri, certificate..." />
			</div>

			<div class="topbar-actions">
				<button class="icon-btn" title="Notificări">
					<i class="ti ti-bell"></i>
					<span class="dot"></span>
				</button>
				<div class="user-chip" id="userChip">
					<div class="avatar"><?php echo e( user_initials( $user ?? [] ) ); ?></div>
					<span class="user-name"><?php echo e( $user['first_name'] ?? '' ); ?></span>
					<i class="ti ti-chevron-down chevron"></i>
					<div class="dropdown" id="userDropdown">
						<a href="<?php echo e( url( '/settings' ) ); ?>" class="dropdown-item">
							<i class="ti ti-user"></i> Profilul meu
						</a>
						<a href="<?php echo e( url( '/settings' ) ); ?>" class="dropdown-item">
							<i class="ti ti-settings"></i> Setări platformă
						</a>
						<div class="dropdown-divider"></div>
						<a href="<?php echo e( url( '/logout' ) ); ?>" class="dropdown-item danger">
							<i class="ti ti-logout"></i> Ieșire
						</a>
					</div>
				</div>
			</div>
		</header>

		<main class="content">
			<?php echo $content; ?>
		</main>

	</div>

</div>

<script>
(function(){
	var chip = document.getElementById('userChip');
	var dd = document.getElementById('userDropdown');
	if (chip && dd) {
		document.addEventListener('click', function (e) {
			if (chip.contains(e.target) && !dd.contains(e.target)) {
				dd.classList.toggle('open');
			} else if (!dd.contains(e.target)) {
				dd.classList.remove('open');
			}
		});
	}
})();
</script>
</body>
</html>
