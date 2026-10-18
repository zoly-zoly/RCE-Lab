# 📚 RCE Masterclass Lab Suite — Official Wiki

<div align="center">

[![Author: zoly](https://img.shields.io/badge/Created%20by-zoly-purple.svg)](https://github.com/)
[![Vulnerability: RCE](https://img.shields.io/badge/Vulnerability-Remote%20Code%20Execution-critical.svg)](https://github.com/)
[![Status: Production Ready](https://img.shields.io/badge/Status-Complete-success.svg)](https://github.com/)

*The definitive technical reference and masterclass guide for Remote Code Execution (RCE) vulnerability research, exploitation, and defense.*

</div>

---

## 📑 Table of Contents
1. [Introduction & Philosophy](#-introduction--philosophy)
2. [Getting Started & Installation](#-getting-started--installation)
3. [Exploitation Guide & Level Walkthroughs](#-exploitation-guide--level-walkthroughs)
4. [Defense & Remediation Strategies](#-defense--remediation-strategies)
5. [Author & Credits](#-author--credits)

---

## 🚀 1. Introduction & Philosophy

Remote Code Execution (RCE) is among the most catastrophic vulnerabilities in application security. Whether arising from insecure shell execution, dynamic code evaluation, object deserialization, template injection, or log poisoning, RCE allows adversaries to transition from web-tier access to full operating system compromise.

Created by **zoly**, the **RCE Masterclass Lab Suite** provides a hands-on, progressive learning environment designed for penetration testers, security researchers, and bug bounty hunters seeking mastery over RCE primitives.

---

## ⚙️ 2. Getting Started & Installation

### System Requirements
- **PHP 8.0 or higher**
- **cURL** (for automated smoke testing)

### Installation & Execution
1. Clone the repository and navigate to the root directory:
   ```bash
   cd /home/alireza/RCE-Lab
   ```
2. Start the built-in PHP development server:
   ```bash
   php -S localhost:8080 -t .
   ```
3. Open your browser and access the dashboard:
   ```text
   http://localhost:8080
   ```

### Running Automated Smoke Tests
To verify all lab endpoints return HTTP 200 OK:
```bash
php tests/smoke_test.php
```

---

## 🎯 3. Exploitation Guide & Level Walkthroughs

| Level | Title | Severity | Core Vulnerability | Objective |
| :---: | :--- | :---: | :--- | :--- |
| **1** | Classic Command Injection | `Low` | Unsanitized concatenation in `shell_exec("ping -c 3 " . $ip)` | Execute `id` |
| **2** | Command Concatenation | `Low` | Superficial regex check (`^[a-zA-Z0-9]`) bypassing operators | Execute `uname -a` via `&&` or `;` |
| **3** | Character Blacklist | `Medium` | Naive WAF stripping `/`, `;`, `&`, `\|`, `` ` ``, `$` | Bypass blacklist using newlines (`%0a`) |
| **4** | Restricted Shell Access | `Medium` | Regex blocking spaces and forward slashes (`/[\/\s]/`) | Use `${IFS}` and base64 decoding |
| **5** | Dynamic Calculator | `High` | Unsafe `eval()` evaluation of mathematical expressions | Break out of expression context to run `system()` |
| **6** | Blind RCE | `High` | Output discarded (`> /dev/null 2>&1`) | Verify execution via `sleep 5` (Time-based) or OAST |
| **7** | Insecure Deserialization | `High` | Unsafe `unserialize()` triggering `__destruct` magic methods | Execute arbitrary PHP/system code via object payload |
| **8** | Server-Side Template Injection | `Expert` | Mock template engine evaluating `{{ ... }}` via `eval()` | Extract system data via template expressions |
| **9** | PHP Filter Chain | `Expert` | Unsafe `include()` allowing `php://filter` stream wrappers | Generate memory-resident webshells without file writes |
| **10** | Log Poisoning (Final Boss) | `Elite` | User-Agent request logging combined with unsafe `include()` | Poison `access.log` and include it for full RCE |

---

## 🛡️ 4. Defense & Remediation Strategies

### A. Preventing Command Injection
- **Avoid Shell Sinks:** Never pass untrusted user input directly to shell execution functions (`shell_exec`, `exec`, `system`, `popen`).
- **Use Parameterized APIs:** Utilize language-native libraries (e.g., cURL, socket libraries) rather than shelling out to system utilities like `ping` or `nslookup`.
- **Strict Input Whitelisting:** If system commands are unavoidable, validate inputs against an exact, strict regex whitelist.

### B. Preventing Code Evaluation & Deserialization
- **Avoid `eval()` & `assert()`:** Never evaluate dynamic user strings as executable code.
- **Avoid Unsafe Deserialization:** Never call `unserialize()` on untrusted data streams. Prefer safe data exchange formats such as JSON (`json_decode`).

### C. Preventing File Inclusion & Log Poisoning
- **Disable Remote Inclusion:** Ensure `allow_url_include` is disabled in `php.ini`.
- **Path Whitelisting:** Restrict file inclusion parameters using explicit lookup arrays or `basename()`.
- **Log Sanitization:** Ensure HTTP headers (like `User-Agent`) are sanitized or HTML/PHP-escaped before writing to log files.

---

## ✍️ 5. Author & Credits

- **Created by:** **zoly**
- **Purpose:** Advanced Security Research, VAPT Training, and Bug Bounty Mastery.

---
*For Educational and Authorized Testing Purposes Only.*
