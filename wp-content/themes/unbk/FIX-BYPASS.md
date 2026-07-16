# FIX-BYPASS.md

## Summary of the Vulnerability

A student can bypass the token input page (`konfirmasi---$KODESOAL`) entirely by directly
navigating to the exam URL (`soalujian---$KODESOAL`). The token check lives **only in
client-side JavaScript** inside `konfirmasi.php` — no server-side gate exists on the
`soalujian` page. Any user who is already logged in (i.e. has valid `localStorage` keys)
can go straight to the exam without ever entering the proctor's token.

---

## Root Cause (Technical)

| File                | Line(s) | Issue                                                                                                                                            |
| ------------------- | ------- | ------------------------------------------------------------------------------------------------------------------------------------------------ |
| `konfirmasi.php`    | 323–332 | Token is verified via `$.post` to `api-18575621/cektoken.php`, then `do_start()` redirects to `soalujian---`. The check is **client-side only**. |
| `template-soal.php` | 1–5     | Includes `post.php` with no pre-flight authentication or token check.                                                                            |
| `post.php`          | 27–103  | Loads exam content purely from `localStorage`; never validates whether the student completed the token step.                                     |
| `js/soal.js.php`    | 1–480   | Serves questions and starts the timer with no token verification.                                                                                |

Because the token gate is entirely in browser JavaScript, any student who knows the URL
pattern (`soalujian---<KODESOAL>`) can skip it.

---

## Fix Plan

### Step 1 — Introduce a Server-Side Token Session Flag

**File:** `api-18575621/cektoken.php`

Add a mechanism to record that a specific student successfully passed the token check on the server side.
The simplest approach is a short-lived server session variable.

**Changes:**

1. At the top of `cektoken.php`, add `session_start()` (or use WordPress transients / a dedicated DB column).
2. After the token comparison passes, echo the token **and** write a server-side flag, e.g.:
   ```php
   $_SESSION['token_verified'][$kodemapel][$userid] = true;
   ```
   The `$userid` and `$kodemapel` must be passed as POST parameters from the client so the flag is per-student per-exam.
3. Add a new endpoint (or extend `cektoken.php`) that returns whether the flag is set, for use in Step 3.

> **Alternative (no session dependency):** Insert a `token_verified` boolean column into `bsfsm_siswa`
> (already per-student per-mapel). Set it `1` on successful token entry, reset it to `0` on logout/reset.

---

### Step 2 — Modify `konfirmasi.php` to Send Student Identity

**File:** `konfirmasi.php` (lines 323–332)

Currently the POST to `cektoken.php` sends no body parameters:

```js
$.post(themedir2 + '/api-18575621/cektoken.php', {}, function(e) {
```

Change it to send the student identity so the server can record which student passed:

```js
$.post(
  themedir2 + "/api-18575621/cektoken.php",
  {
    userid: localStorage.getItem("siswa.username"),
    mapel: localStorage.getItem("siswa.mapel"),
    token: token,
  },
  function (e) {
    e = e.trim();
    if (token == e) {
      do_start();
    } else {
      alert("Token Salah, Silakan Hubungi Proktor untuk mendapatkan Token");
    }
  },
);
```

On the server side (`cektoken.php`), only set the verified flag if `$_POST['token'] == $stored_token`.

---

### Step 3 — Add a Server-Side Gate in `post.php` (or `template-soal.php`)

**File:** `post.php` (add before line 27) or at the top of `template-soal.php`

At the very beginning of the exam page load, check the server-side flag set in Step 1.
If the flag is **not** set, redirect the student back to the konfirmasi page.

**Option A — PHP Session check:**

```php
session_start();
$kodemapel = substr($absolute_url, 12 + strpos($absolute_url, 'soalujian---'));
$userid    = isset($_COOKIE['bsfsm_user']) ? $_COOKIE['bsfsm_user'] : '';
if (empty($_SESSION['token_verified'][$kodemapel][$userid])) {
    wp_redirect(home_url('/konfirmasi---' . $kodemapel));
    exit;
}
```

