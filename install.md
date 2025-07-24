# Laravel-Vue Installation Guide

Diese Anleitung beschreibt die Schritte zur Installation und Einrichtung des Laravel-Vue Projekts mit Docker.

## 🚀 Installation

### 1. Vorbereitung
Kommentieren Sie in `docker-compose.yml` die Zeile `command: php artisan serve ...` zunächst aus.

### 2. Docker Container erstellen und starten
```bash
docker compose build
docker compose up -d
```

### 3. In den Container wechseln
```bash
docker compose exec app bash
```

### 4. Laravel Dependencies installieren
```bash
composer install
```

### 5. Application Key generieren
```bash
php artisan key:generate
```

### 6. Datenbank Konfiguration

Passen Sie in der `.env` Datei die Datenbank-Konfiguration an:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

### 7. Datenbank Migration und Seeding
```bash
php artisan migrate:fresh --seed
```

### 8. Storage Link erstellen
```bash
php artisan storage:link
```

### 9. Finalisierung
1. Kommentieren Sie die Zeile `command: php artisan serve ...` in `docker-compose.yml` wieder ein
2. Container stoppen:
   ```bash
   docker compose down
   ```
3. Container erneut starten:
   ```bash
   docker compose up -d
   ```

## ✅ Fertig!

Das Projekt sollte nun erfolgreich installiert und einsatzbereit sein.