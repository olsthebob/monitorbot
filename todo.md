## TO DO

> remove "staging url" from sites. It isn't required.

- integrate new layouts into templates

- pull new fields into tests and sites accordingly

>> Wireframe new layout for sites and tests.
>> Wireframe forms for new tests

- Wire Tests into PerformTests job.

- Creation of Alerts when tests fail. How are these handled?

- Notifications in database? required?
- Laravel cashier on Organisations




## Potential Problems
We had a problem where the app key was forgotten, thus all encrypted data on the site was lost. 
Do we need to start recording keys so that we can reliably decrypt data? Should we not trust .env?