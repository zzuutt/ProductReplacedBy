<?php

namespace ProductReplacedBy\Model\Base;

use \Exception;
use \PDO;
use ProductReplacedBy\Model\ProductReplacedBy as ChildProductReplacedBy;
use ProductReplacedBy\Model\ProductReplacedByQuery as ChildProductReplacedByQuery;
use ProductReplacedBy\Model\Map\ProductReplacedByTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;
use Thelia\Model\Product;

/**
 * Base class that represents a query for the 'product_replaced_by' table.
 *
 *
 *
 * @method     ChildProductReplacedByQuery orderByProductId($order = Criteria::ASC) Order by the product_id column
 * @method     ChildProductReplacedByQuery orderByReplacedById($order = Criteria::ASC) Order by the replaced_by_id column
 *
 * @method     ChildProductReplacedByQuery groupByProductId() Group by the product_id column
 * @method     ChildProductReplacedByQuery groupByReplacedById() Group by the replaced_by_id column
 *
 * @method     ChildProductReplacedByQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildProductReplacedByQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildProductReplacedByQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildProductReplacedByQuery leftJoinProductRelatedByProductId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductRelatedByProductId relation
 * @method     ChildProductReplacedByQuery rightJoinProductRelatedByProductId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductRelatedByProductId relation
 * @method     ChildProductReplacedByQuery innerJoinProductRelatedByProductId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductRelatedByProductId relation
 *
 * @method     ChildProductReplacedByQuery leftJoinProductRelatedByReplacedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProductRelatedByReplacedById relation
 * @method     ChildProductReplacedByQuery rightJoinProductRelatedByReplacedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProductRelatedByReplacedById relation
 * @method     ChildProductReplacedByQuery innerJoinProductRelatedByReplacedById($relationAlias = null) Adds a INNER JOIN clause to the query using the ProductRelatedByReplacedById relation
 *
 * @method     ChildProductReplacedBy findOne(ConnectionInterface $con = null) Return the first ChildProductReplacedBy matching the query
 * @method     ChildProductReplacedBy findOneOrCreate(ConnectionInterface $con = null) Return the first ChildProductReplacedBy matching the query, or a new ChildProductReplacedBy object populated from the query conditions when no match is found
 *
 * @method     ChildProductReplacedBy findOneByProductId(int $product_id) Return the first ChildProductReplacedBy filtered by the product_id column
 * @method     ChildProductReplacedBy findOneByReplacedById(int $replaced_by_id) Return the first ChildProductReplacedBy filtered by the replaced_by_id column
 *
 * @method     array findByProductId(int $product_id) Return ChildProductReplacedBy objects filtered by the product_id column
 * @method     array findByReplacedById(int $replaced_by_id) Return ChildProductReplacedBy objects filtered by the replaced_by_id column
 *
 */
abstract class ProductReplacedByQuery extends ModelCriteria
{

