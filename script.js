// Show Welcome screen for 6 seconds, then switch to auth screen
window.addEventListener('DOMContentLoaded', () => {
setTimeout(() => {
  window.location.href = "home.php";
}, 6000);


  // Tabs switching
  const loginTab = document.getElementById('login-tab');
  const signupTab = document.getElementById('signup-tab');
  const loginForm = document.getElementById('login-form');
  const signupForm = document.getElementById('signup-form');

  loginTab.addEventListener('click', () => {
    loginForm.classList.add('active-form');
    signupForm.classList.remove('active-form');
    loginTab.classList.add('active-tab');
    signupTab.classList.remove('active-tab');
  });

  signupTab.addEventListener('click', () => {
    signupForm.classList.add('active-form');
    loginForm.classList.remove('active-form');
    signupTab.classList.add('active-tab');
    loginTab.classList.remove('active-tab');
  });

  // Password validation
  const passwordInput = document.getElementById('password');
  const confirmInput = document.getElementById('confirm-password');
  const passwordError = document.getElementById('password-error');

  function checkPasswordsMatch() {
    if (confirmInput.value === "") {
      passwordError.textContent = "";
      return;
    }
    if (passwordInput.value !== confirmInput.value) {
      passwordError.textContent = "Password doesn't match";
    } else {
      passwordError.textContent = "";
    }
  }

  confirmInput.addEventListener('input', checkPasswordsMatch);
  passwordInput.addEventListener('input', checkPasswordsMatch);

  // Handle login form submission
  loginForm.addEventListener('submit', e => {
    e.preventDefault();
    if (passwordInput.value !== confirmInput.value) {
      passwordError.textContent = "Password doesn't match";
      confirmInput.focus();
    } else if (passwordInput.value.length > 6) {
      passwordError.textContent = "Password must be maximum 6 characters.";
      passwordInput.focus();
    } else {
      alert('Login successful! (This is a placeholder alert.)');
      loginForm.reset();
    }
  });

  // Handle signup form submission
  signupForm.addEventListener('submit', e => {
    e.preventDefault();
    alert('Sign up successful! (This is a placeholder alert.)');
    signupForm.reset();
  });
});
