# 📄 Chap CV

> **Smart CV & Resume Generation Platform built with Laravel and MySQL**

Chap CV is a web-based **CV and Resume Management System** designed to help users create, customize, manage, generate, download, and share professional CVs and resumes.

Instead of creating every CV from scratch, Chap CV allows users to maintain their professional information in one centralized profile and use that information to generate different CVs according to their career, job application, academic, or professional needs.

Chap CV also provides **customizable CV templates, shareable professional profiles, QR codes, privacy controls, and resume analytics**, making it more than a traditional CV generator.

---

## 📌 Table of Contents

- [About the Project](#-about-the-project)
- [Project Objectives](#-project-objectives)
- [Key Features](#-key-features)
- [How Chap CV Works](#-how-chap-cv-works)
- [Technology Stack](#-technology-stack)
- [System Architecture](#-system-architecture)
- [Main Modules](#-main-modules)
- [Database](#-database)
- [Database Tables](#-database-tables)
- [CV Generation](#-cv-generation)
- [Privacy and Visibility](#-privacy-and-visibility)
- [Public Profiles](#-public-profiles)
- [QR Code System](#-qr-code-system)
- [Resume Analytics](#-resume-analytics)
- [Smart Resume Generation](#-smart-resume-generation)
- [Installation](#-installation)
- [Environment Configuration](#-environment-configuration)
- [Database Setup](#-database-setup)
- [Seeders](#-seeders)
- [Running the Application](#-running-the-application)
- [Project Structure](#-project-structure)
- [Example Workflow](#-example-workflow)
- [Security](#-security)
- [Future Improvements](#-future-improvements)
- [Testing](#-testing)
- [Useful Artisan Commands](#-useful-artisan-commands)
- [Contributing](#-contributing)
- [License](#-license)

---

# 📖 About the Project

**Chap CV** is a Laravel-based platform that simplifies the process of creating and managing professional CVs and resumes.

Traditional CV creation requires users to repeatedly edit documents whenever they apply for different jobs. Chap CV solves this problem by allowing users to store their professional information in one centralized system.

From this information, users can generate different CVs and resumes according to their requirements.

Examples include:

- Academic CV
- Professional CV
- Technical CV
- Job Application Resume
- Short Resume
- Detailed Resume
- Custom CV

Users can also select which sections and information should appear in each CV.

Chap CV is therefore designed as both a **CV generation platform** and a **professional identity management system**.

---

# 🎯 Project Objectives

The main objectives of Chap CV are to:

1. Simplify professional CV creation.
2. Allow users to maintain their professional information in one place.
3. Generate different CV and resume types from stored information.
4. Allow users to download generated CVs.
5. Provide customizable CV templates.
6. Generate shareable professional profile links.
7. Generate QR codes connected to professional profiles or CVs.
8. Provide privacy and information visibility controls.
9. Allow users to decide what information can be publicly accessed.
10. Reduce the time required to create new CVs.
11. Support continuous and repeated resume generation.
12. Provide a centralized professional identity.
13. Improve accessibility of professional information through links and QR codes.
14. Provide basic analytics for CV downloads, profile views, and QR scans.

---

# 🚀 Key Features

## 👤 User Account Management

Chap CV provides user account management through Laravel authentication.

Users can:

- Register
- Login
- Logout
- Manage their accounts
- Update their profiles
- Manage professional information
- Manage educational information
- Manage work experience
- Manage skills
- Manage projects
- Manage certifications
- Manage references

The `users` table also stores the user's system role.

Current roles include:

- `admin`
- `client`
- `guest`

---

## 📄 Multiple CV Types

Chap CV is designed to support different types of CVs and resumes.

Examples include:

### Academic CV

Suitable for:

- Students
- Researchers
- Lecturers
- Academic applications
- Scholarships
- Research opportunities

### Professional CV

Suitable for:

- Employment
- Corporate applications
- Professional opportunities

### Technical CV

Suitable for:

- Software developers
- IT professionals
- Engineers
- Technicians
- Technical specialists

### Short Resume

Contains only the most important information for quick job applications.

### Custom Resume

Allows users to choose the information and sections they want to include.

---

# 🧠 How Chap CV Works

Chap CV separates **professional information** from individual CV documents.

The user maintains one master professional profile.

```text
                    USER
                     │
                     ▼
              MASTER PROFILE
                     │
       ┌─────────────┼─────────────┐
       ▼             ▼             ▼
   Education     Experience      Skills
       │             │             │
       ├─────────────┼─────────────┤
       │             │             │
       ▼             ▼             ▼
   Projects    Certifications  References
                     │
                     ▼
              CV GENERATION
                     │
          ┌──────────┼──────────┐
          ▼          ▼          ▼
      Academic   Professional  Technical
          │          │          │
          └──────────┼──────────┘
                     ▼
                Generated CV
                     │
             ┌───────┴───────┐
             ▼               ▼
            PDF          Public Profile
                             │
                             ▼
                          QR Code
```

This approach allows the same professional information to be reused across multiple CVs.

---

# 🧩 Main Modules

## 1. Authentication Module

Handles:

- Registration
- Login
- Logout
- Password management
- Account management
- User roles

---

## 2. Profile Module

Stores the user's main professional identity.

Information includes:

- First name
- Middle name
- Last name
- Phone
- Professional title
- Professional summary
- Date of birth
- Gender
- Nationality
- Country
- Region
- City
- Address
- Website
- LinkedIn
- GitHub

---

## 3. Education Module

Allows users to maintain multiple educational records.

Examples:

- Primary
- Secondary
- Certificate
- Diploma
- Bachelor
- Master
- PhD
- Vocational
- Other

Each education record can contain:

- Institution
- Program
- Field of study
- Start date
- End date
- Grade
- Certificate
- Description

---

## 4. Experience Module

Stores professional work experience.

Each record can contain:

- Job title
- Company
- Location
- Start date
- End date
- Current employment status
- Description
- Achievements

---

## 5. Skills Module

Allows users to maintain their professional skills.

Examples:

```text
PHP
Laravel
Java
Spring Boot
JavaScript
React
Networking
Database Management
MySQL
Git
```

Skills can have:

- Name
- Category
- Level
- Percentage

---

## 6. Project Module

Users can add projects to their professional profile.

Each project can contain:

- Project name
- Description
- Role
- Technologies
- Project URL
- GitHub URL
- Start date
- End date
- Current status

---

## 7. Certification Module

Stores professional certifications and training.

Each certification can contain:

- Certificate name
- Issuing organization
- Credential ID
- Credential URL
- Issue date
- Expiry date
- Non-expiring status
- Description

---

## 8. Reference Module

Allows users to add professional references.

Reference information includes:

- Name
- Position
- Organization
- Relationship
- Email
- Phone
- Address

References can be controlled through privacy settings.

---

# 🗄️ Database

Chap CV uses **MySQL** as its primary database.

The database is designed around a centralized professional profile model.

Instead of storing complete CV information separately inside every CV, the system stores the user's professional information in dedicated tables.

The CV system then uses this information when generating a CV.

---

# 📊 Database Tables

Chap CV currently contains **17 core database tables**.

## 1. `users`

Stores authentication and account information.

Main responsibilities:

- User account
- Email
- Password
- Role
- Account status
- Profile photo
- Authentication sessions

Roles currently used:

```text
admin
client
guest
```

---

## 2. `profiles`

Stores the user's main personal and professional profile.

Relationship:

```text
users 1 ─────── 1 profiles
```

Each user has one main profile.

---

## 3. `educations`

Stores educational qualifications.

Relationship:

```text
users 1 ─────── N educations
```

A user can have multiple education records.

---

## 4. `experiences`

Stores professional work experience.

Relationship:

```text
users 1 ─────── N experiences
```

A user can have multiple jobs or professional experiences.

---

## 5. `skills`

Stores professional skills.

Relationship:

```text
users 1 ─────── N skills
```

A user can have multiple skills.

---

## 6. `projects`

Stores professional and personal projects.

Relationship:

```text
users 1 ─────── N projects
```

---

## 7. `certifications`

Stores professional certificates and qualifications.

Relationship:

```text
users 1 ─────── N certifications
```

---

## 8. `references`

Stores professional referees.

Relationship:

```text
users 1 ─────── N references
```

---

## 9. `cv_templates`

Stores available CV designs.

Examples:

```text
Professional
Modern
Classic
```

The table also supports:

- Template descriptions
- Preview images
- Template paths
- Active/inactive templates
- Premium templates

---

## 10. `cvs`

Stores the actual CV records created by users.

Each CV belongs to:

- A user
- Optionally, a CV template

A user can create multiple CVs.

Example:

```text
Stuart's CVs

├── Professional CV
├── Technical CV
├── Academic CV
└── Short Resume
```

---

## 11. `cv_sections`

Controls the sections included in an individual CV.

Examples:

```text
Personal Information
Education
Experience
Skills
Projects
Certifications
References
```

Each section has:

- Section type
- Title
- Display order
- Visibility status

This allows different CVs to display different information.

---

## 12. `privacy_settings`

Controls which user information can be publicly displayed.

Examples:

```text
Email       → Visible / Hidden
Phone       → Visible / Hidden
Address     → Visible / Hidden
Education   → Visible / Hidden
Experience  → Visible / Hidden
Skills      → Visible / Hidden
Projects    → Visible / Hidden
References  → Visible / Hidden
```

Each user has one privacy settings record.

---

## 13. `public_profiles`

Stores shareable professional profile information.

A public profile can be connected to a user's CV.

Example:

```text
Chap CV
   │
   ▼
Public Profile
   │
   ▼
Professional Information
```

Each public profile has a unique slug that can be used for sharing.

---

## 14. `qrcodes`

Stores QR codes associated with CVs or public profiles.

A QR code can point to a public professional profile.

The table stores:

- QR name
- Unique token
- Generated file path
- Associated CV
- Associated public profile
- Active status

---

## 15. `cv_downloads`

Records CV downloads.

This allows Chap CV to track:

- Which CV was downloaded
- Which user owns the CV
- IP address
- User agent
- Download time

This can later be used for resume analytics.

---

## 16. `profile_views`

Records visits to public profiles.

The system can track:

- Public profile
- Viewer information when available
- IP address
- User agent
- View time

This provides profile-view analytics.

---

## 17. `qr_scans`

Records QR-code scans.

The system can track:

- QR code
- User
- IP address
- User agent
- Device type
- Browser
- Platform
- Scan time

This allows users to understand how often their professional QR code is being used.

---

# 🔗 Database Relationship Overview

The overall database structure can be represented as:

```text
                              users
                                │
        ┌──────────┬────────────┼────────────┬──────────────┐
        │          │            │            │              │
        ▼          ▼            ▼            ▼              ▼
    profiles   educations   experiences   skills        projects
        │
        ├──────────────┬───────────────┐
        ▼              ▼               ▼
 certifications    references    privacy_settings
        │
        │
        ▼
       cvs
        │
        ├───────────────┐
        ▼               ▼
 cv_sections       cv_templates
        │
        ▼
 public_profiles
        │
        ├───────────────┐
        ▼               ▼
    qrcodes        profile_views
        │
        ▼
    qr_scans

cvs
 │
 ▼
cv_downloads
```

---

# 🧠 Master Profile Concept

Chap CV is built around the concept of a **Master Professional Profile**.

```text
                 MASTER PROFILE
                       │
        ┌──────────────┼──────────────┐
        ▼              ▼              ▼
    Education      Experience       Skills
        │              │              │
        └──────────────┼──────────────┘
                       │
              ┌────────┼────────┐
              ▼        ▼        ▼
           Projects  Certificates References
                       │
                       ▼
                  CV Generator
                       │
          ┌────────────┼────────────┐
          ▼            ▼            ▼
       Academic    Technical    Professional
          │            │            │
          └────────────┼────────────┘
                       ▼
                  Generated CV
```

The user maintains information once and can reuse it across multiple CVs.

---

# 📄 CV Generation

The CV generation process combines:

```text
User Information
       +
CV Type
       +
CV Template
       +
Selected Sections
       +
Privacy/Visibility Rules
       ↓
CV Generation Engine
       ↓
Generated CV
       ↓
PDF
```

This architecture allows a user to create multiple CVs without duplicating their professional data.

---

# 🔐 Privacy and Visibility

Chap CV separates stored information from publicly accessible information.

A user's information can be controlled through privacy settings.

```text
                    USER DATA
                       │
          ┌────────────┼────────────┐
          ▼            ▼            ▼
       PRIVATE       PUBLIC      CV VISIBLE
          │            │            │
          ▼            ▼            ▼
      Account       Public       Generated
       Owner        Profile         CV
```

For example:

```text
Email       → Public
Phone       → Private
Address     → Private
Skills      → Public
Experience  → Public
References  → Private
```

This prevents public profile pages and QR codes from automatically exposing all user information.

---

# 🌐 Public Profiles

Users can create a public professional profile.

A public profile may contain:

- Name
- Professional title
- Professional summary
- Skills
- Education
- Experience
- Projects
- Certifications
- Selected achievements

The actual information displayed is controlled by privacy settings.

Example:

```text
https://your-domain.com/profile/stuart-smg
```

---

# 📱 QR Code System

Chap CV can generate QR codes that connect users to their public professional profiles.

```text
             QR CODE
                │
                ▼
         Public Profile
                │
       ┌────────┼────────┐
       ▼        ▼        ▼
     Skills  Experience  Projects
       │        │        │
       └────────┼────────┘
                ▼
        Professional Profile
```

QR codes can be placed on:

- Printed CVs
- Business cards
- Portfolios
- Posters
- Personal websites
- Professional documents
- Job applications

The QR code does not need to expose private information directly. It points to a controlled public profile.

---

# 📊 Resume Analytics

Chap CV is designed to support analytics through dedicated database tables.

The system can track:

```text
Profile Views
      │
      ▼
profile_views

CV Downloads
      │
      ▼
cv_downloads

QR Scans
      │
      ▼
qr_scans
```

Future dashboards can display:

```text
Total Profile Views
Total CV Downloads
Total QR Scans
Most Viewed Profile
Most Downloaded CV
QR Scan Activity
```

---

# ⚡ Smart Resume Generation

One of the main concepts of Chap CV is **continuous resume generation**.

A user's professional information can change over time.

For example:

- New job
- New project
- New skill
- New certificate
- New education qualification
- New achievement

The user updates the master profile and can generate a new CV using the latest information.

```text
                  MASTER PROFILE
                        │
                 Update Information
                        │
                        ▼
                 Latest User Data
                        │
                        ▼
                  CV Generator
                        │
          ┌─────────────┼─────────────┐
          ▼             ▼             ▼
       Academic      Technical    Professional
          │             │             │
          └─────────────┼─────────────┘
                        ▼
                       PDF
```

This makes Chap CV useful as a **continuous professional profile management platform**, not simply a one-time CV generator.

---

# 🛠️ Technology Stack

## Backend

- Laravel
- PHP

## Authentication

- Laravel Jetstream
- Laravel Fortify
- Laravel Sanctum

## Frontend

- Laravel Livewire
- Blade
- HTML5
- CSS3
- JavaScript

## Database

- MySQL

## Development Tools

- Composer
- NPM
- Vite
- Git

## PDF Generation

A Laravel-compatible PDF generation package can be integrated for generating downloadable CV documents.

## QR Code

A Laravel-compatible QR code generation package can be integrated for generating profile and CV QR codes.

---

# 🏗️ System Architecture

Chap CV follows the Laravel MVC architecture with dedicated services for complex operations.

```text
                         USER
                           │
                           ▼
                    WEB INTERFACE
                           │
                           ▼
                        ROUTES
                           │
                           ▼
                     CONTROLLERS
                           │
              ┌────────────┼────────────┐
              ▼            ▼            ▼
           REQUESTS      SERVICES      MODELS
                            │            │
                            │            ▼
                            │          MySQL
                            │
                            ▼
                    CV GENERATION
                            │
                  ┌─────────┴─────────┐
                  ▼                   ▼
                 PDF                 QR
                  │                   │
                  └─────────┬─────────┘
                            ▼
                           USER
```

---

# 🌱 Seeders

Chap CV currently uses only the necessary startup seeders.

## `UserSeeder`

Creates six initial users:

```text
2 Admins
2 Clients
2 Guests
```

The configured accounts include:

```text
Admin:
admin@chapcv.com
administrator@chapcv.com

Client:
stuartsmg7@gmail.com
client@chapcv.com

Guest:
guest@chapcv.com
visitor@chapcv.com
```

The development password for these seeded accounts is:

```text
12345678
```

> This password is intended for local development/testing and should be changed before production deployment.

## `CvTemplateSeeder`

Creates the initial CV templates:

```text
Professional
Modern
Classic
```

## `DatabaseSeeder`

Runs:

```text
UserSeeder
CvTemplateSeeder
```

---

# ⚙️ Installation

## Requirements

Before installing Chap CV, make sure the following are installed:

- PHP
- Composer
- MySQL
- Node.js
- NPM
- Git

A compatible web server such as Apache/Nginx can also be used.

---

# 📥 Clone the Repository

```bash
git clone https://github.com/your-username/chap-cv.git
```

Enter the project directory:

```bash
cd chap-cv
```

---

# 📦 Install PHP Dependencies

```bash
composer install
```

---

# 📦 Install Frontend Dependencies

```bash
npm install
```

---

# ⚙️ Environment Configuration

Copy the example environment file.

### Windows PowerShell

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

---

# 🗄️ Database Setup

Create the MySQL database:

```sql
CREATE DATABASE chap_cv;
```

Configure the `.env` file:

```env
APP_NAME="Chap CV"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chap_cv
DB_USERNAME=root
DB_PASSWORD=
```

Update the database credentials according to your MySQL installation.

---

# 🔄 Run Migrations

Run:

```bash
php artisan migrate
```

---

# 🌱 Run Seeders

Run:

```bash
php artisan db:seed
```

Or run migrations and seeders together on a fresh database:

```bash
php artisan migrate --seed
```

---

# 🖼️ Storage Link

If profile images or generated files are stored using Laravel's storage system:

```bash
php artisan storage:link
```

---

# 🎨 Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

---

# ▶️ Running the Application

Start Laravel:

```bash
php artisan serve
```

The application will normally be available at:

```text
http://127.0.0.1:8000
```

During frontend development, keep Vite running:

```bash
npm run dev
```

---

# 📂 Project Structure

A simplified Laravel structure:

```text
chap-cv/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   │
│   ├── Models/
│   │
│   └── Services/
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── public/
│
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│
├── routes/
│   ├── web.php
│   └── api.php
│
├── storage/
│
├── tests/
│
├── .env
├── .env.example
├── composer.json
├── package.json
└── README.md
```

---

# 🔄 Example User Workflow

```text
Register
   ↓
Create Profile
   ↓
Add Personal Information
   ↓
Add Education
   ↓
Add Experience
   ↓
Add Skills
   ↓
Add Projects
   ↓
Add Certifications
   ↓
Add References
   ↓
Configure Privacy
   ↓
Create CV
   ↓
Choose CV Type
   ↓
Choose Template
   ↓
Choose Sections
   ↓
Generate CV
   ↓
Preview
   ↓
Download PDF
   ↓
Create Public Profile
   ↓
Generate QR Code
   ↓
Share
```

---

# 🌐 Public Profile Workflow

```text
User
 │
 ▼
Create Professional Profile
 │
 ▼
Configure Privacy
 │
 ▼
Create Public Profile
 │
 ▼
Generate Shareable Link
 │
 ▼
Generate QR Code
 │
 ▼
Share
 │
 ▼
Employer / Recruiter / Visitor
 │
 ▼
Public Profile
```

---

# 🔐 Security

Chap CV uses Laravel's security mechanisms and follows standard web application security practices.

Security considerations include:

- Authentication
- Authorization
- Password hashing
- CSRF protection
- Input validation
- Form request validation
- Eloquent/query builder protection
- XSS protection
- Secure file uploads
- Privacy controls
- Role-based access control
- Protected user resources

Private information should never be exposed through public profile routes unless the user has explicitly allowed it.

---

# 🔑 Privacy Model

Chap CV separates information into three conceptual areas:

### Private Information

Information accessible only to the account owner.

### Public Information

Information allowed to appear on the user's public professional profile.

### CV Information

Information allowed to appear inside a generated CV.

```text
                    Stored Information
                           │
             ┌─────────────┼─────────────┐
             ▼             ▼             ▼
          Private        Public       CV Visible
             │             │             │
             ▼             ▼             ▼
          Account       Public         Generated
           Owner        Profile           CV
```

---

# 🔮 Future Improvements

## 🤖 AI-Assisted Resume Generation

Future versions may use AI to:

- Generate professional summaries
- Improve job descriptions
- Match resumes to job descriptions
- Suggest relevant skills
- Improve experience descriptions
- Generate cover letters

---

## 🎨 Advanced CV Templates

Future templates may include:

- Minimal
- Corporate
- Creative
- Academic
- Technical
- Executive
- Modern
- Classic

---

## 📱 Mobile Application

A mobile application could allow users to:

- Update profiles
- Generate CVs
- View QR codes
- Share profiles
- Download resumes

---

## 📈 Advanced Resume Analytics

Future analytics can include:

```text
Profile Views
QR Scans
CV Downloads
Public Profile Visits
Most Viewed CV
Most Downloaded CV
Visitor Statistics
```

---

## 🔗 Custom Professional URLs

Users could have URLs such as:

```text
yourdomain.com/stuart-smg
```

instead of randomly generated identifiers.

---

## 🌍 Multilingual CVs

Future versions could support:

- English
- Kiswahili
- French
- Other languages

---

# 🧪 Testing

Laravel tests can be executed using:

```bash
php artisan test
```

Tests can cover:

- Authentication
- Profile creation
- Education management
- Experience management
- CV creation
- CV generation
- Privacy controls
- Public profiles
- QR generation
- PDF generation
- Authorization
- Data validation

---

# 🧹 Useful Artisan Commands

Clear application cache:

```bash
php artisan optimize:clear
```

Run migrations:

```bash
php artisan migrate
```

Rollback migrations:

```bash
php artisan migrate:rollback
```

Check migration status:

```bash
php artisan migrate:status
```

Create a controller:

```bash
php artisan make:controller ExampleController
```

Create a model and migration:

```bash
php artisan make:model Example -m
```

Create a seeder:

```bash
php artisan make:seeder ExampleSeeder
```

Run seeders:

```bash
php artisan db:seed
```

Start the development server:

```bash
php artisan serve
```

---

# 🤝 Contributing

Contributions are welcome.

To contribute:

1. Fork the repository.
2. Create a feature branch.

```bash
git checkout -b feature/new-feature
```

3. Make your changes.
4. Test the application.

```bash
php artisan test
```

5. Commit your changes.

```bash
git commit -m "Add new CV feature"
```

6. Push the branch.

```bash
git push origin feature/new-feature
```

7. Create a Pull Request.

---

# 📜 License

Chap CV is developed as a software project for professional CV and resume management.

The final licensing terms should be defined by the project owner in the repository.

---

# 👨‍💻 Project Summary

**Chap CV** is more than a traditional CV generator.

It is a centralized **professional identity and resume management platform** where users can:

> **Create → Manage → Customize → Generate → Download → Share → Protect → Analyze**

their professional information.

The platform is built around a **Master Professional Profile**, allowing users to maintain their information once and reuse it across multiple CVs and resumes.

The current database architecture consists of **17 core tables** covering:

```text
Users
Profiles
Education
Experience
Skills
Projects
Certifications
References
CV Templates
CVs
CV Sections
Privacy Settings
Public Profiles
QR Codes
CV Downloads
Profile Views
QR Scans
```

These tables provide the foundation for:

- Professional profile management
- Multiple CV creation
- CV template management
- Custom CV sections
- Privacy control
- Public professional profiles
- QR-code sharing
- CV download tracking
- Profile-view analytics
- QR-scan analytics

The overall concept is:

```text
                    CHAP CV

              MASTER PROFILE
                     │
       ┌─────────────┼─────────────┐
       ▼             ▼             ▼
    Education     Experience      Skills
       │             │             │
       └─────────────┼─────────────┘
                     │
              Projects & More
                     │
                     ▼
               CV GENERATOR
                     │
        ┌────────────┼────────────┐
        ▼            ▼            ▼
     Academic    Technical    Professional
        │            │            │
        └────────────┼────────────┘
                     ▼
                  PDF CV
                     │
            ┌────────┴────────┐
            ▼                 ▼
      Public Profile       QR Code
            │                 │
            ▼                 ▼
       Profile Views      QR Scans

                  CV Downloads
```

---

## ⭐ Chap CV

**Create your professional identity.**

**Build your CV.**

**Customize your resume.**

**Share your profile.**

**Generate your QR code.**

**Control your privacy.**

**Track your professional reach.**

**Keep your resume up to date.**

> **Built with Laravel + MySQL.**
