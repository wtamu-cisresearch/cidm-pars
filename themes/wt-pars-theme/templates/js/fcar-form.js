var modal = document.getElementById('baseModal');
var childModal = document.getElementById('childModal');

var span = document.getElementsByClassName("close")[0];
var childClose = document.getElementsByClassName("close")[1];

var _course;
var _cloMeasures = [];
var _grades;
var _assessmentData;
var _tempCloNumber;
var _tempCloId;
var _x = 0;

var _measureId = null;


function form(year, term, course, section){

    modal.style.display = "block";

    document.getElementById("_year").innerText = year;
    document.getElementById("_term").innerText = term;
    document.getElementById("_course").innerText = course;
    document.getElementById("_section").innerText = section;

    _course = {year : year, term : term, course : course, section : section};

    fetchDescription(course);
    fetchClos(year, term, course, section);
}

function fetchClos(year, term, course, section){
    course = course.replace(' ', 'Q');

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);

            var hook = document.getElementById('_cloHook');

            for (var r in record) {
                hook.appendChild(document.createElement('option')).innerText = record[r].CloNo;
            }
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clono/' + course + '/' + year + '/' + term + '/' + section, true ); // false for synchronous request
    xmlHttp.send( null );
}

function spanModal(clono){

    clono = clono.replace(' ', 'Q');

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);

            childModal.style.display = "block";
            _tempCloNumber = record[0].clonumber;
            _tempCloId = record[0].soid;
            document.getElementById('courseDes').innerText = record[0].clodes;
            document.getElementById('mappedSo').innerText = record[0].sonumber + ' - ' + record[0].sodes;
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/crossbridge/' + clono, true ); // false for synchronous request
    xmlHttp.send( null );
}

function fetchDescription(course){
    course = course.replace(' ', 'Q');

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var record = xmlHttp.responseText;
            record = JSON.parse(record);
            record = record[0];
            document.getElementById("_coDes").innerText = record.course_description;
        }
    }
    xmlHttp.open( "GET", 'http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/course/' + course, true ); // false for synchronous request
    xmlHttp.send( null );
}

function saveMeasure(m, e, g, s, p, u, c){

    var measure = m;
    var exemplary = parseInt(e);
    var good = parseInt(g);
    var satisfactory = parseInt(s);
    var poor = parseInt(p);
    var unsatisfactory = parseInt(u);
    var comments = c;
    var sum = exemplary + good + satisfactory + poor + unsatisfactory;

    if(!_measureId){

        _x++;

        _cloMeasures.push({
                            id : _x, clonumber : _tempCloNumber, course : _course.course, measure : measure, section : _course.section, term : _course.term, year : _course.year, exemplary : exemplary,
                            good : good, satisfactory : satisfactory, poor : poor, unsatisfactory : unsatisfactory, soid : _tempCloId, epercentage : (exemplary / sum) * 100,
                            gpercentage : (good / sum) * 100,  spercentage : (satisfactory / sum) * 100, ppercentage : (poor / sum) * 100, upercentage : (unsatisfactory / sum) * 100, comments : comments,
                            peo : 1
                        });


        document.getElementById('defaultOption').selected = true;

        var hook = document.getElementById('_widgetsHook');
        var widget = hook.appendChild(document.createElement('span'));
        widget.style = "background-color:#FF7F50; text-align:center; width:25%; border-radius:25px; cursor:pointer; padding:5px; padding-left:8px; padding-right:8px;"
        widget.id = _x;
        widget.onclick = function(){ editMeasure(this.id) };
        widget.innerText = _tempCloNumber;

        childModal.style.display = 'none';
    }
    else{
        childModal.style.display = 'none';
        document.getElementById('delete').style.display = "none";

        for(i in _cloMeasures){
            if(_measureId == _cloMeasures[i].id){
                _cloMeasures[i].measure = measure;
                _cloMeasures[i].exemplary = exemplary;
                _cloMeasures[i].good = good;
                _cloMeasures[i].satisfactory = satisfactory;
                _cloMeasures[i].poor = poor;
                _cloMeasures[i].unsatisfactory = unsatisfactory;
                _cloMeasures[i].comments = comments;
                _cloMeasures[i].epercentage = (exemplary / sum) * 100;
                _cloMeasures[i].gpercentage = (good / sum) * 100;
                _cloMeasures[i].satisfactory = (satisfactory / sum) * 100;
                _cloMeasures[i].ppercentage = (poor / sum) * 100;
                _cloMeasures[i].upercentage = (unsatisfactory / sum) * 100;
            }
        }

        _measureId = null;
        
    }
}

function editMeasure(id){
    for(i in _cloMeasures){
        if(id == _cloMeasures[i].id){
            console.log(_cloMeasures[i]);
            document.getElementById('measure').value = _cloMeasures[i].measure;
            document.getElementById('exemplary').value = _cloMeasures[i].exemplary;
            document.getElementById('good').value = _cloMeasures[i].good;
            document.getElementById('satisfactory').value = _cloMeasures[i].satisfactory;
            document.getElementById('poor').value = _cloMeasures[i].poor;
            document.getElementById('unsatisfactory').value = _cloMeasures[i].unsatisfactory;
            document.getElementById('comments').value = _cloMeasures[i].comments;

            _measureId = _cloMeasures[i].id;
            document.getElementById('delete').style.display = "block";
            spanModal(_cloMeasures[i].clonumber);
        }
    }
}

