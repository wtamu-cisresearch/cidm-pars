Welcome to PARS (Program Assessment Reporting System)
===================

Work in progress...

----------

Getting Started
-------------
 
Work in progress...

Entity Relational Digram
-------------

> **Design Idea:** The admin will have a window in the dashboard in which he will create a new section, and add all of the course learning outcomes that go with it. The admin will then go to another window in which he will see all of the course learning outcomes that he has assigned to sections and map them with the appropiate student outcomes and program learning objectives. The instructors will then be able to view the new sections assigned to them, modify the section table and add records to the measure table. 

![Alt text](_erd.jpeg?raw=true "ERD")

```sql
/*pars_course*/ 
SELECT course AS 'code', course_name AS 'name', course_description AS description FROM `course` GROUP BY course 
/*pars_section*/ 
SELECT pars_course.course_id, X.name AS instructor, grades.section, grades.term, grades.year, assessment_data.modification, assessment_data.feedback, assessment_data.reflection, assessment_data.proposed_action, grades.A AS a, grades.B AS b, grades.C AS c, grades.D AS d, grades.F AS f, grades.X AS X FROM grades, assessment_data, pars_course, ( SELECT users.name, assignment.course, assignment.section, assignment.term, assignment.year FROM users, assignment WHERE users.uid = assignment.uid ) AS X WHERE grades.course = assessment_data.course AND grades.section = assessment_data.section AND grades.term = assessment_data.term AND grades.year = assessment_data.year AND grades.course = pars_course.code AND grades.course = X.course AND grades.section = X.section AND grades.term = X.term AND grades.year = X.year 
/*pars_course_learning_outcome*/ 
SELECT CloNo, CloDec FROM clo GROUP BY CloDec 
/*pars_assigned_course_learning_outcome*/ 
SELECT clo.CloNo, clo.course, clo.section, clo.term, clo.year, pars_course_learning_outcome.clo_id FROM clo, pars_course_learning_outcome WHERE clo.CloDec = pars_course_learning_outcome.description 
/*pars_alpha*/ 
SELECT DISTINCT pars_course_learning_outcome.clo_id, pars_section.section_id FROM clo_measures, clo, pars_section, pars_course, pars_course_learning_outcome WHERE clo_measures.CloNo = clo.CloNo AND pars_section.course_id = pars_course.course_id AND clo.course = pars_course.code AND pars_section.section = clo.section AND clo.term = pars_section.term AND clo.year = pars_section.year AND clo.CloDec = pars_course_learning_outcome.description 
/*pars_measure*/
SELECT DISTINCT pars_alpha.alpha_id, x.measures, x.exemplary, x.good, x.satisfactory, x.poor, x.unsatisfactory, x.comments FROM pars_alpha, (SELECT DISTINCT pars_course_learning_outcome.clo_id, pars_section.section_id, clo_measures.measures, clo_measures.exemplary, clo_measures.good, clo_measures.satisfactory, clo_measures.poor, clo_measures.unsatisfactory, clo_measures.comments FROM clo_measures, clo, pars_section, pars_course, pars_course_learning_outcome WHERE clo_measures.CloNo = clo.CloNo AND pars_section.course_id = pars_course.course_id AND clo.course = pars_course.code AND pars_section.section = clo.section AND clo.term = pars_section.term AND clo.year = pars_section.year AND clo.CloDec = pars_course_learning_outcome.description) AS x WHERE x.clo_id = pars_alpha.clo_id AND x.section_id = pars_alpha.section_id 
/*pars_student_outcome*/ 
SELECT PloNo, PloDec FROM `plo` GROUP BY PloDec  
/*pars_program_educational_objective*/ 
SELECT peo AS CODE, peo_description AS description FROM program_educational_objective GROUP BY peo_description   
/*pars_beta*/ 
SELECT DISTINCT pars_alpha.alpha_id, pars_student_outcome.so_id, plo.nid11 FROM ploclomap, pars_alpha, plo, pars_student_outcome, plopeomap, program_education_objective, pars_program_educational_objective, ( SELECT DISTINCT pars_course_learning_outcome.clo_id, pars_section.section_id, clo.CloNo FROM clo_measures, clo, pars_section, pars_course, pars_course_learning_outcome WHERE clo_measures.CloNo = clo.CloNo AND pars_section.course_id = pars_course.course_id AND clo.course = pars_course.code AND pars_section.section = clo.section AND clo.term = pars_section.term AND clo.year = pars_section.year AND clo.CloDec = pars_course_learning_outcome.description ) AS X WHERE X.CloNO = ploclomap.CloNo AND pars_alpha.section_id = X.section_id AND pars_alpha.clo_id = X.clo_id AND ploclomap.PloNo = plo.nid11 AND plo.PloDec = pars_student_outcome.description AND plo.nid11 = plopeomap.plo AND plopeomap.peo = program_education_objective.nid AND pars_program_educational_objective.description = program_education_objective.peo_description
/*test alpha*/ 
SELECT pars_course.code, pars_section.section, pars_section.year, pars_section.term, pars_course_learning_outcome.code, pars_course_learning_outcome.description FROM pars_course, pars_section, pars_alpha, pars_course_learning_outcome WHERE pars_section.course_id = pars_course.course_id AND pars_section.year = 2015 AND pars_section.term = "Spring" AND pars_course.code = "CIDM 1315" AND pars_section.section = 1 AND pars_section.section_id = pars_alpha.section_id AND pars_alpha.clo_id = pars_course_learning_outcome.clo_id  
/*test beta*/ 
SELECT pars_course.code, pars_section.section, pars_section.year, pars_student_outcome.code, pars_student_outcome.description, pars_section.term, pars_course_learning_outcome.code, pars_course_learning_outcome.description FROM pars_course, pars_section, pars_alpha, pars_course_learning_outcome, pars_beta, pars_student_outcome WHERE pars_section.course_id = pars_course.course_id AND pars_section.year = 2016 AND pars_section.term = "Spring" AND pars_course.code = "CIDM 4390" AND pars_section.section = 1 AND pars_section.section_id = pars_alpha.section_id AND pars_alpha.clo_id = pars_course_learning_outcome.clo_id AND pars_beta.alpha_id = pars_alpha.alpha_id AND pars_beta.so_id = pars_student_outcome.so_id GROUP BY pars_course_learning_outcome.code 
/*test measure*/
SELECT pars_course.code, pars_section.section, pars_section.year, pars_section.term, pars_course_learning_outcome.code, pars_course_learning_outcome.description, pars_measure.type, pars_measure.exemplary, pars_measure.satisfactory, pars_measure.unsatisfactory FROM pars_course, pars_section, pars_alpha, pars_course_learning_outcome, pars_measure WHERE pars_section.course_id = pars_course.course_id AND pars_section.year = 2011 AND pars_section.term = "Fall" AND pars_course.code = "CIDM 2342" AND pars_section.section = 1 AND pars_section.section_id = pars_alpha.section_id AND pars_alpha.clo_id = pars_course_learning_outcome.clo_id AND pars_measure.alpha_id = pars_alpha.alpha_id
```

----------

 
