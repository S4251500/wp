# Process Evidence Log

This file combines:
1. Debugging records
2. AI (e.g., Copilot/ChatGPT) usage logs

You must maintain this file throughout development.

---

## General Instructions
- Record entries as you work (not at the end)
- Be honest and specific
- Link to commits.Each debugging record must include at least one related GitHub commit 
(using commit hash and URL).
- Superficial or fabricated entries will not receive marks

---

# 🔧 Section 1: Debugging Records

## Bug 1

**Date Identified:**
31/10/2026

**Date Fixed:**
31/10/2026

**File:**
`a3/add.php`

**Related Commit:**
[`6e0b516`](https://github.com/S4251500/wp/commit/6e0b516ae77b69fc2de14f703a495e2abd267ac2)

**Symptom:**
Submitting the add-book form could remain pending until PHP reported a 120-second maximum execution time error while checking for an unused cover identifier.

**Steps to Reproduce:**
Submit a valid new book and cover through `add.php` while using the local database schema.

**Root Cause:**
The upload code was being aligned to a posted schema where `image_path` was a string, while the local `books.image_path` column was an integer. The mismatch made the cover-path collision check incompatible with the local schema; the earlier retry handling did not resolve that mismatch.

**Fix:**
Changed the image reference and collision lookup to use a positive integer matching the local `image_path` column, bound it as an integer, and bounded filename attempts.

**Verification:**
PHP syntax and whitespace checks passed. Five integer filename lookups returned no collisions, and a later check recorded three lookup requests completing without hanging. A complete book insert was not attempted, so successful end-to-end upload was not verified.

---

## Bug 2

**Date Identified:**
31/10/2026

**Date Fixed:**
31/10/2026

**File:**
`a3/add.php`

**Related Commit:**
[`6e0b516`](https://github.com/S4251500/wp/commit/6e0b516ae77b69fc2de14f703a495e2abd267ac2)

**Symptom:**
The add-book cover check failed with MySQL's “Unknown column 'cover_id'” error, preventing a book from being added.

**Steps to Reproduce:**
Submit the add-book form when the local `books` table follows the supplied schema and does not have a `cover_id` column.

**Root Cause:**
The query referenced a `cover_id` field that is not present in the schema; the supplied field for the image identifier is `image_path`.

**Fix:**
Updated the collision check and insert to use `image_path` instead of `cover_id`.

**Verification:**
The Apache error log contained repeated unknown-column errors before the change. PHP syntax and whitespace checks passed afterward, and review confirmed the query and insert use `image_path`. A full book insert was not performed.

---

## Bug 3

**Date Identified:**  
01/11/2026

**Date Fixed:**  
01/11/2026

**File:**  
`a3/register.php`, `a3/login.php`

**Related Commit:**  
[`c79c8ee`](https://github.com/S4251500/wp/commit/c79c8eed6dfb5872a5181edda53f1f773060795e)

**Symptom:**  
Registration displayed “Registration is unavailable right now” because MySQL could not find `users.users`.

**Steps to Reproduce:**  
Submit valid registration details when the configured connection selects the `bookverse` database, where `users` is a table rather than a separate database.

**Root Cause:**  
The registration and login queries qualified the table as `` `users`.`users` ``, although the active connection already selected `bookverse` and the table is named `users` within it.

**Fix:**  
Changed the registration and login queries to reference `users` in the currently selected database.

**Verification:**  
The Apache log confirmed `Table 'users.users' doesn't exist`; PHP syntax and whitespace checks passed after the query correction. A successful live registration and login were not verified.

---

## Bug 4

**Date Identified:**  
01/11/2026

**Date Fixed:**  
01/11/2026

**File:**  
`a3/assets/includes/database_connectivity.inc`, `a3/register.php`, `a3/login.php`

**Related Commit:**
[`445d4b4`](https://github.com/S4251500/wp/commit/445d4b4e52ac4191355dacc2b3c07112f2e6f93f)

**Symptom:**  
After registration failed, the username field showed `root` instead of the username entered by the user.

**Steps to Reproduce:**  
Submit valid registration data on localhost when the database insert fails, then inspect the username field when the form is redisplayed.

**Root Cause:**  
The included database connection file assigned its database account name to `$username`. PHP includes share the caller's variable scope, so that assignment overwrote the form's `$username`.

**Fix:**  
Renamed the connection variables to `$dbHost`, `$dbUsername`, `$dbPassword`, and `$dbName`, keeping database settings separate from form values.

**Verification:**  
The variable collision is present in the earlier code and removed in the linked commit. PHP syntax and whitespace checks passed afterward. A browser retest of an unsuccessful registration was not recorded.

---

## Bug 5

**Date Identified:**
27/10/2026

**Date Fixed:**
01/11/2026

**File:**
`a3/login.php`, `a3/register.php`

**Related Commit:**
[`adac1f6`](https://github.com/S4251500/wp/commit/adac1f60f14e18ad4b399a410bb8a09e07381053)

**Symptom:**
Submitting either account form could create a signed-in session using the submitted username without checking credentials or creating a database account.

**Steps to Reproduce:**
In the historical session-only implementation, submit any username through login or registration and observe that the site redirects to the homepage with that username in the account menu.

**Root Cause:**
The temporary form handlers copied the submitted username directly into the session and redirected without querying or updating the `users` table. The login form's password was not verified.

**Fix:**
Connected registration and login to the `users` table. Registration saves a password hash, and login verifies the stored hash before creating the authenticated session.

**Verification:**
The historical implementation is visible in the earlier code, and the linked commit adds database-backed registration and password verification. The subsequent process record documents invalid-login rejection and rolled-back checks for account insertion, hash verification, and duplicate rejection; a live registration and login were not performed.

---

# 🤖 Section 2: AI Usage Log

## AI Task 1

**Date:**
25/10/2026

**Task Description:**
Add login and registration page layouts and account links to the shared navigation.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Add `login.php` and `register.php` to match the supplied screenshots, reuse existing CSS where possible, and add login and register icons to the shared navigation.

**AI Output Summary:**
Created both page layouts with labelled form fields, added account links with inline SVG icons to the shared navigation, and added matching responsive styles.

**What You Accepted:**
The two page layouts, shared navigation links, inline icons, and responsive styling.

**What You Changed:**
Kept the forms presentation-only because the project does not yet contain account authentication processing or a documented user-table schema.

**Validation Performed:**
Checked both pages with PHP syntax validation and loaded them through the local web server to confirm the shared navigation, page content, and footer render.

**Issues Identified:**
Form submissions are not connected to registration or login processing.

---

## AI Task 2

**Date:**
27/10/2026

**Task Description:**
Create a simple PHP session on login or registration form submission and show a session-aware account dropdown in the shared navigation.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Make login and register submissions create a session without validating or saving the submitted information, and replace the account links with the account name and a logout dropdown while signed in.

**AI Output Summary:**
Added session handling to both form pages, conditional account navigation, a logout endpoint, and matching account-button styling.

**What You Accepted:**
The username-based session display and logout flow.

**What You Changed:**
Removed browser-required and email-format constraints so the forms do not validate the entered fields.

**Validation Performed:**
PHP syntax checks passed for the changed PHP files, and `git diff --check` reported no whitespace errors.

**Issues Identified:**
None identified during syntax and whitespace checks.

---

## AI Task 3

**Date:**
27/10/2026

**Task Description:**
Style the signed-in account dropdown menu

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Make the account dropdown box 

**AI Output Summary:**
Styled the account button and dropdown with dark colors, accent icon, compact dimensions, and hover states.

**What You Accepted:**
The account button icon and custom dark dropdown styling.

**What You Changed:**
Kept the existing logout action rather than adding profile links that do not exist in the project.

**Validation Performed:**
PHP syntax validation passed for the shared navigation include, and `git diff --check` reported no whitespace errors.

**Issues Identified:**
None identified during syntax and whitespace checks.

---

## AI Task 4

**Date:**
31/10/2026

**Task Description:**
Change uploaded book cover identifiers from random hexadecimal strings to random integers suitable for an SQL `INT` field.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Edit the image handling system so the SQL database uses a generated random number with an integer data type.

**AI Output Summary:**
Changed new cover IDs to positive random integers, added collision checks against existing book records and cover files, bound the value as an integer, and updated cover image lookup on the home, gallery, and details pages.

**What You Accepted:**
The integer ID generation, collision checks, integer database binding, and integer-based image paths.

**What You Changed:**
No additional changes.

**Validation Performed:**
PHP syntax checks passed for the four modified PHP pages, and `git diff --check` reported no whitespace errors. Database behavior was not tested.

**Issues Identified:**
The database schema is not included in the repository; the `books.coverID` column must be configured as `INT` in the database. Existing string cover IDs may need to be migrated before changing that column type.

---

## AI Task 5

**Date:**
31/10/2026

**Task Description:**
Align book queries and inserts with the supplied users and books schema while preserving the existing form condition and status values.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Update all database queries to use the supplied schema columns. Keep the existing condition values rather than changing the form to match the `book_condition` ENUM, and retain the random integer cover identifier.

**AI Output Summary:**
Updated book queries to use `book_id`, `publication_year`, `book_condition`, `status`, and `image_path`. The form now submits the database ENUM values directly. Image uploads store a numeric `cover_id` and a relative image path.

**What You Accepted:**
The schema column updates, direct use of the condition and status ENUM values, and use of `image_path` alongside the integer cover ID.

**What You Changed:**
Removed the intermediate form-to-database value mappings and changed the form options to the supplied ENUM values.

**Validation Performed:**
PHP syntax checks passed for all PHP pages, `git diff --check` reported no whitespace errors, and a query/column-name review found no remaining references to the old book column names. Database execution was not tested.

**Issues Identified:**
The supplied books schema does not define `cover_id`. This was subsequently fixed by checking image-path uniqueness and inserting only the supplied schema's `image_path` column.

---

## AI Task 6

**Date:**
31/10/2026

**Task Description:**
Store newly uploaded book covers directly inside `assets/images` with a numeric filename matching their image path.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Ensure a new cover image is stored locally inside `assets/images`, named using its generated number, and that this location is saved in `image_path`.

**AI Output Summary:**
Changed cover uploads to save as `assets/images/<number>.<extension>`, store that relative path in `image_path`, and updated book image lookups to accept that path format.

**What You Accepted:**
The direct `assets/images` upload location and numeric filename/path handling.

**What You Changed:**
No additional changes.

**Validation Performed:**
Pending PHP syntax checks and whitespace validation.

**Issues Identified:**
No runtime database/upload test was performed.

---

## AI Task 7

**Date:**
31/10/2026

**Task Description:**
Fix book cover uploads failing because the code referenced a `cover_id` database column not included in the supplied schema.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Investigate why adding a book reports that its cover was not saved and make cover storage work with the posted database schema.

**AI Output Summary:**
Changed the uniqueness query to compare the generated numeric filename's relative path against `image_path`, and removed the unsupported `cover_id` column from the book insert.

**What You Accepted:**
Using `image_path` as the database's cover reference while keeping the generated number in the local filename under `assets/images`.

**What You Changed:**
No additional changes.

**Validation Performed:**
PHP syntax validation passed, `git diff --check` reported no whitespace errors, the cover query/insert only reference `image_path`, and the insert has ten placeholders with ten bind types. Runtime upload/database behavior was not tested.

**Issues Identified:**
The upload and SQL operation still need runtime verification against the local database.

---

## AI Task 8

**Date:**
31/10/2026

**Task Description:**
Rename PHP variables and book data keys to match the supplied database column names.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Align the variable names with the new database schema without changing query behavior or stored values.

**AI Output Summary:**
Renamed book-related variables and associative keys to use names such as `publication_year`, `book_condition`, `status`, and `image_path`.

**What You Accepted:**
The schema-aligned names in book form handling and query result handling.

**What You Changed:**
Updated the corresponding form field names and labels so submitted values continue to match their renamed PHP keys.

**Validation Performed:**
PHP syntax checks passed for all PHP pages, `git diff --check` reported no whitespace errors, and a search confirmed the previous schema-mismatched book variable and data-key names are no longer used.

**Issues Identified:**
No runtime database test was performed.

---

## AI Task 9

**Date:**
31/10/2026

**Task Description:**
Fix the add-book form hanging while searching for an unused cover image filename.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Investigate why a second add-book submission stays waiting for localhost and fix the issue.

**AI Output Summary:**
Reviewed the Apache PHP error log, which showed repeated maximum-execution-time errors in the image-path collision loop. The initial change used a fresh prepared statement per filename candidate and stopped after ten attempts, but that did not resolve the problem because the local database column type differed from the posted schema.

**What You Accepted:**
The bounded retry loop and per-attempt query lifecycle.

**What You Changed:**
No additional changes.

**Validation Performed:**
PHP syntax and whitespace checks passed. The local image-path lookup ran three times without hanging, but a later schema check found that the local `image_path` column is `INT` and contains `0`. The issue was addressed in AI Task 12. No full book insertion was attempted.

**Issues Identified:**
The posted schema defines `image_path` as `VARCHAR(255)`, but the local database currently defines it as `INT(255)`.

---

## AI Task 10

**Date:**
31/10/2026

**Task Description:**
Fix cover filename generation failing because the local `image_path` column is an integer rather than a path string.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Investigate why the add-book form still cannot generate a cover name.

**AI Output Summary:**
Changed `image_path` to store the numeric image filename, made collision checks bind the candidate as an integer, and updated the home, gallery, and details pages to reconstruct the local image filename using its extension.

**What You Accepted:**
Store the numeric filename in `image_path` and use the extension found in the local `assets/images` folder to display covers.

**What You Changed:**
No additional changes.

**Validation Performed:**
PHP syntax checks passed for all four modified PHP pages, `git diff --check` reported no whitespace errors, and five integer filename lookups against the local database each returned zero matching rows. No full book insertion was attempted.

**Issues Identified:**
The local database ENUM values also differ from the values in the posted schema; an add operation may still fail when inserting the condition or status unless the local schema is updated.

---

## AI Task 11

**Date:**
01/11/2026

**Task Description:**
Implement the account validation, database-backed login, book ownership, and authenticated Add Book access in Assessment 3.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
The account registration, login verification, Add Book access, and book owner requirements previously requested for Assessment 2 were intended for Assessment 3. Also change book conditions to New, Fair, and Old.

**AI Output Summary:**
Connected registration and login to the Assessment 3 `users` table, validates email and password confirmation, uses bcrypt hashes and unique username/email constraints, gates `add.php` behind a valid session, writes the session user ID to `books.user_ID`, and aligns condition and status values to the local database ENUMs.

**What You Accepted:**
Only a database-verified password creates the authenticated `user_id` and `username` session. Anonymous users are redirected from `add.php`, and the Add Book navigation and details-page shortcut are hidden from them.

**What You Changed:**
Used the actual Assessment 3 schema: `users.user_id`, `users.password`, and `books.user_ID`. Registration supplies empty values for the required profile columns and sets `joined_at` to the current time. Updated book condition and availability values to match the local ENUMs.

**Validation Performed:**
Confirmed the local `users` and `books` column definitions and verified that the `users` table has unique username/email keys. PHP syntax and whitespace checks passed. Anonymous HTTP requests to `add.php` returned a redirect to `login.php`, the anonymous homepage had no Add Book link, invalid login credentials were rejected, and invalid registration email/password confirmation was rejected. A rolled-back database transaction verified account insertion, password-hash verification, duplicate rejection, and the owner-linked book insert without retaining test rows.

**Issues Identified:**
The repository does not include a database schema file; the deployed database must use compatible `users` and `books` columns and ENUM values.

---

## AI Task 12

**Date:**
01/11/2026

**Task Description:**
Use the `users` table in the configured BookVerse database for registration and login, validate email addresses, prevent duplicate accounts, and associate added books with the authenticated user.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
Implement registration and login using the configured database's `users` table, reject invalid emails and duplicate accounts, create a session after authentication, and save the account `user_id` when adding a book.

**AI Output Summary:**
Connected registration and login queries to the `users` table, retained email validation and duplicate-key handling, and used the session `user_id` in the book insert.

**What You Accepted:**
The account queries use the configured database connection; book creation also uses that connection.

**What You Changed:**
Aligned the books insert to the supplied `user_ID` column name.

**Validation Performed:**
PHP syntax checks passed for `register.php`, `login.php`, and `add.php`. `git diff --check` reported no whitespace errors. Runtime database behavior was not tested.

**Issues Identified:**
The books table must include the supplied `user_ID` ownership column.

---

## AI Task 13

**Date:**
01/11/2026

**Task Description:**
Fix registration and login using the database username instead of the submitted account username.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
Investigate why `root` appears in the registration username field after registration fails.

**AI Output Summary:**
Renamed the shared database connection variables to `$dbHost`, `$dbUsername`, `$dbPassword`, and `$dbName` so including the connection file no longer overwrites page form variables such as `$username` and `$password`.

**What You Accepted:**
The database connection include now uses dedicated variable names, preserving submitted account values for registration and login.

**What You Changed:**
No additional changes.

**Validation Performed:**
PHP syntax checks passed for the database connection include, `register.php`, and `login.php`. `git diff --check` reported no whitespace errors.

**Issues Identified:**
No runtime database test was performed.

---

## AI Task 14

**Date:**
01/11/2026

**Task Description:**
Add owner-only book editing and deletion from the details page, including safe cover-image replacement and cleanup.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
Show Edit and Delete actions to the owner on `details.php`; implement owner-protected edit/delete flows; keep the existing cover if no replacement is uploaded and remove the previous image after a successful replacement.

**AI Output Summary:**
Added owner-conditional actions, a CSRF-protected `edit.php` form and `delete.php` handler, server-side ownership predicates, optional validated cover replacement, and post-success cleanup for unreferenced image files. Added edit/details styling and updated the CRUD and ownership notes in the README.

**What You Accepted:**
Edits and deletions require the signed-in owner ID to match `books.user_ID`. Failed updates preserve the old cover; successful replacements and deletions clean up old image files only when no remaining book references them.

**What You Changed:**
Used the local schema's `book_id`, `user_ID`, and integer `image_path` fields.

**Validation Performed:**
PHP syntax checks passed for the changed PHP pages and `git diff --check` reported no whitespace errors. Live owner/edit/delete and image-upload behavior was not tested.

**Issues Identified:**
Runtime verification requires an authenticated account that owns a book and a writable cover-image directory.

---

## AI Task 15

**Date:**
01/11/2026

**Task Description:**
Add an authenticated profile-and-books page reachable from the account dropdown.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
Add a seller page matching the supplied profile-and-books screenshot and link it from the account dropdown.

**AI Output Summary:**
Added a session-protected `seller.php` page that retrieves the current user's profile and their own books with prepared statements, displays a profile panel and responsive book-card grid, and added the account dropdown link.

**What You Accepted:**
The seller page uses the session `user_id` to restrict both the profile lookup and book listings, and links each book card to its details page.

**What You Changed:**
Used the supplied local fields `users.user_id`, `books.user_ID`, and integer `books.image_path`.

**Validation Performed:**
All Assessment 3 PHP pages passed syntax checks, and `git diff --check` reported no whitespace errors. An anonymous request to `seller.php` redirected to login; an authenticated local session loaded the page with HTTP 200 and rendered the profile layout.

**Issues Identified:**
The page requires an authenticated session and matching database records for full visual verification.

---

## AI Task 16

**Date:**
01/11/2026

**Task Description:**
Move the My Books link from the main navigation to the top-right account dropdown.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
Place the My Books menu in the top-right dropdown as shown in the supplied screenshot.

**AI Output Summary:**
Removed the standalone navigation dropdown and added “My Profile & Books” above Logout in the existing account dropdown.

**What You Accepted:**
The account menu remains available to authenticated users and opens the existing seller page.

**What You Changed:**
Matched the screenshot’s “My Profile & Books” label.

**Validation Performed:**
`nav.inc` passed PHP syntax validation, `git diff --check` passed, and a navigation search confirmed the profile link is in the top-right account menu with no separate left-side profile menu.

**Issues Identified:**
No runtime visual test was performed.

---

## AI Task 17

**Date:**
01/11/2026

**Task Description:**
Store uploaded book covers in the existing `assets/images/covers/` directory.

**Tool Used:**
GitHub Copilot in VS Code

**Prompt / Input:**
Change uploaded image storage from `assets/images/` to `assets/images/covers/`.

**AI Output Summary:**
Changed add/edit upload destinations, updated all book-cover readers and cleanup handlers, and moved existing numeric uploaded cover files into the covers folder.

**What You Accepted:**
Book `image_path` values continue to contain numeric identifiers; pages resolve those identifiers under `assets/images/covers/`.

**What You Changed:**
Moved the existing numeric JPG/PNG cover files from `assets/images/` into `assets/images/covers/`.

**Validation Performed:**
All Assessment 3 PHP pages passed syntax validation. The scoped `git diff --check` passed for implementation and evidence files; the README was excluded because it contains pre-existing trailing whitespace. Confirmed uploaded-image write, lookup, replacement, and deletion paths target `assets/images/covers/`; moved existing numeric cover files there and retained the previously tracked cover assets in Git. Local book image IDs `710079749`, `1580085397`, and `1542284776` resolve to files in the covers folder. The local book with `image_path` 0 has no cover file. Runtime upload/edit/delete was not performed.

**Issues Identified:**
No runtime add/edit/delete upload was performed.

---

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  
Creating formatting of .php files aswell as formulating logic for website processes 

**What you learned about debugging:**  
Not all AI code is flawless.

**How your approach changed over time:**  
The AI would get worst the more I used a given chat, so reseting the chat would get a better result.