function submit(){
    var a = document.getElementById('a').value;
    var b = document.getElementById('b').value;
    var c = document.getElementById('c').value;
    var d = document.getElementById('d').value;
    var f = document.getElementById('f').value;
    var x = document.getElementById('x').value;
    var sum = parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(f) + parseInt(x);

    var modifications = document.getElementById('modifications').value;
    var reflection = document.getElementById('reflection').value;
    var feedback = document.getElementById('feedback').value;
    var improvement = document.getElementById('improvement').value;

    _grades = {course : _course.course, section : _course.section, term : _course.term, year : _course.year, a : a, b : b, c : c, d : d, f : f, x : x, sum : sum};
    _assessmentData = {course : _course.course, section : _course.section, term : _course.term, year : _course.year, modification : modifications, feedback : feedback,
                       reflection : reflection, improvement : improvement};

    for(var m in _cloMeasures){
        var clo_measures = new XMLHttpRequest();
        clo_measures.onreadystatechange = function() {
            if (clo_measures.readyState == 4 && clo_measures.status == 200){
                console.log('_cloMeasures Saved');
            }
        }
        clo_measures.open( "POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clomeasures/' + _cloMeasures[m].clonumber + '/'
                            + _cloMeasures[m].course + '/' + _cloMeasures[m].measure + '/' + _cloMeasures[m].section + '/' + _cloMeasures[m].term + '/' + _cloMeasures[m].year + '/'
                            + _cloMeasures[m].exemplary + '/' + _cloMeasures[m].good + '/' + _cloMeasures[m].satisfactory + '/' + _cloMeasures[m].poor + '/'
                            + _cloMeasures[m].unsatisfactory + '/' + _cloMeasures[m].soid + '/' + _cloMeasures[m].epercentage + '/'
                            + _cloMeasures[m].gpercentage + '/' + _cloMeasures[m].spercentage + '/' + _cloMeasures[m].ppercentage + '/'
                            + _cloMeasures[m].upercentage + '/' + _cloMeasures[m].comments + '/' + _cloMeasures[m].peo), true );
        clo_measures.send( null );

        console.log(encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/clomeasures/' + _cloMeasures[m].clonumber + '/'
                            + _cloMeasures[m].course + '/' + _cloMeasures[m].measure + '/' + _cloMeasures[m].section + '/' + _cloMeasures[m].term + '/' + _cloMeasures[m].year + '/'
                            + _cloMeasures[m].exemplary + '/' + _cloMeasures[m].good + '/' + _cloMeasures[m].satisfactory + '/' + _cloMeasures[m].poor + '/'
                            + _cloMeasures[m].unsatisfactory + '/' + _cloMeasures[m].soid + '/' + _cloMeasures[m].epercentage + '/'
                            + _cloMeasures[m].gpercentage + '/' + _cloMeasures[m].spercentage + '/' + _cloMeasures[m].ppercentage + '/'
                            + _cloMeasures[m].upercentage + '/' + _cloMeasures[m].comments + '/' + _cloMeasures[m].peo));
    }

    var assessment_data = new XMLHttpRequest();
    assessment_data.onreadystatechange = function() {
        if (assessment_data.readyState == 4 && assessment_data.status == 200){
            console.log('assessment_data Saved');
        }
    }
    assessment_data.open( "POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/assessmentdata/' + _assessmentData.course
                          + '/' + _assessmentData.section + '/' + _assessmentData.term + '/' + _assessmentData.year + '/' + _assessmentData.modification
                          + '/' + _assessmentData.feedback + '/' + _assessmentData.reflection + '/' + _assessmentData.improvement), true );
    assessment_data.send( null );

    console.log(encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/assessmentdata/' + _assessmentData.course
    + '/' + _assessmentData.section + '/' + _assessmentData.term + '/' + _assessmentData.year + '/' + _assessmentData.modification
    + '/' + _assessmentData.feedback + '/' + _assessmentData.reflection + '/' + _assessmentData.improvement));

    var grades = new XMLHttpRequest();
    grades.onreadystatechange = function() {
        if (grades.readyState == 4 && grades.status == 200){
            console.log('grades Saved');
        }
    }
    grades.open( "POST", encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/grades/' + _grades.course
                          + '/' + _grades.section + '/' + _grades.term + '/' + _grades.year + '/' + _grades.a
                          + '/' + _grades.b + '/' + _grades.c + '/' + _grades.d + '/' + _grades.f + '/' + _grades.x + '/' + _grades.sum), true );
    grades.send( null );

    console.log(encodeURI('http://' + window.location.hostname + '/wt-pars/wp-json/wt-pars-plugin/v1/grades/' + _grades.course
    + '/' + _grades.section + '/' + _grades.term + '/' + _grades.year + '/' + _grades.a
    + '/' + _grades.b + '/' + _grades.c + '/' + _grades.d + '/' + _grades.f + '/' + _grades.x + '/' + _grades.sum));

    modal.style.display = "none";
    garbageCollector();

}

function fileUpload(f){
    console.log(f);
}

span.onclick = function() {
    modal.style.display = "none";
    garbageCollector();
}

childClose.onclick = function(){
    childModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        garbageCollector();
    }
}

function garbageCollector(){
    document.getElementById('_widgetsHook').innerText = '';
    document.getElementById('_cloHook').innerText = '';
}