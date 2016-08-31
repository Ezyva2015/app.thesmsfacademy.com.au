<?php

/**
 * @author The API Guys
 * @version 0.2.3
 * @last_updated 2014/10/08
 * @package default
 *
 * A general wrapper for the Infusionsoft iSDK
 *
 * This is proprietary software, do not distrubute
 *
 * @todo Move Contact concerned methods to new Contact class
 * @todo Move Invoice concerned methods to new Invoices and Invoice classes
 * @todo Move Job concerned methods to new Jobs and Job classes
 */
 
require_once dirname(__FILE__) . '/isdk.php';

/**
 * An enhanced iSDK
 */
class iSDK_enhanced extends iSDK {

    static public $singleton = NULL;

    const   ACCESS_READ   = 0x01;
    const   ACCESS_ADD    = 0x02;
    const   ACCESS_DELETE = 0x04;
    const   ACCESS_EDIT   = 0x08;
    
    private $connected    = FALSE;
    private $contact_id   = 0;
    private $app          = NULL;
    private $preserve     = NULL;
    private $table_alias  = array('Opportunity' => 'Lead', 'Order' => 'Job');
    private $formid_map   = array(
        'Contact'       => -1,  'Affiliate' => -3, 'Opportunity' => -4, 'Lead'  => -4,
        'ContactAction' => -5,  'Company'   => -6, 'Job'         => -9, 'Order' => -9,
        'Subscription'  => -10
    );

    public  $last_result  = NULL;
    
    public function __construct($contact_id = NULL)
    {
        $this->contact_id = (int)$contact_id;
    }

    static public function getInstance($contactId = NULL)
    {
        if ( ! self::$singleton)
        {
            return self::$singleton = new iSDK_enhanced($contactId);
        }
        
        return self::$singleton;
    }
    
    /**
     * Override of parent::cfgCon
     * 
     * @see iSDK_enhanced::connect
     */
    public function cfgCon($name, $key = '', $dbOn = 'on', $type = 'i')
    {
        return ($this->connected = parent::cfgCon($name, $key, $dbOn, $type));
    }
    
    /**
     * Override of parent::dsUpdate to support auto-retry
     *
     * @param  string  $table  The target table being updated
     * @param  int     $id     The ID of the record being updated
     * @param  mixed[] $fields Assoc. array of data to update
     * @return mixed
     */
    public function dsUpdate($table, $id, $fields)
    {
        $tries = 0;
        
        do
        {
            $result = parent::dsUpdate($table, $id, $fields);
        } while (($id != $result) && (++$tries < 3));
        
        if ($id != $result)
        {
            file_put_contents(
                dirname(__FILE__) . '/log.txt',
                "Call to dsUpdate failed ({$tries} tries): " . PHP_EOL .
                print_r($table, TRUE)  . PHP_EOL .
                print_r($id, TRUE)     . PHP_EOL .
                print_r($fields, TRUE) . PHP_EOL .
                print_r($result, TRUE) . PHP_EOL . PHP_EOL,
                FILE_APPEND
            );
        }
        
        return $result;
    }
    
    /**
     * Override of parent::achieveGoal to support auto-retry
     *
     * @param  string  $integration  The integration name of the API Goal
     * @param  string  $call_name    The call name of the API Goal
     * @param  uint    $contact_id   The contact ID of the contact on which to execute
     * @return mixed[]
     */
    public function achieveGoal($integration, $call_name, $contact_id)
    {
        $tries = 0;
        
        do
        {
            $result = parent::achieveGoal($integration, $call_name, $contact_id);
        } while (( ! is_array($result) || ! $result[0]['success']) && (++$tries < 3));
        
        if ( ! is_array($result) || ! $result[0]['success'])
        {
            file_put_contents(
                dirname(__FILE__) . '/log.txt',
                "Call to achieveGoal failed ({$tries} tries): " . PHP_EOL .
                print_r($integration, TRUE) . PHP_EOL .
                print_r($call_name, TRUE)   . PHP_EOL .
                print_r($contact_id, TRUE)  . PHP_EOL .
                print_r($result, TRUE)      . PHP_EOL . PHP_EOL,
                FILE_APPEND
            );
        }
        
        return $result;
    }
    
    /**
     * Establish connection with Infusionsoft API webserver
     *
     * Alias for iSDK::cfgCon
     *
     * @param  mixed  $name (Optional) The application name
     * @param  string $key  (Optional) The application encrypted secret key
     * @param  string $dbOn (Optional) Debug mode ('on'/'off')
     * @param  string $type (Optional) Type of application ('i' = Infusionsoft)
     * @return bool
     */
    public function connect($name = '', $key = '', $dbOn = 'on', $type = 'i')
    {
        if ($this->app && $this->app != $name)
        {
            $this->connected = FALSE;
        }
        
        $name = $name ? $name : $this->app;
        
        $this->app = $name;
        
        return $this->cfgCon($this->app, $key, $dbOn, $type);
    }
    
    /**
     * Load all accounts contained in the configuration file
     *
     * @return mixed[]
     */
    public function load_accounts()
    {
        include_once('conn.cfg.php');
        
        $all_accounts = array();
        
        foreach($connInfo as $info)
        {
            $all_accounts[] = explode(':', $info);
        }
        
        return $all_accounts;
    }
    
    /**
     * Bind the current instance to a specific application name
     *
     * @param  mixed         $name The application name to be bound
     * @return iSDK_enhanced
     */
    public function set_app($name)
    {
        $this->app = $name ? $name : $this->app;
        
        return $this;
    }
    
    /**
     * Bind the current instance to a specific contact ID
     *
     * @param  int           $contact_id The contact ID to be bound
     * @return iSDK_enhanced
     */
    public function set_contact_id($contact_id)
    {
        $this->contact_id = (int)$contact_id;
        
        return $this;
    }
    
    /**
     * Return the current bound contact ID
     *
     * @return int
     */
    public function get_contact_id()
    {
        return $this->contact_id;
    }
    
    /**
     * Return all custom fields from a specified table
     *
     * @param  string  $table (Optional) The table to which the custom field belongs. Default is 'Contact'
     * @return mixed[]
     */
    public function get_custom_fields($table = 'Contact')
    {
        $table  = preg_replace('/[^a-z]/', '', strtolower($table));
        $page   = 0;
        $tables = array(
            'contact'     => -1, 'referralpartner' => -3, 'referral' => -3,
            'opportunity' => -4, 'task'            => -5, 'note'     => -5,
            'apt'         => -5, 'tasknoteapt'     => -5, 'company'  => -6,
            'order'       => -9
        );
        $fields = array();
        $return = array(
            'Id',           'Name',   'DataType', 'Label',
            'DefaultValue', 'Values', 'FormId',   'GroupId',
            'ListRows'
        );
        
        if ( ! $table OR ! isset($tables[$table]))
        {
            throw new Exception('Invalid table');
        }
        
        while ($_fields = $this->dsQuery('DataFormField', 999, $page++, array('Name' => '%', 'FormId' => $tables[$table]), $return))
        {
            $fields = array_merge($_fields);
        }
        
        return $fields;
    }
    
    /**
     * Return custom field names only
     *
     * @param  string  $table (Optional) The table to which the custom field belongs. Default is 'Contact'
     * @return mixed[]
     */
    public function get_custom_field_names($table = 'Contact')
    {
        return $this->pluck($this->get_custom_fields($table), 'Name');
    }
    
