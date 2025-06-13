// uploadStory.js

document.addEventListener('DOMContentLoaded', function () {
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("fileInput");
  const preview = document.getElementById("previewContainer");

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
    const files = fileInput.files;
    for (const file of files) {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement("img");
        img.src = e.target.result;
        preview.appendChild(img);
      };
      reader.readAsDataURL(file);
    }
  }

  function showFeedback(msg, type) {
    const fb = document.getElementById('feedback');
    if (!fb) return;

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

  // 🚀 Submit story form
  document.querySelector('.story-upload-form').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = new FormData();
    form.append('programName', document.getElementById('programName').value.trim());
    form.append('storyTitle', document.getElementById('storyTitle').value.trim());
    form.append('location', document.getElementById('location').value.trim());
    form.append('storyDescription', document.getElementById('storyDescription').value.trim());

    const images = fileInput.files;
    for (let i = 0; i < images.length; i++) {
      form.append('storyImages[]', images[i]);
    }

    // Optional: log FormData contents
    const formDataObj = {};
    for (const [key, value] of form.entries()) {
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
      const response = await fetch('./apis/pUploadStory.php', {
        method: 'POST',
        body: form,
        credentials: 'same-origin'
      });

      const text = await response.text();

      if (!response.ok) {
        console.error('Server error:', response.status, text);
        showFeedback(`Server error (${response.status}): Check console.`, 'error');
        return;
      }

      let result;
      try {
        result = JSON.parse(text);
      } catch (jsonError) {
        console.error("Failed to parse JSON:", jsonError);
        console.error("Server responded with:", text);
        showFeedback("Unexpected server response.", 'error');
        return;
      }

      if (!result.success) {
        showFeedback(result.message, 'error');
      } else {
        showFeedback("Story uploaded successfully!", 'success');
        document.querySelector('.story-upload-form').reset();
        preview.innerHTML = "";
      }
    } catch (error) {
      console.error('Fetch/network error:', error);
      showFeedback("Network error. Try again later.", 'error');
    }
  });
});
