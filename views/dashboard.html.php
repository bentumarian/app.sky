<?php $first = $user['first_name'] ?? 'colega'; ?>

<h1 class="page-title">Bună, <?php echo e( $first ); ?> 👋</h1>
<p class="page-subtitle">Acesta este dashboard-ul tău. Aici vezi toate datele importante de la platformă.</p>

<div class="stats-grid">

	<div class="stat-card gradient-cyan">
		<div class="stat-icon"><i class="ti ti-target-arrow"></i></div>
		<div class="stat-value"><?php echo (int) $stats['leads_new']; ?></div>
		<div class="stat-label">Leads noi</div>
		<div class="stat-trend">↑ Azi</div>
	</div>

	<div class="stat-card gradient-orange">
		<div class="stat-icon"><i class="ti ti-clock-hour-4"></i></div>
		<div class="stat-value"><?php echo (int) $stats['awaiting_pay']; ?></div>
		<div class="stat-label">Așteaptă plată</div>
		<div class="stat-trend"><?php echo fmt_money( $stats['awaiting_total'] ); ?></div>
	</div>

	<div class="stat-card gradient-blue">
		<div class="stat-icon"><i class="ti ti-building"></i></div>
		<div class="stat-value"><?php echo (int) $stats['active_clients']; ?></div>
		<div class="stat-label">Clienți activi</div>
		<div class="stat-trend"><?php echo (int) $stats['standards']; ?> standarde IMAB</div>
	</div>

	<div class="stat-card gradient-purple">
		<div class="stat-icon"><i class="ti ti-trending-up"></i></div>
		<div class="stat-value"><?php echo number_format( $stats['monthly_rev'], 0, ',', '.' ); ?></div>
		<div class="stat-label">Cifră luna asta (lei)</div>
		<div class="stat-trend">vs. luna trecută</div>
	</div>

</div>

<div class="card">
	<div class="card-header">
		<span class="card-title">Cereri recente</span>
		<a href="<?php echo e( url( '/leads' ) ); ?>" class="card-link">Vezi toate →</a>
	</div>

	<?php if ( empty( $recent_requests ) ) : ?>
		<div class="empty-state">
			<i class="ti ti-inbox"></i>
			<p>Nicio cerere încă. Vor apărea aici după ce construim modulul Leads.</p>
		</div>
	<?php else : ?>
		<table>
			<thead>
				<tr>
					<th>Firmă</th>
					<th>Standarde</th>
					<th class="r">Total</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $recent_requests as $r ) : ?>
					<tr>
						<td><?php echo e( $r['company'] ); ?></td>
						<td class="muted"><?php echo e( $r['standards'] ); ?></td>
						<td class="r"><?php echo fmt_money( $r['total'] ); ?></td>
						<td><span class="badge b-blue"><?php echo e( $r['status'] ); ?></span></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>

<div class="info-banner">
	<i class="ti ti-info-circle"></i>
	<div>
		<strong>PASUL 1 — schelet livrat.</strong> Vezi designul final al platformei (login + dashboard + sidebar grupat pe categorii + topbar cu căutare). Cifrele și tabelul de aici devin reale când construim modulele Leads și Clienți în PASUL 2.
	</div>
</div>
