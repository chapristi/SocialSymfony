const password = document.getElementById("register_password_first")
const mail  = document.getElementById("register_email")
const erreurPaswword = document.getElementById("erreurPassword")
const erreurMail = document.getElementById("erreurMail")
const doublePassword = document.getElementById("register_password_second")
const erreurDoublePassword = document.getElementById("erreurDoublePassword")
const verifMail =  (value) =>  {
    regex =  String(value)
        .toLowerCase()
        .match(
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,5}))$/
        );
    if(regex === null){
        erreurMail.textContent= "l'email doit etre valide"
        erreurMail.style.color = "red"
    }else{
        erreurMail.textContent="le format de l'email est correcte"
        erreurMail.style.color = "green"
    }
}

const verifPassword = (value) => {
    regex =  String(value)
        .toLowerCase()
        .match(
            /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/
        );
    if(regex === null){
        erreurPaswword.textContent = "Au moins huit caractères, au moins une lettre, un chiffre et un caractère spécial "
        erreurPaswword.style.color = "red"
    }else{
        erreurPaswword.textContent = "le format du mot de passe est valide"
        erreurPaswword.style.color = "green"
    }
}
const verifDoublePass = (value) =>{

    if (password.value !== value ){
        erreurDoublePassword.textContent = "les deux mot de passe ne sont pas identiques"
        erreurDoublePassword.style.color = "red"

    }else {
        erreurDoublePassword.textContent = "les deux mot de passes sont bien identiques"
        erreurDoublePassword.style.color = "green"
    }
}

mail.addEventListener("input",(e)=>{
    verifMail(e.target.value)
});
password.addEventListener("input",(e) => {
    verifPassword(e.target.value)

})
doublePassword.addEventListener("input", (e) =>{
    verifDoublePass(e.target.value)
})