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

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
