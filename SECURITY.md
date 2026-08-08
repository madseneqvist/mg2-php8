# Security policy

## Supported version

Only the latest revision of this fork is intended to receive security fixes.
The original MG2 0.5.1 and kh_mod releases are unsupported.

## Reporting a vulnerability

Do not open a public issue containing exploit details or private gallery data.
Use the hosting platform's private vulnerability-reporting feature, or contact
the repository maintainer privately once a security contact is published.

Include affected versions, reproduction steps, impact, and a proposed fix when
possible. Avoid accessing, changing, or downloading data that is not yours.

## Deployment notes

- Never commit `data/`, `pictures/`, logs, backups, or password hashes.
- Deny all direct HTTP access to `data/` at the web-server layer.
- Use HTTPS and a unique, high-entropy admin password.
- Keep comments disabled unless their input/output paths have been reviewed.
- Back up the flat-file databases before upgrades.
- Verify PHP and GD security updates through your hosting provider.

Historical advisories associated with MG2 include CVE-2005-3432,
CVE-2006-0493, and CVE-2008-1228. Regression tests for these advisories should
be added before declaring a stable security release.
