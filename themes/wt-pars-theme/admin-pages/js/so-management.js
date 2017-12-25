var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

var _id;

function pop(record){
    
    modal.style.display = "block";

    // if(record){
    //     document.getElementById('edit').style.display = "block";
    //     document.getElementById('add').style.display = "none";
    //     _id = record.nid11;

    //     document.getElementById("year").value = record.year;
    //     document.getElementById("term").value = record.term;
    //     document.getElementById("sonumber").value = record.PloNo;
    //     document.getElementById("sodes").value = record.PloDec;
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
    var soNumber = document.getElementById("sonumber").value;
    var soDes = document.getElementById("sodes").value;

    if(!_id){
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
                location.reload();
            }
        }
        xmlHttp.open("POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/so/' + 
                         year + '/' + term + '/' + soNumber + '/' + soDes), true );
        xmlHttp.send( null );
        modal.style.display = "none";
        console.log(xmlHttp.responseText);
    }
    else{
        console.log(encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/so/' + 
        _id +  '/' + year + '/' + term + '/' + soNumber + '/' + soDes));
        var xmlHttp = new XMLHttpRequest();
        xmlHttp.onreadystatechange = function() { 
            if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
                location.reload();
            }
        }
        xmlHttp.open("POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/so/' + 
                       _id +  '/' + year + '/' + term + '/' + soNumber + '/' + soDes), true );
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
    xmlHttp.open( "DELETE", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/so/' + _id , true );
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