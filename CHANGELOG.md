# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.2.0] 2026-04-06

### Changed

- Bump PHP to `8.4`.
- Bump `thesis/endian` to `^0.3.2`.
- Require `ext-bcmath`.
- **BC break:** Change `endian $endian` parameters to `Order $order`.
- **BC break:** Change `readInt64()` and `readUint64()` return type to `BcMath\Number`.
- **BC break:** Change `writeInt64($v)` and `writeUint64($v)` param type to `BcMath\Number`.
