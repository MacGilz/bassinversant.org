<?php
class File_CSV_DataSource
{
    public
    $settings = array(
        'delimiter' => ',',
        'eol' => ";",
        'length' => 999999,
        'escape' => '"'
    );

    protected

    /**
     * imported data from csv
     *
     * @var array
     * @access protected
     */
    $rows = array(),

    /**
     * csv file to parse
     *
     * @var string
     * @access protected
     */
    $_filename = '',

    /**
     * csv headers to parse
     *
     * @var array
     * @access protected
     */
    $headers = array();

    /**
     * data load initialize
     *
     * @param mixed $filename please look at the load() method
     *
     * @access public
     * @see load()
     * @return void
     */
    public function __construct($filename = null)
    {
        $this->load($filename);
    }

    /**
     * csv file loader
     *
     * indicates the object which file is to be loaded
     *
     * <strong>
     *
     *   require_once 'File/CSV/DataSource.php';
     *
     *   $csv = new File_CSV_DataSource;
     *   $csv->load('my_cool.csv');
     *   var_export($csv->connect());
     *
     *   array (
     *     0 =>
     *     array (
     *       'name' => 'john',
     *       'age' => '13',
     *       'skill' => 'knows magic',
     *     ),
     *     1 =>
     *     array (
     *       'name' => 'tanaka',
     *       'age' => '8',
     *       'skill' => 'makes sushi',
     *     ),
     *     2 =>
     *     array (
     *       'name' => 'jose',
     *       'age' => '5',
     *       'skill' => 'dances salsa',
     *     ),
     *   )
     *
     * </strong>
     *
     * @param string $filename the csv filename to load
     *
     * @access public
     * @return boolean true if file was loaded successfully
     * @see isSymmetric(), getAsymmetricRows(), symmetrize()
     */
    public function load($filename)
    {
        $this->_filename = $filename;
        $this->flush();
        return $this->parse();
    }

    /**
     * settings alterator
     *
     * lets you define different settings for scanning
     *
     * Given array will override the internal settings
     *
     * <strong>
     *  $settings = array(
     *      'delimiter' => ',',
     *      'eol' => ";",
     *      'length' => 999999,
     *      'escape' => '"'
     *  );
     * </strong>
     *
     * @param mixed $array containing settings to use
     *
     * @access public
     * @return boolean true if changes where applyed successfully
     * @see $settings
     */
    public function settings($array)
    {
        $this->settings = array_merge($this->settings, $array);
    }

    /**
     * header fetcher
     *
     * gets csv headers into an array
     *
     * <strong>
     *
     *   var_export($csv->getHeaders());
     *
     *   array (
     *     0 => 'name',
     *     1 => 'age',
     *     2 => 'skill',
     *   )
     *
     * </strong>
     *
     * @access public
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * header counter
     *
     * retrives the total number of loaded headers
     *
     * @access public
     * @return integer gets the length of headers
     */
    public function countHeaders()
    {
        return count($this->headers);
    }

    /**
     * header and row relationship builder
     *
     * Attempts to create a relationship for every single cell that
     * was captured and its corresponding header. The sample below shows
     * how a connection/relationship is built.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * php implementation
     *
     * <strong>
     *
     *  $csv = new File_CSV_DataSource;
     *  $csv->load('my_cool.csv');
     *
     *  if (!$csv->isSymmetric()) {
     *      die('file has headers and rows with different lengths
     *      cannot connect');
     *  }
     *
     *  var_export($csv->connect());
     *
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => '8',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     *
     * </strong>
     *
     *
     * You can pass a collection of headers in an array to build
     * a connection for those columns only!
     *
     * <strong>
     *
     *  var_export($csv->connect(array('age')));
     *
     *  array (
     *    0 =>
     *    array (
     *      'age' => '13',
     *    ),
     *    1 =>
     *    array (
     *      'age' => '8',
     *    ),
     *    2 =>
     *    array (
     *      'age' => '5',
     *    ),
     *  )
     *
     * </strong>
     *
     * @param array $columns the columns to connect, if nothing
     * is given all headers will be used to create a connection
     *
     * @access public
     * @return array If the data is not symmetric an empty array
     * will be returned instead
     * @see isSymmetric(), getAsymmetricRows(), symmetrize(), getHeaders()
     */
    public function connect($columns = array())
    {
        if (!$this->isSymmetric()) {
            return array();
        }
        if (!is_array($columns)) {
            return array();
        }
        if ($columns === array()) {
  	         $columns = $this->headers;
        }

        $ret_arr	 		= array();
	
	 	$complete_array 	=		array_merge( $this->headers , $this->rows);

		$it =  new RecursiveIteratorIterator(new RecursiveArrayIterator($complete_array));
		$raw_array = iterator_to_array($it, false);
		foreach($raw_array as $key =>  $value){
				if(!empty($value) && is_email($value)){
					$ret_arr[] = $value;
					}
			}
        return $ret_arr;
    }

