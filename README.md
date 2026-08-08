# MG2 PHP 8

An independent, community-maintained revival of MG2 0.5.1 with the kh_mod
0.2.1 extensions. This fork keeps MG2's flat-file, dependency-free design while
making the application usable on PHP 8 and closing obvious legacy security
exposures.

The repository contains application code only. Personal photographs, gallery
databases, settings, logs, passwords, and server backups are intentionally not
included.

## Status

This is preservation work on a legacy application. Test carefully and keep
regular backups. The code has received a focused compatibility and security
pass, but has not yet had a comprehensive professional audit.

## Requirements

- PHP 8.0 or newer
- GD extension
- Apache-compatible hosting with `.htaccess` support, or equivalent web-server
  rules that deny direct access to `data/`
- Writable `data/` and `pictures/` directories

## Installation

1. Copy the repository to the web root for the gallery.
2. Ensure `data/` and `pictures/` are writable by PHP.
3. Confirm your web server denies HTTP access to `data/`.
4. Open `mg2_install.php` and complete the installer.
5. Sign in through `admin.php` and replace all default settings.
6. Back up `data/` and `pictures/` regularly.

The installer returns 404 after `data/mg2_settings.php` has been created.

## Changes in this fork

- Replaced PHP APIs removed in PHP 8 (`create_function`, `split`, and `each`).
- Replaced legacy constructors and curly-brace offsets.
- Corrected invalid numeric literals and unquoted template keys.
- Removed reliance on short PHP open tags.
- Added strict, secure admin session cookies and session-ID rotation.
- Disabled the installer after configuration.
- Blocked direct access to runtime data and logs.
- Added exact extension checks and image-content validation for uploads.
- Added basic browser security headers.

See [CHANGELOG.md](CHANGELOG.md) and [SECURITY.md](SECURITY.md) for details.

## History and attribution

MG2 was written by Thomas Rybak and released as MG2 0.5.1. This source also
contains the kh_mod 0.2.1 work and bundled third-party components whose notices
remain in their source files. Original copyright and attribution notices have
been preserved.

An earlier independent PHP 8 revival by viulian documented useful compatibility
work and historical MG2 vulnerabilities:
https://bitbucket.org/viulian/mg2

This repository is not affiliated with or endorsed by the original authors.

## License

The MG2 source headers permit redistribution and modification under the GNU
General Public License, version 2 or (at your option) any later version. See
[LICENSE](LICENSE). Bundled third-party files retain their existing notices.
