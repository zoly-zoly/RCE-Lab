# Getting Started & Installation

This guide walks you through setting up the **RCE Masterclass Lab Suite** locally for security training and research.

## Prerequisites

- **PHP 8.0 or higher** installed on your system.
- **cURL** (optional, for running automated smoke tests).

## Installation

1. Clone or download the repository:
   ```bash
   git clone https://github.com/your-username/RCE-Lab.git
   cd RCE-Lab
   ```

2. Start the local development server:
   ```bash
   php -S localhost:8080 -t .
   ```

3. Open your browser and navigate to:
   ```text
   http://localhost:8080
   ```

## Running Automated Tests

To ensure all endpoints are functioning correctly, you can execute the built-in smoke test suite:
```bash
php tests/smoke_test.php
```
