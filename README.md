# Barangay Bulletin – Purok Asjali

Lab Activity 10 for 4-334 Full-Stack Web Development. A small blog for Barangay Matina Crossing where officials publish posts that residents can browse, search and page through. Built with Laravel 12, SQLite, Eloquent, Blade and Tailwind CSS v3.

## My personalized values

| Item | Value |
| --- | --- |
| Site title | Barangay Bulletin – Purok Asjali |
| Kagawad author | Kagawad Benjamin Asjali (kagawad.asjali@bulletin.test) |
| Posts per page | 6, because my last name, Asjali, has 6 letters |
| Custom category | Livelihood |
| Pinned post | Purok Asjali Clean-up Drive |
| Birthday post date | May 23, 2026 |

## How to run

```sh
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
npm install
npm run dev
php artisan serve
```

On Windows PowerShell, use `New-Item database/database.sqlite` instead of `touch`. Run `npm run dev` and `php artisan serve` in two separate terminals, then open http://127.0.0.1:8000.

After seeding there are 5 authors and 51 posts (41 published, including the pinned post, and 10 drafts).

## Screenshot

`docs/tinker.png` shows `find()`, changing the title, and `save()` in tinker.