    /**
     * Return the current timestamp formatted using Infusionsoft's conventions
     *
     * @return string
     */
    public function now()
    {
        return $this->infuDate(date('Ymd\TH:i:s', time()));
    }
    
    /**
     * Return the timestamp formatted using Infusionsoft's conventions
     *
     * @param  mixed  $datetime The time stamp to convert; UNIX timestamp or any standard date/time format
     * @return string
     */
    public function date($datetime)
    {
        return $this->infuDate(date('Ymd\TH:i:s', (is_int($datetime) ? $datetime : strtotime($datetime))));
    }

    public function get_table_fields($table = 'Contact')
    {
        $path = dirname(__FILE__) . "/tables/{$table}.json";
        
        if ( ! file_exists($path))
        {
            return FALSE;
        }
        
        $fields = json_decode(file_get_contents($path), TRUE);
        
        return $this->pluck($fields, 'name');
    }

    public function get_field_attributes($name, $table = 'Contact')
    {
        $table = $this->resolve_table($table);
        $path  = dirname(__FILE__) . "/tables/{$table}.json";
        $name  = ($_name = $this->parse_field($name, 'name')) ? $_name : $name;
        
        if ( ! file_exists($path))
        {
            return FALSE;
        }
        
        $fields = json_decode(file_get_contents($path), TRUE);
        
        foreach ($fields as $field)
        {
            if ($field['name'] == $name)
            {
                return $field;
            }
        }
        
        return FALSE;
    }

    public function custom_field_exists($name, $table = 'Contact')
    {
        return $this->field_exists($name, $table, TRUE);
    }

    public function field_exists($name, $table = 'Contact', $custom = FALSE)
    {
        $name  = trim($name, "\x0b\x7e\x20\t\n\r\0");
        $table = ($_table = $this->parse_field($name, 'table')) ? $_table : $table;
        $name  = ($_name = $this->parse_field($name, 'name')) ? $_name : $name;

        if ($custom)
        {
            return (bool)$this->dsCount(
                'DataFormField',
                array(
                    'Name'   => str_replace('_', '', $name),
                    'FormId' => (isset($this->formid_map[$table]) ? $this->formid_map[$table] : 0)
                )
            );
        }

        return (bool)$this->get_field_attributes($name, $table);
    }
    
    public function is_field_readable($name, $table = 'Contact')
    {
        $table = ($_table = $this->parse_field($name, 'table')) ? $_table : $table;
        $name  = ($_name = $this->parse_field($name, 'name')) ? $_name : $name;

        return (($field = $this->get_field_attributes($name, $table)) &&
                (bindec($field['access']) & self::ACCESS_READ));
    }

    public function is_field_writable($name, $table = 'Contact')
    {
        $table = ($_table = $this->parse_field($name, 'table')) ? $_table : $table;
        $name  = ($_name = $this->parse_field($name, 'name')) ? $_name : $name;

        return (($field = $this->get_field_attributes($name, $table)) &&
                (bindec($field['access']) & self::ACCESS_EDIT));
    }

    public function is_field_addable($name, $table = 'Contact')
    {
        $table = ($_table = $this->parse_field($name, 'table')) ? $_table : $table;
        $name  = ($_name = $this->parse_field($name, 'name')) ? $_name : $name;

        return (($field = $this->get_field_attributes($name, $table)) &&
                (bindec($field['access']) & self::ACCESS_ADD));
    }

    public function is_field_deletable($name, $table = 'Contact')
    {
        $table = ($_table = $this->parse_field($name, 'table')) ? $_table : $table;
        $name  = ($_name = $this->parse_field($name, 'name')) ? $_name : $name;

        return (($field = $this->get_field_attributes($name, $table)) &&
                (bindec($field['access']) & self::ACCESS_DELETE));
    }

	/**
     * Return a list of all invoices
     *
     * @param  mixed[] $extend_query  (Optional) An array of fields to include in Infusionsoft query
     * @param  mixed[] $extend_return (Optional) An array of fields to include in Infusionsoft return data
     * @return mixed[]
     */
    public function get_all_invoices($limit)
    {
        $query = array(
            'Id' => '%'
        );
        
        self::extend_array($query, $extend_query);
        
        $return = array(
            'Id', 'JobId', 'DateCreated', 'InvoiceTotal', 'PayStatus',
            'TotalPaid', 'TotalDue', 'ProductSold'
        );

        self::extend_array($return, $extend_return);
        
        $result = $this->dsQueryOrderBy('Invoice', $limit, 0, $query, $return, 'DateCreated', FALSE);       
        //self::sort_by_date_created($result);
        
        return $this->last_result = $result;
    }
    
    
    
    
    /**
     * Return a list of a user's invoices
     *
     * @param  mixed[] $extend_query  (Optional) An array of fields to include in Infusionsoft query
     * @param  mixed[] $extend_return (Optional) An array of fields to include in Infusionsoft return data
     * @return mixed[]
     */
    public function get_invoices($extend_query = array(), $extend_return = array())
    {
        $query = array(
            'Id' => '%',
            'ContactId' => $this->contact_id
        );
        
        self::extend_array($query, $extend_query);
        
        $return = array(
            'Id', 'JobId', 'DateCreated', 'InvoiceTotal', 'PayStatus',
            'TotalPaid', 'TotalDue', 'ProductSold'
        );

        self::extend_array($return, $extend_return);
        
        $result = $this->dsQuery('Invoice', 999, 0, $query, $return);
        
        self::sort_by_date_created($result);
        
        return $this->last_result = $result;
    }
    
    
    /**
     * Return a list of all products
     *
     * @param  mixed[] $extend_query  (Optional) An array of fields to include in Infusionsoft query
     * @param  mixed[] $extend_return (Optional) An array of fields to include in Infusionsoft return data
     * @return mixed[]
     */
    public function get_products($extend_query = array(), $extend_return = array())
    {
        $query = array(
            'Id' => '%',
        );
        
        
        self::extend_array($query, $extend_query);
        
        $return = array(
            'Id', 'InventoryLimit', 'Status', 'ProductName', 'ProductPrice', 'Sku', 'ShortDescription', 'Description'
        );

        self::extend_array($return, $extend_return);
        
        	
		$numPostcodes = $this->dsCount("Product",$query);
        $x = 0;
        do {
        	$result[] = $this->dsQuery('Product', 999, $x, $query, $return);
		  $x = $x + 1;
		  $numPostcodes = $numPostcodes - 999;
		  
		} while ($numPostcodes>0);
        
        
        self::sort_by_date_created($result);
        
        return $result;
        //return $this->last_result = $result;
    }

    public function getProducts($extend_query = array(), $extend_return = array()){
        $query = array(
            'Id' => '%',
        );

        self::extend_array($query, $extend_query);

        $return = array(
            'Id', 'InventoryLimit', 'Status', 'ProductName', 'ProductPrice', 'Sku', 'ShortDescription', 'Description'
        );

        self::extend_array($return, $extend_return);


        $numPostcodes = $this->dsCount("Product",$query);

        $limit = 1000;
        $loop  = ceil($numPostcodes/$limit);

        $result = array();

        for($i=0; $i<$loop; $i++){
            $rs = $this->dsQuery('Product', $limit, $i,$query, $return);
    //        foreach($rs as $r){
            $result[] = $rs;
    //        }
        }
        return $result;
    }

    
    /**
     * Return the newest available invoice for a user
     *
     * @param  mixed[] $extend_query  (Optional) An array of fields to include in Infusionsoft query
     * @param  mixed[] $extend_return (Optional) An array of fields to include in Infusionsoft return data
     * @return mixed[]
     */
    public function get_newest_invoice($extend_query = array(), $extend_return = array())
    {
        $invoices = $this->get_invoices($extend_query, $extend_return);
        
        return $this->last_result = (($invoices && is_array($invoices)) ? array_pop($invoices) : array());
    }
    
