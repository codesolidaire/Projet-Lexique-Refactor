function myFunction() {
  var x = document.getElementById("mySelect");
  for (let i = 0; i < x.options.length; i++) {
    option = x.options[i];
    if (option.value == "en") {
      option.setAttribute("selected", true);
      window.location.href = "/en";
    } else {
      window.location.href = "/fr";
    }
  }
}
