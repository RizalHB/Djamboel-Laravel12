# 🐔 D'Jamboel Ayam Potong — Business Management System

<p align="center">
  <strong>Web-Based Business Management & Business Analysis System for UMKM Broiler Chicken Business</strong>
</p>

<p align="center">
  A centralized application for managing sales, purchases, inventory, operational expenses, revenue, profit & loss, and business performance analysis.
</p>

---

## 📋 Table of Contents

* [About the Project](#-about-the-project)
* [Project Background](#-project-background)
* [Project Objectives](#-project-objectives)
* [Key Features](#-key-features)
* [Business Workflow](#-business-workflow)
* [Application Modules](#-application-modules)
* [Screenshots](#-screenshots)
* [Business Scale](#-business-scale)
* [Business Insights](#-business-insights)
* [Technology Stack](#️-technology-stack)
* [System Architecture](#️-system-architecture)
* [Installation](#️-installation)
* [Environment Configuration](#️-environment-configuration)
* [Running the Application](#️-running-the-application)
* [Future Improvements](#-future-improvements)
* [Project Purpose](#-project-purpose)
* [Contributing](#-contributing)
* [License](#-license)

---

# 📌 About the Project

**D'Jamboel Ayam Potong Business Management System** is a web-based business management application developed for **D'Jamboel Ayam Potong**, a micro-scale (UMKM) broiler chicken business.

The application is designed to help the business owner manage and monitor important business activities in one centralized system, including:

* Supplier management
* Customer management
* Purchase transactions
* Sales transactions
* Remaining inventory
* Operational expenses
* Revenue
* Profit and loss
* Sales reports
* Business performance analysis
* Graphical business insights

The system transforms daily business transactions into structured information that can be used to evaluate the financial and operational condition of the business.

Rather than relying entirely on manual records or separate spreadsheets, the application provides an integrated platform where transaction data, inventory information, expenses, revenue, and business analysis can be managed together.

---

# 🏢 Project Background

D'Jamboel Ayam Potong operates as a micro-scale broiler chicken business where daily activities involve purchasing chickens or inventory, managing stock, selling products to customers, and handling various operational expenses.

As the number of transactions increases, manually recording and analyzing these activities can become difficult.

This application was developed to address those challenges by providing a centralized business information system capable of recording transactions and generating meaningful reports.

The system supports approximately:

| Business Aspect                       |                 Supported Scale |
| ------------------------------------- | ------------------------------: |
| Broiler chickens per production cycle |          **500–1,000 chickens** |
| Expense & inventory records           |           **50+ records/month** |
| Reporting                             |      **Monthly & period-based** |
| Sales tracking                        |                  Customer-based |
| Purchase tracking                     |                  Supplier-based |
| Inventory                             |      Remaining stock monitoring |
| Financial analysis                    | Revenue, expenses & profit/loss |
| Business analysis                     |         Reports & visual charts |

---

# 🎯 Project Objectives

The main objectives of this application are:

1. **Centralize business data**
   Store sales, purchases, inventory, supplier, customer, and expense information in one system.

2. **Improve transaction management**
   Simplify the process of recording purchase and sales transactions.

3. **Monitor inventory**
   Help the business owner track remaining stock after purchasing and sales activities.

4. **Monitor operational expenses**
   Provide structured records of expenses incurred during business operations.

5. **Generate financial reports**
   Provide revenue, expense, and profit/loss information for a selected period.

6. **Provide business analysis**
   Transform transaction data into useful information through reports and graphical visualizations.

7. **Support business decisions**
   Help the owner understand business performance and make better operational and financial decisions.

---

# 🚀 Key Features

## 📊 1. Business Dashboard

The dashboard provides a centralized overview of the business.

It allows the user to quickly monitor important information such as:

* Sales performance
* Revenue
* Purchases
* Operational expenses
* Remaining inventory
* Business performance
* Financial summaries

The goal of the dashboard is to provide a quick snapshot of the current business condition without requiring the user to review individual transactions.

---

## 🚚 2. Supplier Management

The Supplier Management module manages supplier-related information used in purchasing activities.

### Features

* Add supplier records
* View supplier information
* Manage supplier data
* Connect suppliers with purchase transactions
* Paginated supplier listing

This module provides a structured way to maintain supplier information and supports better organization of purchasing records.

---

## 👥 3. Customer Management

The Customer Management module manages customers associated with sales transactions.

### Features

* Customer records
* Customer information management
* Customer-related sales transactions
* Customer listing
* Pagination

Customer data can be used to identify who is involved in sales transactions and maintain a history of customer-related business activities.

---

## 🐔 4. Remaining Stock / Inventory Management

Inventory management is one of the core components of the system.

The application monitors the remaining stock of broiler chickens after purchasing and sales transactions.

### Features

* Remaining stock monitoring
* Inventory records
* Stock-related transaction information
* Paginated inventory data
* Stock overview

This allows the business owner to understand the current inventory condition and make better purchasing and sales decisions.

---

## 📦 5. Purchase Management

The Purchase Management module records purchases made by the business.

### Features

* Purchase transaction recording
* Supplier-related purchases
* Purchase history
* Inventory-related purchase records
* Paginated purchase data

Purchase information also contributes to the calculation of business expenses and overall financial performance.

---

## 💰 6. Sales Management

The Sales Management module records sales transactions made with customers.

### Features

* Sales transaction recording
* Customer-related sales
* Sales history
* Revenue tracking
* Paginated sales records
* Sales visualization

Sales data becomes an important source for calculating revenue and evaluating business performance.

---

## 💸 7. Operational Cost Management

The Operational Cost module is used to record expenses associated with running the business.

Examples may include:

* Transportation costs
* Labor expenses
* Electricity
* Equipment maintenance
* Packaging
* Operational materials
* Other business expenses

These records are used as part of the financial analysis and profit/loss calculation.

---

## 📈 8. Sales & Revenue Reporting

The reporting module provides information about revenue generated from sales.

Reports can be used to review:

* Total sales
* Revenue
* Sales activity
* Sales performance
* Revenue trends
* Selected-period results

---

## 📊 9. Business Performance Analysis

The Business Analysis module combines business data to provide a broader understanding of company performance.

The analysis can include:

* Revenue
* Purchases
* Operational costs
* Expenses
* Profit/loss
* Sales performance
* Inventory information
* Business trends

The information is presented through reports and graphical visualizations.

---

## 🧮 10. Profit & Loss

The system provides a simplified financial overview by comparing revenue and expenses.

The basic business calculation can be represented as:

```text
Revenue
   │
   ├── Sales Income
   │
   ▼
Total Revenue
   │
   │
   ├── Purchase Costs
   ├── Operational Costs
   └── Other Expenses
   │
   ▼
Total Expenses
   │
   ▼
Profit / Loss
```

This allows the owner to evaluate whether the business is generating a profit or experiencing a loss during a particular period.

---

# 🔄 Business Workflow

The overall business process supported by the application can be represented as:

```text
                    ┌──────────────┐
                    │   Supplier   │
                    └──────┬───────┘
                           │
                           ▼
                 ┌──────────────────┐
                 │ Purchase Records │
                 └────────┬─────────┘
                          │
                          ▼
                 ┌──────────────────┐
                 │    Inventory     │
                 │ Remaining Stock  │
                 └────────┬─────────┘
                          │
                          ▼
                 ┌──────────────────┐
                 │ Sales Transaction│
                 └────────┬─────────┘
                          │
                          ▼
                 ┌──────────────────┐
                 │     Revenue      │
                 └────────┬─────────┘
                          │
                          │
          ┌───────────────┴────────────────┐
          │                                │
          ▼                                ▼
┌────────────────────┐          ┌────────────────────┐
│ Operational Costs  │          │ Business Expenses  │
└──────────┬─────────┘          └──────────┬─────────┘
           │                               │
           └───────────────┬───────────────┘
                           ▼
                  ┌─────────────────┐
                  │ Business Report │
                  └────────┬────────┘
                           │
                           ▼
                  ┌─────────────────┐
                  │ Business        │
                  │ Analysis        │
                  └────────┬────────┘
                           │
                           ▼
                  ┌─────────────────┐
                  │ Profit / Loss & │
                  │ Performance     │
                  └─────────────────┘
```

---

# 🧩 Application Modules

```text
D'Jamboel Ayam Potong
│
├── 📊 Dashboard
│   ├── Business Overview
│   ├── Revenue Summary
│   ├── Expense Summary
│   └── Inventory Summary
│
├── 🚚 Supplier Management
│   ├── Supplier Data
│   └── Supplier Pagination
│
├── 👥 Customer Management
│   ├── Customer Data
│   └── Customer Pagination
│
├── 🐔 Inventory
│   └── Remaining Stock
│
├── 📦 Purchase Management
│   ├── Purchase Data
│   └── Purchase History
│
├── 💰 Sales Management
│   ├── Sales Data
│   ├── Sales History
│   └── Sales Chart
│
├── 💸 Operational Costs
│   └── Expense Records
│
└── 📈 Reports & Analysis
    ├── Sales / Revenue Report
    ├── Business Analysis
    ├── Profit / Loss
    └── Performance Charts
```

---

# 🖥️ Screenshots

> **Google Drive image hosting:** The screenshots below are embedded directly from Google Drive, so the image files do not need to be stored inside this repository.
>
> Make sure every Google Drive image has sharing permission set to **Anyone with the link → Viewer**.

---

## 1. 🚚 Supplier Management

### 1.1 Supplier Dashboard

The Supplier Dashboard provides an overview of registered suppliers and supplier-related information.

![Supplier Dashboard](https://drive.google.com/thumbnail?id=1Qs0oJtJJDSRWFvgnCaTT1NWCDXcOKBuj\&sz=w1200)

*Supplier Dashboard — overview of supplier records and supplier information.*

### 1.2 Supplier Pagination — Page 1

Pagination is used to make larger supplier datasets easier to navigate.

![Supplier Pagination 1](https://drive.google.com/thumbnail?id=1EUmIbeTxmPN1z_j_95Vxm0yniI34pLA5\&sz=w1200)

*Supplier Pagination — first page of supplier records.*

### 1.3 Supplier Pagination — Page 2

The second pagination view demonstrates navigation through additional supplier records.

![Supplier Pagination 2](https://drive.google.com/thumbnail?id=1WvXx6l7Px7ZWYXO5e4COeqNypfNFIGxg\&sz=w1200)

*Supplier Pagination — additional supplier records.*

---

## 2. 👥 Customer Management

### 2.1 Customer Dashboard

The Customer Dashboard provides an organized interface for managing customer information.

![Customer Dashboard](https://drive.google.com/thumbnail?id=1dbGh1_A1qr34rIYZIlnvKdtC_6Mm9g27\&sz=w1200)

*Customer Dashboard — overview of customer records.*

### 2.2 Customer Pagination — Page 2

Pagination allows the application to efficiently display larger customer datasets.

![Customer Pagination 2](https://drive.google.com/thumbnail?id=1L_HkVlVXVwGvijsdLpPriGk2iSJUSpBd\&sz=w1200)

*Customer Pagination — additional customer records.*

---

## 3. 🐔 Remaining Stock

### 3.1 Remaining Stock Dashboard

The Remaining Stock Dashboard provides an overview of current inventory available in the business.

![Remaining Stock Dashboard](https://drive.google.com/thumbnail?id=1USBOAUYz97ed20tWGaDovmHRldTJaP2D\&sz=w1200)

*Remaining Stock Dashboard — overview of current inventory.*

### 3.2 Remaining Stock — Pagination 2

The inventory listing supports pagination for easier navigation through stock records.

![Remaining Stock Pagination 2](https://drive.google.com/thumbnail?id=12FRXyWoxFJSGnX-qZwl9Pgm2EpVEpWX1\&sz=w1200)

*Remaining Stock Pagination — additional inventory records.*

---

## 4. 📦 Purchase Management

### 4.1 Purchase Data

The Purchase Data page displays purchasing transactions recorded by the business.

![Purchase Data](https://drive.google.com/thumbnail?id=177NaxuyE-3lEoS-WdWJ9G7UL9-KR6xTD\&sz=w1200)

*Purchase Data — purchase transaction records.*

### 4.2 Purchase Data — Pagination 2

Additional purchase transactions can be accessed through pagination.

![Purchase Data Pagination 2](https://drive.google.com/thumbnail?id=16Ufm12yOkNy69X_o3ScNgfYr-8nm6s3C\&sz=w1200)

*Purchase Pagination — additional purchase transaction records.*

---

## 5. 💰 Sales Management

### 5.1 Sales Data

The Sales Data page provides a structured listing of sales transactions.

![Sales Data](https://drive.google.com/thumbnail?id=1sD4AkofsESkWGi3urXEG0dMwNLnHzKep\&sz=w1200)

*Sales Data — sales transaction records.*

### 5.2 Sales Data — Pagination 2

Pagination allows users to efficiently navigate through historical sales records.

![Sales Data Pagination 2](https://drive.google.com/thumbnail?id=1CjOuAJ7d6oO66sCX0c03gDW_AZLZGe_Y\&sz=w1200)

*Sales Pagination — additional sales records.*

### 5.3 Sales Data Chart

The Sales Data Chart visualizes sales activity and helps users identify sales trends.

![Sales Data Chart](https://drive.google.com/thumbnail?id=16SzqQqCWiI9wmUjojquHPlAP19j6gLCB\&sz=w1200)

*Sales Data Chart — graphical visualization of sales performance.*

---

## 6. 💸 Operational Cost

### 6.1 Operational Cost Data

The Operational Cost page records expenses associated with the daily operation of the business.

![Operational Cost Data](https://drive.google.com/thumbnail?id=1NLVGAmkrpkuts6c9oL_6Ob7VfAnQJNOO\&sz=w1200)

*Operational Cost Data — business operational expense records.*

---

## 7. 📈 Reports & Business Analysis

### 7.1 Sales Report — Revenue

The Sales Report provides an overview of revenue generated from sales transactions during a selected period.

![Sales Report](https://drive.google.com/thumbnail?id=1BdcSJGt2_09v_yVXa7BHtm2JuhiSllYb\&sz=w1200)

*Sales Report — revenue and sales performance information.*

### 7.2 Business Analysis Report

The Business Analysis Report combines business information to provide insights into financial and operational performance.

![Business Analysis Report](https://drive.google.com/thumbnail?id=1hyDK3RNnU4rL96bW1WTCDy3Hci2c19Yl\&sz=w1200)

*Business Analysis Report — analysis of business performance.*

### 7.3 Business Analysis Chart

The Business Analysis Chart presents analytical information visually, making it easier to understand business trends and performance.

![Business Analysis Chart](https://drive.google.com/thumbnail?id=1sga0HQ9by7FWlpZaWOSliyx1RlRy_cZG\&sz=w1200)

*Business Analysis Chart — graphical representation of business analysis.*

---

# 📊 Business Scale

The application is designed around the operational requirements of a micro-scale broiler chicken business.

### Production

The system supports approximately:

**500–1,000 chickens per production cycle**

### Monthly Data

The system is designed to handle approximately:

**50+ expense and inventory records per month**

### Reporting

Business reports can be generated to help monitor:

* Monthly revenue
* Monthly expenses
* Profit/loss
* Sales performance
* Inventory
* Operational costs
* Business trends

---

# 💡 Business Insights

One of the main purposes of this application is not simply to store transaction data, but to turn that data into useful business information.

The system can help answer questions such as:

### 💰 Revenue

> How much revenue did the business generate during a specific period?

### 🐔 Inventory

> How much stock is currently available?

### 📦 Purchases

> How much has been spent on purchasing inventory?

### 💸 Expenses

> How much money is being spent on operational activities?

### 📈 Profitability

> Is the business generating a profit or a loss?

### 📊 Performance

> How is the business performing from month to month?

### 🎯 Decision Making

> What information should be considered when making future purchasing and operational decisions?

This approach changes the system from a simple transaction-recording application into a **business decision-support tool**.

---

# 🛠️ Technology Stack

The project is built using the following technologies:

| Technology           | Purpose                           |
| -------------------- | --------------------------------- |
| **Laravel**          | Backend web application framework |
| **PHP**              | Server-side programming           |
| **MySQL**            | Relational database               |
| **Blade**            | Laravel templating engine         |
| **HTML5**            | Application structure             |
| **CSS3**             | Styling and layout                |
| **JavaScript**       | Client-side interactions          |
| **Charting Library** | Sales and business visualization  |

> Update the table if the project uses a specific frontend framework, CSS framework, charting library, or database version.

---

# 🏗️ System Architecture

The application follows a typical Laravel web application architecture.

```text
┌───────────────────────────────┐
│           User                │
│      Business Owner           │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│          Web Browser          │
│       User Interface          │
└───────────────┬───────────────┘
                │
                ▼
┌───────────────────────────────┐
│           Laravel             │
│                               │
│ ┌───────────┐ ┌────────────┐ │
│ │  Routes   │ │ Controllers│ │
│ └───────────┘ └──────┬─────┘ │
│                      │       │
│               ┌──────▼─────┐ │
│               │   Models   │ │
│               │ Eloquent   │ │
│               └──────┬─────┘ │
└──────────────────────┼────────┘
                       │
                       ▼
              ┌────────────────┐
              │     MySQL      │
              │    Database    │
              └────────────────┘
```

---

# 🗄️ Main Data Domains

The application's data can be grouped into several major domains:

```text
Master Data
│
├── Suppliers
└── Customers

Transactions
│
├── Purchases
└── Sales

Inventory
│
└── Remaining Stock

Expenses
│
└── Operational Costs

Reports
│
├── Revenue
├── Expenses
├── Profit / Loss
└── Business Performance
```

These domains work together to provide an integrated view of the business.

---

# ⚙️ Installation

## Requirements

Before installing the project, make sure your development environment has:

* PHP
* Composer
* MySQL
* Node.js
* npm
* Git
* Laravel-compatible web server

---

## 1. Clone the Repository

```bash
git clone https://github.com/your-username/your-repository.git
cd your-repository
```

Replace the repository URL with the actual GitHub repository URL.

---

## 2. Install PHP Dependencies

```bash
composer install
```

---

## 3. Install Frontend Dependencies

```bash
npm install
```

---

## 4. Create Environment File

Copy the example environment file:

```bash
cp .env.example .env
```

For Windows:

```powershell
copy .env.example .env
```

---

## 5. Generate Application Key

```bash
php artisan key:generate
```

---

# 🔧 Environment Configuration

Configure the database connection inside `.env`:

```env
APP_NAME="D'Jamboel Ayam Potong"
APP_ENV=local
APP_KEY=
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Make sure the database specified in `DB_DATABASE` already exists.

---

# 🗃️ Database Migration

Run the database migrations:

```bash
php artisan migrate
```

If the project contains seed data:

```bash
php artisan db:seed
```

Or run both together:

```bash
php artisan migrate --seed
```

---

# 🎨 Build Frontend Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

---

# ▶️ Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

The application will then be available through the local Laravel development server.

---

# 🔐 Security Considerations

When deploying this application to a production environment:

* Never commit `.env` to Git.
* Use strong database credentials.
* Keep Laravel and PHP dependencies updated.
* Use HTTPS.
* Implement appropriate authentication and authorization.
* Validate all user input.
* Restrict access to sensitive financial information.
* Regularly back up the database.
* Configure appropriate production error handling.

---

# 🚧 Future Improvements

Potential improvements for future versions include:

* [ ] Role-based access control
* [ ] Advanced user authentication
* [ ] PDF report export
* [ ] Excel report export
* [ ] Automated monthly reports
* [ ] Inventory low-stock notifications
* [ ] Sales forecasting
* [ ] Inventory forecasting
* [ ] Customer purchase history
* [ ] Supplier performance analysis
* [ ] Production-cycle management
* [ ] Automated database backup
* [ ] Mobile-responsive improvements
* [ ] Advanced profit/loss analysis
* [ ] More detailed financial dashboards
* [ ] Multi-user business management

---

# 🎓 Project Purpose

This project demonstrates the implementation of a web-based information system for the operational and financial management of a real-world **UMKM broiler chicken business**.

The application focuses on more than simply recording transactions.

Its main concept is:

```text
Business Transactions
        ↓
   Data Collection
        ↓
   Data Processing
        ↓
      Reports
        ↓
 Business Analysis
        ↓
 Better Decisions
```

By combining transaction management, inventory monitoring, financial reporting, and business analysis, the system provides a foundation for more structured and data-driven business management.

---

# 🤝 Contributing

Contributions, suggestions, and improvements are welcome.

To contribute:

1. Fork the repository.
2. Create a feature branch.
3. Implement your changes.
4. Test the changes.
5. Commit your changes.
6. Push the branch.
7. Create a Pull Request.

Example:

```bash
git checkout -b feature/new-feature

git add .

git commit -m "feat: add new feature"

git push origin feature/new-feature
```

---

# 📄 License

This project is developed for the operational and business management needs of **D'Jamboel Ayam Potong**.

If this repository is intended to be open source, specify the appropriate license here.

For example:

```text
MIT License
```

> Replace this section with the actual license applicable to the project.

---

# 👨‍💻 Project Information

| Information          | Details                                          |
| -------------------- | ------------------------------------------------ |
| **Project Name**     | D'Jamboel Ayam Potong Business Management System |
| **Business Type**    | UMKM — Broiler Chicken Business                  |
| **Application Type** | Web-Based Business Management System             |
| **Primary Users**    | Business Owner / Administrator                   |
| **Main Purpose**     | Business & Transaction Management                |
| **Core Functions**   | Sales, Purchases, Inventory, Expenses, Reports   |
| **Analysis**         | Revenue, Profit/Loss & Business Performance      |
| **Production Scale** | 500–1,000 chickens/cycle                         |
| **Monthly Records**  | 50+ expense & inventory records                  |

---

# ⭐ Conclusion

**D'Jamboel Ayam Potong Business Management System** provides an integrated solution for managing the operational and financial activities of a micro-scale broiler chicken business.

By connecting **suppliers, customers, purchases, sales, inventory, expenses, revenue, reports, and business analysis** in one system, the application helps transform daily business records into actionable information.

The ultimate goal is to help the business operate more efficiently, maintain better records, understand its financial performance, and make more informed business decisions.
