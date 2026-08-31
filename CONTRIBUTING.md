# Contributing to Post ADA 🚀

Thank you for your interest in contributing to **Post ADA**! We welcome bug reports, feature requests, documentation improvements, and code contributions from the community.

---

## Code of Conduct

By participating in this project, you agree to maintain a respectful and welcoming environment for everyone.

---

## How to Contribute

### 1. Reporting Bugs
- Search existing GitHub Issues before submitting a new one.
- Provide a clear, descriptive title.
- Include step-by-step instructions to reproduce the bug, your environment details (PHP version, OS, browser), and relevant error logs.

### 2. Suggesting Features
- Open an Issue with the `[Feature Request]` tag.
- Explain the business value, use cases, and proposed workflow.

### 3. Submitting Pull Requests (PRs)
1. Fork the repository and create your branch from `main`:
   ```bash
   git checkout -b feature/your-feature-name
   ```
2. Follow standard PSR-12 coding conventions.
3. Write clean, readable code and keep views responsive and localized (`lang/`).
4. Ensure your branch builds without errors.
5. Push to your fork and submit a Pull Request describing your changes.

---

## Development Setup

```bash
git clone https://github.com/adacreativeco/postada.git
cd postada
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Thank you for building the future of social automation with us!
