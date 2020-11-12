window.addEventListener("load", function () {

    //ajax
    const form = document.getElementById("form");
    const feedback = document.getElementById("info");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

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
            .then(json => console.log(json.status_message));
    })

})