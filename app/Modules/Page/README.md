# Page Module

This module manages static pages like 'About Us' and 'Contact'.

## Features

- Admin CRUD for pages
- Frontend display of pages

## File Structure

```
Page/
├── Config/
│   └── Routes.php
├── Controllers/
│   ├── Admin/
│   │   └── PageController.php
│   └── Frontend/
│       └── PageController.php
├── Models/
│   └── PageModel.php
├── Entities/
│   └── Page.php
├── Database/
│   ├── Migrations/
│   │   └── ...CreatePages.php
│   └── Seeds/
│       └── PageSeeder.php
├── Views/
│   └── frontend/
│       └── show.php
├── Language/
│   ├── de/Page.php
│   ├── en/Page.php
│   └── tr/Page.php
└── README.md
```