    /**
     * Return the oldest available invoice for a user
     *
     * @param  mixed[] $extend_query  (Optional) An array of fields to include in Infusionsoft query
     * @param  mixed[] $extend_return (Optional) An array of fields to include in Infusionsoft return data
     * @return mixed[]
     */
    public function get_oldest_invoice($extend_query = array(), $extend_return = array())
    {
        $invoices = $this->get_invoices($extend_query, $extend_return);
        
        return $this->last_result = (($invoices && is_array($invoices)) ? array_shift($invoices) : array());
    }
    
    /**
     * Return job details
     *
     * @param  int     $job_id The job id being queried
     * @return mixed[]
     */
    public function get_job_by_id($job_id)
    {
        $job_id = (int)$job_id;
        
        if ( ! $job_id OR ! $this->connected)
        {
            return array();
        }
        
        $query = array('Id' => $job_id);
        
        $return = array(
            'JobTitle', 'StartDate', 'DueDate', 'JobNotes', 'ProductId',
            'JobStatus', 'DateCreated', 'OrderType', 'OrderStatus'
        );
        
        $job = $this->dsQuery('Job', 1, 0, $query, $return);
        
        return $this->last_result = (($job && is_array($job)) ? array_shift($job) : array());
    }
    
    /**
     * Retrive a product by SKU
     *
     * @param  mixed        $sku The SKU of the product whose details are being returned
     * @return mixed[]|NULL
     */
    public function get_product_by_sku($sku)
    {
        $fields   = $this->get_table_fields('Product');
        $products = $this->dsFind('Product', 1, 0, 'Sku', $sku, $fields);
        
        return isset($products[0]) ? $products[0] : NULL;
    }
    
    /**
     * Retrive a product by ID
     *
     * @param  mixed        $pid the ID of the product whose details are being returned
     * @return mixed[]|NULL
     */
    public function get_product_by_id($pid)
    {
        $fields   = $this->get_table_fields('Product');
        $query = array('Id' => $pid);
        $product = $this->dsQuery('Product', 1, 0, $query, array('ProductName', 'ProductPrice', 'ShortDescription','Description'));
        
        //return $product[0]['ProductName'];
        return $product[0];
    }
    
    /**
     * Retrive a product ID by SKU
     *
     * @param  mixed    $sku The SKU of the product whose ID is being returned
     * @return int|NULL
     */
    public function get_product_id_by_sku($sku)
    {
        $product = $this->get_product_by_sku($sku);
        
        return isset($product['Id']) ? $product['Id'] : NULL;
    }

    /**
     * Retrive a product name by SKU
     *
     * @param  mixed      $sku The SKU of the product whose Name is being returned
     * @return mixed|NULL
     */
    public function get_product_name_by_sku($sku)
    {
        $product = $this->get_product_by_sku($sku);
        
        return isset($product['ProductName']) ? $product['ProductName'] : NULL;
    }
    
    /**
     * Return the value of a field
     *
     * @todo Check if table and field name exist
     *       Consider filtering somehow if above doesn't work?
     *
     * @param  string $name  The name of the field being queried
     * @param  string $table (Optional) The source table of the field
     * @param  int    $id    (Optional) Required if not Contact table; ID of record
     * @return mixed
     */
    public function get_field($name, $table = 'Contact', $id = NULL)
    {
        /*
        $numeric_qualifiers = array(
            'Min',     'Max',         'Count',    'IsNotEmpty',
            'IsEmpty', 'GreaterThan', 'LessThan', 'Sum'
        );
        */
        $name = trim($name, "\x0b\x7e\x20\t\n\r\0");
        
        list($_table, $_name, $_id, $qualifiers) = $this->parse_field($name);
        
        $table = $this->resolve_table($_table ? $_table : $table);
        $name  = $_name ? $_name : $name;
        $id    = $_id ? $_id : $id;
        
        /*
         * ID specification/override preservation
         */
        if ($table == 'Contact' && $_id)
        {
            $this->preserve   = $this->contact_id;
            $this->contact_id = $id;
        }
        
        if ( ! $id && ($qualifiers || $table !== 'Contact'))
        {
            $value = $this->get_qualified_record($table, $name, $qualifiers, FALSE);
            
            /*
            $result = $this->get_qualified_record($table, $name, $qualifiers);

            if (array_intersect($numeric_qualifiers, $qualifiers))
            {
                return is_numeric($id) ? $id : 0;
            }
            
            if ( ! (is_numeric($result) && (int)$result))
            {
                return $result;
            }
            */
        }
        else
        {
            $value = $this->dsQuery(
                $table,
                1,
                0,
                array('Id' => ($table == 'Contact' ? $this->contact_id : $id)),
                array($name)
            );
            
            $value = (($value && is_array($value) && isset($value[0][$name]))
                ? $value[0][$name]
                : NULL);
        }
        
        $this->contact_id = is_null($this->preserve) ? $this->contact_id : $this->preserve;
        $this->preserve   = NULL;
        
        return $this->last_result = $value;
    }

    /**
     * Set the value of a field by name
     *
     * @todo Check if table and field name exist
     *       Consider filtering somehow if above doesn't work?
     *
     * @param  string        $name  The name of the field being updated
     * @param  mixed         $value The value to be set
     * @param  string        $table (Optional) The source table of the field
     * @return iSDK_enhanced
     */
    public function set_field($name, $value, $table = 'Contact', $id = NULL)
    {
        $name = trim($name, "\x0b\x7e\x20\t\n\r\0");
        
        list($_table, $_name, $_id, $qualifiers) = $this->parse_field($name);
        
        $table = $this->resolve_table($_table ? $_table : $table);
        $name  = $_name ? $_name : $name;
        $id    = $_id ? $_id : $id;
        
        /*
         * ID specification/override preservation
         */
        if ($table == 'Contact' && $_id)
        {
            $this->preserve   = $this->contact_id;
            $this->contact_id = $id;
        }
        
        if ( ! $id && ($qualifiers || $table !== 'Contact'))
        {
            $ids = $this->get_qualified_record($table, $name, $qualifiers);
            
            if ( ! (is_array($ids) || is_numeric($ids)) || ! $ids)
            {
                return FALSE;
            }
        }
        
        return $this->set_fields(array($name => $value), $table, (isset($ids) ? $ids : $id));
    }
    
