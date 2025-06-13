document.addEventListener('DOMContentLoaded', function () {
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("programImages");
  const preview = document.getElementById("previewContainer");
  const feedback = document.getElementById("feedback");

  const submitBtn = document.getElementById("submitBtn");

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
  // Call this to show feedback:
//    showFeedback("Your message here", "success");
// or showFeedback("Oops, an error", "error");
function showFeedback(msg, type) {
  const fb = document.getElementById('feedback');
  fb.textContent = msg;
  fb.classList.remove('success','error');
  fb.classList.add(type);
  fb.style.display = 'block';
  // trigger fade-in
  requestAnimationFrame(() => fb.style.opacity = 1);

  // hide after 5s
  setTimeout(() => {
    fb.style.opacity = 0;
    // after fade-out, remove from view
    setTimeout(() => {
      fb.style.display = 'none';
    }, 300);
  }, 5000);
}


  // 🚀 Submit form with FormData
  document.getElementById('uploadProgramForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = new FormData();
    form.append('programName', document.getElementById('programName').value.trim());
    form.append('programSymbol', document.getElementById('programSymbol').value.trim());
    form.append('programDescription', document.getElementById('programDescription').value.trim());
    form.append('programTagline', document.getElementById('programTagline').value.trim());
    form.append('programObj1', document.getElementById('programObj1').value.trim());
    form.append('programObj2', document.getElementById('programObj2').value.trim());
    form.append('programObj3', document.getElementById('programObj3').value.trim());
    form.append('programObj4', document.getElementById('programObj4').value.trim());

    // Append each selected image
    const images = fileInput.files;
    for (let i = 0; i < images.length; i++) {
      form.append('projectImages[]', images[i]);
    }

  try {
  const response = await fetch('./apis/pUploadProgram.php', {
    method: 'POST',
    body: form,
    credentials: 'same-origin'
  });

  const text = await response.text();

  if (!response.ok) {
    console.error('Server error:', response.status, text);
    showFeedback(`Server error (${response.status}): Check console for details.`, 'error');
    return;
  }

  let result;
  try {
    result = JSON.parse(text);
  } catch (jsonError) {
    console.error("Failed to parse JSON:", jsonError);
    console.error("Server responded with:", text);
    showFeedback("Server Error: Unexpected response format. See console for details.", 'error');
    return;
  }

  if (!result.success) {
    showFeedback(result.message, 'error');
  } else {
    showFeedback("Success: " + result.message, 'success');
  }
} catch (error) {
  console.error('Network or fetch error:', error);
  showFeedback("An unexpected error occurred. Please try again later.", 'error');
}

  });
});
