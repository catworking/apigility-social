<?php
namespace ApigilitySocial\V1\Rest\Person;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;
use Zend\Stdlib\ArrayObject as ZendArrayObject;

class PersonCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = PersonEntity::class;
    
    public function getCurrentItems()
    {
        $set = parent::getCurrentItems();
        $collection = new ZendArrayObject();

        $onlineArr = [];
        $disonlineArr = [];
        foreach ($set as $item) {
            if ($item->getOnline()) {
                $onlineArr[] = $item;
            } else {
                $disonlineArr[] = $item;
            }
        }
        shuffle($onlineArr);
        shuffle($disonlineArr);
        foreach ($disonlineArr as $disonlineItem) {
            array_push($onlineArr, $disonlineItem);
        }
        foreach ($onlineArr as $item) {
            $collection->append(($item));
        }
        return $collection;
    }

    protected function createItem($item)
    {
        return new PersonEntity($item, $this->serviceManager);
    }
}
