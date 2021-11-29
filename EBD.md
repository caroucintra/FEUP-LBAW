# EBD: Database Specification Component
This document corresponds to a specification of the elements in a database that stores all the information of an online auction service. The modularization was conceptualized to make every information independent from the rest of the database components.

## A4: Conceptual Data Model
The Identification and Description of Entities and Relationships that are Significant to the Database Specification are covered in the Conceptual Data Model.
The model is documented using a UML class diagram.
To avoid overloading the diagram too early in the development, the class diagram is built by first including only the classes and their relationships. More details, such as class attributes, attribute domains, multiplicity of relationships, and additional OCL restrictions, are incorporated in subsequent versions.

### 1. Class diagram

The key organizational entities, their relationships, attributes and their domains, and the multiplicity of relationships for the The Absolute Artion are presented in the UML diagram in Figure 1.

![Fig 1](/Pictures/UMLAbsoluteArtion.png)
*Figure 1 - UML Class Diagram*

Notes:
- Specification of relations between classes:
    1. Transactions will be between a user and the platform, whenever they need to cash in and out the website. Every transaction will need an admin's approval.
    2. A user can follow any other user and review the ones they won an auction from.
    3. A comment is made by a user on an auction.
    4. An auction is associated to one or more categories.
    5. Auctions have multiple followers and only one owner.
    6. Bids are made on a specific auction, by one user.
    7. Users are notified by different events: a new follower, a new auction created by someone they follow and a new comment, bid or action (approaching deadline, end of the auction) on an auction they follow.
- When an auction ends, the platform has access to its greatest bid (that is updated when a new bid is made), and through that, the bidder. That way, the necessary transactions between seller and buyer are safely performed.
- Users that will be notified on each event:
    1. New Bid: All auction's followers
    2. Auction Action: All auction's followers
    3. New Auction: All user's (auction owner) followers
    4. New Comment: All auction's followers
  
### 2. Additional Business Rules
Business rules can be included in the UML diagram as UML notes or in a table in this section.
- BR1: Authenticated User cannot bid on their own auction.
- BR2: The action of bidding is only done when the user has credit on their account and when the bid is validated, that money is secured so that that bidder can't spend it in other auctions. After a new bid on that specific auction, the money becomes free to spend. 
- BR3: The transactions between the site and the user are done through bank transfer and are only validated after an Admin has verify it. Those transfers are mainly: from the user's bank account to their own Absolute Artion credit and cashing out the credit they have accumulated.
- BR4: A user can become an auction follower if they have made an action on that auction (bidding or commenting) or manually.
- BR5: Auctions can be canceled by users (auction owner or admin) through specific conditions, but never deleted from the database.
- BR6: Only users who have won an auction can rate the auction's owner.
- BR7: Users cannot follow or rate themselves.
- BR8: Bids need to have a value greater than the greatest bid made for that auction or the initial price if it's the first bid.

## A5: Relational Schema, validation and schema refinement
The Relational Schema derived from the Conceptual Data Model is contained in this item. Each relation schema, attributes, domains, primary keys, foreign keys, and other integrity rules are all contained in the Relational Schema: UNIQUE, DEFAULT, NOT NULL, CHECK.

### 1. Relational Schema
| Relation Reference | Relation Compact Notation                                                                                                                           |
|--------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------|
| R01                |  Authenticated_User(id, email U NN, username U NN, password NN, Name NN, date_of_birth NN Today - date_of_birth >17 years, address, admin_permission NN, credit DF 0.00) |
| R02                |  Auction(id, initial_price NN, name NN, id_category -> category, deadline NN, greatest_bid NN)                                                      |
| R03                |  Image(id, image, id_auction -> Auction)                                                                                                |
| R04                |  Bid(id, id_Auction -> Auction value NN CK value > greatest_bid, id_user -> Authenticated_User)                                         |
| R05                |  Category(id, type IN category_name NN DF "Other")                                                                                                                                             |
| R06                |  Comment(id, text NN, date DF Today, id_user -> Authenticated_User, id_Auction -> Auction)                                                                                                           |
| R07                |  Transaction(id, value NN CK value > 0, method NN, type IN transaction_type NN, id_user -> Authenticated_User, id_user -> Admin_Permission NN CK True, id_Auction -> Auction  CK typeTransaction sell ou buy id_Auction NN)                                                                                                                     |
| R08                |  Notification(id, type IN notification_type NN, text NN, id_user -> Authenticated_User)                                                                                           |
| R09                |  Review(id, id_reviewed -> Authenticated_User, id_reviewer -> Authenticated_User, text DF "", rating >= 0 && <=5 DF 0)                                                                                        |


