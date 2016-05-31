<?php

namespace MArwelln;

use DB;

class Exists {
    /**
     * Table we want to work with.
     *
     * @var str
     */
    protected $table;

    /**
     * Where statements.
     *
     * @var array
     */
    protected $where = [];

    /**
     * Initialize a new query.
     *
     * @param str $table
     */
    public function __construct(string $table) {
        $this->table = $table;
    }

    /**
     * Make sure we can initialize a new instance with Class::table('table')->chain()
     *
     * @param  str $table
     *
     * @return self
     */
    public static function table(string $table) {
        return new static($table);
    }

    /**
     * WHERE field OPERATOR value statement.
     *
     * @param  str        $key
     * @param  mixed      $value
     * @param  str|string $operator
     *
     * @return self
     */
    public function where(string $key, $value, string $operator = '=') {
        $this->where[] = $key . ' ' . $operator . ' ' . DB::connection()->getPdo()->quote($value);

        return $this;
    }

    /**
     * WHERE field BETWEEN field1 AND field2 statement.
     *
     * @param  string $key
     * @param  string $field1
     * @param  string $field2
     *
     * @return self
     */
    public function whereBetween(string $key, string $field1, string $field2) {
        $this->where[] = $key . ' BETWEEN ' . DB::connection()->getPdo()->quote($field1) . ' AND ' . DB::connection()->getPdo()->quote($field2);

        return $this;
    }

    /**
     * Run the EXISTS query and return a boolean.
     *
     * SELECT EXISTS(SELECT 1 FROM table WHERE statements) AS `exists`
     *
     * @return bool
     */
    public function check() : bool {
        return DB::select(DB::raw("SELECT EXISTS(SELECT 1 FROM " . $this->table . " WHERE " . ($this->where ? implode(" AND ", $this->where) : '1') . ") AS `exists`"))[0]->exists;
    }
}