* Features
    * Major
        * Add games proposition page
            * Handle partnerships with local games stores ?
        * Handle inventory items condition
        * Add account personal space
            * Display all personal information
                * Current and past borrowings
                * Personal logs
            * Allow easy profile deletion
    * Minor
        * Night theme
        * Build a custom CSS file for flag icons that only contains the required ones.
        * Search features and pagination in "Borrowings History" view
        * Add a super admin role who can only remove admins
        * Toggle display of before and after notes in "Borrowings History" view
        * Display before notes in "End Borrowing" view
        * Allow games evaluation by users
        * Display server error messages (>500)
        * Logging
            * Inventory movements
            * Users modification
        * Confirmation modal when modifying own role in "Edit users" view
        * Confirmation modal when deleting a user in "Edit users" view
        * SMS borrowings reminder
* Testing
    * Setup continuous integration
* Refactoring
    * Use ```Vue``` to manage ```DOM``` elements
* Dependencies
    * Replace ```Bootstrap``` with ```Bulma```
    * Remove ```jQuery```