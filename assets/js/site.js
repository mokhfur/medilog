// MediLog website: mobile menu and contact form helpers
(function () {
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  }

  var time = document.getElementById('form-time');
  if (time) { time.value = String(Date.now()); }

  var note = document.getElementById('form-error');
  if (note) {
    var error = new URLSearchParams(window.location.search).get('error');
    var messages = {
      invalid: 'Some details are missing or not valid. Check your first name, email, subject and message, then send again.',
      send: 'Your message could not be sent. Try again in a few minutes.'
    };
    if (error && messages[error]) {
      note.textContent = messages[error];
      note.hidden = false;
    }
  }
})();
