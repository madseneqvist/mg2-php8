# Changelog

## Unreleased

### Compatibility

- Added PHP 8 compatibility throughout the core, admin UI, and bundled skins.
- Fixed the image-view parse error caused by the legacy `08` and `09` literals.
- Fixed installer initialization for PHP 8.

### Security

- Removed the temporary development-login bypass.
- Disabled the installer after installation.
- Protected runtime data and logs from direct HTTP access.
- Hardened session cookies and regenerate the session ID after authentication.
- Validate uploaded files by exact extension and detected image type.
- Added basic browser security headers.

### Distribution

- Excluded photographs, databases, settings, logs, credentials, and backups.
- Added open-source project, contribution, and security documentation.
