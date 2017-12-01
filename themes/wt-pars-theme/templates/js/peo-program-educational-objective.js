var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

function cloReport(peoid, year, term){
    
    console.log(peoid, year, term);

    modal.style.display = "block";

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);

            var hook = document.getElementById('measuresHook');
 
            for (var r in record) {
                var sum = parseInt(record[r].exemplary) + parseInt(record[r].good) + parseInt(record[r].satisfactory) + parseInt(record[r].poor) + parseInt(record[r].unsatisfactory);
                var tr = document.createElement('tr');
                hook.appendChild(tr);
                tr.appendChild(document.createElement('td')).innerText = record[r].sonumber + ' ' + record[r].sodes;
                tr.appendChild(document.createElement('td')).innerText = record[r].exemplary + '%';
                tr.appendChild(document.createElement('td')).innerText = record[r].satisfactory + '%';
                tr.appendChild(document.createElement('td')).innerText = record[r].unsatisfactory + '%';
            }
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/soreport/' + peoid + '/' + year + '/' + term, true ); // false for synchronous request
    xmlHttp.send( null );
}


function yaydata(data){
    console.log(data);
}

span.onclick = function() {
    document.getElementById('measuresHook').innerText = '';
    modal.style.display = "none";    
}

window.onclick = function(event) {
    if (event.target == modal) {
        document.getElementById('measuresHook').innerText = '';
        modal.style.display = "none";
    } 
} 