<?php

namespace App\Traits;

trait FullTextSearch
{
    /**
     * Replaces spaces with full text search wildcards
     *
     * @param string $term
     * @return string
     */
    protected function fullTextWildcards($term)
    {
        // removing symbols used by MySQL
        $reservedSymbols = ['-', '+', '<', '>', '@', '(', ')', '~'];
        $term = str_replace($reservedSymbols, '', $term);

        $words = explode(' ', $term);

        foreach ($words as $key => $word) {
            /*
             * applying + operator (required word) only big words
             * because smaller ones are not indexed by mysql
             */
            if (strlen($word) >= 1) {
                $words[$key] = '+' . $word . '*';
            }
        }

        $searchTerm = implode(' ', $words);

        return $searchTerm;
    }

    /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term
     * @return \Illuminate\Database\Eloquent\Builder
     */
    // public function scopeSearch($query, $term)
    // {
    //     $columns = implode(',', $this->searchable);

    //     $query->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($term));

    //     return $query;
    // }

    public function scopeFullTextSearch($query, $columns, $term, $select = '*')
   {
       $query->select($select)
       ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $this->fullTextWildcards($term));
    //    ->whereRaw("MATCH ({$columns}) AGAINST (? IN BOOLEAN MODE)", $term);

       return $query;
   }


   /**
     * Scope a query that matches a full text search of term.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $term Search term
     * @param array $columns Array of columns to request. Leave it empty to request all columns. Unavoidable in fulltext query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $term, $columns = [])
    {
        //List of columns to perform search on
        $search_columns = implode(',', array_column($this->searchable, 'column_name'));

        $searchableTerm = $this->fullTextWildcards($term);

        //Columns to select
        $columns_select_sql = '*';
        if (count($columns) > 0)
        {
            $columns_select_sql = implode(',', $columns);
        }

        //Initial fulltext query
        $query->selectRaw($columns_select_sql . ", MATCH ({$search_columns}) AGAINST (? IN BOOLEAN MODE) AS relevance_score", [$searchableTerm]);

        //Weighted relevance query
        $weighted_column_array = [];
        foreach ($this->searchable as $weighted_column) {
            array_push($weighted_column_array, $weighted_column['weight'] . ' * (MATCH (' . $weighted_column['column_name'] . ') AGAINST (?))');
        }
        $query->selectRaw( '(' . implode(' + ', $weighted_column_array) . ') as weighted_relevance_score', array_fill(0, count($this->searchable), $searchableTerm));

        //Fulltext match
        $query->whereRaw("MATCH ({$search_columns}) AGAINST (? IN BOOLEAN MODE)", $searchableTerm);

        return $query;
    }

}