    public function get_qualified_record($table, $name, $qualifiers, $id_priority = TRUE)
    {
        $dates = array(
            'Current' => 'F j, Y', 'DayOfWeek'   => 'l', 'DayOfMonth' => 'j', 
            'Month'   => 'F',      'MonthOfYear' => 'n', 'Year'       => 'Y'
        );
        
        if ($table == 'Date' && array_key_exists($name, $dates))
        {
            return date($dates[$name]);
        }
        
        $return = array_filter(array(
            $this->field_exists('LastUpdated', $table) ? 'LastUpdated' : NULL,
            $this->field_exists('DateCreated', $table) ? 'DateCreated' : NULL,
        ));

        $return = @array_merge(array('Id'), array_filter(array($name ? $name : '')), $return);

        /*
         * Get the appropriate ContactID label depending on table; ugh
         */
        $contact_label = $this->field_exists('ContactID', $table)
            ? 'ContactID'
            : $this->field_exists('ContactId', $table)
                ? 'ContactId'
                : NULL;

        /*
         * Remove ContactID constraint if requested
         */
        if (($k = array_search('Global', $qualifiers)) !== FALSE)
        {
            $contact_label = NULL;
            
            unset($qualifiers[$k]);
        }

        $query         = $contact_label ? array($contact_label => $this->get_contact_id()) : array();
        $order_by      = 'DateCreated';
        $is_timestamp  = TRUE;
        $records       = array();
        $page          = 0;

        if ($qualifiers)
        {
            foreach ($qualifiers as $k => $qualifier)
            {
                /*
                 * Extract all "filters" from Filter index
                 */
                if (substr($qualifier, 0, 8) == 'FilterBy')
                {
                    $qualifier_len = strlen('FilterBy');

                    $strings   = self::extract_quoted_text($qualifier);
                    $qualifier = (is_array($strings) && $strings) ? str_replace($strings, array_keys($strings), $qualifier) : $qualifier;
                    $params    = array_filter(explode(',', substr($qualifier, ($qualifier_len + 1), strrpos($qualifier, ')') - ($qualifier_len + 1))));
                    $params    = array_map(
                        function ($a)
                        {
                            return $a ? explode(':', str_replace(array('{comma}', '{period}'), array(',', '.'), $a)) : NULL;
                        },
                        array_map('trim', $params)
                    );

                    if ($params && $strings)
                    {
                        $strings = array_map(function ($a) { return $a ? substr($a, 1, -1) : NULL; }, $strings);

                        foreach ($params as &$param)
                        {
                            $param[1] = str_replace(array_keys($strings), $strings, $param[1]);
                        }
                    }

                    $query = array_unique(array_merge($query, array_unique(array_combine($this->pluck($params, 0), $this->pluck($params, 1)))));

                    unset($qualifiers[$k]);

                    continue;
                }

                /*
                 * Extract desired 'OrderBy' field
                 */
                if (substr($qualifier, 0, 7) == 'OrderBy')
                {
                    $order_by = str_replace('OrderBy', '', preg_replace('/[^a-zA-Z0-9_:]/', '', $qualifier));
                    
                    if (strpos($order_by, ':') !== FALSE)
                    {
                        list($order_by, $is_timestamp) = array_map('trim', explode(':', $order_by));
                        
                        $is_timestamp = FALSE;
                    }
                    
                    unset($qualifiers[$k]);
                    
                    continue;
                }
                
                /*
                 * Extract desired 'Combine' or 'Implode' glue
                 */
                if (substr($qualifier, 0, 7) == 'Combine')
                {
                    if ($glue = self::extract_quoted_text($qualifier, TRUE))
                    {
                        $glue = substr($glue[0], 1, -1);
                    }
                    else
                    {
                        $glue = '';
                    }
                    
                    unset($qualifiers[$k]);
                    
                    $qualifiers[] = 'Combine';
                    
                    continue;
                }
                
                /*
                 * Extract desired 'HasAnyTag' and 'HasAllTags' tags
                 */
                if ($table == 'Contact' &&
                    (($any = (substr($qualifier, 0, 9)  == 'HasAnyTag' )) ||
                     ($all = (substr($qualifier, 0, 10) == 'HasAllTags'))))
                {
                    if ( ! isset($tags))
                    {
                        $tags = array();
                    }
                    
                    $new_qualifier        = $any ? 'HasAnyTag' : 'HasAllTags';
                    $tags[$new_qualifier] = explode(',', preg_replace('/[^0-9,]/', '', $qualifier));
                    
                    unset($qualifiers[$k]);
                    
                    $qualifiers[] = $new_qualifier;
                    $return[]     = 'Groups';
                    
                    continue;
                }
            }
        }

        /*
         * If we're querying the Invoice table, return PayStatus by default
         */
        if ($table == 'Invoice')
        {
            $return[] = 'PayStatus';
        }

        /*
         * De-dupe the desired return data; Only include OrderBy if it exists in table
         */
        $return = array_values(array_unique(array_merge(array($this->field_exists($order_by, $table) ? $order_by : 'Id'), $return)));

        /*
         * Minimum query
         */
        $query = $query ? $query : array('Id' => '%');

        /*
         * Find all matching records
         */
        while ($results = $this->dsQuery($table, 1000, $page++, $query, $return))
        {
            if ( ! is_array($results))
            {
                return NULL;
            }
            
            $records = array_merge($records, $results);
        }

        /*
         * Sort our results by the desired field, default to LastUpdated
         */
        self::sort_assoc_array_by_value($records, $order_by, $is_timestamp);

        /*
         * If there are no qualifiers, return the ID for the
         * "newest" or "last" in the collection
         */
        if ( ! $qualifiers)
        {
            $record = array_pop($records);

            return $id_priority ? $record['Id'] : $record[$name];
        }

        /*
         * If they specified an 'Paid' or 'Unpaid' qualifier, filter out the unqualified records
         */
        if ($table == 'Invoice' && array_intersect(array('Paid', 'Unpaid'), $qualifiers))
        {
            $records = array_filter(
                $records,
                function ($a) use ($qualifiers)
                {
                    return $a['PayStatus'] == (int)in_array('Paid', $qualifiers);
                }
            );

            unset($qualifiers['Paid'], $qualifiers['Unpaid']);
        }

        /*
         * If they request records that are empty, keep only those
         */
        if (in_array('IsEmpty', $qualifiers))
        {
            $records = array_filter(
                $records,
                function ($a) use ($name)
                {
                    return ( ! isset($a[$name]) || (isset($a[$name]) && (is_null($a[$name]) || $a[$name] == '')));
                }
            );

            unset($qualifiers['IsEmpty']);
        }

        /*
         * If they request records that are not empty, keep only those
         */
        if (in_array('IsNotEmpty', $qualifiers))
        {
            $records = array_filter(
                $records,
                function ($a) use ($name)
                {
                    return (isset($a[$name]) && ! is_null($a[$name]) && $a[$name] != '' && $a[$name] != 'null');
                }
            );

            unset($qualifiers['IsNotEmpty']);
        }
        
        /*
         * If they request records that are greater or less than some value, keep only those
         *
         * Begin by creating an array of any valid comparison directives
         */
        $comparisons = array_filter(
            $qualifiers,
            function ($a)
            {
                return preg_match(
                    '/^(?:(?:(?:Greater|Less)Than(?:OrEqualTo)?)|(?:After|Before))\((?:.*?)\)$/',
                    $a
                );
            }
        );
        
        if ($comparisons)
        {
            /*
             * Process those matching directives
             */
            foreach ($comparisons as $k => $comparison)
            {
                /*
                 * Extract the value of the directive
                 */
                preg_match(
                    '/^(?:(?:(?:Greater|Less)Than(?:OrEqualTo)?)|(?:After|Before))\((.*?)\)$/',
                    $comparison,
                    $matches
                );
                
                /*
                 * Determine the type of comparison
                 */
                $operator   = ((strpos($comparison, 'GreaterThan') !== FALSE) ||
                                (strpos($comparison, 'After') !== FALSE))
                    ? 'gt'
                    : 'lt';
                $operator  .= (strpos($comparison, 'OrEqualTo') !== FALSE) ? 'e' : '';
                
                /*
                 * Handle conversions to date
                 */
                $comparison = trim($matches[1], "\x0b\x7e\x20\x22\t\n\r\0");
                $comparison = is_numeric($comparison)
                    ? $comparison
                    : ((($_stamp = strtotime($comparison)) !== FALSE)
                        ? $_stamp
                        : $comparison);
                
                /*
                 * Filter out non-matching results from the record set
                 */
                $records = array_filter(
                    $records,
                    function ($a) use ($name, $operator, $comparison)
                    {
                        /*
                         * If there is no value in the record, assume the record is
                         * less if it's gt/gte, or not if lt/lte
                         */
                        if ( ! isset($a[$name]))
                        {
                            return ($operator[0] == 'g' ? 1 : 0);
                        }
                        
                        /*
                         * Convert the records value to date, if necessary
                         */
                        $reference = $a[$name];
                        $reference = is_numeric($reference)
                            ? $reference
                            : ((($_stamp = strtotime($reference)) !== FALSE)
                                ? $_stamp
                                : $reference);
                        
                        /*
                         * Perform final comparison
                         */
                        switch ($operator)
                        {
                            case 'gt':  return ($reference >  $comparison);
                            case 'gte': return ($reference >= $comparison);
                            case 'lt':  return ($reference <  $comparison);
                            case 'lte': return ($reference <= $comparison);
                        }
                    }
                );

                unset($qualifiers[$k]);
            }
        }
        
        /*
         * If they request records that have all specified tags
         */
        if (in_array('HasAllTags', $qualifiers))
        {
            $records = array_filter(
                $records,
                function ($a) use ($tags)
                {
                    if ( ! isset($a['Groups']))
                    {
                        return FALSE;
                    }
                    
                    return (count(
                        array_intersect(
                            $tags['HasAllTags'],
                            explode(',', $a['Groups'])
                        )
                    ) === count($tags['HasAllTags']));
                }
            );

            unset($qualifiers['HasAllTags']);
        }
        
        /*
         * If they request records that have any of the specified tags
         */
        if (in_array('HasAnyTag', $qualifiers))
        {
            $records = array_filter(
                $records,
                function ($a) use ($tags)
                {
                    if ( ! isset($a['Groups']))
                    {
                        return FALSE;
                    }
                    
                    return (bool)array_intersect(
                        $tags['HasAnyTag'],
                        explode(',', $a['Groups'])
                    );
                }
            );

            unset($qualifiers['HasAllTags']);
        }
         
        /****************************
         * All return-set directives
         ****************************/
        
        /*
         * If they requested an "combined" or "imploded" response
         */
        if (in_array('Combine', $qualifiers))
        {
            return implode(str_replace('\n', PHP_EOL, $glue), $this->pluck($records, $name));
        }
        
        /*
         * If they request all record IDs
         */
        if (in_array('All', $qualifiers))
        {
            $ids = $this->pluck($records, $name);
            
            return $id_priority ? $ids : implode(' ', $ids);
        }

        /*
         * If they request the sum of all records, return that
         */
        if (in_array('Sum', $qualifiers))
        {
            return array_sum($this->pluck($records, $name));
        }
        
        /*
         * If they request the maximum record, return that
         */
        if (in_array('Max', $qualifiers))
        {
            return $records ? max($this->pluck($records, $name)) : 0;
        }

        /*
         * If they request minimum record, return that
         */
        if (in_array('Min', $qualifiers))
        {
            return $records ? min($this->pluck($records, $name)) : 0;
        }

        /*
         * If they request record count, return that
         */
        if (in_array('Count', $qualifiers))
        {
            return count($records);
        }

        /*
         * If they explicitly requested the oldest/first record, return its ID
         */
        if (in_array('Oldest', $qualifiers) || in_array('First', $qualifiers))
        {
            $record = array_shift($records);

            return $id_priority ? $record['Id'] : $record[$name];
        }
        
        $record = $records ? array_pop($records) : NULL;

        return $record ? ($id_priority ? $record['Id'] : $record[$name]) : NULL;
    }

