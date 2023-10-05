# ER: Requirements Specification Component

Software tool for tracking and managing projects. This application is designed to help users plan, coordinate, and execute tasks that need to be completed to make progress on the project at hand.

# A1: ProjeTatu

The primary goal of this project is to provide organizations,teams, or individuals with an intuitive web-based project management solution that optimizes project planning, task allocation, and progress tracking.

Our motivation behind the development of this project is to simplify and streamline the whole process of project development, and to empower its users and teams to a more efficient and productive work flow by creating a user-friendly platform.

This project allows users to create and manage projects, break them down into tasks, assign team members to these tasks as well as leave comments on them, and monitor progress. Each projects will also be accomodated with a discussion forum to allow its members a method for quick communication.

Users are categorized into three different groups, admnistrators, authenticated and non-authenticated user. Admnistrators will not be able to create of participate in projects but will serve as the higher manager of the whole system, as it will be able to browse and view projects details and moderate users. Authenticated Users will also be categorized into two groups, Coordinator and Member, with varying permissions within the projects. Coordinator are Users that created a project and have complete access to it, they can add and remove team members as well as assign new coordinators, edit project details and change the project status. Members will be able to manage tasks, assign users to them as well as comment on them and change their status. Authenticated Users can also be in more than one project. Non-authenticated users simply have access to registration and login.

# A2: Actors and User stories

This artifact identifies the actors and their user stories while acting as documentation for the project’s requirements.

## 1. Actors

<p align="center" justify="center">
  <img src="images/UseCases.png"/>
</p>
<p align="center">
  <b><i>Fig1. Actors</i></b>
</p>
<br>
<br />

Identifier | Description |
--- | --- |
User | Authenticated user; Can create or join a project and edit his profile;
Visitor | Unauthenticated user; Able to sign-up or sign-in;
Project Member | Authenticated user; Allowed to create tasks, assign users to tasks and change task status; 
Project Coordinator | Authenticated user; Able to add users to project, assign new coordinator and archieve project;
Admin | Can browse projects and view project details; Not able to create or participate in projects

## 2. User Stories

### 2.1. User

Identifier | Name | Priority | Description |
--- |--- | --- | --- |
US01| See home | high | As a User, I want to access the home page, so that I can see a brief presentation of the website and all the available options |
US02| Create project | high | As a User, I want to create a new project, so that I can manage a new project |
US03| View projects | high | As a User, I want to access a list of all the projects I currently work and have worked, so that I can easily navigate through the website |
US04 | Notifications | high | As a User, I want to see a list of all my notifications, so that I can be up to date in the projects I am a part of |
US05 | Edit profile | high | As a User I want to modify my profile so that I can make my information up to date |
US06 | Sign-out | high | As a User, I want to be able to sign out of the system, so that I can stop using my account |
US07 | Mark project as favourite | medium |  As a User, I want to mark one or more projects that I am currently on as favourite, so that it's easier to follow it's development |

### 2.2. Visitor

Identifier | Name | Priority | Description |
--- | --- | --- | --- |
US11| Sign-in | high | As a Visitor, I want to authenticate into the system, so that I have access to privileged information |
US12 | Sign-up | high | As a Visitor, I want to register my account into the system, so that I can authenticate into the system later |

### 2.3. Project Member

Identifier | Name | Priority | Description |
--- |--- | --- | --- |
US21 | Create task | high | As a Project Member, I want to create a task inside a project, so that I can register an action that needs to be done |
US22 | Delete task | high | As a Project Member, I want to close a task, so that I can let the team know the task is no longer needed |
US23 | View task details | high | As a Project Member, I want to view the details of specific task, so that I can understand better what the task is about | 
US24 | Comment task | high | As a Project Member, I want to add a comment to a task, so that I can give my opinion regarding certain part of the task |
US25 | Complete task | high | As a Project Member, I want to complete an assigned task so that I can let the team know there's no more work needed on the specific task |
US26 | Leave project | high | As a Project Member, I want to leave a project that I'm currently on so that I can free some space  |
US27 | View project team | high |As a Project Member, I want to see a list of all the members of the project that I am currently on, so that I can get the knowledge of all the colleagues that will be working on the same project|
US28 | Project details | high | As a Project Member, I want to see the project details of a project, so that I can get more information about the project I am currently working on|
US29 | View team members profiles | medium | As a Project Member, I want to see the user profiles of my team members so that I can get information about someone I might need to interact with |
US210 | Search task | medium | As a Project Member, I want to search for a specific task inside a project so that I can easily find the task I'm searching for |

### 2.4. Project Coordinator 

