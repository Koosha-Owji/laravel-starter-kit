# Kinde Laravel Starter Kit

A complete Laravel authentication starter kit using [Kinde](https://kinde.com) for secure, modern user authentication.

[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](https://makeapullrequest.com) [![Kinde Docs](https://img.shields.io/badge/Kinde-Docs-eee?style=flat-square)](https://kinde.com/docs/developer-tools) [![Kinde Community](https://img.shields.io/badge/Kinde-Community-eee?style=flat-square)](https://thekindecommunity.slack.com)

## Requirements

- PHP 8.1 or higher
- Laravel 11.x
- Composer
- Node.js and npm
- A [Kinde](https://kinde.com) account

## Installation

### Initial setup

1. Clone the repository to your machine:

   ```bash
   git clone https://github.com/kinde-oss/laravel-starter-kit.git
   cd laravel-starter-kit
   ```

2. Install the dependencies:

   ```bash
   composer install
   npm install
   ```

3. Set up your environment:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Build the frontend assets:

   ```bash
   npm run build
   ```

### Configure Kinde

1. Create an application in your [Kinde dashboard](https://app.kinde.com)

2. Add your Kinde configuration to your `.env` file:

   ```env
   KINDE_DOMAIN=your-kinde-domain.kinde.com
   KINDE_CLIENT_ID=your_client_id
   KINDE_CLIENT_SECRET=your_client_secret
   KINDE_REDIRECT_URL=http://localhost:8000/auth/callback
   KINDE_POST_LOGOUT_REDIRECT_URL=http://localhost:8000
   ```

3. In your Kinde app settings, add these URLs:
   - **Allowed callback URLs**: `http://localhost:8000/auth/callback`
   - **Allowed logout redirect URLs**: `http://localhost:8000`

4. Start the development server:

   ```bash
   php artisan serve
   ```

Visit `http://localhost:8000` to see your authentication-ready Laravel app!

## What's included

This starter kit provides:

- **Complete authentication flow** - Login, registration, logout with Kinde
- **Protected routes** - Middleware for route protection
- **User management** - Access user profile and permissions
- **Modern UI** - Built with Tailwind CSS and Kinde design system
- **Laravel 11** - Latest Laravel features and best practices
- **Vite integration** - Fast frontend build tooling

## Key components

### Routes

| Route              | Method | Description                    | Protected |
| ------------------ | ------ | ------------------------------ | --------- |
| `/`                | GET    | Home/Welcome page              | No        |
| `/auth/login`      | GET    | Redirect to Kinde login        | No        |
| `/auth/register`   | GET    | Redirect to Kinde registration | No        |
| `/auth/callback`   | GET    | OAuth callback handler         | No        |
| `/auth/logout`     | GET    | Logout and redirect to Kinde   | No        |
| `/dashboard`       | GET    | User dashboard                 | Yes       |

### Services

**KindeService** - Main authentication service providing:
- User authentication checking
- User profile retrieval
- Permission checking
- OAuth URL generation
- Direct SDK access for advanced features

**KindeAuth Middleware** - Protects routes requiring authentication

### Usage example

```php
// Check if user is authenticated
$kindeService = app(KindeService::class);

if ($kindeService->isAuthenticated()) {
    $user = $kindeService->getUser();

    // Check permissions
    if ($kindeService->hasPermission('create:posts')) {
        // User can create posts
    }
}

// Protect routes with middleware
Route::middleware('kinde.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});
```

## Documentation

For details on integrating Kinde into your Laravel project, head over to the [Kinde docs](https://kinde.com/docs/) and see the [Laravel SDK](https://kinde.com/docs/developer-tools/laravel-sdk/) doc 👍🏼.

## Development

### Project structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── AuthController.php      # Authentication routes handler
│   └── Middleware/
│       └── KindeAuth.php           # Route protection middleware
├── Providers/
│   └── KindeServiceProvider.php   # Kinde service registration
└── Services/
    └── KindeService.php            # Simplified Kinde SDK wrapper

resources/
├── css/
│   ├── app.css                    # Application styles
│   └── kinde.css                  # Kinde design system
└── views/
    ├── layouts/
    │   └── app.blade.php          # Main layout template
    └── dashboard.blade.php        # Protected dashboard
```

### Customization

This starter kit is designed to be customized for your specific needs:

1. **Styling** - Modify the Tailwind CSS classes in the views
2. **Routes** - Add your own protected routes using the `kinde.auth` middleware
3. **Permissions** - Use `KindeService::hasPermission()` for role-based access
4. **User data** - Access additional user properties via the Kinde SDK

## Contributing

Please refer to Kinde's [contributing guidelines](https://github.com/kinde-oss/.github/blob/489e2ca9c3307c2b2e098a885e22f2239116394a/CONTRIBUTING.md).

## License

By contributing to Kinde, you agree that your contributions will be licensed under its MIT License.
