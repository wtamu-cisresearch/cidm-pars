Welcome to PARS (Program Accreditation Reporting System)
===================

This application does not make use of the default WordPress entities. The data was structured in custom tables, and those tables are simply brought in and used in the application. The alternative would have been to insert the data into the WordPress default tables, and create custom post types, taxonomies, and so forth. 

Currently this application is in *phase one* which is to the recreation of the origin application done in Drupal. I started working on this in the middle of the Fall semester, and was able to recreate much of the application's main functionality. I would like you to note that getting this application to  be a 100% working site that is ready to be used is useless without a complete remake of the entities and their design as it is currently extremely poor and needs to be modified. 

----------

Getting Started
-------------
 
In order to run the application download a fresh WordPress copy and replace the content of the **wp-content** folder with the files in this project. Then in themes activate **wt-pars-theme**, 
and  in plugins activate **rest-api**. I'm also using **wp-force-login** for security but you don't need it for the application to run.

> **Note:** The route for the custom endpoints is wt-pars-plugin/v1 -  This is because originally the endpoints were in a plugin separate from **wt-pars-theme**. But now they are in the endpoints folder included in the theme.

You will also need a data dump. You can import the entire .sql file to the database you have connected to your WordPress application, and everything should work fine. Having said the if the data dump you have is that of the original Drupal application than keep in mind that not all the tables are used. In fact your data dump will most likely contain many default Drupal tables that you won't need. 

Here is a list of the tables that are used. If you like to you can import the whole data dump to your database and delete the tables you don't need. You can also import the data dump to a separate database and export the tables in this list. There is only one new table that I've created which is the **pars_users** table.

 - **assessment_data** 
 - **assignment**
 - **clo**
 - **clo_measures**
 - **course**
 - **grades**
 - **plo**
 - **ploclomap**
 - **plopeomap**
 - **program_education_objective**
 - **pars_users**

> **Note:** In the FCARs (Faculty Course Assessment Reports) the professors names are pulled from the **users** table. Therefore we need data from this table. The only columns we need however are **uid** and **name** so I chopped all the other attributes, and saved the data to **pars_users**
> 
> You may be wondering why I only modified this table. In the following section I talk a bit more about the ERD, but the reason I modified this table is because I didn't want to create a relationship between **assignment** and **wp_usermeta** because the data in **wp_usermeta** can be deleted. If you examine the code in **assignment-management.js** and **endpoints.php** you will see that I fetch the users names from **wp_usermeta** and save them into **pars_users** In order to maintain a separation between the professors names showing up in their reports and the users who have access to the system. 

Entity Relational Digram
-------------

The one aspect in this appliation that gave me the most trouble was the ERD design. I was not given any diagrams, or documentation, and so I had to examined the original application and draw the ERD as best as I could.  Here is the diagram that I came up with:

![Alt text](current-erd.jpeg?raw=true "Current ERD")


#### Things to keep in mind:

- There are no "formal" foreign keys instead multiple attributes are used to travel from one table to another. 
-  There are naming inconsistencies. For example, **PloNo** in **ploclomap** does not refer to **PloNo** in **plo** the table, but refers to **nid11**
- There are multiple paths (relationships) between some tables. For example **program_education_objective** can be mapped to **clo_measures** via **peo** in **clo_measure**s or by going through **plopeopmap** and **plo**.
- **clo_measures** records the measures as points and percentages resulting in redundancy and inconsistencies. Check the following SQL query:

```sql
SELECT plo.PloNo AS 'sonumber', plo.PloNo AS 'Queried SO (Student Outcome)', ROUND( ( SUM(clo_measures.Epercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Exemplary', ROUND( ( SUM(clo_measures.Gpercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Good', ROUND( ( SUM(clo_measures.Spercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Satisfactory', ROUND( ( SUM(clo_measures.Ppercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Poor', ROUND( ( SUM(clo_measures.Upercentage) /( SUM(clo_measures.Epercentage) + SUM(clo_measures.Gpercentage) + SUM(clo_measures.Spercentage) + SUM(clo_measures.Ppercentage) + SUM(clo_measures.Upercentage) ) * 100 ), 2 ) AS 'Recorded Unsatisfactory', ROUND( ( SUM(clo_measures.exemplary) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Exemplary', ROUND( ( SUM(clo_measures.good) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Good', ROUND( ( SUM(clo_measures.satisfactory) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Satisfactory', ROUND( ( SUM(clo_measures.poor) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Poor', ROUND( ( SUM(clo_measures.unsatisfactory) /( SUM(clo_measures.exemplary) + SUM(clo_measures.good) + SUM(clo_measures.satisfactory) + SUM(clo_measures.poor) + SUM(clo_measures.unsatisfactory) ) * 100 ), 2 ) AS 'Calculated Unsatisfactory', COUNT(plo.PloNo) AS 'Number of Records' FROM clo_measures INNER JOIN plo WHERE clo_measures.PloNo = plo.nid11 AND clo_measures.year = "2010" AND clo_measures.term = "Spring" GROUP BY sonumber
```

> **Note:** The output is in percentages.

----------

Suggestions
-------------

 - Create authentication for the custom endpoints. Check:
 [WordPress.org - Developer Resources - Authentication](https://developer.wordpress.org/rest-api/using-the-rest-api/authentication/)
 
 - To be continued ...
 
