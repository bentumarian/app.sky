<?php
/**
 * Modul: home (root URL) — redirect la /dashboard dacă logat, /login altfel
 */
redirect( auth_check() ? '/dashboard' : '/login' );
