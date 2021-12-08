# EAP: Architecture Specification and Prototype
!!!!Project vision.

## A7: Web Resources Specification
!!!!!Brief presentation of the artefact's goals.

### 1. Overview
This segment identifies the modules that will constitute our application.
|Module|Description|
|--------------|----------------|
|M01: Authentication|Web resources associated with user authentication. Includes the following system features: login/logout, registration, password recovery.|
|M02: Individual Profile|Web resources associated with individual profile management. Includes the following system features: view and edit personal profile information, list bids, rate auctioneers, list notifications, create and list transactions.|
|M03: Auctions|Web resources associated with auctions posted. It is possible to see the auction catalog, search for and create new auctions, see auction pages, participate by bidding or commenting, follow auctions to keep updated.|
|M04: Static pages|Web resources with static content are associated with this module: about, contact, services and faq.|  
|M05: User Administration|Web resources associates with user management, specifically: view and search users, delete or block user accounts, view and change user information, and view system access details for each user.| 

### 2. Permissions
Permissions are documented here and will later be used on each action regarding modules of the website.

|            PUB           |         USR        |          AUC          |          ADM          |
|:------------------------:|:------------------:|:---------------------:|:---------------------:|
|           Pubic          |        User        |     Auctioneer     |     Administrator     |
| Users without privileges | Authenticated User | Auction Owner | System administrators |

### 3. OpenAPI Specification
OpenAPI specification in YAML format to describe the web application's web resources.

Link to the a7_openapi.yaml file in the group's repository.

openapi: 3.0.0

...
## A8: Vertical prototype
Brief presentation of the artefact goals.

### 1. Implemented Features
#### 1.1. Implemented User Stories
Identify the user stories that were implemented in the prototype.

User Story reference	Name	Priority	Description
US01	Name of the user story	Priority of the user story	Description of the user story
...

#### 1.2. Implemented Web Resources
Identify the web resources that were implemented in the prototype.

Module M01: Module Name

Web Resource Reference	URL
R01: Web resource name	URL to access the web resource
...

Module M02: Module Name

...

### 2. Prototype
URL of the prototype plus user credentials necessary to test all features.
Link to the prototype source code in the group's git repository.

Revision history
Changes made to the first submission:

Item 1
..
GROUP2184, 1/12/2021

Group member 1: Ana Bárbara Carvalho Barbosa, up201906704@up.pt <br>
Group member 2: Carolina Cintra Fernandes Figueira, up201906845@up.pt <br>
Group member 3: João Gabriel Ferreira Alves, up201810087@fc.up.pt <br>
Group member 4: Maria Eduarda Fornelos Dantas, up201709467@up.pt (Editor)
