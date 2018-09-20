# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [0.8.0] - Unreleased

### Added

* New borrowing view
    * Borrower authentication button

### Changed

* Borrowings history view
    * Table styling.

## [0.7.0] - 2019-09-20

### Added

* Language pack
    * French
    * English validation messages.
    * Made french the default language pack.
* Validation
    * Regular expression to validate the number of decimals (2 maximum).
    * Check for inventory items availability before allowing the borrowing.
* New borrowing view
    * Displaying of errors linked to inventory items availability.
* Borrowings history view
    * List filling.
* Borrowings history request
    * Joining return lender to the borrowings usual request.

### Changed

* Querying
    * Eloquent syntax for the query requesting all the inventory items.
* Validation
    * Moved error messages from requests to language packs.
* Home view
    * Layout.

### Fixed

* Configuration
    * Project name was not set in configuration.
* Database / Model
    * Some columns were in camelCase instead of snake_case.
    
### Removed

* Validation
    * Check for positive number for the guarantee.
        * Handled by the regular expression.

## [0.6.0] - 2019-09-19

### Added

* Views (common)
    * Turned the custom icons in reusable templates.
* New borrowing view
    * Guarantee field
        * Pattern check for decimal value.
        * Handling of comma-separation before parsing.
        * Positive number validator.
        * More validation messages.
    * Expected return date field
        * Comparison to start date for validation.
    * Better validation.
* End borrowing view
    * Current borrowings list
    * Selection modal
* End borrowing controller
    * Borrowings request.
    * Borrowing + Inventory item update.

### Changed

* New borrowing view
    * Better-looking input groups.
    * Calendar icons.

### Fixed

* Seeds
    * User role for user seeding wasn't a constant from ```UserRole```.
    
### Removed

* Database / Model
    * Removed borrowing statuses in favor of a boolean ```finished```.

## [0.5.0] - 2018-09-16

### Added

* Views (Common)
    * Blade components for menu buttons and modals.
    * Template for headers.
    * Basic layout.
* New borrowing view
    * Checkout filling.
    * Inventory request.
    * Fuzzy games search.
    * Borrowing post.
* Controllers
    * Templates.
    * New borrowing store function.
* Requests
    * New borrowing validation.
* Database
    * Access configuration.
    * Tables creation.
    * Reference tables seeding.
    * Inventory items and users seeding for local environment.
* Public
    * CSS for new borrowing view.

### Changed

* Views
    * Main menu colors.
    * Titles.
    
### Fixed

* Views
    * Header blade condition statements.

## [0.4.1] - 2018-09-05

### Fixed

* Main menu
    * Favicon missing.
    * Title font-weight.
    * Mobile view-port meta-tag.

## [0.4.0] - 2018-09-05

### Added

* Framework
  * Laravel

### Changed

* Main menu
  * Inventory buttons layout.
* Documentation
  * ```UML``` diagram.

## [0.3.2] - 2018-09-04

### Fixed

* Documentation
  * ```UML``` diagram.

## [0.3.1] - 2018-09-04

### Changed

* Project Architecture
  * ```ESDoc``` sources for manuals are now approprietaly in the ```src``` folder.

### Fixed

* Documentation
  * ```UML``` diagram.

## [0.3.0] - 2018-09-04

### Added

* Back-End
  * Database ```SQL``` seed.
* Documentation
  * ```ESDoc``` setup.
  * ```UML``` diagram.

## [0.2.1] - 2018-09-03

### Added

* Development environment
  * ```VSCode``` project settings.

### Fixed

* Changelog link in readme file.

## [0.2.0] - 2018-09-03

### Added

* Development environment
  * ```Webpack```.
  * ```ESLint```.
  * ```Babeljs```.
* Main menu
  * Layout.
  * Colors.

## [0.1.0] - 2018-09-03

* Project creation.