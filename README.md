# Filament: Create button does nothing after browser Back

Minimal reproduction for a Filament / Livewire SPA navigation bug.

**Filament:** v5.7.2  
**Livewire:** v4.3.x  
**Stack:** [Larament](https://github.com/CodeWithDennis/larament) (Laravel 13)

## What’s going wrong

On a normal Filament resource list page:

1. Click **New post** (Create)
2. You land on `/admin/posts/create`
3. Press the browser **Back** button (you return to the list)
4. Click **New post** again

**Expected:** you navigate to the create page again.  
**Actual:** nothing happens. The URL stays on the list page and the create page never opens.

This is easy to miss in day-to-day use, but once you hit Back and try Create again, the header action appears dead until you hard-refresh or navigate away and come back.

## Why this likely happens

Filament panels use Livewire’s SPA-style navigation (`wire:navigate`). Clicking Create pushes `/admin/posts/create` into history. Using the browser Back button restores the list page from that history/snapshot.

When you click Create again, Livewire appears to treat the navigation as a no-op (same destination already known / cached from the previous visit), so the create page never mounts again.

A hard refresh of the list page, or navigating via a full page load, usually makes Create work again — until you repeat Back → Create.

## How to reproduce

### Setup

```bash
composer create-project codewithdennis/larament filament-create-after-browser-back
# or clone this repo, then:

composer setup
php artisan migrate --seed
```

With Laravel Herd, the app is available at:

`https://filament-create-after-browser-back.test/admin`

### Login

Use the seeded Larament admin user (the login form autofills locally):

| Field    | Value               |
|----------|---------------------|
| Email    | `admin@example.com` |
| Password | `password`          |

### Steps

1. Open **Posts** in the sidebar (`/admin/posts`)
2. Click **New post** in the page header
3. Confirm you are on `/admin/posts/create`
4. Click the browser **Back** button
5. Confirm you are back on `/admin/posts`
6. Click **New post** again

**Bug:** the create page does not open. Nothing happens.

### Notes

- You do **not** need to submit the form. Just opening Create and going Back is enough.
- Reproduced in Chromium-based browsers with Filament’s default SPA navigation enabled.
- A hard refresh of `/admin/posts` makes Create work again until you repeat the Back → Create sequence.

## What’s in this repo

A stock Larament app plus one minimal Filament resource:

- `Post` model (`title`, `body`)
- `PostResource` with list / create / edit pages
- Default seeded admin user

No custom JavaScript, themes, or navigation hacks — just a default Filament resource create flow.

## Environment used when filing this

- PHP 8.5
- Laravel 13.21
- Filament 5.7.2
- Livewire 4.3.3
- Safari / Chrome on macOS

## Related

If this is confirmed upstream, this repo is meant as a drop-in reproduction for a Filament / Livewire issue report.