    /**
     * Initializes internal state of \ProductReplacedBy\Model\Base\ProductReplacedByQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'thelia', $modelName = '\\ProductReplacedBy\\Model\\ProductReplacedBy', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildProductReplacedByQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildProductReplacedByQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof \ProductReplacedBy\Model\ProductReplacedByQuery) {
            return $criteria;
        }
        $query = new \ProductReplacedBy\Model\ProductReplacedByQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildProductReplacedBy|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProductReplacedByTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ProductReplacedByTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return   ChildProductReplacedBy A model object, or null if the key is not found
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT PRODUCT_ID, REPLACED_BY_ID FROM product_replaced_by WHERE PRODUCT_ID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            $obj = new ChildProductReplacedBy();
            $obj->hydrate($row);
            ProductReplacedByTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildProductReplacedBy|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the product_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProductId(1234); // WHERE product_id = 1234
     * $query->filterByProductId(array(12, 34)); // WHERE product_id IN (12, 34)
     * $query->filterByProductId(array('min' => 12)); // WHERE product_id > 12
     * </code>
     *
     * @see       filterByProductRelatedByProductId()
     *
     * @param     mixed $productId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function filterByProductId($productId = null, $comparison = null)
    {
        if (is_array($productId)) {
            $useMinMax = false;
            if (isset($productId['min'])) {
                $this->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $productId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($productId['max'])) {
                $this->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $productId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $productId, $comparison);
    }

    /**
     * Filter the query on the replaced_by_id column
     *
     * Example usage:
     * <code>
     * $query->filterByReplacedById(1234); // WHERE replaced_by_id = 1234
     * $query->filterByReplacedById(array(12, 34)); // WHERE replaced_by_id IN (12, 34)
     * $query->filterByReplacedById(array('min' => 12)); // WHERE replaced_by_id > 12
     * </code>
     *
     * @see       filterByProductRelatedByReplacedById()
     *
     * @param     mixed $replacedById The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function filterByReplacedById($replacedById = null, $comparison = null)
    {
        if (is_array($replacedById)) {
            $useMinMax = false;
            if (isset($replacedById['min'])) {
                $this->addUsingAlias(ProductReplacedByTableMap::REPLACED_BY_ID, $replacedById['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($replacedById['max'])) {
                $this->addUsingAlias(ProductReplacedByTableMap::REPLACED_BY_ID, $replacedById['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProductReplacedByTableMap::REPLACED_BY_ID, $replacedById, $comparison);
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function filterByProductRelatedByProductId($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductRelatedByProductId() only accepts arguments of type \Thelia\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductRelatedByProductId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function joinProductRelatedByProductId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductRelatedByProductId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProductRelatedByProductId');
        }

        return $this;
    }

    /**
     * Use the ProductRelatedByProductId relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductRelatedByProductIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductRelatedByProductId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductRelatedByProductId', '\Thelia\Model\ProductQuery');
    }

    /**
     * Filter the query by a related \Thelia\Model\Product object
     *
     * @param \Thelia\Model\Product|ObjectCollection $product The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function filterByProductRelatedByReplacedById($product, $comparison = null)
    {
        if ($product instanceof \Thelia\Model\Product) {
            return $this
                ->addUsingAlias(ProductReplacedByTableMap::REPLACED_BY_ID, $product->getId(), $comparison);
        } elseif ($product instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProductReplacedByTableMap::REPLACED_BY_ID, $product->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByProductRelatedByReplacedById() only accepts arguments of type \Thelia\Model\Product or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProductRelatedByReplacedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function joinProductRelatedByReplacedById($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProductRelatedByReplacedById');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProductRelatedByReplacedById');
        }

        return $this;
    }

    /**
     * Use the ProductRelatedByReplacedById relation Product object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Thelia\Model\ProductQuery A secondary query class using the current class as primary query
     */
    public function useProductRelatedByReplacedByIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProductRelatedByReplacedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProductRelatedByReplacedById', '\Thelia\Model\ProductQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildProductReplacedBy $productReplacedBy Object to remove from the list of results
     *
     * @return ChildProductReplacedByQuery The current query, for fluid interface
     */
    public function prune($productReplacedBy = null)
    {
        if ($productReplacedBy) {
            $this->addUsingAlias(ProductReplacedByTableMap::PRODUCT_ID, $productReplacedBy->getProductId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the product_replaced_by table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductReplacedByTableMap::DATABASE_NAME);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ProductReplacedByTableMap::clearInstancePool();
            ProductReplacedByTableMap::clearRelatedInstancePool();

            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $affectedRows;
    }

    /**
     * Performs a DELETE on the database, given a ChildProductReplacedBy or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ChildProductReplacedBy object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *         rethrown wrapped into a PropelException.
     */
     public function delete(ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ProductReplacedByTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ProductReplacedByTableMap::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();


        ProductReplacedByTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ProductReplacedByTableMap::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

} // ProductReplacedByQuery
