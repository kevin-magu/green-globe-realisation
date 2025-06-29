document.addEventListener("DOMContentLoaded", function () {
  const approveButtons = document.querySelectorAll(".btn-approve[data-id]");
  const rejectButtons = document.querySelectorAll(".btn-reject[data-id]");
  const approveAllBtn = document.querySelector(".btn-approve:not([data-id])");

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

  async function handleOrganizationAction(id, action, btn = null) {
    if (btn) {
      btn.disabled = true;
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    }

    try {
      const response = await fetch("./apis/pApproveOrganization.php", {
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
        if (btn) resetButton(btn, action);
        return;
      }

      if (!result.success) {
        showFeedback(result.message || "Action failed.", "error");
        if (btn) resetButton(btn, action);
      } else {
        showFeedback(result.message || "Action successful!", "success");
        if (btn) {
          const card = btn.closest(".organization-card");
          card?.remove();
        }
      }
    } catch (error) {
      console.error("Fetch error:", error);
      showFeedback("Network error. Try again later.", "error");
      if (btn) resetButton(btn, action);
    }
  }

  function resetButton(btn, action) {
    btn.disabled = false;
    btn.innerHTML = action === "approve"
      ? '<i class="fas fa-check"></i> Approve'
      : '<i class="fas fa-times"></i> Reject';
  }

  approveButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      handleOrganizationAction(id, "approve", btn);
    });
  });

  rejectButtons.forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.getAttribute("data-id");
      handleOrganizationAction(id, "reject", btn);
    });
  });

  approveAllBtn?.addEventListener("click", async () => {
    approveAllBtn.disabled = true;
    approveAllBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving All...';

    const allButtons = document.querySelectorAll(".btn-approve[data-id]");
    for (const btn of allButtons) {
      const id = btn.getAttribute("data-id");
      await handleOrganizationAction(id, "approve", btn);
    }

    showFeedback("All organizations approved.", "success");
    approveAllBtn.innerHTML = "Approve All";
    approveAllBtn.disabled = false;
  });
});
