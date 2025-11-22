// signupvalidation.js
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("signup");
  const remarks = document.getElementById("remarks");

  // navigation buttons (optional)
  window.next = function () {
    document.getElementById("part1").style.display = "none";
    document.getElementById("part2").style.display = "flex";
  };
  window.prev = function () {
    document.getElementById("part1").style.display = "flex";
    document.getElementById("part2").style.display = "none";
  };

  if (!form) return;

  form.addEventListener("submit", validate);

  function validate(e) {
    e.preventDefault();                 // stop native submit
    remarks.innerHTML = "";             // clear old messages

    const fname = document.getElementById("fname").value || "";
    const lname = document.getElementById("lname").value || "";
    const id = document.getElementById("studentid").value || "";
    const email = document.getElementById("email").value || "";
    const password = document.getElementById("password").value || "";
    const cpassword = document.getElementById("cpassword").value || "";

    const checks = [
      { ok: validName(fname), msg: "First Name Not Supported" },
      { ok: validName(lname), msg: "Last Name Not Supported" },
      { ok: validID(id), msg: "ID Must Be 8 Digits Long" },
      { ok: validEmail(email), msg: "Must Be an Ashesi Email" },
      { ok: validPass(password), msg: "Password Not Strong Enough" },
      { ok: passMatch(password, cpassword), msg: "Password Does Not Match" },
    ];

    let valid = true;
    checks.forEach(c => {
      if (!c.ok) {
        valid = false;
        const p = document.createElement("p");
        p.innerText = c.msg;
        p.className = "error"; // style as you like
        remarks.appendChild(p);
      }
    });

    if (valid) {
      // safe-submit avoiding possible shadowing
      // Preferred modern approach if supported:
      if (typeof form.requestSubmit === "function") {
        form.requestSubmit();
      } else {
        // fallback to calling native submit even if someone named input "submit"
        HTMLFormElement.prototype.submit.call(form);
      }
    } else {
      // if part1 had errors but user is on part2, show part1
      document.getElementById("part1").style.display = "flex";
      document.getElementById("part2").style.display = "none";
    }
  }

  // Validators
  function validName(name) {
    // return true if name is non-empty and contains ONLY letters, spaces, hyphen, apostrophe
    const clean = name.trim();
    if (!clean) return false;
    return /^[A-Za-z\-' ]+$/.test(clean);
  }

  function validID(id) {
    // ensure digits and exactly 8 chars
    return /^\d{8}$/.test(id.trim());
  }

  function validEmail(email) {
    // more strict: must end with @ashesi.edu.gh (case-insensitive)
    return /@ashesi\.edu\.gh$/i.test(email.trim());
  }

  function validPass(password) {
    // at least 8 chars — you can strengthen with regex for complexity
    return password.trim().length >= 8;
  }

  function passMatch(pw, cpw) {
    return pw.trim() === cpw.trim() && pw.trim().length > 0;
  }
});