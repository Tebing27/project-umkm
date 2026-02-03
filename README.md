# UMKM Management System (Sasuma)

> Sistem Manajemen UMKM (Usaha Mikro Kecil Menengah) - Small Business Directory Platform

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4.x-06B6D4?style=flat&logo=tailwindcss&logoColor=white)

---

## 📋 Table of Contents

1. [Project Overview](#-project-overview)
2. [Features](#-features)
   - [User Features](#user-features)
   - [Admin Features](#admin-features)
   - [Public Features](#public-features)
   - [Business & Monetization Features](#business--monetization-features)
   - [System Features](#system-features)
3. [Technology Stack](#-technology-stack)
4. [Database Schema & ERD](#-database-schema--erd)
5. [Environment Configuration](#-environment-configuration)
6. [Installation](#-installation)
   - [Local Development (Docker)](#local-development-docker)
   - [Shared Hosting Deployment](#shared-hosting-deployment)
7. [Application Logic & Flow](#-application-logic--flow)
8. [Cronjob Configuration](#-cronjob-configuration)
9. [Commands Reference](#-commands-reference)
10. [Project Structure](#-project-structure)
11. [API & External Services](#-api--external-services)
12. [Troubleshooting](#-troubleshooting)

---

## 🎯 Project Overview

**UMKM Management System** is a comprehensive Laravel-based platform for managing small businesses (UMKM - Usaha Mikro Kecil Menengah) in Indonesia. The system provides a complete ecosystem for business registration, verification, product management, and public discovery.

### Key Capabilities

- **Business Directory:** Public listing of verified small businesses
- **Admin Verification:** Quality control through manual shop verification
- **Product Showcase:** Multi-image product galleries with categories
- **Geographic Search:** Region-based filtering and interactive maps
- **Multi-language:** Indonesian and English support with AI translation
- **Real-time Updates:** Live notifications via Firebase Realtime Database
- **SEO Optimized:** Automated sitemap generation and meta tags
- **Cloud Storage:** Cloudinary integration for scalable image hosting

### Target Users

1. **UMKM Owners:** Register and manage their business profiles
2. **Administrators:** Verify and moderate business listings
3. **Public Visitors:** Discover and explore local businesses

---

## ✨ Features

### User Features

✅ **Account Management**

- Email verification required
- Profile with personal details (name, phone, birth date, address)
- Password reset functionality

✅ **Shop Management**

- Single shop per user account
- Business details (name, description, type, revenue range)
- Geographic location with map pinning
- Social media links (Instagram, TikTok, Facebook, Website)
- Business license uploads
- Shop logo upload (Cloudinary-hosted)

✅ **Product Management**

- Unlimited products per shop
- Product details (name, price, category, variant, description)
- Multi-image gallery per product
- Active/inactive status toggle
- Best seller highlighting
- Batch image upload support

✅ **Photo Gallery**

- Up to 5 shop photos
- Drag-and-drop ordering
- Cloudinary CDN delivery
- Responsive image srcsets

### Admin Features

✅ **Shop Verification System**

- Review pending shops
- Approve/reject with reasons
- Automatic completeness checking
- Verification status tracking

✅ **User Management**

- View all registered users
- User detail inspection
- Shop association tracking

✅ **Content Management (CMS)**

- Dynamic business types
- Logo fallbacks per business type
- Hero images for homepage
- UMKM index banner images
- Text content blocks

✅ **Region Management**

- Geographic area configuration
- Featured shop selection per region
- Region images and coordinates
- Hero carousel ordering

✅ **Featured Region Slider (Monetization Ready)**

- Custom shop highlight per region for homepage hero slider
- Admin can select specific UMKM to feature from each region
- Configurable display order for hero carousel
- **Business Potential:** Can be monetized as "sponsored placement" or "premium listing"
- Shops can pay to be featured prominently on homepage per their region

### Public Features

✅ **Business Discovery**

- Searchable shop directory
- Filter by business type
- Filter by region
- Verified badge display
- View counter tracking

✅ **Shop Detail Pages**

- Complete business information
- Photo gallery slider
- Product catalog with images
- Social media links
- Map with exact location

✅ **Homepage**

- Hero carousel with featured shops
- Region showcase with shop counts
- Interactive map with all verified shops
- Business type categories

### Business & Monetization Features

✅ **Featured Region Slider System**

The Featured Region Slider (`featured-region-card.blade.php`) is a powerful admin feature that enables business monetization:

**How It Works:**

```
Admin Panel → Content Management → Region Configuration
                     ↓
   ┌─────────────────────────────────────────────────────────────┐
   │  REGION CARD (per region)                                   │
   │  ┌───────────────────────────────────────────────────────┐  │
   │  │ [Region Image] [Region Name]           Urutan: [#1]   │  │
   │  │                                                       │  │
   │  │ Featured Shop: [▼ Select UMKM from this region    ]   │  │
   │  │                                                       │  │
   │  │                                     [Simpan Button]   │  │
   │  └───────────────────────────────────────────────────────┘  │
   └─────────────────────────────────────────────────────────────┘
                     ↓
   Homepage Hero Slider displays featured shops in order
```

**Key Features:**

| Feature | Description | Business Value |
|---------|-------------|----------------|
| **Custom Shop Selection** | Admin can manually select which shop appears as "featured" for each region | Premium placement for paying UMKM |
| **Display Order Control** | Set `hero_order` to control slider sequence | Priority positioning (#1, #2, etc.) |
| **Random/None Option** | "Acak / Tidak Ada" option for default behavior | Free tier or rotating display |
| **Region-Scoped** | Only shows shops belonging to that specific region | Location-based advertising |
| **Real-time Search** | Searchable dropdown for easy shop selection | Admin efficiency |

**Monetization Strategies:**

1. **Sponsored Placement Package**
   - Charge UMKM monthly/annually to be featured on homepage
   - Example: Rp 100.000/month for "Featured Business" status

2. **Priority Region Listing**
   - Higher `hero_order` numbers = later in carousel
   - Sell "Position #1" premium spots per region

3. **Rotating Spotlight**
   - Use "Acak" for free tier users
   - Guaranteed placement for paying customers

4. **Regional Campaigns**
   - Partner with local governments or associations
   - Feature multiple businesses from a region during festivals/events

**Technical Implementation:**

Located in: `laravel_app/resources/views/admin/content/partials/featured-regions/`
- `featured-region-card.blade.php` - Main card component with Alpine.js state
- `featured-region-header.blade.php` - Region name, image, and order input
- `featured-region-dropdown.blade.php` - Searchable shop selector dropdown
- `featured-region-submit.blade.php` - Save button with loading state

Controller: `App\Http\Controllers\Admin\RegionController@updateFeaturedShop`
Model: `Region` with `featured_shop_id` foreign key to `shops` table

---

### System Features

✅ **Multi-language Support**

- Indonesian (default)
- English translation via OpenRouter AI
- Automatic shop description translation
- Cached translations for performance

✅ **SEO Optimization**

- Dynamic sitemap.xml generation
- Robots.txt configuration
- Meta tags for all pages
- Canonical URLs
- Structured data support

✅ **Real-time Updates**

- Firebase Realtime Database integration for live notifications
- Shop verification status updates
- Content update broadcasts
- User status changes

✅ **Performance**

- Database query optimization
- Eager loading relationships
- Image CDN delivery
- Response caching
- Index optimization on high-traffic columns

---

## 🛠 Technology Stack

### Backend

- **Framework:** Laravel 12.x (PHP 8.2+)
- **Database:** MySQL 8.0
- **Queue System:** Database-driven queues
- **Cache:** Database cache driver
- **Session:** Database session storage

### Frontend

- **Template Engine:** Blade
- **CSS Framework:** Tailwind CSS 4.x
- **JavaScript:** Alpine.js (lightweight reactivity)
- **Build Tool:** Vite
- **Icons:** Heroicons

### External Services

- **Image Storage:** Cloudinary (cloud CDN)
- **Real-time:** Firebase Realtime Database (WebSocket notifications)
- **Email:** SMTP (Gmail configured)
- **AI Translation:** OpenRouter API
- **Database (optional):** Firebase Realtime Database

### Development Tools

- **Containerization:** Docker + Docker Compose
- **Package Manager:** Composer (PHP), NPM (JavaScript)
- **Code Quality:** Laravel Pint (code style)
- **Testing:** PHPUnit
- **Database Admin:** phpMyAdmin (Docker)

### Production Requirements

- **PHP:** >= 8.2
- **MySQL:** >= 8.0 (or MariaDB >= 10.3)
- **Extensions:** BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- **Composer:** Latest version
- **Node.js:** >= 18 (for asset compilation)

---

## 📊 Database Schema & ERD

### Entity-Relationship Diagram

```
┌──────────────┐         ┌──────────────┐         ┌──────────────┐
│    USERS     │1      1 │    SHOPS     │1      ∞ │   PRODUCTS   │
│──────────────│────────▶│──────────────│────────▶│──────────────│
│ id (PK)      │         │ id (PK)      │         │ id (PK)      │
│ name         │         │ user_id (FK) │         │ shop_id (FK) │
│ email        │         │ name         │         │ name         │
│ password     │         │ description  │         │ price        │
│ phone_number │         │ business_type│         │ category     │
│ role         │         │ product_type │         │ image        │
│ email_verified         │ region_id(FK)│         │ variant      │
│ place_of_birth         │ address      │         │ description  │
│ date_of_birth│         │ latitude     │         │ is_active    │
│ domicile_addr│         │ longitude    │         │ is_best_seller
└──────────────┘         │ omset_min    │         └──────────────┘
                         │ omset_max    │                │1
                         │ logo         │                │
                         │ is_verified  │                │∞
                         │ rejection_   │         ┌───────────────┐
                         │  reason      │         │ PRODUCT_      │
                         │ licenses     │         │  IMAGES       │
                         │ social_*     │         │───────────────│
                         │ views        │         │ id (PK)       │
                         └──────────────┘         │ product_id(FK)│
                                │1                │ image         │
                                │                 │ sort_order    │
                                │∞                └───────────────┘
                         ┌──────────────┐
                         │ SHOP_PHOTOS  │
                         │──────────────│
                         │ id (PK)      │
                         │ shop_id (FK) │
                         │ path         │
                         │ order        │
                         └──────────────┘

┌──────────────┐         ┌──────────────┐
│   REGIONS    │1      ∞ │    SHOPS     │
│──────────────│◀────────│ (see above)  │
│ id (PK)      │         └──────────────┘
│ name         │
│ image        │         ┌──────────────┐
│ latitude     │         │  CONTENTS    │
│ longitude    │         │──────────────│
│ featured_shop│         │ id (PK)      │
│  _id (FK)    │         │ key          │
│ hero_order   │         │ value        │
└──────────────┘         │ type         │
                         │ group        │
                         │ label        │
                         └──────────────┘

┌──────────────┐
│ TRANSLATIONS │
│──────────────│
│ id (PK)      │
│ text         │
│ language     │
│ translated   │
└──────────────┘
```

### Table Descriptions

#### 1. **users** - User Accounts

| Column            | Type            | Nullable | Description                  |
| ----------------- | --------------- | -------- | ---------------------------- |
| id                | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| name              | VARCHAR(255)    | NO       | Full name                    |
| email             | VARCHAR(255)    | NO       | Unique email address         |
| password          | VARCHAR(255)    | NO       | Hashed password (bcrypt)     |
| phone_number      | VARCHAR(20)     | YES      | Contact number               |
| role              | VARCHAR(50)     | NO       | 'admin' or 'users'           |
| email_verified_at | TIMESTAMP       | YES      | Email verification timestamp |
| place_of_birth    | VARCHAR(255)    | YES      | Birth place                  |
| date_of_birth     | DATE            | YES      | Birth date                   |
| domicile_address  | TEXT            | YES      | Current address              |
| remember_token    | VARCHAR(100)    | YES      | Session token                |
| created_at        | TIMESTAMP       | YES      | Record creation              |
| updated_at        | TIMESTAMP       | YES      | Last update                  |

**Indexes:**

- PRIMARY KEY: `id`
- UNIQUE: `email`

**Relationships:**

- Has One: `shops`

---

#### 2. **shops** - Business Profiles

| Column           | Type            | Nullable | Description                                |
| ---------------- | --------------- | -------- | ------------------------------------------ |
| id               | BIGINT UNSIGNED | NO       | Primary key (auto-increment)               |
| user_id          | BIGINT UNSIGNED | NO       | Foreign key to users                       |
| name             | VARCHAR(255)    | NO       | Business name                              |
| description      | TEXT            | YES      | Business description                       |
| product_type     | VARCHAR(255)    | YES      | Main product category                      |
| business_type    | VARCHAR(255)    | YES      | Business classification                    |
| region_id        | BIGINT UNSIGNED | YES      | Foreign key to regions                     |
| address          | TEXT            | YES      | Full address                               |
| latitude         | DECIMAL(10,8)   | YES      | GPS latitude                               |
| longitude        | DECIMAL(11,8)   | YES      | GPS longitude                              |
| omset_min        | BIGINT          | YES      | Minimum revenue                            |
| omset_max        | BIGINT          | YES      | Maximum revenue                            |
| logo             | VARCHAR(500)    | YES      | Logo image path (Cloudinary)               |
| is_verified      | BOOLEAN         | NO       | Admin verification status (default: false) |
| rejection_reason | TEXT            | YES      | Admin rejection message                    |
| licenses         | JSON            | YES      | Business licenses array                    |
| social_instagram | VARCHAR(255)    | YES      | Instagram URL/username                     |
| social_tiktok    | VARCHAR(255)    | YES      | TikTok URL/username                        |
| social_facebook  | VARCHAR(255)    | YES      | Facebook URL/username                      |
| social_website   | VARCHAR(255)    | YES      | Website URL                                |
| views            | INTEGER         | NO       | View counter (default: 0)                  |
| created_at       | TIMESTAMP       | YES      | Record creation                            |
| updated_at       | TIMESTAMP       | YES      | Last update                                |

**Indexes:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` → users(id) ON DELETE CASCADE
- FOREIGN KEY: `region_id` → regions(id) ON DELETE SET NULL
- INDEX: `is_verified` (filtering)
- INDEX: `business_type` (filtering)
- INDEX: `views` (sorting)
- FULLTEXT: `name, description` (search)

**Relationships:**

- Belongs To: `users`, `regions`
- Has Many: `products`, `shop_photos`

---

#### 3. **products** - Shop Products

| Column         | Type            | Nullable | Description                       |
| -------------- | --------------- | -------- | --------------------------------- |
| id             | BIGINT UNSIGNED | NO       | Primary key (auto-increment)      |
| shop_id        | BIGINT UNSIGNED | NO       | Foreign key to shops              |
| name           | VARCHAR(255)    | NO       | Product name                      |
| price          | DECIMAL(12,2)   | NO       | Product price                     |
| category       | VARCHAR(255)    | NO       | Product category                  |
| image          | VARCHAR(500)    | YES      | Main image path (Cloudinary)      |
| variant        | VARCHAR(255)    | YES      | Product variant                   |
| description    | TEXT            | YES      | Product description               |
| is_active      | BOOLEAN         | NO       | Active status (default: true)     |
| is_best_seller | BOOLEAN         | NO       | Best seller flag (default: false) |
| created_at     | TIMESTAMP       | YES      | Record creation                   |
| updated_at     | TIMESTAMP       | YES      | Last update                       |

**Indexes:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `shop_id` → shops(id) ON DELETE CASCADE
- INDEX: `is_active` (filtering)
- INDEX: `is_best_seller` (filtering)

**Relationships:**

- Belongs To: `shops`
- Has Many: `product_images`

---

#### 4. **product_images** - Product Gallery

| Column     | Type            | Nullable | Description                  |
| ---------- | --------------- | -------- | ---------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| product_id | BIGINT UNSIGNED | NO       | Foreign key to products      |
| image      | VARCHAR(500)    | NO       | Image path (Cloudinary)      |
| sort_order | INTEGER         | NO       | Display order (default: 0)   |
| created_at | TIMESTAMP       | YES      | Record creation              |
| updated_at | TIMESTAMP       | YES      | Last update                  |

**Indexes:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `product_id` → products(id) ON DELETE CASCADE
- INDEX: `sort_order` (ordering)

**Relationships:**

- Belongs To: `products`

---

#### 5. **shop_photos** - Shop Photo Gallery

| Column     | Type            | Nullable | Description                  |
| ---------- | --------------- | -------- | ---------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| shop_id    | BIGINT UNSIGNED | NO       | Foreign key to shops         |
| path       | VARCHAR(500)    | NO       | Image path (Cloudinary)      |
| order      | INTEGER         | NO       | Display order (default: 0)   |
| created_at | TIMESTAMP       | YES      | Record creation              |
| updated_at | TIMESTAMP       | YES      | Last update                  |

**Indexes:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `shop_id` → shops(id) ON DELETE CASCADE
- INDEX: `order` (ordering)

**Relationships:**

- Belongs To: `shops`

---

#### 6. **regions** - Geographic Areas

| Column           | Type            | Nullable | Description                  |
| ---------------- | --------------- | -------- | ---------------------------- |
| id               | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| name             | VARCHAR(255)    | NO       | Region name                  |
| image            | VARCHAR(500)    | YES      | Region image (Cloudinary)    |
| latitude         | DECIMAL(10,8)   | YES      | GPS latitude                 |
| longitude        | DECIMAL(11,8)   | YES      | GPS longitude                |
| featured_shop_id | BIGINT UNSIGNED | YES      | Foreign key to shops         |
| hero_order       | INTEGER         | YES      | Homepage carousel order      |
| created_at       | TIMESTAMP       | YES      | Record creation              |
| updated_at       | TIMESTAMP       | YES      | Last update                  |

**Indexes:**

- PRIMARY KEY: `id`
- FOREIGN KEY: `featured_shop_id` → shops(id) ON DELETE SET NULL
- INDEX: `hero_order` (ordering)

**Relationships:**

- Has Many: `shops`
- Belongs To: `shops` (featured shop)

---

#### 7. **contents** - CMS Content

| Column     | Type            | Nullable | Description                   |
| ---------- | --------------- | -------- | ----------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment)  |
| key        | VARCHAR(255)    | NO       | Unique content identifier     |
| value      | LONGTEXT        | YES      | Content value                 |
| type       | VARCHAR(50)     | NO       | 'text', 'image', 'json', etc. |
| group      | VARCHAR(100)    | YES      | Content grouping              |
| label      | VARCHAR(255)    | YES      | Human-readable label          |
| created_at | TIMESTAMP       | YES      | Record creation               |
| updated_at | TIMESTAMP       | YES      | Last update                   |

**Indexes:**

- PRIMARY KEY: `id`
- UNIQUE: `key`
- INDEX: `group` (filtering)

**Relationships:**

- None (standalone content)

---

#### 8. **translations** - Translation Cache

| Column     | Type            | Nullable | Description                  |
| ---------- | --------------- | -------- | ---------------------------- |
| id         | BIGINT UNSIGNED | NO       | Primary key (auto-increment) |
| text       | TEXT            | NO       | Original text                |
| language   | VARCHAR(10)     | NO       | Target language code         |
| translated | TEXT            | NO       | Translated text              |
| created_at | TIMESTAMP       | YES      | Record creation              |
| updated_at | TIMESTAMP       | YES      | Last update                  |

**Indexes:**

- PRIMARY KEY: `id`
- UNIQUE: `text (hash), language` (prevent duplicates)

**Relationships:**

- None (translation cache)

---

### Laravel System Tables

- **cache** & **cache_locks** - Cache storage
- **sessions** - User session storage
- **jobs** & **job_batches** - Queue system
- **failed_jobs** - Failed queue job logging
- **password_reset_tokens** - Password reset storage

### Database Relationships Summary

```
users (1) ────▶ shops (1) ────▶ products (∞) ────▶ product_images (∞)
                  │
                  └────▶ shop_photos (∞)
                  │
regions (1) ──────┘

regions (1) ──featured──▶ shops (1)

contents (standalone)
translations (standalone)
```

---

## ⚙️ Environment Configuration

### Required .env Variables

#### Application Settings

```env
APP_NAME="UMKM Sasuma"
APP_ENV=production                    # local, staging, production
APP_KEY=base64:YOUR_32_CHAR_KEY      # php artisan key:generate
APP_DEBUG=false                       # MUST be false in production
APP_URL=https://yourdomain.com        # Your actual domain

APP_LOCALE=id                         # Default language (id/en)
APP_FALLBACK_LOCALE=en               # Fallback language
```

#### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1                    # Or your MySQL host
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### Mail Configuration (Email Verification)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com             # Or your SMTP provider
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password      # Gmail: App Password required
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Gmail Setup:**

1. Enable 2-Factor Authentication
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Use App Password in `MAIL_PASSWORD`

#### Cloudinary Configuration (Image Storage)

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
```

**Get Credentials:**

1. Sign up at https://cloudinary.com
2. Dashboard → Account Details
3. Copy Cloud Name, API Key, API Secret

**Get Credentials:**

1. Sign up at https://Firebase
2. Create new app → Select cluster
3. Copy App ID, Key, Secret from App Keys tab

#### Firebase Realtime Database Configuration

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
FIREBASE_API_KEY=your_firebase_api_key
FIREBASE_AUTH_DOMAIN=your-project.firebaseapp.com
FIREBASE_PROJECT_ID=your-project-id
FIREBASE_STORAGE_BUCKET=your-project.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your_sender_id
FIREBASE_APP_ID=your_app_id

VITE_FIREBASE_API_KEY="${FIREBASE_API_KEY}"
VITE_FIREBASE_AUTH_DOMAIN="${FIREBASE_AUTH_DOMAIN}"
VITE_FIREBASE_DATABASE_URL="${FIREBASE_DATABASE_URL}"
VITE_FIREBASE_PROJECT_ID="${FIREBASE_PROJECT_ID}"
VITE_FIREBASE_STORAGE_BUCKET="${FIREBASE_STORAGE_BUCKET}"
VITE_FIREBASE_MESSAGING_SENDER_ID="${FIREBASE_MESSAGING_SENDER_ID}"
VITE_FIREBASE_APP_ID="${FIREBASE_APP_ID}"
```

**Get Credentials:**

1. Go to https://console.firebase.google.com
2. Create or select your project
3. Project Settings → General → Your apps
4. Click "Add app" (Web) if you haven't already
5. Copy your Firebase configuration values
6. Enable Realtime Database in Firebase Console → Build → Realtime Database

---

#### OpenRouter API (AI Translation)

```env
OPENROUTER_API_KEY=sk-or-v1-your_api_key
```

**Get API Key:**

1. Sign up at https://openrouter.ai
2. Account → API Keys → Create Key
3. Add credits to account

#### Session & Cache

```env
SESSION_DRIVER=database               # Use database for shared hosting
SESSION_LIFETIME=120                  # Minutes

CACHE_STORE=database                  # Use database for shared hosting
```

#### Queue Configuration

```env
QUEUE_CONNECTION=database             # Use database for shared hosting
```

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
```

---

### Optional .env Variables

```env
# Logging
LOG_CHANNEL=stack
LOG_LEVEL=error                       # debug, info, warning, error

# Security
BCRYPT_ROUNDS=12                      # Password hashing cost

# File Storage
FILESYSTEM_DISK=local                 # local or cloudinary

# Vite (Development)
VITE_DEV_SERVER_URL=http://localhost:5173
```

---

## 📦 Installation

### Local Development (Docker)

#### Prerequisites

- Docker Desktop installed
- Docker Compose installed
- Git

#### Steps

**1. Clone Repository**

```bash
git clone <your-repo-url>
cd umkm_project
```

**2. Start Docker Containers**

```bash
docker-compose up -d
```

This starts:

- **Laravel App:** http://localhost:8000
- **MySQL:** localhost:3307
- **phpMyAdmin:** http://localhost:8001
- **Vite Dev Server:** http://localhost:5174

**3. Access Laravel Container**

```bash
docker exec -it laravel_app bash
```

**4. Install Dependencies**

```bash
# Inside container
composer install
npm install
```

**5. Configure Environment**

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` with Docker settings (already configured):

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=sasuma_db
DB_USERNAME=umkm
DB_PASSWORD=umkm_sasuma
```

**6. Run Migrations**

```bash
php artisan migrate
```

**7. Seed Database** (Creates test user)

```bash
php artisan db:seed
```

Default credentials:

- Email: `test@example.com`
- Password: `password`

**8. Link Storage**

```bash
php artisan storage:link
```

**9. Build Frontend Assets**

```bash
npm run build
```

**10. Start Queue Worker** (Optional, for background jobs)

```bash
# In separate terminal inside container
php artisan queue:work
```

**11. Access Application**

- Frontend: http://localhost:8000
- phpMyAdmin: http://localhost:8001 (user: `umkm`, pass: `umkm_sasuma`)

---

### Shared Hosting Deployment

#### Prerequisites

- cPanel or similar hosting panel
- PHP >= 8.2
- MySQL >= 8.0
- Composer access (SSH or panel)
- Domain configured

#### Steps

**1. Prepare Local Build**

```bash
# On your local machine
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

**2. Upload Files via FTP/SFTP**

Upload these directories:

```
├── app/
├── bootstrap/
├── config/
├── database/
├── lang/
├── public/          ← Document root
├── resources/
├── routes/
├── storage/         ← Set permissions 755
├── vendor/
├── .env.example
├── artisan
├── composer.json
└── composer.lock
```

**DO NOT upload:**

- `.env` (create manually)
- `node_modules/`
- `.git/`
- `tests/`
- `docker/`
- `docker-compose.yml`

**3. Configure Document Root**

Point your domain to `/public` directory:

```
Domain: yourdomain.com → /public_html/public
```

**4. Create .env File**

In hosting file manager or SSH:

```bash
cd /home/yourusername/public_html
cp .env.example .env
nano .env  # or use file manager editor
```

Fill in production values (see Environment Configuration section).

**5. Set Directory Permissions**

```bash
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs
```

**6. Generate Application Key**

```bash
php artisan key:generate
```

**7. Create Database**

In cPanel → MySQL Databases:

1. Create database: `yourusername_umkm`
2. Create user: `yourusername_umkm`
3. Set password (strong password)
4. Grant all privileges to user
5. Update `.env` with credentials

**8. Run Migrations**

```bash
php artisan migrate --force
```

**9. Seed Database**

```bash
php artisan db:seed --force
```

**10. Reset Auto-Increment (Important!)**

```bash
php artisan db:reset-autoincrement
```

**11. Link Storage**

```bash
php artisan storage:link
```

**12. Clear & Cache Configuration**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**13. Set Ownership** (if using SSH)

```bash
chown -R yourusername:yourusername /home/yourusername/public_html
```

**14. Configure .htaccess** (Usually automatic)

If needed, create `/public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**15. Test Application**

Visit: `https://yourdomain.com`

---

#### Post-Deployment Checklist

- ✅ Homepage loads without errors
- ✅ Registration works
- ✅ Email verification sends
- ✅ Login works
- ✅ Images upload to Cloudinary
- ✅ Admin panel accessible
- ✅ Database connections stable
- ✅ Sitemap generates: `/sitemap.xml`
- ✅ Robots.txt exists: `/robots.txt`

---

#### Updating Application

```bash
# 1. Backup database (cPanel → phpMyAdmin → Export)

# 2. Upload new files (overwrite existing)

# 3. Run migrations
php artisan migrate --force

# 4. Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 5. Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🔄 Application Logic & Flow

### User Registration & Verification Flow

```
1. User visits /register
   ↓
2. Fills registration form (name, email, password, phone, birth details, address)
   ↓
3. System creates User account (role = 'users', unverified)
   ↓
4. System creates empty Shop record (associated with user_id)
   ↓
5. System sends verification email
   ↓
6. User clicks email link → email_verified_at set
   ↓
7. User redirected to /users/dashboard
```

### Shop Creation & Verification Flow

```
User (Verified) → Dashboard
   ↓
1. Navigate to "Lokasi" (Location)
   - Select region from dropdown
   - Enter full address
   - Pin location on map (lat/long)
   - Submit
   ↓
2. Navigate to "Edit Toko" (Edit Shop)
   - Enter shop name
   - Enter description
   - Select business type
   - Select product type
   - Enter revenue range (omset_min, omset_max)
   - Upload logo
   - Add social media links
   - Upload business licenses
   - Submit → TranslateShopAttributes job dispatched
   ↓
3. Navigate to "Foto" (Photos)
   - Upload up to 5 shop photos
   - Reorder photos by dragging
   - Submit
   ↓
4. Navigate to "Toko" (Products)
   - Click "Tambah Produk" (Add Product)
   - Enter product details (name, price, category, variant, description)
   - Upload product image
   - Upload additional images (multi-image)
   - Submit
   ↓
5. System checks completeness:
   ✓ Shop name exists
   ✓ Description exists
   ✓ Address exists
   ✓ Lat/Long exists
   ✓ Region selected
   ✓ Business type selected
   ✓ Omset entered
   ✓ At least 1 product
   ✓ At least 1 shop photo
   ↓
6. If complete:
   - Shop appears in admin verification queue
   - Shop status: pending (is_verified = false)
   ↓
7. Admin reviews shop:
   Option A: APPROVE
     - Set is_verified = true
     - ShopUpdated event dispatched (Firebase Realtime Database notification)
     - UserUpdated event dispatched
     - Shop appears on public listing

   Option B: REJECT
     - Set rejection_reason = "Admin message"
     - ShopUpdated event dispatched
     - User sees rejection reason in dashboard
     - User can edit and resubmit
```

### Admin Verification Logic

**Automatic Checks (before admin review):**

- `Shop::isComplete()` method validates:
  - All required fields filled
  - Minimum 1 product exists
  - Minimum 1 photo exists

**Admin Actions:**

- Approve: Shop goes live immediately
- Reject: User notified, can edit and resubmit

**Auto-Revocation Rule:**
If verified shop becomes incomplete (e.g., user deletes all photos):

- `is_verified` automatically set to `false`
- Requires admin re-verification

### Translation Logic

**Automatic Translation (Background Job):**

```
Shop updated/created
   ↓
TranslateShopAttributes job dispatched
   ↓
Check if description translation exists in DB
   ↓
If not: Call OpenRouter API (AI translation)
   ↓
Save translation to translations table
   ↓
Cached for future use
```

### Real-time Notification Logic (Firebase Realtime Database)

**Events & Channels:**

```
Event: ShopUpdated
   ↓
Broadcast to channel: shop.{shop_id}
   ↓
Listeners: Admin dashboard, User dashboard
   ↓
Action: Refresh verification status, update UI

Event: UserUpdated
   ↓
Broadcast to channel: user.{user_id}
   ↓
Listeners: User dashboard
   ↓
Action: Show notification, refresh data
```

### Image Upload Logic

**Cloudinary Upload Flow:**

```
User selects image (form input)
   ↓
Validate file type (image only) and size
   ↓
Upload to Cloudinary via Laravel facade
   ↓
Cloudinary returns:
   - public_id
   - secure_url
   - format
   - dimensions
   ↓
Save secure_url to database
   ↓
Display using storage_url() helper
```

### SEO Sitemap Logic

**Command: `php artisan sitemap:generate`**

```
1. Fetch all verified shops
2. Fetch all active products (with verified shops)
3. Fetch all business types
4. Generate XML with:
   - Static pages (/, /umkm, /login, /register)
   - Business type pages (/umkm?category=X)
   - Shop detail pages (/umkm/{id})
   - Product detail pages (/umkm/product/{id})
5. Add lastmod timestamps
6. Save to /public/sitemap.xml
7. Generate /public/robots.txt with sitemap reference
```

**Run Frequency:** Daily via cronjob

---

## ⏰ Cronjob Configuration

### Required Cronjobs for Shared Hosting

Laravel requires a single cron entry to run the scheduler, which manages all scheduled tasks.

#### 1. Laravel Task Scheduler (Required)

Add this to your crontab:

```cron
* * * * * cd /home/yourusername/public_html && php artisan schedule:run >> /dev/null 2>&1
```

**cPanel Setup:**

1. cPanel → Advanced → Cron Jobs
2. Common Settings: "Every Minute" (\*/1)
3. Command: `cd /home/yourusername/public_html && php artisan schedule:run >> /dev/null 2>&1`
4. Save

**What it does:**

- Runs every minute
- Checks if any scheduled tasks should execute
- Minimal resource usage

---

#### 2. Scheduler Configuration (Sitemap & Maintenance)

The application uses Laravel's scheduler to handle background tasks like sitemap generation and database cleanup.

**Single Cron Job Setup:**

Add this **one** line to your server's crontab (e.g., via CPanel or `crontab -e`) to run all scheduled tasks:

```cron
* * * * * cd /home/yourusername/public_html && php artisan schedule:run >> /dev/null 2>&1
```

_Replace `/home/yourusername/public_html` with the actual path to your project._

**What this handles:**

1. **Sitemap Generation:** Runs daily at 02:00 AM.
2. **Translation Cleanup:** Runs weekly (Sundays at 03:00 AM).

**Manual Triggers:**

```bash
# Generate Sitemap Immediately
php artisan sitemap:generate

# Clean Translations Immediately
php artisan translations:clean
```

**Output:**

- `/public/sitemap.xml` (Google submission)
- `/public/robots.txt` (SEO configuration)

---

#### 3. Queue Worker (For Background Jobs)

**Option A: Continuous Worker (Recommended for VPS)**

```bash
# Keep running in background
nohup php artisan queue:work --sleep=3 --tries=3 --daemon > /dev/null 2>&1 &
```

**Option B: Cron-based (Recommended for Shared Hosting)**

```cron
*/5 * * * * cd /home/yourusername/public_html && php artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

**What it processes:**

- `TranslateShopAttributes` job (shop description translation)
- Email sending (if using queue for mail)
- Image optimization tasks

---

### Verify Cronjobs are Running

**Check Laravel logs:**

```bash
tail -f storage/logs/laravel.log
```

**Test manually:**

```bash
php artisan schedule:list  # View all scheduled tasks
php artisan schedule:run   # Manually trigger scheduler
```

---

## 📝 Commands Reference

### Database Management

```bash
# Run migrations
php artisan migrate

# Run migrations (force, no confirmation - production)
php artisan migrate --force

# Rollback last migration
php artisan migrate:rollback

# Rollback all migrations and re-run
php artisan migrate:fresh

# Seed database with sample data
php artisan db:seed

# Seed specific seeder
php artisan db:seed --class=DatabaseSeeder

```

---

### Application Maintenance

```bash
# Generate application key
php artisan key:generate

# Link storage directory
php artisan storage:link

# Clear all caches
php artisan optimize:clear
# Equivalent to:
# php artisan cache:clear
# php artisan config:clear
# php artisan route:clear
# php artisan view:clear

# Build optimized caches (production)
php artisan optimize
# Equivalent to:
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache
```

---

### Cache Management

```bash
# Clear application cache
php artisan cache:clear

# Clear configuration cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear compiled views cache
php artisan view:clear

# Cache configuration (production)
php artisan config:cache

# Cache routes (production)
php artisan route:cache

# Cache views (production)
php artisan view:cache
```

---

### Queue Management

```bash
# Start queue worker (foreground)
php artisan queue:work

# Start queue worker with options
php artisan queue:work --sleep=3 --tries=3 --timeout=90

# Process all jobs then stop (shared hosting)
php artisan queue:work --stop-when-empty

# List failed jobs
php artisan queue:failed

# Retry all failed jobs
php artisan queue:retry all

# Retry specific failed job
php artisan queue:retry {id}

# Flush all failed jobs
php artisan queue:flush
```

---

### SEO & Sitemap

```bash
# Generate sitemap.xml and robots.txt
php artisan sitemap:generate
```

**Output:**

- `/public/sitemap.xml`
- `/public/robots.txt`

---

### Development Tools

```bash
# Start development server
php artisan serve
# Access at: http://localhost:8000

# Watch logs in real-time
php artisan pail

# List all routes
php artisan route:list

# List all scheduled tasks
php artisan schedule:list

# Run scheduler manually (testing)
php artisan schedule:run

# Laravel Tinker (REPL)
php artisan tinker

# Run tests
php artisan test
```

---

### Composer Commands

```bash
# Install dependencies
composer install

# Install dependencies (production, optimized)
composer install --optimize-autoloader --no-dev

# Update dependencies
composer update

# Dump autoload (after adding new classes)
composer dump-autoload
```

---

### NPM Commands

```bash
# Install dependencies
npm install

# Development build (watch for changes)
npm run dev

# Production build (optimized)
npm run build

# Preview production build
npm run preview
```

---

## 📁 Project Structure

```
umkm_project/
├── docker/                      # Docker configuration files
│   └── php/
│       └── Dockerfile
├── docker-compose.yml           # Docker orchestration
│
└── laravel_app/                 # Laravel application root
    ├── app/
    │   ├── Console/
    │   │   ├── Commands/
    │   │   │   ├── GenerateSitemap.php        # SEO sitemap generator
    │   │   │   └── CleanTranslations.php      # Translation cleanup
    │   │
    │   ├── Events/                # Firebase Realtime Database broadcast events
    │   │   ├── ContentUpdated.php
    │   │   ├── ProductUpdated.php
    │   │   ├── SettingsUpdated.php
    │   │   ├── ShopUpdated.php
    │   │   └── UserUpdated.php
    │   │
    │   ├── Helpers/
    │   │   └── helpers.php         # Global helper functions
    │   │
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── Admin/
    │   │   │   │   ├── ContentController.php   # CMS management
    │   │   │   │   └── RegionController.php    # Region management
    │   │   │   ├── Auth/                      # Laravel Breeze auth
    │   │   │   ├── AdminDashboardController.php
    │   │   │   ├── HomeController.php
    │   │   │   ├── ProfileController.php
    │   │   │   ├── PublicController.php       # Shop directory
    │   │   │   └── UserDashboardController.php
    │   │   │
    │   │   ├── Middleware/
    │   │   │   └── CheckRole.php              # Role-based access
    │   │   │
    │   │   └── Requests/
    │   │       └── ProfileUpdateRequest.php
    │   │
    │   ├── Jobs/
    │   │   └── TranslateShopAttributes.php    # Background translation
    │   │
    │   ├── Models/                # Eloquent models
    │   │   ├── Content.php
    │   │   ├── Product.php
    │   │   ├── ProductImage.php
    │   │   ├── Region.php
    │   │   ├── Shop.php
    │   │   ├── ShopPhoto.php
    │   │   ├── Translation.php
    │   │   └── User.php
    │   │
    │   └── Services/
    │       ├── ImageService.php               # Cloudinary integration
    │       └── TranslationService.php         # OpenRouter AI translation
    │
    ├── bootstrap/                # Application bootstrap
    │   ├── app.php
    │   └── cache/                # Framework cache
    │
    ├── config/                   # Configuration files
    │   ├── app.php
    │   ├── cloudinary.php         # Cloudinary config
    │   ├── database.php
    │   ├── services.php
    │   └── ...
    │
    ├── database/
    │   ├── migrations/           # Database migrations (32 files)
    │   └── seeders/
    │       └── DatabaseSeeder.php
    │
    ├── lang/                     # Translations (id, en)
    │   ├── en/
    │   └── id/
    │
    ├── public/                   # Web server document root
    │   ├── build/                # Compiled assets (Vite)
    │   ├── images/               # Static images
    │   ├── robots.txt            # SEO robots file
    │   ├── sitemap.xml           # Generated sitemap
    │   └── index.php             # Application entry point
    │
    ├── resources/
    │   ├── css/
    │   │   └── app.css           # Tailwind CSS
    │   ├── js/
    │   │   ├── app.js
    │   │   └── bootstrap.js      # Firebase Realtime Database initialization
    │   └── views/                # Blade templates
    │       ├── admin/            # Admin panel views
    │       ├── auth/             # Authentication views (Breeze)
    │       ├── components/       # Reusable components
    │       ├── home/             # Homepage
    │       ├── umkm/             # Public shop directory
    │       └── users/            # User dashboard
    │
    ├── routes/
    │   ├── console.php           # Artisan commands
    │   └── web.php               # Web routes
    │
    ├── storage/                  # Storage directory (writable)
    │   ├── app/
    │   ├── framework/
    │   └── logs/
    │
    ├── tests/                    # PHPUnit tests
    │
    ├── .env.example              # Environment template
    ├── artisan                   # Artisan CLI
    ├── composer.json             # PHP dependencies
    ├── package.json              # NPM dependencies
    ├── vite.config.js            # Vite build config
    └── README.md                 # This file
```

---

## 🔌 API & External Services

### Cloudinary (Image CDN)

**Purpose:** Cloud-based image storage and delivery

**Configuration:**

```env
CLOUDINARY_CLOUD_NAME=your_cloud_name
CLOUDINARY_API_KEY=your_api_key
CLOUDINARY_API_SECRET=your_api_secret
```

**Usage in Code:**

```php
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

// Upload image
$result = Cloudinary::upload($request->file('image')->getRealPath());
$url = $result->getSecurePath();

// Delete image
Cloudinary::destroy($publicId);
```

**Features Used:**

- Auto format (WebP)
- Auto quality optimization
- Responsive srcsets
- Transformation on-the-fly

**Documentation:** https://cloudinary.com/documentation/laravel_integration

---

### Firebase Realtime Database (Real-time Notifications)

**Purpose:** WebSocket-based real-time notifications

**Events Broadcast:**

- `ShopUpdated` - Shop verification status changes
- `UserUpdated` - User profile updates
- `ContentUpdated` - CMS content changes
- `ProductUpdated` - Product modifications

**Usage in Code:**

```php
// Broadcasting event
use App\Events\ShopUpdated;

event(new ShopUpdated($shop));
```

```javascript
// Listening in frontend
window.Echo.channel("shop." + shopId).listen("ShopUpdated", (e) => {
  // Update UI
});
```

**Documentation:** https://Firebase/docs/channels

---

### OpenRouter AI (Translation)

**Purpose:** AI-powered language translation

**Configuration:**

```env
OPENROUTER_API_KEY=sk-or-v1-your_api_key
```

**Usage in Code:**

```php
use App\Services\TranslationService;

$translationService = new TranslationService();
$translated = $translationService->translate($text, 'en');
```

**Features:**

- Indonesian to English translation
- Cached translations (database)
- Background job processing

**Documentation:** https://openrouter.ai/docs

---

### Gmail SMTP (Email)

**Purpose:** Email verification and notifications

**Configuration:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password  # App Password!
```

**Setup:**

1. Enable 2FA on Gmail
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Use App Password in `.env`

**Emails Sent:**

- Email verification
- Password reset
- Shop verification notifications

**Documentation:** https://support.google.com/accounts/answer/185833

---

### Firebase Realtime Database (Optional)

**Purpose:** Optional real-time data sync

**Configuration:**

```env
FIREBASE_DATABASE_URL=https://your-project.firebaseio.com
```

**Note:** Currently optional and not required for core functionality.

---

## 🐛 Troubleshooting

### Common Issues

#### 1. **Images not uploading / Cloudinary error**

**Symptoms:**

- Upload button doesn't work
- Error: "Cloudinary credentials not configured"

**Solutions:**

```bash
# Check .env has Cloudinary credentials
grep CLOUDINARY .env

# Clear config cache
php artisan config:clear
php artisan config:cache

# Test Cloudinary connection
php artisan tinker
> Cloudinary::upload('/path/to/test-image.jpg');
```

---

#### 2. **Auto-increment gaps after deletion**

**Symptoms:**

- IDs jump (e.g., 1, 2, 10, 15)
- Deleted IDs not reused

**Solution:**

```bash
# Reset auto-increment counters
php artisan db:reset-autoincrement

# Preview changes first
php artisan db:reset-autoincrement --dry-run

# Reset specific table
php artisan db:reset-autoincrement --table=shops
```

---

#### 3. **Queue jobs not processing**

**Symptoms:**

- Translation jobs stuck
- Jobs table growing

**Solutions:**

```bash
# Check jobs table
php artisan queue:failed

# Start queue worker
php artisan queue:work

# Retry failed jobs
php artisan queue:retry all

# For shared hosting, add cronjob:
*/5 * * * * cd /path/to/app && php artisan queue:work --stop-when-empty
```

---

#### 4. **Email verification not sending**

**Symptoms:**

- No email received
- Email stuck in queue

**Solutions:**

```bash
# Check mail configuration
grep MAIL .env

# Test email sending
php artisan tinker
> Mail::raw('Test', function($msg) { $msg->to('test@example.com')->subject('Test'); });

# Check logs
tail -f storage/logs/laravel.log

# For Gmail: Use App Password, not regular password
```

---

#### 5. **Firebase Realtime Database notifications not working**

**Symptoms:**

- No real-time updates
- Console errors: "Firebase Realtime Database connection failed"

**Solutions:**

```bash
# Rebuild frontend assets
npm run build

# Check browser console for errors

# Verify Firebase Realtime Database app is active on Firebase dashboard
```

---

#### 6. **404 errors on shared hosting**

**Symptoms:**

- Homepage works, other pages show 404
- `.htaccess` not working

**Solutions:**

```bash
# Ensure document root points to /public
# In cPanel: Domains → domain → Document Root: /public_html/public

# Check .htaccess exists in /public
cat public/.htaccess

# Enable mod_rewrite (contact hosting support if disabled)

# Clear route cache
php artisan route:clear
php artisan route:cache
```

---

#### 7. **Permission denied errors**

**Symptoms:**

- "Permission denied" when writing logs
- "Failed to create directory"

**Solutions:**

```bash
# Fix permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage/logs

# Fix ownership (SSH only)
chown -R yourusername:yourusername storage bootstrap/cache
```

---

#### 8. **Database connection refused**

**Symptoms:**

- "Connection refused"
- "SQLSTATE[HY000] [2002]"

**Solutions:**

```bash
# Check database credentials in .env
grep DB_ .env

# Verify database exists
mysql -u username -p
> SHOW DATABASES;

# Check MySQL is running
service mysql status  # VPS
# Contact hosting support for shared hosting

# Clear config cache
php artisan config:clear
```

---

#### 9. **Sitemap not generating**

**Symptoms:**

- `/sitemap.xml` returns 404
- Command fails silently

**Solutions:**

```bash
# Run sitemap generation manually
php artisan sitemap:generate

# Check permissions on /public
chmod 755 public

# Verify shops exist
php artisan tinker
> Shop::where('is_verified', true)->count();

# Check logs
tail -f storage/logs/laravel.log
```

---

#### 10. **Translation not working**

**Symptoms:**

- Shop descriptions not translated
- OpenRouter API errors

**Solutions:**

```bash
# Check API key
grep OPENROUTER_API_KEY .env

# Test translation
php artisan tinker
> $service = new App\Services\TranslationService();
> $service->translate('Test teks', 'en');

# Check OpenRouter credits at openrouter.ai

# Manually trigger translation job
php artisan tinker
> dispatch(new App\Jobs\TranslateShopAttributes($shop));
```

---

### Getting Help

If issues persist:

1. **Check Laravel logs:**

   ```bash
   tail -f storage/logs/laravel.log
   ```

2. **Enable debug mode temporarily:**

   ```env
   APP_DEBUG=true  # .env file
   ```

   **Remember to disable after debugging!**

3. **Check server requirements:**

   ```bash
   php -v  # Should be >= 8.2
   php -m  # Check extensions
   composer diagnose
   ```

4. **Contact Information:**
   - Project Repository: [Your GitHub URL]
   - Laravel Documentation: https://laravel.com/docs
   - Stack Overflow: Tag questions with `laravel` and `umkm-sasuma`

---

## 📄 License

This project is licensed under the MIT License.

---

## 👥 Credits

**Developed by:** [Your Name/Team]

**Built with:**

- Laravel Framework - https://laravel.com
- Tailwind CSS - https://tailwindcss.com
- Alpine.js - https://alpinejs.dev
- Cloudinary - https://cloudinary.com
- Firebase Realtime Database - https://Firebase
- OpenRouter AI - https://openrouter.ai

---

## 📞 Support

For deployment support or questions:

- **Email:** [your-email@example.com]
- **Documentation:** This README.md
- **Issues:** [Your GitHub Issues URL]

---

**Last Updated:** February 03, 2026

**Version:** 1.1.0
