# My Parks Tests

## Prerequisites

- Docker Desktop (https://www.docker.com/products/docker-desktop)
- Node.js and npm

## Setup

1. Install dependencies:
```bash
npm install
```

2. Start WordPress environment:
```bash
npm run env:start
```

3. Run tests:
```bash
npm run test:php
```

## Commands

- `npm run env:start` - Start WordPress Docker environment
- `npm run env:stop` - Stop WordPress Docker environment
- `npm run env:destroy` - Remove WordPress Docker environment
- `npm run test:php` - Run PHPUnit tests

## What's Tested

- **Taxonomies**: Activity, Facility, Location registration and configuration
- **Post Types**: Park post type registration and features

## Access

- WordPress: http://localhost:8888
- Admin: http://localhost:8888/wp-admin (admin/password)
