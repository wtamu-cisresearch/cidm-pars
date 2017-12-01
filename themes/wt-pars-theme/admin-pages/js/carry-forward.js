function carryForward(){        

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            yaydata(xmlHttp.responseText);
            alert('Sucess!');
            location.reload();
        }
    }
    xmlHttp.open("POST", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/carFor/' + parseInt(document.getElementById('_yearInput').value) + '', true ); // false for synchronous request
    xmlHttp.send( null );
    console.log(xmlHttp.responseText);
}

function yaydata(data){
    console.log(data);
}