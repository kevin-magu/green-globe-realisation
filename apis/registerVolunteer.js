// volunteerForm.js

document.addEventListener('DOMContentLoaded', function () {
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("fileInput");
  const preview = document.getElementById("previewContainer");
  const form = document.getElementById("volunteerForm");

  // Enable drag-and-drop upload
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

  // Preview uploaded image
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

  // Display feedback message
  function showFeedback(msg, type) {
    const fb = document.getElementById('feedback');
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

    const formData = new FormData(form); // Auto collects input fields

    const profileImage = fileInput?.files[0];
    if (profileImage) {
      formData.append("profilePicture", profileImage);
    } else {
      showFeedback("Please upload a profile picture.", "error");
      return;
    }

    // Log form data for debugging
    const formDataObj = {};
    for (const [key, value] of formData.entries()) {
      formDataObj[key] = value instanceof File
        ? { name: value.name, size: value.size, type: value.type }
        : value;
    }
    console.log('FormData being sent:', JSON.stringify(formDataObj, null, 2));

    try {
      const response = await fetch("./apis/pRegisterVolunteer.php", {
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
        showFeedback(result.message, "error");
      } else {
        showFeedback("Application submitted successfully!", "success");
        form.reset();
        preview.innerHTML = "";
      }
    } catch (error) {
      console.error("Fetch/network error:", error);
      showFeedback("Network error. Try again later.", "error");
    }
  });
});