    /**
     * Set the value of one or more fields
     *
     * @param  mixed[]       $fields Name/value pairs of fields to be updated
     * @param  string        $table  (Optional) The source table of the field
     * @return bool
     */
    public function set_fields($fields, $table = 'Contact', $id = NULL)
    {
        $ids     = is_array($id) ? $id : array($id);
        $results = array();
        
        foreach ($ids as $id)
        {
            $results[] = $this->dsUpdate($table, ($table == 'Contact' ? $this->contact_id : $id), $fields);
        }
        
        $this->contact_id = is_null($this->preserve) ? $this->contact_id : $this->preserve;
        $this->preserve   = NULL;
        
        return implode(PHP_EOL, $results);
    }

    /**
     * Add a note to a contact record
     *
     * @param  string        $title The title of the note being created
     * @param  string        $text  A detailed description of the note being created
     * @return iSDK_enhanced
     */
    public function add_note($title, $text)
    {
        $this->dsAdd(
            'ContactAction',
            array(
                'ContactId' => $this->contact_id,
                'UserID' => 1,
                'ActionType' => 'Other',
                'ActionDescription' => $title,
                'CreationNotes' => $text,
                'CompletionDate' => $this->now()
            )
        );
        
        return $this;
    }
    
    /**
     * Set a date field to current time, or optionally, an adjusted time
     *
     * @param  string        $field      The date/time field name
     * @param  string        $adjustment (Optional) The relative adjustment string (i.e. '+1 day')
     * @param  string        $table      (Optional) The source table of the field
     * @return iSDK_enhanced
     */
    public function set_date($field, $adjustment = NULL, $table = 'Contact')
    {
        return $this->set_field(
            $field,
            $this->infuDate(
                date(
                    'Ymd\TH:i:s',
                    ($adjustment
                        ? strtotime($adjustment, time())
                        : time())
                )
            ),
            $table
        );
    }
    
    /**
     * Add a specific tag to a contact record
     *
     * @param  int           $tag_id The tag ID to which a contact will be assigned
     * @return iSDK_enhanced
     */
    public function add_tag($tag_id)
    {
        $this->grpAssign($this->contact_id, $tag_id);
        
        return $this;
    }
    
    /**
     * Add a specific list of tags to a contact record
     *
     * @param  int[]         $tag_ids An array of tag IDs to which a contact will be assigned
     * @return iSDK_enhanced
     */
    public function add_tags($tag_ids)
    {
        if ($tag_ids)
        {
            foreach ($tag_ids as $tag_id)
            {
                $this->add_tag($tag_id);
            }
        }
        
        return $this;
    }
    
    /**
     * Remove a specific tag from a contact record
     *
     * @param  int           $tag_id The tag ID from which a contact will be removed
     * @return iSDK_enhanced
     */
    public function remove_tag($tag_id)
    {
        $this->grpRemove($this->contact_id, $tag_id);
        
        return $this;
    }
    
