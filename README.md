# Changelog
*A Changelog Addon Module for the Chaos MVC*

![PHP](https://img.shields.io/badge/PHP-8%2B-blue)
![Architecture](https://img.shields.io/badge/Architecture-MVC-darkgreen)
![Status](https://img.shields.io/badge/Status-Active%20Development-orange)
![License](https://img.shields.io/badge/License-TBD-lightgrey)
![Sponsored](https://img.shields.io/badge/Created-Poe_Mei-blue)

# Install
1. Install the module beneath `/user/modules/changelog`.
2. Use `sql/schema.sql` with the database installation process selected for the domain.
3. Log into Admin and open Changelog.
4. Add the first changelog entry.
5. Navigate to `/changelog` to view it.

 - This does depend on the Chaos MVC built-in **Markdown Rendering**
 
 ## Directory
 - Comes with both admin and public views

## Security and lifecycle

All Admin writes use explicit POST actions with CSRF verification. The
module-owned `changelog` table is declared for Core-controlled Nuke.

## Version

1.0.6
