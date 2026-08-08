# Changelog

## Unreleased

### Compatibility

- Added PHP 8 compatibility throughout the core, admin UI, and bundled skins.
- Fixed the image-view parse error caused by the legacy `08` and `09` literals.
- Fixed installer initialization for PHP 8.
- Removed the obsolete Mozilla compatibility popup from the admin editor.
- Updated PHP templates across all nine bundled skins for PHP 8 compatibility.

### Features

- Added optional Google Analytics 4 integration configurable from Admin → Setup.

### Security

- Removed the temporary development-login bypass.
- Disabled the installer after installation.
- Protected runtime data and logs from direct HTTP access.
- Hardened session cookies and regenerate the session ID after authentication.
- Validate uploaded files by exact extension and detected image type.
- Added basic browser security headers.
- Use PHP's password hashing API for new gallery passwords while retaining support for existing legacy hashes.

### Distribution

- Excluded photographs, databases, settings, logs, credentials, and backups.
- Added open-source project, contribution, and security documentation.
