// contactMessage.js

document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector(".message-form");

  // Feedback display
  function showFeedback(msg, type) {
    let fb = document.getElementById('feedback');
    if (!fb) {
      fb = document.createElement('div');
      fb.id = 'feedback';
      document.querySelector(".contact-form").appendChild(fb);
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
    }, 10000);
  }

  // Handle form submission
  form?.addEventListener("submit", async function (e) {
    e.preventDefault();

    const name = form.querySelector('input[name="name"]').value.trim();
    const email = form.querySelector('input[name="email"]').value.trim();
    const subject = form.querySelector('input[name="subject"]').value.trim();
    const message = form.querySelector('textarea[name="message"]').value.trim();
    const captcha = form.querySelector('[name="g-recaptcha-response"]')?.value;

    if (!name || !email || !message || !captcha) {
      showFeedback("Please fill all required fields and complete the CAPTCHA.", "error");
      return;
    }

    const formData = new FormData();
    formData.append("name", name);
    formData.append("email", email);
    formData.append("subject", subject);
    formData.append("message", message);
    formData.append("g-recaptcha-response", captcha);
          // Log FormData contents
  const formDataObj = {};
  for (const [key, value] of formData.entries()) {
    if (value instanceof File) {
      formDataObj[key] = {
        name: value.name,
        size: value.size,
        type: value.type
      };
    } else {
      formDataObj[key] = value;
    }
  }
  console.log('FormData being sent:', JSON.stringify(formDataObj, null, 2));
    try {
      const response = await fetch("./apis/contactMessage.php", {
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
        showFeedback(result.message || "Message sending failed.", "error");
      } else {
        showFeedback("Message sent successfully!", "success");
        form.reset();
        grecaptcha.reset(); // Reset CAPTCHA
      }
    } catch (error) {
      console.error("Fetch/network error:", error);
      showFeedback("Network error. Try again later.", "error");
    }
  });
});
