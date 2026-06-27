# Deploying Ayesha & Adnan's wedding invitation site

You don't need any coding experience for this. Just follow each step in order. It should take about 20–30 minutes the first time.

## What you already have

A complete Laravel website with:
- A festive, designed invitation page (hero, countdown, event schedule, maps, gallery, gift info, RSVP form)
- Personalized invite links you can generate per guest (e.g. `/invite/abc123`) that greet them by name
- WhatsApp share button and copy-link button on every invitation page
- A "Download as PDF" button (uses the browser's print function — works everywhere, no setup needed)
- A private admin area where you can: generate guest links, see who RSVP'd, edit event details, and manage gallery photos — all without touching code

## Important: data may reset on restart

To keep this simple and free, the site stores its data (guest list, RSVPs, photos) in a single file that can be wiped if Railway restarts your app. This is unlikely to happen often, but **take a screenshot or export your guest list and RSVPs periodically**, especially close to the wedding date, just in case. If this becomes a concern, tell me and I can help set up persistent storage (a few extra steps).

## Step 1 — Create two free accounts

1. Go to **github.com** and sign up (free).
2. Go to **railway.app** and sign up using your GitHub account (free, no card needed for the free tier).

## Step 2 — Put the code on GitHub

1. On GitHub, click **+** → **New repository**. Name it `wedding-invitation`. Keep it **Private**. Click **Create repository**.
2. Unzip the project zip file on your computer.
3. On the new repo page, use **uploading an existing file**, then drag in everything **inside** the unzipped `wedding-app` folder (not the folder itself).
4. Click **Commit changes**.

## Step 3 — Deploy on Railway

1. On railway.app: **New Project** → **Deploy from GitHub repo** → pick `wedding-invitation`.
2. Wait 2–5 minutes for the build.
3. Go to your service → **Settings** → **Networking** → **Generate Domain**. You'll get a link like `wedding-invitation.up.railway.app`.

## Step 4 — Set your environment variables

In Railway, go to your service → **Variables** tab, and add:

| Variable name | Value |
|---|---|
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `DB_CONNECTION` | `sqlite` |
| `GUEST_LIST_KEY` | Your own secret word, e.g. `ayesha-adnan-2026` |

Railway will redeploy automatically. Wait for the green "Success" status.

## Step 5 — Visit your admin area

Go to:
```
https://your-railway-domain.up.railway.app/admin?key=YOUR_SECRET
```
Replace `YOUR_SECRET` with what you set as `GUEST_LIST_KEY`. **Bookmark this — it's your control panel.**

From here you can:
- **Add a guest name** → get a unique personalized link → copy it → send via WhatsApp yourself
- **See RSVP responses** as they come in
- **Edit event details** (dates, times, venues, countdown, contact info, gift/bank details) — click "Edit event details"
- **Manage gallery photos** — click "Manage gallery", upload images, add captions, remove if needed

**Keep your admin link private.** Anyone with it can edit your site and see your guest list.

## Step 6 — Generate and send personalized invites

1. In the admin dashboard, type a guest's name (e.g. "Uncle Tariq's family") and click **Generate link**.
2. Copy the link shown next to their name.
3. Paste it into WhatsApp (or wherever) and send it to them directly.
4. When they open it, the page greets them by name and pre-fills their name in the RSVP form.
5. Repeat for each guest or family.

You can also just share the main link (without `/invite/...`) generally — it works too, just without the personal greeting.

## Step 7 — Add real photos (optional)

Go to `https://your-domain/admin/gallery?key=YOUR_SECRET`, upload images one at a time with optional captions. They'll appear on the invitation page automatically.

## If something goes wrong

- **Build fails on Railway:** copy the build log error and send it to me.
- **Site loads but looks broken (no styling):** hard refresh (Ctrl+Shift+R / Cmd+Shift+R).
- **"403 Forbidden" on admin/guest-list pages:** you forgot `?key=YOUR_SECRET` in the URL, or it doesn't match what you set in Variables.
- **Uploaded photos don't show:** Railway sometimes needs a redeploy after the very first upload for the storage link to take effect — try refreshing after a minute, or redeploy once from Railway's dashboard.
- **"500 server error":** usually a missing `APP_KEY` or failed migration — send me the Railway deploy logs.

## Want a custom domain later?

Buy one from Namecheap/GoDaddy (~$8–15/year) and I'll walk you through connecting it to Railway. Not required.