    /**
     * Create a tag/group category with the specified category name
     *
     * @param  string   $category The name of the tag category to be created
     * @return int|NULL           The newly created category ID, or NULL if failed
     */
    public function create_tag_category($category)
    {
        $category_id = (int)$this->dsAdd('ContactGroupCategory', array('CategoryName' => $category));
        
        return @($category_id ? $category_id : NULL);
    }
    
    /**
     * Retrieve a tag/group category's ID by name
     *
     * @param  string   $category The name of the category whose ID should be retrieved
     * @return int|NULL           The category ID, or NULL if failed
     */
    public function get_tag_category_id($category)
    {
        $categories = $this->dsFind('ContactGroupCategory', 1, 0, 'CategoryName', $category, array('Id'));
    
        return (is_array($categories) && $categories) ? (int)$categories[0]['Id'] : NULL;
    }
    
    /**
     * Apply tag to contact, and create if it doesn't exist. Create category if it doesn't exist
     *
     * @param  string     $tag_name The name of the tag to apply and create if not existing
     * @param  int|string $category (Optional) The category ID or the category name within which the tag
     *                              exists or should be created. Category will only be created if
     *                              category name is supplied, and not if ID is supplied
     * @return iSDK_enhanced
     */
    public function add_tag_by_name($tag_name, $category = 0)
    {
        if (is_string($category) && ! ($category_id = $this->get_tag_category_id($category)))
        {
            $category_id = $this->create_tag_category($category);
        }

        $category_id = is_int($category) ? $category : (isset($category_id) ? $category_id : 0);

        $query = array('GroupCategoryId' => $category_id, 'GroupName' => $tag_name);

        $tag_id = (int)((is_array($tags = $this->dsQuery('ContactGroup', 1, 0, $query, array('Id'))) && $tags)
            ? $tags[0]['Id']
            : $this->dsAdd('ContactGroup', $query));

        return $this->add_tag($tag_id);
    }
    
    /**
     * [Incomplete]
     *
     * Copy data from field A to field B with optional
     * callback to process any modifications to field A data
     * prior to saving in field B
     *
     * @param  mixed[]       $src      The field to be copied structured as: array(field_name, field_table, item_id)
     * @param  mixed[]       $dest     The field to which data should be saved structured as: array(field_name, field_table, item_id)
     * @param  callable      $callback A function that takes one param by ref and makes any desired modifications
     * @return iSDK_enhanced
     * @todo   Validate the callback function
     * @todo   Make override-able abstract function to be implimented by Contact/Invoice/etc classes
     * @todo   Refactor and tailor to concentrated classes
     */
    public function copy_field($src, $dest, $callback = NULL)
    {
        if (count($src) < 3 OR count($dest) < 3)
        {
            throw new Exception('Invalid param construct');
        }
        
        list($name, $table, $id) = $src;
        
        $src = $this->get_field($name, $table, $id);
        
        if ($callback)
        {
            call_user_func_array($callback, array(&$src));
        }

        list($name, $table, $id) = $dest;
        
        return $this->set_field($name, $src, $table, $id);
    }
    
    /**
     * Remove a specific list of tags from a contact record
     *
     * @param  int[]         $tag_ids An array of tag IDs from which a contact will be removed
     * @return iSDK_enhanced
     */
    public function remove_tags($tag_ids)
    {
        if ( ! is_array($tag_ids) || ! $tag_ids)
        {
            return $this;
        }

        foreach ($tag_ids as $tag_id)
        {
            $this->remove_tag($tag_id);
        }

        return $this;
    }

    /**
     * Create a company record with the specified company name
     *
     * @param  string     $company The name of the company being created
     * @return int|string          Return the company ID, or some error string if it fails
     */
    public function create_company($company)
    {
        return (int)$this->dsAdd('Company', array('Company' => $company));
    }

    /**
     * Retrieve a company's ID
     *
     * @param  string     $company The name of the company whose ID is being retrieved
     * @return int|NULL            Return the company ID, or NULL if none found
     */
    public function get_company_id($company)
    {
        $company = $this->dsQuery('Company', 1, 0, array('Company' => $company), array('Id'));
        
        return (is_array($company) && $company) ? (int)$company[0]['Id'] : NULL;
    }

    /**
     * Set a contact's company to the company specified; create company if doesn't exist
     *
     * @param  string     $company The name of the company to which the contact is associated
     * @return int|FALSE           Return the company ID, or FALSE if failed
     */
    public function set_company($company)
    {
        $company_id = $this->get_company_id($company);
        
        if ( ! $company_id)
        {
            $company_id = $this->create_company($company);
        }
        
        if ( ! (int)$company_id)
        {
            return FALSE;
        }

        $this->set_field('Company',   $company);
        $this->set_field('CompanyID', $company_id);
        
        return $company_id;
    }
    
    /**
     * Return a grouped list of all phone number data for a specified contact
     *
     * @param  int     $limit Limit the search to only X of the 5 available fields
     * @return mixed[]
     */
    public function get_phone_numbers($limit = 5)
    {
        $limit   = (int)$limit ? (($limit <= 0) ? 1 : (($limit > 5) ? 5 : $limit)) : 1;
        $fields  = array();
        $results = array();
        $base    = array('', 'Ext', 'Type');
        
        for ($i = 1; $i <= $limit; $i++)
        {
            foreach ($base as $field)
            {
                $fields[] = "Phone{$i}{$field}";
            }
        }
        
        $this->last_result = $this->dsLoad(
            'Contact',
            $this->contact_id,
            $fields
        );
        
        if ($this->last_result)
        {
            $this->last_result = array_merge(
                array_fill_keys($fields, ''),
                $this->last_result
            );
            
            foreach ($this->last_result as $field => $value)
            {
                preg_match('/Phone\d/', $field, $group);
                $group = $group[0];
                $type = str_replace($group, '', $field);
                
                if ( ! isset($result[$group]))
                {
                    $result[$group] = array();
                }
                
                $result[$group][$type ? $type : 'Number'] = $value;
            }
            
            $this->last_result = $result;
        }
        
        return $this->last_result;
    }
    
    /**
     * Return an e-mail template with Contact merge fields process
     *
     * @param  int      $id       The ID of the e-mail template to process
     * @param  callable $callback A callback that takes 1 arg by ref for custom handling of merge values
     * @return mixed[]
     * @todo   Add sig/slot support after adjustment of Namespace/Class architecture
     */
    public function get_email_template($id, $callback = NULL)
    {
        $id = (int)$id;
        
        if ( ! $id)
        {
            return FALSE;
        }
        
        $template = $this->getEmailTemplate($id);
        $owner_id = $this->get_owner_id();
        
        /*
         * Process any 'Contact' merge fields
         */
        if (preg_match_all(
                '/~Contact.([a-zA-Z0-9_-]*?)~/',
                $template['subject'] . ' ' . $template['textBody'] . ' ' . $template['htmlBody'],
                $merge_fields
            ))
        {
            $merge_fields = array_unique($merge_fields[1]);
            sort($merge_fields);
            $merge_values = $this->dsQuery('Contact', 1, 0, array('Id' => $this->contact_id), $merge_fields);
            $merge_fields = array_fill_keys($merge_fields, '');
            $merge_values = array_merge($merge_fields, $merge_values[0]);
            
            if (is_callable($callback))
            {
                call_user_func_array($callback, array(&$merge_values));
            }
            
            foreach (array('subject', 'textBody', 'htmlBody') as $part)
            {
                foreach ($merge_values as $field => $value)
                {
                    $template[$part] = str_replace("~Contact.{$field}~", $value, $template[$part]);
                }
            }
        }
        
        $template['fromAddress'] = str_replace('~Owner.', "~User({$owner_id}).", $template['fromAddress']);
        $template['fromAddress'] = $this->replace_merge_fields($template['fromAddress']);
        
        return $template;
    }
    
