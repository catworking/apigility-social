<?php
namespace ApigilitySocial\V1\Rest\Requirement;

use ApigilityCatworkFoundation\Base\ApigilityResource;
use Zend\ServiceManager\ServiceManager;
use ZF\ApiProblem\ApiProblem;

class RequirementResource extends ApigilityResource
{
    /**
     * @var \ApigilitySocial\Service\RequirementService
     */
    protected $requirementService;

    public function __construct(ServiceManager $services)
    {
        parent::__construct($services);
        $this->requirementService = $services->get('ApigilitySocial\Service\RequirementService');
    }

    public function fetch($id)
    {
        try {
            return new RequirementEntity($this->requirementService->getRequirement($id), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function fetchAll($params = [])
    {
        try {
            return new RequirementCollection($this->requirementService->getRequirements($params), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function create($data)
    {
        try {
            return new RequirementEntity($this->requirementService->createRequirement($data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function patch($id, $data)
    {
        try {
            return new RequirementEntity($this->requirementService->updateRequirement($id, $data), $this->serviceManager);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            return $this->requirementService->deleteRequirement($id);
        } catch (\Exception $exception) {
            return new ApiProblem($exception->getCode(), $exception->getMessage());
        }
    }
}
