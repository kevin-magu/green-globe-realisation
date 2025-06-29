document.addEventListener("DOMContentLoaded", function () {
  const approveButtons = document.querySelectorAll(".btn-approve[data-id]");
  const rejectButtons = document.querySelectorAll(".btn-reject[data-id]");
  const approveAllBtn = document.querySelector(".btn-approve-all"); // ✅ FIXED selector

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

  async function handleAction(id, action, btn = null) {
    if (btn) {
      btn.disabled = true;
      const originalText = btn.innerHTML;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    }

    try {
      const response = await fetch("./apis/pApproveVolunteer.php", {
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
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = action === "approve" ? '<i class="fas fa-check"></i> Approve' : '<i class="fas fa-times"></i> Reject';
        }
        return;
      }

      if (!result.success) {
        showFeedback(result.message || "Action failed.", "error");
        if (btn) {
          btn.disabled = false;
          btn.innerHTML = action === "approve" ? '<i class="fas fa-check"></i> Approve' : '<i class="fas fa-times"></i> Reject';
        }
      } else {
        showFeedback(result.message || "Action successful!", "success");

        // Remove card from DOM
        const card = btn.closest(".volunteer-card");
        card.remove();
      }
    } catch (error) {
      console.error("Fetch error:", error);
      showFeedback("Network error. Try again later.", "error");
      if (btn) {
        btn.disabled = false;
        btn.innerHTML = action === "approve" ? '<i class="fas fa-check"></i> Approve' : '<i class="fas fa-times"></i> Reject';
      }
    }
  }

  approveButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      handleAction(id, "approve", btn);
    });
  });

  rejectButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      handleAction(id, "reject", btn);
    });
  });

  // ✅ Approve All functionality
  approveAllBtn?.addEventListener("click", async () => {
    approveAllBtn.disabled = true;
    approveAllBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving All...';

    const buttons = document.querySelectorAll(".btn-approve[data-id]");

    for (const btn of buttons) {
      const id = btn.getAttribute("data-id");
      await handleAction(id, "approve", btn);
    }

    showFeedback("All volunteers approved.", "success");
    approveAllBtn.innerHTML = "Approve All";
    approveAllBtn.disabled = false;
  });
});
