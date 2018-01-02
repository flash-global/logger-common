# Service Logger - Common

[![GitHub release](https://img.shields.io/github/release/flash-global/logger-common.svg?style=for-the-badge)](README.md)

## Table of contents
- [Entities](#entities)
- [Contribution](#contribution)

## Entities

### Nofification
| Properties    | Type              | Required | Default value |
|---------------|-------------------|----------|---------------|
| id          | `int`      | No       |               |
| reportedAt          | `datetime`      | No       | Now()              |
| level     | `int`        | Yes       | 2         |
| flags     | `int`          | No       | 0              |
| namespace     | `string`          | Yes       | /              |
| message     | `string`          | Yes       |               |
| backTrace     | `json`          | No       |               |
| user     | `string`          | No       |               |
| server     | `string`          | No       |               |
| command     | `string`          | No       |               |
| origin     | `string`          | Yes       |               |
| category     | `int`          | Yes       |               |
| env     | `string`          | Yes       | n/c              |

### Context
| Properties    | Type              | Required | Default value |
|---------------|-------------------|----------|---------------|
| id          | `int`      | No       |               |
| notification          | `Notification`      | Yes       |               |
| key     | `string`        | Yes       |          |
| value     | `string`          | Yes       |               |


## Contribution
As FEI Service, designed and made by OpCoding. The contribution workflow will involve both technical teams. Feel free to contribute, to improve features and apply patches, but keep in mind to carefully deal with pull request. Merging must be the product of complete discussions between Flash and OpCoding teams :) 



