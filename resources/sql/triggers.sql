SET search_path TO lbaw2184;
-----------------------------------------
-- Triggers
-----------------------------------------

DROP FUNCTION IF EXISTS valid_bid();
CREATE FUNCTION valid_bid() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (SELECT credit
        FROM users
        WHERE NEW.user_id = id) < NEW.bid_value THEN
    RAISE EXCEPTION 'The bidder does not have enough money in the account.';
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER valid_bid
        BEFORE INSERT OR UPDATE ON bids
        FOR EACH ROW
        EXECUTE PROCEDURE valid_bid();

----------------------------------

DROP FUNCTION IF EXISTS greatest_bids_update();
CREATE FUNCTION greatest_bids_update() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (EXISTS (SELECT *
              FROM greatest_bids
              WHERE NEW.auction_id = auction_id)) THEN
    UPDATE greatest_bids
    SET bid_id = NEW.id
    WHERE auction_id = NEW.auction_id;
	ELSE
    INSERT INTO greatest_bids(bid_id, auction_id) VALUES
        (NEW.id, NEW.auction_id);
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER greatest_bids_update
        AFTER INSERT ON bids
        FOR EACH ROW
        EXECUTE PROCEDURE greatest_bids_update();

----------------------------------

DROP FUNCTION IF EXISTS valid_bid_value();
CREATE FUNCTION valid_bid_value() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NEW.bid_value <= (SELECT initial_price
                        FROM auctions
                        WHERE NEW.auction_id = id)
    OR NEW.bid_value <= (SELECT bid_value
                        FROM bids
                        WHERE id = (SELECT bid_id
                                    FROM greatest_bids
                                    WHERE auction_id = NEW.auction_id))
    THEN RAISE EXCEPTION 'The new bid needs to be greater than the current greatest bid.';
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER valid_bid_value
        BEFORE INSERT OR UPDATE ON bids
        FOR EACH ROW
        EXECUTE PROCEDURE valid_bid_value();

----------------------------------

DROP FUNCTION IF EXISTS follow_after_action();
CREATE FUNCTION follow_after_action() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NOT EXISTS (SELECT *
                  FROM auction_follow
                  WHERE auction_id = NEW.auction_id AND NEW.user_id = user_id)
    THEN INSERT INTO auction_follow(user_id, auction_id) VALUES
        (NEW.user_id, NEW.auction_id);
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER follow_after_comment
        AFTER INSERT OR UPDATE ON comments
        FOR EACH ROW
        EXECUTE PROCEDURE follow_after_action();


CREATE TRIGGER follow_after_bid
        BEFORE INSERT OR UPDATE ON bids
        FOR EACH ROW
        EXECUTE PROCEDURE follow_after_action();

----------------------------------

DROP FUNCTION IF EXISTS verify_admin();
CREATE FUNCTION verify_admin() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (NEW.type = 'Deposit' OR NEW.type = 'Debit')
    AND NOT(SELECT admin_permission
          FROM users
          WHERE id = NEW.admin_id) THEN
    RAISE EXCEPTION 'The transaction is not valid because there is no approval from a verified admin';

    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER verify_admin
        BEFORE INSERT OR UPDATE ON money_transactions
        FOR EACH ROW
        EXECUTE PROCEDURE verify_admin();

----------------------------------

DROP FUNCTION IF EXISTS notify_new_comment();
CREATE FUNCTION notify_new_comment() RETURNS TRIGGER AS
$BODY$
DECLARE
    f auction_follow%rowtype;
BEGIN

    FOR f IN (SELECT *
             FROM auction_follow
             WHERE auction_id = NEW.auction_id)
    LOOP
    IF (f.user_id <> NEW.user_id)
        THEN INSERT INTO notifications(user_id, type, comment_id) VALUES
        (f.user_id, 'New Comment', NEW.id);
    END IF;
	END LOOP;

    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_new_comment
        AFTER INSERT OR UPDATE ON comments
        FOR EACH ROW
        EXECUTE PROCEDURE notify_new_comment();

----------------------------------

DROP FUNCTION IF EXISTS notify_new_bid();
CREATE FUNCTION notify_new_bid() RETURNS TRIGGER AS
$BODY$
DECLARE
    f auction_follow%rowtype;
BEGIN

    FOR f IN (SELECT *
             FROM auction_follow
             WHERE auction_id = NEW.auction_id)
    LOOP
    IF (f.user_id <> NEW.user_id)
        THEN INSERT INTO notifications(user_id, type, bid_id) VALUES
            (f.user_id, 'New Bid', NEW.id);
    END IF;
	END LOOP;

    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_new_bid
        AFTER INSERT OR UPDATE ON bids
        FOR EACH ROW
        EXECUTE PROCEDURE notify_new_bid();

----------------------------------

DROP FUNCTION IF EXISTS notify_new_auction();
CREATE FUNCTION notify_new_auction() RETURNS TRIGGER AS
$BODY$
DECLARE
    f user_follow%rowtype;
BEGIN

    FOR f IN (SELECT *
             FROM user_follow
             WHERE followed_id = NEW.user_id)
    LOOP
        INSERT INTO notifications(user_id, type, auction_id) VALUES
        (f.follower_id, 'New Auction', NEW.id);
	END LOOP;

    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_new_auction
        AFTER INSERT OR UPDATE ON auctions
        FOR EACH ROW
        EXECUTE PROCEDURE notify_new_auction();

----------------------------------

DROP FUNCTION IF EXISTS notify_new_follower();
CREATE FUNCTION notify_new_follower() RETURNS TRIGGER AS
$BODY$
BEGIN

    INSERT INTO notifications(user_id, type, follower_id) VALUES
        (NEW.followed_id, 'New Follower', NEW.follower_id);

    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_new_follower
        AFTER INSERT OR UPDATE ON user_follow
        FOR EACH ROW
        EXECUTE PROCEDURE notify_new_follower();

----------------------------------

DROP FUNCTION IF EXISTS perform_transaction();
CREATE FUNCTION perform_transaction() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF (NEW.type = 'Deposit')
    THEN UPDATE users
        SET credit = credit + NEW.transaction_value
        WHERE id = NEW.user_id;

    ELSIF (NEW.type = 'Debit')
    THEN UPDATE users
        SET credit = credit - NEW.transaction_value
        WHERE id = NEW.user_id;
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER perform_transaction
        AFTER INSERT OR UPDATE ON money_transactions
        FOR EACH ROW
        EXECUTE PROCEDURE perform_transaction();

----------------------------------
