# MenuScanOrder

A SaaS platform that allows restaurant and cafe owners to digitize their menu and manage orders through QR codes. Customers can scan a QR code to browse the menu and place orders directly from their phone, while staff can manage and track all incoming orders in real time through a management console.

## Features

- QR code generation for menu items and tables
- Customer-facing menu browsing and order placement
- Staff order management and tracking dashboard
- Real-time order status updates
- Menu and item management for business owners

## Tech Stack

- **Backend:** PHP, CodeIgniter 4
- **Database:** PostgreSQL
- **Frontend:** HTML, CSS, JavaScript

## Getting Started

### Requirements

- PHP 8.1 or higher
- Composer
- PostgreSQL

### Installation

1. Clone the repository
   git clone https://github.com/athaqilmakarim/MenuScanOrder.git

2. Install dependencies
   composer install

3. Set up environment
   cp env .env

4. Update .env with your database credentials and base URL

5. Run the development server
   php spark serve

The app will be available at http://localhost:8080

## Project Structure

- app/ — Controllers, models, views, and config
- public/ — Publicly accessible assets and entry point
- tests/ — Test files
- writable/ — Cache, logs, and uploads

## License

MIT
