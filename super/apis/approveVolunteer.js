document.addEventListener("DOMContentLoaded", function () {
  const approveButtons = document.querySelectorAll(".btn-approve[data-id]");
  const rejectButtons = document.querySelectorAll(".btn-reject[data-id]");

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
    }, 5000);
  }

  async function handleAction(id, action) {
    try {
      const response = await fetch("pApproveVolunteers.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        credentials: "same-origin",
        body: JSON.stringify({ id, action }),
      });

      const text = await response.text();
      let result;

      try {
        result = JSON.parse(text);
      } catch (e) {
        console.error("Invalid JSON:", e, "\nServer response:", text);
        showFeedback("Unexpected server response.", "error");
        return;
      }

      if (!result.success) {
        showFeedback(result.message || "Action failed.", "error");
      } else {
        showFeedback(result.message || "Action successful!", "success");

        // Remove card from DOM
        const btn = document.querySelector(`.btn-${action}[data-id="${id}"]`);
        const card = btn.closest(".volunteer-card");
        card.remove();
      }
    } catch (error) {
      console.error("Fetch error:", error);
      showFeedback("Network error. Try again later.", "error");
    }
  }

  approveButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      handleAction(id, "approve");
    });
  });

  rejectButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      handleAction(id, "reject");
    });
  });
});
