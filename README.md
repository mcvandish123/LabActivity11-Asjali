# Barangay Bulletin – Purok Asjali

Lab Activity 11 for 4-334 Full-Stack Web Development. It builds on my Lab 10 blog for Barangay Matina Crossing. Officials publish posts, and logged-in residents can comment on them. Built with Laravel 12, SQLite, Eloquent, Blade and Tailwind CSS v3.

## My personalized values

| Item | Value |
| --- | --- |
| Site title | Barangay Bulletin – Purok Asjali |
| Kagawad author | Kagawad Benjamin Asjali (kagawad.asjali@bulletin.test) |
| Posts per page | 6, because my last name, Asjali, has 6 letters |
| Custom category | Livelihood |
| Pinned post | Purok Asjali Clean-up Drive |
| Birthday post date | May 23, 2026 |
| Comment error message | "Purok Asjali comments need at least 3 characters." |
| Tags | Purok Asjali, Urgent, Health, Livelihood, Event |

## Seeded logins

All seeded named accounts use the password `bulletin2026`.

| Name | Email | Role |
| --- | --- | --- |
| Kagawad Benjamin Asjali | kagawad.asjali@bulletin.test | Linked to the Kagawad author profile, so can create posts |
| Lola Asjali | lola.asjali@bulletin.test | Resident, can comment only (posting returns 403) |

There are also 8 factory residents (random emails, password `password`).

## Relationships used

| Link | Type | Why |
| --- | --- | --- |
| User → Author | hasOne | A login account can own one author profile; `authors.user_id` holds the key. Used in `StorePostRequest` and `PostController@store`. |
| Author → User | belongsTo | The inverse, shown as the linked login on the author page. |
| Author → Post | hasMany | One author writes many posts; `posts.author_id`. |
| Post → Author | belongsTo | Each post has one author, linked from every card. |
| Post → Comment | hasMany | A post has many comments; comments are created through `$post->comments()`. |
| Comment → Post | belongsTo | Used for "Latest comments received" on the author page. |
| User → Comment | hasMany | Comment count shown in the nav. |
| Comment → User | belongsTo | Shows who commented. |
| Author → Comment | hasManyThrough (via Post) | Comments belong to posts, not authors, so this counts "N comments received" without a second foreign key. |
| Post ↔ Tag | belongsToMany | Many posts share many tags; pivot table `post_tag`, filled only with `attach()` and `sync()`. |

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

After seeding there are 5 authors, 10 users, 5 tags and 51 posts (41 published, including the pinned post, and 10 drafts). The pinned post has the tags Purok Asjali and Urgent and at least 3 comments, one from Lola.

## Screenshot

`docs/tinker.png` shows `find()`, changing the title, and `save()` in tinker.
