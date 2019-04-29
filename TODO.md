# Features
## Major
* Add games proposal page
    * Handle partnerships with local games stores ?
* Handle inventory items condition
* Add and remove genres from "Edit inventory" view
    * Add a command to seed the genres used in local environments
* Send emails to late borrowers and alert lenders when ignored for too long
* Allow users to ask for admin or lender rights
* Add validation messages after being redirected
    * "Borrowing successfully store", "Game information successfully modified", "Password changed"...
## Minor
* Finish Docker setup
    * Cache routes
    * Migrate database
* Add games' language
* Improve games naming system
    * Instead of forcing users to enter the games names in each language, allow to add alternate titles
    * When searching games, alternate names should be used
* Display only one number when max and min players are equal for a game
* Allow user to pick between "average duration" and "min and max durations" when setting or changing the duration of a game
* Fix bug when filtering games by duration in "View inventory" view
    * Example : 2-? players games don't show up when looking for games with 3 players
        * +Replace notation by >2 in this case
* Display a counter of current borrowing from the "Home" page
    * Separate late ones
* Search features and pagination in "Borrowings History" view
* Enable blacklisting users from making borrowings
* Add a super admin role who can only remove admins
* Toggle display of before and after notes in "Borrowings History" view
* Display before notes in "End Borrowing" view
* Allow games evaluation by users
* Display server error messages (>500)
* Prevent browsers autofill of password and email fields when registering and creating a new borrowing
* Re-arrange mobile version, especially inventory edition page
* Logging
    * Inventory movements
    * Users modification
* Confirmation modal when modifying own role in "Edit users" view
* Confirmation modal when deleting a user in "Edit users" view
* SMS borrowings reminder
* Translations
    * Chinese
    * Brazilian
* Personal information
    * Display past borrowings
    * Display logs
* Inject request method in forms with @method
# Testing
* Add unit tests for error displaying in views
* Move cascading deletion assertions present in requests tests to their own unit test.
