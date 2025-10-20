## A7: Web Resources Specification

This artifact presents the documentation for ProjeTatu, including the CRUD (create, read, update, delete) operations for each resource implemented in the vertical prototype.

### 1. Overview
Module | Description
--- | --- 
**M01: Authentication and User Profile** | Web resources associated with user authentication and individual profile management. Includes login/logout, registration,view and edit personal profile information. |
**M02: User Administration and Static pages** | Web resources associated with user management, specifically: view and search users, delete user accounts, view and change user information, and view system access details for each user. Web resources with static content are associated with this module: dashboard, about, contact, services and faq. |
**M03: Projects** | Web Resources associated with projects. Includes the following system features: view project board and info, create and edit projects, archive projects, mark projects as favorites, delete projects, create and edit tasks, assign users to tasks, create and edit comments on tasks, create invitations to join a project. |
**M04: Search** | Web Resources associated with the search system. Includes the following system features: search projects, search tasks inside a project. |


### 2. Permissions

This section defines the permissions used in the modules to establish the conditions of access to resources.

Identifier | Permission | Description
--- | --- | --- |
**PUB** | **Public** | Users without privileges |
**USR** | **User** | Authenticated Users |
**OWN** | **Owner** | Users that are are owners of information|
**MBR** | **Member** | Project Members |
**COR** | **Coordinator** | Project Coordinators |
**ADM** |**Administrator** | System administrators |


### 3. OpenAPI Specification

Link to [.yaml](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23156/-/blob/a40a0cbbf91bd70b1e47150d6a1795fd9510fafb/docs/a7_openapi.yaml)

