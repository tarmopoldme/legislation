<?php

namespace AppBundle\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use AppBundle\Model\Act as ChildAct;
use AppBundle\Model\ActQuery as ChildActQuery;
use AppBundle\Model\ActReference as ChildActReference;
use AppBundle\Model\ActReferenceQuery as ChildActReferenceQuery;
use AppBundle\Model\Map\ActReferenceTableMap;
use AppBundle\Model\Map\ActTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'act' table.
 *
 *
 *
 * @package    propel.generator.src.AppBundle.Model.Base
 */
abstract class Act implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\AppBundle\\Model\\Map\\ActTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the abbreviation field.
     *
     * @var        string
     */
    protected $abbreviation;

    /**
     * The value for the text field.
     *
     * @var        string
     */
    protected $text;

    /**
     * The value for the url field.
     *
     * @var        string
     */
    protected $url;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildActReference[] Collection to store aggregation of ChildActReference objects.
     */
    protected $collActReferencesRelatedBySourceActId;
    protected $collActReferencesRelatedBySourceActIdPartial;

    /**
     * @var        ObjectCollection|ChildActReference[] Collection to store aggregation of ChildActReference objects.
     */
    protected $collActReferencesRelatedByTargetActId;
    protected $collActReferencesRelatedByTargetActIdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildActReference[]
     */
    protected $actReferencesRelatedBySourceActIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildActReference[]
     */
    protected $actReferencesRelatedByTargetActIdScheduledForDeletion = null;

    /**
     * Initializes internal state of AppBundle\Model\Base\Act object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Act</code> instance.  If
     * <code>obj</code> is an instance of <code>Act</code>, delegates to
     * <code>equals(Act)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Act The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [abbreviation] column value.
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * Get the [text] column value.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Get the [url] column value.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ActTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[ActTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [abbreviation] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setAbbreviation($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->abbreviation !== $v) {
            $this->abbreviation = $v;
            $this->modifiedColumns[ActTableMap::COL_ABBREVIATION] = true;
        }

        return $this;
    } // setAbbreviation()

    /**
     * Set the value of [text] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setText($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->text !== $v) {
            $this->text = $v;
            $this->modifiedColumns[ActTableMap::COL_TEXT] = true;
        }

        return $this;
    } // setText()

    /**
     * Set the value of [url] column.
     *
     * @param string $v new value
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setUrl($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->url !== $v) {
            $this->url = $v;
            $this->modifiedColumns[ActTableMap::COL_URL] = true;
        }

        return $this;
    } // setUrl()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ActTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ActTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ActTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ActTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ActTableMap::translateFieldName('Abbreviation', TableMap::TYPE_PHPNAME, $indexType)];
            $this->abbreviation = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ActTableMap::translateFieldName('Text', TableMap::TYPE_PHPNAME, $indexType)];
            $this->text = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ActTableMap::translateFieldName('Url', TableMap::TYPE_PHPNAME, $indexType)];
            $this->url = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ActTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ActTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 7; // 7 = ActTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\AppBundle\\Model\\Act'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ActTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildActQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collActReferencesRelatedBySourceActId = null;

            $this->collActReferencesRelatedByTargetActId = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Act::setDeleted()
     * @see Act::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildActQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ActTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ActTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
                if (!$this->isColumnModified(ActTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ActTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                ActTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->actReferencesRelatedBySourceActIdScheduledForDeletion !== null) {
                if (!$this->actReferencesRelatedBySourceActIdScheduledForDeletion->isEmpty()) {
                    \AppBundle\Model\ActReferenceQuery::create()
                        ->filterByPrimaryKeys($this->actReferencesRelatedBySourceActIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->actReferencesRelatedBySourceActIdScheduledForDeletion = null;
                }
            }

            if ($this->collActReferencesRelatedBySourceActId !== null) {
                foreach ($this->collActReferencesRelatedBySourceActId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->actReferencesRelatedByTargetActIdScheduledForDeletion !== null) {
                if (!$this->actReferencesRelatedByTargetActIdScheduledForDeletion->isEmpty()) {
                    \AppBundle\Model\ActReferenceQuery::create()
                        ->filterByPrimaryKeys($this->actReferencesRelatedByTargetActIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->actReferencesRelatedByTargetActIdScheduledForDeletion = null;
                }
            }

            if ($this->collActReferencesRelatedByTargetActId !== null) {
                foreach ($this->collActReferencesRelatedByTargetActId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[ActTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ActTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ActTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ActTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(ActTableMap::COL_ABBREVIATION)) {
            $modifiedColumns[':p' . $index++]  = 'abbreviation';
        }
        if ($this->isColumnModified(ActTableMap::COL_TEXT)) {
            $modifiedColumns[':p' . $index++]  = 'text';
        }
        if ($this->isColumnModified(ActTableMap::COL_URL)) {
            $modifiedColumns[':p' . $index++]  = 'url';
        }
        if ($this->isColumnModified(ActTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(ActTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO act (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'abbreviation':
                        $stmt->bindValue($identifier, $this->abbreviation, PDO::PARAM_STR);
                        break;
                    case 'text':
                        $stmt->bindValue($identifier, $this->text, PDO::PARAM_STR);
                        break;
                    case 'url':
                        $stmt->bindValue($identifier, $this->url, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ActTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getAbbreviation();
                break;
            case 3:
                return $this->getText();
                break;
            case 4:
                return $this->getUrl();
                break;
            case 5:
                return $this->getCreatedAt();
                break;
            case 6:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Act'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Act'][$this->hashCode()] = true;
        $keys = ActTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getAbbreviation(),
            $keys[3] => $this->getText(),
            $keys[4] => $this->getUrl(),
            $keys[5] => $this->getCreatedAt(),
            $keys[6] => $this->getUpdatedAt(),
        );
        if ($result[$keys[5]] instanceof \DateTime) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collActReferencesRelatedBySourceActId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'actReferences';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'act_references';
                        break;
                    default:
                        $key = 'ActReferences';
                }

                $result[$key] = $this->collActReferencesRelatedBySourceActId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collActReferencesRelatedByTargetActId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'actReferences';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'act_references';
                        break;
                    default:
                        $key = 'ActReferences';
                }

                $result[$key] = $this->collActReferencesRelatedByTargetActId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\AppBundle\Model\Act
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ActTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\AppBundle\Model\Act
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setAbbreviation($value);
                break;
            case 3:
                $this->setText($value);
                break;
            case 4:
                $this->setUrl($value);
                break;
            case 5:
                $this->setCreatedAt($value);
                break;
            case 6:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = ActTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setAbbreviation($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setText($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUrl($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedAt($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUpdatedAt($arr[$keys[6]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\AppBundle\Model\Act The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ActTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ActTableMap::COL_ID)) {
            $criteria->add(ActTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ActTableMap::COL_NAME)) {
            $criteria->add(ActTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(ActTableMap::COL_ABBREVIATION)) {
            $criteria->add(ActTableMap::COL_ABBREVIATION, $this->abbreviation);
        }
        if ($this->isColumnModified(ActTableMap::COL_TEXT)) {
            $criteria->add(ActTableMap::COL_TEXT, $this->text);
        }
        if ($this->isColumnModified(ActTableMap::COL_URL)) {
            $criteria->add(ActTableMap::COL_URL, $this->url);
        }
        if ($this->isColumnModified(ActTableMap::COL_CREATED_AT)) {
            $criteria->add(ActTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ActTableMap::COL_UPDATED_AT)) {
            $criteria->add(ActTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildActQuery::create();
        $criteria->add(ActTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \AppBundle\Model\Act (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setAbbreviation($this->getAbbreviation());
        $copyObj->setText($this->getText());
        $copyObj->setUrl($this->getUrl());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getActReferencesRelatedBySourceActId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addActReferenceRelatedBySourceActId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getActReferencesRelatedByTargetActId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addActReferenceRelatedByTargetActId($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \AppBundle\Model\Act Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('ActReferenceRelatedBySourceActId' == $relationName) {
            return $this->initActReferencesRelatedBySourceActId();
        }
        if ('ActReferenceRelatedByTargetActId' == $relationName) {
            return $this->initActReferencesRelatedByTargetActId();
        }
    }

    /**
     * Clears out the collActReferencesRelatedBySourceActId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addActReferencesRelatedBySourceActId()
     */
    public function clearActReferencesRelatedBySourceActId()
    {
        $this->collActReferencesRelatedBySourceActId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collActReferencesRelatedBySourceActId collection loaded partially.
     */
    public function resetPartialActReferencesRelatedBySourceActId($v = true)
    {
        $this->collActReferencesRelatedBySourceActIdPartial = $v;
    }

    /**
     * Initializes the collActReferencesRelatedBySourceActId collection.
     *
     * By default this just sets the collActReferencesRelatedBySourceActId collection to an empty array (like clearcollActReferencesRelatedBySourceActId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initActReferencesRelatedBySourceActId($overrideExisting = true)
    {
        if (null !== $this->collActReferencesRelatedBySourceActId && !$overrideExisting) {
            return;
        }

        $collectionClassName = ActReferenceTableMap::getTableMap()->getCollectionClassName();

        $this->collActReferencesRelatedBySourceActId = new $collectionClassName;
        $this->collActReferencesRelatedBySourceActId->setModel('\AppBundle\Model\ActReference');
    }

    /**
     * Gets an array of ChildActReference objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildActReference[] List of ChildActReference objects
     * @throws PropelException
     */
    public function getActReferencesRelatedBySourceActId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collActReferencesRelatedBySourceActIdPartial && !$this->isNew();
        if (null === $this->collActReferencesRelatedBySourceActId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collActReferencesRelatedBySourceActId) {
                // return empty collection
                $this->initActReferencesRelatedBySourceActId();
            } else {
                $collActReferencesRelatedBySourceActId = ChildActReferenceQuery::create(null, $criteria)
                    ->filterByActRelatedBySourceActId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collActReferencesRelatedBySourceActIdPartial && count($collActReferencesRelatedBySourceActId)) {
                        $this->initActReferencesRelatedBySourceActId(false);

                        foreach ($collActReferencesRelatedBySourceActId as $obj) {
                            if (false == $this->collActReferencesRelatedBySourceActId->contains($obj)) {
                                $this->collActReferencesRelatedBySourceActId->append($obj);
                            }
                        }

                        $this->collActReferencesRelatedBySourceActIdPartial = true;
                    }

                    return $collActReferencesRelatedBySourceActId;
                }

                if ($partial && $this->collActReferencesRelatedBySourceActId) {
                    foreach ($this->collActReferencesRelatedBySourceActId as $obj) {
                        if ($obj->isNew()) {
                            $collActReferencesRelatedBySourceActId[] = $obj;
                        }
                    }
                }

                $this->collActReferencesRelatedBySourceActId = $collActReferencesRelatedBySourceActId;
                $this->collActReferencesRelatedBySourceActIdPartial = false;
            }
        }

        return $this->collActReferencesRelatedBySourceActId;
    }

    /**
     * Sets a collection of ChildActReference objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $actReferencesRelatedBySourceActId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAct The current object (for fluent API support)
     */
    public function setActReferencesRelatedBySourceActId(Collection $actReferencesRelatedBySourceActId, ConnectionInterface $con = null)
    {
        /** @var ChildActReference[] $actReferencesRelatedBySourceActIdToDelete */
        $actReferencesRelatedBySourceActIdToDelete = $this->getActReferencesRelatedBySourceActId(new Criteria(), $con)->diff($actReferencesRelatedBySourceActId);


        $this->actReferencesRelatedBySourceActIdScheduledForDeletion = $actReferencesRelatedBySourceActIdToDelete;

        foreach ($actReferencesRelatedBySourceActIdToDelete as $actReferenceRelatedBySourceActIdRemoved) {
            $actReferenceRelatedBySourceActIdRemoved->setActRelatedBySourceActId(null);
        }

        $this->collActReferencesRelatedBySourceActId = null;
        foreach ($actReferencesRelatedBySourceActId as $actReferenceRelatedBySourceActId) {
            $this->addActReferenceRelatedBySourceActId($actReferenceRelatedBySourceActId);
        }

        $this->collActReferencesRelatedBySourceActId = $actReferencesRelatedBySourceActId;
        $this->collActReferencesRelatedBySourceActIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ActReference objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ActReference objects.
     * @throws PropelException
     */
    public function countActReferencesRelatedBySourceActId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collActReferencesRelatedBySourceActIdPartial && !$this->isNew();
        if (null === $this->collActReferencesRelatedBySourceActId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collActReferencesRelatedBySourceActId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getActReferencesRelatedBySourceActId());
            }

            $query = ChildActReferenceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByActRelatedBySourceActId($this)
                ->count($con);
        }

        return count($this->collActReferencesRelatedBySourceActId);
    }

    /**
     * Method called to associate a ChildActReference object to this object
     * through the ChildActReference foreign key attribute.
     *
     * @param  ChildActReference $l ChildActReference
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function addActReferenceRelatedBySourceActId(ChildActReference $l)
    {
        if ($this->collActReferencesRelatedBySourceActId === null) {
            $this->initActReferencesRelatedBySourceActId();
            $this->collActReferencesRelatedBySourceActIdPartial = true;
        }

        if (!$this->collActReferencesRelatedBySourceActId->contains($l)) {
            $this->doAddActReferenceRelatedBySourceActId($l);

            if ($this->actReferencesRelatedBySourceActIdScheduledForDeletion and $this->actReferencesRelatedBySourceActIdScheduledForDeletion->contains($l)) {
                $this->actReferencesRelatedBySourceActIdScheduledForDeletion->remove($this->actReferencesRelatedBySourceActIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildActReference $actReferenceRelatedBySourceActId The ChildActReference object to add.
     */
    protected function doAddActReferenceRelatedBySourceActId(ChildActReference $actReferenceRelatedBySourceActId)
    {
        $this->collActReferencesRelatedBySourceActId[]= $actReferenceRelatedBySourceActId;
        $actReferenceRelatedBySourceActId->setActRelatedBySourceActId($this);
    }

    /**
     * @param  ChildActReference $actReferenceRelatedBySourceActId The ChildActReference object to remove.
     * @return $this|ChildAct The current object (for fluent API support)
     */
    public function removeActReferenceRelatedBySourceActId(ChildActReference $actReferenceRelatedBySourceActId)
    {
        if ($this->getActReferencesRelatedBySourceActId()->contains($actReferenceRelatedBySourceActId)) {
            $pos = $this->collActReferencesRelatedBySourceActId->search($actReferenceRelatedBySourceActId);
            $this->collActReferencesRelatedBySourceActId->remove($pos);
            if (null === $this->actReferencesRelatedBySourceActIdScheduledForDeletion) {
                $this->actReferencesRelatedBySourceActIdScheduledForDeletion = clone $this->collActReferencesRelatedBySourceActId;
                $this->actReferencesRelatedBySourceActIdScheduledForDeletion->clear();
            }
            $this->actReferencesRelatedBySourceActIdScheduledForDeletion[]= clone $actReferenceRelatedBySourceActId;
            $actReferenceRelatedBySourceActId->setActRelatedBySourceActId(null);
        }

        return $this;
    }

    /**
     * Clears out the collActReferencesRelatedByTargetActId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addActReferencesRelatedByTargetActId()
     */
    public function clearActReferencesRelatedByTargetActId()
    {
        $this->collActReferencesRelatedByTargetActId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collActReferencesRelatedByTargetActId collection loaded partially.
     */
    public function resetPartialActReferencesRelatedByTargetActId($v = true)
    {
        $this->collActReferencesRelatedByTargetActIdPartial = $v;
    }

    /**
     * Initializes the collActReferencesRelatedByTargetActId collection.
     *
     * By default this just sets the collActReferencesRelatedByTargetActId collection to an empty array (like clearcollActReferencesRelatedByTargetActId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initActReferencesRelatedByTargetActId($overrideExisting = true)
    {
        if (null !== $this->collActReferencesRelatedByTargetActId && !$overrideExisting) {
            return;
        }

        $collectionClassName = ActReferenceTableMap::getTableMap()->getCollectionClassName();

        $this->collActReferencesRelatedByTargetActId = new $collectionClassName;
        $this->collActReferencesRelatedByTargetActId->setModel('\AppBundle\Model\ActReference');
    }

    /**
     * Gets an array of ChildActReference objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAct is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildActReference[] List of ChildActReference objects
     * @throws PropelException
     */
    public function getActReferencesRelatedByTargetActId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collActReferencesRelatedByTargetActIdPartial && !$this->isNew();
        if (null === $this->collActReferencesRelatedByTargetActId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collActReferencesRelatedByTargetActId) {
                // return empty collection
                $this->initActReferencesRelatedByTargetActId();
            } else {
                $collActReferencesRelatedByTargetActId = ChildActReferenceQuery::create(null, $criteria)
                    ->filterByActRelatedByTargetActId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collActReferencesRelatedByTargetActIdPartial && count($collActReferencesRelatedByTargetActId)) {
                        $this->initActReferencesRelatedByTargetActId(false);

                        foreach ($collActReferencesRelatedByTargetActId as $obj) {
                            if (false == $this->collActReferencesRelatedByTargetActId->contains($obj)) {
                                $this->collActReferencesRelatedByTargetActId->append($obj);
                            }
                        }

                        $this->collActReferencesRelatedByTargetActIdPartial = true;
                    }

                    return $collActReferencesRelatedByTargetActId;
                }

                if ($partial && $this->collActReferencesRelatedByTargetActId) {
                    foreach ($this->collActReferencesRelatedByTargetActId as $obj) {
                        if ($obj->isNew()) {
                            $collActReferencesRelatedByTargetActId[] = $obj;
                        }
                    }
                }

                $this->collActReferencesRelatedByTargetActId = $collActReferencesRelatedByTargetActId;
                $this->collActReferencesRelatedByTargetActIdPartial = false;
            }
        }

        return $this->collActReferencesRelatedByTargetActId;
    }

    /**
     * Sets a collection of ChildActReference objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $actReferencesRelatedByTargetActId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAct The current object (for fluent API support)
     */
    public function setActReferencesRelatedByTargetActId(Collection $actReferencesRelatedByTargetActId, ConnectionInterface $con = null)
    {
        /** @var ChildActReference[] $actReferencesRelatedByTargetActIdToDelete */
        $actReferencesRelatedByTargetActIdToDelete = $this->getActReferencesRelatedByTargetActId(new Criteria(), $con)->diff($actReferencesRelatedByTargetActId);


        $this->actReferencesRelatedByTargetActIdScheduledForDeletion = $actReferencesRelatedByTargetActIdToDelete;

        foreach ($actReferencesRelatedByTargetActIdToDelete as $actReferenceRelatedByTargetActIdRemoved) {
            $actReferenceRelatedByTargetActIdRemoved->setActRelatedByTargetActId(null);
        }

        $this->collActReferencesRelatedByTargetActId = null;
        foreach ($actReferencesRelatedByTargetActId as $actReferenceRelatedByTargetActId) {
            $this->addActReferenceRelatedByTargetActId($actReferenceRelatedByTargetActId);
        }

        $this->collActReferencesRelatedByTargetActId = $actReferencesRelatedByTargetActId;
        $this->collActReferencesRelatedByTargetActIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ActReference objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ActReference objects.
     * @throws PropelException
     */
    public function countActReferencesRelatedByTargetActId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collActReferencesRelatedByTargetActIdPartial && !$this->isNew();
        if (null === $this->collActReferencesRelatedByTargetActId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collActReferencesRelatedByTargetActId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getActReferencesRelatedByTargetActId());
            }

            $query = ChildActReferenceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByActRelatedByTargetActId($this)
                ->count($con);
        }

        return count($this->collActReferencesRelatedByTargetActId);
    }

    /**
     * Method called to associate a ChildActReference object to this object
     * through the ChildActReference foreign key attribute.
     *
     * @param  ChildActReference $l ChildActReference
     * @return $this|\AppBundle\Model\Act The current object (for fluent API support)
     */
    public function addActReferenceRelatedByTargetActId(ChildActReference $l)
    {
        if ($this->collActReferencesRelatedByTargetActId === null) {
            $this->initActReferencesRelatedByTargetActId();
            $this->collActReferencesRelatedByTargetActIdPartial = true;
        }

        if (!$this->collActReferencesRelatedByTargetActId->contains($l)) {
            $this->doAddActReferenceRelatedByTargetActId($l);

            if ($this->actReferencesRelatedByTargetActIdScheduledForDeletion and $this->actReferencesRelatedByTargetActIdScheduledForDeletion->contains($l)) {
                $this->actReferencesRelatedByTargetActIdScheduledForDeletion->remove($this->actReferencesRelatedByTargetActIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildActReference $actReferenceRelatedByTargetActId The ChildActReference object to add.
     */
    protected function doAddActReferenceRelatedByTargetActId(ChildActReference $actReferenceRelatedByTargetActId)
    {
        $this->collActReferencesRelatedByTargetActId[]= $actReferenceRelatedByTargetActId;
        $actReferenceRelatedByTargetActId->setActRelatedByTargetActId($this);
    }

    /**
     * @param  ChildActReference $actReferenceRelatedByTargetActId The ChildActReference object to remove.
     * @return $this|ChildAct The current object (for fluent API support)
     */
    public function removeActReferenceRelatedByTargetActId(ChildActReference $actReferenceRelatedByTargetActId)
    {
        if ($this->getActReferencesRelatedByTargetActId()->contains($actReferenceRelatedByTargetActId)) {
            $pos = $this->collActReferencesRelatedByTargetActId->search($actReferenceRelatedByTargetActId);
            $this->collActReferencesRelatedByTargetActId->remove($pos);
            if (null === $this->actReferencesRelatedByTargetActIdScheduledForDeletion) {
                $this->actReferencesRelatedByTargetActIdScheduledForDeletion = clone $this->collActReferencesRelatedByTargetActId;
                $this->actReferencesRelatedByTargetActIdScheduledForDeletion->clear();
            }
            $this->actReferencesRelatedByTargetActIdScheduledForDeletion[]= clone $actReferenceRelatedByTargetActId;
            $actReferenceRelatedByTargetActId->setActRelatedByTargetActId(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->name = null;
        $this->abbreviation = null;
        $this->text = null;
        $this->url = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collActReferencesRelatedBySourceActId) {
                foreach ($this->collActReferencesRelatedBySourceActId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collActReferencesRelatedByTargetActId) {
                foreach ($this->collActReferencesRelatedByTargetActId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collActReferencesRelatedBySourceActId = null;
        $this->collActReferencesRelatedByTargetActId = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ActTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildAct The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ActTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
