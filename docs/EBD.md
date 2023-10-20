# EBD: Database Specification Component

Software tool for tracking and managing projects. This application is designed to help users plan, coordinate, and execute tasks that need to be completed to make progress on the project at hand.

## A4: Conceptual Data Model

This artifact presents the Conceptual Data Model using a UML class diagram to document the model. It contains the identification and description of the entities and relationships that are relevant to the database specification.

### 1. Class Diagram

        (imagem)

### 2. Additional Business Rules
- GeneralUser is the conceptual name, in order to separate Admins from the rest of the users.


## A5: Relational Schema, validation and schema refinement

This artifact contains the Relational Schema made by mapping the Conceptual Data Model and represents the relation schema, attributes, domains, primary keys, foreign keys and other integrity rules that will be included in the database.

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

### 3. Schema validation

## A6: Indexes, triggers, transactions and database population

This artifact contains the physical schema of the database, the identification and characterisation of the indexes, the support of data integrity rules with triggers and the definition of the database user-defined functions.

Furthermore, it also shows the database transactions needed to assure the integrity of the data in the presence of concurrent accesses. For each transaction, the isolation level is explicitly stated and justified.

This artifact also contains the database's workload as well as the complete database creation script, including all SQL necessary to define all integrity constraints, indexes and triggers. Finally, this artifact also includes a separate script with INSERT statements to populate the database.

### 1. Database Workload

### 2. Proposed Indices

#### 2.1. Performance Indices

#### 2.2. Full-text Search Indices

### 3. Triggers

### 4. Transactions

## Annex A. SQL Code

### A.1. Database Schema

### A.2. Database Population

## Revision history

---

GROUP23156, DD/10/2023

- Alexandre Morais up201906049
- Nuno Ramos up201906051
- Bruno Leal up202008047
- Vitor Bizarro up202007888





