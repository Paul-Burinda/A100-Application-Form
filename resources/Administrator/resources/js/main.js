function getId(x) {
    return document.getElementById(x);
}

function login(){
    var e = _("email").value;
    var p = _("password").value;

    if (e == "" || p == ""){
        getId("status").innerHTML = "Please fill out all fields";
    } else {
        getId("submit").style.display = "none";
        getId("status").innerHTML = "please wait ...";

        var ajax = ajjaxObj("POST",)
    }
}

function restrict(elem){
    var tf = getId(elem);
    var rx = new RegExp;

    if (elem == "username"){
        rx = /[^a-z0-9]/gi;
    }
    tf.value = tf.value.replace(rx,"");
}

function clearElement(elem){
    getId(elem).innerHTML="";
}

function checkusername(){
    var u = getId("username").value;
    if (u != ""){
        getId("usernamesatus").innerHTML="checking ...";
    }
}
