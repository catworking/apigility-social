<?php
namespace ApigilitySocial\V1\Rest\Person;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use ApigilitySocial\Service\PersonService;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class PersonResource extends ApigilityResource
{
    /**
     * @var PersonService
     */
    protected $personService;
    
    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->personService = $services->get('ApigilitySocial\Service\PersonService');
    }
    
    public function fetch($id)
    {
        try {
            return new PersonEntity($this->personService->getPerson($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new PersonCollection($this->personService->getPersons($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return new PersonEntity($this->personService->createPerson($data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new PersonEntity($this->personService->updatePerson($id, $data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->personService->deletePerson($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
