# EBD: Database Specification Component

Software tool for tracking and managing projects. This application is designed to help users plan, coordinate, and execute tasks that need to be completed to make progress on the project at hand.

## A4: Conceptual Data Model

This artifact presents the Conceptual Data Model using a UML class diagram to document the model. It contains the identification and description of the entities and relationships that are relevant to the database specification.

### 1. Class Diagram


<p align="center" justify="center">
  <img src="images/ebd.drawio.png"/>
</p>
<p align="center">
  <b><i>Fig1. Conceptual Data Model in UML</i></b>
</p>
<br>
<br />

### 2. Additional Business Rules
- GeneralUser is the conceptual name, in order to separate Admins from the rest of the users.

## A5: Relational Schema, validation and schema refinement

This artifact contains the Relational Schema made by mapping the Conceptual Data Model and represents the relation schema, attributes, domains, primary keys, foreign keys and other integrity rules that will be included in the database.

### 1. Relational Schema
Relation reference| Relation Compact Notation |
--- | --- |
R01 | users(<ins>id</ins>, name **NN**, email **NN** **UK** **CK** valid_email_format, password **NN**)
R02 | admins(<ins>id</ins>, name **NN**, password **NN**)
R03 | company(<ins>id</ins>, name **NN**)
R04 | project(<ins>id</ins>, company_id -> company, name **NN**, details, creation **NN DF** today **CK** creation<=today,delivery **NN CK** delivery>=creation)
R05 | project_member(<ins>users_id</ins> -> users, <ins>project_id</ins> -> project, is_favourite **NN DF** false)
R06 | project_coordinator(<ins>id</ins>, users_id -> users, project_id -> project)
R07 | task(<ins>id</ins>, project_id -> project, creator -> users, name **NN**, details, status **NN**, creation **NN DF** today **CK** creation<=today, delivery **NN CK** delivery>=creation)
R08 | task_assigned(<ins>users_id</ins> -> users, <ins>task_id</ins> -> task)
R09 | comment(<ins>id</ins>, task_id -> task, author -> users, content **NN**, creation **NN DF** today **CK** creation<=today)
R10 | invitation(<ins>project_id</ins> -> project, <ins>users_id</ins> -> users, <ins>project_coordinator_id</ins> -> project_coordinator)
R11 | notification()

Legend:

 - UK = UNIQUE KEY

 - NN = NOT NULL 

 - DF = DEFAULT 

 - CK = CHECK

### 2. Domains
Domain Name| Domain Specification |
--- | --- |
today | TIMESTAMP DEFAULT CURRENT_DATE
status | ENUM('Completed', 'Ongoing', 'Paused', 'Abandoned')

### 3. Schema validation
Table R01| users |
--- | --- |
**Keys:** {id},{email} 
**Functional Dependencies**
FD0101 | {id} -> {name, email, password}
FD0102 | {email} -> {id, name, password}
**Normal Form** | BCNF

Table R02| admins |
--- | --- |
**Keys:** {id}
**Functional Dependencies**
FD0201 | {id} -> {name, password}
**Normal Form** | BCNF

Table R03| company |
--- | --- |
**Keys:** {id}
**Functional Dependencies**
FD0301 | {id} -> {name}
**Normal Form** | BCNF

Table R04| project |
--- | --- |
**Keys:** {id}
**Functional Dependencies**
FD0401 | {id} -> {company_id, name, details, creation, delivery}
**Normal Form** | BCNF

Table R05| project_member |
--- | --- |
**Keys:** {users_id, project_id}
**Functional Dependencies**
FD0501 | {users_id, project_id} -> {is_favourite}
**Normal Form** | BCNF

Table R06| project_coordinator |
--- | --- |
**Keys:** {id}
**Functional Dependencies**
FD0601 | {id} -> {users_id, project_id}
**Normal Form** | BCNF

Table R07| task |
--- | --- |
**Keys:** {id}
**Functional Dependencies**
FD0701 | {id} -> {project_id, creator, name, details, status, creation, delivery}
**Normal Form** | BCNF

Table R08| task_assigned |
--- | --- |
**Keys:** {users_id, task_id}
**Functional Dependencies** | none
**Normal Form** | BCNF

Table R09| comment |
--- | --- |
**Keys:** {id}
**Functional Dependencies**
FD0901 | {id} -> {task_id, author, content, creation}
**Normal Form** | BCNF

Table R010| invitation |
--- | --- |
**Keys:** {project_id, users_id, project_coordinator_id}
**Functional Dependencies** | none
**Normal Form** | BCNF