Identifier | Name | Priority | Description |
--- |--- | --- | --- |
US31 | Add user to project | high | As a Project Coordinator, I want to add a new user to a project, so that all the members can be added to the project |
US32 | Assign new Project Coordinator | high | As a Project Coordinator, I want to assign a new Project Coordinator for a project, so that a project member gains the privileges of a project coordinator |
US33 | Edit project details | high | As a Project Coordinator, I want to edit the project details, so that i can update them |
US34 | Remove project member | high | As a Project Coordinator, I want to remove a member from a project, so that any unwanted members wont be kept in the project |
US35 | Archive project | high | As a Project Coordinator, I want to archive a project, so that it will be saved in case it will be needed to checkout in the future |
US36 | Remove Project Coordinator privileges | high | As a Project Coordinator, I want to remove Project Coordinator privileges from a team member, so that someone who doesnt need the privilege anymore wont keep them |
US37 | Delete comment | high | As a Project Coordinator, I want to remove a comment from a Project Member, so that there isnt any comments unrelated to the issue in question |

### 2.5. Admin

Identifier | Name | Priority | Description |
--- |--- | --- | --- |
US41 | User list | high | As an Admin, I want to see a list of all the users registred in the system, so that i can look through all the registered users |
US42 |  Ban user | high | As an Admin, I want to ban a registred User from the system, so that i can delete a user with unwanted behavior |
US43 | Sign-out | high | As a User, I want to be able to sign out of the system, so that I can stop using my account |

## 3. Supplementary requirements

### 3.1 Business rules

Identifier | Name| Description |
--- | --- | --- |
BR01 | Multiple Comments | In the instance of multiple comments on a task by the same user, the comments will show up as individual comments |
BR02 | User Deletion | When a user is deleted all its content stays but the author/creator of the content shows up as "user-deleted" |
BR03 | Task deadline | The deadline of a task must be greater than the creation date of the task |

### 3.2 Technical requirements

Identifier | Name | Description |
--- | --- | --- |
TR01 | Availability | The system must be available 99 percent of time in each 24 hour period |
TR02 | Accessibility | The system must be accessible to every person, regardless of any disability |
TR03 | Usability | The system must be simple, intuitive and easy to navigate |
TR04 | Performance | The system should be responsive (under 2 seconds of response time) |
TR05 | Web Application | The system should be implemented as a web application with dynamic pages |
TR06 | Database | PostgreSQL must be used as the database |
TR07 | Security | The system shall protect information from unauthorized access |
TR08 | Robustness | THe system must be prepared to handle and continue operating when runtime errors occur |
TR09 | Scalability | The system must be prepared to deal with the growth in the number of users and their actions |
TR10 | Ethics | The system must respect the ethical principles in software development |

### 3.3 Restrictions

Identifier | Name | Description |
--- | --- | --- |
BR01 | Deadline | The system should be ready to use at the beggining of december |

# A3: Information Architecture

This artifact presents an overview of the information architecture about the system to be developed. It has the following goals:

 1. Help identify and describe the user requirements, and raise new ones;
 2. Preview and empirically test the user interface of the product to be developed;
 3. Enable quick and multiple iterations on the design of the user interface.

This artifact includes two elements:

 1. A sitemap, defining how the information is organized in pages;
 2. A set of wireframes, defining the functionality and the content for each page.

## 1. Sitemap

The following Sitemap depicts the different pages intended in our application and the relationships in between them. Our system is organized in 5 main groups: 
1. The **Unauthenticated User Pages** displays the information about the page and offers the possibility of entering the system as an authenticated user. 
2. The **Public Pages** contain the general, public knowledge on the use of the application. 
3. The **Authenticated User Pages** that allows an user to manage their profile. 
4. The **Authenticated Admin Pages** that restrics the administrator to manage the usage of the app itself.
5. The **Project Pages** themselves which include the main interactions regarding all the projects available (which are here in a stack) and all the tasks assigned to them.

<p align="center" justify="center">
  <img src="images/sitemap.png"/>
</p>
<p align="center" justify="center">
  <b><i>Fig2. Sitemap</i></b>
</p>
<br>
<br />

# 2. Wireframes

## UI01 - Login 

<p align="center" justify="center">
  <img src="images/Login.png"/>
</p>
<p align="center" justify="center">
  <b><i>Fig3. Login</i></b>
</p>
<br>
<br />

## UI01 - View Projects

<p align="center" justify="center">
  <img src="images/ViewProjects.png"/>
</p>
<p align="center" justify="center">
  <b><i>Fig4. View Projects</i></b>
</p>
<br>
<br />

## UI07 - User profile

<p align="center" justify="center">
  <img src="images/Profile.png"/>
</p>
<p align="center" justify="center">
  <b><i>Fig5. User Profile</i></b>
</p>
<br>
<br />

## Artefacts Checklist

* The artefacts checklist is available at: <https://docs.google.com/spreadsheets/d/1eDBxYIYvh_G1SrmzsTyPRs5LCxtaLW-aBPjxWDdM83g/edit?usp=sharing>

## Team

- Alexandre Morais up201906049
- Nuno Ramos up201906051
- Bruno Leal up202008047
- Vitor Bizarro up202007888

---

GROUP23156, 05/10/2023
