<?php
namespace ApigilitySocial\V1\Rest\Friend;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class FriendResource extends ApigilityResource
{
    /**
     * @var \ApigilitySocial\Service\FriendService
     */
    protected $friendService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->friendService = $services->get('ApigilitySocial\Service\FriendService');
    }
    
    public function fetch($id)
    {
        try {
            return new FriendEntity($this->friendService->getFriend($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new FriendCollection($this->friendService->getFriends($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return new FriendEntity($this->friendService->createFriend($data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new FriendEntity($this->friendService->updateFriend($id, $data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->friendService->deleteFriend($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
