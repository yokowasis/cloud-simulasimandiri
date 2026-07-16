# REPORT.md — Security & Code Quality Issues

Investigation date: 2026-07-16
Investigator: Antigravity AI Code Review

---

## Issue #1 — CRITICAL: Token Bypass via Direct URL Navigation

**Severity:** CRITICAL  
**File:** `konfirmasi.php` (lines 317–336), `template-soal.php`, `post.php`

### Description
The token verification that guards the exam is implemented entirely in client-side JavaScript.
When a student clicks "MULAI", the browser:
1. Calls `api-18575621/cektoken.php` via `$.post` to get the current token
2. Compares it to what the user typed
3. If matching, calls `do_start()` which sets `window.location = './soalujian---' + kode`

Because `template-soal.php` / `post.php` has **zero server-side check** for whether the
token was ever validated, a student can skip step 1–3 entirely and navigate directly to
`soalujian---$KODESOAL`. The exam will load fully.

### Exploit Path
```
Login → note the kodesoal in konfirmasi URL → manually type soalujian---$KODESOAL → exam opens
```

### Fix
See `FIX-BYPASS.md` for the complete remediation plan.

---

## Issue #2 — HIGH: SQL Injection in `jawab.php`

**Severity:** HIGH  
**File:** `jawab.php` (lines 17, 63–68)

### Description
Several SQL queries in `jawab.php` are built using string concatenation with user-supplied data
and **no prepared statement or escaping**:

```php
// Line 17 — $userid and $kodemapel come directly from $_POST
$v11sql = "SELECT finish FROM `{$table_prefix}bsfsm_siswa` WHERE kode='$userid' AND mapel='$kodemapel'";

// Lines 43–55 — $kodemapel, $userid, $no, $jawaban inserted into INSERT
'($kodemapel-$userid-$no', '$jawaban')'
```

`$jawaban` is `real_escape_string`-escaped on line 31, but `$userid`, `$kodemapel`, and `$no`
are used raw from `$_POST` without sanitization.

### Fix
Replace all concatenated queries with MySQLi prepared statements with bound parameters, or
use `$conn->real_escape_string()` consistently for every user-supplied value.

---

## Issue #3 — HIGH: SQL Injection in `kumpul.php`

**Severity:** HIGH  
**File:** `kumpul.php` (lines 9, 23, 26, 35, 41, 65)

### Description
Same pattern as `jawab.php`. `$id` (from `$_POST['nama']`) and `$mapel` (from `$_POST['mapel']`)
are interpolated directly into SQL strings without escaping:

```php
$v11sql = "SELECT `finish` FROM `{$table_prefix}bsfsm_siswa` WHERE kode='$id' AND mapel='$mapel'";
// ...
$addpg .= "('$indexkey-$i','".$jawaban[$i]."')";
```

`$jawaban[$i]` values from `json_decode($_POST['jawaban'])` are also inserted without escaping.

### Fix
Use prepared statements or escape all user-supplied variables before inserting into SQL.

---

## Issue #4 — HIGH: SQL Injection in `cektoken.php` (Indirect)

**Severity:** HIGH  
**File:** `api-18575621/cektoken.php` (lines 14, 35–37)

### Description
The `UPDATE` query on line 35 uses `$token` (which is generated server-side via `RandomString()`),
but the `SELECT` on line 14 has no WHERE clause limiting to a specific student/mapel — it returns
**all** tokens from the table, whichever was last updated:

```php
$v11sql = "SELECT * FROM `{$table_prefix}bsfsm_aktif`";
```

This means every student gets the same system-wide token, regardless of which exam they're
taking. A student from one session can share the token with another.

---

## Issue #5 — MEDIUM: `RandomString()` in `cektoken.php` Has Off-by-One

**Severity:** MEDIUM  
**File:** `api-18575621/cektoken.php` (lines 4–12)

### Description
```php
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZZ';  // 'Z' appears twice
for ($i = 0; $i < 6; $i++) {
    $randstring = $randstring.$characters[rand(0, strlen($characters))];
    //                                              ^^^^^^^^^^^^^^^^^
    //  strlen() returns 27, so rand(0,27) can access index 27 which is OUT OF BOUNDS
}
```

`strlen($characters)` is 27 (indices 0–26). `rand(0, 27)` can produce 27, which is an
undefined character (PHP will return an empty string for that position). The token is also
biased toward `Z` (appears twice at index 25 and 26).

### Fix
```php
$randstring .= $characters[rand(0, strlen($characters) - 1)];
```

---

