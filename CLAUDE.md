# CLAUDE.md

## Project Overview

**One Red Paperclip** — trade-up platform on the Waaseyaa PHP framework. Migrated from Laravel (legacy at `legacy.oneredpaperclip.xyz`).

## Commands

```bash
vendor/bin/phpunit                    # Run all tests (346 tests)
npm run build                         # Vite production build
npm run dev                           # Vite dev server
```

## Architecture

- **Framework:** Waaseyaa v0.1.0-alpha.36 (local path deps via symlinks)
- **Frontend:** Inertia.js v2 + Vue 3 + Tailwind CSS v4 + shadcn-vue
- **Database:** SQLite (production + dev)
- **Mail:** SendGrid via custom `SendGridTransport`
- **Deploy:** rsync with resolved symlinks → Caddy + PHP-FPM on DigitalOcean

## Key Directories

- `src/Action/` — Business logic (CreateChallenge, AcceptOffer, ConfirmTrade, etc.)
- `src/Auth/` — AuthService + AccountAdapter (session-based, bcrypt)
- `src/Entity/` — 10 entity classes (Challenge, Item, Offer, Trade, Comment, Follow, Notification, User, Category, Media)
- `src/Http/Controller/` — Inertia controllers (Page, Challenge, Offer, Trade, Auth, Admin, Dashboard, Notification, Settings, Sitemap)
- `src/Http/RouteProvider.php` — 33 routes
- `src/Policy/` — Authorization (ChallengePolicy, OfferPolicy, TradePolicy)
- `src/Schema/SchemaInstaller.php` — Creates all 10 tables with constraints
- `src/Service/` — XpService, StreakService, SlugGenerator, HtmlSanitizer, SeoMetadata, ChallengeSearchService, ChallengeWorkflow
- `src/Validation/` — StoreChallengeValidator, StoreOfferValidator

## Deployment

```bash
# Build locally, rsync to server (resolves symlinks), deploy release
npm run build
rsync -avzL --delete --exclude='.git' --exclude='node_modules' --exclude='.phpunit.cache' --exclude='backups' --exclude='database/database.sqlite' --exclude='.env' --exclude='tests' ./ jones@147.182.150.145:/tmp/orpc-deploy/

# SSH and deploy release
ssh jones@147.182.150.145
RELEASE=$(date +%Y%m%d%H%M%S)
sudo -u deployer cp -r /tmp/orpc-deploy /home/deployer/oneredpaperclip-waaseyaa/releases/$RELEASE
sudo -u deployer ln -sf /home/deployer/oneredpaperclip-waaseyaa/shared/.env /home/deployer/oneredpaperclip-waaseyaa/releases/$RELEASE/.env
sudo -u deployer ln -sfn /home/deployer/oneredpaperclip-waaseyaa/shared/storage/app/public /home/deployer/oneredpaperclip-waaseyaa/releases/$RELEASE/public/storage
sudo -u deployer ln -sfn /home/deployer/oneredpaperclip-waaseyaa/releases/$RELEASE /home/deployer/oneredpaperclip-waaseyaa/current
```

## Gotchas

- `DBALDatabase::createSqlite()` runs PRAGMA that requires write access — both source AND target DBs need write permission for the user running PHP
- Vite `base` must be `/build/` since `outDir` is `public/build/` — otherwise chunks request `/assets/` instead of `/build/assets/`
- `SqlEntityQuery::execute()` returns entity **IDs** (not objects) — must call `storage->load($id)` to get entities
- `SqlEntityStorage::delete()` takes an **array** of entities, not a single entity
- Entity label key determines column name: `'label' => 'title'` means no separate `label` column — `buildTableSpec()` reuses `title` as the label column
- Media `model_type` in production uses Laravel FQCN (`App\Models\Item`) — query media by this string, not just `item`
- SchemaInstaller runs on every request (#5) — performance concern, should be one-time
- `ssr.ts` still imports from `laravel-vite-plugin` (#2) — SSR won't work until fixed
- Ansible `waaseyaa-app` role only provisions infrastructure (dirs, Caddyfile, .env) — actual deploy (git clone, composer, npm, symlink) is manual
- Storage symlink (`public/storage → shared/storage/app/public`) must be recreated on each deploy release

## Known Issues

See: https://github.com/jonesrussell/oneredpaperclip-waaseyaa/issues
