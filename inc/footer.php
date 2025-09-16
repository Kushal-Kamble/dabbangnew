<footer class="py-4 text-center">
  <div class="container small text-muted">&copy; <?= date('Y') ?> WorkSmart</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    let msg = localStorage.getItem("toastMessage");
    if(msg){
      Toastify({
        text: msg,
        duration: 3000,
        gravity: "top",
        position: "right",
        backgroundColor: "#28a745",
      }).showToast();
      localStorage.removeItem("toastMessage");
    }
  });
</script>