## Issue #6 — MEDIUM: Focus-Loss Logout Not Wired to Any Event

**Severity:** MEDIUM  
**File:** `archives/js/script.js` (lines 37–43)

### Description
The AGENTS.md noted this was fixed at some point. Confirmed: the current file **does** wire
`visibilitychange` to `selesaiTest()` (lines 37–43). However, the implementation only
triggers on `document.hidden` — it does not cover:
- `window.blur` (student switches windows without the tab becoming hidden)
- Alt+Tab on some browsers/OSes where `visibilitychange` may not fire reliably

### Recommendation
Also bind `window.addEventListener('blur', selesaiTest)` for broader coverage. Ensure
`selesaiTest()` is not called on legitimate focus loss (e.g. clicking an in-page modal).

---

## Issue #7 — MEDIUM: `ADMINDEBUG` Back-Door Exposed in `post.php`

**Severity:** MEDIUM  
**File:** `post.php` (lines 3–25)

### Description
If a POST request is sent to the soal page with the `ADMINDEBUG` parameter, it:
1. Clears `localStorage`
2. Sets `siswa.namasiswa` to `__ADMINTESTSOAL__`
3. Loads any exam by mapel code
4. Redirects to the exam without authentication

```php
if (isset($_POST['ADMINDEBUG'])) {
    // ... directly loads exam
    exit;
}
```

There is no password, nonce, or IP restriction on this debug path. Any student who discovers
it can use it to load arbitrary exams as a fake "admin" user.

### Fix
Either remove the debug block in production, or protect it with a strong secret key or
WordPress admin capability check.

---

## Issue #8 — LOW: `localStorage` as the Sole Authentication State

**Severity:** LOW  
**File:** `post.php` (lines 34–102), `konfirmasi.php` (lines 23–85)

### Description
All student identity data (`siswa.username`, `siswa.namasiswa`, `siswa.mapel`,
`mapel.kode`, etc.) comes exclusively from `localStorage`. A student can open DevTools,
change `siswa.username` to another student's username, and submit answers attributed to
that other student.

The server endpoints (`jawab.php`, `kumpul.php`) accept `userid` as a plain POST parameter
with no session binding, making this exploitable.

### Fix
Bind the session on the server side during `dologin()` (e.g. PHP session or signed cookie)
and verify it in `jawab.php` / `kumpul.php` instead of trusting the POST-supplied `userid`.

---

## Issue #9 — LOW: Visible `pentest.html` in `archives/` Directory

**Severity:** LOW  
**File:** `archives/pentest.html`

### Description
A file named `pentest.html` is publicly accessible inside the `archives/` directory.
Depending on its contents this could expose test/debug endpoints or invite attention from
malicious actors.

### Fix
Remove from the web root or deny access via `.htaccess` / server config.

---

## Issue #10 — INFO: Token Comparison Done Client-Side After Receiving Plaintext Token

**Severity:** INFO  
**File:** `konfirmasi.php` (lines 324–331)

### Description
The current flow fetches the **actual current token** from the server and compares it in
the browser:
```js
$.post(...cektoken.php..., function(e) {
    if (token == e) { do_start(); }
```

This means the correct token is transmitted in the HTTP response body every time a student
clicks "MULAI", even if they type the wrong token. An attacker can read the correct token
from the browser's network tab.

### Fix
Move the comparison to the server: the client POSTs `{ userid, mapel, token }` and the
server responds with `OK` or `INVALID`. The correct token is never sent to the client.

---

## Summary Table

| # | Severity | File | Issue |
|---|----------|------|-------|
| 1 | CRITICAL | `konfirmasi.php`, `post.php` | Token bypass via direct URL navigation |
| 2 | HIGH | `jawab.php` | SQL injection in answer submission |
| 3 | HIGH | `kumpul.php` | SQL injection in final answer collection |
| 4 | HIGH | `cektoken.php` | Single system-wide token; no per-exam scoping |
| 5 | MEDIUM | `cektoken.php` | Off-by-one in `RandomString()` + 'Z' bias |
| 6 | MEDIUM | `archives/js/script.js` | Focus-loss detection incomplete (blur not covered) |
| 7 | MEDIUM | `post.php` | Unauthenticated `ADMINDEBUG` back-door |
| 8 | LOW | `post.php`, `jawab.php`, `kumpul.php` | `localStorage`-only identity; answer fraud possible |
| 9 | LOW | `archives/pentest.html` | Debug/pentest file publicly accessible |
| 10 | INFO | `konfirmasi.php` | Plaintext token sent to client in response body |
