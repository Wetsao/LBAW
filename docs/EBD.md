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
- BR01. GeneralUser is the conceptual name, in order to separate Admins from the rest of the users.

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
R11 | notifications(<ins>id</ins>, creation **NN DF** today **CK** creation<=today, dismissed **NN**, users->user **NN**, inviation->invitation, comment->comment, task->task, project->project, notification_type **NN**)

Legend:

 - UK = UNIQUE KEY

 - NN = NOT NULL 

 - DF = DEFAULT 

 - CK = CHECK

### 2. Domains
Domain Name| Domain Specification |
--- | --- |
today | TIMESTAMP DEFAULT CURRENT_DATE
status | ENUM('Completed', 'Ongoing', 'Paused', 'Abandoned', 'Late')
notification_type | ENUM('project_notification','invitation_notification','task_notification','comment_notification')

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

Table R11| notification |
--- | --- |
**Keys** | {id}
**Functional Dependencies:**
FD1101 | {id} -> {creation, dismissed, users, inviation, comment, task, project, notification_type}
**NORMAL FORM** | BCNF

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

Index               | IDX01
---                 | ---
**Index relation**  | task_assigned
**Index attribute** | users_id
**Index type**      | B-tree
**Cardinality**     | Medium
**Clustering**      | No
**Justification**   | Every time the user needs to see tasks assigned to him, a querry will be issued. This table will be frequently updated so clustering is not efficient. Also there will be multiple rows with the same 'users_id' value, so hash was also not efficient.
```sql
CREATE INDEX task_assigned_idx ON task_assigned USING btree (users_id);
``` 

Index               | IDX02
---                 | ---
**Index relation**  | users
**Index attribute** | email
**Index type**      | hash
**Cardinality**     | Medium
**Clustering**      | No
**Justification**   | In authentication we will filter 'users' 'email' frequently so an index here will greatly increse efficiency. Email is an exact match so hash is the best option.

```sql
CREATE INDEX idx_users_email ON users USING hash (email);
```

Index               | IDX03
---                 | ---
**Index relation**  | task
**Index attribute** | project_id
**Index type**      | B-tree
**Cardinality**     | Medium
**Clustering**      | No
**Justification**   | Table 'task' will be frequently accessed for showing tasks in a certain project. A b-tree index allows for faster date range queries based on the 'project_id'.
```sql
CREATE INDEX idx_task_project_id ON task USING btree (project_id);
```
  
#### 2.2. Full-text Search Indices

Index                | IDX11
---                  | ---
**Index relation**   |
**Index attributes** |
**Index type**       |
**Clustering**       |
**Justification**    |
**SQL Code**         |
```sql
```

### 3. Triggers

Trigger         | TRIGGER01
---             | ---
**Description** | 
**SQL Code**    |
```sql
```

### 4. Transactions

Transaction         | TRAN01
---                 | ---
**Description**     |
**Justification**   |
**Isolation Level** |
**SQL Code**        |
```sql
```

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

