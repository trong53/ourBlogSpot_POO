
if (document.querySelector('#signUp')!= undefined) {
    
    let name_field = document.querySelector('#signup-name');
    name_field.onblur = function(){
        let reGex_name = /^[A-z]{1,}\s?([A-z]{1,}\'?\-?[A-z]{1,}\s?)+([A-z]{1,})?$/;

        let error_name = document.getElementById('error-name');

        if (name_field.value == "" || name_field.value == null) {
            error_name.innerText = "Name can not be empty !";
        } else if (!reGex_name.test(name_field.value)){
            error_name.innerText = "Name is not correct !";
        } else {
            error_name.innerHTML = "&nbsp;";
        }
    }

    let pseudo_field = document.querySelector('#signup-pseudo');
    pseudo_field.onblur = function(){
        let reGex_pseudo = /^[A-z0-9_\-\.]{2,32}$/;

        let error_pseudo = document.getElementById('error-pseudo');

        if (pseudo_field.value == "" || pseudo_field.value == null) {
            error_pseudo.innerText = "Pseudo can not be empty !";
        } else if (!reGex_pseudo.test(pseudo_field.value)){
            error_pseudo.innerText = "Pseudo is not correct !";
        } else {

            fetch('http://projectsiteblog.test/signup-check-field', {
                method: 'POST',
                body: JSON.stringify([[pseudo_field.value, 'pseudo']]),
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then ((response)=>response.json())
            .then ((not_exist)=>{
                if (!not_exist){
                    error_pseudo.innerHTML = "Pseudo already existed !";}
                else {error_pseudo.innerHTML = "&nbsp;";}
            })
        }
    }

    let email_field = document.querySelector('#signup-email');
    email_field.onblur = function(){
        let reGex_email = /^[A-z][A-z0-9_\.\-]{2,32}@([A-z0-9\.\-]{3,15})(\.[A-z]{2,8}){1,2}$/;

        let error_email = document.getElementById('error-email');

        if (email_field.value == "" || email_field.value == null) {
            error_email.innerText = "Email can not be empty !";
        } else if (!reGex_email.test(email_field.value)){
            error_email.innerText = "Email is not correct !";
        } else {

            fetch('http://projectsiteblog.test/signup-check-field', {
                method: 'POST',
                body: JSON.stringify([[email_field.value, 'email']]),
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then ((response)=>response.json())
            .then ((not_exist)=>{
                if (!not_exist){
                    error_email.innerHTML = "Email already existed !";}
                else {error_email.innerHTML = "&nbsp;";}
            })
        }
        
    }

    let password_field = document.querySelector('#signup-password');
    password_field.onblur = function(){
        let reGex_password = /^(?=.*\d)(?=.*\W)(?=.*[A-Z]).{8,32}$/;

        let error_password = document.getElementById('error-password');

        if (password_field.value == "" || password_field.value == null) {
            error_password.innerText = "Password can not be empty !";
        } else if (!reGex_password.test(password_field.value)){
            error_password.innerText = "Password is not correct !";
        } else {
            error_password.innerHTML = "&nbsp;";
        }
    }

}