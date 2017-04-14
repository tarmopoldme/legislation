<?php

namespace AppBundle\Model\Map;

use AppBundle\Model\Act;
use AppBundle\Model\ActQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'act' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ActTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.AppBundle.Model.Map.ActTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'act';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\AppBundle\\Model\\Act';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'src.AppBundle.Model.Act';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'act.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'act.name';

    /**
     * the column name for the abbreviation field
     */
    const COL_ABBREVIATION = 'act.abbreviation';

    /**
     * the column name for the text field
     */
    const COL_TEXT = 'act.text';

    /**
     * the column name for the xml field
     */
    const COL_XML = 'act.xml';

    /**
     * the column name for the url field
     */
    const COL_URL = 'act.url';

    /**
     * the column name for the confirmity_weight field
     */
    const COL_CONFIRMITY_WEIGHT = 'act.confirmity_weight';

    /**
     * the column name for the betweenness_weight field
     */
    const COL_BETWEENNESS_WEIGHT = 'act.betweenness_weight';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'act.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'act.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Abbreviation', 'Text', 'Xml', 'Url', 'ConfirmityWeight', 'BetweennessWeight', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'abbreviation', 'text', 'xml', 'url', 'confirmityWeight', 'betweennessWeight', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ActTableMap::COL_ID, ActTableMap::COL_NAME, ActTableMap::COL_ABBREVIATION, ActTableMap::COL_TEXT, ActTableMap::COL_XML, ActTableMap::COL_URL, ActTableMap::COL_CONFIRMITY_WEIGHT, ActTableMap::COL_BETWEENNESS_WEIGHT, ActTableMap::COL_CREATED_AT, ActTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'abbreviation', 'text', 'xml', 'url', 'confirmity_weight', 'betweenness_weight', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Abbreviation' => 2, 'Text' => 3, 'Xml' => 4, 'Url' => 5, 'ConfirmityWeight' => 6, 'BetweennessWeight' => 7, 'CreatedAt' => 8, 'UpdatedAt' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'abbreviation' => 2, 'text' => 3, 'xml' => 4, 'url' => 5, 'confirmityWeight' => 6, 'betweennessWeight' => 7, 'createdAt' => 8, 'updatedAt' => 9, ),
        self::TYPE_COLNAME       => array(ActTableMap::COL_ID => 0, ActTableMap::COL_NAME => 1, ActTableMap::COL_ABBREVIATION => 2, ActTableMap::COL_TEXT => 3, ActTableMap::COL_XML => 4, ActTableMap::COL_URL => 5, ActTableMap::COL_CONFIRMITY_WEIGHT => 6, ActTableMap::COL_BETWEENNESS_WEIGHT => 7, ActTableMap::COL_CREATED_AT => 8, ActTableMap::COL_UPDATED_AT => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'abbreviation' => 2, 'text' => 3, 'xml' => 4, 'url' => 5, 'confirmity_weight' => 6, 'betweenness_weight' => 7, 'created_at' => 8, 'updated_at' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('act');
        $this->setPhpName('Act');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\AppBundle\\Model\\Act');
        $this->setPackage('src.AppBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('abbreviation', 'Abbreviation', 'VARCHAR', true, 10, null);
        $this->addColumn('text', 'Text', 'LONGVARCHAR', false, null, null);
        $this->addColumn('xml', 'Xml', 'LONGVARCHAR', false, null, null);
        $this->addColumn('url', 'Url', 'VARCHAR', false, 255, null);
        $this->addColumn('confirmity_weight', 'ConfirmityWeight', 'INTEGER', false, null, null);
        $this->addColumn('betweenness_weight', 'BetweennessWeight', 'DECIMAL', false, 12, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ActReferenceRelatedBySourceActId', '\\AppBundle\\Model\\ActReference', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':source_act_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ActReferencesRelatedBySourceActId', false);
        $this->addRelation('ActReferenceRelatedByTargetActId', '\\AppBundle\\Model\\ActReference', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':target_act_id',
    1 => ':id',
  ),
), 'CASCADE', 'CASCADE', 'ActReferencesRelatedByTargetActId', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to act     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ActReferenceTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? ActTableMap::CLASS_DEFAULT : ActTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Act object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ActTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ActTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ActTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ActTableMap::OM_CLASS;
            /** @var Act $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ActTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = ActTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ActTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Act $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ActTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ActTableMap::COL_ID);
            $criteria->addSelectColumn(ActTableMap::COL_NAME);
            $criteria->addSelectColumn(ActTableMap::COL_ABBREVIATION);
            $criteria->addSelectColumn(ActTableMap::COL_TEXT);
            $criteria->addSelectColumn(ActTableMap::COL_XML);
            $criteria->addSelectColumn(ActTableMap::COL_URL);
            $criteria->addSelectColumn(ActTableMap::COL_CONFIRMITY_WEIGHT);
            $criteria->addSelectColumn(ActTableMap::COL_BETWEENNESS_WEIGHT);
            $criteria->addSelectColumn(ActTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ActTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.abbreviation');
            $criteria->addSelectColumn($alias . '.text');
            $criteria->addSelectColumn($alias . '.xml');
            $criteria->addSelectColumn($alias . '.url');
            $criteria->addSelectColumn($alias . '.confirmity_weight');
            $criteria->addSelectColumn($alias . '.betweenness_weight');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(ActTableMap::DATABASE_NAME)->getTable(ActTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ActTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ActTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ActTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Act or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Act object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \AppBundle\Model\Act) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ActTableMap::DATABASE_NAME);
            $criteria->add(ActTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ActQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ActTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ActTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the act table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ActQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Act or Criteria object.
     *
     * @param mixed               $criteria Criteria or Act object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Act object
        }

        if ($criteria->containsKey(ActTableMap::COL_ID) && $criteria->keyContainsValue(ActTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ActTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ActQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ActTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ActTableMap::buildTableMap();
