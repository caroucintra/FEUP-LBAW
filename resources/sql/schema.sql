SET search_path TO lbaw2184;
create schema if not exists lbaw2184;
-----------------------------------------
-- Types
-----------------------------------------
DROP TABLE IF EXISTS money_transaction CASCADE;
DROP TABLE IF EXISTS images CASCADE;
DROP TYPE IF EXISTS category_name CASCADE;
DROP TYPE IF EXISTS notification_type CASCADE;
DROP TYPE IF EXISTS admin_request_type CASCADE;
DROP TYPE IF EXISTS transaction_type CASCADE;
CREATE TYPE category_name AS ENUM ('Clothing', 'Painting', 'Jewelry', 'Sculpture', 'Furniture', 'Accessories', 'Other');
CREATE TYPE notification_type AS ENUM ('New Follower', 'Auction Action', 'New Auction', 'New Bid', 'New Comment');
CREATE TYPE transaction_type AS ENUM ('Sell', 'Buy', 'Deposit', 'Debit');
CREATE TYPE admin_request_type AS ENUM ('Deposit', 'Debit', 'Report');

-----------------------------------------
-- Tables
-----------------------------------------

DROP TABLE IF EXISTS users CASCADE;
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email TEXT NOT NULL UNIQUE,
    username TEXT UNIQUE,
    name TEXT NOT NULL,
    remember_token VARCHAR,
    password TEXT NOT NULL,
    img TEXT DEFAULT 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png',
    about TEXT DEFAULT 'About Me',
    date_of_birth DATE,        -- '2021-12-01'
    admin_permission BOOLEAN DEFAULT FALSE,
    credit FLOAT DEFAULT 0,
    user_address TEXT,
    rating FLOAT DEFAULT 0,

    CONSTRAINT minimum_age check (
        (date_part('year',now()- date_of_birth) +
        date_part('month',now()- date_of_birth)/12 +
        date_part('day',now()- date_of_birth)/365
        ) > 17)
);

DROP TABLE IF EXISTS user_follow CASCADE;
CREATE TABLE user_follow (
    id SERIAL PRIMARY KEY,
    follower_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    followed_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE

);

DROP TABLE IF EXISTS auctions CASCADE;
CREATE TABLE auctions (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    initial_price FLOAT NOT NULL,
    deadline TIMESTAMP NOT NULL,         -- TIMESTAMP '2004-10-19 10:23:54'
    description TEXT NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE

   -- CONSTRAINT valid_deadline check (
   --     (date_part('month',deadline-now())*43800+
   --     date_part('day',deadline-now())*1440+
   --     date_part('hour',deadline-now())*60+
   --     date_part('minute',deadline-now())
   --     ) > 30)
);

DROP TABLE IF EXISTS auction_follow CASCADE;
CREATE TABLE auction_follow (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE

);

DROP TABLE IF EXISTS categories CASCADE;
CREATE TABLE categories (
    id SERIAL PRIMARY KEY,
    auction_id INTEGER NOT NULL REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE,
    TYPE category_name DEFAULT 'Other'
);

DROP TABLE IF EXISTS bids CASCADE;
CREATE TABLE bids (
    id SERIAL PRIMARY KEY,
    bid_value FLOAT NOT NULL,
    bid_date TIMESTAMP DEFAULT now(),
    winner BOOL DEFAULT FALSE,

    auction_id INTEGER NOT NULL REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE
);

 DROP TABLE IF EXISTS greatest_bids CASCADE;
 CREATE TABLE greatest_bids (
    bid_id INTEGER NOT NULL REFERENCES bids(id) ON UPDATE CASCADE ON DELETE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE,

    PRIMARY KEY (bid_id, auction_id)
);

DROP TABLE IF EXISTS comments CASCADE;
CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE,
    comment_text TEXT NOT NULL,
    comment_date TIMESTAMP DEFAULT now()
);

DROP TABLE IF EXISTS money_transactions CASCADE;
CREATE TABLE money_transactions (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    admin_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    transaction_value FLOAT NOT NULL,
    TYPE transaction_type NOT NULL,
    auction_id INTEGER REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE,

    CONSTRAINT minimum_transaction check (transaction_value > 0),
	CONSTRAINT valid_transaction check (
        ((type in ('Sell', 'Buy')) AND NOT(auction_id IS NULL)) OR
        ((type in ('Deposit', 'Debit')) AND NOT(admin_id IS NULL))
	)
);

DROP TABLE IF EXISTS images CASCADE;
CREATE TABLE images (
    id SERIAL PRIMARY KEY,
    address TEXT UNIQUE,
    auction_id INTEGER NOT NULL REFERENCES auctions(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS notifications CASCADE;
CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    type notification_type NOT NULL,
    auction_id INTEGER REFERENCES auctions(id) ON UPDATE CASCADE ON DELETE CASCADE,
    follower_id INTEGER REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
    comment_id INTEGER REFERENCES comments(id) ON UPDATE CASCADE ON DELETE CASCADE,
    bid_id INTEGER REFERENCES bids(id),
    notification_date TIMESTAMP DEFAULT now(),
    seen BOOLEAN DEFAULT FALSE,

    CONSTRAINT valid_notification check (
        ((type IN ('New Follower')) AND NOT(follower_id IS NULL)) OR
        ((type IN ('Auction Action')) AND NOT(auction_id IS NULL)) OR
        ((type IN ('New Bid')) AND NOT(bid_id IS NULL)) OR
        ((type IN ('New Comment')) AND NOT(comment_id IS NULL)) OR
        ((type IN ('New Auction')) AND NOT(auction_id IS NULL))
    )
);

DROP TABLE IF EXISTS admin_requests CASCADE;
CREATE TABLE admin_requests (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    type admin_request_type NOT NULL,
    admin_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    amount FLOAT,
    auction_id INTEGER REFERENCES auctions(id) ON UPDATE CASCADE,
    seen BOOLEAN DEFAULT FALSE,

    CONSTRAINT valid_notification check (
        ((type IN ('Deposit')) AND NOT(amount IS NULL)) OR
        ((type IN ('Debit')) AND NOT(amount IS NULL)) OR
        ((type IN ('Report')) AND NOT(auction_id IS NULL))
    )

);

DROP TABLE IF EXISTS review CASCADE;
CREATE TABLE review (
    id SERIAL PRIMARY KEY,
    id_reviewer INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    id_reviewed INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    review_text TEXT DEFAULT '',
    rating INTEGER DEFAULT 0,

    CONSTRAINT valid_rating check ((rating > -1) AND (rating < 6))
);
