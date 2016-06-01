# Installation

    composer require marwelln/exists:~1.0

# Usage

    $exists = Marwelln\Exists::table('mytable')->where('statement', 'value')->check(); // true or false

    $exists = (new Marwelln\Exists('mytable'))->where('statement', 'value')->check(); // true or false

# Available methods

    static table(string $table)

Sets the table we want to run `EXISTS` with. Can use constructor instead if wanted.

    where(string $key, mixed $value, string $operator = '=') // WHERE key {$operator} value

    whereBetween(string $key, string $field1, string $field2) // WHERE key BETWEEN field1 AND field2

    whereNull(string $key) // WHERE key IS NULL

    whereNotNull(string $key) // WHERE key IS NOT NULL

Add `WHERE` statements. This can be chained.

    check()
    // SELECT EXISTS(SELECT 1 FROM table WHERE statements) AS `exists`

Run the query. Will return `true` or `false` depending on if the row existed or not.
