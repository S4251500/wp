# COSC2446 Web Programming – Assessment 2  
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

This README documents the Assessment 2 project and should be completed by the student.

It is used to:

- summarise the project;
- explain the structure and technical choices;
- document database, security, testing, and deployment decisions;
- support marking of documentation and submission quality;
- help AI tools such as GitHub Copilot follow the assessment requirements.

TODO: After completing the project, update every TODO section in this file.

---

## 2. Copilot and AI Coding Instructions

This section must be completed by the student after reading the Assessment 2 brief.

Write clear instructions that would help GitHub Copilot or another AI tool produce code that follows the Assessment 2 requirements.

Your instructions should help the AI understand what it is allowed to generate, what it must not generate, and which assessment constraints must be followed.

TODO: Include instructions about:

- allowed technologies;
- technologies, frameworks, libraries, or tools that must not be used;
- required files and folders;
- PHP include file requirements;
- database connection requirements;
- MySQLi procedural prepared statement requirements;
- CSS and JavaScript file requirements;
- Bootstrap layout requirements;
- image upload and validation requirements;
- gallery modal requirements;
- book status filtering requirements;
- security requirements;
- deployment requirements;
- AI usage and process-evidence requirements.

### My Copilot / AI instructions

TODO: Write your Copilot/AI instructions here in clear bullet points.

---

## 3. Project Overview

Briefly describe the purpose of the BookVerse dynamic website.

TODO: In 3–5 sentences, explain:

- what BookVerse is;
- what users can view or interact with;
- how Assessment 2 extends the static website from Assessment 1;
- which technologies were used;
- how the website uses a database.

---

## 4. Website Structure

Complete the table below by describing the purpose of each page.

| File | Purpose |
|---|---|
| `index.php` | TODO |
| `books.php` | TODO |
| `gallery.php` | TODO |
| `add.php` | TODO |
| `details.php` | TODO |
| `process_add.php` *(optional)* | TODO, if used |

---

## 5. Project Folder Structure

Show the final structure of your `a2` folder.

TODO: Update this structure if your final project contains additional required files or folders.

```
a2/
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
├── add.php
├── details.php
├── README.md
└── process-evidence.md

Optional:
└── process_add.php
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

- how the design should continue from Assessment 1;
- how the required colour palette should be used;
- how the required fonts should be used;
- how Material Icons should be used;
- how Bootstrap should be used for layout and responsiveness;
- how shared include files support consistency across pages.

---

## 8. Required Features

Complete the table below by explaining where and how each required feature should be implemented.

| Feature | Page/File | Explanation |
|---|---|---|
| Carousel | `index.php` | TODO |
| Latest 4 books from database | `index.php` | TODO |
| Book table | `books.php` | TODO |
| Status filter | `books.php` | TODO |
| Book detail link | `books.php` / `details.php` | TODO |
| Details page | `details.php` | TODO |
| Gallery grid | `gallery.php` | TODO |
| Bootstrap image modal | `gallery.php` | TODO |
| Add Book form | `add.php` | TODO |
| Record insertion | `add.php` or `process_add.php` | TODO |
| Image upload | `add.php` or `process_add.php` | TODO |

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
- how `details.php` retrieves one selected record;
- how prepared statements are used.

### Database tables and important fields

Complete this section using the schema supplied for the assessment.

| Table | Important fields | Purpose |
|---|---|---|
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

TODO: Explain how these files reduce repetition and support consistent layout or database access.

---

## 11. JavaScript Functionality

Describe the JavaScript features that should be implemented in your website.

| JavaScript feature | Page | How it works |
|---|---|---|
| Image extension validation | `add.php` | TODO |
| Image preview | `add.php` | TODO |
| Gallery modal | `gallery.php` | TODO |
| Book status filter | `books.php` | TODO |

---

## 12. Form Handling and Validation

Describe the validation and processing used on the Add Book form.

TODO: Explain:

- which fields are required;
- how labels are associated with form fields;
- which input types were used;
- how client-side image validation works;
- how server-side checks are performed;
- how the image file is uploaded;
- how the image filename is made unique;
- how the record is inserted into the database;
- what feedback the user receives if the submission succeeds or fails.

---

## 13. Security and Best Practices

Briefly explain how your project addresses security and best practices.

TODO: Mention relevant items such as:

- MySQLi procedural prepared statements;
- protection against SQL injection;
- escaping database output with `htmlspecialchars()`;
- validating query string values;
- validating uploaded files;
- unique uploaded filenames;
- not relying on original uploaded filenames;
- `.gitignore` use for uploaded/generated files;
- not displaying raw database errors to users on the deployed site.

---

## 14. Accessibility and Usability

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
- clear user feedback.

---

## 15. Testing and Validation

Complete this section after testing your website.

### Rendered HTML Validation

| Page | Result | Notes |
|---|---|---|
| `index.php` | TODO: Pass / Issues found | TODO |
| `books.php` | TODO: Pass / Issues found | TODO |
| `gallery.php` | TODO: Pass / Issues found | TODO |
| `add.php` | TODO: Pass / Issues found | TODO |
| `details.php` | TODO: Pass / Issues found | TODO |

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
| Gallery modal | TODO | TODO |
| Add Book form validation | TODO | TODO |
| Image upload | TODO | TODO |
| Image preview | TODO | TODO |
| Deployed site links/assets | TODO | TODO |
| Deployed database content | TODO | TODO |

---

## 16. Deployment

Provide details of your deployed website.

| Item | Details |
|---|---|
| Deployed website URL | TODO |
| Coreteaching server | TODO |
| Jacob 5 database name | TODO |
| Deployment folder | TODO |
| `.htaccess` location | TODO |
| Upload folder permissions | TODO |

TODO: In 2–4 sentences, explain how you checked that the deployed website and database work correctly.

---

## 17. Git and Development Process

Briefly describe how you used Git during the project.

TODO: Explain:

- how often you committed changes;
- what types of changes your commits show;
- how your Git history shows progressive development;
- how your commits relate to your process-evidence records.

---

## 18. AI Use Declaration

AI tools are required for this assessment.

Confirm the following:

- [ ] I used AI tools meaningfully during this assessment.
- [ ] I recorded meaningful AI use in `process-evidence.md`.
- [ ] I reviewed, tested, and adapted AI-assisted output.
- [ ] I can explain all AI-assisted code submitted.

TODO: Write 2–5 sentences explaining how AI tools supported your development.

Detailed AI usage records must be included in `process-evidence.md`.

---

## 19. Process Evidence

Confirm that your process evidence file has been completed.

| Requirement | Completed? |
|---|---|
| `process-evidence.md` file included | TODO: Yes / No |
| At least 4 debugging records included | TODO: Yes / No |
| At least 4 meaningful AI usage records included | TODO: Yes / No |
| Relevant commit links included | TODO: Yes / No |

---

## 20. Known Issues or Limitations

List any known issues or limitations in your submitted project.

| Issue or limitation | Explanation |
|---|---|
| TODO | TODO |
| TODO | TODO |

If there are no known issues, write:

> No known issues at the time of submission.
