# COSC2446 Web Programming – Assessment 3  
# BookVerse Online Bookstore Platform

## Student Details

| Item | Details |
|---|---|
| Student name | TODO |
| Student ID | TODO |
| GitHub repository URL | TODO |
| Deployed website URL | TODO |

---

## 1. Purpose of This README

This README documents the Assessment 3 project and should be completed by the student.

It is used to:

- summarise the project;
- explain the structure and technical choices;
- document database, security, authentication, testing, and deployment decisions;
- support marking of documentation and submission quality;
- help AI tools such as GitHub Copilot follow the assessment requirements.

TODO: After completing the project, update every TODO section in this file.

---

## 2. Copilot and AI Coding Instructions

This section must be completed by the student after reading the Assessment 3 brief.

Write clear instructions that would help GitHub Copilot or another AI tool produce code that follows the Assessment 3 requirements.

Your instructions should help the AI understand what it is allowed to generate, what it must not generate, and which assessment constraints must be followed.

TODO: Include instructions about:

- allowed technologies;
- technologies, frameworks, libraries, or tools that must not be used;
- required files and folders;
- PHP include file requirements;
- database connection requirements;
- MySQLi procedural prepared statement requirements;
- session and flash-message requirements;
- registration, login, and logout requirements;
- authentication and authorisation requirements;
- owner-only edit and delete requirements;
- CRUD requirements;
- search requirements;
- seller page requirements;
- image upload and validation requirements;
- CSS and JavaScript file requirements;
- Bootstrap layout requirements;
- gallery modal requirements;
- book status filtering requirements;
- deletion confirmation requirements;
- security requirements;
- deployment requirements;
- AI usage and process-evidence requirements.

### My Copilot / AI instructions

TODO: Write your Copilot/AI instructions here in clear bullet points.

---

## 3. Project Overview

Briefly describe the purpose of the BookVerse extended project.

TODO: In 3–5 sentences, explain:

- what BookVerse is;
- what authenticated users can do;
- what anonymous visitors can do;
- how Assessment 3 extends Assessment 2;
- which technologies were used;
- how the website uses database persistence.

---

## 4. Website Structure

Complete the table below by describing the purpose of each page.

| File | Purpose |
|---|---|
| `index.php` | TODO |
| `books.php` | TODO |
| `gallery.php` | TODO |
| `details.php` | TODO |
| `seller.php` | TODO |
| `search.php` | TODO |
| `register.php` | TODO |
| `login.php` | TODO |
| `logout.php` | TODO |
| `add.php` | TODO |
| `edit.php` | TODO |
| Optional processing files | TODO, if used |

---

## 5. Project Folder Structure

Show the final structure of your `a3` folder.

TODO: Update this structure if your final project contains additional required files or folders.

```
a3/
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── js/
│   │   └── scripts.js
│   └── images/
│       └── covers/
├── includes/
│   ├── db_connect.inc
│   ├── header.inc
│   ├── nav.inc
│   └── footer.inc
├── index.php
├── books.php
├── gallery.php
├── details.php
├── seller.php
├── search.php
├── register.php
├── login.php
├── logout.php
├── add.php
├── edit.php
├── README.md
└── process-evidence.md

Optional:
├── process_add.php
├── process_edit.php
├── process_delete.php
├── process_register.php
└── process_login.php
```

---

## 6. Technologies Used

Complete the table below. Explain how each technology was used in your project.

| Technology | How it was used in this project |
|---|---|
| HTML5 | TODO |
| CSS3 | TODO |
| Bootstrap 5 | TODO |
| JavaScript | TODO |
| PHP | TODO |
| MySQL | TODO |
| MySQLi procedural prepared statements | TODO |
| PHP sessions | TODO |
| Google Fonts | TODO |
| Material Icons | TODO |
| GitHub | TODO |
| Coreteaching server | TODO |
| Jacob 5 database server | TODO |
| AI tools | TODO |

---

## 7. Design and Layout

Based on the assessment document, describe the required design and layout choices.

TODO: Explain:

- how the design should continue from previous assessments;
- how the required colour palette should be used;
- how the required fonts should be used;
- how Material Icons should be used;
- how Bootstrap should be used for layout and responsiveness;
- how shared include files support consistency across pages;
- how navigation changes depending on whether the user is logged in.

---

## 8. Required Features

Complete the table below by explaining where and how each required feature should be implemented.

