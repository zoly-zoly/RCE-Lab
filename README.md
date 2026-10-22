# 🛡️ RCE Masterclass Lab Suite

<div align="center">

[![Security: Educational](https://img.shields.io/badge/Security-Education%20&%20Training-blue.svg)](https://github.com/)
[![Vulnerability: RCE](https://img.shields.io/badge/Vulnerability-Remote%20Code%20Execution-critical.svg)](https://github.com/)
[![Author: zoly](https://img.shields.io/badge/Created%20by-zoly-purple.svg)](https://github.com/)

*An elite, production-grade training ground for mastering Remote Code Execution (RCE) vulnerabilities, from web-tier command injection to kernel-adjacent deserialization and template injection.*

</div>

---

## 📋 Table of Contents
- [Overview](#-overview)
- [Lab Architecture & Levels](#-lab-architecture--levels)
- [Quick Start Guide](#-quick-start-guide)
- [Deep Dive: Vulnerability Mechanics](#-deep-dive-vulnerability-mechanics)
- [Author & Credits](#-author--credits)

---

## 🔍 Overview

Remote Code Execution (RCE) represents one of the most critical vulnerabilities in modern software architectures. When an application insufficiently validates, sanitizes, or safely executes untrusted user input within system interpreters, template engines, or deserialization routines, attackers achieve full system compromise.

The **RCE Masterclass Lab Suite** is meticulously engineered by **zoly** to bridge the gap between theoretical understanding and elite bug bounty execution. Each level models real-world vulnerabilities discovered in bug bounty programs, enterprise software, and CTFs.

---

## 🏗️ Lab Architecture & Levels

| Level | Title | Severity | Core Vulnerability Pattern | Exploitation Objective |
| :---: | :--- | :---: | :--- | :--- |
| **1** | Classic Command Injection | `Low` | Unsanitized string concatenation in `shell_exec("ping -c 3 " . $ip)` | Execute `id` |
| **2** | Command Concatenation | `Low` | Superficial input check (`^[a-zA-Z0-9]`) bypassing operators | Execute `uname -a` via `&&` or `;` |
| **3** | Character Blacklist | `Medium` | Naive WAF stripping `/`, `;`, `&`, `\|`, `` ` ``, `$` | Bypass blacklist using newlines (`%0a`) |
| **4** | Restricted Shell Access | `Medium` | Regex blocking spaces and forward slashes (`/[\/\s]/`) | Use `${IFS}` and base64 decoding |
| **5** | Dynamic Calculator | `High` | Unsafe `eval()` evaluation of mathematical expressions | Break out of expression context to run `system()` |
| **6** | Blind RCE | `High` | Output discarded (`> /dev/null 2>&1`) | Verify execution via `sleep 5` (Time-based) or OAST |
| **7** | Insecure Deserialization | `High` | Unsafe `unserialize()` triggering `__destruct` magic methods | Execute arbitrary PHP/system code via object payload |
| **8** | Server-Side Template Injection | `Expert` | Mock template engine evaluating `{{ ... }}` via `eval()` | Extract system data via template expressions |
| **9** | PHP Filter Chain | `Expert` | Unsafe `include()` allowing `php://filter` stream wrappers | Generate memory-resident webshells without file writes |
| **10** | Log Poisoning (Final Boss) | `Elite` | User-Agent request logging combined with unsafe `include()` | Poison `access.log` and include it for full RCE |

---

## 🚀 Quick Start Guide

### Prerequisites
- PHP 8.x installed on your local system.

### Running the Lab Server
1. Clone or navigate to the lab directory:
   ```bash
   cd RCE-Lab
   ```
2. Start the built-in PHP development server:
   ```bash
   php -S localhost:8080 -t .
   ```
3. Access the training dashboard in your browser at:
   ```text
   http://localhost:8080
   ```

---

## 🧠 Deep Dive: Vulnerability Mechanics

### 1. Command Injection & Bypasses (Levels 1-4)
- **Root Cause:** Passing untrusted user input directly to shell interfaces (`popen`, `system`, `shell_exec`, `passthru`).
- **Bypass Techniques:**
  - *Separators:* Semicolon (`;`), Ampersands (`&&`), Pipe (`||`), Newlines (`%0a`).
  - *Space Restrictions:* Using Internal Field Separator (`${IFS}`), brace expansion (`{cat,/etc/passwd}`).
  - *Slash Restrictions:* Base64 encoding payloads (`echo ZmxhZz4... | base64 -d | sh`) or environment variables (`$PATH`).

### 2. Code Evaluation & Deserialization (Levels 5 & 7)
- **Root Cause:** Treating data as code via `eval()`, `assert()`, or deserializing untrusted object graphs where magic methods (`__destruct`, `__wakeup`, `__toString`) execute destructive or sensitive logic.

### 3. Template Injection & File Inclusion (Levels 8-10)
- **Root Cause:** Parsing user-controlled templates or passing dynamic parameters into file inclusion sinks (`include`, `require`, `readfile`). Chain with filter wrappers or log poisoning to escalate to full RCE.

---

## ✍️ Author & Credits

- **Created by:** **zoly**
- **Purpose:** Advanced Security Research, VAPT Training, and Bug Bounty Mastery.

---
*For Educational and Authorized Testing Purposes Only.*
