Welcome to PARS (Program Accreditation Reporting System)
===================

Work in progress...

----------

Getting Started
-------------
 
Work in progress...

Entity Relational Digram
-------------


![Alt text](new-erd.jpeg?raw=true "New ERD")

# Queries to populate the new entities:

> **Note:** Not fully tested

> **Note:** The queries need to be executed sequentially

```sql
 /*pars_class*/  
 SELECT course AS 'code', course_name AS 'name', course_description AS description FROM `course` GROUP BY course  
 /*pars_course*/  
 SELECT pars_class.class_id, X.name AS instructor, grades.section, grades.term, grades.year, assessment_data.modification, assessment_data.feedback, assessment_data.reflection, assessment_data.proposed_action, grades.A AS a, grades.B AS b, grades.C AS c, grades.D AS d, grades.F AS f, grades.X AS x FROM grades, assessment_data, pars_class, ( SELECT users.name, assignment.course, assignment.section, assignment.term, assignment.year FROM users, assignment WHERE users.uid = assignment.uid ) AS X WHERE grades.course = assessment_data.course AND grades.section = assessment_data.section AND grades.term = assessment_data.term AND grades.year = assessment_data.year AND grades.course = pars_class.code AND grades.course = X.course AND grades.section = X.section AND grades.term = X.term AND grades.year = X.year  
 /*pars_course_learning_outcome*/  
 SELECT CloNo, CloDec FROM clo GROUP BY CloDec  
 /*pars_objective*/  
 SELECT DISTINCT X.clo_id, Y.course_id FROM ( SELECT clo.CloNo, clo.course, clo.section, clo.term, clo.year, pars_course_learning_outcome.clo_id FROM clo, pars_course_learning_outcome WHERE clo.CloDec = pars_course_learning_outcome.description ) AS X, ( SELECT pars_course.course_id, pars_class.code, pars_course.section, pars_course.term, pars_course.year FROM pars_course, pars_class WHERE pars_course.class_id = pars_class.class_id ) AS Y WHERE X.course = Y.code AND X.year = Y.year AND X.term = Y.term AND X.section = Y.section  
 /*pars_measures*/  
 SELECT i.objective_id, clo_measures.measures AS TYPE, clo_measures.exemplary, clo_measures.good, clo_measures.satisfactory, clo_measures.poor, clo_measures.unsatisfactory, clo_measures.comments AS COMMENT FROM clo_measures, ( SELECT pars_objective.objective_id, z.code FROM pars_objective, ( SELECT X.CloNo AS CODE, X.clo_id, Y.course_id FROM ( SELECT clo.CloNo, clo.course, clo.section, clo.term, clo.year, pars_course_learning_outcome.clo_id FROM clo, pars_course_learning_outcome WHERE clo.CloDec = pars_course_learning_outcome.description ) AS X, ( SELECT pars_course.course_id, pars_class.code, pars_course.section, pars_course.term, pars_course.year FROM pars_course, pars_class WHERE pars_course.class_id = pars_class.class_id ) AS Y WHERE X.course = Y.code AND X.year = Y.year AND X.term = Y.term AND X.section = Y.section ) AS z WHERE z.clo_id = pars_objective.clo_id AND z.course_id = pars_objective.course_id GROUP BY pars_objective.objective_id, z.clo_id, z.course_id ) AS i WHERE i.code = clo_measures.CloNo  
 /*pars_student_outcome*/  
 SELECT PloNo, PloDec FROM `plo` GROUP BY PloDec  
 /*pars_fulfillment*/  
 SELECT pars_student_outcome.so_id, z.clo_id FROM pars_student_outcome, ( SELECT plo.PloDec, Y.clo_id FROM plo, ( SELECT X.CloNo, X.PloNo, X.CloDec, pars_course_learning_outcome.clo_id FROM pars_course_learning_outcome, ( SELECT ploclomap.CloNo, ploclomap.PloNo, clo.CloDec FROM ploclomap, clo WHERE ploclomap.CloNo = clo.CloNo GROUP BY clo.CloNO ) AS X WHERE X.CloDec = pars_course_learning_outcome.description ) AS Y WHERE Y.PloNo = plo.nid11 ) AS z WHERE z.PloDec = pars_student_outcome.description GROUP BY pars_student_outcome.so_id, z.clo_id  
 /*pars_program_educational_objective*/  
 SELECT peo AS CODE, peo_description AS description FROM program_educational_objective GROUP BY peo_description   
 /*pars_expectation*/  
 SELECT pars_student_outcome.so_id, pars_program_educational_objective.peo_id FROM pars_student_outcome, pars_program_educational_objective, ( SELECT plo.PloDec, program_education_objective.peo_description FROM plopeomap, plo, program_education_objective WHERE plopeomap.plo = plo.nid11 AND plopeomap.peo = program_education_objective.nid ) AS X WHERE pars_student_outcome.description = X.PloDec AND pars_program_educational_objective.description = X.peo_description GROUP BY pars_student_outcome.so_id, pars_program_educational_objective.peo_id   

```

----------

 
