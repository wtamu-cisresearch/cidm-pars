var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

var _id;

function pop(record){
    
    modal.style.display = "block";
}

function submit(){    
    
    var year = document.getElementById("year").value;
    var term = document.getElementById("term").value;
    var course = document.getElementById("course").value;
    var section = document.getElementById("section").value;
    var courseName = document.getElementById("coursename").value;
    var courseDes = document.getElementById("coursedes").value;


    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            location.reload();
        }
    }
    xmlHttp.open("POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/course/' + 
                    _id + '/' + course + '/' + section + '/' + term + '/' + year + '/' + courseName + '/' + courseDes), true );
    xmlHttp.send( null );
    modal.style.display = "none";
    console.log(xmlHttp.responseText);
    
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