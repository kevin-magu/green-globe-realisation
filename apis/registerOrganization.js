// registerOrganization.js

document.addEventListener('DOMContentLoaded', function () {
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("fileInput");
  const preview = document.getElementById("previewContainer");
  const form = document.getElementById("organizationForm");

  // Handle drag and drop upload
  dropZone?.addEventListener("click", () => fileInput?.click());

  fileInput?.addEventListener("change", updatePreview);

  dropZone?.addEventListener("dragover", e => {
    e.preventDefault();
    dropZone.style.backgroundColor = "#e0f0ff";
  });

  dropZone?.addEventListener("dragleave", () => {
    dropZone.style.backgroundColor = "#fafafa";
  });

  dropZone?.addEventListener("drop", e => {
    e.preventDefault();
    fileInput.files = e.dataTransfer.files;
    updatePreview();
    dropZone.style.backgroundColor = "#fafafa";
  });

  function updatePreview() {
    if (!preview || !fileInput?.files) return;
    preview.innerHTML = "";
    const file = fileInput.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement("img");
        img.src = e.target.result;
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    }
  }

  function showFeedback(msg, type = 'success') {
    const fb = document.getElementById('feedback');
    fb.textContent = msg;
    fb.className = type;
    fb.style.display = 'block';
    requestAnimationFrame(() => fb.style.opacity = 1);
    setTimeout(() => {
      fb.style.opacity = 0;
      setTimeout(() => { fb.style.display = 'none'; }, 300);
    }, 8000);
  }

  form?.addEventListener("submit", async function (e) {
    e.preventDefault();
    // get submit button
    const submitButton = document.getElementById('submit-button')
    const inputs = form.querySelectorAll('button');

    inputs.forEach(input => input.disabled = true );
    submitButton.innerHTML = 'Processing...';

    const formData = new FormData(form);

    const logo = fileInput?.files[0];
    if (logo) {
      formData.append("organizationLogo", logo);
    } else {
      showFeedback("Please upload an organization logo.", "error");
      return;
    }

    const checkedFocusAreas = document.querySelectorAll('input[name="focusAreas[]"]:checked');
    checkedFocusAreas.forEach(item => formData.append('focusAreas[]', item.value));

     // Debug log
    const formDataObj = {};
    for (const [key, value] of formData.entries()) {
      formDataObj[key] = value instanceof File
        ? { name: value.name, size: value.size, type: value.type }
        : value;
    }
    console.log('FormData being sent:', JSON.stringify(formDataObj, null, 2));

    try {
      const response = await fetch("./apis/pRegisterOrganization.php", {
        method: "POST",
        body: formData,
        credentials: "same-origin"
      });

      const text = await response.text();
      let result;

      try {
        result = JSON.parse(text);
        inputs.forEach(input => input.disabled = false );
        submitButton.innerHTML = 'Submit Application';
      } catch (err) {
        inputs.forEach(input => input.disabled = false );
        submitButton.innerHTML = 'Submit Application';
        console.error("Invalid JSON:", text);
        showFeedback("Unexpected server response.", "error");
        return;
      }

      if (!result.success) {
        showFeedback(result.message, "error");
        inputs.forEach(input => input.disabled = false );
        submitButton.innerHTML = 'Submit Application';
      } else {
        showFeedback("Organization registered successfully!", "success");
        form.reset();
        preview.innerHTML = "";
        inputs.forEach(input => input.disabled = false );
        submitButton.innerHTML = 'Submit Application';
      }
    } catch (err) {
      inputs.forEach(input => input.disabled = false );
      submitButton.innerHTML = 'Submit Application';
      console.error("Fetch error:", err);
      showFeedback("Network error. Please try again later.", "error");
    }
  });
});