```yaml

openapi: 3.0.0

info:
  version: '1.0'
  title: 'LBAW ProjeTatu Web API'
  description: 'Web Resources Specification (A7) for ProjeTatu'

servers:
- url: http://lbaw23156.lbaw.fe.up.pt
  description: Production server

tags:
  - name: 'M01: Authentication and Individual Profile'
  - name: 'M02: Projects'
  - name: 'M03: Search'
  - name: 'M04: User Administration and Static pages'

paths: 

#################################################################################################################################################################
########################################################## M01: Authentication and Individual Profile ###########################################################
#################################################################################################################################################################

  /login:
    get:
      operationId: R101
      summary: 'R101: Login Form'
      description: 'Provide login form. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
        
      responses:
        '200':
          description: 'Ok. Show log-in UI'
          
    post:
      operationId: R102
      summary: 'R102: Login Action'
      description: 'Processes the login form submission. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
 
      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:          # <!--- form field name
                  type: string
                password:    # <!--- form field name
                  type: string
              required:
                - email
                - password
 
      responses:
        '302':
          description: 'Redirect after processing the login credentials.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to Homepage.'
                  value: '/'
                302Error:
                  description: 'Failed authentication. Redirect to login form.'
                  value: '/login'

  /logout:
     post:
      operationId: R103
      summary: 'R103: Logout Action'
      description: 'Logout the current authenticated used. Access: USR, ADM'
      tags:
        - 'M01: Authentication and Individual Profile'
        
      responses:
        '302':
          description: 'Redirect after processing logout.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful logout. Redirect to login form.'
                  value: '/login'

  /register:
    get:
      operationId: R104
      summary: 'R104: Register Form'
      description: 'Provide new user registration form. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'
        
      responses:
        '200':
          description: 'Ok. Show sign-up UI'

    post:
      operationId: R105
      summary: 'R105: Register Action'
      description: 'Processes the new user registration form submission. Access: PUB'
      tags:
        - 'M01: Authentication and Individual Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                password: 
                  type: string
              required:
                - name
                - email
                - password

      responses:
        '302':
          description: 'Redirect after processing the new user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Failure:
                  description: 'Failed authentication. Redirect to register form.'
                  value: '/register'
  
  /users/{id}:
    get:
      operationId: R106
      summary: 'R106: View user profile'
      description: 'Show the individual user profile. Access: USR'
      tags:         
       - 'M01: Authentication and Individual Profile'

      parameters:
        - in: path
          name: id
          schema:              
            type: integer
          required: true

      responses:
        '200':
          description: 'Ok. Show view profile UI'
        '404':
          description: 'Not Found. User id not found'

  /users/{id}/edit:
    get:
      operationId: R107
      summary: 'R107: Edit user profile'
      description: 'Show the edit page. Access: OWN'
      tags: 
       - 'M01: Authentication and Individual Profile'
      
      parameters:
        - in: path
          name: id
          schema:              
            type: integer
          required: true
      
      responses:
        '200':
          description: 'Ok. Show view profile UI'
        '404':
          description: 'Not Found. User id not found'
    
    post: 
      operationId: R108
      summary: 'R108: Edit user profile'
      description: 'Show the edit page. Access: OWN, ADM'
      tags: 
       - 'M01: Authentication and Individual Profile'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                email:
                  type: string
                password: 
                  type: string
                phonenumber:
                  type: string
                aboutme:
                  type: string
      responses:
        '302':
          description: 'Redirect after processing the edited user information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful authentication. Redirect to user profile.'
                  value: '/users/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to edit form.'
                  value: '/users/{id}/edit'

  /:
    get:
      operationId: R109
      summary: 'R109: Home Page'
      description: 'Show the Home page. Access: USR'
      tags: 
       - 'M01: Authentication and Individual Profile'

      responses: 
        '302':
          description: 'Ok. Show Homepage'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Redirect to Homepage.'
                  value: '/'
                302Error:
                  description: 'Redirect to login form.'
                  value: '/login'

#################################################################################################################################################################
##################################################################### M02: Projects #############################################################################
#################################################################################################################################################################

  /project/{id}:
    get:
        operationID: R201
        summary: 'R201: View project page'
        description: 'Show the project page and its information. Access: PM, ADM'
        tags:
          - 'M02: Projects'
          
        parameters:
          - in: path
            name: id
            schema:
              type: integer
            required: true

        responses:
          '302':
            description: 'Redirect to project page.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Redirect to Project Page.'
                    value: '/project/{id}'
                  302Error:
                    description: 'Redirect to Homepage.'
                    value: '/'

  /project/new:
    get:
      operationId: R202
      summary: 'R202: Create New Project Form'
      description: 'Create New Project Form page. Access: USR'
      tags:
        - 'M02: Projects'

      responses:
        '200':
          description: 'Sucess. Create New Project UI is shown'

    post:
      operationId: R203
      summary: 'R203: Create new project action'
      description: 'Create New Project data precessing. Access: USR'

      tags:
        - 'M02'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                details:
                  type: string
              required:
                - name

      responses:
        '302':
          description: 'Redirect after processing the project information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful project creation. Redirect to project page.'
                  value: '/project/{id}'
                302Failure:
                  description: 'Failed to create project. Redirect to project creation.'
                  value: '/project/new'

  /project/{id}/task/new:
    get:
      operationId: R204
      summary: 'R204: Create New Task Form'
      description: 'Create a New Task Form. Access: MBR'
      tags:
        - 'M02: Projects'

      responses:
        '200':
          description: 'Ok. Show New Task Ui'    

    post:
      operationId: R205
      summary: 'R205: Create new Task'
      description: 'Create a new Task on the specified project. Access: MBR'
      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                details:
                  type: string
                delivery:
                  type: string
                  format: date
              required:
                - 'name'

      responses:
        '302':
          description: 'Redirect to the task page after creating the new task'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful task creation. Redirect to task page.'
                  value: '/project/{id}/task/{id}'
                302Failure:
                  description: 'Failed to create task. Redirect to task creation.'
                  value: '/project/new/task/new'

  /project/{id}/task/{id}:
    get:
      operationId: R206
      summary: 'R206: View Task Details'
      description: 'Show the Task details page. Access: MBR, ADM'
      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true
        - in: path
          name: id
          schema:
            type: integer
          required: true
          
      responses:
        '302':
            description: 'Redirect to task page.'
            headers:
              Location:
                schema:
                  type: string
                examples:
                  302Success:
                    description: 'Redirect to Task Page.'
                    value: '/project/{id}/task/{id}'
                  302Error:
                    description: 'Redirect to Project Page.'
                    value: '/project/{id}'

  /project/{id}/task/search:
    get:
      operationId: R207
      summary: 'R207: Search tasks'
      description: 'Search tasks within a specific project. Access: MBR'
      tags:
        - 'M02: Projects'
      parameters:
        - in: query
          name: q
          schema:
            type: string
          required: true
      responses:
        '200':
          description: 'Sucess. Task search UI is shown'
        '403':
          description: 'User doesnt have permition'
        '404':
          description: 'Cannot be found'
  
  /project/{id}/task/{id}/edit:
    post: 
      operationId: R208
      summary: 'R208: Edit Task Details'
      description: 'Show the edit page. Access: MBR'
      tags: 
       - 'M02: Projects'

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                name:
                  type: string
                details:
                  type: string
                delivery: 
                  type: string
                  format: date

      responses:
        '302':
          description: 'Redirect after processing the edited task information.'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful edit. Redirect to task page.'
                  value: '/project/{id}/task/{id}'
                302Failure:
                  description: 'Failed edit. Redirect to edit form.'
                  value: '/project/{id}/task/{id}/edit'

  /project/{id}/add:
    get:
      operationId: R209
      summary: 'R209: Project Member addition Form'
      description: 'Provide the Add New Member Form. Access: COORD'

      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Ok. Show the New Member Form'

    post:
      operationId: R210
      summary: 'R210: Process the Member addition Form'
      description: 'Process the Add New Member Form. Access: COORD'

      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: string
          required: true

      requestBody:
        required: true
        content:
          application/x-www-form-urlencoded:
            schema:
              type: object
              properties:
                email:
                  type: string
              required:
                - 'email'

      responses:
        '302':
          description: 'Redirect to the project board after adding a user'
          headers:
            Location:
              schema:
                type: string
              examples:
                302Success:
                  description: 'Successful New Member creation. Redirect to Project page.'
                  value: '/project/{id}'
                302Failure:
                  description: 'Failed to create New Member. Redirect to New Member page.'
                  value: '/project/{id}/add'

  /project/{id}/task/{id}/complete:
    put:
      operationId: R211
      summary: 'R211: Complete Task'
      description: 'Mark a task as completed. Access: MBR.'

      tags:
        - 'M02: Projects'

      parameters:
        - in: path
          name: id
          schema:
            type: integer
          required: true

      responses:
        '200':
          description: 'Task marked as completed'
          content:
            application/json:
              schema:
                type: object
                properties:
                  id:
                    type: integer
                  name:
                    type: string
                  details:
                    type: string
                  creation:
                    type: string
                    format: date
                  delivery:
                    type: string
                    format: date
                  status:
                    type: string
                    example: COMPLETED
                  creator:
                    type: integer
        '403':
          description: 'User doesnt have permition'
        '404':
          description: 'Cannot be found'
      
#################################################################################################################################################################
###################################################################### M03: Search ##############################################################################
#################################################################################################################################################################

  /project/search:
    get:
      operationId: R301
      summary: 'R301: Search projects'
      description: 'Search for the users projects. Access: USR'
      tags:
        - 'M03: Search'

      parameters:
        - in: query
          name: q
          schema:
            type: string
          required: true

      responses:
        '200':
          description: 'Sucess. Project search UI is shown'
        '403':
          description: 'User doesnt have permission'
        '404':
          description: 'Cannot be found'

#################################################################################################################################################################
########################################################### M04: User Administration and Static pages ###########################################################
#################################################################################################################################################################

  /admin/users:
    get:
      operationId: R401
      summary: 'R401: User Administration Area'
      description: 'Administration Area. Access: ADM'
      tags:
        - 'M04: User Administration and Static pages'

      responses:
        '200':
          description: 'Sucess. Administration area UI is shown'
        '403':
          description: 'User doesnt have permission'
        '404':
          description: "Not Found."

  /faq:
    get:
      operationId: R402
      summary: 'R402: Frequently Asked Questions'
      description: 'Page with frequently asked questions. Access: PUB, USR, ADM'
      tags:
        - 'M04: User Administration and Static pages'

      responses:
        '200':
          description: 'Ok. Show FAQ page'
        '404':
          description: "Not Found."

  /aboutus:
    get:
      operationId: R403
      summary: 'R403: About Us'
      description: 'Page with information about us. Access: PUB, USR, ADM'
      tags:
        - 'M04: User Administration and Static pages'
      
      responses:
        '200':
          description: 'Ok. Show About Us page'
        '404':
          description: "Not Found."

  /services:
    get:
      operationId: R404
      summary: 'R404: Services'
      description: 'Services page. Access: PUB, USR, ADM'
      tags:
        - 'M04: User Administration and Static pages'

      responses:
        '200':
          description: 'Ok. Show Services page'
        '404':
          description: "Not Found."

```




