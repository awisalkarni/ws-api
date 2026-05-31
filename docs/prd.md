# Waktu Solat API — Product Requirements Document

## Overview

A Malaysian prayer times (Waktu Solat) API that serves daily prayer times by zone. Data is sourced from JAKIM's official e-Solat portal. The system includes a public REST API, an admin panel for managing prayer time data, and an automated crawler to sync data from e-solat.gov.my.

## Target Audience

- Muslim app/web developers in Malaysia who need reliable prayer time data
- Organizations building Islamic lifestyle apps, mosque displays, or IoT azan devices
- Internal admin managing the database

## Features

### 1. Public API (Unauthenticated)

- `GET /api/v1/zones` — List all supported zones
- `GET /api/v1/zones/{zone}` — Get prayer times for a specific zone (default: today; optional query params: `?date=2026-05-31`, `?month=5&year=2026`, `?year=2026`)
- `GET /api/v1/prayer-times/today?zone=SGR01` — Get today's prayer times for a zone
- `GET /api/v1/prayer-times/date/2026-05-31?zone=SGR01` — Get prayer times for a specific date

### 2. Admin Panel (Authenticated)

- Admin login/logout (session-based, web guard)
- Dashboard to view prayer time data
- CRUD for zones
- CRUD for prayer time entries
- Trigger manual crawl/sync from e-Solat
- View crawl history and logs

### 3. Crawler / Sync Command

- Artisan command: `php artisan solat:sync` — Fetches prayer times from e-solat.gov.my for all zones (or a specified zone) for the current year
- Handles the e-Solat session/CSRF token flow
- Stores data in the local database
- Deduplicates entries (no duplicate date+zone rows)
- Rate limiting and error handling for the external API

## Database Schema

### `zones`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | |
| code | string unique | e.g., `JHR01` |
| state | string | e.g., `Johor` |
| description | text | e.g., `Pulau Aur dan Pulau Pemanggil` |
| timestamps | | |

### `prayer_times`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | |
| zone_id | FK → zones.id | |
| date | date | Prayer date |
| imsak | time | |
| subuh | time | |
| syuruk | time | |
| zohor | time | |
| asar | time | |
| maghrib | time | |
| isyak | time | |
| dhuha | time | Calculated: syuruk + ⅓(syuruk − subuh) |
| timestamps | | |
| UNIQUE | (zone_id, date) | No duplicate entries |

#### Dhuha Calculation

Dhuha is not provided by e-Solat and must be calculated locally:

```
dhuha = syuruk + ⅓ × (syuruk − subuh)
```

**Example** (Kuala Lumpur, 12 December 2012):

| Field | Value |
|-------|-------|
| Syuruk | 07:10 |
| Subuh | 05:48 |
| Difference (syuruk − subuh) | 82 minit |
| ⅓ of difference | ~27 minit |
| Dhuha (syuruk + ⅓ diff) | **07:39** |

### `sync_logs`
| Column | Type | Description |
|--------|------|-------------|
| id | bigint PK | |
| zone_code | string | Zone synced |
| year | int | Year synced |
| status | string | success, failed |
| records_created | int | |
| error_message | text nullable | |
| timestamps | | |

## API Response Format

```json
{
  "data": {
    "zone": "SGR01",
    "state": "Selangor",
    "description": "Gombak, Petaling, Sepang, Hulu Langat, Hulu Selangor, S.Alam",
    "date": "2026-05-31",
    "prayers": {
      "imsak": "05:40",
      "subuh": "05:50",
      "syuruk": "07:12",
      "zohor": "13:15",
      "asar": "16:35",
      "maghrib": "19:21",
      "isyak": "20:32",
      "dhuha": "07:39"
    }
  }
}
```

## Authentication

- Admin authentication uses Laravel's built-in session guard
- Admin users are managed via the existing `users` table
- Middleware-protected admin routes (`web` + `auth`)
- API routes are public (no authentication required)

## E-Solat Data Source

- **Base URL:** `https://www.e-solat.gov.my/index.php?r=esolatApi/takwimsolat`
- **Parameters:** `period=year&zone={ZONE_CODE}` (e.g., `JHR01`)
- **Response:** JSON array of prayer time objects for the year
- **Requirements:** Session cookie (`PHPSESSID`) and CSRF token (`YII_CSRF_TOKEN`) are needed to access the API

## Malaysian Zones

Full list of zones from e-Solat across states: Johor, Kedah, Kelantan, Melaka, Negeri Sembilan, Pahang, Perlis, Pulau Pinang, Perak, Sabah, Sarawak, Selangor, Terengganu, Wilayah Persekutuan.

## Non-Goals (V1)

- Push notifications
- User-facing mobile app
- Multi-language support
- OAuth / API key authentication
- Rate limiting on the public API
- Hijri calendar integration

## Success Metrics

- Public API responds in < 100ms (cached)
- Crawl command handles all ~70 zones without failure
- Admin can manage zones and prayer times via the UI
- Zero duplicate prayer time entries
