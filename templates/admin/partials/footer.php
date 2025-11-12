  </div> <!-- end .admin-wrapper -->
  
  <!-- Main JS -->
  <script src="../../assets/js/mainadmin.js"></script>

  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  
  <script>
  // === FIX FOOTER MELAYANG SAAT LOAD ===
  document.addEventListener("DOMContentLoaded", () => {
    const content = document.getElementById("content");
    if (content) {
      const vh = window.innerHeight;
      content.style.minHeight = vh + "px";
    }
  });

  // Saat resize juga update ulang
  window.addEventListener("resize", () => {
    const content = document.getElementById("content");
    if (content) {
      const vh = window.innerHeight;
      content.style.minHeight = vh + "px";
    }
  });
</script>


</body>
</html>