## A8- Vertical Prototype

The Vertical Prototype includes the implementation of the high priority features marked as necessary (with an asterisk) in the common and theme requirements documents. This artifact aims to validate the architecture presented, also serving to gain familiarity with the technologies used in the project.


### 1. Implemented Features

#### 1.1. Implemented User Stories

Identifier | Name | Priority | Description |
--- |--- | --- | --- |
US01| See home | high | As a User, I want to access the home page, so that I can see a brief presentation of the website and all the available options |
US02| Create project | high | As a User, I want to create a new project, so that I can manage a new project |
US03| View projects | high | As a User, I want to access a list of all the projects I currently work and have worked, so that I can easily navigate through the website |
US05 | Edit profile | high | As a User I want to modify my profile so that I can make my information up to date |
US06 | Sign-out | high | As a User, I want to be able to sign out of the system, so that I can stop using my account |
US11| Sign-in | high | As a Visitor, I want to authenticate into the system, so that I have access to privileged information |
US12 | Sign-up | high | As a Visitor, I want to register my account into the system, so that I can authenticate into the system later |
US23 | View task details | high | As a Project Member, I want to view the details of specific task, so that I can understand better what the task is about | 
US28 | Project details | high | As a Project Member, I want to see the project details of a project, so that I can get more information about the project I am currently working on|
US41 | User list | high | As an Admin, I want to see a list of all the users registred in the system, so that i can look through all the registered users |
US43 | Sign-out | high | As a User, I want to be able to sign out of the system, so that I can stop using my account |

#### 1.2. Implemented Web Resources

| Web Resource Reference | URL                            |
| ---------------------- | ------------------------------ |
| R101: Login Form | GET /login   |
| R103: Logout Action | POST /logout |
| R104: Register Form | GET /register |
| R105: Register Action | POST /register |
| R106: View user profile | GET /profile |
| R107: Edit user profile | GET /edit-profile |
| R108: Edit user profile | POST /edit-profile |
| R109: Home Page | GET /homepage |
| R201: View project page | GET /project-page |
| R202: Create New Project Form | GET /add |
| R203: Create new project action | POST /insert |
| R206: View Task Details | GET /project-page/{projectId}/task/{taskId}|
| R401: User Administration Area | GET /homepage |

### 2. Prototype

Link to [site](https://lbaw23156.lbaw.fe.up.pt/)

#### 2.1. Credentials

| Email | Password | Position |
|-------|----------|----------|
|l.paca@example.com|1234|Admin|
|bruno.l@example.com|1234| Project Coordinator/Project Member|

## Revision history
---

GROUP23156, 25/11/2023

- Alexandre Morais up201906049
- Nuno Ramos up201906051 
- Bruno Leal up202008047 (Editor)
- Vitor Bizarro up202007888



