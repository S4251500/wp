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
(e.g., 15/03/2026)

**Date Fixed:**  
(e.g., 15/03/2026)

**File:**  
(e.g., about.html)

**Related Commit:**  
(e.g., abc1234)

**Symptom:**  
What went wrong?

**Steps to Reproduce:**  
How can the issue be triggered?

**Root Cause:**  
Why did the issue occur?

**Fix:**  
What did you change?

**Verification:**  
How did you confirm the fix?

---

## Bug 2

**Date Identified:**  

**Date Fixed:**  

**File:**  

**Related Commit:**  

**Symptom:**  

**Steps to Reproduce:**  

**Root Cause:**  

**Fix:**  

**Verification:**  

---

# 🤖 Section 2: AI Usage Log

## AI Task 1

**Date:**  
(e.g., 15/03/2026)

**Task Description:**  
What were you trying to do?

**Tool Used:**  
(e.g., GitHub Copilot, ChatGPT)

**Prompt / Input:**  
(What did you type?)

**AI Output Summary:**  
(What did it generate?)

**What You Accepted:**  
(Which parts did you keep?)

**What You Changed:**  
(What did you modify and why?)

**Validation Performed:**  
How did you test correctness?

**Issues Identified:**  
(Any errors or problems in AI output?)

---

## AI Task 2

**Date:**  

**Task Description:**  

**Tool Used:**  

**Prompt / Input:**  

**AI Output Summary:**  

**What You Accepted:**  

**What You Changed:**  

**Validation Performed:**  

**Issues Identified:**  

---

## AI Task 3

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

## AI Task 4

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

## AI Task 5

**Date:**
27/10/2026

**Task Description:**
Style the signed-in account dropdown to match the supplied navigation screenshot.

**Tool Used:**
GitHub Copilot

**Prompt / Input:**
Make the account dropdown box look like the one in the top-right of the supplied image.

**AI Output Summary:**
Styled the account button and dropdown with the screenshot's dark colors, accent icon, compact dimensions, and hover states.

**What You Accepted:**
The account button icon and custom dark dropdown styling.

**What You Changed:**
Kept the existing logout action rather than adding profile links that do not exist in the project.

**Validation Performed:**
PHP syntax validation passed for the shared navigation include, and `git diff --check` reported no whitespace errors.

**Issues Identified:**
None identified during syntax and whitespace checks.

---

## AI Task 6

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

## AI Task 7

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

## AI Task 8

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

## AI Task 9

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

## AI Task 10

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

## AI Task 11

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

## AI Task 12

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

## AI Task 13

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

## AI Task 14

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
Used the lowercase `user_id` column name in the books insert to match the supplied naming.

**Validation Performed:**
PHP syntax checks passed for `register.php`, `login.php`, and `add.php`. `git diff --check` reported no whitespace errors. Runtime database behavior was not tested.

**Issues Identified:**
The books table must include a compatible `user_id` column.

---

## AI Task 15

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

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