    /**
     * data length/symmetry checker
     *
     * tells if the headers and all of the contents length match.
     * Note: there is a lot of methods that won't work if data is not
     * symmetric this method is very important!
     *
     * @access public
     * @return boolean
     * @see symmetrize(), getAsymmetricRows(), isSymmetric()
     */
    public function isSymmetric()
    {
        $hc = count($this->headers);
        foreach ($this->rows as $row) {
            if (count($row) != $hc) {
                return false;
            }
        }
        return true;
    }

    /**
     * asymmetric data fetcher
     *
     * finds the rows that do not match the headers length
     *
     * lets assume that we add one more row to our csv file.
     * that has only two values. Something like
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     *   niki,6
     * </strong>
     *
     * Then in our php code
     *
     * <strong>
     *   $csv->load('my_cool.csv');
     *   var_export($csv->getAsymmetricRows());
     * </strong>
     *
     * The result
     *
     * <strong>
     *
     *   array (
     *     0 =>
     *     array (
     *       0 => 'niki',
     *       1 => '6',
     *     ),
     *   )
     *
     * </strong>
     *
     * @access public
     * @return array filled with rows that do not match headers
     * @see getHeaders(), symmetrize(), isSymmetric(),
     * getAsymmetricRows()
     */
    public function getAsymmetricRows()
    {
        $ret_arr = array();
        $hc      = count($this->headers);
        foreach ($this->rows as $row) {
            if (count($row) != $hc) {
                $ret_arr[] = $row;
            }
        }
        return $ret_arr;
    }

    /**
     * all rows length equalizer
     *
     * makes the length of all rows and headers the same. If no $value is given
     * all unexistent cells will be filled with empty spaces
     *
     * @param mixed $value the value to fill the unexistent cells
     *
     * @access public
     * @return array
     * @see isSymmetric(), getAsymmetricRows(), symmetrize()
     */
    public function symmetrize($value = '')
    {
        $max_length = 0;
        $headers_length = count($this->headers);

        foreach ($this->rows as $row) {
            $row_length = count($row);
            if ($max_length < $row_length) {
                $max_length = $row_length;
            }
        }

        if ($max_length < $headers_length) {
            $max_length = $headers_length;
        }

        foreach ($this->rows as $key => $row) {
            $this->rows[$key] = array_pad($row, $max_length, $value);
        }

        $this->headers = array_pad($this->headers, $max_length, $value);
    }

    /**
     * grid walker
     *
     * travels through the whole dataset executing a callback per each
     * cell
     *
     * Note: callback functions get the value of the cell as an
     * argument, and whatever that callback returns will be used to
     * replace the current value of that cell.
     *
     * @param string $callback the callback function to be called per
     * each cell in the dataset.
     *
     * @access public
     * @return void
     * @see walkColumn(), walkRow(), fillColumn(), fillRow(), fillCell()
     */
    public function walkGrid($callback)
    {
        foreach (array_keys($this->getRows()) as $key) {
            if (!$this->walkRow($key, $callback)) {
                return false;
            }
        }
        return true;
    }