    public function get_owner_id()
    {
        return $this->get_field('OwnerID', 'Contact', $this->get_contact_id());
    }
    
    /**
     * Replace any merge field data within a given string or array of string input
     *
     * @param  string|string[] $input The content that may contain merge fields
     * @return string|string[]        The original input data with merge fields replaced
     */
    public function replace_merge_fields($input)
    {
        $search = implode(' ', array_filter(is_array($input) ? $input : array($input)));

        // Replace escaped tildes within qouted text
        $search = preg_replace('/(".*)\\\~(.*")/', "$1{esc:tilde}$2", $search);

        // Extract standard merge fields
        preg_match_all('/~Contact\.([a-zA-Z0-9_-]+)~/', $search, $merge_fields);

        /*
         * Extract advanced merge fields
         */
        if (preg_match_all('/~(?:[A-Z][a-zA-Z]+(?:\(\d*\))?)\.(?:[a-zA-Z0-9_]+)\.?.*?~/', $search, $advanced_fields) &&
            $merge_fields)
        {
            $advanced_fields = array_diff(array_pop($advanced_fields), $merge_fields[0]);
        }

        if ( ! ($merge_fields || $advanced_fields))
        {
            return $input;
        }

        $advanced_fields = array_unique(array_map(
            function ($a)
            {
                return trim(str_replace('{esc:tilde}', '~', $a), "\x0b\x7e\x20\t\n\r\0");
            },
            array_filter($advanced_fields)
        ));

        $custom_fields = $this->pluck($this->get_custom_fields(), 'Name');
        $table_fields  = $this->get_table_fields('Contact');
        $merge_fields  = array_map('array_values', array_map('array_unique', $merge_fields));

        $query_fields = array_filter(
            $merge_fields[1],
            function ($a) use ($custom_fields, $table_fields)
            {
                return in_array(ltrim($a, '_'), $custom_fields) || in_array($a, $table_fields);
            }
        );

        if ($query_fields)
        {
            $merge_values    = $this->dsQuery('Contact', 1, 0, array('Id' => $this->contact_id), array_values($query_fields));
            $merge_values    = array_merge(array_fill_keys(array_values($merge_fields[1]), NULL), $merge_values[0]);
            $merge_fields[1] = array_merge(array_fill_keys(array_values($merge_fields[1]), NULL), $merge_values);
            $merge_fields    = array_combine($merge_fields[0], $merge_fields[1]);
        }
        else
        {
            $merge_fields = array();
        }

        if ($advanced_fields)
        {
            $advanced_fields = array_fill_keys($advanced_fields, NULL);

            foreach ($advanced_fields as $field => &$value)
            {
                $value = $this->get_field(html_entity_decode($field));
            }

            unset($value);

            $advanced_fields = array_combine(
                array_map(
                    function ($a)
                    {
                        return "~{$a}~";
                    },
                    array_keys($advanced_fields)
                ),
                $advanced_fields
            );

            $merge_fields = array_merge($merge_fields, $advanced_fields);
        }

        if ( ! is_array($input))
        {
            return str_replace(array_keys($merge_fields), $merge_fields, $input);
        }

        foreach ($input as &$content)
        {
            $content = str_replace(array_keys($merge_fields), $merge_fields, $content);
        }

        unset($content);

        return $input;
    }

    /**
     * Upload one or more files to the global or contact's filebox, either
     * by providing file paths, reading from uploaded content contained within
     * the superglobal $_FILES, or a combination of both
     *
     * @param  mixed   $files           Either a file path, or an array of file paths, to be uploaded
     * @param  bool    $ignore_uploaded Set TRUE to ignore any uploaded content within $_FILES superglobal
     * @return mixed[]|FALSE
     */
    public function upload_files($files = NULL, $ignore_uploaded = FALSE)
    {
        if ( ! ($files OR $_FILES))
        {
            return FALSE;
        }
        
        $results = array();
        
        if ($files && ! is_array($files))
        {
            $files = array($files);
        }
        
        if ($files)
        {
            $_files = array();
            
            foreach ($files as $file)
            {
                $_files[] = array(
                    'path' => $file,
                    'name' => basename($file)
                );
            }
            
            $files = $_files;
        }
        
        if ($_FILES && ! $ignore_uploaded)
        {
            $files = is_array($files) ? $files : array();
            
            foreach ($_FILES as $batch => $content)
            {
                foreach ($_FILES[$batch]['tmp_name'] as $index => $path)
                {
                    /*
                     * Skip empty files, errored, non-form-uploaded, and inaccessable files
                     */
                    if ( ! ($_FILES[$batch]['size'][$index] &&
                            $_FILES[$batch]['error'][$index] == UPLOAD_ERR_OK &&
                            is_readable($path) &&
                            is_uploaded_file($path)))
                    {
                        $results[$_FILES[$batch]['name'][$index]] = FALSE;
                        
                        continue;
                    }
                    
                    $files[] = array(
                        'path' => $path,
                        'name' => $_FILES[$batch]['name'][$index]
                    );
                }
            }
        }
        
        if ($files)
        {
            foreach ($files as $file)
            {
                $results[$file['name']] = (int)$this->uploadFile($file['name'], base64_encode(file_get_contents($file['path'])), $this->get_contact_id());
            }
        }
        
        return $results;
    }

    /**
     * Retrieve opportunities with optional search parameters
     *
     * @param mixed[] $options   (Optional) Search options that correlate to Infusionsoft Lead table fields
     * @param string  $qualifier (Optional) (oldest|newest|latest)
     * @param string  $order_by  (Optional) Field by which to order results (DateCreated|LastUpdated|EstimatedCloseDate|NextActionDate)
     *
     * @return mixed[]
     *
     * @todo Switch to closures once eAccelerator problem is fixed
     */
    public function get_opportunities(array $options = array(), $qualifier = NULL, $order_by = 'DateCreated')
    {
        $options       = array_filter($options);
        $page          = 0;
        $opportunities = array();
        $qualifiers    = array('first', 'oldest', 'latest', 'last', 'newest');
        $fields        = $this->get_table_fields('Lead');
        $order_fields  = array('DateCreated', 'LastUpdated', 'EstimatedCloseDate', 'NextActionDate');
        $return        = array_merge(array('Id', 'UserID', 'AffiliateId', 'StageID'), $order_fields);
        $query         = array_filter(array_merge(
            array('ContactID' => $this->get_contact_id()),
            array_intersect_key($options, array_fill_keys($fields, NULL))
        ));

        while ($_opportunities = $this->dsQuery('Lead', 999, $page++, $query, $return))
        {
            $opportunities = array_merge($opportunities, $_opportunities);
        }
        
        if ( ! $opportunities)
        {
            return array();
        }
        
        if ($order_by && in_array($order_by, $order_fields))
        {
            usort(
                $opportunities,
                function ($a, $b) use ($order_by)
                {
                    $a = strtotime($a[$order_by]);
                    $b = strtotime($b[$order_by]);
                    
                    return ($a == $b) ? 0 : (($a > $b) ? 1 : -1);
                }
            );
            
            /*
             * use if eAccelerator or some other optimizer problem comes back
            $cust_sort = create_function('$a,$b', '$a = strtotime($a["' . $order_by . '"]); $b = strtotime($b["' . $order_by . '"]); return ($a == $b) ? 0 : (($a > $b) ? 1 : -1);');
            usort($opportunities, $cust_sort);
            */
        }
        
        if ($qualifier && in_array(($qualifier = trim(strtolower($qualifier))), $qualifiers))
        {
            switch($qualifier)
            {
                case 'latest':
                case 'last':
                case 'newest':  $opportunities = array(array_pop($opportunities)); break;
                
                case 'first':
                case 'oldest': $opportunities = array(array_shift($opportunities)); break;
            }
        }
        
        return $opportunities;
    }
    
