var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

var _id;

function pop(record){
    
    modal.style.display = "block";

    // if(record){
    //     document.getElementById('edit').style.display = "block";
    //     document.getElementById('add').style.display = "none";
    //     _id = record.nid5;

    //     document.getElementById("year").value = record.year;
    //     document.getElementById("term").value = record.term;
    //     document.getElementById("course").value = record.course;
    //     document.getElementById("section").value = record.section;
    //     document.getElementById("clonumber").value = record.CloNo;
    //     document.getElementById("clodes").value = record.CloDec;
    // }
    // else{
    //     document.getElementById('edit').style.display = "none";
    //     document.getElementById('add').style.display = "block";
    //     _id = null;
    // }
}

function submit(){    
    
    var year = document.getElementById("year").value;
    var term = document.getElementById("term").value;
    var course = document.getElementById("course").value;
    var section = document.getElementById("section").value;
    var cloNumber = document.getElementById("clonumber").value;
    var cloDes = document.getElementById("clodes").value;

    if(!_id){
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
                location.reload();
            }
        }
        xmlHttp.open("POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clo/' + 
                        course + '/' + year + '/' + term + '/' + section + '/' + cloNumber + '/' + cloDes), true );
        xmlHttp.send( null );
        modal.style.display = "none";
        console.log(xmlHttp.responseText);
    }
    else{
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
                location.reload();
            }
        }
        xmlHttp.open("POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clo/' + 
                       _id + '/' + course + '/' + year + '/' + term + '/' + section + '/' + cloNumber + '/' + cloDes), true );
        xmlHttp.send( null );
        modal.style.display = "none";
        console.log(xmlHttp.responseText);
    }
}

function discard(){    

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            location.reload();
        }
    }
    xmlHttp.open( "DELETE", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clo/' + _id , true );
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