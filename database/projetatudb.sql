DROP SCHEMA IF EXISTS lbaw23156 CASCADE;
CREATE SCHEMA IF NOT EXISTS lbaw23156;
SET search_path TO lbaw23156;


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
DROP TABLE IF EXISTS notifications;

DROP TYPE IF EXISTS status;
DROP TYPE IF EXISTS notification_type;


CREATE TYPE status AS ENUM ('Completed', 'Ongoing', 'Paused', 'Abandoned', 'Overdue');
CREATE TYPE notification_type AS ENUM('project_notification','invitation_notification','task_notification','comment_notification');

CREATE TABLE users(
   id SERIAL PRIMARY KEY,
  name VARCHAR NOT NULL,
  email VARCHAR UNIQUE NOT NULL,
  password VARCHAR NOT NULL,
  remember_token VARCHAR,
  is_admin BOOLEAN NOT NULL DEFAULT FALSE
);


CREATE TABLE company(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE project (
    id SERIAL PRIMARY KEY,
    company_id INTEGER REFERENCES company(id) ON DELETE CASCADE,
    name TEXT NOT NULL,
    details TEXT,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now(),
    delivery TIMESTAMP WITH TIME ZONE CHECK (delivery >= creation)
);

CREATE TABLE project_member(
    id SERIAL PRIMARY KEY,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    is_favorite BOOLEAN DEFAULT FALSE 
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
    status status NOT NULL DEFAULT 'Ongoing',
    creation TIMESTAMP WITH TIME ZONE DEFAULT now(),
    delivery TIMESTAMP WITH TIME ZONE CHECK (delivery >= creation)
);


CREATE TABLE task_assigned(
    id SERIAL PRIMARY KEY,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task_id INTEGER NOT NULL REFERENCES task(id) ON DELETE CASCADE
);


CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    author INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task_id INTEGER NOT NULL REFERENCES task(id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now()
);


CREATE TABLE invitation(
    id SERIAL PRIMARY KEY,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_coordinator_id INTEGER NOT NULL REFERENCES project_coordinator(id) ON DELETE CASCADE
);

/*
CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    dismissed BOOLEAN NOT NULL,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    invitation_id INTEGER REFERENCES invitation(id) ON DELETE CASCADE,
    comment_id INTEGER REFERENCES comment(id) ON DELETE CASCADE,
    task_id INTEGER REFERENCES task(id),
    project_id INTEGER REFERENCES project(id) ON DELETE CASCADE,
    notification_type notification_type NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now()

);
*/

/*
-------------------------------------------------------------------------------------------------------------------------------
-- INDEXES
-------------------------------------------------------------------------------------------------------------------------------

CREATE INDEX task_assigned_idx ON task_assigned USING btree (users_id);

CREATE INDEX idx_users_email ON users USING hash (email);

CREATE INDEX idx_task_project_id ON task USING btree (project_id);

-- FULL-TEXT SEARCH INDEX

ALTER TABLE project
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION project_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.details), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.details <> OLD.details) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.details), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;
N DELETE CASCADE,
    project_id INTEGER REFERENCES project(id) ON DELETE CASCADE,
    TYPE notification_type NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now()
;


-------------------------------------------------------------------------------------------------------------------------------
-- INDEXES
-------------------------------------------------------------------------------------------------------------------------------

CREATE INDEX task_assigned_idx ON task_assigned USING btree (users_id);

CREATE INDEX idx_users_email ON users USING hash (email);

CREATE INDEX idx_task_project_id ON task USING btree (project_id);

-- FULL-TEXT SEARCH INDEX

ALTER TABLE project
ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION project_search_update() RETURNS TRIGGER AS $$
BEGIN
 IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
         setweight(to_tsvector('english', NEW.name), 'A') ||
         setweight(to_tsvector('english', NEW.details), 'B')
        );
 END IF;
 IF TG_OP = 'UPDATE' THEN
         IF (NEW.name <> OLD.name OR NEW.details <> OLD.details) THEN
           NEW.tsvectors = (
             setweight(to_tsvector('english', NEW.name), 'A') ||
             setweight(to_tsvector('english', NEW.details), 'B')
           );
         END IF;
 END IF;
 RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER project_search_update
 BEFORE INSERT OR UPDATE ON project
 FOR EACH ROW
 EXECUTE PROCEDURE project_search_update();

CREATE INDEX search_idx ON project USING GIN (tsvectors);
*/

-------------------------------------------------------------------------------------------------------------------------------
-- TRIGGER
-------------------------------------------------------------------------------------------------------------------------------
/*
-- TRIGGER 1

CREATE FUNCTION prevent_duplicate_assignment() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM task_assigned WHERE users_id = NEW.users_id AND task_id = NEW.task_id) THEN
        RAISE EXCEPTION 'User is already assigned to this task';
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER prevent_duplicate_assignment_trigger
BEFORE INSERT ON task_assigned
FOR EACH ROW
EXECUTE FUNCTION prevent_duplicate_assignment();

-- TRIGGER 2

CREATE OR REPLACE FUNCTION update_task_status_trigger()
RETURNS TRIGGER AS $$
BEGIN
  IF NEW.delivery < NOW() THEN AND NEW.delivery != 'Completed'
    NEW.status = 'Overdue';
  END IF;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER task_update_status
BEFORE INSERT OR UPDATE ON task
FOR EACH ROW
EXECUTE FUNCTION update_task_status_trigger();

-------------------------------------------------------------------------------------------------------------------------------
-- TRANSACTION
-------------------------------------------------------------------------------------------------------------------------------

-- TRANSACTION 1

BEGIN TRANSACTION

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ

INSERT INTO project_member(users_id, project_id, is_favorite)
    VALUES ($users_id, $project_id, $is_favorite);

INSERT INTO project_coordinator(id, users_id, project_id)
    VALUES ($id, $users_id, $project_id);

END TRANSACTION;
*/

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

    
-- Insert data into the "users" table, 120 rows /TODAS A PASSES SAO 1234
INSERT INTO users (name, email, password) VALUES
    ('John Doe', 'john.doe@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Jane Smith', 'jane.smith@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Michael Johnson', 'michael.j@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Emily Brown', 'emily.brown@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('William Davis', 'william.d@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Sophia Wilson', 'sophia.w@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('James Anderson', 'james.a@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Olivia Harris', 'olivia.h@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Liam Thomas', 'liam.t@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Emma Lee', 'emma.l@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Noah White', 'noah.w@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Ava Martinez', 'ava.m@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Logan Garcia', 'logan.g@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Bruno Leal', 'bruno.l@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W'),
    ('Andre Leal', 'andre.l@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W');


INSERT INTO users (name, email, password, is_admin) VALUES
    ('L Paca', 'l.paca@example.com', '$2y$10$HfzIhGCCaxqyaIdGgjARSuOKAcm1Uy82YfLuNaajn6JrjLWy9Sj/W', TRUE);
   

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
    (1, 14, 'Financial Report Analysis', 'Analyze the companys financial reports and prepare an audit.', 'Ongoing', NOW() + INTERVAL '30 days'),
    (1, 1, 'Content Update Planning', 'Plan the content updates for the new website.', 'Paused', NOW() + INTERVAL '30 days'),
    (1, 14, 'Inventory System Planning', 'Plan the inventory managment system.', 'Paused', NOW() + INTERVAL '30 days'),
    (1, 2, 'Revenue Data Review', 'Review and validate revenue data for the audit.', 'Completed', NOW() + INTERVAL '45 days'),
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
    (7, 13, 'Mobile App Wireframing', 'Create wireframes for the new mobile application.', 'Ongoing', NOW() + INTERVAL '60 days');


-- Insert data into the "comment" table, 60 rows
INSERT INTO comment (task_id, author, content) VALUES
    (1, 1,'This task needs to be done by someone else');

   

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
    (14, 1, true),
    (14, 2, false),
    (14, 3, false);
    

-- Insert data into the "task_assigned" table, 60 rows
INSERT INTO task_assigned (users_id, task_id) VALUES
    (7, 1),
    (10, 2),
    (10, 3),
    (8, 4),
    (12, 5),
    (10, 6),
    (9, 7),
    (8, 8),
    (13, 9),
    (10, 10),
    (13, 11),
    (14, 1),
    (15,1),
    (12, 12);
 

-- Insert data into the "project_coordinator" table, 30 rows
INSERT INTO project_coordinator (users_id, project_id) VALUES
    (14, 1),
    (14, 2),
    (10, 3),
    (13, 4);


-- Insert data into the "invitation" table, 10 rows
INSERT INTO invitation (id, project_id, users_id, project_coordinator_id) VALUES
    (1, 1, 2, 1),
    (2, 3, 1, 4),
    (3, 5, 3, 2);


/*
-- Insert data into the "notifications" table, 8 rows
INSERT INTO notifications (dismissed, users_id, invitation_id, comment_id, task_id, project_id, notification_type, creation) VALUES
  (false, 1, 1, null, 4, null, 'project_notification', '2023-10-26T08:00:00Z'),
  (true, 1, null, null, 6, 2, 'task_notification', '2023-10-26T10:15:00Z'),
  (false, 2, null, null, null, 3, 'comment_notification', '2023-10-26T11:45:00Z'),
  (false, 3, 3, null, null, 1, 'invitation_notification', '2023-10-26T13:30:00Z'),
  (true, 4, null, null, 7, 2, 'task_notification', '2023-10-26T15:00:00Z');
*/
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
--"notifications" table, 8 rows