Legend:
U = UNIQUE
NN = NOT NULL
DF = DEFAULT
CK = CHECK.

### 2. Domains
The specification of the additional domain.

| Domain Name |	Domain Specification      |
|-------------|---------------------------|
| Today	      | DATE DEFAULT CURRENT_DATE |
| notification_type	      | ENUM ('New Follower', 'Auction Action', 'New Auction', 'New Bid', 'New Comment') |
| transaction_type	      | ENUM ('Sell', 'Buy', 'Deposit', 'Debit') |
| category_name	      | ENUM ('Clothing', 'Painting', 'Jewelry', 'Sculpture', 'Furniture', 'Accessories', 'Other') |

### 3. Schema validation
To validate the Relational Schema obtained from the Conceptual Model, all functional dependencies are identified and the normalization of all relation schemas is accomplished. Should it be necessary, in case the scheme is not in the Boyce–Codd Normal Form (BCNF), the relational schema is refined using normalization.

| **TABLE R01**                | Authenticated_User                                                                          |
|------------------------------|---------------------------------------------------------------------------------------------|
| **Keys:**                    | {id}, {email}                                                                               |
| **Functional Dependencies:** |                                                                                             |
| FD0101                       | {id} -> {email, username, password, Name, date_of_birth, address, admin_permission, credit} |
| FD0102                       | {email} -> {id, username, password, Name, date_of_birth, address, admin_permission, credit} |
| **Normal Form**              | BCNF                                                                                        |

| **TABLE R02**                | Auction                                                                                     |
|------------------------------|---------------------------------------------------------------------------------------------|
| **Keys:**                    | {id}, {email}                                                                               |
| **Functional Dependencies:** |                                                                                             |
| FD0201                       | {id} -> {email, username, password, Name, date_of_birth, address, admin_permission, credit} |
| FD0102                       | {email} -> {id, username, password, Name, date_of_birth, address, admin_permission, credit} |
| **Normal Form**              | BCNF                                                                                        |

| **TABLE R03**                | Image            |
|------------------------------|------------------|
| **Keys:**                    | {id, id_auction} |
| **Functional Dependencies:** |                  |
| FD0301                       | {id} -> {image}  |
| **Normal Form**              | BCNF             |


| **TABLE R04**                | Bid                       |
|------------------------------|---------------------------|
| **Keys:**                    | {id, id_Auction, id_user} |
| **Functional Dependencies:** |                           |
| FD0401                       | none                      |
| **Normal Form**              | BCNF                      |

| **TABLE R05**                | Category       |
|------------------------------|----------------|
| **Keys:**                    | {id}           |
| **Functional Dependencies:** |                |
| FD0501                       | {id} -> {type} |
| **Normal Form**              | BCNF           |

| **TABLE R06**                | Comment                   |
|------------------------------|---------------------------|
| **Keys:**                    | {id, id_user, id_Auction} |
| **Functional Dependencies:** |                           |
| FD0601                       | {id} -> {text, date}      |
| **Normal Form**              | BCNF                      |

| **TABLE R07**                | Transaction                   |
|------------------------------|-------------------------------|
| **Keys:**                    | {id, id_user, id_Auction}     |
| **Functional Dependencies:** |                               |
| FD0701                       | {id} -> {value, method, type} |
| **Normal Form**              | BCNF                          |

| **TABLE R08**                | Notification         |
|------------------------------|----------------------|
| **Keys:**                    | {id, id_user}        |
| **Functional Dependencies:** |                      |
| FD0801                       | {id} -> {type, text} |
| **Normal Form**              | BCNF                 |

| **TABLE R09**                | Review                 |
|------------------------------|------------------------|
| **Keys:**                    | {id, id_reviewed}      |
| **Functional Dependencies:** |                        |
| FD0901                       | {id} -> {text, rating} |
| **Normal Form**              | BCNF                   |
 
 
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

|Trigger |	TRIGGER01 |
|--------|------------|
|Description| Validates the bid attempt by checking if the bidder has enough money in his account. Corresponds to BR2.|
|SQL code	| 
    DROP FUNCTION IF EXISTS valid_bid();
    CREATE FUNCTION valid_bid() RETURNS TRIGGER AS
    $BODY$
    BEGIN

    IF (SELECT credit 
        FROM authenticated_user
        WHERE NEW.user_id = id) < NEW.bid_value THEN
    RAISE EXCEPTION 'The bidder does not have enough money in the account.';
    END IF;
    RETURN NEW;

    END
    $BODY$
    LANGUAGE plpgsql;

    CREATE TRIGGER valid_bid
    BEFORE INSERT OR UPDATE ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE valid_bid();

