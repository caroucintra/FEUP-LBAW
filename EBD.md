# EBD: Database Specification Component
This document corresponds to a specification of the elements in a database that stores all the information of an online auction service. The modularization was conceptualized to make every information independent from the rest of the database components.

## A4: Conceptual Data Model
The Identification and Description of Entities and Relationships that are Significant to the Database Specification are covered in the Conceptual Data Model.
The model is documented using a UML class diagram.
To avoid overloading the diagram too early in the development, the class diagram is built by first including only the classes and their relationships. More details, such as class attributes, attribute domains, multiplicity of relationships, and additional OCL restrictions, are incorporated in subsequent versions.

### 1. Class diagram

The key organizational entities, their relationships, attributes and their domains, and the multiplicity of relationships for the The Absolute Artion are presented in the UML diagram in Figure 1.

Fig 1

Notes:
- Especification of relations between classes:
    1. Transactions will be between a user and the platform, whenever they need to cash in and out the website. Every transaction will need an admin's approval.
    2. Users can follow and rate other users.
    3. A comment is made by a user on an auction.
    4. An auction is associated with exactly one item and that item can be associated to one or more categories.
    5. Auctions have multiple followers and only one owner.
    6. Bids are made on a specific auction, by one user.
- When an auction ends, the platform has access to its greatest bid (that is updated when a ned bid is made), and through that, the bidder.
- Users that will be notificated on each event:
    1. New Bid: All auction's followers
    2. Auction Action: All auction's followers
    3. New Auction: All user's (auction owner) followers
    4. New Comment: All auction's followers
  
### 2. Additional Business Rules
Business rules can be included in the UML diagram as UML notes or in a table in this section.
- BR1: Authenticated User cannot bid on their own auction.
- BR2: The action of bidding is only done when the user has credit on their account and when the bid is validated, that money is secured so that that bidder can't spend it in other auctions. After a new bid on that specific auction, the money becomes free to spend on other 
- BR3: The transactions between the site and the user are done through bank transfer and are only validated after an Admin has verify it. Those transfers are mainly: from the user's bank account to their own Absolute Artion credit and cashing out the credit they have accumulated.
- BR4: A user can become an auction follower if they have made an action on that auction (bidding or commenting) or manually.
- BR5: Auctions can be canceled by users (auction owner or admin) through specific conditions, but never deleted from the database.
- BR6: Only users who have won an auction can rate the auction's owner.
- BR7: Users cannot follow or rate themselves.

## A5: Relational Schema, validation and schema refinement
Brief presentation of the artefact goals.

### 1. Relational Schema
The Relational Schema includes the relation schemas, attributes, domains, primary keys, foreign keys and other integrity rules: UNIQUE, DEFAULT, NOT NULL, CHECK.
Relation schemas are specified in the compact notation:

Relation reference	Relation Compact Notation
R01	Table1(id, attribute NN)
R02	Table2(id, attribute → Table1 NN)
R03	Table3(id1, id2 → Table2, attribute UK NN)
R04	Table4((id1, id2) → Table3, id3, attribute CK attribute > 0)

### 2. Domains
The specification of additional domains can also be made in a compact form, using the notation:

Domain Name	Domain Specification
Today	DATE DEFAULT CURRENT_DATE
Priority	ENUM ('High', 'Medium', 'Low')

### 3. Schema validation
To validate the Relational Schema obtained from the Conceptual Model, all functional dependencies are identified and the normalization of all relation schemas is accomplished. Should it be necessary, in case the scheme is not in the Boyce–Codd Normal Form (BCNF), the relational schema is refined using normalization.

TABLE R01	User
Keys	{ id }, { email }
Functional Dependencies:	
FD0101	id → {email, name}
FD0102	email → {id, name}
...	...
NORMAL FORM	BCNF
If necessary, description of the changes necessary to convert the schema to BCNF.
Justification of the BCNF.

## A6: Indexes, triggers, transactions and database population
Brief presentation of the artefact goals.

### 1. Database Workload
A study of the predicted system load (database load). Estimate of tuples at each relation.

Relation reference	Relation Name	Order of magnitude	Estimated growth
R01	Table1	units	dozens
R02	Table2	units	dozens
R03	Table3	units	dozens
R04	Table4	units	dozens
### 2. Proposed Indices
## 2.1. Performance Indices
Indices proposed to improve performance of the identified queries.

Index	IDX01
Relation	Relation where the index is applied
Attribute	Attribute where the index is applied
Type	B-tree, Hash, GiST or GIN
Cardinality	Attribute cardinality: low/medium/high
Clustering	Clustering of the index
Justification	Justification for the proposed index
SQL code	
Analysis of the impact of the performance indices on specific queries. Include the execution plan before and after the use of indices.

Query	SELECT01
Description	One sentence describing the query goal
SQL code	
Execution Plan without indices	
Execution plan	
Execution Plan with indices	
Execution plan	
## 2.2. Full-text Search Indices
The system being developed must provide full-text search features supported by PostgreSQL. Thus, it is necessary to specify the fields where full-text search will be available and the associated setup, namely all necessary configurations, indexes definitions and other relevant details.

Index	IDX01
Relation	Relation where the index is applied
Attribute	Attribute where the index is applied
Type	B-tree, Hash, GiST or GIN
Clustering	Clustering of the index
Justification	Justification for the proposed index
SQL code	
### 3. Triggers
User-defined functions and trigger procedures that add control structures to the SQL language or perform complex computations, are identified and described to be trusted by the database server. Every kind of function (SQL functions, Stored procedures, Trigger procedures) can take base types, composite types, or combinations of these as arguments (parameters). In addition, every kind of function can return a base type or a composite type. Functions can also be defined to return sets of base or composite values.

Trigger	TRIGGER01
Description	Trigger description, including reference to the business rules involved
SQL code	
### 4. Transactions
Transactions needed to assure the integrity of the data.

SQL Reference	Transaction Name
Justification	Justification for the transaction.
Isolation level	Isolation level of the transaction.
Complete SQL Code	
Annex A. SQL Code
The database scripts are included in this annex to the EBD component.

The database creation script and the population script should be presented as separate elements. The creation script includes the code necessary to build (and rebuild) the database. The population script includes an amount of tuples suitable for testing and with plausible values for the fields of the database.

This code should also be included in the group's git repository and links added here.


### A.1. Database schema
### A.2. Database population

Revision history
Changes made to the first submission:


Group member 1 name, email (Editor)
Group member 2 name, email
...