    /**
     * column fetcher
     *
     * gets all the data for a specific column identified by $name
     *
     * Note $name is the same as the items returned by getHeaders()
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * php implementation
     *
     * <strong>
     *   $csv = new File_CSV_DataSource;
     *   $csv->load('my_cool.csv');
     *   var_export($csv->getColumn('name'));
     * </strong>
     *
     * the above example outputs something like
     *
     * <strong>
     *
     *   array (
     *     0 => 'john',
     *     1 => 'tanaka',
     *     2 => 'jose',
     *   )
     *
     * </strong>
     *
     * @param string $name the name of the column to fetch
     *
     * @access public
     * @return array filled with values of a column
     * @see getHeaders(), fillColumn(), appendColumn(), getCell(), getRows(),
     * getRow(), hasColumn()
     */
    public function getColumn($name)
    {
        if (!in_array($name, $this->headers)) {
            return array();
        }
        $ret_arr = array();
        $key     = array_search($name, $this->headers, true);
        foreach ($this->rows as $data) {
            $ret_arr[] = $data[$key];
        }
        return $ret_arr;
    }

    /**
     * column existance checker
     *
     * checks if a column exists, columns are identified by their
     * header name.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * php implementation
     *
     * <strong>
     *   $csv = new File_CSV_DataSource;
     *   $csv->load('my_cool.csv');
     *   $headers = $csv->getHeaders();
     * </strong>
     *
     * now lets check if the columns exist
     *
     * <strong>
     *   var_export($csv->hasColumn($headers[0]));    // true
     *   var_export($csv->hasColumn('age'));          // true
     *   var_export($csv->hasColumn('I dont exist')); // false
     * </strong>
     *
     * @param string $string an item returned by getHeaders()
     *
     * @access public
     * @return boolean
     * @see getHeaders()
     */
    public function hasColumn($string)
    {
        return in_array($string, $this->headers);
    }

    /**
     * column appender
     *
     * Appends a column and each or all values in it can be
     * dinamically filled. Only when the $values argument is given.
     * <strong>
     *
     *
     *  var_export($csv->fillColumn('age', 99));
     *  true
     *
     *  var_export($csv->appendColumn('candy_ownership', array(99, 44, 65)));
     *  true
     *
     *  var_export($csv->appendColumn('import_id', 111111111));
     *  true
     *
     *  var_export($csv->connect());
     *
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => 99,
     *      'skill' => 'knows magic',
     *      'candy_ownership' => 99,
     *      'import_id' => 111111111,
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => 99,
     *      'skill' => 'makes sushi',
     *      'candy_ownership' => 44,
     *      'import_id' => 111111111,
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => 99,
     *      'skill' => 'dances salsa',
     *      'candy_ownership' => 65,
     *      'import_id' => 111111111,
     *    ),
     *  )
     *
     * </strong>
     *
     * @param string $column an item returned by getHeaders()
     * @param mixed  $values same as fillColumn()
     *
     * @access public
     * @return boolean
     * @see getHeaders(), fillColumn(), fillCell(), createHeaders(),
     * setHeaders()
     */
    public function appendColumn($column, $values = null)
    {
        if ($this->hasColumn($column)) {
            return false;
        }
        $this->headers[] = $column;
        $length          = $this->countHeaders();
        $rows            = array();

        foreach ($this->rows as $row) {
            $rows[] = array_pad($row, $length, '');
        }

        $this->rows = $rows;

        if ($values === null) {
            $values = '';
        }

        return $this->fillColumn($column, $values);
    }