| Feature | Page/File | Explanation |
|---|---|---|
| Carousel of latest images | `index.php` | TODO |
| Latest 4 books from database | `index.php` | TODO |
| Book table | `books.php` | TODO |
| Status filter | `books.php` | TODO |
| Book detail link | `books.php` / `details.php` | TODO |
| Details page | `details.php` | TODO |
| Seller link | `index.php`, `details.php`, `books.php` | TODO |
| Seller page | `seller.php` | TODO |
| Gallery grid | `gallery.php` | TODO |
| Bootstrap image modal | `gallery.php` | TODO |
| Search | `search.php` | TODO |
| User registration | `register.php` | TODO |
| User login | `login.php` | TODO |
| User logout | `logout.php` | TODO |
| Add Book form | `add.php` | TODO |
| Edit Book form | `edit.php` | TODO |
| Delete action | `details.php` or optional processing file | TODO |
| Image upload | `add.php` / `edit.php` | TODO |
| Flash messages | Session-based pages/actions | TODO |

---

## 9. Database Design and Use

Describe how the database is used in your project.

TODO: Explain:

- which database server is used locally and on deployment;
- the database name used on Jacob 5;
- which table or tables are used;
- how the supplied schema was followed;
- how records are retrieved and displayed;
- how new records are inserted;
- how existing records are edited;
- how records are deleted;
- how books are linked to owners;
- how `details.php` retrieves one selected record;
- how `seller.php` retrieves records for one selected owner;
- how `search.php` searches records;
- how prepared statements are used.

### Database tables and important fields

Complete this section using the schema supplied for the assessment.

| Table | Important fields | Purpose |
|---|---|---|
| TODO | TODO | TODO |
| TODO | TODO | TODO |

---

## 10. PHP Includes and Reusable Structure

Describe how the include files are used.

| Include file | Purpose |
|---|---|
| `includes/db_connect.inc` | TODO |
| `includes/header.inc` | TODO |
| `includes/nav.inc` | TODO |
| `includes/footer.inc` | TODO |
| Other optional include files | TODO |

TODO: Explain how these files reduce repetition and support consistent layout, database access, session messages, or navigation.

---

## 11. Authentication, Sessions, and Access Control

Describe how authentication and sessions are implemented.

TODO: Explain:

- how registration works;
- how passwords are hashed before storage;
- how login verifies passwords;
- how sessions are used after login;
- how logout works;
- how flash messages are stored and displayed;
- how anonymous and authenticated views differ;
- which pages require login;
- which actions are owner-only.

### Protected routes and actions

| Page or action | Who can access it? | How access is checked |
|---|---|---|
| `add.php` | TODO | TODO |
| `edit.php` | TODO | TODO |
| Delete action | TODO | TODO |
| Owner edit/delete buttons | TODO | TODO |
| Anonymous visitor pages | TODO | TODO |

---

## 12. CRUD Functionality

Describe how create, read, update, and delete functionality is implemented.

| CRUD operation | Page/File | Explanation |
|---|---|---|
| Create book | `add.php` / optional handler | TODO |
| Read all books | `books.php` | TODO |
| Read one book | `details.php` | TODO |
| Update book | `edit.php` / optional handler | TODO |
| Delete book | `details.php` / optional handler | TODO |

TODO: Explain how ownership is checked before editing or deleting a record.

---

## 13. Search, Filtering, and Seller Pages

Describe the dynamic browsing features.

| Feature | Page | Explanation |
|---|---|---|
| Status filtering | `books.php` | TODO |
| Keyword search | `search.php` | TODO |
| Seller page | `seller.php` | TODO |

TODO: Explain:

- how status filtering works;
- how `data-status` is used;
- how search uses prepared statements;
- how the selected seller is identified;
- how seller links are displayed.

---

## 14. JavaScript Functionality

Describe the JavaScript features that should be implemented in your website.

| JavaScript feature | Page | How it works |
|---|---|---|
| Image extension validation | `add.php` / `edit.php` | TODO |
| Image preview | `add.php` / `edit.php` | TODO |
| Gallery modal | `gallery.php` | TODO |
| Book status filter | `books.php` | TODO |
| Delete confirmation modal | `details.php` | TODO |

---

## 15. Form Handling and Validation

Describe the validation and processing used on forms.

TODO: Explain:

- which forms are included;
- which fields are required;
- how labels are associated with form fields;
- which input types were used;
- how client-side image validation works;
- how server-side checks are performed;
- how uploaded images are validated;
- how uploaded image filenames are made unique;
- what happens if no new image is uploaded during editing;
- what feedback the user receives if an action succeeds or fails.

---

## 16. File Uploads and File-System Hygiene

Describe how image uploads are handled.

TODO: Explain:

