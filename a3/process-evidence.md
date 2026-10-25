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

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