    /**
     * collumn data injector
     *
     * fills alll the data in the given column with $values
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * php implementation
     *
     * <strong>
     *   $csv = new File_CSV_DataSource;
     *   $csv->load('my_cool.csv');
     *
     *   // if the csv file loads
     *   if ($csv->load('my_cool.csv')) {
     *
     *      // grab all data within the age column
     *      var_export($csv->getColumn('age'));
     *
     *      // rename all values in it with the number 99
     *      var_export($csv->fillColumn('age', 99));
     *
     *      // grab all data within the age column
     *      var_export($csv->getColumn('age'));
     *
     *      // rename each value in a column independently
     *      $data = array(1, 2, 3);
     *      $csv->fillColumn('age', $data);
     *
     *      var_export($csv->getColumn('age'));
     *   }
     * </strong>
     *
     * standard output
     *
     * <strong>
     *   array (
     *     0 => '13',
     *     1 => '8',
     *     2 => '5',
     *   )
     * </strong>
     *
     * <strong>
     *   true
     * </strong>
     *
     * <strong>
     *   array (
     *     0 => 99,
     *     1 => 99,
     *     2 => 99,
     *   )
     * </strong>
     *
     * <strong>
     *   array (
     *     0 => 1,
     *     1 => 2,
     *     2 => 3,
     *   )
     * </strong>
     *
     * @param mixed $column the column identified by a string
     * @param mixed $values ither one of the following
     *  - (Number) will fill the whole column with the value of number
     *  - (String) will fill the whole column with the value of string
     *  - (Array) will fill the while column with the values of array
     *    the array gets ignored if it does not match the length of rows
     *
     * @access public
     * @return void
     */
    public function fillColumn($column, $values = null)
    {
        if (!$this->hasColumn($column)) {
            return false;
        }

        if ($values === null) {
            return false;
        }

        if (!$this->isSymmetric()) {
            return false;
        }

        $y = array_search($column, $this->headers);

        if (is_numeric($values) || is_string($values)) {
            foreach (range(0, $this->countRows() -1) as $x) {
                $this->fillCell($x, $y, $values);
            }
            return true;
        }

        if ($values === array()) {
            return false;
        }

        $length = $this->countRows();
        if (is_array($values) && $length == count($values)) {
            for ($x = 0; $x < $length; $x++) {
                $this->fillCell($x, $y, $values[$x]);
            }
            return true;
        }

        return false;
    }

    /**
     * column remover
     *
     * Completly removes a whole column identified by $name
     * Note: that this function will only work if data is symmetric.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * load the library and csv file
     *
     * <strong>
     *  require_once 'File/CSV/DataSource.php';
     *  $csv = new File_CSV_DataSource;
     *  $csv->load('my_cool.csv');
     * </strong>
     *
     * lets dump currently loaded data
     * <strong>
     *  var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => '8',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * and now let's remove the second column
     *
     * <strong>
     *  var_export($csv->removeColumn('age'));
     * </strong>
     *
     * output
     *
     * <strong>
     *  true
     * </strong>
     *
     * those changes made let's dump the data again and see what we got
     *
     * <strong>
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * @param string $name same as the ones returned by getHeaders();
     *
     * @access public
     * @return boolean
     * @see hasColumn(), getHeaders(), createHeaders(), setHeaders(),
     * isSymmetric(), getAsymmetricRows()
     */
    public function removeColumn($name)
    {
        if (!in_array($name, $this->headers)) {
            return false;
        }

        if (!$this->isSymmetric()) {
            return false;
        }

        $key = array_search($name, $this->headers);
        unset($this->headers[$key]);
        $this->resetKeys($this->headers);

        foreach ($this->rows as $target => $row) {
            unset($this->rows[$target][$key]);
            $this->resetKeys($this->rows[$target]);
        }

        return $this->isSymmetric();
    }

    /**
     * column walker
     *
     * goes through the whole column and executes a callback for each
     * one of the cells in it.
     *
     * Note: callback functions get the value of the cell as an
     * argument, and whatever that callback returns will be used to
     * replace the current value of that cell.
     *
     * @param string $name     the header name used to identify the column
     * @param string $callback the callback function to be called per
     * each cell value
     *
     * @access public
     * @return boolean
     * @see getHeaders(), fillColumn(), appendColumn()
     */
    public function walkColumn($name, $callback)
    {
        if (!$this->isSymmetric()) {
            return false;
        }

        if (!$this->hasColumn($name)) {
            return false;
        }

        if (!function_exists($callback)) {
            return false;
        }

        $column = $this->getColumn($name);
        foreach ($column as $key => $cell) {
            $column[$key] = $callback($cell);
        }
        return $this->fillColumn($name, $column);
    }

