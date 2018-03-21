# graylog-contentpack-moodle
Graylog content pack for ingesting Moodle logs and using it with lookup tables &amp; pipelines for statistical usage

1) First put this great plugin in your moodle:
https://moodle.org/plugins/logstore_graylog

2) Find a webserver with php and drop the lookup-scripts folder in it

3) Configure in the conf folder the parameters for LDAP & Moodle BDD

4) Access the moodle-user.php with the URL 

5) Validate that data folder is populated with 3 JSON files: ldapuserdata.json, moodleuserdata.json & globaluserdata.json

6) Create the lookup tables and pipelines in Graylog

7) Enjoy !

NOTE: 
  - The moodle-user.php lookup an user based on its moodle user ID
  - The ldap-user.php lookup an user based on its ldap user ID
