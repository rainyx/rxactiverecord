<?php
/**
 * @copyright Copyright &copy; rainyx, rainyx.com, 2013 - 2017
 * @file ActiveQuery.php
 * @version ${VERSION}
 */

namespace rainyx\rxkit\db;


/**
 * Class ActiveQuery
 * @package rainyx\rxkit\db
 * @author rainyx <atrainyx#gmail.com>
 * @since 1.0
 */
class ActiveQuery extends \yii\db\ActiveQuery {

    public $polymorphic;
    public $as;


    public function originalFindFor($name, $model) {
        return parent::findFor($name, $model);
    }

    public function findFor($name, $model)
    {
        if ($this->multiple) {
            return \Yii::createObject(ActiveCollectionProxy::className(), [
                $name,
                $this,
            ]);
        } else {
            return $this->originalFindFor($name, $model);
        }
    }

    public function prepare($builder)
    {
        if (empty($this->from) && $this->polymorphic && !$this->as) {
            /* @var $modelClass ActiveRecord */
            $modelClass = get_class($this->primaryModel);
            $tableName = $modelClass::tableName();
            $this->from = [$tableName];
        }

        return parent::prepare($builder); // TODO: Change the autogenerated stub
    }
}