- where uploaded images are stored;
- how unique filenames are generated;
- how the original filename is handled;
- how old images are deleted when a record is edited;
- how images are deleted when a record is deleted;
- how `.gitignore` is used for uploaded/generated files;
- how file permissions are handled on Coreteaching.

---

## 17. Security and Best Practices

Briefly explain how your project addresses security and best practices.

TODO: Mention relevant items such as:

- MySQLi procedural prepared statements;
- protection against SQL injection;
- escaping database output with `htmlspecialchars()`;
- validating query string values;
- validating form input;
- validating uploaded files;
- unique uploaded filenames;
- not relying on original uploaded filenames;
- server-side ownership checks;
- session-based access control;
- flash messages;
- not displaying raw database errors to users on the deployed site.

---

## 18. Accessibility and Usability

Briefly describe what accessibility and usability features must be implemented.

TODO: Mention relevant items such as:

- meaningful page titles;
- semantic HTML;
- form labels;
- image `alt` text;
- consistent navigation;
- readable text;
- colour contrast;
- responsive layout;
- clear user feedback;
- error and success messages;
- authenticated and anonymous user experience.

---

## 19. Testing and Validation

Complete this section after testing your website.

### Rendered HTML Validation

| Page | Result | Notes |
|---|---|---|
| `index.php` | TODO: Pass / Issues found | TODO |
| `books.php` | TODO: Pass / Issues found | TODO |
| `gallery.php` | TODO: Pass / Issues found | TODO |
| `details.php` | TODO: Pass / Issues found | TODO |
| `seller.php` | TODO: Pass / Issues found | TODO |
| `search.php` | TODO: Pass / Issues found | TODO |
| `register.php` | TODO: Pass / Issues found | TODO |
| `login.php` | TODO: Pass / Issues found | TODO |
| `add.php` | TODO: Pass / Issues found | TODO |
| `edit.php` | TODO: Pass / Issues found | TODO |

### CSS Validation

| File | Result | Notes |
|---|---|---|
| `assets/css/style.css` | TODO: Pass / Issues found | TODO |

### Functionality Testing

| Feature tested | Result | Notes |
|---|---|---|
| Navigation links | TODO | TODO |
| Database connection | TODO | TODO |
| Latest books display | TODO | TODO |
| Books table | TODO | TODO |
| Book status filter | TODO | TODO |
| Details page query string | TODO | TODO |
| Seller page query string | TODO | TODO |
| Search | TODO | TODO |
| Gallery modal | TODO | TODO |
| Registration | TODO | TODO |
| Login | TODO | TODO |
| Logout | TODO | TODO |
| Session flash messages | TODO | TODO |
| Add Book form validation | TODO | TODO |
| Image upload | TODO | TODO |
| Image preview | TODO | TODO |
| Edit Book | TODO | TODO |
| Delete confirmation | TODO | TODO |
| Owner-only access | TODO | TODO |
| Anonymous user access | TODO | TODO |
| Deployed site links/assets | TODO | TODO |
| Deployed database content | TODO | TODO |

---

## 20. Deployment

Provide details of your deployed website.

| Item | Details |
|---|---|
| Deployed website URL | TODO |
| Jacob 5 database name | TODO |
| Deployment folder | TODO |
| `.htaccess` location | TODO |
| Upload folder permissions | TODO |

TODO: In 2–4 sentences, explain how you checked that the deployed website, authentication, uploads, and database functionality work correctly.

---

## 21. Git and Development Process

Briefly describe how you used Git during the project.

TODO: Explain:

- how often you committed changes;
- what types of changes your commits show;
- how your Git history shows progressive development;
- how your commits relate to your process-evidence records.

---

## 22. AI Use Declaration

AI tools are required for this assessment.

Confirm the following:

- [ ] I used AI tools meaningfully during this assessment.
- [ ] I recorded meaningful AI use in `process-evidence.md`.
- [ ] I reviewed, tested, and adapted AI-assisted output.
- [ ] I can explain all AI-assisted code submitted.

TODO: Write 2–5 sentences explaining how AI tools supported your development.

Detailed AI usage records must be included in `process-evidence.md`.

---

## 23. Process Evidence

Confirm that your process evidence file has been completed.

| Requirement | Completed? |
|---|---|
| `process-evidence.md` file included | TODO: Yes / No |
| At least 5 debugging records included | TODO: Yes / No |
| At least 5 meaningful AI usage records included | TODO: Yes / No |
| Relevant commit links included | TODO: Yes / No |

---

## 24. Known Issues or Limitations

List any known issues or limitations in your submitted project.

| Issue or limitation | Explanation |
|---|---|
| TODO | TODO |
| TODO | TODO |

If there are no known issues, write:

> No known issues at the time of submission.