|Trigger |	TRIGGER02 |
|--------|------------|
|Description| Updates the greatest_bid whenever a new bid is made.|
|SQL code	| 
    DROP FUNCTION IF EXISTS greatest_bid_update();
    CREATE FUNCTION greatest_bid_update() RETURNS TRIGGER AS
    $BODY$
    BEGIN

    IF (EXISTS (SELECT * 
              FROM greatest_bid
              WHERE NEW.auction_id = auction_id)) THEN
    UPDATE greatest_bid
    SET bid_id = NEW.bid_id
    WHERE auction_id = NEW.auction_id;
	ELSE
    INSERT INTO greatest_bid(bid_id, auction_id) VALUES
        (NEW.id, NEW.auction_id);
    END IF;
    RETURN NEW;

    END
    $BODY$
    LANGUAGE plpgsql;

    CREATE TRIGGER greatest_bid_update
    AFTER INSERT ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE greatest_bid_update();

|Trigger |	TRIGGER03 |
|--------|------------|
|Description| Validates transactions between the platform and the user by making sure the admin involved in the deposit/debit has admin permissions. Corresponds to BR3.|
|SQL code	| 
    DROP FUNCTION IF EXISTS verify_admin();
    CREATE FUNCTION verify_admin() RETURNS TRIGGER AS
    $BODY$
    BEGIN

    IF (NEW.type = 'Deposit' OR NEW.type = 'Debit')
    AND NOT(SELECT admin_permission
          FROM authenticated_user
          WHERE id = NEW.admin_id) THEN
    RAISE EXCEPTION 'The transaction is not valid because there is no approval from a verified admin';
    
    END IF;
    RETURN NEW;

    END
    $BODY$
    LANGUAGE plpgsql;

    CREATE TRIGGER verify_admin
    BEFORE INSERT OR UPDATE ON money_transaction
    FOR EACH ROW
    EXECUTE PROCEDURE verify_admin();

|Trigger |	TRIGGER04 |
|--------|------------|
|Description| Checks if the value of the new bid is greater than the initial price and the value of the highest bid on that auction. Corresponds to BR8.|
|SQL code	| 
    DROP FUNCTION IF EXISTS valid_bid_value();
    CREATE FUNCTION valid_bid_value() RETURNS TRIGGER AS
    $BODY$
    BEGIN

    IF NEW.bid_value <= (SELECT initial_price
                        FROM auction
                        WHERE NEW.auction_id = id)
    OR NEW.bid_value <= (SELECT bid_value
                        FROM bid
                        WHERE id = (SELECT bid_id
                                    FROM greatest_bid 
                                    WHERE auction_id = NEW.auction_id))
    THEN RAISE EXCEPTION 'The new bid needs to be greater than the current greatest bid.';
    END IF;
    RETURN NEW;

    END
    $BODY$
    LANGUAGE plpgsql;

    CREATE TRIGGER valid_bid_value
    BEFORE INSERT OR UPDATE ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE valid_bid_value();

|Trigger |	TRIGGER05 |
|--------|------------|
|Description| Users who comment on an auction start following it automatically. Corresponds to BR4.|
|SQL code	| 
    DROP FUNCTION IF EXISTS follow_after_action();
    CREATE FUNCTION follow_after_action() RETURNS TRIGGER AS
    $BODY$
    BEGIN

    IF NOT EXISTS (SELECT *
                  FROM auction_follow
                  WHERE auction_id = NEW.auction_id AND NEW.user_id = user_id)
    THEN INSERT INTO auction_follow(follower_id, auction_id) VALUES
        (NEW.user_id, NEW.auction_id);
    END IF;
    RETURN NEW;

    END
    $BODY$
    LANGUAGE plpgsql;

    CREATE TRIGGER follow_after_comment
    AFTER INSERT OR UPDATE ON user_comment
    FOR EACH ROW
    EXECUTE PROCEDURE follow_after_action();

|Trigger |	TRIGGER06 |
|--------|------------|
|Description| Users who bid on an auction start following it automatically. Uses the same function declared for TRIGGER05 and also corresponds to BR4.|
|SQL code	| 

    CREATE TRIGGER follow_after_bid
    BEFORE INSERT OR UPDATE ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE follow_after_action();
    
<br>


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


**GROUP2184**, 08/11/2021

Group member 1: Ana Bárbara Carvalho Barbosa, up201906704@up.pt<br>
Group member 2: Carolina Cintra Fernandes Figueira, up201906845@up.pt<br>
Group member 3: João Gabriel Ferreira Alves, up201810087@fc.up.pt<br>
Group member 4: Maria Eduarda Fornelos Dantas, up201709467@up.pt (Editor)