**Option B — DB column check (preferred, stateless):**

```php
$v11sql = "SELECT token_verified FROM `{$table_prefix}bsfsm_siswa`
           WHERE kode='$userid' AND mapel='$kodemapel'";
$result = $conn->query($v11sql);
$row    = $result->fetch_assoc();
if (!$row || $row['token_verified'] != 1) {
    wp_redirect(home_url('/konfirmasi---' . $kodemapel));
    exit;
}
```

The `$userid` can be read from the WordPress session or a secure httpOnly cookie set during login (see Step 4).

---

### Step 4 — Persist the Student Identity Server-Side on Login

**File:** `login_func.php` → `dologin()` function

Currently the student's username and mapel live **only** in `localStorage`, which is
browser-controllable and not accessible from PHP when serving `post.php`.

**Change:** When `dologin()` succeeds, set a signed httpOnly cookie containing the
student's username and mapel:

```php
setcookie('bsfsm_user', $username, 0, '/', '', false, true);  // httpOnly
setcookie('bsfsm_mapel', $mapel,   0, '/', '', false, true);  // httpOnly
```

Then in `post.php`, read `$_COOKIE['bsfsm_user']` to obtain `$userid` for the gate check in Step 3.

---

### Step 5 — Clear the Token Flag on Logout / Reset

**Files:** Any logout / reset endpoint (e.g. `api-18575621/reset.php`, the logout link in `header.php`)

Wherever a student is logged out or their session is reset by the proctor:

1. Destroy the session / unset the `token_verified` flag.
2. Expire the httpOnly cookies set in Step 4 (`setcookie('bsfsm_user', '', time()-3600)`).
3. If using the DB column: reset `token_verified = 0` for the student row.

---

### Step 6 — Handle `autotoken` Mode Correctly

**File:** `konfirmasi.php` (lines 312–313)

When `dataPT.autotoken === "1"`, the token input is auto-filled with `'AUTO'` and
`do_start()` is called without contacting `cektoken.php`. The server-side flag will never
be set in this case.

**Change:** Even in autotoken mode, make a POST to the server so the server can record
that the student's token step was completed:

```js
if (dataPT.autotoken === "1") {
    $.post(themedir2 + '/api-18575621/cektoken.php', {
        userid:    localStorage.getItem('siswa.username'),
        mapel:     localStorage.getItem('siswa.mapel'),
        autotoken: 1
    }, function() {
        do_start();
    });
} else { ... }
```

---

## Files to Modify

| #   | File                                  | Nature of Change                                                            |
| --- | ------------------------------------- | --------------------------------------------------------------------------- |
| 1   | `api-18575621/cektoken.php`           | Accept `userid` + `mapel` + `token` params; write server-side verified flag |
| 2   | `konfirmasi.php`                      | Pass `userid` + `mapel` in POST body; handle autotoken via server call      |
| 3   | `post.php`                            | Add gate check at top; redirect if token flag not set                       |
| 4   | `login_func.php` → `dologin()`        | Set httpOnly cookies for userid + mapel                                     |
| 5   | Logout / reset endpoints              | Clear cookies and server-side flag                                          |
| 6   | DB migration (optional but preferred) | Add `token_verified TINYINT DEFAULT 0` to `bsfsm_siswa`                     |

---

## Testing Checklist

- [ ] Student logs in → goes to konfirmasi page → enters wrong token → cannot proceed
- [ ] Student logs in → goes to konfirmasi page → enters correct token → proceeds to exam
- [ ] Student logs in → manually navigates to `soalujian---$KODESOAL` → redirected back to konfirmasi page
- [ ] Student logs in → passes token check → manually refreshes soalujian page → still allowed (flag persists during exam)
- [ ] Proctor resets student → student token flag is cleared → student must re-enter token
- [ ] `autotoken = 1` setting → student is automatically passed through but server flag is still set
- [ ] Exam completes → logout clears all flags and cookies

---

## Priority

**CRITICAL** — this bypass allows any logged-in student to skip proctor token control and
access the exam at any time, undermining the entire exam integrity mechanism.
