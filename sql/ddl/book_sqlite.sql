--
-- Creating a very small Book table.
--



--
-- Table Book
--
DROP TABLE IF EXISTS Book;
CREATE TABLE Book (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "pic" TEXT NOT NULL,
    "Title" TEXT NOT NULL,
    "Author" TEXT NOT NULL
);
