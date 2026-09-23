# Chapu CV Mobile (Flutter)

Flutter client for **Chapu CV** by MALAFYALE TECH.

It connects to the Laravel backend Engines through Sanctum API tokens.

## Features

- Landing / get started / home / contact
- Register, login, logout
- Create & edit CV (synced to `POST /api/mobile/cv/sync`)
- Load CV from API (`GET /api/mobile/cv`)
- Preview + local QR share payload
- Runs on Android, iOS, and Flutter Web

## Requirements

- Flutter SDK 3.13+
- Running Chapu CV Laravel API (`php artisan serve`)

## Configure API URL

Defaults:

| Platform | Base URL |
|----------|----------|
| Flutter Web / Windows | `http://127.0.0.1:8000/api` |
| Android emulator | `http://10.0.2.2:8000/api` |

Override:

```bash
flutter run --dart-define=API_BASE_URL=http://YOUR_HOST:8000/api
```

## Run

```bash
# from repo root — start API
php artisan serve --host=127.0.0.1 --port=8000

# from this folder
flutter pub get
flutter run -d chrome --web-hostname=127.0.0.1 --web-port=5555
```

## Test account

```text
client@chapcv.com / 12345678
```

## Project layout

```text
lib/
  core/app_constants.dart
  models/cv_data.dart
  screens/          # landing, auth, home, create CV, preview, QR, contact
  services/         # ApiClient, AuthStore, CvStore
  theme/app_theme.dart
  main.dart
```

Full roadmap and backend checklist: see [`../Blueprint.md`](../Blueprint.md).
