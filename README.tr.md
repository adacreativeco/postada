<div align="center">

# POST ADA

**Yeni Nesil Çoklu Platform Sosyal Medya Otomasyonu & Yapay Zekâ İçerik Stüdyosu**

<p align="center">
  <a href="README.md"><b>English</b></a> • <a href="README.tr.md"><b>Türkçe</b></a>
</p>

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.5-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)](https://livewire.laravel.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![Tests](https://img.shields.io/badge/Tests-22%2F22%20PASS-22C55E?style=for-the-badge)](https://phpunit.de)
[![License](https://img.shields.io/badge/Lisans-Ticari%20%2F%20Gizli-9333EA?style=for-the-badge)](https://adacreative.co)

<br />

POST ADA; kreatif ajanslar, markalar ve modern içerik üreticileri için tasarlanmış yüksek performanslı, çok kiracılı (multi-tenant) bir sosyal medya yönetim, otomasyon ve yapay zekâ içerik üretim platformudur.

</div>

---

## Görsel Vitrin

### 1. Çoklu Platform Editörü & Gerçek Zamanlı Önizleme
9 sosyal medya kanalı (X, LinkedIn, Instagram, TikTok, Facebook, Reddit, YouTube, Telegram, WhatsApp) için platforma özgü format uyarlamaları ve gerçekçi canlı önizleme kartları sunan merkezi editör.

![İçerik Editörü ve Canlı Önizleme](art/composer.png)

---

### 2. Konsolide Analitik & Büyüme Paneli
Takipçi metriklerinin, yayınlama hızının ve kanallar arası performans göstergelerinin anlık takibi.

![Analitik ve Özet Paneli](art/dashboard.png)

---

### 3. Görsel Sosyal Medya Takvimi & Akıllı Zamanlama Matrisi
Özelleştirilebilir zaman yuvalarına göre en uygun paylaşım zamanını otomatik atayan etkileşimli takvim matrisi.

![Görsel Sosyal Medya Takvimi](art/calendar.png)

---

## Temel Yetenekler

- **Merkezi Çoklu Platform İçerik Editörü**
  - 9 büyük sosyal ağ için anlık canlı önizleme: X (Twitter), LinkedIn, Instagram, TikTok, Facebook, Reddit, YouTube, Telegram ve WhatsApp.
  - Platforma özgü kısıtlama doğrulamaları (karakter sayaçları, medya sınırları, format uyarıları).
  - Anında medya yükleme ve çoklu dosya seçimi sunan entegre Medya Kütüphanesi.

- **Yapay Zekâ İçerik Stüdyosu**
  - Google Gemini ve OpenAI GPT-4o modelleriyle otomatik açıklama oluşturma, akıllı hashtag önerileri ve anlık ton adaptasyonu (Profesyonel, Samimi, Yaratıcı, Esprili, Bilgilendirici).
  - Yapay zekâ görsel üretim köprüsü (DALL-E 3 / Imagen).

- **Akıllı Zamanlama & Otomatik Planlama**
  - Kullanıcı tanımlı gün ve saat yuvalarına (`schedule_slots`) göre en uygun zamanı hesaplayan akıllı algoritma.
  - Çoklu hesaplarda eşzamanlı yayınlama sağlayan asenkron kuyruk sistemi.

- **Kapsamlı Analitik & Raporlama Motoru**
  - Tek ekranda toplanan etkileşim verileri, takipçi artış oranları ve platform kırılımları.
  - Otomatik PDF/CSV performans denetim raporu çıktısı.

- **Ekip Yönetimi & Çok Kiracılı Çalışma Alanları**
  - Güvenli çalışma alanı izolasyonu, role dayalı yetkilendirme ve anında ekip değiştirme.

- **Kredi & Ödeme Altyapısı**
  - Otomatik ödeme geçidi entegrasyonu (Shopier) ile paket ve kredi yönetimi.

---

## Desteklenen Sosyal Ağlar

| Platform | Kanal Türü | Önizleme Adaptörü | Limit & Kısıtlamalar |
| :--- | :--- | :--- | :--- |
| **X (Twitter)** | Mikroblog | Tweet kartı ve aksiyon butonları | 280 karakter, 4 medya |
| **LinkedIn** | Profesyonel Ağ | İş gönderisi ve tepki butonları | 3.000 karakter, tek/çoklu görsel |
| **Instagram** | Görsel / Medya | Kare akış gönderisi ve Hikaye mockup | 2.200 karakter, kare oran |
| **TikTok** | Kısa Video | 9:16 dikey tam ekran mockup | 2.200 karakter, dikey video |
| **Facebook** | Sosyal Akış | Sayfa/Grup paylaşım kartı | 63.206 karakter, çoklu medya |
| **Reddit** | Topluluk / Forum | Subreddit tartışma kartı ve oylama | 40.000 karakter, markdown |
| **YouTube** | Topluluk Akışı | Topluluk gönderisi ve görsel banner | 10.000 karakter |
| **Telegram** | Doğrudan Yayın | Doğrulama tikli mesaj balonu | 4.096 karakter |
| **WhatsApp** | Doğrudan Mesaj | İletildi tikli mesaj balonu | 65.536 karakter |

---

## Teknoloji Yığını

| Katman | Teknoloji |
| :--- | :--- |
| **Backend Çatısı** | Laravel 12 (PHP 8.5.x) |
| **Reaktif Arayüz** | Livewire 3 + Alpine.js |
| **Stil & Tasarım Sistemi** | Tailwind CSS v4 + Saf CSS Tasarım Belirteçleri |
| **Veritabanı Motoru** | SQLite (Geliştirme) / MySQL 8.0+ / PostgreSQL (Canlı) |
| **Kuyruk & Önbellek** | Redis / Veritabanı Sürücüsü |
| **Derleme Hattı** | Vite 7 |
| **Test Çatısı** | PHPUnit 11 |

---

## Sistem Gereksinimleri

- **PHP**: `>= 8.3` (`PHP 8.5.x` önerilir)
  - Gerekli Eklentiler: `pdo`, `pdo_sqlite` / `pdo_mysql`, `curl`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- **Composer**: `>= 2.7`
- **Node.js**: `>= 20.x`
- **NPM**: `>= 10.x`

---

## Hızlı Kurulum Rehberi

### 1. Projeyi Klonlayın
```bash
git clone https://github.com/adacreativeco/postada.git
cd postada
```

### 2. Bağımlılıkları Yükleyin
```bash
composer install
npm install
```

### 3. Ortam Dosyasını Hazırlayın
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Veritabanını Hazırlayın ve Migrasyonları Çalıştırın
```bash
touch database/database.sqlite
php artisan migrate
```

### 5. Varlıkları Derleyin
```bash
npm run build
```

### 6. Yerel Sunucuyu Başlatın
```bash
# Terminal 1 - Yerel PHP Sunucusu
php artisan serve --port=8088

# Terminal 2 - Canlı Vite Sunucusu (Geliştirme için isteğe bağlı)
npm run dev

# Terminal 3 - Kuyruk Dinleyicisi
php artisan queue:listen
```

Uygulamaya tarayıcınızdan erişebilirsiniz: `http://localhost:8088`

---

## Ortam Değişkenleri (.env)

`.env` dosyanızda aşağıdaki servis anahtarlarını tanımlayın:

```ini
APP_NAME="POST ADA"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8088

# Veritabanı
DB_CONNECTION=sqlite

# Yapay Zekâ Servisleri
GEMINI_API_KEY=your_gemini_api_key
OPENAI_API_KEY=your_openai_api_key

# Ödeme Altyapısı (Shopier)
SHOPIER_API_KEY=your_shopier_key
SHOPIER_API_SECRET=your_shopier_secret
SHOPIER_WEBSITE_INDEX=1

# Sosyal Medya OAuth Bilgileri
TWITTER_CLIENT_ID=
TWITTER_CLIENT_SECRET=
TWITTER_REDIRECT_URI="${APP_URL}/auth/twitter/callback"

LINKEDIN_CLIENT_ID=
LINKEDIN_CLIENT_SECRET=
LINKEDIN_REDIRECT_URI="${APP_URL}/auth/linkedin/callback"

FACEBOOK_CLIENT_ID=
FACEBOOK_CLIENT_SECRET=
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
```

---

## Test & Kalite Güvencesi

Tüm mimari bileşenler, yetkilendirme akışları, ekip izolasyonu ve arayüz render testleri otomatik olarak test edilmektedir.

```bash
# Tüm testleri çalıştırın
php artisan test

# PHPUnit ikili dosyası ile çalıştırma
vendor/bin/phpunit
```

22 birim ve özellik test paketinin tamamı %100 başarıyla geçmektedir.

---

## Proje Dizin Yapısı

```
postada/
├── app/
│   ├── Http/Controllers/     # Standart HTTP ve OAuth callback denetleyicileri
│   ├── Livewire/             # Reaktif tam sayfa Livewire bileşenleri
│   │   ├── AccountSettings.php
│   │   ├── AISettings.php
│   │   ├── Analytics.php
│   │   ├── Calendar.php
│   │   ├── Dashboard.php
│   │   ├── MediaLibrary.php
│   │   ├── PostEditor.php
│   │   ├── Pricing.php
│   │   ├── ScheduleSettings.php
│   │   ├── SocialManager.php
│   │   └── TeamSettings.php
│   ├── Models/               # Eloquent veri modelleri (User, Post, Team, Package vb.)
│   └── Services/             # İş mantığı servis katmanları
│       ├── AI/               # AIContentService (Gemini / OpenAI köprüsü)
│       ├── Payment/          # PaymentService (Shopier ödeme yaşam döngüsü)
│       ├── Post/             # PostPublishService ve sosyal API bağlayıcıları
│       └── Scheduling/       # AutoScheduleService (akıllı yuva hesaplama)
├── database/
│   ├── migrations/           # Veritabanı şema migrasyonları
│   └── seeders/              # Başlangıç verileri ve paket tohumlayıcıları
├── resources/
│   ├── css/                  # Tasarım belirteçleri ve Tailwind importları
│   ├── js/                   # Ön yüz istemci scriptleri
│   └── views/
│       ├── components/       # Tekrar kullanılabilir Blade bileşenleri (sidebar vb.)
│       └── livewire/         # Livewire şablonları ve platform önizleme kartları
├── routes/
│   ├── web.php               # Uygulama ve webhook rotaları
│   └── console.php           # Zamanlanmış görevler ve artisan komutları
└── tests/
    ├── Feature/              # Uçtan uca kullanıcı senaryoları ve entegrasyon testleri
    └── Unit/                 # Birim ve servis testleri
```

---

## Lisans & Mülkiyet Hakları

Telif Hakkı © ADA Creative Co. Tüm Hakları Saklıdır.  
Bu yazılım ve ilgili dokümantasyon ADA Creative Co.'ya ait ticari ve gizli bir mülktür. Yazılı izin olmaksızın kısmen veya tamamen kopyalanması, dağıtılması veya üçüncü şahıslarla paylaşılması kesinlikle yasaktır.
