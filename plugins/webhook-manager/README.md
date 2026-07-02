# Webhook Manager

**Webhook Manager** is an Azuriom plugin that centralizes outgoing webhooks with a clear model:

`Service (connector)` + `Event` + `JSON payload`

It lets you reuse destinations, customize payloads per event, and keep full delivery logs.

---

Summary:

- [Available languages](#available-languages)
- [Features](#features)
- [Cases](#cases)
- [Hooks & Triggers](#hooks--triggers)
- [Extension API](#extension-api-for-other-plugins)
- [Compatibility](#compatibility)

## Available languages

- English

## Features

### 1) Reusable services (connectors)

- Full admin CRUD for services.
- Available types: `discord`, `custom`.
- A service stores:
  - destination URL
  - Discord visual identity (`bot_name`, `bot_avatar`, `default_color`)
- Safe deletion: a service cannot be deleted while used by one or more webhooks.

### 2) Event-based webhooks

- Full admin CRUD for webhooks.
- Each webhook references a `service_id`.
- Main fields:
  - `event`
  - `payload_template` (JSON)
  - `headers` (optional)
  - `secret` HMAC (optional)
  - `timeout` (1 to 30s)
  - `is_active`

### 3) JSON helper for non-technical users

- Pre-configured payload examples by event.
- One-click insert for the selected event example.
- JSON formatting button.
- Dynamic variable list shown under the payload template field.

### 4) Security and reliability

- Optional HMAC SHA-256 signature in `X-Webhook-Signature`.
- Custom HTTP headers support.
- Automatic masking of sensitive headers in logs (`authorization`, `token`, `secret`, `signature`, `key`).
- Safe HTTP dispatch (timeout + exception handling) without breaking the parent application flow.

### 5) Logs and diagnostics

- Detailed delivery history:
  - payload sent
  - headers sent (masked when sensitive)
  - HTTP status code
  - response body
  - sent timestamp
- Filters by webhook and event.
- **Test** button to send a sample request without waiting for a real event.

### 6) Admin permission

- Dedicated permission: `webhook-manager.admin`.
- All plugin admin routes are protected by this permission.

## Cases

1. New user notification on Discord  
Trigger `user.registered` and send a welcome embed to your staff channel with `{user.name}` and `{user.email}`.

2. Paid order alert for moderation/sales tracking  
Trigger `order.paid` and post order details (`{order.id}`, `{order.total}`, `{order.items_text}`) to a private Discord channel.

3. Admin access monitoring  
Trigger `admin.login` and send an audit message with `{admin.name}`, `{admin.ip}`, and `{date}`.

4. Vote activity feed  
With Vote plugin installed, trigger `user.voted` and push a short message to keep your team aware of vote traffic.

5. Support ticket creation notification  
With Support plugin installed, trigger `ticket.created` and send ticket details (`{ticket.id}`, `{ticket.subject}`, `{ticket.category}`) to support staff.

6. Custom plugin integrations  
Use `WebhookManager::registerEvent()` and `WebhookManager::dispatch()` to expose your own plugin events and send standardized webhooks to external systems.

## Hooks & Triggers

| Hook | Trigger |
| --- | --- |
| `azuriom.auth` | `user.registered`, `admin.login` |
| `shop` | `order.paid` |
| `vote` | `user.voted` (automatic bridge when Vote plugin is installed) |
| `support` | `ticket.created` (automatic bridge when Support plugin is installed) |
| `webhook-manager` | `custom.*` (events declared/dispatched via public API) |

## Extension API for other plugins

Facade:

```php
use Azuriom\Plugin\WebhookManager\Facades\WebhookManager;
```

Register a custom event:

```php
WebhookManager::registerEvent('my_plugin.custom_event', [
    'label' => 'My custom event',
    'variables' => ['custom.var1', 'custom.var2'],
]);
```

Dispatch a custom event:

```php
WebhookManager::dispatch('my_plugin.custom_event', [
    'custom.var1' => 'value1',
    'custom.var2' => 'value2',
]);
```

API endpoint (list registered events):

```text
GET /api/webhook-manager/events
```

## Compatibility

- Azuriom API: `1.1.0`
- PHP: `>= 8.1`
- Plugin id: `webhook-manager`
