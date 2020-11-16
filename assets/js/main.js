window.addEventListener("load", function () {

    //ajax
    const form = document.getElementById("form");
    const feedback = document.getElementById("info");
    const submit = document.getElementById("form_submit");
    const loading = document.getElementById("form_loading");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        submit.style.transition = "none";
        submit.style.borderColor = "white";
        submit.style.fontSize = "1rem";
        submit.disabled = true;
        submit.value = "Envoyer";
        loading.style.opacity = "1";
        feedback.style.color = "white";
        feedback.innerHTML = "";
        submit.style.transition = "all 0.25s ease-in-out";

        setTimeout(function () {
            // select all fields values
            let form_body = new FormData();
            form_body.append("email", document.getElementById("email").value);
            form_body.append("subject", document.getElementById("subject").value);
            form_body.append("message", document.getElementById("message").value);

            fetch("./src/request.php", {
                method: 'POST',
                mode: 'cors',
                credentials: 'same-origin',
                body: form_body
            })
                .then(response => response.json())
                .then(json => {
                    console.log(json);
                    feedback.innerHTML = json.feedback_message;
                    submit.disabled = false;
                    if (json.code === 200) {
                        submit.style.borderColor = "#00aa00";
                        submit.style.fontSize = "2rem";
                        submit.value = "✔️";
                        loading.style.opacity = "0";
                        feedback.style.color = "#00aa00";
                    }
                    else{
                        feedback.style.color = "red";
                        loading.style.opacity = "0";
                    }
                });
        }, 500);
    //#00aa00
    })
})