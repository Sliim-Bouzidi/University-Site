function test() {
  var login = document.getElementById("email").value;
  var pwd = document.getElementById("pass").value;
  var cin = document.getElementById("cin").value;
  var a = "@";
  if (cin.length != 8 || isNaN(cin)) {
    alert("Vérifier votre CIN SVP");
    return false;
  }
  else {
    if (login.length === 0 || pwd.length === 0) {
      alert("Vérifier votre login et votre de mot de passe SVP");
      return false;
    }
    if (pwd.length < 8) {
      alert("Votre mot de passe doit avoir au moins une longueur égale à 8 caractères");

      return false;
    }
  }
}