    public function getCell($x, $y)
    {
        if ($this->hasCell($x, $y)) {
            $row = $this->getRow($x);
            return $row[$y];
        }
        return false;
    }

  
    public function fillCell($x, $y, $value)
    {
        if (!$this->hasCell($x, $y)) {
            return false;
        }
        $row            = $this->getRow($x);
        $row[$y]        = $value;
        $this->rows[$x] = $row;
        return true;
    }

   
    public function hasCell($x, $y)
    {
        $has_x = array_key_exists($x, $this->rows);
        $has_y = array_key_exists($y, $this->headers);
        return ($has_x && $has_y);
    }

    
    public function getRow($number)
    {
        $raw = $this->rows;
        if (array_key_exists($number, $raw)) {
            return $raw[$number];
        }
        return array();
    }

   
    public function getRows($range = array())
    {
        if (is_array($range) && ($range === array())) {
            return $this->rows;
        }

        if (!is_array($range)) {
            return $this->rows;
        }

        $ret_arr = array();
        foreach ($this->rows as $key => $row) {
            if (in_array($key, $range)) {
                $ret_arr[] = $row;
            }
        }
        return $ret_arr;
    }

   
    public function countRows()
    {
        return count($this->rows);
    }

    public function appendRow($values)
    {
        $this->rows[] = array();
        $this->symmetrize();
        return $this->fillRow($this->countRows() - 1, $values);
    }

   
    public function fillRow($row, $values)
    {
        if (!$this->hasRow($row)) {
            return false;
        }

        if (is_string($values) || is_numeric($values)) {
            foreach ($this->rows[$row] as $key => $cell) {
                 $this->rows[$row][$key] = $values;
            }
            return true;
        }

        $eql_to_headers = ($this->countHeaders() == count($values));
        if (is_array($values) && $this->isSymmetric() && $eql_to_headers) {
            $this->rows[$row] = $values;
            return true;
        }

        return false;
    }

    /**
     * row existance checker
     *
     * Scans currently loaded dataset and
     * checks if a given row identified by $number exists
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * load library and csv file
     *
     * <strong>
     *  require_once 'File/CSV/DataSource.php';
     *  $csv = new File_CSV_DataSource;
     *  $csv->load('my_cool.csv');
     * </strong>
     *
     * build a relationship and dump it so we can see the rows we will
     * be working with
     *
     * <strong>
     *   var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>  // THIS ROW EXISTS!!!
     *    array (
     *      'name' => 'tanaka',
     *      'age' => '8',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * now lets check for row existance
     *
     * <strong>
     *  var_export($csv->hasRow(1));
     *  var_export($csv->hasRow(-1));
     *  var_export($csv->hasRow(9999));
     * </strong>
     *
     * output
     *
     * <strong>
     *  true
     *  false
     *  false
     * </strong>
     *
     * @param mixed $number a numeric value that identifies the row
     * you are trying to fetch.
     *
     * @access public
     * @return boolean
     * @see getRow(), getRows(), appendRow(), fillRow()
     */
    public function hasRow($number)
    {
        return (in_array($number, array_keys($this->rows)));
    }

    /**
     * row remover
     *
     * removes one row from the current data set.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * first let's load the file and output whatever was retrived.
     *
     * <strong>
     *  require_once 'File/CSV/DataSource.php';
     *  $csv = new File_CSV_DataSource;
     *  $csv->load('my_cool.csv');
     *  var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => '8',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * now lets remove the second row
     *
     * <strong>
     *  var_export($csv->removeRow(1));
     * </strong>
     *
     * output
     *
     * <strong>
     *  true
     * </strong>
     *
     * now lets dump again the data and see what changes have been
     * made
     *
     * <strong>
     *  var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * @param mixed $number the key that identifies that row
     *
     * @access public
     * @return boolean
     * @see hasColumn(), getHeaders(), createHeaders(), setHeaders(),
     * isSymmetric(), getAsymmetricRows()
     */
    public function removeRow($number)
    {
        $cnt = $this->countRows();
        $row = $this->getRow($number);
        if (is_array($row) && ($row != array())) {
            unset($this->rows[$number]);
        } else {
            return false;
        }
        $this->resetKeys($this->rows);
        return ($cnt == ($this->countRows() + 1));
    }

