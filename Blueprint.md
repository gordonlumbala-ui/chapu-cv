# CHAPU-CV — Updated 30 Day Development Blueprint

**Project Goal:** Build and deploy a functional Smart CV & Resume Generation Platform in 30 days.

## Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12, MySQL / SQLite, Sanctum |
| Shared logic | `app/Engines/` (API + web) |
| Web UI | Livewire, Blade, Jetstream, Tailwind / Metronic |
| Mobile | Flutter (`Chapu_cv_mobile`) — Android, iOS, Web |
| Extras | PDF generation, QR codes |

## Progress legend

- `[x]` Done
- `[~]` Partial / backend done, UI pending
- `[ ]` Not started

---

# WEEK 1 — FOUNDATION & USER PROFILE

## DAY 1 — Project Foundation

- [x] Confirm Laravel project structure
- [x] Confirm database connection (MySQL / SQLite)
- [x] Confirm migrations
- [x] Confirm seeders
- [x] Confirm authentication (Jetstream / Fortify / Sanctum)
- [x] Confirm user roles (`admin`, `client`, `guest`)
- [~] Create basic application layout (Metronic layouts exist; polish pending)
- [x] Confirm dashboard routes work (role-based views)
- [x] Create shared **Engines** layer for domain logic

**Deliverable:** Working authenticated Laravel application.  
**Status:** ✅ Foundation + Engines complete; web UI polish pending.

---

## DAY 2 — User Dashboard

- [~] Build client dashboard (shell exists)
- [~] Build navigation/sidebar (client layout exists; links mostly placeholders)
- [~] Add dashboard cards
- [ ] Add quick actions wired to real routes
- [ ] Add CV statistics from Engines / analytics

**Deliverable:** Functional client dashboard.  
**Status:** 🟡 Shell exists; live data & navigation pending.

---

## DAY 3 — Profile Management

- [x] User/profile database foundation (profile fields migration)
- [x] Profile **Engine** (`ProfileEngine`)
- [x] Profile API controller (show / update / deactivate)
- [x] Profile web controller (backend only — no new views owned here)
- [x] Save / edit profile via API
- [~] Create profile page / form (Jetstream + custom `profile.show` exist)
- [~] Display profile information
- [~] Add profile photo support (Jetstream)

**Deliverable:** Complete user profile module.  
**Status:** ✅ Backend (Engine + API + web controller) done; UI polish pending.

---

## DAY 4 — Education

- [x] Education migration
- [x] Education model + relationships
- [x] Education seeder + factory
- [x] Education API Resource
- [x] Education **Engine**
- [x] Education API controller (uses Engine)
- [x] Education web controller (backend only)
- [x] API routes registered
- [ ] Education web/Livewire UI (add / edit / delete / validation)

**Deliverable:** Complete education management.  
**Status:** ✅ Backend complete; web frontend pending. Mobile syncs education text via Engine.

---

## DAY 5 — Experience

- [x] Experience migration
- [x] Experience model + relationships
- [x] Experience seeder + factory
- [x] Experience API Resource
- [x] Experience **Engine**
- [x] Experience API controller
- [x] Experience web controller (backend only)
- [x] API routes registered
- [ ] Experience web/Livewire UI
- [ ] Current job UI

**Deliverable:** Complete experience management.  
**Status:** ✅ Backend complete; web frontend pending. Mobile syncs experience via Engine.

---

## DAY 6 — Skills

- [x] Skills migration + `cv_skills` pivot
- [x] Skill model + relationships
- [x] Skill seeder + factory
- [x] Skill API Resource
- [x] Skill **Engine**
- [x] Skill API controller
- [x] Skill web controller (backend only)
- [x] API routes registered
- [ ] Skills web/Livewire UI (level / percentage / categories)

**Deliverable:** Complete skills management.  
**Status:** ✅ Backend complete; web frontend pending. Mobile syncs comma-separated skills via Engine.

---

## DAY 7 — Projects

- [x] Projects migration
- [x] Project model + relationships
- [x] Project seeder + factory
- [x] Project API Resource
- [x] Project **Engine**
- [x] Project API controller
- [x] Project web controller (backend only)
- [x] API routes registered
- [ ] Projects web/Livewire UI (technologies / URLs / current)

**Deliverable:** Complete project management.  
**Status:** ✅ Backend complete; web frontend pending.

---

# WEEK 2 — PROFESSIONAL INFORMATION & CV SYSTEM

## DAY 8 — Certifications

- [x] Certification migration / model / relationships
- [x] Certification seeder + factory
- [x] Certification API Resource
- [x] Certification **Engine**
- [x] Certification API + web controllers
- [x] API routes registered
- [ ] Certification web UI (credential / expiry)

