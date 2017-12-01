var modal = document.getElementById('myModal');

var span = document.getElementsByClassName("close")[0];

function view(course){
    modal.style.display = "block";
    console.log(course);

    document.getElementById("_year").innerText = course.year;
    document.getElementById("_term").innerText = course.term;
    document.getElementById("_course").innerText = course.course;
    document.getElementById("_section").innerText = course.section;

    fetchDescription(course.course);
    fetchCoordinator(course.course, course.year, course.term, course.section);
    fetchGrades(course.course, course.year, course.term, course.section);
    fetchCloMeasures(course.course, course.year, course.term, course.section);
    fetchCloMapping(course.course, course.year, course.term, course.section);

    document.getElementById('_modi').innerText = course.modification;
    document.getElementById('_ref').innerText = course.reflection;
    document.getElementById('_feed').innerText = course.feedback;
    document.getElementById('_propAct').innerText = course.proposed_action;

}

function fetchGrades(course, year, term, section){
    course = course.replace(' ', 'Q');
    //console.log('from grades: ' + course + ' ' + year + ' ' + term + ' ' + section);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);
            record = record[0];
            //console.log(record);
            document.getElementById("_a").innerText = record.A;
            document.getElementById("_b").innerText = record.B;
            document.getElementById("_c").innerText = record.C;
            document.getElementById("_d").innerText = record.D;
            document.getElementById("_f").innerText = record.F;
            document.getElementById("_x").innerText = record.X;
            document.getElementById("_total").innerText = record.sum;
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/grades/' + course + '/' + year + '/' + term + '/' + section, true ); // false for synchronous request
    xmlHttp.send( null );      
}

function fetchCoordinator(course, year, term, section){
    course = course.replace(' ', 'Q');
    //console.log('from coordinator: ' + course + ' ' + year + ' ' + term + ' ' + section);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var assignment = xmlHttp.responseText;
            assignment = JSON.parse(assignment);
            assignment = assignment[0];
            //console.log('from des:' + assignment.uid);

            var xmlHttp_inner = new XMLHttpRequest();
            xmlHttp_inner.onreadystatechange = function() { 
                if (xmlHttp_inner.readyState == 4 && xmlHttp_inner.status == 200){
                    var user = xmlHttp_inner.responseText;
                    user = JSON.parse(user);
                    user = user[0];
                    //console.log(user);
                    document.getElementById("_coordi").innerText = user.username;
                }
            }
            xmlHttp_inner.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/parsusers/' + assignment.uid, true ); // false for synchronous request
            xmlHttp_inner.send( null );

        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/assignment/' + course + '/' + year + '/' + term + '/' + section, true ); // false for synchronous request
    xmlHttp.send( null );      
}

function fetchDescription(course){
    course = course.replace(' ', 'Q');
    //console.log('from description: ' + course);

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);
            record = record[0];
            //console.log(record);
            document.getElementById("_coDes").innerText = record.course_description;
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/course/' + course, true ); // false for synchronous request
    xmlHttp.send( null );      
}

function fetchCloMapping(course, year, term, section){
    course = course.replace(' ', 'Q');

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() { 
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);

            var hook = document.getElementById('mappingHook');

            for (var r in record) {
                var tr = document.createElement('tr');
                hook.appendChild(tr);
                var so = record[r].sonumber + ' - ' + record[r].sodes;
                var clo = record[r].CloNo + ' - ' + record[r].CloDec
                tr.appendChild(document.createElement('td')).innerText = so;
                tr.appendChild(document.createElement('td')).innerText = clo;
            }
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clomapping/' + course + '/' + year + '/' + term + '/' + section, true ); // false for synchronous request
    xmlHttp.send( null );      
}

function fetchCloMeasures(course, year, term, section){
    course = course.replace(' ', 'Q');

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
                tr.appendChild(document.createElement('td')).innerText = record[r].sonumber;
                tr.appendChild(document.createElement('td')).innerText = record[r].CloNo;
                tr.appendChild(document.createElement('td')).innerText = record[r].measures;
                tr.appendChild(document.createElement('td')).innerText = record[r].comments;
                tr.appendChild(document.createElement('td')).innerText = record[r].exemplary + ' (' + Math.round((record[r].exemplary / sum) * 100) + '%)';
                tr.appendChild(document.createElement('td')).innerText = record[r].good + ' (' + Math.round((record[r].good / sum) * 100) + '%'; 
                tr.appendChild(document.createElement('td')).innerText = record[r].satisfactory + ' (' + Math.round((record[r].satisfactory / sum) * 100) + '%)';
                tr.appendChild(document.createElement('td')).innerText = record[r].poor + ' (' + Math.round((record[r].poor / sum) * 100) + '%';
                tr.appendChild(document.createElement('td')).innerText = record[r].unsatisfactory + ' (' + Math.round((record[r].unsatisfactory / sum) * 100) + '%)';
            }
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clomeasures/' + course + '/' + year + '/' + term + '/' + section, true ); // false for synchronous request
    xmlHttp.send( null );      
}

span.onclick = function() {
    modal.style.display = "none";
    document.getElementById('measuresHook').innerText = '';
    document.getElementById('mappingHook').innerText = '';
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        document.getElementById('measuresHook').innerText = '';
        document.getElementById('mappingHook').innerText = '';
    } 
} 