    /**
     * row walker
     *
     * goes through one full row of data and executes a callback
     * function per each cell in that row.
     *
     * Note: callback functions get the value of the cell as an
     * argument, and whatever that callback returns will be used to
     * replace the current value of that cell.
     *
     * @param string|integer $row      anything that is numeric is a valid row
     * identificator. As long as it is within the range of the currently
     * loaded dataset
     *
     * @param string         $callback the callback function to be executed
     * per each cell in a row
     *
     * @access public
     * @return boolean
     *  - false if callback does not exist
     *  - false if row does not exits
     */
    public function walkRow($row, $callback)
    {
        if (!function_exists($callback)) {
            return false;
        }
        if ($this->hasRow($row)) {
            foreach ($this->getRow($row) as $key => $value) {
                $this->rows[$row][$key] = $callback($value);
            }
            return true;
        }
        return false;
    }

    /**
     * raw data as array
     *
     * Gets the data that was retrived from the csv file as an array
     *
     * Note: that changes and alterations made to rows, columns and
     * values will also reflect on what this function retrives.
     *
     * @access public
     * @return array
     * @see connect(), getHeaders(), getRows(), isSymmetric(), getAsymmetricRows(),
     * symmetrize()
     */
    public function getRawArray()
    {
        $ret_arr   = array();
        $ret_arr[] = $this->headers;
        foreach ($this->rows as $row) {
            $ret_arr[] = $row;
        }
        return $ret_arr;
    }

    /**
     * header creator
     *
     * uses prefix and creates a header for each column suffixed by a
     * numeric value
     *
     * by default the first row is interpreted as headers but if we
     * have a csv file with data only and no headers it becomes really
     * annoying to work with the current loaded data.
     *
     * this function will create a set dinamically generated headers
     * and make the current headers accessable with the row handling
     * functions
     *
     * Note: that the csv file contains only data but no headers
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * checks if the csv file was loaded
     *
     * <strong>
     *   $csv = new File_CSV_DataSource;
     *   if (!$csv->load('my_cool.csv')) {
     *      die('can not load csv file');
     *   }
     * </strong>
     *
     * dump current headers
     *
     * <strong>
     *   var_export($csv->getHeaders());
     * </strong>
     *
     * standard output
     *
     * <strong>
     *   array (
     *     0 => 'john',
     *     1 => '13',
     *     2 => 'knows magic',
     *   )
     * </strong>
     *
     * generate headers named 'column' suffixed by a number and interpret
     * the previous headers as rows.
     *
     * <strong>
     *   $csv->createHeaders('column')
     * </strong>
     *
     * dump current headers
     *
     * <strong>
     *   var_export($csv->getHeaders());
     * </strong>
     *
     * standard output
     *
     * <strong>
     *   array (
     *     0 => 'column_1',
     *     1 => 'column_2',
     *     2 => 'column_3',
     *   )
     * </strong>
     *
     * build a relationship and dump it
     *
     * <strong>
     *   var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *
     *  array (
     *    0 =>
     *    array (
     *      'column_1' => 'john',
     *      'column_2' => '13',
     *      'column_3' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'column_1' => 'tanaka',
     *      'column_2' => '8',
     *      'column_3' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'column_1' => 'jose',
     *      'column_2' => '5',
     *      'column_3' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * @param string $prefix string to use as prefix for each
     * independent header
     *
     * @access public
     * @return boolean fails if data is not symmetric
     * @see isSymmetric(), getAsymmetricRows()
     */
    public function createHeaders($prefix)
    {
        if (!$this->isSymmetric()) {
            return false;
        }

        $length = count($this->headers) + 1;
        $this->moveHeadersToRows();

        $ret_arr = array();
        for ($i = 1; $i < $length; $i ++) {
            $ret_arr[] = $prefix . "_$i";
        }
        $this->headers = $ret_arr;
        return $this->isSymmetric();
    }

