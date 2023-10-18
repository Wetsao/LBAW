# EBD: Database Specification Component

## A4: Conceptual Data Model

### 1. Class Diagram

        (imagem)

### 2. Additional Business Rules
- GeneralUser is the conceptual name, in order to separate Admins from the rest of the users.


## A5: Relational Schema, validation and schema refinement

### 1. Relational Schema

Relation reference| Relation Compact Notation |
--- | --- |
R01 | user(<ins>id</ins>, name **NN**, email **NN** **UK**, password **NN**)
R02 | admin(<ins>user</ins> -> user)
R03 | project(<ins>id</ins>, details, creation **NN DF** today **CK** creation<=today,delivery **NN CK** delivery>=creation, coordinator -> user)
R04 | project_coordinator(<ins>user</ins> -> user, <ins>project</ins> -> project)
R05 | project_member(<ins>user</ins> -> user, <ins>project</ins> -> project, is_favourite **NN DF** false)
R06 | task(<ins>id</ins>, name **NN**,  creation **NN DF** today **CK** creation<=today,delivery **NN CK** delivery>=creation, status **NN**, project -> project **NN**, creator -> user)
R07 | comment(<ins>id</ins>, content **NN**, creation **NN DF** today **CK** creation<=today, author -> user, project -> project **NN**)
R08 | inviation(<ins>id</ins>, user -> user **NN**, project -> project, accpeted **NN**)
RO9 | notification(<ins>id</ins>, creation **NN DF** today **CK** creation<=today, dismissed **NN**, users->user **NN**, inviation->invitation, comment->comment, task->task, project->project)


NN = NOT NULL 

DF = DEFAAULT 

CK = CHECK

### 2. Domains
Domain Name| Domain Specification |
--- | --- |
today | TIMESTAMP DEFAULT CURRENT_DATE
task_status | ENUM('CREATED','IN PROGRESS','COMPLETE')





