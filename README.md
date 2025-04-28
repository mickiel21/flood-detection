# Flood Detection System

## Introduction
Welcome to the **Flood Detection System** repository. This guide will help you set up your local development environment efficiently.

## Prerequisites
Ensure your system has the following installed:
- **PHP** 8.2
- **Node.js** v18.18.2
- **npm** 9.8.1
- **Composer**

## Installation Instructions

### 1. Clone the Repository
```sh
git clone git@github.com:mickiel21/flood-detection.git
cd flood-detection
code .

DB_DATABASE="your_repo_name"

composer install
npm install

php artisan migrate

php artisan db:seed

npm run dev

php artisan optimize:clear