**Status:** ✅ Backend complete; frontend pending.

---

## DAY 9 — Languages & References

### Languages

- [x] Language migration / model / relationships
- [x] Language seeder + factory
- [x] Language API Resource
- [x] Language **Engine**
- [x] Language API + web controllers
- [x] API routes registered
- [ ] Language web UI

### References

- [x] Reference migration / model / relationships
- [x] Reference seeder + factory
- [ ] Reference API Resource
- [ ] Reference Engine
- [ ] Reference API + web controllers
- [ ] Reference web UI

**Status:** ✅ Languages backend done. 🟡 References DB only.

---

## DAY 10 — CV Management

- [x] CV migration / model / relationships
- [x] CV seeder + factory
- [x] CV API Resource
- [x] CV **Engine** (create / update / delete / duplicate / default / public)
- [x] CV API controller
- [x] CV web controller (backend; views not owned yet)
- [x] API + web resource routes
- [ ] Create / edit / delete / view CV UI
- [ ] CV title / type / default / active UI

**Status:** ✅ Backend complete; web frontend pending.

---

## DAY 11 — CV Templates

- [x] Template migration / model / seeder / factory
- [x] Template API Resource
- [x] Template **Engine**
- [x] Template API + web controllers
- [x] API + web routes
- [ ] Template listing / selection / preview UI
- [ ] Admin template management UI

**Status:** ✅ Backend complete; frontend pending.

---

## DAY 12 — CV Sections

- [x] CV sections migration / model / seeder
- [ ] CV Section API Resource / Engine / controllers
- [ ] Create / show-hide / order sections UI

**Status:** 🟡 Database/model foundation exists.

---

## DAY 13 — CV Builder (Web) + Mobile CV Sync

### Web builder

- [ ] Build CV editor UI
- [ ] Connect profile / education / experience / skills / projects / certifications / references

### Flutter mobile (attached to Engines via API)

- [x] Scaffold Flutter app (`Chapu_cv_mobile`)
- [x] App theme, landing, get-started, home, contact
- [x] Local CV draft (`CvStore` + SharedPreferences)
- [x] HTTP `ApiClient` + Sanctum token auth
- [x] Login / register / logout screens
- [x] `POST /api/register`, `POST /api/login`, `POST /api/logout`
- [x] `MobileCvSyncEngine` + `GET/POST /api/mobile/cv*`
- [x] Create/edit CV form syncs to Engines (profile + CV + education/experience/skills)
- [x] Pull CV from API after login
- [x] Preview CV + QR share screens
- [x] Run on Flutter **web** against local API (`http://127.0.0.1:8000/api`)

**Deliverable:** Functional CV builder (web) + mobile sync to backend.  
**Status:** ✅ Mobile ↔ Engine API done. ⬜ Web builder UI pending.

---

## DAY 14 — CV Builder Polish

- [ ] Improve web CV builder UI
- [ ] Section navigation / reorder / validation
- [~] Mobile form UX polish (basic done; structured section editors later)
- [ ] Error handling across web + mobile

**Status:** 🟡 Mobile usable; web polish pending.

---

# WEEK 3 — CV OUTPUT, PRIVACY & PUBLIC PROFILES

## DAY 15–17 — Templates, Preview

- [ ] Build Professional / Modern / Classic Blade templates
- [ ] Connect database data dynamically
- [~] Mobile CV preview (local layout exists; not template-driven from server)
- [ ] Web preview page + template switching

**Status:** ⬜ Web templates pending. 🟡 Mobile preview exists.

---

## DAY 18 — PDF Generation

- [ ] Install/configure PDF generator
- [ ] Convert CV preview to PDF + download
- [ ] Test one-page / multi-page CV
- [ ] Optional: mobile download PDF via API

**Status:** ⬜ Not started.

---

## DAY 19 — Download Tracking

- [x] Download tracking migration / model
- [x] Seeder foundation
- [ ] Record downloads + display statistics UI

**Status:** 🟡 Database/model foundation complete.

---

## DAY 20 — Privacy Settings

- [x] Privacy settings migration / model / fields
- [ ] Privacy settings page + apply rules to public CV

**Status:** 🟡 Backend foundation complete; UI and integration pending.

---

## DAY 21 — Public CV Profiles

- [x] Public profiles migration / model
- [ ] Publish CV / public slug page / activate-deactivate

**Status:** 🟡 Database/model foundation complete.

---

# WEEK 4 — QR, ANALYTICS, ADMIN & FINALIZATION

## DAY 22–24 — QR & Analytics

