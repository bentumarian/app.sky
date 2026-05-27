# SkyCert Platform — Instalare PASUL 1

## Pași

### 1. Curăță complet `app.skycert.ro/` pe server
File Manager Romarg → folderul `app.skycert.ro/` → Select All → Delete. Trebuie să fie gol.

### 2. Creează baza de date MySQL
cPanel → MySQL Databases:
- **Create New Database**: ex `r112945skyc_skycert`
- **Add New User**: ex `r112945skyc_skycert` cu o parolă tare
- **Add User To Database**: bifează ALL PRIVILEGES

Notează: nume DB, nume user, parola.

### 3. Editează `config.php`
Deschide `config.php` și înlocuiește în secțiunea `'db'`:
- `name` cu numele DB-ului tău (ex `r112945skyc_skycert`)
- `user` cu user-ul DB-ului
- `password` cu parola

### 4. Upload toate fișierele
Încarcă ÎNTREG conținutul folderului `skycert-app/` în `app.skycert.ro/`. Structura finală:
```
app.skycert.ro/
├── .htaccess
├── index.php
├── config.php
├── db.php
├── auth.php
├── helpers.php
├── modules/
├── views/
├── assets/
└── storage/
```

### 5. Deschide în browser
`https://app.skycert.ro/`

La prima accesare, schema DB se creează automat (tabelul `users` + user-ul admin `bentumarian@gmail.com` / `123456`).

Ești redirectat la `/login`. Te loghezi cu credentialele de mai sus.

### 6. Verifică
- Dashboard apare la `/dashboard`
- Sidebar funcțional (8 module + Setări placeholder)
- Logout merge

### Pentru debug
Dacă apare eroare albă, schimbă în `config.php`:
```
'env' => 'development'
```
Asta afișează erorile PHP detaliate.
