document.querySelectorAll(".like-btn").forEach((btn) => {
  btn.addEventListener("click", () => {
    const id = btn.dataset.id;

    fetch("like.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "id=" + id,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          document.getElementById("likes-" + id).innerText = data.likes;
        }
      });
  });
});

document.querySelectorAll(".video-card").forEach((card) => {
  const video = card.querySelector("video");
  if (video) {
    card.addEventListener("mouseenter", () => {
      video.play();
    });
    card.addEventListener("mouseleave", () => {
      video.pause();
      video.currentTime = 0;
    });
  }
});