- [x] QR / QR scan / profile view migrations & models + seeders
- [~] Mobile QR screen (local payload; not yet tied to public profile URL)
- [ ] Generate QR image / download / redirect / analytics cards

**Status:** 🟡 DB foundation + mobile QR draft. Integration pending.

---

## DAY 25–26 — Admin

- [~] Admin dashboard shell
- [ ] User / CV / template / public profile management

**Status:** 🟡 Shell only.

---

## DAY 27 — Smart CV Features

- [ ] Summary / experience / skill suggestions
- [ ] Job-targeted CV concept

**Status:** ⬜ Not started.

---

## DAY 28 — Security & Validation

- [x] API ownership checks (Engines `OwnsResource`)
- [x] API validation (Engines + Form validation)
- [x] API JSON exception handling (`bootstrap/app.php`)
- [x] Sanctum authentication (token for Flutter)
- [~] Review web authorization / ownership
- [ ] Review file uploads / rate limiting
- [ ] Full security review

**Status:** 🟡 Core API security in place; full review pending.

---

## DAY 29 — Testing & UI Polish

- [x] Smoke-test API login + mobile CV sync
- [x] Flutter analyze (lib) clean
- [ ] Full regression: registration, profile, sections, CV, PDF, QR, analytics
- [ ] Responsive web polish

**Status:** 🟡 Partial smoke tests done.

---

## DAY 30 — Deployment & Final Release

- [ ] Production config, SSL, domain, backups
- [ ] Deploy Laravel API + web
- [ ] Publish Flutter app (Play Store / App Store / PWA)
- [ ] Final documentation

**Status:** ⬜ Not started.

---

# CURRENT BACKEND CHECKPOINT

Completed foundation:

- [x] Laravel 12 project
- [x] Database migrations (including user profile fields)
- [x] Models + relationships
- [x] Seeders + required factories
- [x] Helpers
- [x] Sanctum authentication
- [x] API exception handling
- [x] API Resources
- [x] Shared **Engines** (`Cv`, `Profile`, `Education`, `Experience`, `Skill`, `Project`, `Certification`, `Language`, `CvTemplate`, `MobileCvSync`)
- [x] API Controllers wired to Engines
- [x] Web Controllers wired to Engines (backend only — views deferred)
- [x] API routes for auth, profile, CV resources, templates, mobile sync
- [x] Web resource routes registered
- [x] Flutter mobile app connected to Engines via API
- [x] Flutter web run against local API

---

# FLUTTER MOBILE CHECKPOINT

App path: `Chapu_cv_mobile/`

| Feature | Status |
|---------|--------|
| Landing / get started / home / contact | Done |
| Auth (login / register / logout) | Done |
| CV create/edit → `POST /api/mobile/cv/sync` | Done |
| Load CV → `GET /api/mobile/cv` | Done |
| Preview + local QR | Done |
| Android / Chrome web run | Done |
| Structured section editors on mobile | Pending |
| Public profile / server QR URL | Pending |
| PDF download from mobile | Pending |

**Seeded test account**

```text
client@chapcv.com
12345678
```

**Local run**

```bash
# API
php artisan serve --host=127.0.0.1 --port=8000

# Flutter web
cd Chapu_cv_mobile
flutter run -d chrome --web-hostname=127.0.0.1 --web-port=5555
```

API base URL defaults to `http://127.0.0.1:8000/api` on web/desktop and `http://10.0.2.2:8000/api` on Android emulator.

---

# NEXT DEVELOPMENT PHASE

```text
WEB / LIVEWIRE UI (profile → sections → CV builder)
        ↓
REFERENCE ENGINE + API
        ↓
CV TEMPLATES (Blade) + PREVIEW
        ↓
PDF GENERATION
        ↓
PUBLIC CV + PRIVACY
        ↓
QR (server) + ANALYTICS
        ↓
ADMIN MANAGEMENT
        ↓
SMART FEATURES
        ↓
SECURITY REVIEW + TESTING
        ↓
DEPLOYMENT (Laravel + Flutter)
```

---

# FINAL PRODUCT FLOW

```text
USER (Web Blade / Flutter)
        │
        ├── Profile
        ├── Education
        ├── Experience
        ├── Skills
        ├── Projects
        ├── Certifications
        ├── Languages
        └── References
                │
                ▼
         Engines (shared)
                │
        ┌───────┴───────┐
        ▼               ▼
   API (Sanctum)    Web Controllers
        │
        ▼
   Flutter / Web clients
        │
        ▼
   CV Builder → Template → Preview → PDF
        │
        ▼
   Public CV → Privacy → QR → Analytics → Dashboard
```

**30-DAY TARGET:** Live Chapu CV platform (Laravel API + web UI + Flutter app).
