<!doctype html>
<html lang="ro">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Intră în cont · SkyCert Platform</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/2.40.0/iconfont/tabler-icons.min.css">
	<style>
		*,*::before,*::after { box-sizing: border-box; margin: 0; padding: 0; }
		html, body { height: 100%; }
		body {
			font-family: -apple-system, BlinkMacSystemFont, "Inter", "Segoe UI", Roboto, sans-serif;
			background: #0B1426;
			color: #E2E8F0;
			min-height: 100vh;
			display: flex; align-items: center; justify-content: center;
			padding: 20px;
			position: relative;
			overflow: hidden;
		}
		/* Background glow effect */
		body::before {
			content: '';
			position: absolute;
			top: -200px; left: -200px;
			width: 600px; height: 600px;
			background: radial-gradient(circle, rgba(26,180,229,0.15) 0%, transparent 70%);
			pointer-events: none;
		}
		body::after {
			content: '';
			position: absolute;
			bottom: -200px; right: -200px;
			width: 600px; height: 600px;
			background: radial-gradient(circle, rgba(37,99,235,0.12) 0%, transparent 70%);
			pointer-events: none;
		}

		.card {
			background: linear-gradient(180deg, #131D36 0%, #111A30 100%);
			border: 1px solid rgba(148,163,184,0.1);
			border-radius: 18px;
			padding: 44px 40px;
			width: 100%;
			max-width: 400px;
			position: relative;
			z-index: 1;
			box-shadow: 0 20px 60px rgba(0,0,0,0.4);
		}

		.brand {
			display: flex; flex-direction: column; align-items: center;
			margin-bottom: 28px;
		}
		.brand-mark {
			width: 56px; height: 56px;
			background: linear-gradient(135deg, #1AB4E5, #2563EB);
			border-radius: 14px;
			display: flex; align-items: center; justify-content: center;
			font-weight: 700; font-style: italic;
			color: #fff; font-size: 28px;
			box-shadow: 0 8px 24px rgba(26,180,229,0.3);
			margin-bottom: 14px;
		}
		.brand-text {
			font-weight: 600; font-style: italic; font-size: 26px;
			letter-spacing: -1px;
		}
		.brand-text .sky  { color: #1AB4E5; }
		.brand-text .cert { color: #fff; }

		h1 {
			text-align: center;
			font-size: 22px;
			font-weight: 700;
			color: #fff;
			margin-bottom: 6px;
		}
		.subtitle {
			text-align: center;
			font-size: 14px;
			color: #94A3B8;
			margin-bottom: 28px;
		}

		.error {
			background: rgba(239,68,68,0.1);
			border: 1px solid rgba(239,68,68,0.3);
			color: #FCA5A5;
			padding: 12px 16px;
			border-radius: 8px;
			font-size: 13px;
			margin-bottom: 20px;
			display: flex; align-items: center; gap: 10px;
		}
		.error i { font-size: 18px; }

		.field { margin-bottom: 16px; }
		.field label {
			display: block;
			font-size: 11px;
			color: #94A3B8;
			margin-bottom: 8px;
			letter-spacing: 0.5px;
			font-weight: 600;
			text-transform: uppercase;
		}
		.field input {
			width: 100%;
			background: rgba(15,24,48,0.6);
			border: 1px solid rgba(148,163,184,0.15);
			color: #E2E8F0;
			padding: 12px 14px;
			border-radius: 8px;
			font-size: 14px;
			font-family: inherit;
			transition: all .15s;
		}
		.field input::placeholder { color: #64748B; }
		.field input:focus {
			outline: none;
			border-color: rgba(26,180,229,0.5);
			background: rgba(15,24,48,0.9);
			box-shadow: 0 0 0 3px rgba(26,180,229,0.1);
		}

		.row-remember {
			display: flex; align-items: center; gap: 10px;
			margin-bottom: 22px;
			font-size: 13px;
			color: #94A3B8;
			cursor: pointer;
		}
		.row-remember input {
			width: 16px; height: 16px;
			accent-color: #1AB4E5;
			cursor: pointer;
		}

		.btn-primary {
			width: 100%;
			padding: 13px;
			background: linear-gradient(135deg, #1AB4E5, #2563EB);
			color: #fff;
			border: none;
			border-radius: 8px;
			font-size: 14px;
			font-weight: 600;
			cursor: pointer;
			transition: all .15s;
			box-shadow: 0 4px 14px rgba(26,180,229,0.25);
			display: flex; align-items: center; justify-content: center; gap: 8px;
		}
		.btn-primary:hover {
			transform: translateY(-1px);
			box-shadow: 0 6px 20px rgba(26,180,229,0.4);
		}
		.btn-primary i { font-size: 16px; }

		.forgot {
			text-align: center;
			margin: 18px 0 0;
			font-size: 13px;
			color: #94A3B8;
		}
		.forgot a { color: #1AB4E5; font-weight: 500; }
		.forgot a:hover { text-decoration: underline; }

		.footer {
			text-align: center;
			margin-top: 28px;
			padding-top: 20px;
			border-top: 1px solid rgba(148,163,184,0.08);
			font-size: 11px;
			color: #64748B;
		}
		.footer strong { color: #94A3B8; }
	</style>
</head>
<body>

<div class="card">
	<div class="brand">
		<div class="brand-mark">s</div>
		<div class="brand-text"><span class="sky">sky</span><span class="cert">CERT</span></div>
	</div>

	<h1>Bună, bine ai revenit</h1>
	<p class="subtitle">Intră în platforma SkyCert ca să gestionezi cererile și certificatele.</p>

	<?php if ( ! empty( $error ) ) : ?>
		<div class="error">
			<i class="ti ti-alert-circle"></i>
			<span><?php echo e( $error ); ?></span>
		</div>
	<?php endif; ?>

	<form method="post" autocomplete="on" novalidate>
		<input type="hidden" name="_csrf" value="<?php echo e( csrf_token() ); ?>">
		<input type="hidden" name="next" value="<?php echo e( $next ); ?>">

		<div class="field">
			<label>Email</label>
			<input type="email" name="email" value="<?php echo e( $email ); ?>" required autofocus autocomplete="username" placeholder="bentumarian@gmail.com">
		</div>

		<div class="field">
			<label>Parolă</label>
			<input type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
		</div>

		<label class="row-remember">
			<input type="checkbox" name="remember" value="1" checked>
			<span>Ține-mă logat</span>
		</label>

		<button type="submit" class="btn-primary">
			Intră în SkyCert
			<i class="ti ti-arrow-right"></i>
		</button>
	</form>

	<p class="forgot">
		<a href="#">Ai uitat parola?</a>
	</p>

	<p class="footer">
		<strong><?php echo e( $CONFIG['app']['company'] ); ?></strong><br>
		Acreditat <?php echo e( $CONFIG['accreditation']['short'] ); ?> · <?php echo e( $CONFIG['accreditation']['annexure'] ); ?>
	</p>
</div>

</body>
</html>
