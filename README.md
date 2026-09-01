# 📅 Koninklijke Harmonie Lentekrans Linne



## ✨ Kenmerken

- **📆 Agenda Beheer** – Voeg, bewerk en verwijder evenementen met een intuïtief dashboard.
- **🎨 Categorieën** – Organiseer evenementen in kleurgecodeerde categorieën (bijv. *LOL*, *KHLL*, *Activiteiten*).
- **📸 Afbeeldingen Uploaden** – Voeg posters of afbeeldingen toe aan evenementen (ondersteunt JPG, PNG, GIF, max. 2MB).
- **⏰ Publicatiebeheer** – Plan evenementen in de toekomst en stel een publicatiedatum in.
- **🔍 Filteren & Zoeken** – Filter evenementen op status (concept, gepubliceerd, geannuleerd) en categorie.
- **👀 Voorbeeldmodus voor Admins** – Bekijk nog niet-gepubliceerde evenementen als administrator.
- **📱 Responsief Design** – Werkt naadloos op desktop, tablet en mobiel.
- **🌐 API-gedreven** – Backend REST API maakt integratie met andere apps mogelijk (bv. Flutter mobiele app).

---

## 🛠️ Technologieën

### Backend
- **Laravel** (PHP 8.1+) – Robuust framework voor de API en admin backend.
- **MySQL** / **SQLite** – Database voor evenementen en gebruikersgegevens.
- **Laravel Sanctum** – Authenticatie en API token beheer.

### Frontend
- **Vue.js 3** – Progressief JavaScript framework voor de gebruikersinterface.
- **Inertia.js** – Verbindt Laravel met Vue zonder complexe API-aanroepen.
- **Tailwind CSS** – Utility-first CSS voor een strak en consistent design.
- **Axios** – HTTP client voor API-communicatie.

### Extra’s
- **Flutter** (optioneel) – Mobiele companion app voor evenementenweergave (zie `music_sheet_sorter`).

---

## 🚀 Installatie

### Vereisten
- PHP >= 8.3
- Composer
- Node.js & NPM
- MySQL of SQLite
- (Optioneel) Flutter SDK voor de mobiele app

### Stappen

1. **Clone de repository**
   ```bash
   git clone https://github.com/jouw-gebruiker/agenda-beheer.git
   cd agenda-beheer
   ```
2. **php.ini aanpassingen**
   ```bash
    # Vereist voor Composer (snellere downloads)
    extension=curl
    # Vereist voor League/Flysystem (bestandssysteem)
    extension=fileinfo
    # Vereist voor Composer (uitpakken van zip-bestanden)
    extension=zip
    # Vereist voor beveiligde verbindingen (SSL/TLS)
    extension=openssl
   
    # Overig
   extension_dir="ext"
    extension=gd
    extension=mbstring
    extension=pdo_mysql
   ```

2. **Backend installeren**
   ```bash
   #verwijder de vendor map en composer.lock als je een bestaande installatie hebt
   #verwijder php.ini-production file
   composer install --prefer-dist --ignore-platform-req=php
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database configureren**
    - Pas de `.env` bestand aan met je database gegevens.
    - Voer migraties en seeders uit:
      ```bash
      php artisan migrate --seed
      ```

4. **Frontend installeren**
   ```bash
   npm install
   npm run build   # Voor productie
   # Of voor ontwikkeling:
   npm run dev
   ```

5. **Start de ontwikkelserver**
   ```bash
   php artisan serve
   ```
   De applicatie is nu beschikbaar op `http://localhost:8000`.

6. **(Optioneel) Mobiele app**  
   Zie de map `music_sheet_sorter` voor de Flutter app. Volg de instructies in de [Flutter README](music_sheet_sorter/README.md).

---

## 🧑‍💻 Gebruik

### Admin Dashboard
- **Inloggen** – Gebruik een admin-account (zie `database/seeders` voor een standaard gebruiker).
- **Agenda Beheren** – Klik op *Nieuw Agenda Item* om een evenement toe te voegen.
- **Evenement Bewerken** – Klik op het potloodicoon op een kaartje om te bewerken.
- **Publiceren** – Stel de status in op *Gepubliceerd* en eventueel een publicatiedatum.

### Publieke Agenda
- Bezoek `/agenda` om alle zichtbare evenementen te bekijken.
- Evenementen worden alleen getoond als de status *gepubliceerd* is én de publicatiedatum is verstreken.
- Administrators zien ook concept- en toekomstige evenementen (met een preview-badge).

---

## 📁 Projectstructuur (beknopt)

```
├── app/                    # Laravel backend
│   ├── Http/
│   │   ├── Controllers/   # API en web controllers
│   │   └── Resources/     # API resources
│   └── Models/            # Eloquent modellen
├── resources/
│   ├── js/
│   │   ├── Pages/         # Vue-pagina's (Admin/Agenda, AgendaDetail)
│   │   ├── Components/    # Herbruikbare Vue-componenten
│   │   └── Layouts/       # Layouts (AdminLayout, MainLayout)
│   └── views/             # Blade templates (Inertia root)
├── routes/
│   └── api.php            # API routes
├── database/
│   ├── migrations/        # Database schema
│   └── seeders/           # Voorbeelddata
└── music_sheet_sorter/    # Flutter mobiele app (optioneel)
```

## 🙏 Credits

- Ontwikkeld met door Casper Vocking
- Icons door [Heroicons](https://heroicons.com/)