    /**
     * header injector
     *
     * uses a $list of values which wil be used to replace current
     * headers.
     *
     * Note: that given $list must match the length of all rows.
     * known as symmetric. see isSymmetric() and getAsymmetricRows() methods
     *
     * Also, that current headers will be used as first row of data
     * and consecuently all rows order will change with this action.
     *
     * sample of a csv file "my_cool.csv"
     *
     * <strong>
     *   name,age,skill
     *   john,13,knows magic
     *   tanaka,8,makes sushi
     *   jose,5,dances salsa
     * </strong>
     *
     * load the library and csv file
     *
     * <strong>
     *  require_once 'File/CSV/DataSource.php';
     *  $csv = new File_CSV_DataSource;
     *  $csv->load('my_cool.csv');
     * </strong>
     *
     * lets dump currently loaded data
     * <strong>
     *  var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *  array (
     *    0 =>
     *    array (
     *      'name' => 'john',
     *      'age' => '13',
     *      'skill' => 'knows magic',
     *    ),
     *    1 =>
     *    array (
     *      'name' => 'tanaka',
     *      'age' => '8',
     *      'skill' => 'makes sushi',
     *    ),
     *    2 =>
     *    array (
     *      'name' => 'jose',
     *      'age' => '5',
     *      'skill' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * And now lets create a new set of headers and attempt to inject
     * them into the current loaded dataset
     *
     * <strong>
     *  $new_headers = array('a', 'b', 'c');
     *  var_export($csv->setHeaders($new_headers));
     * </strong>
     *
     * output
     *
     * <strong>
     *  true
     * </strong>
     *
     * Now lets try the same with some headers that do not match the
     * current headers length. (this should fail)
     *
     * <strong>
     *  $new_headers = array('a', 'b');
     *  var_export($csv->setHeaders($new_headers));
     * </strong>
     *
     * output
     *
     * <strong>
     *  false
     * </strong>
     *
     * now let's dump whatever we have changed
     *
     * <strong>
     *  var_export($csv->connect());
     * </strong>
     *
     * output
     *
     * <strong>
     *  array (
     *    0 =>
     *    array (
     *      'a' => 'name',
     *      'b' => 'age',
     *      'c' => 'skill',
     *    ),
     *    1 =>
     *    array (
     *      'a' => 'john',
     *      'b' => '13',
     *      'c' => 'knows magic',
     *    ),
     *    2 =>
     *    array (
     *      'a' => 'tanaka',
     *      'b' => '8',
     *      'c' => 'makes sushi',
     *    ),
     *    3 =>
     *    array (
     *      'a' => 'jose',
     *      'b' => '5',
     *      'c' => 'dances salsa',
     *    ),
     *  )
     * </strong>
     *
     * @param array $list a collection of names to use as headers,
     *
     * @access public
     * @return boolean fails if data is not symmetric
     * @see isSymmetric(), getAsymmetricRows(), getHeaders(), createHeaders()
     */
    public function setHeaders($list)
    {
        if (!$this->isSymmetric()) {
            return false;
        }
        if (!is_array($list)) {
            return false;
        }
        if (count($list) != count($this->headers)) {
            return false;
        }
        $this->moveHeadersToRows();
        $this->headers = $list;
        return true;
    }

    /**
     * csv parser
     *
     * reads csv data and transforms it into php-data
     *
     * @access protected
     * @return boolean
     */
    protected function parse()
    {
        if (!$this->validates()) {
            return false;
        }

        $c = 0;
        $d = $this->settings['delimiter'];
        $e = $this->settings['escape'];
        $l = $this->settings['length'];

        $res = fopen($this->_filename, 'r');

        while ($keys = fgetcsv($res, $l, $d, $e)) {

            if ($c == 0) {
                $this->headers = $keys;
            } else {
                array_push($this->rows, $keys);
            }

            $c ++;
        }

        fclose($res);
        $this->removeEmpty();
        return true;
    }

    /**
     * empty row remover
     *
     * removes all records that have been defined but have no data.
     *
     * @access protected
     * @return array containing only the rows that have data
     */
    protected function removeEmpty()
    {
        $ret_arr = array();
        foreach ($this->rows as $row) {
            $line = trim(join('', $row));
            if (!empty($line)) {
                $ret_arr[] = $row;
            }
        }
        $this->rows = $ret_arr;
    }

    /**
     * csv file validator
     *
     * checks wheather if the given csv file is valid or not
     *
     * @access protected
     * @return boolean
     */
    protected function validates()
    {
        // file existance
        if (!file_exists($this->_filename)) {
            return false;
        }

        // file readability
        if (!is_readable($this->_filename)) {
            return false;
        }

        return true;
    }

