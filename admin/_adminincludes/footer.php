    <script type="text/javascript">
      const currlocation = location.href;
      const navLinks = document.getElementsByClassName("side-link");
      for(let i = 0; i < navLinks.length; i++) {
        if(navLinks[i].href === currlocation) {
          navLinks[i].classList.add("active");
          if(navLinks[i].classList.contains("dropdown-item")) {
            navLinks[i].parentElement.parentElement.parentElement.children[0].classList.add("bg-primary", "text-white");
          }
        } 
      }
    </script>
    <!-- bootstrap js -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>