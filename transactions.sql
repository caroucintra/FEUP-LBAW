BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;

-- Get number of current loans
SELECT COUNT(*)
FROM loan
WHERE now() < end_t;

-- Get ending loans (limit 10)
SELECT loan.end_t, loan.start_t, item.*, work.*, users.id, users.name
FROM loan
INNER JOIN item ON item.id = loan.id_item
INNER JOIN work ON work.id = item.id_work
INNER JOIN users ON users.id = loan.id_users
WHERE now () < loan.end_t
ORDER BY loan.end_t ASC
LIMIT 10;

END TRANSACTION;