    /**
     * header relocator
     *
     * @access protected
     * @return void
     */
    protected function moveHeadersToRows()
    {
        $arr   = array();
        $arr[] = $this->headers;
        foreach ($this->rows as $row) {
            $arr[] = $row;
        }
        $this->rows    = $arr;
        $this->headers = array();
    }

    /**
     * array key reseter
     *
     * makes sure that an array's keys are setted in a correct numerical order
     *
     * Note: that this function does not return anything, all changes
     * are made to the original array as a reference
     *
     * @param array &$array any array, if keys are strings they will
     * be replaced with numeric values
     *
     * @access protected
     * @return void
     */
    protected function resetKeys(&$array)
    {
        $arr = array();
        foreach ($array as $item) {
            $arr[] = $item;
        }
        $array = $arr;
    }

    /**
     * object data flusher
     *
     * tells this object to forget all data loaded and start from
     * scratch
     *
     * @access protected
     * @return void
     */
    protected function flush()
    {
        $this->rows    = array();
        $this->headers = array();
    }

}

if(!function_exists('str_getcsv')) {
    function str_getcsv($input, $delimiter = ',', $enclosure = '"') {

        if( ! preg_match("/[$enclosure]/", $input) ) {
          return (array)preg_replace(array("/^\\s*/", "/\\s*$/"), '', explode($delimiter, $input));
        }

        $token = "##"; $token2 = "::";
        //alternate tokens "\034\034", "\035\035", "%%";
        $t1 = preg_replace(array("/\\\[$enclosure]/", "/$enclosure{2}/",
             "/[$enclosure]\\s*[$delimiter]\\s*[$enclosure]\\s*/", "/\\s*[$enclosure]\\s*/"),
             array($token2, $token2, $token, $token), trim(trim(trim($input), $enclosure)));

        $a = explode($token, $t1);
        foreach($a as $k=>$v) {
            if ( preg_match("/^{$delimiter}/", $v) || preg_match("/{$delimiter}$/", $v) ) {
                $a[$k] = trim($v, $delimiter); $a[$k] = preg_replace("/$delimiter/", "$token", $a[$k]); }
        }
        $a = explode($token, implode($token, $a));
        return (array)preg_replace(array("/^\\s/", "/\\s$/", "/$token2/"), array('', '', $enclosure), $a);

    }
}

 function CSV_GENERATE($getTable) {
		ob_end_clean();
		global $wpdb;
		$field	='';
		$getField ='';
		if($getTable){
			$result = $wpdb->get_results("SELECT * FROM $getTable");
		
		$fieldsCount = $wpdb->get_col( "DESC " . $getTable , 0 );//mysql_num_fields($requestedTable);
		for($i=0; $i < count($fieldsCount); $i++){
				//$field = mysql_fetch_field($requestedTable);
				//$field = (object) $field;         
				$getField .= $fieldsCount[$i].',';//$field->name.',';
			}
			$sub = substr_replace($getField, '', -1);
			$fields = $sub; // Get fields names
			$each_field = explode(',', $sub);
			//$csv_file_name = $getTable.'_'.date('Ymd_His').'.csv'; 
			$csv_file_name = 'NativeEmail_'.date('Ymd_His').'.csv'; 
			// Get fields values with last comma excluded
			foreach($result as $row){
				for($j = 0; $j < count($fieldsCount); $j++){
					if($j == 0) $fields .= "\n"; // Force new line if loop complete
					$value = str_replace(array("\n", "\n\r", "\r\n", "\r"), "\t", $row->$each_field[$j]); // Replace new line with tab
					$value = str_getcsv ( $value , ",", "\"" , "\\"); // SEQUENCING DATA IN CSV FORMAT, REQUIRED PHP >= 5.3.0
					$fields .= $value[0].','; // Separate fields with comma
				}
				$fields = substr_replace($fields, '', -1); // Remove extra space at end of string
			}
			
			if (ob_get_length()) ob_end_clean();
			
			header("Content-type: text/csv");
			header("Content-Transfer-Encoding: binary");
			header("Content-Disposition: attachment; filename=".$csv_file_name);
			header("Content-type: application/x-msdownload");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $fields; 
			exit;
		}
 }
?>