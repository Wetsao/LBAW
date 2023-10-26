/*
DROP TABLE IF EXISTS project CASCADE;
DROP TABLE IF EXISTS task CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS comment CASCADE;
DROP TABLE IF EXISTS project_member;
DROP TABLE IF EXISTS admins;
DROP TABLE IS EXISTS company;
DROP TABLE IF EXISTS task_assigned;
DROP TABLE IF EXISTS project_coordinator;
DROP TABLE IF EXISTS invitation;

DROP TYPE IF EXISTS status;


CREATE TYPE status AS ENUM ('Completed', 'Ongoing', 'Paused', 'Abandoned');


CREATE TABLE company(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE users(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    CONSTRAINT valid_email_format CHECK (email ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
);

CREATE TABLE project (
    id SERIAL PRIMARY KEY,
    company_id REFERENCES company(id) ON DELETE CASCADE,
    name TEXT NOT NULL,
    details TEXT,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now(),
    delivery TIMESTAMP WITH TIME ZONE CHECK (delivery >= creation)
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


CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    author INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task_id INTEGER NOT NULL REFERENCES task(id) ON DELETE CASCADE,
    content TEXT NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now()
);

CREATE TABLE project_member(
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    is_favorite BOOLEAN DEFAULT FALSE;
    PRIMARY KEY(project_id, users_id)
);

CREATE TABLE admins(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL, 
    password TEXT NOT NULL
);

CREATE TABLE task_assigned(
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    task_id INTEGER NOT NULL REFERENCES task(id) ON DELETE CASCADE,
    PRIMARY KEY(users_id, task_id)
);

CREATE TABLE project_coordinator(
    id SERIAL PRIMARY KEY,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE
);

CREATE TABLE invitation(
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_coordinator_id INTEGER NOT NULL REFERENCES project_coordinator(id) ON DELETE CASCADE,
    PRIMARY KEY(project_id, users_id, project_coordinator_id)
);
*/

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
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    CONSTRAINT valid_email_format CHECK (email ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
);

CREATE TABLE admins(
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL, 
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
    CONSTRAINT valid_email_format CHECK (email ~ '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\\.[A-Za-z]{2,}$')
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
    id SERIAL PRIMARY KEY,
    project_id INTEGER NOT NULL REFERENCES project(id) ON DELETE CASCADE,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    project_coordinator_id INTEGER NOT NULL REFERENCES project_coordinator(id) ON DELETE CASCADE,
);

CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    dismissed BOOLEAN NOT NULL,
    users_id INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    invitation_id INTEGER REFERENCES invitation(id) ON DELETE CASCADE,
    comment_id INTEGER REFERENCES comment(id) ON DELETE CASCADE,
    task_id INTEGER REFERENCES task(id) ON DELETE CASCADE,
    project_id INTEGER REFERENCES project(id) ON DELETE CASCADE,
    TYPE notification_type NOT NULL,
    creation TIMESTAMP WITH TIME ZONE DEFAULT now()
);


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


-------------------------------------------------------------------------------------------------------------------------------
-- TRIGGER
-------------------------------------------------------------------------------------------------------------------------------

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
