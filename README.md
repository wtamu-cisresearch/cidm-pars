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

![Alt text](erd.jpeg?raw=true "ERD")

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
SELECT DISTINCT pars_course_learning_outcome.clo_id, pars_section.section_id FROM clo_measures, clo, pars_section, pars_course, pars_course_learning_outcome WHERE clo_measures.CloNo = clo.CloNo AND pars_section.course_id = pars_course.course_id AND clo.course = pars_course.code AND pars_section.number = clo.section AND clo.term = pars_section.term AND clo.year = pars_section.year AND clo.CloDec = pars_course_learning_outcome.description 
/*pars_measure*/
SELECT DISTINCT pars_alpha.alpha_id, x.measures, x.exemplary, x.good, x.satisfactory, x.poor, x.unsatisfactory, x.comments FROM pars_alpha, (SELECT DISTINCT pars_course_learning_outcome.clo_id, pars_section.section_id, clo_measures.measures, clo_measures.exemplary, clo_measures.good, clo_measures.satisfactory, clo_measures.poor, clo_measures.unsatisfactory, clo_measures.comments FROM clo_measures, clo, pars_section, pars_course, pars_course_learning_outcome WHERE clo_measures.CloNo = clo.CloNo AND pars_section.course_id = pars_course.course_id AND clo.course = pars_course.code AND pars_section.number = clo.section AND clo.term = pars_section.term AND clo.year = pars_section.year AND clo.CloDec = pars_course_learning_outcome.description) AS x WHERE x.clo_id = pars_alpha.clo_id AND x.section_id = pars_alpha.section_id 
/*pars_student_outcome*/ 
SELECT PloNo, PloDec FROM `plo` GROUP BY PloDec  
/*pars_program_educational_objective*/ 
SELECT peo AS CODE, peo_description AS description FROM program_educational_objective GROUP BY peo_description   
/*pars_beta*/ 
SELECT Y.alpha_id, z.peo_id, Y.so_id FROM ( SELECT DISTINCT pars_alpha.alpha_id, pars_student_outcome.so_id, plo.nid11 FROM clo_measures, clo, pars_section, pars_course, pars_course_learning_outcome, ploclomap, pars_alpha, plo, pars_student_outcome WHERE clo_measures.CloNo = clo.CloNo AND pars_section.course_id = pars_course.course_id AND clo.course = pars_course.code AND pars_section.number = clo.section AND clo.term = pars_section.term AND clo.year = pars_section.year AND clo.CloDec = pars_course_learning_outcome.description AND clo.CloNo = ploclomap.CloNo AND pars_alpha.clo_id = pars_course_learning_outcome.clo_id AND pars_alpha.section_id = pars_section.section_id AND ploclomap.PloNo = plo.nid11 AND plo.PloDec = pars_student_outcome.description ) AS Y, ( SELECT pars_program_educational_objective.peo_id, plopeomap.plo FROM program_education_objective, plopeomap, pars_program_educational_objective WHERE program_education_objective.nid = plopeomap.peo AND pars_program_educational_objective.description = program_education_objective.peo_description GROUP BY plopeomap.plo ) AS z WHERE Y.nid11 = z.plo
/*Manuel Adjustments*/
DELETE FROM pars_section WHERE pars_section.section_id = 69 OR pars_section.section_id = 76;
INSERT INTO pars_section (course_id, instructor_id, instructor, number, term, year, modification, feedback, reflection, proposed_action)  VALUES (2, NULL, "	Dr. Jeffry Babb", 1, "Spring", 2010, "A final group project was introduced as a means of trying CIDM 1315 and CIDM2315.", "Overall, Students did worse than they did in CIDM 1315 by about a letter grade. At the midterm, the feedback related to a disconnect between quiz questions and lecture and what was on their test. Some students sought help throughout the semester, but others were scarce. Some students did engage in their learning process by working with me to create code these are students who excelled. In general the semester was not a good experience for many of the srudents and the expectations difference between CIDM1315 and CIDM2315 adversely affected many of these students.", "I was, on the whole quite unhappy with this class this semester. I have taught this class or variant for all 9 years of my academic career and i have never experienced this degree of coordination and unwillingness to work hard in any group. While I will spend considerable time this summer looking for what I can do to improve the critical CIDM experience, I think the degree of coordination and expectation management between the programming course is key. As we, as a faculty, have plans for a revitalization and ravamp of the programming sequence, I am certain this will work out.", "For next semester, I propose using the Processing using library for java in a graphical context. It is my feeling that this graphical context will improve engagement and learning.");
INSERT INTO pars_alpha (clo_id, section_id) VALUES (163, 103);
INSERT INTO pars_alpha (clo_id, section_id) VALUES (167, 103);
INSERT INTO pars_alpha (clo_id, section_id) VALUES (160, 103);
INSERT INTO pars_alpha (clo_id, section_id) VALUES (190, 103);
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (564, "Assignment", 6, 0, 2, 0, 0, 'Assignment Three, Problems 5.30 and 5.31 from Deitel and Deitel "Java: How to progra Late Objects Version", 8th ed.');
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (565, "Assignment", 7, 0, 2, 0, 0, 'Assignment Three, Problems 5.30 and 5.31 from Deitel and Deitel "Java: How to progra Late Objects Version", 8th ed.');
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (566, "Assignment", 0, 0, 13, 0, 14, 'Assignment Two, Problems 3.31 from Deitel and Deitel "Java: How to progra Late Objects Version", 8th ed.');
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (567, "Assignment", 7, 0, 1, 0, 7, 'Assignment Six, Problems 14.7 from Deitel and Deitel "Java: How to progra Late Objects Version", 8th ed.');
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (564, 4, 1);
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (565, 4, 1);
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (566, 4, 5);
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (567, 4, 7);
UPDATE pars_beta SET pars_beta.so_id = 7 WHERE pars_beta.alpha_id = 1;
UPDATE pars_beta SET pars_beta.so_id = 3 WHERE pars_beta.alpha_id = 5;
UPDATE pars_beta SET pars_beta.so_id = 3 WHERE pars_beta.alpha_id = 3;
UPDATE pars_beta SET pars_beta.peo_id = 2 WHERE pars_beta.alpha_id = 3;
UPDATE pars_beta SET pars_beta.peo_id = 2 WHERE pars_beta.alpha_id = 5 ;
UPDATE pars_beta SET pars_beta.peo_id = 4 WHERE pars_beta.beta_id = 413;
INSERT INTO pars_alpha (clo_id, section_id) VALUES (140, 43);
INSERT INTO pars_alpha (clo_id, section_id) VALUES (127, 43);
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (569, "Rubric", 9, 0, 11, 0, 5, '• A homework assignment has been identified (homework #4) to assess this learning outcome using rubric. It will require the student to develop website structure. • Students who achieve a score of “satisfactory” (2/3) or “exemplary” (3/3) are deemed to have attained an acceptable learning outcome for the objective.');
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (570, "Exam", 6, 0, 3, 0, 16, 'The final exam includes 7 questions from the test bank mapped to this objective. Students who score correctly on 70% or higher are deemed satisfactory and those who score 85% or higher are exemplary.');
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (569, 4, 5);
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (570, 4, 5);
INSERT INTO pars_alpha (clo_id, section_id) VALUES (203, 8);
INSERT INTO pars_measure (alpha_id, type, exemplary, good, satisfactory, poor, unsatisfactory, comment) VALUES (571, "Assignment", 11, 0, 5, 0, 1, 'Homework 7');
INSERT INTO pars_beta (alpha_id, peo_id, so_id) VALUES (571, 4, 7);
UPDATE pars_beta SET pars_beta.so_id = 8 WHERE pars_beta.beta_id = 520;
UPDATE pars_beta SET pars_beta.peo_id = 2 WHERE pars_beta.beta_id = 520;
/*Percentage VS. recorded values grouped by SOs (for original db)*/
SELECT plo.PloNo AS 'sonumber', plo.PloNo AS 'Queried SO (Student Outcome)', ROUND( ( SUM(clo_measures.Epercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Exemplary', ROUND( ( SUM(clo_measures.Gpercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Good', ROUND( ( SUM(clo_measures.Spercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Satisfactory', ROUND( ( SUM(clo_measures.Ppercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Poor', ROUND( ( SUM(clo_measures.Upercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Unsatisfactory', ROUND( ( SUM(clo_measures.exemplary) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Exemplary', ROUND( ( SUM(clo_measures.good) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Good', ROUND( ( SUM(clo_measures.satisfactory) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Satisfactory', ROUND( ( SUM(clo_measures.poor) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Poor', ROUND( ( SUM(clo_measures.unsatisfactory) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Unsatisfactory', COUNT(plo.PloNo) AS 'Number of Records' FROM clo_measures INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND clo_measures.year = "2010" AND clo_measures.term = "Spring" GROUP BY sonumber
/*Percentage VS. recorded values grouped by PEOs (for original db)*/
SELECT program_education_objective.peo, plo.PloNo AS 'Queried SO (Student Outcome)', ROUND( ( SUM(clo_measures.Epercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Exemplary', ROUND( ( SUM(clo_measures.Gpercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Good', ROUND( ( SUM(clo_measures.Spercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Satisfactory', ROUND( ( SUM(clo_measures.Ppercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Poor', ROUND( ( SUM(clo_measures.Upercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Unsatisfactory', ROUND( ( SUM(clo_measures.exemplary) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Exemplary', ROUND( ( SUM(clo_measures.good) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Good', ROUND( ( SUM(clo_measures.satisfactory) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Satisfactory', ROUND( ( SUM(clo_measures.poor) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Poor', ROUND( ( SUM(clo_measures.unsatisfactory) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Unsatisfactory', COUNT(plo.PloNo) AS 'Number of Records' FROM program_education_objective, plopeomap, clo_measures INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND plo.nid11 = plopeomap.plo AND program_education_objective.nid = plopeomap.peo AND clo_measures.year = "2010" AND clo_measures.term = "Spring" GROUP BY program_education_objective.peo
```

----------

 
