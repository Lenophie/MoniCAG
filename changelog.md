# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [0.14.0] - Unreleased

* Testing
    * Dusk setup.

## [0.13.0] - 2018-10-07

### Added

* Readme
    * General presentation.
    * French version.
    * Link to license file.
* Validation
    * New borrowing
        * Rules for notes field.
* Testing
    * Unit tests for notes field rules of new borrowing request.
    * New borrowing request.
    * End borrowing request.
    * Add inventory item request.
    * Patch inventory item request.
    * Delete inventory item request.
    * Patch user request.
    * Delete user request.
    
### Changed

* Edit user request
    * Renamed to Patch user request in controller, tests and language files.

### Removed

* Testing
    * Useless (and incorrect) namespace for unit tests.

## [0.12.0] - 2018-10-06

### Added

* Routing
    * Redirection to 401 error page for non-GET requests made by guests.
* Testing
    * Pages access tests.
    * Requests authentication tests.
    * New borrowing validation tests.
    * End borrowing validation tests.
    * Add inventory item validation tests.
    * Delete inventory item validation tests.
    * Patch inventory item validation tests.
    * Edit user validation tests.
    * Delete user validation tests.
* Models factories
    * Users.
    * Inventory items.
    * Borrowing.
    * Genre.
* Validation
    * General
        * Custom messages for integers in arrays validation.
        * ```bail``` validation rule for fields with custom validations rules.
        * Reworded some custom messages.
        * Inverted order of exist and distinct rules to prevent errors in replacers.
    * Register
        * Promotion must now be within an acceptable range.
    * New borrowing
        * Existence rule for borrowed items.
    * End borrowing
        * New custom rule to check if a borrowing to end isn't already declared as finished.
    * Add inventory item
        * Check uniqueness of names in database.
    * Patch inventory item
        * Check type of names.
        * Check uniqueness of names in database.
* TODO items
    * Usage of before and after borrowing notes.
    * Add confirmation modal when editing own role in "Edit users".
    
### Changed

* End borrowing routes
    * HTTP verb ```POST``` to ```PATCH```.
    * Refactored the two previously-```POST``` routes to one.
* Validation
    * General
        * Simplified some custom validators thanks to ```bail``` rule addition for relevant fiels.
    * New borrowing
        * Simplified regex validation for guarantee.
    * Add inventory item
        * Improved validation rules.
    * Patch inventory item
        * Improved validation rules.
    
### Fixed

* New borrowing
    * Start date of the borrowing.
        * Problem : The app doesn't correctly handle delayed borrowings as it is setting the items as borrowed when creating the borrowing regardless of the start date.
        * Solution : Forbid having a start date different from the current date when creating a borrowing.
        * Implementation : Remove the field from the form and update its related model attribute setting, validation rules and translation files.
    * Error in custom validator ```InventoryItemAvailable```.
        * Problem : When a non-integer is fed to the validator, an error is thrown when trying to find the corresponding inventory item.
        * Solution : Prevent non-integers from being fed to the validator.
        * Implementation : Add ```bail``` rule to relevant field in ```NewBorrowingRequest```.
    * Inventory item name not being displayed in ```InventoryItemAvailable``` error message.
* Edit inventory view
    * Typo in deletion warning message.
    * Line breaks in deletion warning message.
    * Error not displayed for "Players max" field when patching.
* Validators
    * Made the type conversions symmetrical in UnchangedDuringBorrowing validator.
* Changelog
    * Dates from the future. (*Thanks Spooktober*)

## [0.11.0] - 2018-10-01

### Added

* End borrowing validation
    * A user can't confirm the return of its own borrowings.
* Edit inventory view
    * Minimal width of tables for better responsiveness.
* Edit users view
    * Layout.
    * Errors displaying.
* Edit users controller
    * Users updating and deletion.
* Edit users validation
    * Check for admin self-modification.

### Removed

* Edit inventory view
    * Hiding of some elements for small viewports.

## [0.10.0] - 2018-09-29

### Added

* New borrowing validation
    * Check if borrowed items are distinct.
* End borrowing validation
    * Check if borrowings to end are distinct.
* Edit inventory view
    * Layout.
* Edit inventory controller
    * Adding, updating and deleting inventory items.
* Edit inventory validation
    * When adding new item.
    * When patching existing item.
    * When deleting existing item.
* Edit inventory routing
    * ```POST```, ```PATCH``` and ```DELETE``` routes.
* End borrowing validation
    * Check if the borrowed items' new status is correct.
* Translation files
    * English attributes aliases.

### Changed

* New borrowing view
    * Sorting games by name.
* Inventory view
    * Sorting games and genres by name.
    * Minimum value of players filter input from 0 to 1.
* Language files
    * Sorted validation messages by relevant request.
    
### Fixed

* Inventory item name mutators.
* Inventory item statuses used when ending borrowing.
* Request authorizations.

### Removed

* Compiled ```js``` files from ```git``` tracking
    * Added ```.gitignore``` file for future commits.

## [0.9.0] - 2018-09-26

### Added

* End borrowing view
    * Message when no current borrowing.
* Home view
    * MoniCAG ```GitHub``` link.
* Authentication
    * Laravel built-in tools.
    * Pages access.
    * Lender ids used for borrowings.
    * Validating borrower for borrowing.
* Full english translation

### Fixed

* New borrowing view
    * Genre filtering.

## [0.8.0] - 2018-09-21

### Added

* New borrowing view
    * Borrower authentication button.
* View inventory view
    * Layout.
    * Data displaying.
    * Filtering.
* Inventory model
    * Duration, number of players for each inventory item.
    * Games genres pivot and reference tables.

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
    * ```CSS``` for new borrowing view.

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