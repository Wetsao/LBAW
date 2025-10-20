# PA: Product and Presentation

Software tool for tracking and managing projects. This application is designed to help users plan, coordinate, and execute tasks that need to be completed to make progress on the project at hand.

## A9: Product


PROJETATU is a web application with the main goal of providing organizations, teams, or individuals with an intuitive web-based project management solution that optimizes project planning, task allocation, and progress tracking. 

### 1. Installation


The full Docker command to start the image available at the group's GitLab Container Registry using the production database:

```
docker run -it -p 8000:80 --name=lbaw23156 -e DB_DATABASE="lbaw23156" -e DB_SCHEMA="lbaw23156" -e DB_USERNAME="lbaw23156" -e DB_PASSWORD="jSBDcPLU" git.fe.up.pt:5050/lbaw/lbaw2324/lbaw23156
```

### 2. Usage

The final release version can be found [here (website)](http://lbaw23156.lbaw.fe.up.pt) or [here (source code)](https://git.fe.up.pt/lbaw/lbaw2324/lbaw23156).


#### 2.1. Administration Credentials

To access the admin page just login using this credentials: 

| Username | Password |
| -------- | -------- |
| l.paca@example.com    | 1234 |

#### 2.2. User Credentials

| Type          | Username  | Password |
| ------------- | --------- | -------- |
| User/Project Coordinator | jane.smith@example.com   | 1234 |
| User/Project Coordinator   | bruno.l@example.com    | 1234 |

### 3. Application Help

We did the application as intuitive as we could.

### 4. Input Validation

There is always labels when input is required.

### 5. Check Accessibility and Usability

Results of accessibility and usability tests using the following checklists:

- Accessibility: [Accessibility Report - SAPO UX](./docs/entregas/Ux_Sapo_Acessibilidade.pdf)
- Usability: [Usability Report - SAPO UX](./docs/entregas/Ux_Sapo_Usabilidade.pdf)

### 6. HTML & CSS Validation

The results of the validation of the HTML and CSS code:

- HTML:[W3C HTML Validator Reports](./docs/entregas/HTML_Validation)
- CSS: [W3C CSS Validator Report](./docs/entregas/CSS_Validation.pdf)

### 7. Revisions to the Project



### 8. Implementation Details



#### 8.1. Libraries Used



#### 8.2 User Stories


| US Identifier | Name    | Module | Priority                       | Team Members               | State  |
| ------------- | ------- | ------ | ------------------------------ | -------------------------- | ------ |
| US01      | See Home      | M01 | High     | Bruno Leal | 100% |
| US02      | Create Project     | M01 | High     | Bruno Leal | 100% |
| US03      | View Projects    | M01 | High     | Bruno Leal | 100% |
| US04      | View Profile | M01 | High | Bruno Leal | 100% |
| US05      | Edit Profile   | M01 | High     | Alexandre Morais/Bruno Leal | 30%/70% |
| US06      | Sign Out | M01 | High     | Bruno Leal | 100% |
| US07      | Mark Project as Favorite       | M01   | High     | Bruno Leal | 100% |
| US08      | Recover Password | M01 | High | Alexandre Morais/ Nuno Ramos | 50%/50% |
| US09      | Delete Account | M01 | High | Bruno Leal | 100% |
| US11      | Sign-In             | M02 | High     | Bruno Leal | 100% |
| US12      | Sign-Up          | M02   | High     | Bruno Leal | 100%|
| US13      | About Us | M02 | Medium | Nuno Ramos/Alexandre Morais | 50%/50% |
| US14      | Main Features | M02 | Medium | Nuno Ramos/Alexandre Morais | 50%/50% |
| US15      | Contacts | M02 | Medium | Nuno Ramos/Alexandre Morais | 50%/50% |
| US21      | Create Task | M03 | High     | Bruno Leal | 100% |
| US22      | Manage Tasks | M03 | High | Bruno Leal | 100% |
| US23      | View Task Details                   | M03 | High     | Nuno Ramos/Alexandre Morais | 50%/50% |
| US25      | Complete Task  | M03 | Medium   | Bruno Leal | 100% |
| US26      | Leave Project            | M03 | Medium   | Nuno Ramos/Alexandre Morais | 50%/50% |
| US27      | View Project Team                | M03    | High     |  Bruno Leal | 100%|
| US28      | View Project Details                | M03  | High     |  Nuno Ramos/Alexandre Morais | 50%/50% |
| US31      | Add User To Project   | M04   | High     |  Bruno Leal | 100%|
| US32      | Assign New Project Coordinator               | M04   | High     |  Nuno Ramos/Alexandre Morais |50%/50%|
| US33      | Remove Project Member               | M04   | High     | Bruno Leal | 100% |
| US36      | Remove Project Coordinator Privileges       | M04  | High     | Nuno Ramos/Alexandre Morais | 50%/50% |
| US37      | Assign User to Task        | M04 | High | Bruno Leal | 100% |
| US41      | User List | M05 | Medium   | Alexandre Morais/Bruno Leal | 50%/50% |
| US42      | Ban User            | M04 | Medium   | Bruno Leal | 100% |
| US43      | Sign Out              | M04  | Medium   | Bruno Leal | 100% |


## A10: Presentation
 

### 1. Product presentation

Software tool for tracking and managing projects. This application is designed to help users plan, coordinate, and execute tasks that need to be completed to make progress on the project at hand.

The primary goal of this project is to provide organizations, teams, or individuals with an intuitive web-based project management solution that optimizes project planning, task allocation, and progress tracking.

Our motivation behind the development of this project is to simplify and streamline the whole process of project development, and to empower its users and teams to a more efficient and productive work flow by creating a user-friendly platform.


URL to the product: http://lbaw23156.lbaw.fe.up.pt  


### 2. Video presentation

Screenshot of the video :
<p align="center" justify="center">
  <img src="images/VideoScreenshot.png"/>
</p>
<p align="center">
  <b><i>Fig1. Video Screenshot</i></b>
</p>
<br>
<br />


Link to video: 
https://drive.google.com/file/d/1CRBpEEf4uirkbpsU4KMeuusqHWrvgKTN/view?usp=sharing

---


## Revision history

--- 

GROUP2151, 28/01/2022

- Alexandre Morais up201906049 
- Nuno Ramos up201906051 (Editor)
- Bruno Leal up202008047
