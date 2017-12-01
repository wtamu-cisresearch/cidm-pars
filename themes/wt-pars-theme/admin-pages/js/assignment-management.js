var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

function pop(record){
    
    modal.style.display = "block"; 

    popUsers();
}

function popUsers(){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);
            console.log(record);
            var hook = document.getElementById('usersHook');

            for (var r in record) {
                
                var option = hook.appendChild(document.createElement('option'));
                option.innerText = record[r].NAME;
                option.value = record[r].id;
                option.id = record[r].id;
            }
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/wpusers', true ); // false for synchronous request);
    xmlHttp.send( null );
}

function submit(){    
    
    var id = document.getElementById("usersHook").value;
    var name = document.getElementById(id).innerText;
    var course = document.getElementById("course").value;
    var startFCAR = document.getElementById("startfcar").value;
    var endFCAR = document.getElementById("endfcar").value;

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            location.reload();
            console.log(encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/assignment/' + 
            id + '/' + name  + '/' + course + '/' + startFCAR + '/' + endFCAR));
        }
    }
    xmlHttp.open("POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/assignment/' + 
                id + '/' + name  + '/' + course + '/' + startFCAR + '/' + endFCAR), true );
    xmlHttp.send( null );
    modal.style.display = "none";
    console.log(xmlHttp.responseText);
}

function discard(id){    
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            location.reload();
        }
    }
    xmlHttp.open( "DELETE", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/assignment/' + id , true );
    xmlHttp.send( null );
    modal.style.display = "none";
}

function yaydata(data){
    console.log(data);
}

span.onclick = function() {
    modal.style.display = "none";
    garbageCollector();    
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        garbageCollector();
    } 
} 

function garbageCollector(){
    for(var bag in document.getElementsByClassName('garbage-collector')){
        document.getElementsByClassName('garbage-collector')[bag].value = null;
    }
} 