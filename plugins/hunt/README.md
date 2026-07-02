# Hunt Plugin for Azuriom

A comprehensive hunt plugin that allows small images to appear randomly on site pages, which players can click to earn rewards (site currency or server commands).

## Features Implemented

### Admin Panel Features
- **Hunt Management** (`/admin/hunt/`):
  - Create, edit, and delete hunts
  - Priority system for overlapping hunt periods
  - Global caps and daily limits per user
  - Spawn rate configuration (percentage chance)
  - Start/end date scheduling
  - Archive system for completed hunts

- **Reward Management** (`/admin/hunt/rewards`):
  - Create rewards with chance percentages
  - Site currency rewards
  - Multiple server command execution
  - Role-based reward restrictions
  - Image support for rewards
  - Reward scratch-game (jeu à gratter) : https://market.azuriom.com/resources/198

- **Logging System** (`/admin/hunt/logs`):
  - Complete claim tracking
  - User activity monitoring
  - Export functionality (CSV/Excel)
  - Filtering and search capabilities
  - Automatic cleanup of old logs

### User-Facing Features
- **Hunt Display** (`/hunt`):
  - Multi-hunt leaderboard page
  - Current hunt highlighted with badges
  - Progress tracking and statistics

- **Individual Hunt Pages** (`/hunt/{slug}`):
  - Detailed leaderboards with rankings
  - Personal progress tracking
  - Overall statistics
  - Available rewards display

### JavaScript Functionality
- **Random Hunt Spawning**:
  - Items appear randomly positioned on screen
  - Fixed positioning with high z-index
  - Smooth animations and hover effects
  - Auto-removal after 10 seconds

- **Security Features**:
  - 2-second anti-bot protection between clicks
  - Restricted pages detection (admin, login, register, deep routes)
  - Server-side spawn rate validation
  - Cooldown system after failed attempts

- **User Experience**:
  - Bootstrap modals for all interactions
  - Offline user handling with appropriate messages
  - Real-time progress updates
  - Responsive design

## Security & Validation

### Server-Side Protection
- All validation handled server-side
- CSRF token protection
- Rate limiting and cooldown systems
- IP tracking and user agent logging
- Role-based reward restrictions

### Anti-Bot Measures
- 2-second minimum between clicks
- Server-side spawn rate validation
- Cooldown penalties for failed attempts
- Session-based tracking

### Page Restrictions
Hunt items never appear on:
- Admin pages (`/admin/*`)
- Login/register pages
- Deep nested routes (N+2 levels)

## Database Structure

### Tables Created
1. `hunt_hunts` - Main hunt configurations
2. `hunt_rewards` - Reward definitions and settings
3. `hunt_logs` - Complete claim tracking
4. `hunt_user_daily` - Daily progress tracking
5. `hunt_reward_role` - Role restrictions (pivot table)

### Key Features
- Soft deletes for hunts
- Priority-based hunt selection
- Daily progress tracking with timezone support
- Comprehensive logging with IP/user agent

## Configuration Options

### Hunt Settings
- **Priority**: 1-100 (higher takes precedence)
- **Spawn Rate**: 0.01-100% (chance of reward when clicked)
- **Max Per Day**: Minimum 1 (daily claim limit per user)
- **Global Cap**: 0+ (0 = unlimited total claims)
- **Cooldown**: 1+ minutes (penalty after failed spawn)

### Reward Settings
- **Chance Percentage**: 0.01-100% (selection probability)
- **Money Reward**: 0+ site currency
- **Commands**: Multiple server commands with placeholders
- **Role Restrictions**: Optional role-based eligibility

## Translations

### Complete English Translation
- **Admin Interface**: All forms, validation, and management text
- **User Messages**: Frontend displays, modals, and interactions
- **JavaScript**: All client-side messages and notifications
- **Accessibility**: Alt text and screen reader support

## Priority System

When multiple hunts have overlapping date ranges:
1. Higher priority hunts take complete precedence
2. Only the highest priority active hunt displays
3. Lower priority hunts are effectively paused
4. System automatically switches when priorities change

## Hunt Display System

### Automatic Integration
The hunt display system automatically integrates into all themes without manual configuration:

- **Automatic Injection**: View composer system injects hunt display into all layout views
- **Theme Compatibility**: Works across all Azuriom themes automatically
- **Page Restrictions**: Never displays on admin, login, register, or deep routes (N+2)
- **Performance Optimized**: Only loads when active hunts are available

### Visual Features
- **Fixed Positioning**: Hunt items appear with `position: fixed` and high z-index (9999)
- **Attractive Animations**: Pulsing animation and hover effects to attract attention
- **Responsive Design**: Adapts to different screen sizes (80px → 60px on mobile)
- **Smooth Transitions**: CSS transitions for appearing, disappearing, and interactions

### Security Implementation
- **Server-Side Validation**: All validation handled on the server
- **Anti-Bot Protection**: 2-second minimum delay between clicks
- **Page Restrictions**: Automatic detection and blocking of restricted pages
- **Cooldown System**: 30-minute cooldown after failed spawn attempts
- **Daily Limits**: Configurable daily claim limits per user
- **IP Tracking**: Full audit trail with IP addresses and user agents

### User Experience Features
- **Offline Handling**: Shows appropriate message when user not authenticated
- **Modal System**: Bootstrap modals for all interactions (success/error/info)
- **Progress Tracking**: Real-time display of user progress and limits
- **Leaderboard Links**: Direct links to hunt leaderboards from modals
- **Responsive Feedback**: Immediate visual feedback on all actions

### Modal Types
1. **Success Modal**: Shows rewards received, progress, and global statistics
2. **Error Modals**: Handles daily limits, cooldowns, and global caps
3. **Offline Modal**: Special handling for non-authenticated users
4. **Global Cap Modal**: When hunt reaches maximum rewards

## Technical Implementation

### Architecture
- **Service Provider**: Handles plugin registration, view composers, and hunt injection
- **Models**: Eloquent models with relationships and scopes
- **Controllers**: Separate admin and user-facing controllers
- **Requests**: Form validation with custom rules
- **Views**: Blade templates with Bootstrap styling and automatic hunt injection
- **JavaScript**: Modern ES6 class-based hunt management with full security

### Performance Considerations
- Efficient database queries with proper indexing
- Lazy loading of relationships
- Client-side caching of hunt data
- Automatic cleanup of old logs
- Conditional loading only when hunts are active

## Admin Navigation

As per requirements, this plugin **does not appear** in the admin panel's offcanvas navigation menu, while still maintaining all administrative functionality through direct URL access.

## Installation Notes

The plugin is ready for installation and includes:
- Complete database migrations
- All necessary models and relationships
- Admin and user controllers
- Frontend and admin views
- JavaScript and CSS assets
- English translations
- Security and validation layers

All functionality matches the original French specifications and has been translated and implemented in English as requested.