    /**
     * Extend the contents of an array
     *
     * @param  &mixed[] $src       The source array to be extended
     * @param  mixed[]  $extension The array with which to extend
     * @return void
     *
     * @todo Move to helper class
     */
    static private function extend_array(&$src, $extension)
    {
        if ($extension && is_array($extension))
        {
            $src = array_unique(array_filter(array_merge($src, $extension)));
        }
    }

    /**
     * Sort an array by standard Infusionsoft 'DateCreated' element
     *
     * @todo: Move to helper class
     */
    static private function sort_by_date_created(&$src)
    {
        self::sort_assoc_array_by_value($src, 'DateCreated', TRUE);
    }

    /**
     * Sort an array by a specific key value
     *
     * @todo: Move to helper class
     */
    static private function sort_assoc_array_by_value(&$src, $key, $is_timestamp = FALSE)
    {
        usort(
            $src,
            function ($a, $b) use ($key, $is_timestamp)
            {
                $a = isset($a[$key])
                    ? ($is_timestamp ? strtotime($a[$key]) : $a[$key])
                    : 0;
                    
                $b = isset($b[$key])
                    ? ($is_timestamp ? strtotime($b[$key]) : $b[$key])
                    : 0;
                
                return (($a > $b)
                    ? 1
                    : (($a < $b)
                        ? -1
                        : 0));
            }
        );

        /*
        $cust_sort = create_function('$a,$b', 'return ((strtotime($a["' . $key . '"]) > strtotime($b["' . $key . '"])) ? 1 : ((strtotime($a["' . $key . '"]) < strtotime($b["' . $key . '"])) ? -1 : 0));');
        usort($src, $cust_sort);
        */
    }

    static private function extract_quoted_text($content, $numeric_keys = FALSE)
    {
        $strings = array_filter(
            preg_match_all('/".*?"/', str_replace('\"', '{esc:quote}', $content), $strings)
                ? $strings[0]
                : array()
        );

        if ( ! is_array($strings) || ! $strings)
        {
            return array();
        }
        
        return array_combine(
            array_map(
                function ($a) use ($numeric_keys)
                {
                    return $numeric_keys ? (int)$a : "{{$a}}";
                },
                array_keys($strings)
            ),
            array_map(
                function ($a)
                {
                    return str_replace('{esc:quote}', '"', $a);
                },
                $strings
            )
        );
    }

    /**
     * Return a flat array of particular column within a multi-dim array
     *
     * @param  mixed[] $array The array of associative arrays (record set)
     * @return string  $key   The column to extract
     *
     * @todo   Move to helper class
     */
    public function pluck(array $array, $key)
    {
        if ( ! is_array($array) OR ! $array) return array();
        
        if (function_exists('array_column'))
        {
            return array_column($array, $key);
        }
        
        $plucked = array();
        
        foreach ($array as $k => $v)
        {
            $plucked[] = isset($v[$key]) ? $v[$key] : NULL;
        }
        
        return $plucked;
    }

    /**
     * Parse Table.Field.qualifier annotation
     *
     * @param  string  $field The field annotation to parse
     * @return mixed[] An array of [table, field, [qualifiers]]
     */
    public function parse_field($field, $only = FALSE, $default_table = NULL)
    {
        $id = NULL;
        
        /*
         * Handle fields that specify table and qualifiers
         */
        if (strpos($field, '.') !== FALSE)
        {
            // Simple table/field notation
            if (substr_count($field, '.') == 1)
            {
                $fields = explode('.', $field);
            }
            // Advanced notation with qualifiers
            else
            {
                $strings = self::extract_quoted_text($field);

                // Replace our quoted "string" occurrences with {#} notation to replace later
                $field = (is_array($strings) && $strings) ? str_replace($strings, array_keys($strings), $field) : $field;

                preg_match_all('/([a-zA-Z0-9_]+(?:\(?[^\.]+\))?)/', $field, $matches);
            }
        }

        if (isset($matches) && $matches)
        {
            $fields = $matches[0];
        }
        elseif (isset($fields) && $fields)
        {
            $fields = $fields;
        }
        else
        {
            $fields = array(
                $default_table,
                ((isset($strings) && $strings)
                    ? str_replace(array_keys($strings), $strings, $field)
                    : $field)
            );
        }

        /*
         * Return any captured strings
         */
        if ($fields && isset($strings) && $strings)
        {
            foreach ($fields as &$field)
            {
                $field = str_replace(array_keys($strings), $strings, $field);
            }
            
            unset($field);
        }
        
        /*
         * ID specification/override
         */
        if (preg_match('/^([A-Z]{1}[a-zA-Z]+)(?:\((\d*)\))/', $fields[0], $matches))
        {
            $fields[0] = $matches[1];
            $id        = $matches[2];
        }
        
        switch (strtolower($only))
        {
            case 'table':      return preg_replace('/[^a-zA-Z0-9_]/', '', $fields[0]);
            case 'name':       return preg_replace('/[^a-zA-Z0-9_]/', '', $fields[1]);
            case 'id':         return $id;
            case 'qualifiers': return array_slice($fields, 2);
            default:           return array($fields[0], $fields[1], $id, array_slice($fields, 2));
        }
    }
    
    /**
     * Return contact id using email
     */
    public function cid_by_email($contact_email)
    {
        $find_contact_id = $this->findByEmail($contact_email, array('Id'));
        
        return $find_contact_id[0]['Id'];
    }
    
    /**
     * Set contact_id by email
     */
    public function set_cid_by_email($contact_email)
    {
        $this->contact_id = self::cid_by_email($contact_email);
    }
    
    /**
     * Find contacts by custom field
     */
    public function set_cid_by_custom_field($table = 'Contact', $custom_field, $value)
    {
        $contact = $this->dsFind($table, 1, 0, '_'.$custom_field, $value, array('Id'));
        
        return $this->contact_id = $contact[0]['Id'];
    }
    
    /**
     * Return user's open invoice with certain amount
     */
    public function open_invoice($inv_amount, $date)
    {
        $invoices = $this->get_invoices();
        
        foreach($invoices as $invoice)
        {
            if($inv_amount == money_format('%i', $invoice['InvoiceTotal']) && $invoice['PayStatus'] == 0 && $date == $invoice['DateCreated'])
            {
                $open_invoice[] = $invoice;
            }
        }
        
        return $open_invoice[0];
    }
    
    private function resolve_table($table)
    {
        return isset($this->table_alias[$table]) ? $this->table_alias[$table] : $table;
    }
}