```sql
-- Populate ProjeTatu database

-- Insert data into the "company" table, 30 rows
INSERT INTO company (name) VALUES
    ('Tech Solutions Inc.'),
    ('Creative Innovations Ltd.'),
    ('Global Services Co.'),
    ('InnovateTech Corporation'),
    ('Swift Solutions Group'),
    ('TechHive Enterprises'),
    ('Dynamic Software Solutions'),
    ('WebTech Innovations'),
    ('Innovative Designs Inc.'),
    ('eCommerce Experts Ltd.'),
    ('Data Science Solutions'),
    ('WebCrafters Inc.'),
    ('Digital Dynamics Ltd.'),
    ('Future Vision Technologies'),
    ('CodeGenius Inc.'),
    ('Infotech Solutions'),
    ('Software Wizards Ltd.'),
    ('DataMasters Inc.'),
    ('WebMasters Group'),
    ('Innovative Web Solutions'),
    ('MobileTech Innovations'),
    ('Visionary Software Solutions'),
    ('TechArt Creations Ltd.'),
    ('TechFusion Corporation'),
    ('WebSphere Technologies'),
    ('DataCrafters Inc.'),
    ('CloudTech Innovations'),
    ('eCommerce Elegance Ltd.'),
    ('CyberSolutions Inc.'),
    ('InfoTech Innovators');

-- Insert data into the "users" table, 120 rows
INSERT INTO users (name, email, password) VALUES
    ('John Doe', 'john.doe@example.com', 'password123'),
    ('Jane Smith', 'jane.smith@example.com', 'pass456word'),
    ('Michael Johnson', 'michael.j@example.com', 'securepass123'),
    ('Emily Brown', 'emily.brown@example.com', 'strongpass789'),
    ('William Davis', 'william.d@example.com', 'userpass456'),
    ('Sophia Wilson', 'sophia.w@example.com', 'pass1234'),
    ('James Anderson', 'james.a@example.com', 'mypassword'),
    ('Olivia Harris', 'olivia.h@example.com', 'securepass789'),
    ('Liam Thomas', 'liam.t@example.com', 'liampass123'),
    ('Emma Lee', 'emma.l@example.com', 'emma1234'),
    ('Noah White', 'noah.w@example.com', 'noahpass456'),
    ('Ava Martinez', 'ava.m@example.com', 'avapass789'),
    ('Logan Garcia', 'logan.g@example.com', 'loganpass123'),
    ('Isabella Rodriguez', 'isabella.r@example.com', 'isabellapass'),
    ('Mason Taylor', 'mason.t@example.com', 'mason1234'),
    ('Oliver Lewis', 'oliver.l@example.com', 'oliverpass456'),
    ('Sophia Smith', 'sophia.s@example.com', 'sophiapass789'),
    ('Ethan Johnson', 'ethan.j@example.com', 'ethan1234'),
    ('Amelia Davis', 'amelia.d@example.com', 'ameliapass456'),
    ('Liam Wilson', 'liam.w@example.com', 'liampass789'),
    ('Olivia Taylor', 'olivia.t@example.com', 'olivia1234'),
    ('Jackson Brown', 'jackson.b@example.com', 'jacksonpass456'),
    ('Ava Jones', 'ava.j@example.com', 'avapass789'),
    ('Lucas Clark', 'lucas.c@example.com', 'lucas1234'),
    ('Ava Anderson', 'ava.a@example.com', 'avapass456'),
    ('Sophia Moore', 'sophia.m@example.com', 'sophiapass789'),
    ('Liam Thomas', 'liam.t@example.com', 'liampass123'),
    ('Emma Lee', 'emma.l@example.com', 'emma1234'),
    ('Noah White', 'noah.w@example.com', 'noahpass456'),
    ('Ava Martinez', 'ava.m@example.com', 'avapass789'),
    ('Logan Garcia', 'logan.g@example.com', 'loganpass123'),
    ('Isabella Rodriguez', 'isabella.r@example.com', 'isabellapass'),
    ('Mason Taylor', 'mason.t@example.com', 'mason1234'),
    ('Oliver Lewis', 'oliver.l@example.com', 'oliverpass456'),
    ('Sophia Smith', 'sophia.s@example.com', 'sophiapass789'),
    ('Ethan Johnson', 'ethan.j@example.com', 'ethan1234'),
    ('Amelia Davis', 'amelia.d@example.com', 'ameliapass456'),
    ('Liam Wilson', 'liam.w@example.com', 'liampass789'),
    ('Olivia Taylor', 'olivia.t@example.com', 'olivia1234'),
    ('Jackson Brown', 'jackson.b@example.com', 'jacksonpass456'),
    ('Ava Jones', 'ava.j@example.com', 'avapass789'),
    ('Lucas Clark', 'lucas.c@example.com', 'lucas1234'),
    ('Ava Anderson', 'ava.a@example.com', 'avapass456'),
    ('Sophia Moore', 'sophia.m@example.com', 'sophiapass789'),
    ('Ethan Martinez', 'ethan.m@example.com', 'ethan1234'),
    ('Olivia Davis', 'olivia.d@example.com', 'oliviapass456'),
    ('Logan Harris', 'logan.h@example.com', 'loganpass789'),
    ('Ava Lewis', 'ava.l@example.com', 'ava1234'),
    ('William Garcia', 'william.g@example.com', 'williampass456'),
    ('Mia Thomas', 'mia.t@example.com', 'miapass789'),
    ('Elijah Wilson', 'elijah.w@example.com', 'elijahpass123'),
    ('Sophia Smith', 'sophia.s@example.com', 'sophiapass456'),
    ('James Davis', 'james.d@example.com', 'jamespass789'),
    ('Amelia Lee', 'amelia.l@example.com', 'amelia1234'),
    ('Ethan Moore', 'ethan.m@example.com', 'ethanpass456'),
    ('Olivia Thomas', 'olivia.t@example.com', 'oliviapass789'),
    ('Ava Harris', 'ava.h@example.com', 'avapass123'),
    ('Jackson White', 'jackson.w@example.com', 'jackson1234'),
    ('Oliver Brown', 'oliver.b@example.com', 'oliverpass456'),
    ('Mia Taylor', 'mia.t@example.com', 'miapass789'),
    ('Sophia Lewis', 'sophia.l@example.com', 'sophiapass123'),
    ('William Garcia', 'william.g@example.com', 'williampass456'),
    ('Ava Thomas', 'ava.t@example.com', 'avapass789'),
    ('Liam Harris', 'liam.h@example.com', 'liampass123'),
    ('Olivia Wilson', 'olivia.w@example.com', 'oliviapass456'),
    ('Noah Smith', 'noah.s@example.com', 'noahpass789'),
    ('Elijah Moore', 'elijah.m@example.com', 'elijah1234'),
    ('Mia Anderson', 'mia.a@example.com', 'miapass456'),
    ('Oliver Davis', 'oliver.d@example.com', 'oliverpass789'),
    ('Sophia Taylor', 'sophia.t@example.com', 'sophiapass123'),
    ('Ethan Lewis', 'ethan.l@example.com', 'ethanpass456'),
    ('William Harris', 'william.h@example.com', 'williampass789'),
    ('Ava White', 'ava.w@example.com', 'avapass123'),
    ('Logan Smith', 'logan.s@example.com', 'logan1234'),
    ('Amelia Wilson', 'amelia.w@example.com', 'ameliapass456'),
    ('Olivia Moore', 'olivia.m@example.com', 'oliviapass789'),
    ('Jackson Davis', 'jackson.d@example.com', 'jacksonpass123'),
    ('Sophia Anderson', 'sophia.a@example.com', 'sophiapass456'),
    ('Liam Thomas', 'liam.t@example.com', 'liampass789'),
    ('William Garcia', 'william.g@example.com', 'williampass123'),
    ('Emma Brown', 'emma.b@example.com', 'emma1234'),
    ('Oliver Clark', 'oliver.c@example.com', 'oliverpass456'),
    ('Sophia Taylor', 'sophia.t@example.com', 'sophiapass789'),
    ('Ethan Lewis', 'ethan.l@example.com', 'ethan1234'),
    ('Mia Harris', 'mia.h@example.com', 'miapass456'),
    ('Olivia Anderson', 'olivia.a@example.com', 'oliviapass789'),
    ('Ava Smith', 'ava.s@example.com', 'avapass123'),
    ('Jackson Davis', 'jackson.d@example.com', 'jackson1234'),
    ('Liam Wilson', 'liam.w@example.com', 'liampass456'),
    ('Sophia Moore', 'sophia.m@example.com', 'sophiapass789'),
    ('Ethan Martinez', 'ethan.m@example.com', 'ethan1234'),
    ('Olivia Davis', 'olivia.d@example.com', 'oliviapass456'),
    ('Logan Harris', 'logan.h@example.com', 'loganpass789'),
    ('Ava Lewis', 'ava.l@example.com', 'ava1234'),
    ('William Garcia', 'william.g@example.com', 'williampass456'),
    ('Mia Thomas', 'mia.t@example.com', 'miapass789'),
    ('Elijah Wilson', 'elijah.w@example.com', 'elijahpass123'),
    ('Sophia Smith', 'sophia.s@example.com', 'sophiapass456'),
    ('James Davis', 'james.d@example.com', 'jamespass789'),
    ('Amelia Lee', 'amelia.l@example.com', 'amelia1234'),
    ('Ethan Moore', 'ethan.m@example.com', 'ethanpass456'),
    ('Olivia Thomas', 'olivia.t@example.com', 'oliviapass789'),
    ('Ava Harris', 'ava.h@example.com', 'avapass123'),
    ('Jackson White', 'jackson.w@example.com', 'jackson1234'),
    ('Oliver Brown', 'oliver.b@example.com', 'oliverpass456'),
    ('Mia Taylor', 'mia.t@example.com', 'miapass789'),
    ('Sophia Lewis', 'sophia.l@example.com', 'sophiapass123'),
    ('William Garcia', 'william.g@example.com', 'williampass456'),
    ('Ava Thomas', 'ava.t@example.com', 'avapass789'),
    ('Liam Harris', 'liam.h@example.com', 'liampass123'),
    ('Olivia Wilson', 'olivia.w@example.com', 'oliviapass456'),
    ('Noah Smith', 'noah.s@example.com', 'noahpass789'),
    ('Elijah Moore', 'elijah.m@example.com', 'elijah1234'),
    ('Mia Anderson', 'mia.a@example.com', 'miapass456'),
    ('Oliver Davis', 'oliver.d@example.com', 'oliverpass789'),
    ('Sophia Taylor', 'sophia.t@example.com', 'sophiapass123'),
    ('Ethan Lewis', 'ethan.l@example.com', 'ethanpass456'),
    ('William Harris', 'william.h@example.com', 'williampass789'),
    ('Ava White', 'ava.w@example.com', 'avapass123'),
    ('Logan Smith', 'logan.s@example.com', 'logan1234'),
    ('Amelia Wilson', 'amelia.w@example.com', 'ameliapass456'),
    ('Olivia Moore', 'olivia.m@example.com', 'oliviapass789');

-- Insert data into the "project" table, 30 rows
INSERT INTO project (company_id, name, details, delivery) VALUES
    (1, 'Project Audit', 'Conduct a comprehensive audit of the company finances.', NOW() + INTERVAL '90 days'),
    (2, 'Website Redesign', 'Redesign the company website for a more modern look.', NOW() + INTERVAL '60 days'),
    (3, 'Product Launch', 'Plan and execute the launch of a new product in the market.', NOW() + INTERVAL '120 days'),
    (4, 'Marketing Campaign', 'Create and launch a new marketing campaign to boost sales.', NOW() + INTERVAL '75 days'),
    (5, 'Inventory Management System', 'Develop an inventory management system for the warehouse.', NOW() + INTERVAL '100 days'),
    (6, 'Customer Support Portal', 'Build a customer support portal for better customer service.', NOW() + INTERVAL '90 days'),
    (7, 'New Mobile App', 'Develop a new mobile application for iOS and Android.', NOW() + INTERVAL '150 days'),
    (8, 'Financial Analysis', 'Analyze financial data and provide insights for decision-making.', NOW() + INTERVAL '60 days'),
    (9, 'Supply Chain Optimization', 'Optimize the supply chain for cost reduction and efficiency.', NOW() + INTERVAL '120 days'),
    (10, 'Social Media Strategy', 'Create and implement a new social media strategy for engagement.', NOW() + INTERVAL '45 days'),
    (11, 'Content Marketing', 'Develop and publish content for content marketing campaigns.', NOW() + INTERVAL '90 days'),
    (12, 'Quality Assurance Testing', 'Conduct comprehensive QA testing on the product.', NOW() + INTERVAL '75 days'),
    (13, 'Employee Training Program', 'Design a training program for employee development.', NOW() + INTERVAL '60 days'),
    (14, 'Market Research', 'Conduct market research to identify growth opportunities.', NOW() + INTERVAL '120 days'),
    (15, 'IT Infrastructure Upgrade', 'Upgrade and enhance the company IT infrastructure.', NOW() + INTERVAL '100 days'),
    (16, 'New Product Design', 'Design a new product based on market demand and trends.', NOW() + INTERVAL '150 days'),
    (17, 'Sales Strategy', 'Develop and implement a new sales strategy for the sales team.', NOW() + INTERVAL '90 days'),
    (18, 'Customer Feedback Survey', 'Create and analyze customer feedback surveys for insights.', NOW() + INTERVAL '75 days'),
    (19, 'Environmental Sustainability Initiative', 'Initiate sustainability programs and reduce environmental impact.', NOW() + INTERVAL '120 days'),
    (20, 'Human Resources Management System', 'Implement an HR management system for better HR operations.', NOW() + INTERVAL '60 days'),
    (21, 'Product Testing and Validation', 'Conduct product testing and validation for quality assurance.', NOW() + INTERVAL '100 days'),
    (22, 'Public Relations Campaign', 'Launch a PR campaign to improve brand reputation.', NOW() + INTERVAL '45 days'),
    (23, 'Customer Loyalty Program', 'Develop a customer loyalty program to retain customers.', NOW() + INTERVAL '90 days'),
    (24, 'Market Expansion Strategy', 'Plan and execute a strategy for expanding into new markets.', NOW() + INTERVAL '75 days'),
    (25, 'Security Enhancement', 'Enhance security measures to protect company data and assets.', NOW() + INTERVAL '60 days'),
    (26, 'Corporate Social Responsibility', 'Initiate CSR programs for social and community impact.', NOW() + INTERVAL '150 days'),
    (27, 'Financial Forecasting', 'Create financial forecasts for better financial planning.', NOW() + INTERVAL '90 days'),
    (28, 'Product Packaging Redesign', 'Redesign product packaging for improved market appeal.', NOW() + INTERVAL '100 days'),
    (29, 'Digital Marketing Campaign', 'Launch a digital marketing campaign to increase online presence.', NOW() + INTERVAL '120 days'),
    (30, 'Innovation and Research', 'Invest in research and innovation for product improvement.', NOW() + INTERVAL '45 days');

-- Insert data into the "task" table, 100 rows
INSERT INTO task (project_id, creator, name, details, status, delivery) VALUES
    (1, 1, 'Financial Report Analysis', 'Analyze the companys financial reports and prepare an audit.', 'Ongoing', NOW() + INTERVAL '30 days'),
    (1, 2, 'Revenue Data Review', 'Review and validate revenue data for the audit.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (2, 3, 'Website Redesign Mockups', 'Create mockups for the redesigned website.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (2, 4, 'Content Update Planning', 'Plan the content updates for the new website.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (3, 5, 'Product Launch Strategy', 'Develop a strategy for the product launch.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (3, 6, 'Marketing Materials Creation', 'Create marketing materials for the new product.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (4, 7, 'Market Analysis', 'Analyze the market for the upcoming marketing campaign.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (4, 8, 'Campaign Content Creation', 'Create content for the marketing campaign.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (5, 9, 'Inventory System Development', 'Develop the inventory management system.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (5, 10, 'System Testing', 'Test the inventory management system for accuracy and functionality.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (6, 11, 'Customer Support Portal Design', 'Design the user interface for the customer support portal.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (6, 12, 'Development and Testing', 'Develop and test the customer support portal.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (7, 13, 'Mobile App Wireframing', 'Create wireframes for the new mobile application.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (7, 14, 'App Development', 'Develop the mobile application for iOS and Android.', 'Ongoing', NOW() + INTERVAL '150 days'),
    (8, 15, 'Financial Data Collection', 'Collect financial data for analysis.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (8, 16, 'Data Analysis', 'Analyze the financial data for insights.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (9, 17, 'Supply Chain Evaluation', 'Evaluate the current supply chain process.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (9, 18, 'Optimization Recommendations', 'Provide recommendations for supply chain optimization.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (10, 19, 'Social Media Audit', 'Conduct an audit of the companys social media presence.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (10, 20, 'Strategy Development', 'Develop a new social media engagement strategy.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (11, 21, 'Content Creation Plan', 'Plan content creation for upcoming marketing campaigns.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (11, 22, 'Content Production', 'Produce content for marketing purposes.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (12, 23, 'QA Testing', 'Conduct quality assurance testing on the product.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (12, 24, 'Bug Fixes and Improvements', 'Address bugs and make necessary improvements.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (13, 25, 'Employee Training Material Design', 'Design training materials for employee development.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (13, 26, 'Training Sessions Conduct', 'Conduct training sessions for employees.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (14, 27, 'Market Research Survey', 'Design and conduct a survey for market research.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (14, 28, 'Data Analysis and Insights', 'Analyze survey data and provide market insights.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (15, 29, 'IT Infrastructure Assessment', 'Assess the current IT infrastructure for upgrades.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (15, 30, 'Infrastructure Upgrade', 'Upgrade IT infrastructure for better performance.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (16, 31, 'Product Redesign Planning', 'Plan the redesign of the companys flagship product.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (16, 32, 'Design and Prototyping', 'Design product prototypes for the redesign.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (17, 33, 'Sales Strategy Development', 'Develop a new sales strategy for the sales team.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (17, 34, 'Implementation and Training', 'Implement the strategy and train the sales team.', 'Ongoing', NOW() + INTERVAL '150 days'),
    (18, 35, 'Customer Feedback Survey Design', 'Design a customer feedback survey for customers.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (18, 36, 'Survey Analysis and Recommendations', 'Analyze survey results and provide recommendations.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (19, 37, 'Sustainability Programs Planning', 'Plan environmental sustainability programs.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (19, 38, 'Implementation and Monitoring', 'Implement sustainability programs and monitor progress.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (20, 39, 'HR Management System Design', 'Design a new HR management system for the company.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (20, 40, 'Development and Testing', 'Develop and test the HR management system.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (21, 41, 'Product Testing Plan', 'Plan the comprehensive testing of the product.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (21, 42, 'Testing and Validation', 'Conduct product testing and validation procedures.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (22, 43, 'Public Relations Strategy', 'Develop a PR strategy for improving brand reputation.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (22, 44, 'PR Campaign Execution', 'Execute the PR campaign for brand improvement.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (23, 45, 'Customer Loyalty Program Design', 'Design a customer loyalty program for customer retention.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (23, 46, 'Program Launch and Monitoring', 'Launch the customer loyalty program and monitor its performance.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (24, 47, 'Market Expansion Planning', 'Plan the strategy for expanding into new markets.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (24, 48, 'Execution and Market Entry', 'Execute the market expansion strategy and enter new markets.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (25, 49, 'Security Assessment', 'Assess the companys security measures and identify vulnerabilities.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (25, 50, 'Security Enhancement Plan', 'Develop a plan to enhance the companys security measures.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (26, 51, 'CSR Program Development', 'Develop corporate social responsibility programs for community impact.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (26, 52, 'CSR Initiatives Implementation', 'Implement CSR initiatives for social and environmental impact.', 'Ongoing', NOW() + INTERVAL '45 days'),
    (27, 53, 'Financial Forecasting Modeling', 'Create financial models for accurate forecasting.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (27, 54, 'Forecasting Data Analysis', 'Analyze financial data and provide forecasts.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (28, 55, 'Product Packaging Redesign Concept', 'Design new concepts for product packaging.', 'Ongoing', NOW() + INTERVAL '90 days'),
    (28, 56, 'Prototyping and Testing', 'Create prototypes and test new product packaging designs.', 'Ongoing', NOW() + INTERVAL '60 days'),
    (29, 57, 'Digital Marketing Campaign Planning', 'Plan a digital marketing campaign for online presence.', 'Ongoing', NOW() + INTERVAL '120 days'),
    (29, 58, 'Campaign Execution and Monitoring', 'Execute the digital marketing campaign and monitor results.', 'Ongoing', NOW() + INTERVAL '75 days'),
    (30, 59, 'Innovation and Research Strategy', 'Develop a strategy for research and innovation.', 'Ongoing', NOW() + INTERVAL '100 days'),
    (30, 60, 'Research and Development', 'Conduct research and development activities for innovation.', 'Ongoing', NOW() + INTERVAL '45 days');

-- Insert data into the "comment" table, 60 rows
INSERT INTO comment (task_id, content) VALUES
    (1, 'This task needs to be done by someone else'),
    (1, 'I can take care of this task if needed.'),
    (1, 'Lets assign this to John for now.'),
    (2, 'This is another comment on Task 2 for Project A'),
    (2, 'The progress on Task 2 is going well.'),
    (2, 'We should schedule a meeting to discuss Task 2.'),
    (3, 'Task 3 is critical for the audit. Please prioritize it.'),
    (3, 'Ill make sure Task 3 is completed on time.'),
    (3, 'Task 3 is in progress and should be done soon.'),
    (4, 'Task 4 requires input from the design team.'),
    (4, 'The design team has been informed about Task 4.'),
    (4, 'Please review the mockups for Task 4.'),
    (5, 'I need assistance with Task 5. Can someone help?'),
    (5, 'Task 5 is a bit complex. Lets collaborate on it.'),
    (5, 'Task 5 has been assigned to the development team.'),
    (6, 'The customer support portal is almost ready.'),
    (6, 'We should test the customer support portal soon.'),
    (6, 'Please confirm the delivery date for the portal.'),
    (7, 'Mobile app development is progressing as planned.'),
    (7, 'Im working on the iOS version of the mobile app.'),
    (7, 'Android app development is also on track.'),
    (8, 'Financial data for Task 8 is available in the report.'),
    (8, 'We need to review the financial data for Task 8.'),
    (8, 'Please provide the financial report for analysis.'),
    (9, 'Task 9 is part of the supply chain optimization project.'),
    (9, 'Supply chain optimization is a critical task.'),
    (9, 'Task 9 is linked to cost reduction efforts.'),
    (10, 'Our social media audit is complete for Task 10.'),
    (10, 'We are ready to implement the new social media strategy.'),
    (10, 'Task 10 is essential for our online presence.'),
    (11, 'Content marketing materials for Task 11 are ready.'),
    (11, 'Task 11 content is engaging and ready for publishing.'),
    (11, 'Lets schedule content publication for Task 11.'),
    (12, 'QA testing for Task 12 is in progress.'),
    (12, 'Weve identified some issues in the QA testing of Task 12.'),
    (12, 'Task 12 needs additional testing and improvements.'),
    (13, 'Employee training materials for Task 13 are in development.'),
    (13, 'The training sessions for Task 13 have been scheduled.'),
    (13, 'Task 13 will contribute to employee development.'),
    (14, 'The market research survey for Task 14 is live.'),
    (14, 'Weve received valuable responses for Task 14.'),
    (14, 'Lets analyze the survey data for Task 14.'),
    (15, 'The IT infrastructure assessment for Task 15 is complete.'),
    (15, 'Task 15 has identified areas for infrastructure improvement.'),
    (15, 'Infrastructure upgrades will enhance operations.'),
    (16, 'Product redesign concepts for Task 16 are impressive.'),
    (16, 'Task 16 prototypes are ready for testing.'),
    (16, 'Product redesign will boost market appeal.'),
    (17, 'The new sales strategy for Task 17 is in development.'),
    (17, 'The sales team is excited about the new strategy for Task 17.'),
    (17, 'Task 17 will drive sales growth.'),
    (18, 'Customer feedback survey design for Task 18 is complete.'),
    (18, 'Weve received positive feedback on the survey design.'),
    (18, 'Lets prepare insights from Task 18 survey data.'),
    (19, 'Sustainability programs planning for Task 19 is underway.'),
    (19, 'Task 19 programs will make a positive impact on the environment.'),
    (19, 'Task 19 is aligned with our corporate values.'),
    (20, 'The HR management system design for Task 20 is impressive.'),
    (20, 'Task 20 development is expected to streamline HR operations.'),
    (20, 'HR management improvements will benefit the organization.');

-- Insert data into the "project_member" table, 60 rows
INSERT INTO project_member (users_id, project_id, is_favorite) VALUES
    (1, 1, true),
    (2, 1, false),
    (3, 2, true),
    (4, 2, false),
    (5, 3, true),
    (6, 3, false),
    (7, 4, true),
    (8, 4, false),
    (9, 5, true),
    (10, 5, false),
    (11, 6, true),
    (12, 6, false),
    (13, 7, true),
    (14, 7, false),
    (15, 8, true),
    (16, 8, false),
    (17, 9, true),
    (18, 9, false),
    (19, 10, true),
    (20, 10, false),
    (21, 11, true),
    (22, 11, false),
    (23, 12, true),
    (24, 12, false),
    (25, 13, true),
    (26, 13, false),
    (27, 14, true),
    (28, 14, false),
    (29, 15, true),
    (30, 15, false),
    (31, 16, true),
    (32, 16, false),
    (33, 17, true),
    (34, 17, false),
    (35, 18, true),
    (36, 18, false),
    (37, 19, true),
    (38, 19, false),
    (39, 20, true),
    (40, 20, false),
    (41, 21, true),
    (42, 21, false),
    (43, 22, true),
    (44, 22, false),
    (45, 23, true),
    (46, 23, false),
    (47, 24, true),
    (48, 24, false),
    (49, 25, true),
    (50, 25, false),
    (51, 26, true),
    (52, 26, false),
    (53, 27, true),
    (54, 27, false),
    (55, 28, true),
    (56, 28, false),
    (57, 29, true),
    (58, 29, false),
    (59, 30, true),
    (60, 30, false);

-- Insert data into the "admins" table, 20 rows
INSERT INTO admins (name, password) VALUES
    ('Admin 1', 'adminpass1'),
    ('Admin 2', 'mypass2'),
    ('Admin 3', 'secretpass3'),
    ('Admin 4', 'password4'),
    ('Admin 5', 'admin123'),
    ('Admin 6', 'secureadmin'),
    ('Admin 7', 'adminadmin7'),
    ('Admin 8', 'adminpass8'),
    ('Admin 9', 'mypassword9'),
    ('Admin 10', 'adminadmin10'),
    ('Admin 11', 'password11'),
    ('Admin 12', 'secure123'),
    ('Admin 13', 'adminpass13'),
    ('Admin 14', 'mypass14'),
    ('Admin 15', 'adminadmin15'),
    ('Admin 16', 'password16'),
    ('Admin 17', 'securepass17'),
    ('Admin 18', 'mypassword18'),
    ('Admin 19', 'adminadmin19'),
    ('Admin 20', 'password20');
    -- Add more admin data here

-- Insert data into the "task_assigned" table, 60 rows
INSERT INTO task_assigned (users_id, task_id) VALUES
    (7, 1),
    (19, 2),
    (29, 3),
    (8, 4),
    (18, 5),
    (30, 6),
    (9, 7),
    (17, 8),
    (31, 9),
    (10, 10),
    (16, 11),
    (32, 12),
    (11, 13),
    (15, 14),
    (33, 15),
    (12, 16),
    (14, 17),
    (34, 18),
    (13, 19),
    (20, 20),
    (35, 21),
    (6, 22),
    (21, 23),
    (36, 24),
    (5, 25),
    (22, 26),
    (37, 27),
    (4, 28),
    (23, 29),
    (38, 30),
    (3, 31),
    (24, 32),
    (39, 33),
    (2, 34),
    (25, 35),
    (40, 36),
    (1, 37),
    (26, 38),
    (41, 39),
    (49, 40),
    (27, 41),
    (42, 42),
    (50, 43),
    (28, 44),
    (43, 45),
    (51, 46),
    (45, 47),
    (52, 48),
    (44, 49),
    (53, 50),
    (46, 51),
    (54, 52),
    (48, 53),
    (55, 54),
    (47, 55),
    (56, 56),
    (53, 57),
    (57, 58),
    (52, 59),
    (58, 60);

-- Insert data into the "project_coordinator" table, 30 rows
INSERT INTO project_coordinator (users_id, project_id) VALUES
    (7, 1),
    (10, 2),
    (10, 3),
    (13, 4),
    (14, 5),
    (15, 6),
    (16, 7),
    (17, 8),
    (18, 9),
    (19, 10),
    (20, 11),
    (21, 12),
    (22, 13),
    (23, 14),
    (24, 15),
    (25, 16),
    (26, 17),
    (27, 18),
    (28, 19),
    (29, 20),
    (30, 21),
    (31, 22),
    (32, 23),
    (33, 24),
    (34, 25),
    (35, 26),
    (36, 27),
    (37, 28),
    (38, 29),
    (39, 30);

-- Insert data into the "invitation" table, 10 rows
INSERT INTO invitation (project_id, users_id, project_coordinator_id) VALUES
    (1, 2, 1),
    (3, 1, 4),
    (5, 3, 2),
    (7, 4, 6),
    (9, 5, 8),
    (11, 6, 10),
    (13, 7, 3),
    (15, 8, 5),
    (17, 9, 7),
    (19, 10, 9);

    -- Add more invitation data here

--"company" table, 30 rows
--"users" table, 120 rows
--"invitation" table, 10 rows
--"project" table, 30 rows
--"task" table, 100 rows
--"comment" table, 60 rows
--"project_member" table, 60 rows
--"admins" table, 20 rows
--"task_assigned" table, 60 rows
--"project_coordinator" table, 30 rows
--"invitation" table, 10 rows
```

## Revision history

---

GROUP23156, 26/10/2023

- Alexandre Morais up201906049
- Nuno Ramos up201906051 (Editor)
- Bruno Leal up202008047
- Vitor Bizarro up202007888





