# Moodle Webservices for Cohort Enrolment CHANGELOG.

Version history:

v3.3.2 (20180600)

* Added additional check in php unit test delete instance to ensure that the cohort enrolment instance was removed.
* Implemented privacy API.

v3.3.3 (2019042900) for Moodle 3.3, 3.4, 3.5, and 3.6. Released Monday, 29 April 2019

* Fixed issue that was preventing a cohort enrolment instance being added to a course.
    * This was happening for sites that had more than 25 cohorts available at a context. This limit is a default value when calling cohort_get_available_cohorts().
    * Thanks to Thomas (thoschi) for this fix.
* Updated unit tests to create 100 cohorts before calling the webservice add_instance() function.
* Tagged this release.