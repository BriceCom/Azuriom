# Hunt

**Hunt** is an Azuriom plugin that spawns small items randomly on site pages. Players click them to claim rewards such as site currency and/or server commands.

---

Summary:

- [Available langs](#available-langs)
- [Features](#features)
- [Reward placeholders](#reward-placeholders)
- [Next features](#next-features)

---

### Available langs

![English](https://azuriom.com/assets/svg/country/us.svg)

If your language is not available, contact me on Discord.

---

### Features

#### Hunt Management

- Create, edit, archive, and schedule hunts.
- Priority system for overlapping periods.
- Spawn rate, cooldown, and daily limits per user.
- Global cap support (total claims).
- Optional hunt images and descriptions.

#### Rewards Management

- Weighted chances per reward.
- Site currency rewards.
- Server commands (single or multiple).
- Role-based eligibility.
- Optional reward images.

#### Player Experience

- Random hunt spawns across public pages.
- Claim flow with success/error modals.
- Personal daily progress tracking.
- Global progress when caps are enabled.
- Leaderboards and public hunt pages.

#### Logs & Security

- Full claim logging with metadata.
- Server-side validation for cooldowns, limits, and caps.
- Anti-bot click protection and rate control.

---

### Reward placeholders

You can use these placeholders in reward commands:

- `{player}`
- `{user}`
- `{hunt}`
- `{reward}`
- `{steam_id}`
- `{steam_id_32}`

---

### Next features

- Advanced hunt statistics dashboard.
- Optional scheduled cleanup for daily stats.
- More UI customization for hunt spawns.
