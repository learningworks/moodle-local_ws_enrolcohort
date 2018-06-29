# Moodle Webservices for Cohort Enrolment.

* [What is this plugin and why was it developed?](#what-is-this-plugin-and-why-was-it-developed?)
* [What can this plugin do?](#what-can-this-plugin-do?)
* [What else can this plugin do?](#what-else-can-this-plugin-do?)
* [What can this plugin not do?](#what-can-this-plugin-not-do?)
* [How do I install this plugin?](#how-do-i-install-this-plugin?)
* [What version of Moodle can I install this on?](#what-version-of-moodle-can-i-install-this-on?)
* [How do I use this plugin?](#how-do-i-use-this-plugin?)
* [Examples JSON responses](#example-json-responses)

What is this plugin and why was it developed?
---------------------------------------------

This is a local plugin with webservice functions.

It was developed for <a href="https://www.twoa.ac.nz" target="_blank" alt="Link to Te Wānanga O Aotearoa website" title="Link to Te Wānanga O Aotearoa website">Te Wānanga O Aotearoa</a>
to streamline the enrolment of tauira (student, learner) into courses. Cohorts and courses are created using Moodle webservices but 
adding cohort enrolment instances to courses was a manual process. 

The overall goal is to have this webservice function integrated into Moodle core.


What can this plugin do?
-------------------------

This local plugin enables people to add a cohort enrolment instance to a course using webservices.

What else can this plugin do?
------------------------------

In addition to adding a cohort enrolment instance to a course using webservices, this plugin can also:

* Delete an existing cohort enrolment instance
* Update an existing cohort enrolment instance
    * The name of the cohort enrolment instance
    * The status of the cohort enrolment instance (i.e. active or inactive) 
    * The role that the users of the cohort enrolment instance is synchronised with
    * The group that users of the cohort enrolment instance are added to 
      (i.e. create a new group, an existing group that belongs to the course, none)
* Get a list of all cohort enrolment instances
* Get a list of cohort enrolment instances for a specific course

What can this plugin not do?
----------------------------

This plugin can not do anything that is not listed under [What can this plugin do?](#what-can-this-plugin-do?)
or [What else can this plugin do?](#what-else-can-this-plugin-do?)

How do I install this plugin?
-----------------------------

This plugin can be installed by following the official 
<a href="http://docs.moodle.org/en/Installing_plugins" target="_blank">Moodle documentation</a>. 


What version of Moodle can I install this on?
---------------------------------------------

This plugin has only been developed and tested for Moodle 3.3.

How do I use this plugin?
-------------------------

This plugin can be used in accordance with the official 
<a href="https://docs.moodle.org/en/Using_web_services" target="_blank">Moodle documentation</a>.

Example JSON responses.
-----------------------

This is an example of a JSON response to the webservice function get_instances().

`{
     "id": -1,
     "code": 200,
     "message": "Found 0 cohort enrolment instances in 2 courses (All courses).",
     "data": []
 }`
 
Here are some example JSON responses to the webservice function add_instance().
 
 `{
      "exception": "local_ws_enrolcohort\\exceptions\\cohort_not_found_exception",
      "errorcode": "objectnotfound",
      "message": "Object does not exist!",
      "debuginfo": "Could not find cohort with id 2"
  }`
  
 `{
      "id": 24,
      "code": 201,
      "message": "Cohort enrolment instance added.",
      "data": [
          {
              "object": "course",
              "id": 2,
              "name": "TestCourse1",
              "idnumber": "",
              "shortname": "TestCourse1",
              "visible": 1,
              "format": "topics"
          },
          {
              "object": "cohort",
              "id": 4,
              "name": "Test",
              "idnumber": "1",
              "visible": 1
          },
          {
              "object": "role",
              "id": 1,
              "shortname": "manager"
          },
          {
              "object": "data",
              "name": "",
              "cohortid": 4,
              "roleid": 1,
              "groupid": 0,
              "status": 0
          },
          {
              "object": "group",
              "id": 0,
              "name": "Enrol instance group none.",
              "courseid": -1
          },
          {
              "object": "enrol",
              "id": 24,
              "name": "Cohort sync (Test - Manager) - Using system generated name.",
              "courseid": 2,
              "cohortid": 4,
              "roleid": 1,
              "groupid": 0,
              "status": 0
          }
      ]
  }`