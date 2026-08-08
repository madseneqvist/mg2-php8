# Backlog

This backlog records ideas rather than promises or release dates. Security and compatibility fixes take priority over presentation features.

## Modern large-image viewing

Status: planned

Improve image presentation for contemporary desktop and mobile displays without losing MG2's lightweight, self-hosted character.

Proposed scope:

- Make gallery images responsive up to the available viewport width.
- Add an administrator setting for maximum displayed image width.
- Use the retained original photograph as a higher-resolution `srcset` candidate when appropriate.
- Bundle PhotoSwipe locally for fullscreen viewing, zoom, touch gestures, and keyboard navigation.
- Preserve normal links and image viewing when JavaScript is unavailable.
- Avoid loading full-resolution originals unnecessarily on smaller screens.
- Apply the feature consistently across all nine bundled skins.
- Document that enlarging a low-resolution original cannot restore missing image detail.

Before implementation:

- Review the bundled PhotoSwipe version and license.
- Decide how existing `_medium` derivatives should be regenerated after the configured size changes.
- Test portrait, landscape, very large, and legacy 600-pixel images.
- Test current desktop and mobile browsers, keyboard navigation, and reduced-motion preferences.
