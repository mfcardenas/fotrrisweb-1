/**
* Generate pass hash from insert in DB.
*/
function formhash(form, password) {
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement("input");

    // Add the new element to our form. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Make sure the plaintext password doesn't get sent. 
    password.value = "";

    // Finally submit the form. 
    form.submit();
}

/**
* Validate form input data to create user.
*/
function regformhash(form, name, uid, email, password, conf, image, perfil, sn_active, gaction, id, userapp) {
    // Check each field has a value
    if (uid.value == '' || email.value == '' || perfil.value == '' || sn_active.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    if (password.value != "" || conf.value != "") {
        if (password.value == '' || conf.value == '') {
            alert('You must provide all the requested details. Please try again');
            return false;
        }

        // Check that the password is sufficiently long (min 6 chars)
        // The check is duplicated below, but this is included to give more
        // specific guidance to the user
        if (password.value.length < 6) {
            alert('Passwords must be at least 6 characters long.  Please try again');
            form.password.focus();
            return false;
        }

        // At least one number, one lowercase and one uppercase letter
        // At least six characters
        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
        if (!re.test(password.value)) {
            alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
            return false;
        }

        // Check password and confirmation are the same
        if (password.value != conf.value) {
            alert('Your password and confirmation do not match. Please try again');
            form.password.focus();
            return false;
        }

        // Create a new element input, this will be our hashed password field.
        var p = document.createElement("input");

        // Add the new element to our form.
        form.appendChild(p);
        p.name = "p";
        p.id = "p";
        p.type = "hidden";
        p.value = hex_sha512(password.value);

        // Make sure the plaintext password doesn't get sent.
        password.value = "";
        conf.value = "";
    }
    
    // Check the username
    re = /^\w+$/; 
    if(!re.test(form.username.value)) { 
        alert("Username must contain only letters, numbers and underscores. Please try again"); 
        form.username.focus();
        return false; 
    }

    // Finally submit the form. 
    form.submit();
    return true;
}

/**
 * Validate form input data to create user.
 */
function settingformhash(form, name, username, password, conf, image, gaction, id, userapp) {
    // Check each field has a value
    if (username.value == '' || name.value == '' ) {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    // Add the new element to our form.
    // Create a new element input, this will be our hashed password field.
    var p = document.createElement("input");
    form.appendChild(p);
    p.name = "pwr";
    p.id = 'pwr';
    p.type = "hidden";

    if (password.value != "" || conf.value != "") {
        if (password.value == '' || conf.value == '') {
            alert('You must provide all the requested details. Please try again');
            return false;
        }

        // Check that the password is sufficiently long (min 6 chars)
        // The check is duplicated below, but this is included to give more
        // specific guidance to the user
        if (password.value.length < 6) {
            alert('Passwords must be at least 6 characters long.  Please try again');
            form.password.focus();
            return false;
        }

        // At least one number, one lowercase and one uppercase letter
        // At least six characters
        var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
        if (!re.test(password.value)) {
            alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
            return false;
        }

        // Check password and confirmation are the same
        if (password.value != conf.value) {
            alert('Your password and confirmation do not match. Please try again');
            form.password.focus();
            return false;
        }

        p.value = hex_sha512(password.value);

        // Make sure the plaintext password doesn't get sent.
        password.value = "";
        conf.value = "";
    } else {
        p.value = null;
    }

    // Check the username
    re = /^\w+$/;
    if(!re.test(form.username.value)) {
        alert("Username must contain only letters, numbers and underscores. Please try again");
        form.username.focus();
        return false;
    }

    // Finally submit the form.
    form.submit();
    return true;
}

/**
* Validate form input data to create Project
*/
function regformproject(form, name, id_arena, date_from, date_to, ubication, number_pad, desc_p1,name_p1, desc_p2, name_p2, desc_p3,name_p3, desc_p4,name_p4, desc_p5,name_p5, desc_p6,name_p6, desc_p7, name_p7, desc_p8, name_p8, desc_p9, name_p9, desc_p10, name_p10, desc_proj, keywords, sn_active, images) {
    // Check each field has a value
    if (name.value == '' || id_arena.value == '' || ubication.value == '' || sn_active.value == '' || date_from.value == '' || desc_proj.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    
    if(desc_p1.value == "" || name_p1.value == ""){
        alert("You must provide the description and name for phase 1. Please try again");
        return false;
    }
    if(number_pad.value > 1 && (desc_p2.value == "" || name_p2.value == "")){
        alert("You must provide the description and name for phase 2. Please try again");
        return false;
    }
    if(number_pad.value > 2 && (desc_p3.value == "" || name_p3.value == "")){
        alert("You must provide the description and name for phase 3. Please try again");
        return false;
    }
    if(number_pad.value > 3 && (desc_p4.value == "" || name_p4.value == "")){
        alert("You must provide the description and name for phase 4. Please try again");
        return false;
    }
    if(number_pad.value > 4 && (desc_p5.value == "" || name_p5.value == "")){
        alert("You must provide the description and name for phase 5. Please try again");
        return false;
    }
    if(number_pad.value > 5 && (desc_p6.value == "" || name_p6.value == "")){
        alert("You must provide the description and name for phase 6. Please try again");
        return false;
    }
    if(number_pad.value > 6 && (desc_p7.value == "" || name_p7.value == "")){
        alert("You must provide the description and name for phase 7. Please try again");
        return false;
    }
    if(number_pad.value > 7 && (desc_p8.value == "" || name_p8.value == "")){
        alert("You must provide the description and name for phase 8. Please try again");
        return false;
    }
    if(number_pad.value > 8 && (desc_p9.value == "" || name_p9.value == "")){
        alert("You must provide the description and name for phase 9. Please try again");
        return false;
    }
    if(number_pad.value > 9 && (desc_p10.value == "" || name_p10.value == "")){
        alert("You must provide the description and name for phase 10. Please try again");
        return false;
    }

    // Finally submit the form. 
    form.submit();
    return true;
}
               
/**
* Validate form input data to create Arena
*/           
function regformarena(form, name, place, address, responsable, sn_active, id, userapp, id_user, id_user_list) {
    // Check each field has a value
    if (name.value == '' || place.value == '' || address.value == '' || sn_active.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    id_user_list.value = __getValueUser(id_user)
    // Finally submit the form. 
    form.submit();
    return true;
}

function __getValueUser(id_user) {
    var value = "";
    for (var i = 0; i < id_user.options.length; i++) {
        if(id_user.options[i].selected){
            value += id_user.options[i].value + ",";
        }
    }
    return value;
}

/**
 * Validate form input data to create Perfil
 */
function regformperfil(form, name, type, sn_active, id, userapp) {
    // Check each field has a value
    if (name.value == '' || type.value == '' || sn_active.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    // Finally submit the form.
    form.submit();
    return true;
}

/**
* Validate form input data to create Assigne Project User
*/
function regformassigne(form, id_project, id_user, date_from, date_to, sn_active, id, userapp) {
    // Check each field has a value
    if (id_project.value == '' || id_user.value == '' || date_from.value == '' || date_to.value == '' || sn_active.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }
    
    // Finally submit the form. 
    form.submit();
    return true;
}

function setManagerArena(id_user){

    var parameters = {
        "id_user" : id_user
    }

    $.ajax({
        data:  parameters,
        url:   'index.php?controller=arena&action=manager',
        type:  'post',
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor...");
        },
        success:  function (response) {
            $("#resultado").html(response);
        }
    });
}

/**
 * Function Validate Electronic Mail.
 * @param email
 * @returns {boolean}
 */
function validaEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
