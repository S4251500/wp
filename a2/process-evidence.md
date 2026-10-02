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
28/09/2026

**Date Fixed:**  
28/09/2026

**File:**  
assets/includes/nav.inc

**Related Commit:**  
Commit 1

**Symptom:**  
Clicking the BookVerse logo in the navigation caused an error because the link pointed to a page that did not exist in the project.

**Steps to Reproduce:**  
1. Open any page in the `a2` project.
2. Click the BookVerse logo in the navigation bar.
3. Observe that the link attempts to open `index.html` and produces an error because that file is not present.

**Root Cause:**  
The navigation logo still referenced `index.html`, but the project uses `index.php` as its home page and no longer contained `index.html`.

**Fix:**  
Changed the logo link in `assets/includes/nav.inc` from `index.html` to `index.php`.

**Verification:**  
Opened the navigation on the PHP pages and clicked the BookVerse logo. It now navigates to `index.php` without an error.

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

# 📌 Final Reflection (End of Assessment)

**What AI was most useful for:**  

**Where AI was incorrect or misleading:**  

**What you learned about debugging:**  

**How your approach changed over time:**  
