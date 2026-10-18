# Defense & Remediation

Preventing Remote Code Execution requires strict defense-in-depth principles across input handling, execution wrappers, and application architecture.

## 1. Preventing Command Injection
- **Avoid Shell Sinks:** Never pass user input directly to `shell_exec`, `exec`, `system`, or `passthru`.
- **Use Parameterized APIs:** Instead of shelling out to ping, use native language networking libraries or safe APIs.
- **Strict Whitelisting:** If system commands must be invoked, validate input strictly against an explicit whitelist of allowed values (e.g., exact IP regex or predefined options).

## 2. Preventing Code Evaluation & Deserialization
- **Avoid `eval()` / `assert()`:** Never evaluate dynamic user input as code.
- **Avoid Unsafe Deserialization:** Never call `unserialize()` on untrusted data. Use JSON (`json_decode`) or safe data interchange formats instead.

## 3. Preventing File Inclusion & Log Poisoning
- **Disable `allow_url_include`:** Ensure PHP configuration restricts remote and stream inclusion.
- **Base Name Filtering:** Restrict file inclusion parameters using `basename()` or strict path whitelisting arrays.
- **Sanitize Logging:** Ensure log entries sanitize or escape special characters (e.g. newlines, PHP tags) before writing to log files.
