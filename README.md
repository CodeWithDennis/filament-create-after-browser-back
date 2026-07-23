# Filament: Create button does nothing after browser Back

Minimal reproduction for a Filament resource navigation bug.

**Filament:** v5.7.2  
**Stack:** [Larament](https://github.com/CodeWithDennis/larament) (Laravel 13)

## What’s going wrong

On a normal Filament resource list page:

1. Click **New post** (Create)
2. You land on `/admin/posts/create`
3. Press the browser **Back** button (you return to the list)
4. Click **New post** again

**Expected:** you navigate to the create page again.  
**Actual:** nothing happens. The URL stays on the list page and the create page never opens.

This is not limited to SPA / `wire:navigate` quirks — it happens consistently after using the browser Back button. The Create action stays broken until you hard-refresh or leave the list page and come back another way.

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
- Happens every time after Back → Create, not only in specific browsers or SPA modes.
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
- Helium / Brave on macOS

## Related

If this is confirmed upstream, this repo is meant as a drop-in reproduction for a Filament issue report.
