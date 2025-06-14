// mailingList.js

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector(".newsletter-form");

  // Feedback display
  function showFeedback(msg, type) {
    let fb = document.getElementById('feedback');
    if (!fb) {
      fb = document.createElement('div');
      fb.id = 'feedback';
      document.querySelector(".newsletter-section").appendChild(fb);
    }
    fb.textContent = msg;
    fb.classList.remove('success', 'error');
    fb.classList.add(type);
    fb.style.display = 'block';
    requestAnimationFrame(() => fb.style.opacity = 1);
    setTimeout(() => {
      fb.style.opacity = 0;
      setTimeout(() => {
        fb.style.display = 'none';
      }, 300);
    }, 5000);
  }

  // Handle form submission
  form?.addEventListener("submit", async function (e) {
    e.preventDefault();

    const email = form.querySelector('input[name="email"]').value.trim();
    const captcha = form.querySelector('[name="g-recaptcha-response"]')?.value;

    if (!email || !captcha) {
      showFeedback("Please fill all fields and complete the CAPTCHA.", "error");
      return;
    }

    const formData = new FormData();
    formData.append("email", email);
    formData.append("g-recaptcha-response", captcha);

    try {
      const response = await fetch("./uploadMailingList.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin",
      });

      const text = await response.text();

      let result;
      try {
        result = JSON.parse(text);
      } catch (jsonError) {
        console.error("Failed to parse JSON:", jsonError);
        console.error("Server responded with:", text);
        showFeedback("Unexpected server response.", "error");
        return;
      }

      if (!result.success) {
        showFeedback(result.message || "Subscription failed.", "error");
      } else {
        showFeedback("Subscribed successfully!", "success");
        form.reset();
        grecaptcha.reset(); // Reset CAPTCHA
      }
    } catch (error) {
      console.error("Fetch/network error:", error);
      showFeedback("Network error. Try again later.", "error");
    }
  });
});
