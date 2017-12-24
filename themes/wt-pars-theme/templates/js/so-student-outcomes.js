var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

function cloReport(so_id, year, term) {

    console.log(so_id + ' ' + year + ' ' + term);
    modal.style.display = "block";

    $.ajax({
        url: settings.root + 'wt-pars-theme/v2/studentoutcomes/' + so_id + '/' + year + '/' + term,
        method: 'GET',
        beforeSend: function(xhr){
            xhr.setRequestHeader( 'X-WP-Nonce', settings.nonce)
        },
        success: function (data) {

            var hook = document.getElementById('measuresHook');
            
            for (var d in data) {
                var sum = parseInt(data[d].exemplary) + parseInt(data[d].good) + parseInt(data[d].satisfactory) + parseInt(data[d].poor) + parseInt(data[d].unsatisfactory);
                var tr = document.createElement('tr');
                hook.appendChild(tr);
                tr.appendChild(document.createElement('td')).innerText = data[d].clo_code + ' ' + data[d].clo_description;
                tr.appendChild(document.createElement('td')).innerText = data[d].exemplary + '%';
                tr.appendChild(document.createElement('td')).innerText = data[d].satisfactory + '%';
                tr.appendChild(document.createElement('td')).innerText = data[d].unsatisfactory + '%';
            }    

        },
        error: function (xhr, status, error) {
            console.info(xhr.responseText);
        },
    })
}

function yaydata(data) {
    console.log(data);
}

span.onclick = function () {
    modal.style.display = "none";
}

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
} 