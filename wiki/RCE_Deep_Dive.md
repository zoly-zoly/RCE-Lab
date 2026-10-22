# RCE Deep-Dive: Execution Sinks, Deserialization & Defensive Architecture

Welcome to the official Wiki for the **RCE Masterclass Lab Suite**. This wiki is designed to be an advanced architectural reference guide, shifting the focus from "running a system command" to **how PHP execution sinks, object deserialization magic methods, template engines, and stream wrappers function under the hood**, alongside enterprise remediation strategies.

---

## 🔬 Part 1: Anatomy of Remote Code Execution (RCE)

Remote Code Execution represents the pinnacle of application vulnerability severity. It occurs when an application insufficiently validates, sanitizes, or safely evaluates untrusted data passed to system interpreters, evaluation functions, deserialization handlers, or file inclusion sinks.

```
[ Inbound Raw HTTP Request ]
            │
            ├─► 1. Shell Sinks (`shell_exec`, `system`, `passthru`, `exec`)
            │
            ├─► 2. Code Evaluation Sinks (`eval()`, `assert()`, `preg_replace /e`)
            │
            ├─► 3. Object Deserialization (`unserialize()` triggering `__destruct`)
            │
            └─► 4. Stream Wrapper & File Inclusion (`include`, `php://filter`)
```

### Contextual Vulnerability Matrix

| Vulnerability Class | Vulnerable Pattern | Root Mechanism | Required Defense |
| :--- | :--- | :--- | :--- |
| **Command Injection** | `shell_exec("ping -c 3 " . $ip)` | Unsanitized shell metacharacters (`;&|`). | Strict Whitelisting or Parameterized API |
| **Code Evaluation** | `eval('$res = ' . $expr);` | Untrusted input evaluated as PHP code. | Never use `eval()`; use math parsers |
| **Deserialization** | `unserialize(base64_decode($data))` | Magic methods (`__destruct`) executing arbitrary logic. | Use JSON (`json_decode`) instead of PHP native serialization |
| **PHP Filter Chain** | `include($_GET['page']);` | Stream wrappers generating memory-resident code. | Disable `allow_url_include`, whitelist paths |

---

## 🎯 Part 2: Advanced Attack Archetypes

### 1. Insecure Deserialization via Magic Methods (Level 7)
When PHP deserializes untrusted object graphs via `unserialize()`, magic methods like `__wakeup()`, `__sleep()`, and `__destruct()` are automatically invoked when objects are instantiated or garbage collected.
*   **The Flaw:** If a class defines a `__destruct()` method that performs logging, file operations, or code evaluation using object properties (`@eval($this->logMessage)`), an attacker can craft a serialized payload triggering RCE immediately upon object destruction.

### 2. Log Poisoning & PHP Filter Chains (Levels 9 & 10)
*   **Log Poisoning:** Combining Local File Inclusion (LFI) with server log writing (such as HTTP User-Agent request logging). By sending PHP code in the User-Agent header and including `logs/access.log`, the server executes the injected code.
*   **PHP Filter Chains:** Chaining stream filters (like `convert.base64-encode`, `string.rot13`, `convert.iconv.*`) via `php://filter` to construct arbitrary PHP code in memory without writing files to disk.

---

## 🛡️ Part 3: Defensive Architecture (The Industry Standard)

To eliminate RCE across an enterprise application, implement a **Defense-in-Depth Pipeline**:

```
                  ┌────────────────────────────────────────┐
                  │          Inbound Untrusted Input       │
                  └───────────────────┬────────────────────┘
                                      │
                                      ▼
                        [ Strict Whitelist Validation ]
                                      │
                                      ▼
                       [ Avoid Dangerous Sinks Entirely ]
                    (No `eval`, `system`, `unserialize`, raw `include`)
                                      │
                                      ▼
                         [ Least-Privilege Execution ]
                          (Restricted web user sandbox)
                                      │
                                      ▼
                          [ Secure Containerization ]
                         (Docker rootless / read-only root)
```

### 1. Eliminate Dangerous Sinks
Never use `eval()`, `assert()`, `unserialize()`, or raw `include()` on untrusted input. Use safe interchange formats (JSON) and explicit path routing.

### 2. Least-Privilege Permissions
Ensure the web server user (e.g., `www-data`) has minimal filesystem permissions and cannot write to web root directories or execute sensitive binaries.

---
*Documentation curated by **Zoly** for the advancement of secure application architecture.*