Table R011| notification |
--- | --- |
**Keys:** {}
**Functional Dependencies**
FD1101 | 
**Normal Form** | BCNF

Because all relations are in the Boyce–Codd Normal Form (BCNF), the relational schema is also in the BCNF and, therefore, the schema does not need to be further normalized.

## A6: Indexes, triggers, transactions and database population

This artifact contains the physical schema of the database, the identification and characterisation of the indexes, the support of data integrity rules with triggers and the definition of the database user-defined functions.

Furthermore, it also shows the database transactions needed to assure the integrity of the data in the presence of concurrent accesses. For each transaction, the isolation level is explicitly stated and justified.

This artifact also contains the database's workload as well as the complete database creation script, including all SQL necessary to define all integrity constraints, indexes and triggers. Finally, this artifact also includes a separate script with INSERT statements to populate the database.

### 1. Database Workload

Relation | Relation name       | Order of magnitude            | Estimated growth
---      | ---                 | ---                           | --- 
R01      | users               | 10 k (tens of thousands)      | 10 (tens) / day          
R02      | admins              | 10 (tens)                     | 1 (one) / year
R03      | company             | 100 (hundreds)                | 1 / week
R04      | project             | 1 k (thousands)               | 1 / day
R05      | project_member      | 10 k                          | 10 / day
R06      | project_coordinator | 1 k                           | 1 / day
R07      | task                | 100 k (hundreds of thousands) | 100 (hundred) / day
R08      | task_assigned       | 100 k                         | 100 / day
R09      | comment             | 1 M (million)                 | 1 k (thousands) / day
R10      | invitation          | 10 k                          | 10 / day
R11      | notification        | 1 M                           | 1 k / day

### 2. Proposed Indices

#### 2.1. Performance Indices

Index | IDX01
---   | ---
**Index relation** |
**Index attribute** |
**Index type** |
**Cardinality** |
**Clustering** |
**Justification** |
**SQLCode** |escrever SQL

Index | IDX02
---   | ---
**Index relation** |
**Index attribute** |
**Index type** |
**Cardinality** |
**Clustering** |
**Justification** |
**SQLCode** |escrever SQL

Index | IDX03
---   | ---
**Index relation** |
**Index attribute** |
**Index type** |
**Cardinality** |
**Clustering** |
**Justification** |
**SQLCode** |escrever SQL
  

#### 2.2. Full-text Search Indices

### 3. Triggers

### 4. Transactions

## Annex A. SQL Code

### A.1. Database Schema

```sql
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS company;
DROP TABLE IF EXISTS project CASCADE;
DROP TABLE IF EXISTS project_member;
DROP TABLE IF EXISTS project_coordinator;
DROP TABLE IF EXISTS task CASCADE;
DROP TABLE IF EXISTS task_assigned;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS invitation;

DROP TYPE IF EXISTS status;


CREATE TYPE status AS ENUM ('Completed', 'Ongoing', 'Paused', 'Abandoned');

CREATE TABLE users(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    CONSTRAINT valid_email_format CHECK (email ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
);

CREATE TABLE admins(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL, 
    password TEXT NOT NULL
);

CREATE TABLE company(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE project (
    id SERIAL PRIMARY KEY,
    company_id REFERENCES company(id) ON DELETE CASCADE,
    name TEXT NOT NULL,
    details TEXT,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now(),
    delivery TIMESTAMP WITH TIME ZONE CHECK (delivery >= creation)
);

CREATE TABLE project_member(
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    is_favorite BOOLEAN DEFAULT FALSE;
    PRIMARY KEY(project_id, users_id)
);

CREATE TABLE project_coordinator(
    id SERIAL PRIMARY KEY,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE task(
    id SERIAL PRIMARY KEY,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    creator INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    name TEXT NOT NULL,
    details TEXT,
    TYPE status NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now(),
    delivery TIMESTAMP WITH TIME ZONE CHECK (delivery >= creation)
);


CREATE TABLE task_assigned(
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task_id INTEGER NOT NULL REFERENCES task(id) ON DELETE CASCADE,
    PRIMARY KEY(users_id, task_id)
);

CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    author INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task_id INTEGER NOT NULL REFERENCES task(id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now()
);


CREATE TABLE invitation(
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_coordinator_id INTEGER NOT NULL REFERENCES project_coordinator(id) ON DELETE CASCADE,
    PRIMARY KEY(project_id, users_id, project_coordinator_id)
);
```

### A.2. Database Population

## Revision history

---

GROUP23156, DD/10/2023

- Alexandre Morais up201906049
- Nuno Ramos up201906051
- Bruno Leal up202008047
- Vitor Bizarro up202007888





